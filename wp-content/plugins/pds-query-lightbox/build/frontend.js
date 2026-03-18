(function () {
	'use strict';

	var cfg   = window.pdsQL || {};
	var rest  = (cfg.restUrl || '/wp-json/').replace(/\/$/, '');
	var nonce = cfg.nonce || '';
	var i18n  = cfg.i18n  || {};

	// -----------------------------------------------------------------------
	// Lightbox DOM
	// -----------------------------------------------------------------------
	var overlay, lightbox, lbClose, lbBody;

	function buildLightbox() {
		overlay = document.createElement('div');
		overlay.className = 'pds-ql-overlay';
		overlay.setAttribute('role', 'presentation');

		lightbox = document.createElement('div');
		lightbox.className = 'pds-ql-lightbox shadow20';
		lightbox.setAttribute('role', 'dialog');
		lightbox.setAttribute('aria-modal', 'true');

		lbClose = document.createElement('button');
		lbClose.className = 'pds-ql-close';
		lbClose.type = 'button';
		lbClose.setAttribute('aria-label', i18n.close || 'Cerrar');
		lbClose.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';

		lbBody = document.createElement('div');
		lbBody.className = 'pds-ql-body';

		lightbox.appendChild(lbClose);
		lightbox.appendChild(lbBody);
		overlay.appendChild(lightbox);
		document.body.appendChild(overlay);

		lbClose.addEventListener('click', closeLightbox);
		overlay.addEventListener('click', function (e) {
			if (e.target === overlay) closeLightbox();
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') closeLightbox();
		});
	}

	function openLightbox() {
		if (!overlay) buildLightbox();
		overlay.classList.add('is-active');
		document.body.style.overflow = 'hidden';
		lbClose.focus();
	}

	function closeLightbox() {
		if (!overlay) return;
		overlay.classList.remove('is-active');
		document.body.style.overflow = '';
		lbBody.innerHTML = '';
	}

	function setBody(html) {
		lbBody.innerHTML = html;
	}

	// -----------------------------------------------------------------------
	// Fetch post via WP REST API
	// -----------------------------------------------------------------------
	function loadPost(restBase, slug) {
		openLightbox();
		setBody(
			'<div class="pds-ql-skeleton">' +
				'<div class="pds-ql-sk-thumb"></div>' +
				'<div class="pds-ql-sk-body">' +
					'<div class="pds-ql-sk-title"></div>' +
					'<div class="pds-ql-sk-line"></div>' +
					'<div class="pds-ql-sk-line pds-ql-sk-line--short"></div>' +
					'<div class="pds-ql-sk-line"></div>' +
					'<div class="pds-ql-sk-line pds-ql-sk-line--mid"></div>' +
					'<div class="pds-ql-sk-line"></div>' +
				'</div>' +
			'</div>'
		);

		var url = rest + '/wp/v2/' + restBase + '?slug=' + encodeURIComponent(slug) + '&_embed';

		fetch(url, { headers: { 'X-WP-Nonce': nonce } })
			.then(function (res) {
				if (!res.ok) throw new Error('HTTP ' + res.status);
				return res.json();
			})
			.then(function (posts) {
				var post = posts[0];
				if (!post) {
					setBody('<p class="pds-ql-msg">' + (i18n.notFound || 'No se encontr\u00f3 el contenido.') + '</p>');
					return;
				}
				renderPost(post);
			})
			.catch(function (err) {
				console.error('PDS QL:', err);
				setBody('<p class="pds-ql-msg pds-ql-error">' + (i18n.error || 'Error al cargar el contenido.') + '</p>');
			});
	}

	function renderPost(post) {
		var title   = (post.title   && post.title.rendered)   || '';
		var content = (post.content && post.content.rendered) || '';
		var link    = post.link || '#';

		var media = post._embedded
			&& post._embedded['wp:featuredmedia']
			&& post._embedded['wp:featuredmedia'][0];
		var thumb = media ? (media.source_url || '') : '';

		var thumbHtml = thumb
			? '<div class="pds-ql-thumb"><img src="' + thumb + '" alt="' + title.replace(/"/g, '&quot;') + '"></div>'
			: '';

		setBody(
			thumbHtml +
			'<div class="pds-ql-content">' +
				'<h2 class="pds-ql-title">' + title + '</h2>' +
				'<div class="pds-ql-text">' + content + '</div>' +
			'</div>'
		);
	}

	// -----------------------------------------------------------------------
	// Click delegation
	// -----------------------------------------------------------------------
	function slugFromUrl(href) {
		try {
			var url   = new URL(href);
			var parts = url.pathname.replace(/\/$/, '').split('/').filter(Boolean);
			return parts[parts.length - 1] || '';
		} catch (e) {
			return '';
		}
	}

	document.addEventListener('click', function (e) {
		var queryEl = e.target.closest('[data-pds-lightbox]');
		if (!queryEl) return;

		// Direct click on a link, or click anywhere on the post card (li)
		var link = e.target.closest('a');
		if (!link) {
			var item = e.target.closest('li');
			link = item && item.querySelector('a[href]');
		}
		if (!link || !link.href) return;

		// Only intercept internal links
		if (link.hostname !== window.location.hostname) return;

		e.preventDefault();

		var restBase = queryEl.dataset.pdsRestBase || 'posts';
		var slug     = slugFromUrl(link.href);
		if (!slug) return;

		loadPost(restBase, slug);
	});

})();
