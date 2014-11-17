=== CC Child Pages ===

Plugin Name: CC Child Pages
Contributors: caterhamcomputing
Plugin URI: http://ccchildpages.ccplugins.co.uk/
Author URI: http://www.caterhamcomputing.net/
Donate Link: http://ccchildpages.ccplugins.co.uk/donate/
Requires at least: 4.0
Tested up to: 4.0
Stable tag: 1.8
Version: 1.8
Tags: child pages widget, child pages shortcode, child pages, child page, shortcode, widget, list, sub-pages, subpages, sub-page, subpage, sub page, responsive, child-page, child-pages, childpage, childpages

Adds a responsive shortcode to list child pages. Pre-styled or specify your own CSS class for custom styling. Includes child pages widget.

== Description ==

CC Child Pages is a simple plugin to show links to child pages via a shortcode.

Child Pages are displayed in responsive boxes, and include the page title, an excerpt and a "Read more..." link.

You can choose between 1, 2, 3 & 4 column layouts.

3 & 4 column layouts will resize to a 2 column layout on small devices to ensure that they remain readable.

= CC Child Pages widget =

**CC Child Pages now also includes a widget for displaying child pages within your sidebars.**

The widget can be set to show the children of the current page or a specific page.

Pages can be sorted by their menu order, title or ID. You can also select the depth of pages to be displayed.

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

= Using the shortcode =

The simplest usage would be to use the shortcode with no parameters:

`[child_pages]`

This would show the Child Pages for the current page in 2 columns.

You can add the `cols` parameter to choose the number of columns:

`[child_pages cols="1"]`
`[child_pages cols="2"]`
`[child_pages cols="3"]`
`[child_pages cols="4"]`

... if `cols` is set to anything other than 1, 2, 3 or 4 the value will be ignored.

You can also show the child pages of a specific page by adding the `ID` of the page as follows:

`[child_pages id="42"]`

If you want to prefer to use text other than the standard "Read more ..." to link to the pages, this can be specified with the `more` parameter:

`[child_pages more="More..."]`

You can display a thumbnail of the featured image for each page (if set) by setting the `thumbs` to `"true"`:

`[child_pages thumbs="true"]`

You can limit the length of the excerpt by specifying the `words` parameter:

`[child_pages words="10"]`

You can now also use the `skin` parameter to choose a colour scheme for the Child Pages as follows:

`[child_pages skin="simple"]` (the default colour scheme)
`[child_pages skin="red"]`
`[child_pages skin="green"]`
`[child_pages skin="blue"]`

If you want to style the child page boxes yourself, you can also specify the `class` parameter. If used, this overrides the `span` parameter and adds the specified class name to the generated HTML:

`[child_pages class="myclass"]`

Finally, you can also display just an unordered list (`<ul>`) of child pages by adding the `list` parameter. In this case, all other parameters are ignored **except for `class` and `id`**.

`[child_pages list="true"]`

== Screenshots ==

1. One column: `[child_pages cols="1"]`
2. Two columns (default): `[child_pages]` or `[child_pages cols="2"]`
3. Three columns: `[child_pages cols="3"]`
4. Four columns: `[child_pages cols="4"]`
5. Skin for Red colour schemes: `[child_pages skin="red"]`
6. Skin for Green colour schemes: `[child_pages skin="green"]`
7. Skin for Blue colour schemes: `[child_pages skin="blue"]`
8. Custom class defined for custom styling: `[child_pages class="myclass"]`
9. Show child pages as a list: `[child_pages list="true"]`
10. Using featured images as thumbnails: `[child_pages thumbs="true"]`
11. Limit word count of excerpt: `[child_pages words="10"]`
12. CC Child Pages widget options

== Changelog ==

= 1.8 =
* CC Child Pages widget enhanced to allow display of children of current page or a specific page
* CC Child Pages widget enhanced to allow depth to be specified

= 1.7 =
* Changed plugin author to show business name (Caterham Computing)
* Added CC Child Pages widget
* Added various new classes to help with custom CSS styling

= 1.6 =
* Added the `words` parameter. When set to a value greater than 0, the number of words in the excerpt will be trimmed if greater than the specified value.

= 1.5 =
* Added the `thumbs` parameter. If set to `"true"`, the featured image (if set) of a page will be shown.

= 1.4 =
* Added `more` parameter to override standard "Read more ..." text
* Internationalisation ...

= 1.3 =
* Corrected small error when using `list` parameter

= 1.2 =
* Added the `list` parameter

= 1.1 =
* Added the `skin` parameter
* Added the `class` parameter

= 1.0 =
* Initial Release

== Upgrade Notice ==

= 1.7 =
Added new CC Child Pages Widget. Added lots of new classes to help with custom CSS styling.

