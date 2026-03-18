/**
 * PDS Gallery Extended – Editor filters
 *
 * Extends core/gallery with:
 *  - galleryLayout  : 'default' | 'masonry' | 'filmstrip' | 'focal'
 *  - focalPoint     : { x: 0–1, y: 0–1 }
 *  - focalHeight    : px
 *  - enableLightbox : boolean
 *  - enableScroll   : boolean
 *  - scrollDuration : ms (durada d'un loop complet)
 *  - scrollLoop     : boolean
 */

import { addFilter }                  from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls }          from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	ToggleControl,
	RangeControl,
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';

import './editor.scss';

/* ── 1. Afegir atributs al bloc core/gallery ─────────────────────── */
addFilter(
	'blocks.registerBlockType',
	'pds-gallery/add-attributes',
	( settings, name ) => {
		if ( name !== 'core/gallery' ) return settings;
		return {
			...settings,
			attributes: {
				...settings.attributes,
				galleryLayout:   { type: 'string',  default: 'default' },
				focalPoint:      { type: 'object',  default: { x: 0.5, y: 0.5 } },
				focalHeight:     { type: 'number',  default: 300 },
				focalMaxHeight:  { type: 'number',  default: 400 },
				focalAlign:       { type: 'string',  default: 'center' },
				enableLightbox:   { type: 'boolean', default: false },
				enableScroll:     { type: 'boolean', default: false },
				scrollDuration:   { type: 'number',  default: 8000 },
				scrollDirection:  { type: 'string',  default: 'ltr' },
				scrollLoop:       { type: 'boolean', default: true },
			},
		};
	}
);

/* ── 2. Afegir controls al sidebar ───────────────────────────────── */
const withGalleryControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( props.name !== 'core/gallery' ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;
		const {
			galleryLayout,
			focalPoint,
			focalHeight,
			focalMaxHeight,
			focalAlign,
			enableLightbox,
			enableScroll,
			scrollDuration,
			scrollDirection,
			scrollLoop,
		} = attributes;

		return (
			<Fragment>
				<BlockEdit { ...props } />

				<InspectorControls>

					{/* ── Layout ── */}
					<PanelBody title="Layout de galeria" initialOpen={ true }>
						<SelectControl
							label="Mode de layout"
							value={ galleryLayout }
							options={ [
								{ label: 'Per defecte (grid WP)',          value: 'default'   },
								{ label: 'Masonry (columnes lliures)',      value: 'masonry'   },
								{ label: 'Filmstrip (mateixa alçada)',      value: 'filmstrip' },
								{ label: 'Punt focal (cobreix contenidor)', value: 'focal'     },
							] }
							onChange={ ( v ) => setAttributes( { galleryLayout: v } ) }
						/>

						{ galleryLayout === 'focal' && (
							<>
								<RangeControl
									label="Alçada màxima (px)"
									help="Limita l'alçada de les imatges. Les imatges mantenen la proporció."
									value={ focalMaxHeight }
									onChange={ ( v ) => setAttributes( { focalMaxHeight: v } ) }
									min={ 100 }
									max={ 1000 }
									step={ 10 }
								/>
								<SelectControl
									label="Alineació vertical"
									value={ focalAlign }
									options={ [
										{ label: 'Superior (top)',    value: 'flex-start' },
										{ label: 'Centre (horitzó)', value: 'center'     },
										{ label: 'Inferior (bottom)', value: 'flex-end'  },
									] }
									onChange={ ( v ) => setAttributes( { focalAlign: v } ) }
								/>
								<SelectControl
									label="Direcció del scroll"
									value={ scrollDirection }
									options={ [
										{ label: 'Esquerra → Dreta', value: 'ltr' },
										{ label: 'Dreta → Esquerra', value: 'rtl' },
									] }
									onChange={ ( v ) => setAttributes( { scrollDirection: v } ) }
								/>
								<RangeControl
									label="Durada d'un loop (ms)"
									value={ scrollDuration }
									onChange={ ( v ) => setAttributes( { scrollDuration: v } ) }
									min={ 1000 }
									max={ 60000 }
									step={ 500 }
								/>
							</>
						) }
					</PanelBody>

					{/* ── Lightbox ── */}
					<PanelBody title="Lightbox" initialOpen={ false }>
						<ToggleControl
							label="Activar lightbox"
							help="Clic sobre una imatge per ampliar-la. Navegació amb fletxes i teclat."
							checked={ enableLightbox }
							onChange={ ( v ) => setAttributes( { enableLightbox: v } ) }
						/>
					</PanelBody>

				</InspectorControls>
			</Fragment>
		);
	};
}, 'withGalleryControls' );

addFilter( 'editor.BlockEdit', 'pds-gallery/with-controls', withGalleryControls );
