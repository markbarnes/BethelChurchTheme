<?php
/**
* Enqueue fonts
* 
*/
function bethel_enqueue_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-font-montserrat', '//fonts.googleapis.com/css?family=Montserrat:300,700', array(), CHILD_THEME_VERSION );
}

function bethel_get_default_background_args() {
	return array ('default-color' => '#f5f5f5',
				  'default-image' => get_stylesheet_directory_uri().'/images/background.jpg',
				  'default-repeat' => 'repeat'
	             );
}

function bethel_filter_menu_items() {
	add_filter ('walker_nav_menu_start_el', 'bethel_add_menu_subtitles'); // Adds subtitles to menus
}

function bethel_stop_filtering_menu_items() {
	remove_filter ('walker_nav_menu_start_el', 'bethel_add_menu_subtitles'); // Removes filter that added subtitles to menus
}

function bethel_add_menu_subtitles ($string) {
	if (substr($string, 3, 7) == 'title="') {
		$title = substr($string, 10, strpos($string, '"', 11)-10);
		$string = "{$string}<span class=\"subtitle\">{$title}</span>";
	}
	return $string;
}

function bethel_footer( $creds ) {
	return '<strong>Bethel Evangelical Church</strong>, Heol-y-nant, Clydach &nbsp;&bull;&nbsp; <strong>Tel:</strong> 01792 828095 &nbsp;&bull;&nbsp; <strong>Registered charity:</strong> 1142690';
}

function bethel_do_logo() {
	echo "<a href=\"".home_url()."\"><img src=\"".get_stylesheet_directory_uri()."/images/logo.png\" width=\"600\" height=\"133\" title=\"Bethel Evangelical Church, Clydach\" alt=\"Bethel Evangelical Church, Clydach\"/></a>";
}

function bethel_add_favicons() {
	echo "<link rel=\"shortcut icon\" href=\"".get_stylesheet_directory_uri()."/images/favicons/favicon.ico\">\r\n";
	echo "<link rel=\"icon\" sizes=\"16x16 32x32 64x64\" href=\"".get_stylesheet_directory_uri()."/images/favicons/favicon.ico\">\r\n";
	$sizes = array(196, 160, 96, 64, 32, 16);
	foreach ($sizes as $size) {
		echo "<link rel=\"icon\" type=\"image/png\" sizes=\"{$size}x{$size}\" href=\"".get_stylesheet_directory_uri()."/images/favicons/favicon-{$size}.png\">\r\n";
	}
	//iOS images can't have alpha transparency
	$sizes = array (152,144,120,114,76,72);
	foreach ($sizes as $size) {
		echo "<link rel=\"apple-touch-icon\" sizes=\"{$size}x{$size}\" href=\"".get_stylesheet_directory_uri()."/images/favicons/favicon-{$size}.png\">\r\n";
	}
	echo "<link rel=\"apple-touch-icon\" href=\"".get_stylesheet_directory_uri()."/images/favicons/favicon-57.png\">\r\n";
	echo "<meta name=\"msapplication-TileColor\" content=\"#FFFFFF\">\r\n";
	echo "<meta name=\"msapplication-TileImage\" content=\"".get_stylesheet_directory_uri()."/images/favicons/favicon-144.png\">\r\n";
	echo "<meta name=\"msapplication-config\" content=\"".get_stylesheet_directory_uri()."/images/favicons/browserconfig.xml\">\r\n";
}

function bethel_add_login_logo() {
	echo "<style type=\"text/css\">\r\n";
	echo "\tbody.login div#login h1 a {\r\n";
	echo "\t\tbackground-image: url('".get_stylesheet_directory_uri()."/images/logo-narrow-186.png');\r\n";
	echo "\t\t-webkit-background-size: 186px 100px;\r\n";
	echo "\t\tbackground-size: 186px 100px;\r\n";
	echo "\t\theight: 100px;\r\n";
	echo "\t\twidth: 186px;\r\n";
	echo "\t}\r\n";
	echo "</style>";
}