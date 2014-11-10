<?php
/*
Plugin Name: CC Child Pages
Plugin URI: http://ccchildpages.ccplugins.co.uk/
Description: Show links to child pages
Author: Caterham Computing
Text Domain: cc-child-pages
Domain Path: /languages
Version: 1.7
Author URI: http://www.caterhamcomputing.net/
*/
include_once('includes/ccchildpages.php');

add_shortcode( 'child_pages', 'ccchildpages::show_child_pages' );
add_action( 'wp_enqueue_scripts', 'ccchildpages::enqueue_styles' );
add_action( 'plugins_loaded', 'ccchildpages::load_plugin_textdomain' );

include_once('includes/ccchildpages_widget.php');
// register widget
function register_ccchildpages_widget() {
    register_widget( 'ccchildpages_widget' );
}
add_action( 'widgets_init', 'register_ccchildpages_widget' );

/*EOF*/