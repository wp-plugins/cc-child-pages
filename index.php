<?php
/*
Plugin Name: CC Child Pages
Plugin URI: http://ccchildpages.ccplugins.co.uk/
Description: Show links to child pages
Author: Tim lomas
Text Domain: cc-child-pages
Domain Path: /languages
Version: 1.5
Author URI: http://www.caterhamcomputing.net/
*/
include_once('includes/ccchildpages.php');

add_shortcode( 'child_pages', 'ccchildpages::show_child_pages' );
add_action( 'wp_enqueue_scripts', 'ccchildpages::enqueue_styles' );
add_action( 'plugins_loaded', 'ccchildpages::load_plugin_textdomain' );

/*EOF*/