=== CC Child Pages ===

Plugin Name: CC Child Pages
Contributors: caterhamcomputing
Plugin URI: http://ccchildpages.ccplugins.co.uk/
Author URI: http://www.caterhamcomputing.net/
Donate Link: http://ccchildpages.ccplugins.co.uk/donate/
Requires at least: 4.0
Tested up to: 4.0
Stable tag: 1.1
Version: 1.1
Tags: child, pages, shortcode, sub-pages, subpages, sub-page, subpage

== Description ==

CC Child Pages is a simple plugin to show links to child pages via a shortcode.

Child Pages are displayed in responsive boxes, and include the page title, an excerpt and a "Read more..." link.

You can choose between 1, 2, 3 & 4 column layouts.

3 & 4 column layouts will resize to a 2 column layout on small devices to ensure that they remain readable.

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Using the shortcode ==

The simplest usage would be to use the shortcode with no parameters:

`[child_pages]`

This would show the Child Pages for the current page in 2 columns.

You can add the `cols` parameter to choose the number of columns:

`[child_pages cols="1"]`
`[child_pages cols="2"]`
`[child_pages cols="3"]`
`[child_pages cols="4"]`

... if `cols` is set to anything other than 2, 3 or 4 the value will be ignored.

You can also show the child pages of a specific page by adding the `ID` of the page as follows:

`[child_pages id="42"]`

You can now also use the `skin` parameter to choose a colour scheme for the Child Pages as follows:

`[child_pages skin="simple"]` (the default colour scheme)
`[child_pages skin="red"]`
`[child_pages skin="green"]`
`[child_pages skin="blue"]`

If you want to style the child page boxes yourself, you can also specify the `class` parameter. If used, this overrides the `span` parameter and adds the specified class name to the generated HTML:

`[child_pages class="myclass"]`

== Screenshots ==

== Changelog ==

= 1.1 =
* Added the `skin` parameter
* Added the `class` parameter

= 1.0 =
* Initial Release
