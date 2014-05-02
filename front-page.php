<?php
/**
 * This file adds the Home Page to the Bethel Church Theme.
 *
 * @author Mark Barnes
 * @package Generate
 * @subpackage Customizations
 */

add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content'); // Remove sidebar
remove_action('genesis_loop', 'genesis_do_loop'); // Remove standard page elements
add_action('genesis_loop', 'bethel_do_home_page'); // Add in our elements

function bethel_do_home_page() {
	echo '<img class="home-main" src="'.get_stylesheet_directory_uri().'/images/people.jpg" height="615" width="1140"/>';
}

genesis();