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

	public static function show_child_pages( $atts ) {
		$a = shortcode_atts( array(
			'id'	=> get_the_ID(),
			'cols'	=> '3',
			'skin'	=> 'simple',
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
			default:
				$class = 'twocol';
				$cols = 2;
		}
		
		switch ( $a['skin'] ) {
			default:
				$skin = 'simple';
		}
		
		$return_html = '<div class="ccchildpages ' . $class .' ' . $skin . ' ccclearfix">';
		
		$page_id = $a['id'];
				
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
			
//			$page_excerpt = wp_trim_words(strip_shortcodes(do_shortcode(get_the_content())),35);

			$page_excerpt = get_the_excerpt();
			
			$return_html .= '<p class="ccpages_excerpt">' . strip_tags($page_excerpt) . '</p>';
			
			$return_html .= '<p class="ccpages_more"><a href="' . $link . '" title="Read more...">Read more ...</a></p>';
			
			$return_html .= '</div>';
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
				0.1
			);
			wp_enqueue_style( 'ccchildpagescss' );
		}
	}
}

/*EOF*/