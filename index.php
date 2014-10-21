<?php
/*
Plugin Name: CC Child Pages
Plugin URI: http://ccchildpages.ccplugins.co.uk/
Description: Show links to child pages
Author: Tim lomas
Version: 1.1
Author URI: http://www.caterhamcomputing.net/
*/
include_once('includes/ccchildpages.php');

add_shortcode( 'child_pages', 'ccchildpages::show_child_pages' );
add_action( 'wp_enqueue_scripts', 'ccchildpages::enqueue_styles' );

/*EOF*/