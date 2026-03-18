/**
 * PDS Luge v2 – Editor JSX source
 * Bloques: parallax, text-reveal, video-scrub, counter
 * Compile: npm run build
 */
import { registerBlockType } from '@wordpress/blocks';
import {
	useBlockProps,
	InnerBlocks,
	InspectorControls,
	RichText,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import {
	PanelBody,
	RangeControl,
	SelectControl,
	ToggleControl,
	TextControl,
	Button,
	Placeholder,
} from '@wordpress/components';

/* ─── Opciones compartidas de animación ─────────────────────────────── */
const ANIMATION_OPTIONS = [
	{ label: 'Fade Up',          value: 'fadeUp' },
	{ label: 'Fade Down',        value: 'fadeDown' },
	{ label: 'Fade In',          value: 'fadeIn' },
	{ label: 'Slide izquierda',  value: 'slideLeft' },
	{ label: 'Slide derecha',    value: 'slideRight' },
	{ label: 'Scale In',         value: 'scaleIn' },
	{ label: 'Zoom In',          value: 'zoomIn' },
	{ label: 'Sin animación',    value: 'none' },
];

const EASE_OPTIONS = [
	{ label: 'power1.out',             value: 'power1.out' },
	{ label: 'power2.out (defecto)',   value: 'power2.out' },
	{ label: 'power3.out',             value: 'power3.out' },
	{ label: 'power4.out',             value: 'power4.out' },
	{ label: 'back.out',               value: 'back.out(1.7)' },
	{ label: 'elastic.out',            value: 'elastic.out(1, 0.3)' },
	{ label: 'bounce.out',             value: 'bounce.out' },
	{ label: 'sine.out',               value: 'sine.out' },
	{ label: 'expo.out',               value: 'expo.out' },
	{ label: 'circ.out',               value: 'circ.out' },
];

/* ─── Panel reutilizable de animación de entrada ────────────────────── */
function AnimationPanel( { animationType, gsapEase, setAttributes } ) {
	return (
		<PanelBody title="Animación de entrada" initialOpen={ false }>
			<SelectControl
				label="Tipo de animación"
				value={ animationType }
				options={ ANIMATION_OPTIONS }
				onChange={ ( v ) => setAttributes( { animationType: v } ) }
			/>
			{ animationType !== 'none' && (
				<SelectControl
					label="Easing GSAP"
					value={ gsapEase }
					options={ EASE_OPTIONS }
					onChange={ ( v ) => setAttributes( { gsapEase: v } ) }
				/>
			) }
		</PanelBody>
	);
}

/* ═══════════════════════════════════════════════════════════════════
   1. PARALLAX BLOCK  –  pds-luge/parallax
══════════════════════════════════════════════════════════════════════ */
registerBlockType( 'pds-luge/parallax', {
	title: 'Parallax',
	description: 'Wrapper con efecto parallax GSAP al hacer scroll.',
	category: 'design',
	icon: 'move',
	attributes: {
		speed:         { type: 'number', default: 0.5 },
		direction:     { type: 'string', default: 'vertical' },
		animationType: { type: 'string', default: 'fadeUp' },
		gsapEase:      { type: 'string', default: 'power2.out' },
	},

	edit( { attributes, setAttributes } ) {
		const { speed, direction, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps( { className: 'pds-parallax-editor' } );

		return (
			<>
				<InspectorControls>
					<PanelBody title="Parallax" initialOpen>
						<RangeControl
							label="Velocidad"
							help="Negativo = dirección inversa al scroll. 0 = sin efecto."
							value={ speed }
							onChange={ ( v ) => setAttributes( { speed: v } ) }
							min={ -2 } max={ 2 } step={ 0.1 }
						/>
						<SelectControl
							label="Dirección"
							value={ direction }
							options={ [
								{ label: 'Vertical (Y)',   value: 'vertical' },
								{ label: 'Horizontal (X)', value: 'horizontal' },
							] }
							onChange={ ( v ) => setAttributes( { direction: v } ) }
						/>
					</PanelBody>
					<AnimationPanel
						animationType={ animationType }
						gsapEase={ gsapEase }
						setAttributes={ setAttributes }
					/>
				</InspectorControls>

				<div { ...blockProps }>
					<div className="pds-parallax-editor-label">
						Parallax — velocidad: { speed } | { direction } | entrada: { animationType }
					</div>
					<InnerBlocks />
				</div>
			</>
		);
	},

	save( { attributes } ) {
		const { speed, direction, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps.save( {
			className:              'pds-parallax',
			'data-speed':           String( speed ),
			'data-direction':       direction,
			'data-animation-type':  animationType,
			'data-gsap-ease':       gsapEase,
		} );
		return (
			<div { ...blockProps }>
				<div className="pds-parallax-inner">
					<InnerBlocks.Content />
				</div>
			</div>
		);
	},
} );

/* ═══════════════════════════════════════════════════════════════════
   2. TEXT REVEAL BLOCK  –  pds-luge/text-reveal
   InnerBlocks wrapper: edición Gutenberg nativa completa.
   El JS frontend recorre el DOM preservando HTML (bold, links, etc.)
   y anima por palabras, bloques (lines) o caracteres.
══════════════════════════════════════════════════════════════════════ */
registerBlockType( 'pds-luge/text-reveal', {
	title: 'Text Reveal',
	description: 'Wrapper que anima el texto interior por palabras, bloques o caracteres. Edición Gutenberg nativa.',
	category: 'text',
	icon: 'editor-textcolor',
	attributes: {
		revealType:    { type: 'string', default: 'words' },
		duration:      { type: 'number', default: 800 },
		stagger:       { type: 'number', default: 50 },
		delay:         { type: 'number', default: 0 },
		animationType: { type: 'string', default: 'fadeUp' },
		gsapEase:      { type: 'string', default: 'power2.out' },
	},

	edit( { attributes, setAttributes } ) {
		const { revealType, duration, stagger, delay, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps( { className: 'pds-text-reveal-editor' } );

		return (
			<>
				<InspectorControls>
					<PanelBody title="Text Reveal" initialOpen>
						<SelectControl
							label="Tipo de reveal"
							help="words/chars: divide el texto preservando negritas y enlaces. lines: anima cada bloque hijo como unidad."
							value={ revealType }
							options={ [
								{ label: 'Por palabras',   value: 'words' },
								{ label: 'Por bloques',    value: 'lines' },
								{ label: 'Por caracteres', value: 'chars' },
							] }
							onChange={ ( v ) => setAttributes( { revealType: v } ) }
						/>
					</PanelBody>
					<PanelBody title="Timing" initialOpen={ false }>
						<RangeControl
							label="Duración (ms)"
							value={ duration }
							onChange={ ( v ) => setAttributes( { duration: v } ) }
							min={ 100 } max={ 3000 } step={ 50 }
						/>
						<RangeControl
							label="Stagger entre unidades (ms)"
							value={ stagger }
							onChange={ ( v ) => setAttributes( { stagger: v } ) }
							min={ 0 } max={ 300 } step={ 10 }
						/>
						<RangeControl
							label="Delay inicial (ms)"
							value={ delay }
							onChange={ ( v ) => setAttributes( { delay: v } ) }
							min={ 0 } max={ 2000 } step={ 50 }
						/>
					</PanelBody>
					<AnimationPanel
						animationType={ animationType }
						gsapEase={ gsapEase }
						setAttributes={ setAttributes }
					/>
				</InspectorControls>

				<div { ...blockProps }>
					<div className="pds-text-reveal-editor-label">
						Text Reveal — { revealType } | { animationType }
					</div>
					<InnerBlocks
						allowedBlocks={ [
							'core/paragraph', 'core/heading',
							'core/list', 'core/quote', 'core/verse',
						] }
						template={ [ [ 'core/paragraph', { placeholder: 'Escribe el texto a animar…' } ] ] }
						templateLock={ false }
					/>
				</div>
			</>
		);
	},

	save( { attributes } ) {
		const { revealType, duration, stagger, delay, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps.save( {
			className:             'pds-text-reveal',
			'data-reveal-type':    revealType,
			'data-duration':       String( duration ),
			'data-stagger':        String( stagger ),
			'data-delay':          String( delay ),
			'data-animation-type': animationType,
			'data-gsap-ease':      gsapEase,
		} );
		return (
			<div { ...blockProps }>
				<InnerBlocks.Content />
			</div>
		);
	},
} );

/* ═══════════════════════════════════════════════════════════════════
   3. VIDEO SCRUB BLOCK  –  pds-luge/video-scrub
══════════════════════════════════════════════════════════════════════ */
registerBlockType( 'pds-luge/video-scrub', {
	title: 'Video Scrub',
	description: 'Video controlado por el scroll con GSAP ScrollTrigger.',
	category: 'media',
	icon: 'video-alt3',
	attributes: {
		videoUrl:      { type: 'string', default: '' },
		pin:           { type: 'boolean', default: false },
		scrubSpeed:    { type: 'number', default: 1 },
		startTrigger:  { type: 'string', default: 'top center' },
		endTrigger:    { type: 'string', default: 'bottom top' },
		animationType: { type: 'string', default: 'fadeIn' },
		gsapEase:      { type: 'string', default: 'power2.out' },
	},

	edit( { attributes, setAttributes } ) {
		const { videoUrl, pin, scrubSpeed, startTrigger, endTrigger, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps( { className: 'pds-video-scrub-editor' } );

		return (
			<>
				<InspectorControls>
					<PanelBody title="Vídeo" initialOpen>
						<TextControl
							label="URL del vídeo"
							help="MP4 recomendado. Puede ser una URL relativa o absoluta."
							value={ videoUrl }
							onChange={ ( v ) => setAttributes( { videoUrl: v } ) }
							placeholder="https://…/video.mp4"
						/>
						<MediaUploadCheck>
							<MediaUpload
								onSelect={ ( media ) => setAttributes( { videoUrl: media.url } ) }
								allowedTypes={ [ 'video' ] }
								render={ ( { open } ) => (
									<Button variant="secondary" onClick={ open }>
										Seleccionar vídeo de la biblioteca
									</Button>
								) }
							/>
						</MediaUploadCheck>
					</PanelBody>
					<PanelBody title="Scroll Trigger" initialOpen={ false }>
						<ToggleControl
							label="Fijar en pantalla (pin)"
							help="El wrapper queda fijo mientras dura el scrub."
							checked={ pin }
							onChange={ ( v ) => setAttributes( { pin: v } ) }
						/>
						<RangeControl
							label="Velocidad de scrub"
							help="1 = sincronizado con el scroll. Valores mayores = más lento."
							value={ scrubSpeed }
							onChange={ ( v ) => setAttributes( { scrubSpeed: v } ) }
							min={ 0.1 } max={ 5 } step={ 0.1 }
						/>
						<TextControl
							label="Inicio del trigger"
							help="Ej: 'top center', 'top 80%'"
							value={ startTrigger }
							onChange={ ( v ) => setAttributes( { startTrigger: v } ) }
						/>
						<TextControl
							label="Fin del trigger"
							help="Ej: 'bottom top', 'bottom 20%'"
							value={ endTrigger }
							onChange={ ( v ) => setAttributes( { endTrigger: v } ) }
						/>
					</PanelBody>
					<AnimationPanel
						animationType={ animationType }
						gsapEase={ gsapEase }
						setAttributes={ setAttributes }
					/>
				</InspectorControls>

				<div { ...blockProps }>
					{ videoUrl ? (
						<video
							src={ videoUrl }
							className="pds-video-scrub-preview"
							muted
							playsInline
						/>
					) : (
						<Placeholder
							icon="video-alt3"
							label="Video Scrub"
							instructions="Introduce una URL de vídeo en el panel lateral o selecciona uno de la biblioteca."
						/>
					) }
					<div className="pds-video-scrub-editor-meta">
						Pin: { pin ? 'Sí' : 'No' } | Scrub: { scrubSpeed }x | Entrada: { animationType }
					</div>
				</div>
			</>
		);
	},

	save( { attributes } ) {
		const { videoUrl, pin, scrubSpeed, startTrigger, endTrigger, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps.save( {
			className:             'pds-video-scrub-wrapper',
			'data-pin':            pin ? 'true' : 'false',
			'data-scrub-speed':    String( scrubSpeed ),
			'data-start':          startTrigger,
			'data-end':            endTrigger,
			'data-animation-type': animationType,
			'data-gsap-ease':      gsapEase,
		} );
		return (
			<div { ...blockProps }>
				<video
					className="pds-video-scrub"
					src={ videoUrl }
					muted
					playsInline
					preload="auto"
				/>
			</div>
		);
	},
} );

/* ═══════════════════════════════════════════════════════════════════
   4. COUNTER BLOCK  –  pds-luge/counter
══════════════════════════════════════════════════════════════════════ */
registerBlockType( 'pds-luge/counter', {
	title: 'Counter',
	description: 'Contador animado que se activa al entrar en el viewport.',
	category: 'design',
	icon: 'chart-bar',
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

	edit( { attributes, setAttributes } ) {
		const { target, prefix, suffix, decimals, duration, separator, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps( { className: 'pds-counter-editor' } );

		const previewValue = separator
			? target.toLocaleString( 'es-ES', { minimumFractionDigits: decimals, maximumFractionDigits: decimals } )
			: target.toFixed( decimals );

		return (
			<>
				<InspectorControls>
					<PanelBody title="Counter" initialOpen>
						<TextControl
							label="Número objetivo"
							type="number"
							value={ target }
							onChange={ ( v ) => setAttributes( { target: parseFloat( v ) || 0 } ) }
						/>
						<TextControl
							label="Prefijo"
							help="Ej: '$', '€'"
							value={ prefix }
							onChange={ ( v ) => setAttributes( { prefix: v } ) }
						/>
						<TextControl
							label="Sufijo"
							help="Ej: '%', 'k', ' años'"
							value={ suffix }
							onChange={ ( v ) => setAttributes( { suffix: v } ) }
						/>
						<RangeControl
							label="Decimales"
							value={ decimals }
							onChange={ ( v ) => setAttributes( { decimals: v } ) }
							min={ 0 } max={ 4 }
						/>
						<RangeControl
							label="Duración (ms)"
							value={ duration }
							onChange={ ( v ) => setAttributes( { duration: v } ) }
							min={ 200 } max={ 5000 } step={ 100 }
						/>
						<ToggleControl
							label="Separador de miles"
							checked={ separator }
							onChange={ ( v ) => setAttributes( { separator: v } ) }
						/>
					</PanelBody>
					<AnimationPanel
						animationType={ animationType }
						gsapEase={ gsapEase }
						setAttributes={ setAttributes }
					/>
				</InspectorControls>

				<div { ...blockProps }>
					<span className="pds-counter-preview">
						{ prefix }{ previewValue }{ suffix }
					</span>
					<span className="pds-counter-editor-hint">Vista previa (se animará en el frontend)</span>
				</div>
			</>
		);
	},

	save( { attributes } ) {
		const { target, prefix, suffix, decimals, duration, separator, animationType, gsapEase } = attributes;
		const blockProps = useBlockProps.save( {
			className:             'pds-counter-wrapper',
			'data-animation-type': animationType,
			'data-gsap-ease':      gsapEase,
		} );
		return (
			<div { ...blockProps }>
				{ prefix && <span className="pds-counter-prefix">{ prefix }</span> }
				<span
					className="pds-counter"
					data-target={ String( target ) }
					data-decimals={ String( decimals ) }
					data-duration={ String( duration ) }
					data-separator={ separator ? 'true' : 'false' }
				>
					0
				</span>
				{ suffix && <span className="pds-counter-suffix">{ suffix }</span> }
			</div>
		);
	},
} );
