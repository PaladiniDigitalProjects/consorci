( function () {
	'use strict';

	const cfg    = window.pdsQL || {};
	const rest   = ( cfg.restUrl || '/wp-json/' ).replace( /\/$/, '' );
	const nonce  = cfg.nonce  || '';
	const i18n   = cfg.i18n   || {};

	// -----------------------------------------------------------------------
	// Lightbox DOM
	// -----------------------------------------------------------------------
	let overlay, lightbox, lbClose, lbBody;

	function buildLightbox() {
		overlay = document.createElement( 'div' );
		overlay.className = 'pds-ql-overlay';
		overlay.setAttribute( 'role', 'presentation' );

		lightbox = document.createElement( 'div' );
		lightbox.className = 'pds-ql-lightbox shadow20';
		lightbox.setAttribute( 'role', 'dialog' );
		lightbox.setAttribute( 'aria-modal', 'true' );

		lbClose = document.createElement( 'button' );
		lbClose.className = 'pds-ql-close';
		lbClose.type = 'button';
		lbClose.setAttribute( 'aria-label', i18n.close || 'Cerrar' );
		lbClose.innerHTML =
			'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';

		lbBody = document.createElement( 'div' );
		lbBody.className = 'pds-ql-body';

		lightbox.appendChild( lbClose );
		lightbox.appendChild( lbBody );
		overlay.appendChild( lightbox );
		document.body.appendChild( overlay );

		// Close handlers
		lbClose.addEventListener( 'click', closeLightbox );
		overlay.addEventListener( 'click', ( e ) => {
			if ( e.target === overlay ) closeLightbox();
		} );
		document.addEventListener( 'keydown', ( e ) => {
			if ( e.key === 'Escape' ) closeLightbox();
		} );
	}

	function openLightbox() {
		if ( ! overlay ) buildLightbox();
		overlay.classList.add( 'is-active' );
		document.body.style.overflow = 'hidden';
		lbClose.focus();
	}

	function closeLightbox() {
		if ( ! overlay ) return;
		overlay.classList.remove( 'is-active' );
		document.body.style.overflow = '';
		lbBody.innerHTML = '';
	}

	// -----------------------------------------------------------------------
	// Data fetch
	// -----------------------------------------------------------------------

	function setBody( html ) {
		lbBody.innerHTML = html;
	}

	async function loadPost( restBase, slug ) {
		openLightbox();
		setBody( `
			<div class="pds-ql-skeleton">
				<div class="pds-ql-sk-thumb"></div>
				<div class="pds-ql-sk-body">
					<div class="pds-ql-sk-title"></div>
					<div class="pds-ql-sk-line"></div>
					<div class="pds-ql-sk-line pds-ql-sk-line--short"></div>
					<div class="pds-ql-sk-line"></div>
					<div class="pds-ql-sk-line pds-ql-sk-line--mid"></div>
					<div class="pds-ql-sk-line"></div>
				</div>
			</div>
		` );

		try {
			const url =
				`${ rest }/wp/v2/${ restBase }` +
				`?slug=${ encodeURIComponent( slug ) }&_embed`;

			const res = await fetch( url, {
				headers: { 'X-WP-Nonce': nonce },
			} );

			if ( ! res.ok ) throw new Error( 'HTTP ' + res.status );

			const posts = await res.json();
			const post  = posts[ 0 ];

			if ( ! post ) {
				setBody( `<p class="pds-ql-msg">${ i18n.notFound || 'No se encontró el contenido.' }</p>` );
				return;
			}

			renderPost( post );

		} catch ( err ) {
			console.error( 'PDS QL:', err );
			setBody( `<p class="pds-ql-msg pds-ql-error">${ i18n.error || 'Error al cargar el contenido.' }</p>` );
		}
	}

	function renderPost( post ) {
		const title   = post.title?.rendered   || '';
		const content = post.content?.rendered || '';
		const link    = post.link              || '#';
		const media   = post._embedded?.[ 'wp:featuredmedia' ]?.[ 0 ];
		const thumb   = media?.source_url      || '';

		const thumbHtml = thumb
			? `<div class="pds-ql-thumb"><img src="${ thumb }" alt="${ title.replace( /"/g, '&quot;' ) }"></div>`
			: '';

		setBody( `
			${ thumbHtml }
			<div class="pds-ql-content">
				<h2 class="pds-ql-title">${ title }</h2>
				<div class="pds-ql-text">${ content }</div>
			</div>
		` );
	}

	// -----------------------------------------------------------------------
	// Click delegation
	// -----------------------------------------------------------------------

	function slugFromUrl( href ) {
		try {
			const url   = new URL( href );
			const parts = url.pathname.replace( /\/$/, '' ).split( '/' ).filter( Boolean );
			return parts[ parts.length - 1 ] || '';
		} catch {
			return '';
		}
	}

	document.addEventListener( 'click', ( e ) => {
		const queryEl = e.target.closest( '[data-pds-lightbox]' );
		if ( ! queryEl ) return;

		// Direct click on a link, or click anywhere on the post card (li)
		let link = e.target.closest( 'a' );
		if ( ! link ) {
			const item = e.target.closest( 'li' );
			link = item?.querySelector( 'a[href]' ) ?? null;
		}
		if ( ! link?.href ) return;

		// Only intercept internal links
		if ( link.hostname !== window.location.hostname ) return;

		e.preventDefault();

		const restBase = queryEl.dataset.pdsRestBase || 'posts';
		const slug     = slugFromUrl( link.href );
		if ( ! slug ) return;

		loadPost( restBase, slug );
	} );
} )();
