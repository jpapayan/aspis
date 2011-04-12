=== Plugin Name ===
Contributors: wobeo
Donate link:  http://wobeo.com/wordpress-free-plugins/wp-safesearch-filter-wordpress-adult-content/
Tags: wordpress, plugin, filter, content, categories, category, tags, tag, widgets, widget
Requires at least: 3.0.1
Tested up to: 3.0.1
Stable tag: 0.7

WP Safe Search acts as a simple filter on posts/pages lists by hiding the posts belonging to categories and tags ids you have marked as restricted.

== Description ==

Filtering content becomes a real problem when it comes to "offendant" material mixed with less specific one. Search engines may disallow ALL your content just because you do not have set any proper system to filter a few posts out of the rest. WP Safe Search provides a simple way for your WordPress website to follow such restrictive guidelines just by entering a few categories/tags ids on the plugin settings page and then filtering the corresponding posts. At any moment will your readers be able to switch the filter On/Off, thus letting them choose wether to read or ignore posts you have marked as restricted to a specific audience (provided you properly set up the WP Safe Search widget or template tag).

== Installation ==

1. Unzip and upload the wp-safesearch directory to the /wp-content/plugins/ directory.
2. Activate the plugin through the "Plugins" section of WordPress admin panel.
3. Go to WordPress admin area and list the categories and tags to hide on the Settings page.
4. Place &lt;?php if (function_exists('wpss_safesearch')) { echo wpss_safesearch(); } ?&gt; in your templates or use the provided widget.

== Frequently Asked Questions ==

= What is WP Safe Search? =

WP Safe Search provides your visitors a "safe way" to surf your site by filtering the categories/tags you may not find safe to let them browse without being conscious of the related risk.
By activating this plugin, you now have the ability to efficiently hide categories/tags to the first coming visitors, while letting them a chance to access the entire content later.
WP Safe Search does not modify your database content, it only slightly changes the way it is rendered.

= How to filter categories/tags? =

   1. Activate the plugin and go to the settings page
   2. Enter as many categories and tags ids as wanted in the general options fields. Ensure to separate ids by commas!
   3. Put the WP Safe Search widget in one of your site's sidebars.
   4. You may also want to use the following template tag in your theme's files:
      &lt;?php if (function_exists('wpss_safesearch')) { echo wpss_safesearch(); } ?&gt;
   5. To enclose the resulting html code between specific html tags, simply use the before/after parameters:
      &lt;?php if (function_exists('wpss_safesearch')) { echo wpss_safesearch('li','li'); } ?&gt;

= How does it work? =
In order to set the filter on, the visitor's browser MUST accept cookies.
The filter is On as soon you activate the plugin. It means that your visitors MUST deactivate the Safe Search filter first through the link provide by the widget (or the template tag) to access the hidden posts. This makes some sense as the filtered content being supposed to be offendant or risky, it should not be shown prior to the visitor's consent.
The plugin does not alter your content in any way, it simply modifies the genuine WP Query whenever the filter is switched On/Off. So if you deactivate the plugin (or set non-existent categories/tags ids), all your original content will be brought back.
If a post belongs at least to one of the filtered categories/tags and the visitor's filter is set to On, it won't be shown anywhere.
NB: The filtering provided by WP Safe Search doesn't apply to any of the WordPress' RSS feeds.

= How to remove the WP Safe Search filter? =
Just deactivate/uninstall the plugin to get your WordPress website go and roll as it used to before!
If you need to disable the filter temporarily (for testing purposes by example), you can deactivate it OR set the filtered categories and tags to a non existent value (ie 0) through the plugin settings page...

= What about caching systems ? =
As for 0.3 version, the plugin does well even if a caching system is running.
The cache systems generally serve plain html files instead of tirelessly running the same queries for any page requested, so the filtered lists/pages/posts are now suffixed by a specific query var (<strong>safesearch=true|false</strong>), thus insuring separately cached files for filtered and unfiltered urls.

= How to avoid duplicate content =
<strong>Do not forget</strong> to inform the search engine of a possible duplicate content by:
- using a canonical url on each post/page created,
- adding the plugin added query var as to be ignored by search engines.
Example: go to Google Webmaster Tools > Site Configuration > Parameter Handling and add there the plugin parameter <strong>safesearch</strong> with the "action" set to "Ignore", which should prevent the bot to explore the pages twice.

= How to inform the visitor the content has been filtered? =
There is no simple way to notify visitors that some posts aren't shown in combined archives (like date archives, searches,...), as safe posts will still be shown while unsafe ones will be effectively filtered. However, for plain filtered categories and tags lists (the archives corresponding to the admin plugin set ids), you will better customize your 404 template to indicate that the archive or search content may be altered by the filter being active

= What about custom taxonomies? =
WP Safe Search does not currently support custom taxonomies.

= Possible other uses =
If needed you may use the plugin in your templates file thats way:

&lt;?php
 if ( function_exists('wpss_getcookie') )
 {
	// the plugin is active, we will test the filter's state
	if ( wpss_getcookie() )
	{
		// filter is On
		... treatment here
	}
	else
	{
		// filter is Off
		... treatment there
	}
 }
?&gt;

= What about support? =
I can't spend as much times as I should in order to support plainly this plugin, so use them at your own risk and do not wait for quick answers to inquiries neither for updates on a regular basis. Fell free anyhow to use the forums as I will try and look there from time to time.

== Screenshots ==

Comin soon

== Upgrade Notice ==

= Cache =
Do not forget to empty your cache after upgrading.

= Filenames changes =
Since V0.3, filenames have changed to reflect the WordPress repository rules (wp-safe-search instead of wp-safesearch).
To upgrade to vX.X from v0.3, please:
* deactivate plugin,
* delete plugin files either through admin panel or directly through FTP,
* reinstall plugin.

== Changelog ==

= 0.6 =
* filenames changed for reflecting WP repositery rules

= 0.3 =
* cache plugins support added
	
= 0.2 =
* support for WPTouch added

= 0.1 =
* beta release
