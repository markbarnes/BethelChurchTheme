<?php
//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );
require ('inc/theme_functions.php');

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Custom theme for Bethel, Clydach' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

/**
* Add theme support
*/
add_theme_support( 'html5' ); //* Add HTML5 markup structure
//add_theme_support( 'genesis-responsive-viewport' ); //* Add viewport meta tag for mobile browsers
add_theme_support( 'custom-background', bethel_get_default_background_args()); //* Add support for custom background
add_theme_support( 'genesis-footer-widgets', 3 ); //* Add support for 3-column footer widgets

/**
* Remove default actions
*/
remove_action( 'wp_head', 'genesis_load_favicon' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' ); // Remove the site title
remove_action( 'genesis_site_description', 'genesis_seo_site_description' ); // Remove the subtitle
remove_action( 'genesis_after_header', 'genesis_do_subnav' ); // Remove the subnav from below the header
unregister_sidebar( 'header-right' ); // Remove the right header widget area

/**
* Add actions
*/
add_action( 'wp_enqueue_scripts', 'bethel_enqueue_fonts' ); // Enqueue fonts
add_action ('login_enqueue_scripts', 'bethel_add_login_logo'); // Add CSS for login logo
add_action( 'genesis_meta', 'bethel_add_favicons'); // Add favicons
add_action( 'genesis_site_title', 'genesis_do_subnav', 1 ); // Add subnav just before the site title
add_action( 'genesis_site_title', 'bethel_do_logo' ); // Add the logo header
add_action( 'genesis_after_header', 'bethel_filter_menu_items', 0 );
add_action( 'genesis_after_header', 'bethel_stop_filtering_menu_items', 15 );

/**
* Add filters
*/
add_filter('genesis_footer_creds_text', 'bethel_footer'); //* Change the footer text