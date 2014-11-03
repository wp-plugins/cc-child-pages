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
	const plugin_version = '1.5';
	
	public static function load_plugin_textdomain() {
		load_plugin_textdomain( 'cc-child-pages', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public static function show_child_pages( $atts ) {
		$a = shortcode_atts( array(
			'id'	=> get_the_ID(),
			'cols'	=> '3',
			'skin'	=> 'simple',
			'class'	=> '',
			'list'	=> 'false',
			'thumbs'	=> 'false',
			'more'	=> __('Read more ...', 'cc-child-pages'),
		), $atts );
		
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
			$thumbs = TRUE;
		}
		else {
			$thumbs = FALSE;
		}
		
		$more = htmlentities(trim($a['more']));
		
		// if class is specified, substitue value for skin class
		if ( $a['class'] != '' ) $skin = trim(htmlentities($a['class']));
		
		$return_html = '<div class="ccchildpages ' . $class .' ' . $skin . ' ccclearfix">';

		$page_id = $a['id'];

		if ( $list ) {	
			$args = array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $page_id,
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'post_status' => 'publish'
			);

			$parent = new WP_Query( $args );
		
			if ( ! $parent->have_posts() ) return '';
		
			$page_count = 0;		

			$return_html .= '<ul>';

			while ( $parent->have_posts() ) {
			
				$parent->the_post();
			
				$page_count++;
			
				if ( $page_count%$cols == 0 ) {
					$page_class = ' cclast';
				}
				else if ( $page_count%$cols == 1 ) {
					$page_class = ' ccfirst';
				}
				else {
					$page_class = '';
				}
			
				$link = get_permalink(get_the_ID());
						
				$return_html .= '<li><a href="' . $link . '" title="' . htmlentities(get_the_title()) . '">' . htmlentities(get_the_title()) . '</a></li>';
			
			}
			$return_html .= '</ul>';
		}
		else {				
			$args = array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post_parent'    => $page_id,
				'order'          => 'ASC',
				'orderby'        => 'menu_order',
				'post_status' => 'publish'
			);

			$parent = new WP_Query( $args );
		
			if ( ! $parent->have_posts() ) return '';
		
			$page_count = 0;		

			while ( $parent->have_posts() ) {
			
				$parent->the_post();
			
				$page_count++;
			
				if ( $page_count%$cols == 0 ) {
					$page_class = ' cclast';
				}
				else if ( $page_count%$cols == 1 ) {
					$page_class = ' ccfirst';
				}
				else {
					$page_class = '';
				}
			
				$link = get_permalink(get_the_ID());
			
				$return_html .= '<div class="ccchildpage' . $page_class . '">';
			
				$return_html .= '<h3>' . htmlentities(get_the_title()) . '</h3>';
				
				if ( $thumbs ) {
					$thumb_attr = array(
						'class'	=> "cc-child-pages-thumb",
						'alt'	=> get_the_title(),
						'title'	=> get_the_title(),
					);
					
					$return_html .= get_the_post_thumbnail(get_the_ID(), 'medium', $thumb_attr);
				}

				$page_excerpt = get_the_excerpt();
			
				$return_html .= '<p class="ccpages_excerpt">' . strip_tags($page_excerpt) . '</p>';
			
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
}

/*EOF*/