<?php
/**
* Enqueue fonts
* 
*/
function bethel_enqueue_fonts() {
	wp_enqueue_style ('bethel-font-lato', get_stylesheet_directory_uri().'/fonts/lato.css', array(), CHILD_THEME_VERSION);
	//wp_enqueue_style ('bethel-font-bebas', get_stylesheet_directory_uri().'/fonts/bebas.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_style ('bethel-font-icons', get_stylesheet_directory_uri()."/fonts/bethel-icons.css", array(), CHILD_THEME_VERSION);
}

function bethel_admin_enqueue_fonts() {
	wp_enqueue_style ('bethel-font-icons', get_stylesheet_directory_uri()."/fonts/bethel-icons.css", array(), CHILD_THEME_VERSION);
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
		$string = "{$string}<br/><span class=\"subtitle\">{$title}</span>";
	}
	return $string;
}

function bethel_footer( $creds ) {
	return '<span class="footer-line-1"><span class="bethel-tree-icon"></span> &nbsp;<strong>Bethel Evangelical Church, Heol-y-nant, Clydach</strong></span><br/><span class="footer-line-2">Tel: 01792 828095 &nbsp;&nbsp;&nbsp; Registered charity: 1142690</span>';
}

function bethel_do_logo() {
	echo "<a href=\"".home_url()."\"><img src=\"".get_stylesheet_directory_uri()."/images/logo.png\" width=\"600\" height=\"139\" title=\"Bethel Evangelical Church, Clydach\" alt=\"Bethel Evangelical Church, Clydach\"/></a>";
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

function bethel_add_viewport() {
	echo "<meta name=\"viewport\" content=\"width=1200\">\r\n";
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

function bethel_add_admin_css() {
	echo <<<EOT
	<style type="text/css">
		#wpadminbar #wp-admin-bar-site-name>.ab-item:before {
			font-family: 'bethel-icons';
			content: "\\e600";
		}
	</style>
EOT;
}

function bethel_add_submenu_to_post() {
	global $post;
	$menu_items = get_menu_items_for_current_page();
	if ($menu_items) {
		echo '<ul class="bethel-subpages-nav">';
		foreach ($menu_items as $menu_item) {
			echo '<li'.($menu_item->object_id == $post->ID ? ' class="current-item"' : '').">";
			echo "<a href=\"{$menu_item->url}\">{$menu_item->title}</a>";
			echo '</li>';
		}
		echo '</ul>';
	}
}

function get_menu_items_for_current_page () {
	global $post;
	if (!$post->ID) {
		return;
	}
	$locations = get_nav_menu_locations();
	if (isset($locations['primary'])) {
		$pages = wp_get_nav_menu_items($locations['primary']);
		if ($pages) {
			$menu_parent = false;
			foreach ($pages as $page) {
				if ($page->object_id == $post->ID) {
					$menu_parent = $page->menu_item_parent;
				}
			}
			if ($menu_parent !== FALSE) {
				$items = array();
				foreach ($pages as $page) {
					if ($page->menu_item_parent == $menu_parent && $page->object == 'page') {
						$items[$page->menu_order] = $page;
					}
				}
				ksort($items);
				return $items;
			}
		}
	}
}

/**
* Adds the featured image to the top of pages (not stories)
*/
function bethel_add_image_to_pages() {
	global $post;
	if ($post) {
		$image_id = get_post_thumbnail_id ($post->ID);
		if ($image_id) {
			if ($post->post_type != 'bethel_stories') {
				$image = wp_get_attachment_image_src($image_id, 'bethel_supersize');
				if ($image) {
					if ($image[1] < 740) { //width
						$image[2] = round($image [2] / $image[1] * 740);
					}
					$image[2] = ($image[2] > 360) ? 360 : $image[2]; //height
					echo "<style type=\"text/css\">.entry-header { height: {$image[2]}px; background-image: url('{$image[0]}')}</style>";
					return;
				}
			}
		} else {
			echo "<style type=\"text/css\">.content .entry-header { margin: 35px -40px 75px -40px }</style>";
		}
	}
}

/**
* Adds the featured image to the top of stories
*/
function bethel_add_image_to_stories() {
	global $post;
	if ($post && $post->post_type=='bethel_stories') {
		echo "<div class=\"bethel-featured-image-wrapper\">";
		the_post_thumbnail('bethel_column_width');
		$caption = apply_filters ('bethel_featured_image_caption', '');
		if ($caption != '') {
			echo "<div class=\"bethel-featured-image-caption\">{$caption}</div>";
		}
		do_action ('bethel_after_featured_image');
		echo "</div>";
	}
}

function bethel_restrict_depth_of_primary_menu ($args) {
	$a=1;
	if ($args['theme_location'] == 'primary') {
		$args['depth'] = 3;
	}
	return $args;
}

function bethel_choose_image_sizes ($sizes) {
	$bethel_sizes = array 	('bethel_column_width' => 'Half-width',
							 'bethel_full_width' => 'Full-width',
							 'bethel_supersize' => 'Supersize',
							);
	return array_merge ($sizes, $bethel_sizes);
}