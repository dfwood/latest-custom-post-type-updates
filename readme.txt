=== Latest Custom Post Type Updates ===
Contributors:      dfwood90
Plugin Name:       Latest Custom Post Type Updates
Plugin URI:        http://technicalmastermind.com/wordpress-plugins/latest-custom-post-type-updates/
Tags:              widget, custom post type, latest updates, latest post, latest posts, latest custom posts, latest, filter posts, filter, filter custom posts, filter custom post types, widget-only
Author URI:        http://davidwood.ninja/
Author:            David Wood
Donate link:       http://technicalmastermind.com/donate/
License:           GPLv3
Requires at least: 4.4
Tested up to:      4.4
Stable tag:        2.0.0

Simple widget to display the latest posts from any post type! Has several advanced options as well!

== Description ==
A simple widget that allows quick and easy display of posts from (nearly) any post type. It also has a set of advanced features:

* Ability to show posts from multiple post types, in one widget
* Can sort results by one or more criteria
* Can display the date in any format you want
* Developer filters for even more customization of output (requires use of PHP code)

= Notice for versions older than 2.0 =
I am not supporting versions older than 2.0 and the 2.0 release does not migrate widgets from older versions.

= A word on support and additional features =
Due to time constraints, I am not able to keep up with this plugin as much as I would like. If you want to help keep it up to date, feel free to create a pull request on the [GitHub repo](https://github.com/dfwood90/latest-custom-post-type-updates)!

== Installation ==
1. Copy the entire "latest-custom-post-type-updates" folder into your wp-content/plugins folder.
2. Activate the plugin.
3. Add the widget to a widget area and select your options.
4. See the latest post updates on any page!

== Frequently Asked Questions ==
= Can you add 'some feature' to the plugin? =
I will only add features to the plugin that I deem as beneficial to my original purpose of the plugin and are general enough that they can be used by others in various situations. Also, due to time constraints, I may not have the time to add the feature myself (or it may take a long time). If you know how to code, feel free to create a pull request on my [GitHub repo](https://github.com/dfwood90/latest-custom-post-type-updates) and I will review it and merge it in if I see it as beneficial. Please follow [WordPress coding standards](https://make.wordpress.org/core/handbook/best-practices/coding-standards/) when formatting code!

tldr; I probably won't unless you write it yourself and do a pull request on the [GitHub repo](https://github.com/dfwood90/latest-custom-post-type-updates).

= This plugin used to do "X", why doesn't it do that anymore? =
When I rewrote the plugin, I tried to add support for new WordPress features that weren't available at the time previous versions were written. During that process, I tried to think through the best way to handle all the features and I decided some features would not be "officially" supported anymore. Some of them may make their way back into the plugin in the future while others can be added back via WordPress filters. Everything that was possible before should be possible now, but some of the older features now require some coding (since I am not "officially" supporting them).

tldr; Because I took that feature out. The new filters can replicate that feature with some code.

== Screenshots ==
TODO!
1. The widget configuration options
2. The widget displaying the latest posts in a custom post type
3. Advanced configuration options

== WP Filters ==
= `lcptu_wrapper_tag` =
Allows changing of the wrapper tag that wraps all posts in the widget. By default it is a `<ul>` tag. Passes `$tag` (string, default is "ul") and `$sidebar_id` (string, id of the sidebar widget is being output in).

= `lcptu_single_wrapper_tag` =
Allows changing of the wrapper tag on individual posts in the widget. By default it is a `<li>` tag. Passes `$tag` (string, default is "li") and `$sidebar_id` (string, id of the sidebar widget is being output in).

= `lcptu_single_wrapper_classes` =
Runs during the loop. Allows changing the CSS classes applied to the wrapper of individual posts in the widget. Passes `$classes` (array, CSS classes that will be output) and `$sidebar_id` (string, id of the sidebar widget is being output in).

= `lcptu_single_content_html` =
Runs during the loop. Allows filtering the HTML markup for individual posts in the widget. Does not include the wrapper tag. Passes `$content` (string, HTML that will be output), `$sidebar_id` (string, id of the sidebar widget is being output in), and `$recent_posts` (WP_Query object containing posts that will be output in the widget).

== Upgrade Notice ==
= 2.0.0 =
MAJOR UPDATE! WILL REMOVE EXISTING WIDGETS (from this plugin)! This is a complete rewrite and overhaul to make everything more intuitive and clean. Consider this to NOT be backwards compatible.
= 1.3.0 =
REQUIRES JAVASCRIPT & WORDPRESS 3.3+! Major update adding support for several requested features.
= 1.2.1 =
Added the ability to define custom text that displays only when there are no posts of the selected post type. Otherwise it displays nothing.
= 1.2 =
Added ability to restrict displayed posts by taxonomy tags/categories. This allows for displaying posts that are in, not in, or in all of the selected taxonomy tags/categories.
= 1.1 =
Added in missing closing UL tag
= 1.0 =
Initial plugin release

== Changelog ==
= 2.0.0 =
* COMPLETE REWRITE
* Will NOT migrate existing widgets created by older versions of this plugin! (older than 2.0)
* Changed the filename of the base plugin file! If you are upgrading you may need to reactivate the plugin!
* Added some filters! You can now edit almost everything through PHP code.
= 1.3.0 =
* NOW REQUIRES JavaScript and WordPress 3.3+
* Added excerpt, thumbnail, sorting, and multiple post type support
* Can now specify custom classes
* Several core improvements
= 1.2.1 =
* Added the ability to define custom text that displays only when there are no posts of the selected post type. Otherwise it displays nothing.
= 1.2 =
* Added ability to restrict displayed posts by taxonomy tags/categories.
* Allows for displaying posts that are in, not in, or in all of the selected taxonomy tags/categories.
= 1.1 =
* Added in missing closing UL tag
= 1.0 =
* Initial plugin release