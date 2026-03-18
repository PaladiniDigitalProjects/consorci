<?php
function my_theme_enqueue_assets() {
    // Parent theme stylesheet.
    $parent_handle = 'parent-style';
    wp_enqueue_style(
        $parent_handle,
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( get_template() )->get( 'Version' )
    );

    // Child theme stylesheet.
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [ $parent_handle ],
        wp_get_theme()->get( 'Version' )
    );

    // Extra child CSS (estils.css).
    wp_enqueue_style(
        'child-estils',
        get_stylesheet_directory_uri() . '/assets/css/estils.css',
        [ $parent_handle ],
        wp_get_theme()->get( 'Version' )
    );


    // Ensure jQuery is available.
    wp_enqueue_script( 'jquery' );

    // Main JS, loaded in footer, depends on jQuery.
    wp_enqueue_script(
        'child-main-js',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        [ 'jquery' ],
        '1.0.0',
        true
    );



}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_assets' );


/* REGISTER NEWS STYLE */

function prefix_register_block_styles() {
	register_block_style(
		array( 'core/button' ),
		array(
			'name'         => 'button-icon-right',
			'label'        => __( 'Icon Right', 'PDS' ),
		)
	);

	register_block_style(
		array( 'core/button' ),
		array(
			'name'         => 'button-icon-left',
			'label'        => __( 'Icon Left', 'PDS' ),
		)
	);

	register_block_style(
		array( 'core/list' ),
		array(
			'name'         => 'list-clean',
			'label'        => __( 'Llistat net', 'PDS' ),
		)
	);
	register_block_style(
		array( 'core/list' ),
		array(
			'name'         => 'list-ratllat',
			'label'        => __( 'Llistat underline', 'PDS' ),
		)
	);
}
add_action( 'init', 'prefix_register_block_styles' );


/* ADD ADMIN AND LOGIN STYLES */

function wpdocs_enqueue_custom_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_stylesheet_directory_uri() . '/assets/css/admin-styles.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style' );

function login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/assets/css/login-styles.css' );
}
add_action( 'login_enqueue_scripts', 'login_stylesheet' );

/* HIDE JSON API */

add_filter( 'rest_authentication_errors', function( $result ) {
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_disabled', 'REST API restricted to authenticated users.', array( 'status' => 401 ) );
    }
    return $result;
});

/* LOGIN H1 URL */


function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );


/* EDIT PAGE */

edit_post_link( __( 'Editar', 'textdomain' ), '<p>', '</p>', null, 'btn btn-primary btn-edit-post-link' );
add_filter('the_content', 'mycontent');
add_filter('avf_template_builder_content', 'mycontent');

function mycontent( $content ) {
	if( is_singular() && is_user_logged_in() ) {
		$content = $content . '<div class="btn btn-primary edit-post-link" style="background-color:red; display:block; border-radius:50%; width:100px; height:100px; position: fixed; right:2rem; bottom:2rem; z-index:999"><a style="display:block; text-align:center; line-height:100px; color:white;" href="' . get_edit_post_link( get_the_ID(), 'Editar') . '">Editar</a></div>';
	}
	return $content;
}

/* EXCLUDE HSOJD CATEGORY */

add_filter('get_the_terms', 'ocultar_categoria_ohsjd', 10, 3);

function ocultar_categoria_ohsjd($terms, $post_id, $taxonomy) {
    if (!empty($terms) && is_array($terms)) {
        foreach ($terms as $key => $term) {
            if ($term->slug === 'ohsjd' || $term->name === 'OHSJD') {
                unset($terms[$key]);
            }
        }
        
        $terms = array_values($terms);
    }
    return $terms;
}

/* BLOCKS */

add_action('acf/init', 'my_acf_init');
function my_acf_init() {

	// check function exists
	if( function_exists('acf_register_block') ) {

    // register related content
    acf_register_block(array(
      'name'				=> 'related',
      'title'				=> __('Related'),
      'description'			=> __('Related content'),
      'render_callback'		=> 'my_acf_block_render_callback',
      'category'			=> 'formatting',
      'icon'				=> 'welcome-add-page',
      'keywords'			=> array( 'Content', 'Related', 'Sponsors' ),
    ));

	// register a editorial block.
	acf_register_block_type(array(
        'name'              => 'block',
        'title'             => __('Editorial Block'),
        'description'       => __('A custom Editorial block.'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'button',
        'align'				=> 'full',
	  ));
	  
	// register a editorial block Slider FP.
	acf_register_block_type(array(
        'name'              => 'blockslider',
        'title'             => __('Editorial Block FP Slider'),
        'description'       => __('A custom Editorial block with.'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'arrow-right-alt',
        'align'				=> 'full',
	  ));

		  
	// register carrusel.
	acf_register_block_type(array(
        'name'              => 'carussel',
        'title'             => __('Carussel'),
        'description'       => __('Carussel slides.'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'button',
        'align'				=> 'full',
	  ));
	
	// register a Slider.
	acf_register_block_type(array(
        'name'              => 'Slider',
        'title'             => __('Slider Block'),
        'description'       => __('Custom Banner / Slider.'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'dashicons-button',
		'keywords'			=> array( 'Content', 'Related', 'Sponsors' ),
      ));

	// register  contact block.
	acf_register_block_type(array(
        'name'              => 'contact',
        'title'             => __('Contact Block'),
        'description'       => __('Contact'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'phone',
		'keywords'			=> array( 'Contact' ),
      ));


	// register  team block.
	acf_register_block_type(array(
        'name'              => 'team',
        'title'             => __('Team'),
        'description'       => __('Team image'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'admin-users',
		'keywords'			=> array('Team image'),
      ));

	// register  team list.
	acf_register_block_type(array(
        'name'              => 'teamlist',
        'title'             => __('Team list'),
        'description'       => __('Team persons list'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'admin-users',
		'keywords'			=> array('Team'),
      ));


	  // register  projects slider.
	acf_register_block_type(array(
        'name'              => 'projects-slider',
        'title'             => __('Projects slider'),
        'description'       => __('Projects slider'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'slides',
		'keywords'			=> array('Projects, Slider'),
      ));


        // register  events list.
	acf_register_block_type(array(
        'name'              => 'events',
        'title'             => __('Events list'),
        'description'       => __('Event list'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'formatting',
        'icon' 				=> 'calendar-alt',
		'keywords'			=> array('Events'),
      ));


    // register  events list.
	acf_register_block_type(array(
        'name'              => 'ticker',
        'title'             => __('Ticker list'),
        'description'       => __('Ticker list'),
        'render_callback'	=> 'my_acf_block_render_callback',
        'category'          => 'Banner',
        'icon' 				=> 'sticky',
		'keywords'			=> array('Ticker'),
      ));

    
    // register related content slider
    acf_register_block(array(
        'name'				=> 'noticias',
        'title'				=> __('Noticias relacionadas'),
        'description'			=> __('Noticias relacionadas'),
        'render_callback'		=> 'my_acf_block_render_callback',
        'category'			=> 'formatting',
        'icon'				=> 'media-spreadsheet',
        'keywords'			=> array( 'Content', 'Related' ),
      ));

      // Contenidos relacionados
    acf_register_block(array(
        'name'				=> 'relacionado',
        'title'				=> __('Contenidos relacionados'),
        'description'			=> __('Contenidos relacionados'),
        'render_callback'		=> 'my_acf_block_render_callback',
        'category'			=> 'formatting',
        'icon'				=> 'pressthis',
        'keywords'			=> array( 'Content', 'Relacionado' ),
      ));

    // Validacion CP
    
    acf_register_block(array(
        'name'				=> 'donaciones',
        'title'				=> __('Quiero Donar'),
        'description'			=> __('Donaciones'),
        'render_callback'		=> 'my_acf_block_render_callback',
        'category'			=> 'formatting',
        'icon'				=> 'pressthis',
        'keywords'			=> array( 'Donaciones', 'Código postal' ),
      ));

    // REDES SOCIALES
    
    acf_register_block(array(
        'name'				=> 'redes-sociales',
        'title'				=> __('Redes Sociales'),
        'description'			=> __('Archivos para descargar'),
        'render_callback'		=> 'my_acf_block_render_callback',
        'category'			=> 'formatting',
        'icon'				=> 'pressthis',
        'keywords'			=> array( 'Redes sociales', 'Social' ),
      ));
	


    
    // DESCARGAS
    
    acf_register_block(array(
        'name'				=> 'descargas',
        'title'				=> __('Descargas'),
        'description'			=> __('Archivos para descargar'),
        'render_callback'		=> 'my_acf_block_render_callback',
        'category'			=> 'formatting',
        'icon'				=> 'pressthis',
        'keywords'			=> array( 'Descargas', 'PDF' ),
      ));
	
	}

  acf_update_setting('google_api_key', 'AIzaSyDacDNyKQJywprc8azrpouCDgMonQSlbmY');
}

add_theme_support( 'wp-block-styles' );

function my_acf_block_render_callback( $block ) {
	$slug = str_replace('acf/', '', $block['name']);
	// include a template part from within the "template-parts/block" folder
	if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
		include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
	}
}

// LOGIN FIRST

// if ( ( is_single() || is_front_page() || is_page() ) 
//        && !is_page('login') && !is_user_logged_in()){ 
//     auth_redirect(); 
// } 
