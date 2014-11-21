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
	const plugin_version = '1.11';
	
	public static function load_plugin_textdomain() {
		load_plugin_textdomain( 'cc-child-pages', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public static function show_child_pages( $atts ) {
		$a = shortcode_atts( array(
			'id'			=> get_the_ID(),
			'cols'			=> '3',
			'depth'			=> '1',
			'exclude'		=> '',
			'exclude_tree'	=> '',
			'skin'			=> 'simple',
			'class'			=> '',
			'list'			=> 'false',
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
				'sort_column'	=> 'menu_order'
			);
		
			$page_count = 0;		

			$return_html .= '<ul>';
						
			$page_list .= trim(wp_list_pages( $args ));
			
			if ( $page_list == '' ) return '';
			
			$return_html .= $page_list;
			
			$return_html .= '</ul>';
		}
		else {				
			$args = array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $page_id,
				'order'          => 'ASC',
				'orderby'			=> 'menu_order',
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
			
				$return_html .= '<h3>' . htmlentities(get_the_title()) . '</h3>';
				
				if ( $thumbs != FALSE ) {
					$thumb_attr = array(
						'class'	=> "cc-child-pages-thumb",
						'alt'	=> get_the_title(),
						'title'	=> get_the_title(),
					);
					
					$return_html .= get_the_post_thumbnail($id, $thumbs, $thumb_attr);
				}

				if ( has_excerpt() ) {
					$page_excerpt = get_the_excerpt();
				}
				else {
					$page_excerpt = strip_tags( get_the_content(), '<p><strong><em><b><i>' );
				}
				
				$words = ( intval($a['words']) > 0 ? intval($a['words']) : 55 );
				
				$page_excerpt = wp_trim_words( $page_excerpt, $words, '...' );
			
				$return_html .= '<p class="ccpages_excerpt">' . $page_excerpt . '</p>';
			
				$return_html .= '<p class="ccpages_more"><a href="' . $link . '" title="' . $more . '">' . $more . '</a></p>';
			
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
		add_filter( 'mce_external_plugins', 'ccchildpages::add_childpages_buttons' );
		add_filter( 'mce_buttons', 'ccchildpages::register_childpages_buttons' );
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
	 * Show Excerpt for Pages ...
	 */
	public static function show_page_excerpt () {
		add_post_type_support( 'page', 'excerpt' );
	}
	
	/*
	 * Show plugin links
	 */
	function plugin_action_links( $links ) {
		$links[] = '<a href="https://wordpress.org/support/view/plugin-reviews/cc-child-pages" target="_blank">Rate this plugin...</a>';
//		$links[] = '<a href="http://www.ccplugins.co.uk" target="_blank">More from CC Plugins</a>';
		return $links;
}
}

/*EOF*/