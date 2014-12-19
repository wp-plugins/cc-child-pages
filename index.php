<?php
/*
Plugin Name: CC Child Pages
Plugin URI: http://ccchildpages.ccplugins.co.uk/
Description: Show links to child pages
Author: Caterham Computing
Text Domain: cc-child-pages
Domain Path: /languages
Version: 1.19
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

// Dashboard feed - for future release
// add_action( 'wp_dashboard_setup', 'ccchildpages::dashboard_widgets');

// TinyMCE Buttons
add_action( 'init', 'ccchildpages::tinymce_buttons' );

// Show excerpt for pages ...
add_action ( 'init', 'ccchildpages::show_page_excerpt');

// Add action links for plugin
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ccchildpages::plugin_action_links' );

// Set default option values
register_activation_hook(__FILE__, 'ccchildpages::options_activation');

// Regsiter settings
add_action('admin_init', 'ccchildpages::register_options');

// Add options page
add_action('admin_menu', 'ccchildpages::options_menu');

/*EOF*/