<?php
/**
* Enqueue fonts
* 
* Called by the wp_enqueue_scripts action
*/
function bethel_enqueue_fonts() {
	wp_enqueue_style ('bethel-font-lato', get_stylesheet_directory_uri().'/fonts/lato.css', array(), CHILD_THEME_VERSION);
	wp_enqueue_style ('bethel-font-icons', get_stylesheet_directory_uri()."/fonts/bethel-icons.css", array(), CHILD_THEME_VERSION);
}

/**
* Enqueue admin fonts
* 
* Called by the admin_enqueue_scripts action
*/
function bethel_admin_enqueue_fonts() {
	wp_enqueue_style ('bethel-font-icons', get_stylesheet_directory_uri()."/fonts/bethel-icons.css", array(), CHILD_THEME_VERSION);
}

/**
* Enqueue javascript
* 
* Called by the wp_enqueue_scripts action
*/
function bethel_add_frontend_javascript() {
    global $post;
    if (is_front_page()) {
        wp_enqueue_script('bethel-frontend', get_stylesheet_directory_uri().'/js/frontend.js', array('jquery'), '0.1', true);
        wp_localize_script('bethel-frontend', 'bethel', array('siteurl'=>site_url()));
    }
    if ((is_page() || is_single()) && (strpos ($post->post_content, '[gallery ') !== FALSE)) {
        wp_enqueue_script('jquery');
        add_action ('wp_print_footer_scripts', 'bethel_add_gallery_js_to_footer');
    }
}

/**
* Returns the default background settings
* 
* Called due to custom-background in add_theme_support
* 
*/
function bethel_get_default_background_args() {
	return array ('default-color' => '#f5f5f5',
				  'default-image' => get_stylesheet_directory_uri().'/images/background.jpg',
				  'default-repeat' => 'repeat'
	             );
}

/**
* Adds the filter to add subtitles to the main menu
* 
* Called by the genesis_after_header action (early priority)
*/
function bethel_filter_menu_items() {
	add_filter ('walker_nav_menu_start_el', 'bethel_add_menu_subtitles');
}

/**
* Removes filter that added subtitles to menus
* 
* Called by the genesis_after_header action (late priority)
*/
function bethel_stop_filtering_menu_items() {
	remove_filter ('walker_nav_menu_start_el', 'bethel_add_menu_subtitles');
}

/**
* Displays subtitles in the main menu
* 
* @param mixed $string
* @return string
*/
function bethel_add_menu_subtitles ($string) {
	if (substr($string, 3, 7) == 'title="') {
		$title = substr($string, 10, strpos($string, '"', 11)-10);
		$string = substr($string,0,-4)."<br/><span class=\"subtitle\">{$title}</span></a>";
	}
	return $string;
}

/**
* Displays the footer
* 
* Filters genesis_footer_creds_text
* 
* @param mixed $creds
* @return mixed
*/
function bethel_footer ($creds) {
	return '<span class="footer-line-1"><span class="bethel-tree-icon"></span> &nbsp;<strong>Bethel Evangelical Church, Heol-y-nant, Clydach</strong></span><br/><span class="footer-line-2">Tel: 01792 828095 &nbsp;&nbsp;&nbsp; Registered charity: 1142690</span>';
}

/**
* Displays the logo in the header
* 
* Called by the genesis_site_title action
*/
function bethel_do_logo() {
	echo "<a class=\"logo_header\" href=\"".home_url()."\"><img src=\"".get_stylesheet_directory_uri()."/images/logo.png\" width=\"600\" height=\"139\" title=\"Bethel Evangelical Church, Clydach\" alt=\"Bethel Evangelical Church, Clydach\"/></a>";
}

/**
* Adds code to the head, to display favicons and shortcut icons
* 
* Called by the genesis_meta action
*/
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

/**
* Resizes the viewport for mobile devices
* 
* Called by the genesis_meta action
*/
function bethel_add_viewport() {
	echo "<meta name=\"viewport\" content=\"width=1280\">\r\n";
}

/**
* Adds the Bethel log to the log in page
* 
* Called by the login_enqueue_scripts action
* 
*/
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

/**
* Adds custom CSS to the admin pages
* 
* Called by the admin_head action
*/
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

/**
* Adds the submenu with sister pages to the current post, if appropriate
* 
* Called by the genesis_entry_content action
*/
function bethel_add_submenu_to_post() {
	global $post;
	$menu_items = get_menu_items_for_current_page();
	if ($menu_items && sizeof($menu_items) > 1) {
		echo '<ul class="bethel-subpages-nav">';
		foreach ($menu_items as $menu_item) {
			echo '<li'.($menu_item->object_id == $post->ID ? ' class="current-item"' : '').">";
			echo "<a href=\"{$menu_item->url}\">{$menu_item->title}</a>";
			echo '</li>';
		}
		echo '</ul>';
	}
}

/**
* Returns an array of menu items for the current page
* 
* @return array
*/
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
					if ($page->menu_item_parent == $menu_parent && ($page->object == 'page' || $page->object == 'bethel_ministries')) {
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
			if ($post->post_type != 'bethel_stories' && $post->page_template != 'stories.php') {
				$image = wp_get_attachment_image_src($image_id, 'bethel_supersize');
				if ($image) {
					if ($image[1] < 800) { //width
						$image[2] = round($image [2] / $image[1] * 800);
					}
					$image[2] = ($image[2] > 400) ? 400 : $image[2]; //height
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
	if ($post && ($post->post_type=='bethel_stories' || $post->page_template == 'stories.php')) {
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

/**
* Restricts the dept of the primary menu to three levels (deeper levels are shown in the post itself)
* 
* Filters wp_nav_menu_args
* 
* @param array $args
* @return array
*/
function bethel_restrict_depth_of_primary_menu ($args) {
	$a=1;
	if ($args['theme_location'] == 'primary') {
		$args['depth'] = 3;
	}
	return $args;
}

/**
* Adds additional image sizes when editing a post
* 
* Filters image_size_names_choose
* 
* @param array $sizes
* @return array
*/
function bethel_choose_image_sizes ($sizes) {
	$bethel_sizes = array 	('bethel_narrow_column' => 'Narrow',
                             'bethel_column_width' => 'Half-width',
							 'bethel_full_width' => 'Full-width',
							 'bethel_supersize' => 'Supersize',
							);
	return array_merge ($sizes, $bethel_sizes);
}

/**
* Registers the themes widget areas
*/
function bethel_register_widget_areas() {
	unregister_sidebar( 'header-right' ); // Remove the right header widget area
	genesis_register_sidebar (array ('id' => 'header-right-top', 'name' => 'Header Right Top', 'description' => 'The upper widget to the right of the header image.'));	
	genesis_register_sidebar (array ('id' => 'footer-bottom', 'name' => 'Footer Bottom', 'description' => 'Full-width widget at the very bottom of the page.'));	
}

/**
* Outputs the top-right widget area
*/
function bethel_do_header_right_top() {
	genesis_widget_area ('header-right-top', array ('before' => '<div id="bethel-header-right-top">', 'after' => '</div>'));
}

/**
* Outputs the widget below the footer
*/
function bethel_do_footer_bottom() {
	genesis_widget_area ('footer-bottom', array ('before' => '<div id="bethel-header-right-bottom">', 'after' => '</div>'));
}

/**
* Add the page template to the global $post variable
* 
* Called by the template_redirect action
*/
function bethel_custom_template() {
    if (is_page()) {
        global $post;
        $post->page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    }
}

/**
* Handles the pullquote shortcode
*/
function bethel_pullquote ($atts, $content = NULL) {
    if (isset($atts['align']) && $atts['align']=='right') {
        $att_string = ' class="align-right"';
    } else {
        $att_string = '';
    }
    return "<aside{$att_string}><span class=\"left-quote\">&ldquo;</span>{$content}<span class=\"right-quote\">&rdquo;</span></aside>";
}

/**
* Adds javascript to the footer on gallery pages
* 
* Called on the wp_print_footer_scripts action
*/
function bethel_add_gallery_js_to_footer() {
    echo "<script type=\"text/javascript\">\r\n";
    include ('gallery.js.php');
    echo "</script>\r\n";
}

function bethel_add_gallery_filters() {
    global $post;
    if ((is_page() || is_single()) && (strpos ($post->post_content, '[gallery ') !== FALSE)) {
        add_filter ('body_class', 'bethel_add_gallery_to_body_class');
        add_filter ('shortcode_atts_gallery', 'bethel_filter_gallery_atts', 10, 3);
        add_action ('genesis_entry_footer', 'bethel_add_back_to_parent_link');
        //The following filters aren't really filtering. They're just convenient places to run our own code.
        add_filter ('gallery_style', 'bethel_add_filter_to_gallery_images'); // This filter runs during the gallery shortcode
        add_filter ('genesis_edit_post_link', 'bethel_remove_filter_from_gallery_images'); // This filter runs at the end of a post
    }
}

/**
* Adds the 'gallery' class to the body tag
* 
* Filters body_class
* 
* @param array $class
* @return array
*/
function bethel_add_gallery_to_body_class ($classes) {
    $classes [] = 'bethel-gallery';
    return $classes;
}

/**
* Adds a filter to gallery images
* 
* Filters gallery_style (or, more accurately, actions during the filter)
* 
* @param string $style
* @return string
*/
function bethel_add_filter_to_gallery_images ($style) {
    add_filter ('wp_get_attachment_image_attributes', 'bethel_filter_image_attributes_for_gallery', 10, 2);
    return $style;
}

/**
* Removes the filter from gallery images
* 
* Filters genesis_edit_post_link (or, more accurately, actions during the filter)
* 
* @param boolean $edit
* @return boolean
*/
function bethel_remove_filter_from_gallery_images ($edit) {
    remove_filter ('wp_get_attachment_image_attributes', 'bethel_filter_image_attributes_for_gallery', 10, 2);
    return $edit;
}

/**
* Filters the image attributes in galleries
* 
* @param mixed $attr
* @param mixed $attachment
*/
function bethel_filter_image_attributes_for_gallery ($attr, $attachment) {
    $attr ['id'] = "gallery-image-id-{$attachment->ID}";
    $attr ['class'] .= ' gallery-thumbnail';
    return $attr;
}

function bethel_filter_gallery_atts ($out, $pairs, $atts) {
    $ids = $out ['include'];
    if ($ids) {
        global $bethel_gallery_urls;
        $ids = explode (',', $ids);
        foreach ($ids as $id) {
            $urls["i{$id}"] = wp_get_attachment_image_src($id, 'bethel_supersize');
            $urls["i{$id}"] = $urls["i{$id}"][0];
        }
        $bethel_gallery_urls = json_encode ($urls);
    }
    $out['link'] = 'none';
    return $out;
}

function bethel_add_back_to_parent_link() {
    global $post;
    if ((is_single() || is_page()) && $post->post_parent) {
        $parent = get_post($post->post_parent);
        echo "<a href=\"".get_permalink($post->post_parent)."\">&laquo Back to {$parent->post_title}</a>";
    }
}

function bethel_gallery_list($atts) {
    global $post;
    if (!$post) {
        return;
    }
    $class = isset($atts['class']) ? " class=\"{$atts['class']}\"" : ''; 
    $child_pages = get_posts (array('post_type' => $post->post_type, 'post_parent' => $post->ID, 'order_by' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1));
    if ($child_pages) {
        $output =  "<ul class=\"gallery_list\">";
        foreach ($child_pages as $page) {
            $thumbnail = wp_get_attachment_image_src (get_post_thumbnail_id($page->ID), 'bethel_narrow_column');
            if (!$thumbnail) {
                $thumbnail = wp_get_attachment_image_src (get_post_thumbnail_id($post->ID), 'bethel_narrow_column');
            }
            $output .= "<li{$class}><a style=\"background-image:url('".$thumbnail[0]."')\" href=\"".get_permalink($page->ID)."\"><span class=\"title\">{$page->post_title}</span></a></li>";
        }
        $output .= "</ul>";
        return $output;
    }
}