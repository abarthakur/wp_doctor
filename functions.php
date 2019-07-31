<?php

//TODO : DOCSTRING?


/* Enqueue stylesheets and scripts */
function doc_enqueue_theme_styles_and_scripts() {
	wp_enqueue_style( 'theme-style', get_stylesheet_directory_uri() . '/css/style.css', array(), 20141119 );
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/css/lib/bootstrap.css', array(), 20141119 );
	wp_enqueue_style( 'fonts', get_stylesheet_directory_uri() . '/css/lib/fontawesome.css', array(), 20141122 );
	/* Popper 1.14.7 */
	wp_enqueue_script( 'popper-script', get_stylesheet_directory_uri() . '/js/lib/popper.js', array(), 20120206 );
	/* JQuery 3.3.1 */
	wp_enqueue_script( 'jquery-script', get_stylesheet_directory_uri() . '/js/lib/jquery-3.3.1.js', array(), 20120206);
	// /* Bootstrap 4.3.1. Dependencies - JQuery 3.3.1, Popper 1.14.7 */
	wp_enqueue_script( 'bootstrap-script', get_stylesheet_directory_uri() . '/js/lib/bootstrap.bundle.js', array(), 20120206 );
	wp_enqueue_script( 'theme-script', get_stylesheet_directory_uri() . '/js/main.js', array(), 20120206,false );
	wp_enqueue_script( 'clamp-js', get_stylesheet_directory_uri() . '/js/lib/clamp.js', array(), 20120222 );
}
add_action( 'wp_enqueue_scripts', 'doc_enqueue_theme_styles_and_scripts' );


/* Register custom post types */
function doc_register_custom_post_types() {
	//TODO : Refactor
	register_post_type( 'custom_card',
		array(
			'labels'=> array(
							'name'	=> __( 'Custom Card' ),
							),
			'public'		=> false,
			'show_ui'		=> true,
			'supports'		=> array(
								'title',
								'editor'
							)
		)
	);
	
	register_post_type( 'video_post',
		array(
			'labels'       => array(
				'name'       => __( 'Video Post' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'supports'     => array(
				'title',
				'editor',
				'excerpt',
				'author'
			)
		)
	);

	register_post_type( 'service_card',
		array(
			'labels'       => array(
				'name'       => __( 'Service Card' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'supports'     => array(
				'title',
				'editor'
			)
		)
	);

	register_post_type( 'place_of_work',
		array(
			'labels'       => array(
				'name'       => __( 'Place Of Work' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'supports'     => array(
				'title',
				'excerpt',
				'editor'
			)
		)
	);

	register_post_type( 'testimonial',
		array(
			'labels'       => array(
				'name'       => __( 'Testimonial' ),
			),
			'public'       => false,
			'show_ui'      => true,
			'supports' => array(
				'title'
			)
		)
	);


}
add_action( 'init', 'doc_register_custom_post_types' );


/* Register navigation menus (for nav menu, footers etc)*/
function doc_register_menus() {
	register_nav_menus(
	  array(
		'header-menu' => __( 'Header Menu' ),
		'footer-menu-1'=>  'Footer Menu 1',
		'footer-menu-2'=>  'Footer Menu 2',
	   )
	 );
}
add_action( 'init', 'doc_register_menus' );

/* Require 3rd party libraries */
require_once get_template_directory() . '/lib/class-wp-bootstrap-navwalker.php';


/* Register Settings pages */
//TODO
