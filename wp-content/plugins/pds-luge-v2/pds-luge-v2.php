<?php
/**
 * Plugin Name:  PDS Luge v2
 * Description:  Bloques Gutenberg de animación GSAP/ScrollTrigger: Parallax, Text Reveal, Video Scrub y Counter.
 * Version:      2.0.0
 * Requires at least: 6.1
 * Requires PHP: 7.4
 * Author:       Ricard Paladini Digital Solutions
 * Text Domain:  pds-luge-v2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PDS_LUGE2_DIR', plugin_dir_path( __FILE__ ) );
define( 'PDS_LUGE2_URL', plugin_dir_url( __FILE__ ) );
define( 'PDS_LUGE2_VER', '2.0.0' );

/* ─── GSAP via CDN ─────────────────────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', 'pds_luge2_enqueue_gsap' );
function pds_luge2_enqueue_gsap() {
	if ( ! wp_script_is( 'gsap-js', 'registered' ) ) {
		wp_enqueue_script( 'gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/gsap.min.js', [], false, true );
	} else {
		wp_enqueue_script( 'gsap-js' );
	}
	if ( ! wp_script_is( 'gsap-st', 'registered' ) ) {
		wp_enqueue_script( 'gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.12.7/dist/ScrollTrigger.min.js', [ 'gsap-js' ], false, true );
	} else {
		wp_enqueue_script( 'gsap-st' );
	}
}

/* ─── Registrar bloques ────────────────────────────────────────────────────── */
add_action( 'init', 'pds_luge2_register_blocks' );
function pds_luge2_register_blocks() {

	$editor_js  = PDS_LUGE2_DIR . 'build/editor.js';
	$frontend_js = PDS_LUGE2_DIR . 'build/frontend.js';
	$style_css  = PDS_LUGE2_DIR . 'build/style-style.css';

	wp_register_script(
		'pds-luge2-editor',
		PDS_LUGE2_URL . 'build/editor.js',
		[ 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-element', 'wp-i18n' ],
		file_exists( $editor_js ) ? filemtime( $editor_js ) : PDS_LUGE2_VER,
		true
	);

	wp_register_style(
		'pds-luge2-style',
		PDS_LUGE2_URL . 'build/style-style.css',
		[],
		file_exists( $style_css ) ? filemtime( $style_css ) : PDS_LUGE2_VER
	);

	wp_register_script(
		'pds-luge2-frontend',
		PDS_LUGE2_URL . 'build/frontend.js',
		[ 'gsap-js', 'gsap-st' ],
		file_exists( $frontend_js ) ? filemtime( $frontend_js ) : PDS_LUGE2_VER,
		true
	);

	/* ── pds-luge/parallax ───────────────────────────────────────────── */
	register_block_type( 'pds-luge/parallax', [
		'editor_script' => 'pds-luge2-editor',
		'style'         => 'pds-luge2-style',
		'script'        => 'pds-luge2-frontend',
		'attributes'    => [
			'speed'         => [ 'type' => 'number', 'default' => 0.5 ],
			'direction'     => [ 'type' => 'string', 'default' => 'vertical' ],
			'animationType' => [ 'type' => 'string', 'default' => 'fadeUp' ],
			'gsapEase'      => [ 'type' => 'string', 'default' => 'power2.out' ],
		],
	] );

	/* ── pds-luge/text-reveal ────────────────────────────────────────── */
	register_block_type( 'pds-luge/text-reveal', [
		'editor_script' => 'pds-luge2-editor',
		'style'         => 'pds-luge2-style',
		'script'        => 'pds-luge2-frontend',
		'attributes'    => [
			'revealType'    => [ 'type' => 'string', 'default' => 'words' ],
			'duration'      => [ 'type' => 'number', 'default' => 800 ],
			'stagger'       => [ 'type' => 'number', 'default' => 50 ],
			'delay'         => [ 'type' => 'number', 'default' => 0 ],
			'animationType' => [ 'type' => 'string', 'default' => 'fadeUp' ],
			'gsapEase'      => [ 'type' => 'string', 'default' => 'power2.out' ],
		],
	] );

	/* ── pds-luge/video-scrub ────────────────────────────────────────── */
	register_block_type( 'pds-luge/video-scrub', [
		'editor_script' => 'pds-luge2-editor',
		'style'         => 'pds-luge2-style',
		'script'        => 'pds-luge2-frontend',
		'attributes'    => [
			'videoUrl'      => [ 'type' => 'string', 'default' => '' ],
			'pin'           => [ 'type' => 'boolean', 'default' => false ],
			'scrubSpeed'    => [ 'type' => 'number', 'default' => 1 ],
			'startTrigger'  => [ 'type' => 'string', 'default' => 'top center' ],
			'endTrigger'    => [ 'type' => 'string', 'default' => 'bottom top' ],
			'animationType' => [ 'type' => 'string', 'default' => 'fadeIn' ],
			'gsapEase'      => [ 'type' => 'string', 'default' => 'power2.out' ],
		],
	] );

	/* ── pds-luge/counter ────────────────────────────────────────────── */
	register_block_type( 'pds-luge/counter', [
		'editor_script' => 'pds-luge2-editor',
		'style'         => 'pds-luge2-style',
		'script'        => 'pds-luge2-frontend',
		'attributes'    => [
			'target'        => [ 'type' => 'number', 'default' => 1000 ],
			'prefix'        => [ 'type' => 'string', 'default' => '' ],
			'suffix'        => [ 'type' => 'string', 'default' => '' ],
			'decimals'      => [ 'type' => 'number', 'default' => 0 ],
			'duration'      => [ 'type' => 'number', 'default' => 2000 ],
			'separator'     => [ 'type' => 'boolean', 'default' => false ],
			'animationType' => [ 'type' => 'string', 'default' => 'fadeUp' ],
			'gsapEase'      => [ 'type' => 'string', 'default' => 'power2.out' ],
		],
	] );
}

/* ═══════════════════════════════════════════════════════════════════════════
   PÁGINA DE DOCUMENTACIÓN EN EL ADMIN
═══════════════════════════════════════════════════════════════════════════ */
add_action( 'admin_menu', 'pds_luge2_admin_menu' );
function pds_luge2_admin_menu() {
	add_menu_page(
		'PDS Luge v2 — Documentación',
		'PDS Luge v2',
		'manage_options',
		'pds-luge-v2',
		'pds_luge2_admin_page',
		'dashicons-superhero-alt',
		81
	);
}

function pds_luge2_admin_page() {
	?>
	<style>
		.pds-doc { max-width: 960px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
		.pds-doc h1 { display: flex; align-items: center; gap: 10px; font-size: 1.6rem; margin-bottom: 6px; }
		.pds-doc .pds-version { font-size: .75rem; background: #0A3A5E; color: #fff; padding: 2px 8px; border-radius: 12px; vertical-align: middle; }
		.pds-doc .pds-subtitle { color: #465466; margin-top: 0; margin-bottom: 28px; font-size: .95rem; }

		/* Bloques */
		.pds-blocks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 16px; margin-bottom: 36px; }
		.pds-block-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 18px 20px; }
		.pds-block-card .icon { font-size: 2rem; line-height: 1; margin-bottom: 8px; }
		.pds-block-card h3 { margin: 0 0 6px; font-size: 1rem; color: #0A3A5E; }
		.pds-block-card p  { margin: 0 0 10px; font-size: .82rem; color: #555; line-height: 1.45; }
		.pds-block-card code { display: inline-block; background: #f0f4f8; color: #1D669D; font-size: .75rem; padding: 1px 6px; border-radius: 4px; }

		/* Secciones */
		.pds-section { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 24px 28px; margin-bottom: 24px; }
		.pds-section h2 { margin-top: 0; font-size: 1.15rem; color: #0A3A5E; border-bottom: 2px solid #F40000; padding-bottom: 8px; display: inline-block; }

		/* Tabla de presets */
		.pds-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
		.pds-table th { background: #0A3A5E; color: #fff; padding: 8px 12px; text-align: left; font-weight: 600; }
		.pds-table td { padding: 8px 12px; border-bottom: 1px solid #eee; vertical-align: top; }
		.pds-table tr:last-child td { border-bottom: none; }
		.pds-table tr:nth-child(even) td { background: #f9fafb; }
		.pds-table .preset-name { font-weight: 700; color: #1D669D; white-space: nowrap; }
		.pds-table .preset-css  { font-family: monospace; font-size: .78rem; color: #444; }
		.pds-table .ease-curve  { font-style: italic; color: #555; font-size: .8rem; }

		/* Uso por bloque */
		.pds-block-detail { margin-bottom: 0; }
		.pds-block-detail + .pds-block-detail { margin-top: 22px; border-top: 1px solid #eee; padding-top: 22px; }
		.pds-block-detail h3 { margin: 0 0 10px; font-size: 1rem; color: #1D669D; }
		.pds-attr-list { margin: 0; padding: 0; list-style: none; display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 6px; }
		.pds-attr-list li { background: #f0f4f8; border-radius: 5px; padding: 6px 10px; font-size: .8rem; }
		.pds-attr-list li strong { color: #0A3A5E; font-family: monospace; }
		.pds-attr-list li span { color: #555; }

		/* Nota */
		.pds-note { background: #fff8e1; border-left: 4px solid #f9a825; border-radius: 4px; padding: 10px 14px; font-size: .83rem; color: #555; margin-top: 16px; }
		.pds-note strong { color: #333; }

		/* Ease demo */
		.ease-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px; }
		.ease-card { background: #f9fafb; border: 1px solid #eee; border-radius: 6px; padding: 10px 14px; }
		.ease-card .ease-name { font-weight: 700; font-family: monospace; font-size: .82rem; color: #1D669D; margin-bottom: 4px; }
		.ease-card .ease-desc { font-size: .78rem; color: #666; line-height: 1.4; }
		.ease-card .ease-badge { display: inline-block; margin-top: 4px; background: #0A3A5E; color: #fff; font-size: .68rem; padding: 1px 6px; border-radius: 10px; }
	</style>

	<div class="wrap pds-doc">

		<h1>
			<span class="dashicons dashicons-superhero-alt" style="font-size:1.8rem;height:auto;color:#F40000;"></span>
			PDS Luge v2
			<span class="pds-version">v2.0.0</span>
		</h1>
		<p class="pds-subtitle">Plugin de animaciones GSAP/ScrollTrigger para Gutenberg &mdash; Paladini Digital Solutions</p>

		<!-- BLOQUES DISPONIBLES -->
		<div class="pds-section">
			<h2>Bloques disponibles</h2>
			<div class="pds-blocks-grid" style="margin-top:16px;">
				<div class="pds-block-card">
					<div class="icon">🌀</div>
					<h3>Parallax</h3>
					<p>Wrapper con efecto parallax continuo al hacer scroll. El contenido interior se desplaza a velocidad distinta al scroll.</p>
					<code>pds-luge/parallax</code>
				</div>
				<div class="pds-block-card">
					<div class="icon">✍️</div>
					<h3>Text Reveal</h3>
					<p>RichText que aparece animado, dividiendo el contenido por palabras, líneas o caracteres con stagger configurable.</p>
					<code>pds-luge/text-reveal</code>
				</div>
				<div class="pds-block-card">
					<div class="icon">🎬</div>
					<h3>Video Scrub</h3>
					<p>Vídeo cuyo <code>currentTime</code> se sincroniza con el scroll mediante GSAP ScrollTrigger. Admite pin.</p>
					<code>pds-luge/video-scrub</code>
				</div>
				<div class="pds-block-card">
					<div class="icon">🔢</div>
					<h3>Counter</h3>
					<p>Contador animado que se dispara al entrar en el viewport. Soporta prefijo, sufijo, decimales y separador de miles.</p>
					<code>pds-luge/counter</code>
				</div>
			</div>
		</div>

		<!-- PRESETS DE ANIMACIÓN -->
		<div class="pds-section">
			<h2>Presets de animación de entrada</h2>
			<p style="color:#555;font-size:.87rem;margin-top:8px;">Todos los bloques incluyen un selector de <strong>Animación de entrada</strong> que se dispara una sola vez cuando el elemento entra en el viewport (ScrollTrigger <code>once: true</code>, inicio en <code>top 85%</code>).</p>
			<table class="pds-table" style="margin-top:14px;">
				<thead>
					<tr>
						<th>Preset</th>
						<th>Desde (from)</th>
						<th>Hasta (to)</th>
						<th>Mejor uso</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="preset-name">fadeUp</td>
						<td class="preset-css">opacity:0, y:40px</td>
						<td class="preset-css">opacity:1, y:0</td>
						<td>Uso general, textos y tarjetas</td>
					</tr>
					<tr>
						<td class="preset-name">fadeDown</td>
						<td class="preset-css">opacity:0, y:&#8209;40px</td>
						<td class="preset-css">opacity:1, y:0</td>
						<td>Elementos que caen desde arriba</td>
					</tr>
					<tr>
						<td class="preset-name">fadeIn</td>
						<td class="preset-css">opacity:0</td>
						<td class="preset-css">opacity:1</td>
						<td>Fondos, vídeos, imágenes</td>
					</tr>
					<tr>
						<td class="preset-name">slideLeft</td>
						<td class="preset-css">opacity:0, x:&#8209;60px</td>
						<td class="preset-css">opacity:1, x:0</td>
						<td>Elementos que entran por la izquierda</td>
					</tr>
					<tr>
						<td class="preset-name">slideRight</td>
						<td class="preset-css">opacity:0, x:60px</td>
						<td class="preset-css">opacity:1, x:0</td>
						<td>Elementos que entran por la derecha</td>
					</tr>
					<tr>
						<td class="preset-name">scaleIn</td>
						<td class="preset-css">opacity:0, scale:0.85</td>
						<td class="preset-css">opacity:1, scale:1</td>
						<td>Tarjetas, botones, imágenes</td>
					</tr>
					<tr>
						<td class="preset-name">zoomIn</td>
						<td class="preset-css">opacity:0, scale:0.5</td>
						<td class="preset-css">opacity:1, scale:1</td>
						<td>Efectos de impacto, iconos grandes</td>
					</tr>
					<tr>
						<td class="preset-name">none</td>
						<td class="preset-css">&mdash;</td>
						<td class="preset-css">&mdash;</td>
						<td>Sin animación de entrada</td>
					</tr>
				</tbody>
			</table>
		</div>

		<!-- EASING -->
		<div class="pds-section">
			<h2>Curvas de easing (GSAP)</h2>
			<p style="color:#555;font-size:.87rem;margin-top:8px;">El easing controla la aceleración de la animación. Solo se aplica cuando hay un preset activo (no aplica a <em>none</em>).</p>
			<div class="ease-grid" style="margin-top:16px;">
				<div class="ease-card">
					<div class="ease-name">power1.out</div>
					<div class="ease-desc">Desaceleración suave. Ideal para movimientos cotidianos.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">power2.out</div>
					<div class="ease-desc">Desaceleración media. <span class="ease-badge">Defecto</span></div>
				</div>
				<div class="ease-card">
					<div class="ease-name">power3.out</div>
					<div class="ease-desc">Entrada rápida y frenada notable. Muy usado en UI.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">power4.out</div>
					<div class="ease-desc">Entrada muy rápida, frenada fuerte. Impactante.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">back.out(1.7)</div>
					<div class="ease-desc">Sobrepasa el punto de llegada y rebota levemente hacia atrás.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">elastic.out</div>
					<div class="ease-desc">Efecto muelle con oscilaciones al llegar. Muy llamativo.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">bounce.out</div>
					<div class="ease-desc">Simula un objeto que rebota al llegar. Lúdico.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">sine.out</div>
					<div class="ease-desc">Curva sinusoidal, muy suave. Ideal para parallax.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">expo.out</div>
					<div class="ease-desc">Aceleración exponencial y frenada brusca.</div>
				</div>
				<div class="ease-card">
					<div class="ease-name">circ.out</div>
					<div class="ease-desc">Basado en un cuarto de círculo. Frenada muy orgánica.</div>
				</div>
			</div>
		</div>

		<!-- CONFIGURACIÓN POR BLOQUE -->
		<div class="pds-section">
			<h2>Configuración por bloque</h2>

			<div class="pds-block-detail" style="margin-top:16px;">
				<h3>🌀 Parallax <code style="font-size:.8rem;">pds-luge/parallax</code></h3>
				<ul class="pds-attr-list">
					<li><strong>speed</strong> <span>&mdash; número entre -2 y 2. Positivo = mismo sentido del scroll, negativo = inverso. 0 = sin efecto.</span></li>
					<li><strong>direction</strong> <span>&mdash; <em>vertical</em> (desplaza Y) o <em>horizontal</em> (desplaza X).</span></li>
					<li><strong>animationType</strong> <span>&mdash; preset de entrada al viewport (ver tabla arriba).</span></li>
					<li><strong>gsapEase</strong> <span>&mdash; curva de la animación de entrada.</span></li>
				</ul>
				<div class="pds-note">El bloque es un <strong>wrapper</strong> (InnerBlocks). Coloca dentro cualquier bloque de WordPress. La animación de entrada y el parallax son independientes.</div>
			</div>

			<div class="pds-block-detail">
				<h3>✍️ Text Reveal <code style="font-size:.8rem;">pds-luge/text-reveal</code></h3>
				<ul class="pds-attr-list">
					<li><strong>tag</strong> <span>&mdash; elemento HTML: <em>p, h2, h3, h4</em>.</span></li>
					<li><strong>revealType</strong> <span>&mdash; <em>words</em>, <em>lines</em> o <em>chars</em>. El JS divide el texto en spans.</span></li>
					<li><strong>duration</strong> <span>&mdash; duración de la animación de cada unidad (ms). Por defecto 800.</span></li>
					<li><strong>stagger</strong> <span>&mdash; retraso entre cada palabra/línea/carácter (ms). Por defecto 50.</span></li>
					<li><strong>delay</strong> <span>&mdash; retraso inicial antes de que empiece la animación (ms).</span></li>
					<li><strong>animationType</strong> <span>&mdash; determina el <em>from</em> de cada unidad (fadeUp, slideLeft…).</span></li>
					<li><strong>gsapEase</strong> <span>&mdash; curva aplicada a cada unidad.</span></li>
				</ul>
				<div class="pds-note"><strong>Importante:</strong> el JS reescribe el innerHTML del elemento para insertar los spans. El contenido HTML rico (negrita, enlaces) se aplana a texto plano. Usa este bloque solo para texto sin formato.</div>
			</div>

			<div class="pds-block-detail">
				<h3>🎬 Video Scrub <code style="font-size:.8rem;">pds-luge/video-scrub</code></h3>
				<ul class="pds-attr-list">
					<li><strong>videoUrl</strong> <span>&mdash; URL del vídeo MP4. Puedes usar la biblioteca de medios.</span></li>
					<li><strong>pin</strong> <span>&mdash; si está activo, el wrapper queda fijo en pantalla mientras dura el scrub.</span></li>
					<li><strong>scrubSpeed</strong> <span>&mdash; velocidad del scrub. 1 = sincronizado 1:1 con el scroll. Valores mayores = más lento.</span></li>
					<li><strong>startTrigger</strong> <span>&mdash; punto de inicio del ScrollTrigger. Ej: <em>top center</em>, <em>top 80%</em>.</span></li>
					<li><strong>endTrigger</strong> <span>&mdash; punto de fin del ScrollTrigger. Ej: <em>bottom top</em>, <em>bottom 20%</em>.</span></li>
					<li><strong>animationType</strong> <span>&mdash; animación de entrada del wrapper antes del scrub.</span></li>
					<li><strong>gsapEase</strong> <span>&mdash; curva de la animación de entrada.</span></li>
				</ul>
				<div class="pds-note">El vídeo necesita <strong>metadatos cargados</strong> para calcular la duración. Si no aparece el scrub, asegúrate de que el servidor sirve el vídeo con <em>byte-range</em> correcto (no chunked). El atributo <code>preload="auto"</code> está activo por defecto.</div>
			</div>

			<div class="pds-block-detail">
				<h3>🔢 Counter <code style="font-size:.8rem;">pds-luge/counter</code></h3>
				<ul class="pds-attr-list">
					<li><strong>target</strong> <span>&mdash; número final al que llega el contador.</span></li>
					<li><strong>prefix</strong> <span>&mdash; texto antes del número. Ej: <em>$</em>, <em>+</em>.</span></li>
					<li><strong>suffix</strong> <span>&mdash; texto después del número. Ej: <em>%</em>, <em>k</em>, <em> años</em>.</span></li>
					<li><strong>decimals</strong> <span>&mdash; número de decimales a mostrar (0–4).</span></li>
					<li><strong>duration</strong> <span>&mdash; duración de la animación del contador en ms. Por defecto 2000.</span></li>
					<li><strong>separator</strong> <span>&mdash; si está activo, usa punto como separador de miles y coma para decimales (es-ES).</span></li>
					<li><strong>animationType</strong> <span>&mdash; animación de entrada del wrapper (aparece mientras el contador empieza).</span></li>
					<li><strong>gsapEase</strong> <span>&mdash; curva de la animación de entrada del wrapper.</span></li>
				</ul>
				<div class="pds-note">El contador usa <strong>IntersectionObserver</strong> + <code>requestAnimationFrame</code> (sin GSAP). La curva de easing del contador es siempre <em>ease-out cúbica</em> y no es configurable; el <em>gsapEase</em> solo afecta a la animación de entrada del wrapper.</div>
			</div>
		</div>

		<!-- DEPENDENCIAS -->
		<div class="pds-section">
			<h2>Dependencias</h2>
			<table class="pds-table">
				<thead><tr><th>Librería</th><th>Versión</th><th>Carga</th><th>Notas</th></tr></thead>
				<tbody>
					<tr>
						<td><strong>GSAP</strong></td>
						<td>3.12.7</td>
						<td>CDN (jsDelivr)</td>
						<td>Solo en el frontend público. Handle WP: <code>gsap-js</code></td>
					</tr>
					<tr>
						<td><strong>ScrollTrigger</strong></td>
						<td>3.12.7</td>
						<td>CDN (jsDelivr)</td>
						<td>Depende de GSAP. Handle WP: <code>gsap-st</code></td>
					</tr>
					<tr>
						<td><strong>WordPress Blocks API</strong></td>
						<td>≥ 6.1</td>
						<td>WP core</td>
						<td>wp-blocks, wp-block-editor, wp-components, wp-element</td>
					</tr>
				</tbody>
			</table>
			<div class="pds-note" style="margin-top:12px;">Si el plugin <strong>PDS Luge (v1)</strong> está activo al mismo tiempo, los handles <code>gsap-js</code> y <code>gsap-st</code> ya estarán registrados y este plugin los reutilizará sin cargarlos dos veces.</div>
		</div>

		<p style="color:#aaa;font-size:.78rem;margin-top:8px;">PDS Luge v2 &mdash; Paladini Digital Solutions &mdash; <?php echo esc_html( date( 'Y' ) ); ?></p>
	</div>
	<?php
}
