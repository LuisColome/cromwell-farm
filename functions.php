<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Cromwell Farm
 * @author  Luis Colomé
 * @license GPL-2.0-or-later
 * @link    https://luiscolome.com/
 */

 /**
 * Set up the content width value based on the theme's design.
 *
 */
if ( ! isset( $content_width ) )
	$content_width = 768;	

 /**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function lcm_global_enqueues() {
	
	// javascript
	wp_enqueue_script( 'ea-global', get_stylesheet_directory_uri() . '/assets/js/global-min.js', array( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/global-min.js' ), true );

	// Move jQuery to footer
	if( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
		wp_enqueue_script( 'jquery' );
	}

	// css
	wp_dequeue_style( 'child-theme' );
	wp_enqueue_style( 'lcm-fonts', lcm_theme_fonts_url(), array(), null  );
	wp_enqueue_style( 'lcm-style', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), filemtime( get_stylesheet_directory() . '/assets/css/main.css' ) );

}
add_action( 'wp_enqueue_scripts', 'lcm_global_enqueues' );

/**
 * Gutenberg scripts and styles
 *
 */
function ea_gutenberg_scripts() {
	wp_enqueue_style( 'lcm-fonts', lcm_theme_fonts_url() );
	//wp_enqueue_script( 'ea-editor', get_stylesheet_directory_uri() . '/assets/js/editor.js', array( 'wp-blocks', 'wp-dom' ), filemtime( get_stylesheet_directory() . '/assets/js/editor.js' ), true );
}
add_action( 'enqueue_block_editor_assets', 'ea_gutenberg_scripts' );

/**
* Theme Fonts URL
*
*/
function lcm_theme_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&display=swap';
}

function ea_child_theme_setup() {

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/assets/css/main.css' ) );

	// General cleanup
	include_once( get_stylesheet_directory() . '/inc/wordpress-cleanup.php' );
	include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );

	// Theme
	include_once( get_stylesheet_directory() . '/inc/site-logo.php' );
	include_once( get_stylesheet_directory() . '/inc/site-footer.php' );
	include_once( get_stylesheet_directory() . '/inc/login-logo.php' );
	include_once( get_stylesheet_directory() . '/inc/layouts.php' );
	include_once( get_stylesheet_directory() . '/inc/loop.php' );
	include_once( get_stylesheet_directory() . '/inc/navigation.php' );
	include_once( get_stylesheet_directory() . '/inc/markup.php' );
	include_once( get_stylesheet_directory() . '/inc/template-tags.php' );
	include_once( get_stylesheet_directory() . '/inc/helper-functions.php' );

    // Plugin Support
	include_once( get_stylesheet_directory() . '/inc/acf.php' );
	include_once( get_stylesheet_directory() . '/inc/amp.php' );

	// Editor Styles
	add_theme_support( 'editor-styles' );
	add_editor_style( '/inc/gutenberg/style-editor.css' );
	// add_editor_style( '/assets/css/editor-style.css' );

	// Remove image sizes
	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );

	// Adds image sizes.
	add_image_size( 'cf-standard-image', 768, 432, true ); // 16:9
	add_image_size( 'cf-featured-image', 768, 626, true );


	/**
	 * Register custom images sizes to use in Gutenberg
	 */
	function lcm_custom_image_sizes( $sizes ) {
		return array_merge( $sizes, array(

		//Add your custom sizes here
		'cf-featured-image' => __( 'Cromwell Farm Featured Image (768x626)' ),
		'cf-standard-image' => __( 'Standard Featured Image (768x432)' ),
		
		) );
	}
	add_filter( 'image_size_names_choose','lcm_custom_image_sizes' );

	// Gutenberg

	// -- Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// -- Wide Images
	add_theme_support( 'align-wide' );

	// -- Custom line heights.
	add_theme_support( 'custom-line-height' );

	// -- Custom units.
	add_theme_support( 'custom-units' );

	// -- Editor Font Sizes
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'Small', 'cromwellfarm' ),
			'shortName' => __( 'S', 'cromwellfarm' ),
			'size'      => 14,
			'slug'      => 'small'
		),
		array(
			'name'      => __( 'Normal', 'cromwellfarm' ),
			'shortName' => __( 'M', 'cromwellfarm' ),
			'size'      => 18,
			'slug'      => 'normal'
		),
		array(
			'name'      => __( 'Large', 'cromwellfarm' ),
			'shortName' => __( 'L', 'cromwellfarm' ),
			'size'      => 22,
			'slug'      => 'large'
		),
		array(
			'name'      => __( 'Huge', 'cromwellfarm' ),
			'shortName' => __( 'H', 'cromwellfarm' ),
			'size'      => 26,
			'slug'      => 'huge'
		),
	) );

	// -- Disable Custom Colors
	// add_theme_support( 'disable-custom-colors' );

	// -- Editor Color Palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Orange', 'cromwellfarm' ),
			'slug'  => 'purple',
			'color'	=> '#642581',
		),
		array(
			'name'  => __( 'Light Grey', 'cromwellfarm' ),
			'slug'  => 'light-grey',
			'color'	=> '#f7f7f7',
		),
		array(
			'name'  => __( 'Grey', 'cromwellfarm' ),
			'slug'  => 'grey',
			'color' => '#383838',
		),
		array(
			'name'  => __( 'Dark grey', 'cromwellfarm' ),
			'slug'  => 'dark-grey',
			'color' => '#454545',
		),
		array(
			'name'  => __( 'White', 'cromwellfarm' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
	) );

	// // Registers the responsive menus. (/config/responsive-menus.php)
	// if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	// 	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
	// }

}
add_action( 'genesis_setup', 'ea_child_theme_setup', 15 );


/**
 * Change the comment area text
 *
 * @since  1.0.0
 * @param  array $args
 * @return array
 */
function ea_comment_text( $args ) {
	$args['title_reply']          = __( 'Leave A Comment', 'cromwellfarm' );
	$args['label_submit']         = __( 'Post Comment',  'cromwellfarm' );
	$args['comment_notes_before'] = '';
	$args['comment_notes_after']  = '';
	return $args;
}
add_filter( 'comment_form_defaults', 'ea_comment_text' );


/**
 * Template Hierarchy
 *
 */
function ea_template_hierarchy( $template ) {
	if( is_home() )
		$template = get_query_template( 'archive' );
	return $template;
}
add_filter( 'template_include', 'ea_template_hierarchy' );


/**
 * Remove the P tag from the CF7 forms.
 * 
 */
add_filter('wpcf7_autop_or_not', '__return_false');