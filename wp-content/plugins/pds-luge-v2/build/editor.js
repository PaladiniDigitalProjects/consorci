/**
 * PDS Luge v2 – Editor (pre-compiled, WP globals)
 * No requiere paso de build. Usa window.wp.*
 * Para modificar: editar src/editor.js y ejecutar npm run build.
 */
(function () {
	'use strict';

	var el              = window.wp.element.createElement;
	var registerBlockType  = window.wp.blocks.registerBlockType;
	var useBlockProps      = window.wp.blockEditor.useBlockProps;
	var InnerBlocks        = window.wp.blockEditor.InnerBlocks;
	var InspectorControls  = window.wp.blockEditor.InspectorControls;
	var RichText           = window.wp.blockEditor.RichText;
	var MediaUpload        = window.wp.blockEditor.MediaUpload;
	var MediaUploadCheck   = window.wp.blockEditor.MediaUploadCheck;
	var PanelBody          = window.wp.components.PanelBody;
	var RangeControl       = window.wp.components.RangeControl;
	var SelectControl      = window.wp.components.SelectControl;
	var ToggleControl      = window.wp.components.ToggleControl;
	var TextControl        = window.wp.components.TextControl;
	var Button             = window.wp.components.Button;
	var Placeholder        = window.wp.components.Placeholder;
	var Fragment           = window.wp.element.Fragment;

	/* ─── Opciones compartidas ──────────────────────────────────────── */
	var ANIMATION_OPTIONS = [
		{ label: 'Fade Up',         value: 'fadeUp' },
		{ label: 'Fade Down',       value: 'fadeDown' },
		{ label: 'Fade In',         value: 'fadeIn' },
		{ label: 'Slide izquierda', value: 'slideLeft' },
		{ label: 'Slide derecha',   value: 'slideRight' },
		{ label: 'Scale In',        value: 'scaleIn' },
		{ label: 'Zoom In',         value: 'zoomIn' },
		{ label: 'Sin animación',   value: 'none' },
	];

	var EASE_OPTIONS = [
		{ label: 'power1.out',           value: 'power1.out' },
		{ label: 'power2.out (defecto)', value: 'power2.out' },
		{ label: 'power3.out',           value: 'power3.out' },
		{ label: 'power4.out',           value: 'power4.out' },
		{ label: 'back.out',             value: 'back.out(1.7)' },
		{ label: 'elastic.out',          value: 'elastic.out(1, 0.3)' },
		{ label: 'bounce.out',           value: 'bounce.out' },
		{ label: 'sine.out',             value: 'sine.out' },
		{ label: 'expo.out',             value: 'expo.out' },
		{ label: 'circ.out',             value: 'circ.out' },
	];

	/* ─── Panel reutilizable ────────────────────────────────────────── */
	function AnimationPanel(animationType, gsapEase, setAttributes) {
		var easeControl = animationType !== 'none'
			? el(SelectControl, {
				label: 'Easing GSAP',
				value: gsapEase,
				options: EASE_OPTIONS,
				onChange: function (v) { setAttributes({ gsapEase: v }); },
			  })
			: null;

		return el(PanelBody, { title: 'Animación de entrada', initialOpen: false },
			el(SelectControl, {
				label: 'Tipo de animación',
				value: animationType,
				options: ANIMATION_OPTIONS,
				onChange: function (v) { setAttributes({ animationType: v }); },
			}),
			easeControl
		);
	}

	/* ═══════════════════════════════════════════════════════════════
	   1. PARALLAX BLOCK  –  pds-luge/parallax
	═══════════════════════════════════════════════════════════════ */
	registerBlockType('pds-luge/parallax', {
		title:       'Parallax',
		description: 'Wrapper con efecto parallax GSAP al hacer scroll.',
		category:    'design',
		icon:        'move',
		attributes: {
			speed:         { type: 'number', default: 0.5 },
			direction:     { type: 'string', default: 'vertical' },
			animationType: { type: 'string', default: 'fadeUp' },
			gsapEase:      { type: 'string', default: 'power2.out' },
		},

		edit: function (props) {
			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var speed         = attributes.speed;
			var direction     = attributes.direction;
			var animationType = attributes.animationType;
			var gsapEase      = attributes.gsapEase;
			var blockProps    = useBlockProps({ className: 'pds-parallax-editor' });

			return el(Fragment, null,
				el(InspectorControls, null,
					el(PanelBody, { title: 'Parallax', initialOpen: true },
						el(RangeControl, {
							label: 'Velocidad',
							help:  'Negativo = dirección inversa al scroll. 0 = sin efecto.',
							value: speed,
							onChange: function (v) { setAttributes({ speed: v }); },
							min: -2, max: 2, step: 0.1,
						}),
						el(SelectControl, {
							label: 'Dirección',
							value: direction,
							options: [
								{ label: 'Vertical (Y)',   value: 'vertical' },
								{ label: 'Horizontal (X)', value: 'horizontal' },
							],
							onChange: function (v) { setAttributes({ direction: v }); },
						})
					),
					AnimationPanel(animationType, gsapEase, setAttributes)
				),
				el('div', blockProps,
					el('div', { className: 'pds-parallax-editor-label' },
						'Parallax — velocidad: ' + speed + ' | ' + direction + ' | entrada: ' + animationType
					),
					el(InnerBlocks)
				)
			);
		},

		save: function (props) {
			var a = props.attributes;
			var blockProps = useBlockProps.save({
				className:             'pds-parallax',
				'data-speed':          String(a.speed),
				'data-direction':      a.direction,
				'data-animation-type': a.animationType,
				'data-gsap-ease':      a.gsapEase,
			});
			return el('div', blockProps,
				el('div', { className: 'pds-parallax-inner' },
					el(InnerBlocks.Content)
				)
			);
		},
	});

	/* ═══════════════════════════════════════════════════════════════
	   2. TEXT REVEAL BLOCK  –  pds-luge/text-reveal
	   InnerBlocks wrapper: edición Gutenberg nativa completa.
	═══════════════════════════════════════════════════════════════ */
	registerBlockType('pds-luge/text-reveal', {
		title:       'Text Reveal',
		description: 'Wrapper que anima el texto interior por palabras, bloques o caracteres. Edición Gutenberg nativa.',
		category:    'text',
		icon:        'editor-textcolor',
		attributes: {
			revealType:    { type: 'string', default: 'words' },
			duration:      { type: 'number', default: 800 },
			stagger:       { type: 'number', default: 50 },
			delay:         { type: 'number', default: 0 },
			animationType: { type: 'string', default: 'fadeUp' },
			gsapEase:      { type: 'string', default: 'power2.out' },
		},

		edit: function (props) {
			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var revealType    = attributes.revealType;
			var duration      = attributes.duration;
			var stagger       = attributes.stagger;
			var delay         = attributes.delay;
			var animationType = attributes.animationType;
			var gsapEase      = attributes.gsapEase;
			var blockProps    = useBlockProps({ className: 'pds-text-reveal-editor' });

			return el(Fragment, null,
				el(InspectorControls, null,
					el(PanelBody, { title: 'Text Reveal', initialOpen: true },
						el(SelectControl, {
							label: 'Tipo de reveal',
							help:  'words/chars: divide el texto preservando negritas y enlaces. lines: anima cada bloque hijo como unidad.',
							value: revealType,
							options: [
								{ label: 'Por palabras',   value: 'words' },
								{ label: 'Por bloques',    value: 'lines' },
								{ label: 'Por caracteres', value: 'chars' },
							],
							onChange: function (v) { setAttributes({ revealType: v }); },
						})
					),
					el(PanelBody, { title: 'Timing', initialOpen: false },
						el(RangeControl, {
							label: 'Duración (ms)', value: duration,
							onChange: function (v) { setAttributes({ duration: v }); },
							min: 100, max: 3000, step: 50,
						}),
						el(RangeControl, {
							label: 'Stagger entre unidades (ms)', value: stagger,
							onChange: function (v) { setAttributes({ stagger: v }); },
							min: 0, max: 300, step: 10,
						}),
						el(RangeControl, {
							label: 'Delay inicial (ms)', value: delay,
							onChange: function (v) { setAttributes({ delay: v }); },
							min: 0, max: 2000, step: 50,
						})
					),
					AnimationPanel(animationType, gsapEase, setAttributes)
				),
				el('div', blockProps,
					el('div', { className: 'pds-text-reveal-editor-label' },
						'Text Reveal — ' + revealType + ' | ' + animationType
					),
					el(InnerBlocks, {
						allowedBlocks: [
							'core/paragraph', 'core/heading',
							'core/list', 'core/quote', 'core/verse',
						],
						template: [ [ 'core/paragraph', { placeholder: 'Escribe el texto a animar…' } ] ],
						templateLock: false,
					})
				)
			);
		},

		save: function (props) {
			var a = props.attributes;
			var blockProps = useBlockProps.save({
				className:             'pds-text-reveal',
				'data-reveal-type':    a.revealType,
				'data-duration':       String(a.duration),
				'data-stagger':        String(a.stagger),
				'data-delay':          String(a.delay),
				'data-animation-type': a.animationType,
				'data-gsap-ease':      a.gsapEase,
			});
			return el('div', blockProps, el(InnerBlocks.Content));
		},
	});

	/* ═══════════════════════════════════════════════════════════════
	   3. VIDEO SCRUB BLOCK  –  pds-luge/video-scrub
	═══════════════════════════════════════════════════════════════ */
	registerBlockType('pds-luge/video-scrub', {
		title:       'Video Scrub',
		description: 'Video controlado por el scroll con GSAP ScrollTrigger.',
		category:    'media',
		icon:        'video-alt3',
		attributes: {
			videoUrl:      { type: 'string', default: '' },
			pin:           { type: 'boolean', default: false },
			scrubSpeed:    { type: 'number', default: 1 },
			startTrigger:  { type: 'string', default: 'top center' },
			endTrigger:    { type: 'string', default: 'bottom top' },
			animationType: { type: 'string', default: 'fadeIn' },
			gsapEase:      { type: 'string', default: 'power2.out' },
		},

		edit: function (props) {
			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var videoUrl      = attributes.videoUrl;
			var pin           = attributes.pin;
			var scrubSpeed    = attributes.scrubSpeed;
			var startTrigger  = attributes.startTrigger;
			var endTrigger    = attributes.endTrigger;
			var animationType = attributes.animationType;
			var gsapEase      = attributes.gsapEase;
			var blockProps    = useBlockProps({ className: 'pds-video-scrub-editor' });

			var videoOrPlaceholder = videoUrl
				? el('video', { src: videoUrl, className: 'pds-video-scrub-preview', muted: true, playsInline: true })
				: el(Placeholder, {
					icon:         'video-alt3',
					label:        'Video Scrub',
					instructions: 'Introduce una URL de vídeo en el panel lateral.',
				  });

			return el(Fragment, null,
				el(InspectorControls, null,
					el(PanelBody, { title: 'Vídeo', initialOpen: true },
						el(TextControl, {
							label:       'URL del vídeo',
							help:        'MP4 recomendado.',
							value:       videoUrl,
							onChange:    function (v) { setAttributes({ videoUrl: v }); },
							placeholder: 'https://…/video.mp4',
						}),
						el(MediaUploadCheck, null,
							el(MediaUpload, {
								onSelect:     function (media) { setAttributes({ videoUrl: media.url }); },
								allowedTypes: ['video'],
								render:       function (renderProps) {
									return el(Button, { variant: 'secondary', onClick: renderProps.open },
										'Seleccionar de la biblioteca'
									);
								},
							})
						)
					),
					el(PanelBody, { title: 'Scroll Trigger', initialOpen: false },
						el(ToggleControl, {
							label:   'Fijar en pantalla (pin)',
							help:    'El wrapper queda fijo mientras dura el scrub.',
							checked: pin,
							onChange: function (v) { setAttributes({ pin: v }); },
						}),
						el(RangeControl, {
							label: 'Velocidad de scrub', value: scrubSpeed,
							onChange: function (v) { setAttributes({ scrubSpeed: v }); },
							min: 0.1, max: 5, step: 0.1,
						}),
						el(TextControl, {
							label: 'Inicio del trigger', value: startTrigger,
							onChange: function (v) { setAttributes({ startTrigger: v }); },
						}),
						el(TextControl, {
							label: 'Fin del trigger', value: endTrigger,
							onChange: function (v) { setAttributes({ endTrigger: v }); },
						})
					),
					AnimationPanel(animationType, gsapEase, setAttributes)
				),
				el('div', blockProps,
					videoOrPlaceholder,
					el('div', { className: 'pds-video-scrub-editor-meta' },
						'Pin: ' + (pin ? 'Sí' : 'No') + ' | Scrub: ' + scrubSpeed + 'x | Entrada: ' + animationType
					)
				)
			);
		},

		save: function (props) {
			var a = props.attributes;
			var blockProps = useBlockProps.save({
				className:             'pds-video-scrub-wrapper',
				'data-pin':            a.pin ? 'true' : 'false',
				'data-scrub-speed':    String(a.scrubSpeed),
				'data-start':          a.startTrigger,
				'data-end':            a.endTrigger,
				'data-animation-type': a.animationType,
				'data-gsap-ease':      a.gsapEase,
			});
			return el('div', blockProps,
				el('video', {
					className:   'pds-video-scrub',
					src:         a.videoUrl,
					muted:       true,
					playsInline: true,
					preload:     'auto',
				})
			);
		},
	});

	/* ═══════════════════════════════════════════════════════════════
	   4. COUNTER BLOCK  –  pds-luge/counter
	═══════════════════════════════════════════════════════════════ */
	registerBlockType('pds-luge/counter', {
		title:       'Counter',
		description: 'Contador animado que se activa al entrar en el viewport.',
		category:    'design',
		icon:        'chart-bar',
		attributes: {
			target:        { type: 'number', default: 1000 },
			prefix:        { type: 'string', default: '' },
			suffix:        { type: 'string', default: '' },
			decimals:      { type: 'number', default: 0 },
			duration:      { type: 'number', default: 2000 },
			separator:     { type: 'boolean', default: false },
			animationType: { type: 'string', default: 'fadeUp' },
			gsapEase:      { type: 'string', default: 'power2.out' },
		},

		edit: function (props) {
			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var target        = attributes.target;
			var prefix        = attributes.prefix;
			var suffix        = attributes.suffix;
			var decimals      = attributes.decimals;
			var duration      = attributes.duration;
			var separator     = attributes.separator;
			var animationType = attributes.animationType;
			var gsapEase      = attributes.gsapEase;
			var blockProps    = useBlockProps({ className: 'pds-counter-editor' });

			var previewValue = separator
				? target.toLocaleString('es-ES', { minimumFractionDigits: decimals, maximumFractionDigits: decimals })
				: target.toFixed(decimals);

			return el(Fragment, null,
				el(InspectorControls, null,
					el(PanelBody, { title: 'Counter', initialOpen: true },
						el(TextControl, {
							label:    'Número objetivo',
							type:     'number',
							value:    target,
							onChange: function (v) { setAttributes({ target: parseFloat(v) || 0 }); },
						}),
						el(TextControl, {
							label: 'Prefijo', help: "Ej: '$', '€'",
							value: prefix,
							onChange: function (v) { setAttributes({ prefix: v }); },
						}),
						el(TextControl, {
							label: 'Sufijo', help: "Ej: '%', 'k', ' años'",
							value: suffix,
							onChange: function (v) { setAttributes({ suffix: v }); },
						}),
						el(RangeControl, {
							label: 'Decimales', value: decimals,
							onChange: function (v) { setAttributes({ decimals: v }); },
							min: 0, max: 4,
						}),
						el(RangeControl, {
							label: 'Duración (ms)', value: duration,
							onChange: function (v) { setAttributes({ duration: v }); },
							min: 200, max: 5000, step: 100,
						}),
						el(ToggleControl, {
							label:   'Separador de miles',
							checked: separator,
							onChange: function (v) { setAttributes({ separator: v }); },
						})
					),
					AnimationPanel(animationType, gsapEase, setAttributes)
				),
				el('div', blockProps,
					el('span', { className: 'pds-counter-preview' }, prefix + previewValue + suffix),
					el('span', { className: 'pds-counter-editor-hint' }, 'Vista previa (se animará en el frontend)')
				)
			);
		},

		save: function (props) {
			var a = props.attributes;
			var blockProps = useBlockProps.save({
				className:             'pds-counter-wrapper',
				'data-animation-type': a.animationType,
				'data-gsap-ease':      a.gsapEase,
			});

			var children = [];
			if (a.prefix) {
				children.push(el('span', { key: 'prefix', className: 'pds-counter-prefix' }, a.prefix));
			}
			children.push(el('span', {
				key:              'counter',
				className:        'pds-counter',
				'data-target':    String(a.target),
				'data-decimals':  String(a.decimals),
				'data-duration':  String(a.duration),
				'data-separator': a.separator ? 'true' : 'false',
			}, '0'));
			if (a.suffix) {
				children.push(el('span', { key: 'suffix', className: 'pds-counter-suffix' }, a.suffix));
			}

			return el.apply(null, ['div', blockProps].concat(children));
		},
	});

})();
