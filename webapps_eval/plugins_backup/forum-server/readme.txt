===WP Forum Server ===
Author: VastHTML
Author URI: http://lucidcrew.com/
Donate link: http://vasthtml.com/
Plugin URI: http://vasthtml.com/js/wordpress-forum-server/
Tags: forum, integrated, bbpress
Requires at least: 2.6
Tested up to: 3.0.3
Stable tag: 1.6.5

This Wordpress plugin is a complete forum system for your wordpress blog.

== Description ==

WP Forum Server : A complete forum system for your wordpress blog. 
The forum is a plugin, so no additional work is needed to integrate it into your site.

WP Forum Server is a an advanced, stable fork of WP Forum.

If there are any problems installing this plugin 
please visit the site at http://vasthtml.com/js/wordpress-forum-server/
and download the plugin from there.

If you want to show off your forum please 
visit: http://vasthtml.com/support/?vasthtmlaction=viewtopic&t=24.0
and leave a link to your site.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `forum-server` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make a new page to place your forum into. Make sure you have it on the `HTML` editor.
4. Simply place the tag `<!--VASTHTML-->` or `[forumServer]` in the new page content area.

Please visit http://vasthtml.com/js/wordpress-forum-server/ for usage instructions.
Complete Installation Instructions: http://vasthtml.com/item-readme/forum-server/
For a complete demo visit http://vasthtml.com/support/

== Frequently Asked Questions ==

= Do you have a demo? = 
Yes- it's located here: http://vasthtml.com/support/

= The file from Wordpress.org does not work = 
Go to http://vasthtml.com/js/wordpress-forum-server/
and download from there.

= Is there a gallery i can see other people using the plugin? = 
http://vasthtml.com/support/?vasthtmlaction=viewtopic&t=24.0 

= How do I translate interface in another language? = 
To make a translation of any wp plugin use this plugin
http://wordpress.org/extend/plugins/codestyling-localization/

Prefix the .mo and .po files with "vasthtml-", for example: vasthtml-en_EN.mo, vasthtml-en_EN.po.
When the .mo and .po files are ready:
1. Copy .mo and .po files to /wp-content/plugins/forum-server/
2. Open /wp-content/plugins/forum-server/wpf-main.php file
3. Uncomment the following lines:
//$plugin_dir = basename(dirname(__FILE__));
//load_textdomain("vasthtml", ABSPATH.'wp-content/plugins/'. $plugin_dir.'/'.'vasthtml-en_EN.mo');
(change "en_EN" to your locale descriptor.

= May I recommend some new features? = 
Yes please do. http://vasthtml.com/support/?vasthtmlaction=viewtopic&t=20.0

= Where can I get support? = 
In the support forums on Vast HTML: http://vasthtml.com/support/


== Screenshots ==

1. Choose a forum skin.
2. The home page for the forum options.
3. About the forum page.

== Changelog ==
= 1.6.5 =
* Fixed bug: warning php message
= 1.6.4 =
* Fixed bug: duplicate topic forms
* Fixed bug: default encoding in database tables changed to UTF-8
* Fixed bug: parsing '$' character
* Fixed bug: width for posts with embedded video or code listings
* Fixed bug: login form when wordpress is installed in it's own directory (not in root folder)
* Fixed bug: 'show new posts since last visit' feature
* Fixed bug: links to posts in RSS feed
* Fixed bug: database error when deleting forum
* Fixed bug: interface of adding users to users' groups
= 1.6.3 =
* Fixed bug: Fix icon for my hot topics
* Fixed bug: Fix minimize forum header button
* Fixed bug: Fix deleting single post in topic
* Fixed bug: Fix deleting category when there's some topics in it
* Fixed bug: Fix redirect after posting in topic on non first page
* Fixed bug: Fix checking user_level for sticky post function
* Fixed forum related errors (undefined variables) with debug-mode enabled
= 1.6.2 =
* Fixed bug: Incorrect formatting in replies subject for topics and posts containing apostrophes
* Fixed bug: Disallow ability to modify guest posts by other guests
* Fixed bug: Fix the topic links in the rss feed and email-notifications
* Added line breaks in post/answer body for better text formatting
= 1.6 =
* Fixed bug: Duplicate launch of plugin with sfc-like plugin
* Fixed bug: Fix youtube video insertion (allow html embed object)
* Was added support SEO-frendly URLs
= 1.5.2 =
* Fixed bug: Duplicate launch of plugin on certain themes and WordPress installations
* Fixed bug: Localization support on WordPress 3.0+
* Fixed bug: Javascript error when using "Show or hide header" feature on certain Forum Server skins
= 1.5.1 =
* Fixed bug: Path problems if wordpress is in subdirectory
= 1.5 =
* Fixed bug: Incompatibility with FireStats plugin and possibly certain other plugins, the bug also could cause a lot of database errors
* Fixed bug: Duplicating topics due to plugin incompatibility with certain plugins
* Fixed bug: No post body inside the topic due to plugin incompatibility with certain plugins
* Fixed bug: BBCode content inside e-mail notifications
* Fixed bug: Closing a topic didn't work as expected
* Fixed bug: sending e-mail notifications of your own replies when subscribed on topic
* Fixed bug: When subscribing to replies on topic, a blank screen was showing up
* "Unmake sticky" renamed to "Unstick" (for sticky topics)
* Fixed bug: Unstick function now works
* Fixed bug: search system now works
* Improved search system, now it searches in topic titles and can search in both titles and content
* Fixed bug: Email notifications were not sent in some cases
* New placeholder for inserting forum into WordPress page: [forumServer] can be used instead of <!--VASTHTML-->
= 1.4 =
* Added admin ability to close a topic
* Added admin ability to move a topic
* Fixed bug with message width on narrow theme column
* Fixed bug with Google Analytics hiding message textarea
* Fixed bug when user manually changes url parameters
= 1.3 =
* The link to edit categories now works.
* Made a work around for those having trouble deleting categories.
= 1.2 =
* Link to FORUM in Breadcrumb
* Group Link and Group Page
* Fixed the blank page redirection stuff
= 1.1 =
* Fixed database errors
= 1.0 =
* Code clean up
* Changed menu style to match Wordpress 2.7+
* Changed all images to a more updated look
== Upgrade Notice ==
= 1.5 =
This version fixes a number of plugin incompatibility bugs. Upgrade highly recommended.
= 1.4 =
This version fixes a security related bug. Upgrade immediately.
