<?php
//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );
require ('inc/theme_functions.php');

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Custom theme for Bethel, Clydach' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '0.1' );

/**
* Add theme support
*/
add_theme_support( 'html5' ); //* Add HTML5 markup structure
add_theme_support( 'custom-background', bethel_get_default_background_args()); //* Add support for custom background
add_theme_support( 'genesis-footer-widgets', 3 ); //* Add support for 3-column footer widgets

/**
* Remove default actions
*/
remove_action( 'wp_head', 'genesis_load_favicon' );
remove_action( 'genesis_meta', 'genesis_responsive_viewport' );
remove_action( 'genesis_site_title', 'genesis_seo_site_title' ); // Remove the site title
remove_action( 'genesis_site_description', 'genesis_seo_site_description' ); // Remove the subtitle
remove_action( 'genesis_after_header', 'genesis_do_subnav' ); // Remove the subnav from below the header
unregister_sidebar( 'header-right' ); // Remove the right header widget area

/**
* Add actions
*/
add_action( 'wp_enqueue_scripts', 'bethel_enqueue_fonts' ); // Enqueue fonts
add_action ('admin_enqueue_scripts', 'bethel_admin_enqueue_fonts');
add_action ('login_enqueue_scripts', 'bethel_add_login_logo'); // Add CSS for login logo
add_action( 'genesis_meta', 'bethel_add_favicons'); // Add favicons
add_action( 'genesis_meta', 'bethel_add_viewport' );
add_action( 'genesis_site_title', 'genesis_do_subnav', 1 ); // Add subnav just before the site title
add_action( 'genesis_site_title', 'bethel_do_logo' ); // Add the logo header
add_action( 'genesis_after_header', 'bethel_filter_menu_items', 0 );
add_action( 'genesis_after_header', 'bethel_stop_filtering_menu_items', 15 );
add_action( 'genesis_before_entry', 'bethel_add_submenu_to_post', 0);
add_action ('genesis_entry_header', 'bethel_add_image_to_stories', 9);
add_action ('genesis_meta', 'bethel_add_image_to_pages', 11);
add_action ('admin_head', 'bethel_add_favicons');
add_action ('admin_head', 'bethel_add_admin_css');

/**
* Add filters
*/
add_filter('genesis_footer_creds_text', 'bethel_footer'); //* Change the footer text
add_filter ('wp_nav_menu_args', 'bethel_restrict_depth_of_primary_menu');
add_filter ('image_size_names_choose', 'bethel_choose_image_sizes');

/**
* Add image sizes
*/
add_image_size ('bethel_column_width', 360);
add_image_size ('bethel_full_width', 660);
add_image_size ('bethel_supersize', 740);