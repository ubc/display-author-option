=== Plugin Name ===
Contributors: enej, ctlt-dev, ubcdev
Tags: settings, author, reading
Requires at least: 3.4.1
Tested up to: 2.1
Stable tag: 1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin enables you do overwrite how the author is being displayed. By overwriting the the_author filter. 

== Description ==

You can choose how the author is being displayed without changing the theme. 

You can currently choose from these options:
* Default - What the user selected to display publicly
* First Name Last Name 
* Last Name First Name 
* Nickname 
* Username 
* First Name 
* Last Name 

== Installation ==

The usual WordPress install. 

e.g.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently Asked Questions ==

= Where are the settings located for the plugin?  =

You can find them under 

Dashboard > Settings > Reading 


== Screenshots ==
1. A view at the settings.

== Changelog ==

= 1.0 =
* Initial Release
