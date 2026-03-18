(function (wp) {
	if (!wp) return;

	var addFilter              = wp.hooks.addFilter;
	var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
	var InspectorControls      = wp.blockEditor.InspectorControls;
	var PanelBody              = wp.components.PanelBody;
	var ToggleControl          = wp.components.ToggleControl;
	var el                     = wp.element.createElement;
	var Fragment               = wp.element.Fragment;

	// 1. Add pdsEnableLightbox attribute to core/query
	addFilter(
		'blocks.registerBlockType',
		'pds/ql-attribute',
		function (settings, name) {
			if (name !== 'core/query') return settings;
			return Object.assign({}, settings, {
				attributes: Object.assign({}, settings.attributes, {
					pdsEnableLightbox: {
						type: 'boolean',
						default: false,
					},
				}),
			});
		}
	);

	// 2. Inject inspector panel into core/query
	var withLightboxControl = createHigherOrderComponent(function (BlockEdit) {
		return function (props) {
			if (props.name !== 'core/query') {
				return el(BlockEdit, props);
			}

			var attributes    = props.attributes;
			var setAttributes = props.setAttributes;
			var enabled       = !!attributes.pdsEnableLightbox;

			return el(
				Fragment,
				null,
				el(BlockEdit, props),
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: 'Lightbox', initialOpen: false },
						el(ToggleControl, {
							label: 'Activar Lightbox',
							help: enabled
								? 'Las entradas se abrirán en un lightbox (sin salir de la página).'
								: 'Las entradas abrirán su página normal.',
							checked: enabled,
							onChange: function (val) {
								setAttributes({ pdsEnableLightbox: val });
							},
						})
					)
				)
			);
		};
	}, 'withLightboxControl');

	addFilter('editor.BlockEdit', 'pds/ql-control', withLightboxControl);

})(window.wp);
