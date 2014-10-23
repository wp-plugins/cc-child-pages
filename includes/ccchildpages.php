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
	const plugin_version = 1.2;

	public static function show_child_pages( $atts ) {
		$a = shortcode_atts( array(
			'id'	=> get_the_ID(),
			'cols'	=> '3',
			'skin'	=> 'simple',
			'class'	=> '',
			'list'	=> 'false',
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
			
				$return_html .= '<ul>';
			
				$return_html .= '<li><a href="' . $link . '" title="' . htmlentities(get_the_title()) . '">' . htmlentities(get_the_title()) . '</a></li>';
			
				$return_html .= '</ul>';
			}
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

				$page_excerpt = get_the_excerpt();
			
				$return_html .= '<p class="ccpages_excerpt">' . strip_tags($page_excerpt) . '</p>';
			
				$return_html .= '<p class="ccpages_more"><a href="' . $link . '" title="Read more...">Read more ...</a></p>';
			
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
				plugin_version
			);
			wp_enqueue_style( 'ccchildpagescss' );
		}
	}
}

/*EOF*/