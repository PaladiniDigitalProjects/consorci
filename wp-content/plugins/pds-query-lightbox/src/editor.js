import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

// 1. Register custom attribute on core/query
addFilter(
	'blocks.registerBlockType',
	'pds/ql-attribute',
	( settings, name ) => {
		if ( name !== 'core/query' ) return settings;
		return {
			...settings,
			attributes: {
				...settings.attributes,
				pdsEnableLightbox: {
					type: 'boolean',
					default: false,
				},
			},
		};
	}
);

// 2. Add inspector control to core/query
const withLightboxControl = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( props.name !== 'core/query' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;

		return (
			<Fragment>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody title="Lightbox" initialOpen={ false }>
						<ToggleControl
							label="Activar Lightbox"
							help={
								attributes.pdsEnableLightbox
									? 'Las entradas se abrirán en un lightbox.'
									: 'Las entradas abrirán su página normal.'
							}
							checked={ !! attributes.pdsEnableLightbox }
							onChange={ ( val ) =>
								setAttributes( { pdsEnableLightbox: val } )
							}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'withLightboxControl' );

addFilter( 'editor.BlockEdit', 'pds/ql-control', withLightboxControl );
