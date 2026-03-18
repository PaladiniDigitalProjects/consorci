/**
 * PDS Gallery Extended – Frontend
 *
 * 1. Focal   → 2 files d'imatges animades a l'horitzó (fila 1 ←, fila 2 →)
 * 2. Lightbox → overlay personalitzat amb prev/next a .pds-gallery--lightbox
 * 3. Auto-scroll → scroll horitzontal automàtic amb loop a .pds-gallery--autoscroll
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		initFocal();
		initLightbox();
		initAutoScroll();
	} );

	/* ──────────────────────────────────────────────────────────────────
	   Helper: anima un runner amb loop infinit.
	   runner      — element que rep el translateX
	   inner       — primer fill del runner (scrollWidth = amplada d'una còpia)
	   durationMs  — ms que tarda a completar un loop complet
	   direction   — 1 (esquerra) | -1 (dreta)
	────────────────────────────────────────────────────────────────── */
	function startScroll( runner, inner, durationMs, direction ) {
		var offset   = 0;
		var lastTime = null;

		function tick( timestamp ) {
			if ( ! lastTime ) lastTime = timestamp;
			var dt   = ( timestamp - lastTime ) / 1000;
			lastTime = timestamp;

			var innerW = inner.scrollWidth; /* inclou padding-right = gap → seamless */
			if ( innerW > 0 ) {
				/* px/s calculats dinàmicament a partir de la durada i l'amplada del contingut */
				var pxPerSec = innerW / ( durationMs / 1000 );
				offset += pxPerSec * dt;
				if ( offset >= innerW ) {
					offset -= innerW;
				}
				runner.style.transform = 'translateX(' + ( direction * -offset ) + 'px)';
			}

			requestAnimationFrame( tick );
		}

		requestAnimationFrame( tick );
	}

	/* ══════════════════════════════════════════════════════════════════
	   1. FOCAL — 2 files animades a l'horitzó
	   Divideix les imatges en 2 grups (primera meitat / segona meitat),
	   crea les files, clona el contingut i anima cada fila.
	   Fila 1 → esquerra · Fila 2 → dreta.
	══════════════════════════════════════════════════════════════════ */
	function initFocal() {
		var galleries = document.querySelectorAll( '.pds-gallery--focal' );
		galleries.forEach( function ( gallery ) {

			/* Max-height i alineació vertical */
			var maxH  = parseInt( gallery.getAttribute( 'data-focal-max-height' ), 10 ) || 400;
			var align = gallery.getAttribute( 'data-focal-align' ) || 'center';
			gallery.style.setProperty( '--pds-focal-max-height', maxH + 'px' );
			gallery.style.setProperty( '--pds-focal-align',      align );

			/* Durada i direcció */
			var duration  = parseInt( gallery.getAttribute( 'data-scroll-duration' ),  10 ) || 8000;
			var dirAttr   = gallery.getAttribute( 'data-scroll-direction' ) || 'ltr';
			var direction = dirAttr === 'rtl' ? -1 : 1;

			/* Recollir items */
			var items = Array.from( gallery.querySelectorAll( ':scope > figure.wp-block-image' ) );
			if ( ! items.length ) {
				items = Array.from( gallery.querySelectorAll( ':scope > ul > li.blocks-gallery-item' ) );
			}
			if ( ! items.length ) return;

			/* Construir estructura: gallery > row > runner > inner + clone */
			var rowEl  = document.createElement( 'div' );
			rowEl.className = 'pds-focal-row';

			var runner = document.createElement( 'div' );
			runner.className = 'pds-focal-runner';

			var inner  = document.createElement( 'div' );
			inner.className = 'pds-focal-inner';
			items.forEach( function ( item ) { inner.appendChild( item ); } );

			var clone  = inner.cloneNode( true );
			clone.setAttribute( 'aria-hidden', 'true' );

			runner.appendChild( inner );
			runner.appendChild( clone );
			rowEl.appendChild( runner );
			gallery.appendChild( rowEl );

			startScroll( runner, inner, duration, direction );
		} );
	}

	/* ══════════════════════════════════════════════════════════════════
	   2. LIGHTBOX
	   Overlay personalitzat: backdrop + imatge + prev/next + teclat.
	══════════════════════════════════════════════════════════════════ */
	function initLightbox() {
		var galleries = document.querySelectorAll( '.pds-gallery--lightbox' );
		if ( ! galleries.length ) return;

		var overlay   = buildOverlay();
		var lbImg     = overlay.querySelector( '.pds-lb-img' );
		var lbCaption = overlay.querySelector( '.pds-lb-caption' );
		var lbCounter = overlay.querySelector( '.pds-lb-counter' );
		var btnClose  = overlay.querySelector( '.pds-lb-close' );
		var btnPrev   = overlay.querySelector( '.pds-lb-prev' );
		var btnNext   = overlay.querySelector( '.pds-lb-next' );
		var backdrop  = overlay.querySelector( '.pds-lb-backdrop' );
		document.body.appendChild( overlay );

		var currentImages = [];
		var currentIndex  = 0;

		galleries.forEach( function ( gallery ) {
			/* Excloure imatges dins de clons (aria-hidden="true") */
			var imgs = Array.from( gallery.querySelectorAll( 'img' ) ).filter( function ( img ) {
				return ! img.closest( '[aria-hidden="true"]' );
			} );

			imgs.forEach( function ( img, idx ) {
				img.style.cursor = 'zoom-in';
				img.addEventListener( 'click', function ( e ) {
					e.preventDefault();
					e.stopPropagation(); /* evita conflicte amb el lightbox natiu de WP */
					currentImages = imgs;
					currentIndex  = idx;
					openLightbox();
				} );
			} );
		} );

		btnPrev.addEventListener( 'click', function () {
			currentIndex = ( currentIndex - 1 + currentImages.length ) % currentImages.length;
			updateImage();
		} );
		btnNext.addEventListener( 'click', function () {
			currentIndex = ( currentIndex + 1 ) % currentImages.length;
			updateImage();
		} );
		btnClose.addEventListener( 'click', closeLightbox );
		backdrop.addEventListener( 'click', closeLightbox );

		document.addEventListener( 'keydown', function ( e ) {
			if ( ! overlay.classList.contains( 'is-open' ) ) return;
			if ( e.key === 'ArrowLeft'  ) { currentIndex = ( currentIndex - 1 + currentImages.length ) % currentImages.length; updateImage(); }
			if ( e.key === 'ArrowRight' ) { currentIndex = ( currentIndex + 1 ) % currentImages.length; updateImage(); }
			if ( e.key === 'Escape'     ) { closeLightbox(); }
		} );

		function openLightbox() {
			overlay.classList.add( 'is-open' );
			document.body.style.overflow = 'hidden';
			updateImage();
		}
		function closeLightbox() {
			overlay.classList.remove( 'is-open' );
			document.body.style.overflow = '';
		}
		function updateImage() {
			var img    = currentImages[ currentIndex ];
			var src    = getBestSrc( img );
			var figure = img.closest( 'figure' );
			var cap    = figure ? figure.querySelector( 'figcaption' ) : null;

			/* Mostrar imatge — gestió correcta de caché (onload pot no disparar) */
			lbImg.style.opacity = '0';
			lbImg.onload = function () { lbImg.style.opacity = '1'; };
			lbImg.src    = src;
			lbImg.alt    = img.alt || '';
			/* Fallback: si la imatge ja és en caché, onload no dispara */
			if ( lbImg.complete && lbImg.naturalWidth ) {
				lbImg.style.opacity = '1';
			}

			lbCaption.textContent = cap ? cap.textContent : '';
			lbCounter.textContent = ( currentIndex + 1 ) + ' / ' + currentImages.length;

			var single = currentImages.length <= 1;
			btnPrev.style.display = single ? 'none' : '';
			btnNext.style.display = single ? 'none' : '';
		}
	}

	function buildOverlay() {
		var el       = document.createElement( 'div' );
		el.className = 'pds-lightbox';
		el.setAttribute( 'role', 'dialog' );
		el.setAttribute( 'aria-modal', 'true' );
		el.innerHTML =
			'<div class="pds-lb-backdrop"></div>' +
			'<div class="pds-lb-stage">' +
			'  <button class="pds-lb-close" aria-label="Tancar">&times;</button>' +
			'  <button class="pds-lb-prev"  aria-label="Anterior">&#8592;</button>' +
			'  <button class="pds-lb-next"  aria-label="Seg&uuml;ent">&#8594;</button>' +
			'  <div class="pds-lb-img-wrap"><img class="pds-lb-img" src="" alt="" /></div>' +
			'  <p class="pds-lb-caption"></p>' +
			'  <p class="pds-lb-counter"></p>' +
			'</div>';
		return el;
	}

	function getBestSrc( img ) {
		var srcset = img.getAttribute( 'srcset' ) || '';
		if ( ! srcset ) return img.src;
		var best = { w: 0, url: img.src };
		srcset.split( ',' ).forEach( function ( part ) {
			var tokens = part.trim().split( /\s+/ );
			if ( tokens.length < 2 ) return;
			var w = parseInt( tokens[ 1 ], 10 ) || 0;
			if ( w > best.w ) { best.w = w; best.url = tokens[ 0 ]; }
		} );
		return best.url;
	}

	/* ══════════════════════════════════════════════════════════════════
	   3. AUTO-SCROLL
	   Una sola fila, loop infinit, pausa al hover.
	   Estructura generada:
	     figure.pds-gallery--autoscroll (overflow: hidden)
	       └── div.pds-scroll-runner   (translateX animat)
	             ├── div.pds-scroll-inner (original, padding-right: 2rem)
	             └── div.pds-scroll-inner (clon, aria-hidden)
	══════════════════════════════════════════════════════════════════ */
	function initAutoScroll() {
		var galleries = document.querySelectorAll( '.pds-gallery--autoscroll' );
		galleries.forEach( function ( gallery ) {
			/* Evitar doble init si focal + autoscroll estan combinats */
			if ( gallery.classList.contains( 'pds-gallery--focal' ) ) return;

			var duration  = parseInt( gallery.getAttribute( 'data-scroll-duration' ),  10 ) || 8000;
			var loop      = gallery.getAttribute( 'data-scroll-loop' ) !== 'false';
			var dirAttr   = gallery.getAttribute( 'data-scroll-direction' ) || 'ltr';
			var direction = dirAttr === 'rtl' ? -1 : 1;

			/* Recollir items originals (galeria nova i antiga) */
			var items = Array.from(
				gallery.querySelectorAll( ':scope > figure.wp-block-image' )
			);
			if ( ! items.length ) {
				items = Array.from(
					gallery.querySelectorAll( ':scope > ul > li.blocks-gallery-item' )
				);
			}
			if ( ! items.length ) return;

			/* Construir estructura runner > inner */
			var runner = document.createElement( 'div' );
			runner.className = 'pds-scroll-runner';

			var inner = document.createElement( 'div' );
			inner.className = 'pds-scroll-inner';
			items.forEach( function ( item ) { inner.appendChild( item ); } );

			runner.appendChild( inner );

			if ( loop ) {
				var clone = inner.cloneNode( true );
				clone.setAttribute( 'aria-hidden', 'true' );
				runner.appendChild( clone );
			}

			gallery.appendChild( runner );

			startScroll( runner, inner, duration, direction );
		} );
	}

} )();
