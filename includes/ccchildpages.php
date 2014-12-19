<?php
/**
* ccchildpages
*
*/

class ccchildpages {

	// Used to uniquely identify this plugin's menu page in the WP manager
	const admin_menu_slug = 'ccchildpages';
	
	// Plugin name
	const plugin_name = 'CC Child Pages';

	// Plugin version
	const plugin_version = '1.19';
	
	public static function load_plugin_textdomain() {
		load_plugin_textdomain( 'cc-child-pages', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public static function show_child_pages( $atts ) {
/*		// Include global DB object for video_thumbs option
		global $wpdb; */

		$a = shortcode_atts( array(
			'id'			=> get_the_ID(),
			'cols'			=> '3',
			'depth'			=> '1',
			'exclude'		=> '',
			'exclude_tree'	=> '',
			'skin'			=> 'simple',
			'class'			=> '',
			'orderby'		=> 'menu_order',
			'order'			=> 'ASC',
			'link_titles'	=> 'false',
			'title_link_class' => 'ccpage_title_link',
			'hide_more'		=> 'false',
			'hide_excerpt'	=> 'false',
			'truncate_excerpt'	=> 'true',
			'list'			=> 'false',
			'link_thumbs'	=> 'false',
			'thumbs'		=> 'false',
			'more'			=> __('Read more ...', 'cc-child-pages'),
			'words'	=> 55,
		), $atts );
		
		$depth = intval($a['depth']);
		
		switch ( $a['cols'] ) {
			case '4':
				$class = 'fourcol';
				$cols = 4;
				break;
			case '3':
				$class = 'threecol';
				$cols = 3;
				break;
			case '1':
				$class = 'onecol';
				$cols = 1;
				break;
			default:
				$class = 'twocol';
				$cols = 2;
		}
		
		switch ( $a['skin'] ) {
			case 'red':
				$skin = 'ccred';
				break;
			case 'green':
				$skin = 'ccgreen';
				break;
			case 'blue':
				$skin = 'ccblue';
				break;
			default:
				$skin = 'simple';
		}
		
		if ( strtolower(trim($a['list'])) == 'true' ) {
			$list = TRUE;
		}
		else {
			$list = FALSE;
		}
		
		if ( strtolower(trim($a['truncate_excerpt'])) == 'true' ) {
			$truncate_excerpt = TRUE;
		}
		else {
			$truncate_excerpt = FALSE;
		}
		
		if ( strtolower(trim($a['link_titles'])) == 'true' ) {
			$link_titles = TRUE;
			$title_link_class = trim($a['title_link_class']);
		}
		else {
			$link_titles = FALSE;
		}
		
		if ( strtolower(trim($a['hide_more'])) == 'true' ) {
			$hide_more = TRUE;
		}
		else {
			$hide_more = FALSE;
		}
		
		if ( strtolower(trim($a['hide_excerpt'])) == 'true' ) {
			$hide_excerpt = TRUE;
		}
		else {
			$hide_excerpt = FALSE;
		}
		
		if ( $a['order'] == 'ASC' ) {
			$order = 'ASC';
		}
		else {
			$order = 'DESC';
		}

		switch ( $a['orderby'] ) {
			case 'post_id':
			case 'id':
			case 'ID':
				$orderby = 'ID';
				break;
			case 'post_author':
			case 'author':
				if ( $list ) {
					$orderby = 'post_author';
				}
				else {
					$orderby = 'author';
				}
				break;
			case 'post_date':
			case 'date':
				if ( $list ) {
					$orderby = 'post_date';
				}
				else {
					$orderby = 'date';
				}
				break;
			case 'post_modified':
			case 'modified':
				if ( $list ) {
					$orderby = 'post_modified';
				}
				else {
					$orderby = 'modified';
				}
				break;
			case 'post_title':
			case 'title':
				if ( $list ) {
					$orderby = 'post_title';
				}
				else {
					$orderby = 'title';
				}
				break;
			case 'post_name':
			case 'name':
			case 'slug':
				if ( $list ) {
					$orderby = 'post_name';
				}
				else {
					$orderby = 'name';
				}
				break;
			default:
				$orderby = 'menu_order';
		}

		
		if ( strtolower(trim($a['link_thumbs'])) == 'true' ) {
			$link_thumbs = TRUE;
		}
		else {
			$link_thumbs = FALSE;
		}
		
		if ( strtolower(trim($a['thumbs'])) == 'true' ) {
			$thumbs = 'medium';
		}
		else if ( strtolower(trim($a['thumbs'])) == 'false' ) {
			$thumbs = FALSE;
		}
		else {
			$thumbs = strtolower(trim($a['thumbs']));
			
			$img_sizes = get_intermediate_image_sizes();
			$img_sizes[] = 'full'; // allow "virtual" image size ...
			
			if ( ! in_array( $thumbs, $img_sizes ) ) $thumbs = 'medium';
		}
		
		$more = htmlentities(trim($a['more']));
		
		// if class is specified, substitue value for skin class
		if ( $a['class'] != '' ) $skin = trim(htmlentities($a['class']));
		
		$return_html = '<div class="ccchildpages ' . $class .' ' . $skin . ' ccclearfix">';

		$page_id = $a['id'];

		if ( $list ) {	
			$args = array(
				'title_li'		=> '',
				'child_of'		=> $page_id,
				'echo'			=> 0,
				'depth'			=> $depth,
				'exclude'		=> $a['exclude'],
				'sort_order'	=> $order,
				'sort_column'	=> $orderby
			);
		
			$page_count = 0;		

			$return_html .= '<ul>';
						
			$page_list = trim(wp_list_pages( $args ));
			
			if ( $page_list == '' ) return '';
			
			$return_html .= $page_list;
			
			$return_html .= '</ul>';
		}
		else {				
			$args = array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $page_id,
				'order'          => $order,
				'orderby'			=> $orderby,
				'post__not_in'		=> explode(',', $a['exclude']),
				'post_status'		=> 'publish'
			);

			$parent = new WP_Query( $args );
		
			if ( ! $parent->have_posts() ) return '';
		
			$page_count = 0;

			while ( $parent->have_posts() ) {
			
				$parent->the_post();
				
				$id = get_the_ID();
			
				$page_count++;
			
				if ( $page_count%$cols == 0 && $cols > 1) {
					$page_class = ' cclast';
				}
				else if ( $page_count%$cols == 1 && $cols > 1 ) {
					$page_class = ' ccfirst';
				}
				else {
					$page_class = '';
				}

				if ( $page_count%2 == 0  ) {
					$page_class .= ' cceven';
				}
				else {
					$page_class .= ' ccodd';
				}
				
				$page_class .= ' ccpage-count-' . $page_count;
				$page_class .= ' ccpage-id-' . $id;
				$page_class .= ' ccpage-' . self::the_slug($id);
			
				$link = get_permalink($id);
			
				$return_html .= '<div class="ccchildpage' . $page_class . '">';
			
				if ( ! $link_titles ) {
					$return_html .= '<h3>' . get_the_title() . '</h3>';
				}
				else {
					$return_html .= '<h3 class="ccpage_linked_title"><a class="' . $title_link_class . '" href="' . $link . '" title="' . get_the_title() . '">' . get_the_title() . '</a></h3>';
				}
				
				if ( $thumbs != FALSE ) {
					$thumb_attr = array(
						'class'	=> "cc-child-pages-thumb",
						'alt'	=> get_the_title(),
						'title'	=> get_the_title(),
					);
					
					// Check whether Video Thumbnail plugin is installed.
					// If so, make sure that thumnail is generated.
					if ( class_exists('Video_Thumbnails') && function_exists( 'get_video_thumbnail' ) ) {
						// Call get_video_thumbnail to generate video thumbnail
						$video_img = get_video_thumbnail($id);
					}
					
					if ( $link_thumbs ) $return_html .= '<a class="ccpage_linked_thumb" href="' . $link . '" title="' . get_the_title() . '">';

					$return_html .= get_the_post_thumbnail($id, $thumbs, $thumb_attr);
					
					if ( $link_thumbs ) $return_html .= '</a>';
				}


				if ( ! $hide_excerpt ) {
					$words = ( intval($a['words']) > 0 ? intval($a['words']) : 55 );
				
					if ( has_excerpt() ) {
						$page_excerpt = get_the_excerpt();
						if ( str_word_count(strip_tags($page_excerpt) ) > $words && $truncate_excerpt ) $page_excerpt = wp_trim_words( $page_excerpt, $words, '...' );
					}
					else {
						$page_excerpt = strip_tags( do_shortcode( get_the_content() ) );
						if ( str_word_count(strip_tags($page_excerpt)) > $words ) $page_excerpt = wp_trim_words( $page_excerpt, $words, '...' );
					}
				
					$return_html .= '<p class="ccpages_excerpt">' . $page_excerpt . '</p>';
				}
			
				if ( ! $hide_more ) $return_html .= '<p class="ccpages_more"><a href="' . $link . '" title="' . $more . '">' . $more . '</a></p>';
			
				$return_html .= '</div>';
			}
		
		}	

		$return_html .= '</div>';
		
		wp_reset_query();
		
		return $return_html;
	}
	
	public static function enqueue_styles() {
		$css_file = plugins_url( 'css/styles.css' , __FILE__ );
		if ( !is_admin() ) { 
			wp_register_style(
				'ccchildpagescss',
				$css_file,
				false,
				self::plugin_version
			);
			wp_enqueue_style( 'ccchildpagescss' );
		}
	}

	private static function the_slug($id) {
		$post_data = get_post($id, ARRAY_A);
		$slug = $post_data['post_name'];
		return $slug; 
	}
	
	public static function dashboard_widgets() {
		if ( current_user_can( 'update_plugins' ) ) {
			wp_add_dashboard_widget('cc-child-pages-dashboard', 'CC Child Pages', 'ccchildpages::dashboard_widget_feed');
		}
	}
	
	public static function dashboard_widget_feed() {
		$content = file_get_contents('http://ccplugins.co.uk/feed/');
		$x = new SimpleXmlElement($content);
     
		echo '<ul>';
     
		foreach($x->channel->item as $entry) {
			echo '<li><a href="' . $entry->link . '" title="' . $entry->title . '" target="_blank">' . $entry->title . '</a></li>';
		}
		echo '</ul>';
	}
	
	public static function tinymce_buttons() {
		if ( $options = get_option('cc_child_pages') ) {
			if ( empty( $options['show_button'] ) ) {
				// undefined - so set to true for backward compatibility
				$show_button = TRUE;
			}
			else if ( $options['show_button'] == 'true' ) {
				$show_button = TRUE;
			}
			else {
				$show_button = FALSE;
			}
		}
		else {
			$show_button = TRUE;
		}
		
		if ( $show_button ) {
			add_filter( 'mce_external_plugins', 'ccchildpages::add_childpages_buttons' );
			add_filter( 'mce_buttons', 'ccchildpages::register_childpages_buttons' );
		}
	}
	
	public static function add_childpages_buttons ( $plugin_array ) {
		$plugin_array['ccchildpages'] = plugins_url( 'js/ccchildpages-plugin.js' , __FILE__ );
		return $plugin_array;
	}
	
	public static function register_childpages_buttons ( $buttons ) {
		array_push( $buttons, 'ccchildpages');
		return $buttons;
	}
	
	/*
	 * Add options page ...
	 */
	
	// Set default values on activation ...
	public static function options_activation () {
		$options = array();
		$options['show_button'] = 'true';
		
		add_option('cc_child_pages', $options, '', 'yes');
	}
	 
	// Register settings ...
	public static function register_options () {
		register_setting('cc_child_pages', 'cc_child_pages');
	}
	
	// Add submenu
	public static function options_menu () {
		add_options_page('CC Child Pages', 'CC Child Pages', 'manage_options', 'cc-child-pages', 'ccchildpages::options_page');
	}
	
	// Display options page
	public static function options_page () {
?>
<div class="wrap">
	<form method="post" id="cc_child_page_form" action="options.php">
		<?php
			$show_button = FALSE;

			settings_fields('cc_child_pages');
			
			if ( $options = get_option('cc_child_pages') ) {
				if ( empty( $options['show_button'] ) ) {
					// undefined - so set to true for backward compatibility
					$show_button = TRUE;
				}
				else if ( $options['show_button'] == 'true' ) {
					$show_button = TRUE;
				}
			}
			else {
				$show_button = TRUE;
			}
		?>
		<h2><?php _e('CC Child Pages options', 'cc-child-pages' ) ?></h2>
		<p><label>Add button to the visual editor: <input type="radio" name="cc_child_pages[show_button]" value="true" <?php checked(TRUE,$show_button) ?> > Yes <input type="radio" name="cc_child_pages[show_button]" value="false" <?php checked(FALSE,$show_button) ?> > No</label></p>
		<p class="submit"><input  type="submit" name="submit" class="button-primary" value="Update Options" /></p>
	</form>
</div>
<?php
	}
	
	/*
	 * Show Excerpt for Pages ...
	 */
	public static function show_page_excerpt () {
		add_post_type_support( 'page', 'excerpt' );
	}
	
	/*
	 * Show plugin links
	 */
	public static function plugin_action_links( $links ) {
		$links[] = '<a href="https://wordpress.org/support/view/plugin-reviews/cc-child-pages" target="_blank">Rate this plugin...</a>';
//		$links[] = '<a href="http://www.ccplugins.co.uk" target="_blank">More from CC Plugins</a>';
		return $links;
}
}

/*EOF*/