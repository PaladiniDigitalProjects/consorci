/**
 * PDS Luge v2 – Frontend animations
 * Depende de: gsap, ScrollTrigger (cargados vía CDN por el PHP)
 *
 * Bloques gestionados:
 *  1. .pds-parallax             → Parallax GSAP ScrollTrigger + entrada animada
 *  2. .pds-text-reveal          → Split text + GSAP fromTo según animationType
 *  3. .pds-video-scrub-wrapper  → Video scrub GSAP ScrollTrigger + entrada animada
 *  4. .pds-counter-wrapper      → Counter animado rAF + entrada animada GSAP
 */
(function () {
	'use strict';

	/* ─── Presets de animación de entrada ───────────────────────────── */
	var PRESETS = {
		fadeUp:    { from: { opacity: 0, y: 40 },  to: { opacity: 1, y: 0 } },
		fadeDown:  { from: { opacity: 0, y: -40 }, to: { opacity: 1, y: 0 } },
		fadeIn:    { from: { opacity: 0 },          to: { opacity: 1 } },
		slideLeft: { from: { opacity: 0, x: -60 }, to: { opacity: 1, x: 0 } },
		slideRight:{ from: { opacity: 0, x: 60 },  to: { opacity: 1, x: 0 } },
		scaleIn:   { from: { opacity: 0, scale: 0.85 }, to: { opacity: 1, scale: 1 } },
		zoomIn:    { from: { opacity: 0, scale: 0.5 },  to: { opacity: 1, scale: 1 } },
		none:      null,
	};

	/* ─── Helper: aplicar animación de entrada genérica ────────────── */
	function applyEntrance(gsap, ST, el, type, ease, triggerConfig) {
		var preset = PRESETS[type] || PRESETS['fadeUp'];
		if (!preset) return; // type === 'none'

		var toProps = Object.assign({}, preset.to, {
			ease: ease || 'power2.out',
			scrollTrigger: Object.assign({
				trigger: el,
				start:   'top 85%',
				once:    true,
			}, triggerConfig || {}),
		});

		gsap.fromTo(el, preset.from, toProps);
	}

	/* ── Espera a que gsap y ScrollTrigger estén disponibles ────────── */
	function whenReady(cb) {
		if (typeof window.gsap !== 'undefined' && typeof window.ScrollTrigger !== 'undefined') {
			cb();
		} else {
			window.addEventListener('load', cb);
		}
	}

	document.addEventListener('DOMContentLoaded', function () {
		whenReady(initAll);
	});

	function initAll() {
		var gsap = window.gsap;
		var ST   = window.ScrollTrigger;
		gsap.registerPlugin(ST);

		initParallax(gsap, ST);
		initTextReveal(gsap, ST);
		initVideoScrub(gsap, ST);
		initCounters(gsap, ST);
	}

	/* ══════════════════════════════════════════════════════════════════
	   1. PARALLAX
	   Animación continua de scrub (parallax) + animación de entrada.
	══════════════════════════════════════════════════════════════════ */
	function initParallax(gsap, ST) {
		var wrappers = document.querySelectorAll('.pds-parallax');
		wrappers.forEach(function (wrapper) {
			var inner         = wrapper.querySelector('.pds-parallax-inner');
			var speed         = parseFloat(wrapper.getAttribute('data-speed'))     || 0.5;
			var direction     = wrapper.getAttribute('data-direction') || 'vertical';
			var animationType = wrapper.getAttribute('data-animation-type') || 'fadeUp';
			var gsapEase      = wrapper.getAttribute('data-gsap-ease')      || 'power2.out';

			if (!inner) return;

			/* Parallax scrub */
			var distance = 80 * speed;
			var fromProps = direction === 'horizontal' ? { x: -distance } : { y: -distance };
			var toProps   = direction === 'horizontal'
				? { x: distance, ease: 'none' }
				: { y: distance, ease: 'none' };

			gsap.fromTo(inner, fromProps, Object.assign(toProps, {
				scrollTrigger: {
					trigger: wrapper,
					start:   'top bottom',
					end:     'bottom top',
					scrub:   true,
				},
			}));

			/* Entrada animada del wrapper */
			applyEntrance(gsap, ST, wrapper, animationType, gsapEase);
		});
	}

	/* ══════════════════════════════════════════════════════════════════
	   2. TEXT REVEAL
	   El wrapper .pds-text-reveal contiene InnerBlocks de Gutenberg.
	   - lines:  anima cada bloque hijo directo como unidad (preserva todo)
	   - words:  recorre el árbol DOM dividiendo text nodes en spans de
	             palabras, sin tocar nodos Element (bold, em, a, etc.)
	   - chars:  igual que words pero por carácter
	══════════════════════════════════════════════════════════════════ */
	function initTextReveal(gsap, ST) {
		var wrappers = document.querySelectorAll('.pds-text-reveal');
		wrappers.forEach(function (wrapper) {
			var revealType    = wrapper.getAttribute('data-reveal-type')    || 'words';
			var duration      = (parseInt(wrapper.getAttribute('data-duration'), 10) || 800)  / 1000;
			var stagger       = (parseInt(wrapper.getAttribute('data-stagger'),  10) || 50)   / 1000;
			var delay         = (parseInt(wrapper.getAttribute('data-delay'),    10) || 0)    / 1000;
			var animationType = wrapper.getAttribute('data-animation-type') || 'fadeUp';
			var gsapEase      = wrapper.getAttribute('data-gsap-ease')      || 'power2.out';

			if (animationType === 'none') return;

			var preset = PRESETS[animationType] || PRESETS['fadeUp'];
			var units;

			if (revealType === 'lines') {
				/* Animar cada bloque hijo directo como unidad */
				units = Array.from(wrapper.children);
				if (!units.length) return;
				gsap.set(units, { opacity: 0 });
			} else {
				/* words o chars: recorrer DOM preservando HTML */
				units = splitDomTree(wrapper, revealType);
				if (!units.length) return;
			}

			var toProps = Object.assign({}, preset.to, {
				duration: duration,
				stagger:  stagger,
				delay:    delay,
				ease:     gsapEase,
				scrollTrigger: {
					trigger: wrapper,
					start:   'top 85%',
					once:    true,
				},
			});

			gsap.fromTo(units, preset.from, toProps);
		});
	}

	/**
	 * Recorre el árbol DOM del wrapper dividiendo solo los nodos de texto
	 * en <span> de palabras o caracteres, sin tocar elementos HTML existentes
	 * (strong, em, a, etc.). Devuelve el array de spans creados.
	 *
	 * @param {Element} wrapper  - El wrapper .pds-text-reveal
	 * @param {string}  type     - 'words' | 'chars'
	 * @returns {Element[]}
	 */
	function splitDomTree(wrapper, type) {
		var spans = [];

		function walkNode(node) {
			if (node.nodeType === 3) {
				/* Nodo de texto: dividir en spans */
				var text     = node.textContent;
				var fragment = document.createDocumentFragment();
				var parts;

				if (type === 'chars') {
					parts = text.split('');
				} else {
					/* words: separar por espacios conservando los espacios como separadores */
					parts = text.split(/(\s+)/);
				}

				parts.forEach(function (part) {
					if (!part) return;
					/* Espacios en blanco → nodo de texto normal */
					if (/^\s+$/.test(part)) {
						fragment.appendChild(document.createTextNode(part));
						return;
					}
					var span = document.createElement('span');
					span.className = 'pds-tr-unit';
					span.style.display = 'inline-block';
					span.style.opacity = '0';
					span.textContent = part;
					spans.push(span);
					fragment.appendChild(span);
				});

				node.parentNode.replaceChild(fragment, node);

			} else if (node.nodeType === 1) {
				/* Nodo elemento: recorrer hijos (clonar lista porque mutaremos el DOM) */
				Array.from(node.childNodes).forEach(walkNode);
			}
		}

		/* Recorrer solo los hijos directos del wrapper (bloques Gutenberg) */
		Array.from(wrapper.children).forEach(function (block) {
			Array.from(block.childNodes).forEach(walkNode);
		});

		return spans;
	}

	/* ══════════════════════════════════════════════════════════════════
	   3. VIDEO SCRUB
	   Scrub controlado por scroll + entrada animada del wrapper.
	══════════════════════════════════════════════════════════════════ */
	function initVideoScrub(gsap, ST) {
		var wrappers = document.querySelectorAll('.pds-video-scrub-wrapper');
		wrappers.forEach(function (wrapper) {
			var video         = wrapper.querySelector('.pds-video-scrub');
			var pin           = wrapper.getAttribute('data-pin')         === 'true';
			var scrubSpeed    = parseFloat(wrapper.getAttribute('data-scrub-speed'))  || 1;
			var start         = wrapper.getAttribute('data-start') || 'top center';
			var end           = wrapper.getAttribute('data-end')   || 'bottom top';
			var animationType = wrapper.getAttribute('data-animation-type') || 'fadeIn';
			var gsapEase      = wrapper.getAttribute('data-gsap-ease')      || 'power2.out';

			if (!video) return;

			/* Entrada animada del wrapper */
			applyEntrance(gsap, ST, wrapper, animationType, gsapEase);

			/* Video scrub */
			function setup() {
				var duration = video.duration;
				if (!duration || isNaN(duration)) return;

				ST.create({
					trigger:  wrapper,
					start:    start,
					end:      end,
					pin:      pin,
					scrub:    scrubSpeed,
					onUpdate: function (self) {
						video.currentTime = self.progress * duration;
					},
				});
			}

			if (video.readyState >= 1) {
				setup();
			} else {
				video.addEventListener('loadedmetadata', setup);
			}
		});
	}

	/* ══════════════════════════════════════════════════════════════════
	   4. COUNTER
	   Entrada animada GSAP + contador rAF con IntersectionObserver.
	══════════════════════════════════════════════════════════════════ */
	function initCounters(gsap, ST) {
		var wrappers = document.querySelectorAll('.pds-counter-wrapper');
		if (!wrappers.length) return;

		wrappers.forEach(function (wrapper) {
			var animationType = wrapper.getAttribute('data-animation-type') || 'fadeUp';
			var gsapEase      = wrapper.getAttribute('data-gsap-ease')      || 'power2.out';
			var counter       = wrapper.querySelector('.pds-counter');

			/* Entrada animada del wrapper */
			applyEntrance(gsap, ST, wrapper, animationType, gsapEase);

			/* Contador rAF disparado por IntersectionObserver */
			if (!counter) return;

			var observer = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) return;
					observer.unobserve(entry.target);
					animateCounter(entry.target);
				});
			}, { threshold: 0.2 });

			observer.observe(counter);
		});
	}

	function animateCounter(el) {
		var target   = parseFloat(el.getAttribute('data-target'))   || 0;
		var decimals = parseInt(el.getAttribute('data-decimals'),  10) || 0;
		var duration = parseInt(el.getAttribute('data-duration'),  10) || 2000;
		var useSep   = el.getAttribute('data-separator') === 'true';
		var start    = performance.now();

		function tick(now) {
			var elapsed  = now - start;
			var progress = Math.min(elapsed / duration, 1);
			var eased    = 1 - Math.pow(1 - progress, 3); // ease-out cubic
			var current  = eased * target;

			el.textContent = formatNumber(current, decimals, useSep);

			if (progress < 1) {
				requestAnimationFrame(tick);
			} else {
				el.textContent = formatNumber(target, decimals, useSep);
			}
		}

		requestAnimationFrame(tick);
	}

	function formatNumber(value, decimals, separator) {
		var fixed = value.toFixed(decimals);
		if (!separator) return fixed;
		var parts = fixed.split('.');
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
		return parts.join(',');
	}

})();
