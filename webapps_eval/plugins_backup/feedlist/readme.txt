=== FeedList ===
Contributors: finalcut
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=bill%40doxie%2eorg&item_name=Feedlist&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: rss, atom, feeds, listings
Requires at least: 1.5
Tested up to: 3.01
Stable tag: 2.61.01

Allows you to display lists of links from an rss or atom feed on your blog.

== Description ==
	This plugin fetches RSS or ATOM feeds from the url you provide and displays them on your blog. It can be used to manage "hot links" sections or anything else you can grab via an RSS or ATOM feed.

	The plugin also supports wordpress filters by letting you embed a feed into your post.


	The initial idea for this plugin came from the del.icio.us plugin that can be found at http://chrismetcalf.net. -

	Secondary inspiration for the ATOM integration comes from James Lewis at http://jameslewis.com - I had been thinking about doing it and he did it which pushed me to make the integration.



== Installation ==
	INSTALLATION:

	1.) Place the plugin (feedlist.php) in your wp-content/plugins/feedlist directory. (create the feedlist directory if necessary)

	2.) Edit feedlist.php and fill out the values in the CONFIGURATION section.

	3.) Enable the feedList plugin in the "Plugins" section of your WordPress administration panel.

	4.) OPTIONAL BUT HIGHLY RECOMMENDED - Replace the class-snoopy.php file in your wp-includes directory with the one provided in this distribution.  The standard class-snoopy.php is broken
	when trying to load pages that are compressed by their server (gzip compression).  This file fixes that problem.


	UPGRADING:

	1.) jot down your configuration information in feedList.php 

	2.) Overwrite your feedlist.php file

	3.) Update your feedlist configuration information with that data you wrote down in step 1

	4.) enjoy



== Change Log ==
	DATE					MODIFICATION						
		AUTHOR
-------------------------------------------------------------------------------------------------------
12 October 2005			Initial Version						
		Bill Rawlinson - released version 2.0B
							rewrite of rssLinkedList  NOTE a 
major change - the caching is handled 
by Wordpress now so you don't need a 
cache directory.


	06 Nov 2005			Simplified Interface and Rewrite Docs

	15 Nov 2005			Fixed some bugs 

	01 Dec 2005			Fixed a bug where the description wasn't being shown for atom feeds
						and cleaned up the description display code
	24 Jan 2006			Added new parameter to suppress the inclusion of links with an item title

	09 Feb 2006			Removed erronneous line that was preventing feed caching.  Thanks to user Ted.
					also added better internationalization thanks to user Sebastian

	08 Mar 2006			Added new parameter to display the date the feed was updated "show_date" which is false
					by default.

	10 Mar 2006			Added "random feed" capability (see bottom of file for usage).

	12 May 2006			Added new parameter "additional_fields" which really extends what you can show within the output of the feed.

	16 Jun 2006			Added new parameters max_characters and max_char_wordbreak Plus the ability to add translations for some key words that might get inserted in the feed items.

	21 Nov 2006			minor bug fix that caused generated content to not be xhtml compliant - thanks to the owner of "The Swamp" at http://www.guzzlingcakes.com/ for pointing out the problems.
					Am also including the class-snoopy.php fix for wordpress so that sites that gzip compress their feeds can be consumed by feedlist (this is a bug in snoopy that has been fixed)
					this will allow you to pull in feeds from sites that previously didn't work such as ma.gnolia and reddit.com

	14 Apr 2007			Complete rewrite

	22 Jan 2008			Minor Bug fixes (handle show_date, show_date_per_item)

	24 Mar 2008			Added new parameter "show_description_only" which forces the output to only show each items description (will be linked if a link exists in the feed).

	08 Apr 2009			The Read More link now acts according to the behavior of the "new_window" argument

	07 Jul 2009			Added "feedListExtensions.php" with first extension point, "transformURL" see bottom of this document for help on extensions.

	23 Sep 2009			fixed a variety of issues identified at http://code.google.com/p/wp-feedlist/issues/list (issues: 15, 17, 22, 30, 31, 32, 37)

	25 Nov 2009			Added filter for posts to use the random feed file

	19 Jan 2010			Added new option of to display rel="nofollow" on the links.  Option is called "no_follow_on" and by default is set to false.

	08 Apr 2010			Added support for SimplePIE feed parsing as an alternative to the default magpie choice.

	29 Oct 2010			Made the language option request specific while keeping the global setting as the default choice
-------------------------------------------------------------------------------------------------------
  
== LICENSE ==
	This program is free software; you can redistribute it and/or 
modify it under the terms of the GNU General Public License 
(GPL) as published by the Free Software Foundation; either 
version 2 of the License, or (at your option) any later 
version.


== POTENTIAL ISSUES ==
	May not handle internationalization very well.  Has seen very 
limited testing with non UTF-8 encoding.

== KNOWN BUG ==
	using the rssFile filter results in a duplication of the feedList display


== USAGE ==
	From anywhere in your WordPress template, call the function 
"feedList(...)", which takes the following parameters (all 
parameters have default values) you can pass in either a named array of parameters or
pass the parameters in order as follows:


	* rss_feed_url (default: "http://del.icio.us/rss") - The URL of the Del.icio.us RSS or ATOM Feed.  Still named rss_feed_url for backwards compatability but will work with ATOM feeds
	* num_items (default: 15) - The number of items to display
	* show_description (default: true) - Whether or not to display the "description" field
	* random (default: false) - Whether or not to randomize the items
	* before (default: "<li>") - Tag placed before the item	
	* after (default: "</li>") - Tag placed after the item	
	* description_separator (default: " - ") - Between the link and the item
	* encoding (default: false) - Change to true if you are reading in a ISO-8859-1 formatted file.  Basically, if you see a bunch of question marks (?) in your titles set this to true and see if it fixes the problem.
	* sort (default: "none") - takes one of three values; none, asc, desc
			none - doesn't sort and leaves your existing code as is
			asc	 - sorts the results in alphabetic order (by title)
			desc - sorts in reverse alphabetic order (by title)
	* new_window (default: false) - Whether to open the links in a new window or not.
			true - opens links in new window using javascript to attach the "target" attribute to each link in the list	and is thus xhtml strict compliant
			false - opens the links in the current window  (DEFAULT)
			simple - opens links in new window and hardcodes the target="_blank" into the link. NOT xhtml strict compliant this option exists so that you can use it without javascript.  If you also don't want to include the javascript	in your header file update the global setting in rssLinkList.php $showRSSLinkListJS and set it to false.
	* ignore_cache	(default: false) use only under special circumstances such as testing a feed.  Setting to true will get you banned from
			some feed providers if you fetch too often!  If you provide a number (instead of true or false) it will
			use that value (in seconds) as the cache timeout setting..
			true - gets a fresh copy if possible: not reccommended as some sites will ban you if you get their feed to frequently
			false - uses the default caching mechanism
			numeric value - a way to overide the cache timeout on a feed-by-feed basis
	* suppress_link (default: false) - Whether to wrap the item title in a link to the item's link url
			true - suppresses the link and wraps the title in a <span>
			false - the default behaviour that is what feedList has always done - if a link exists in the feed item then the title is wrapped in the anchor tag <a href="">.
	* show_date	(default: false) - wheter to show the last date the feed was updated.  If true it shows the date wrapped in a div with the class of "feedDate".
			true - shows the update date like so: "updated: 02 Mar 2006 01:59pm EST" without the quotes wrapped in a DIV with class "feedDate".  If you use this and have your
				feed items shown in a list (<ul>,<ol>) your html page may not validate with a <div> nested in the list.
			false - the default behaviour and is what feedList has always done.  No update date is displayed.
	* additional_fields - lets you enter a list of fields you want to display.  The list of fields needs to be delimited by a tilde (~).  If you want to show a nested field then it needs to be defined as a period/dot delimited item.
			example	using del.icio.us and you want to show the tags associated with the item and the summary of the item -
			feedList(array("rss_feed_url"=>"http://del.icio.us/rss/finalcut",
						   "additional_fields"=>'summary~dc.subject'
						   )
			
			In this example the list of fields is summary and dc.subject - dc.subject drills down into the rss structure to reach the node <item><dc><subject></subject></dc></title> - del.icio.us currently exports the list of tags
			in the dc.subject field.
	* max_characters - The maximum number of characters to return. If you want to show everything, set to 0 (default).
			NOTE: if this is set (non 0 number) then any HTML entities will not be converted back to HTML to make sure your sites HTML doesn't get broken.

	* max_char_wordbreak - Used only if max_characters is NOT 0.  Prevent breaking up words.
			true - we cut on the last space before max_characters. 
			false - cuts right at the max_characters point

	* show_description_only - provides a mechanism for turning off the item titles
			true - suppresses the title and the description separator; forces "show_description" to be true
			false - won't change the behavior of the plugin at all.  (DEFAULT)
	* no_follow_on - flag for turning on, or off, the rel="nofollow" attribute on links
			true - include rel="nofollow" with each link in the feed
			false - don't include rel="nofollow"  (DEFAULT)
	* language -	what language to show the "Read More..." link in when the description field is longer than max_characters.  By default it uses the language setting that is in
			the plugin around line 181 which, by default, is en_US.  As of this date the languages supported are:
				fr_FR - French [shows, Lisez davantage]
				nl_NL - Dutch [shows, lees verder]
				en_US - US English [shows, Read more...]
				
	FILTER USAGE

		* basic:
			<!--rss:[URL]--> 

			NOTE if you aren't using named parameters with the fitler then ONLY provide the url after the rss: or else it won't work.  Left as rss: for backwards compatability but will work with ATOM feeds as well.

		* NAMED PARAMETERS
			<!--rss:rss_feed_url:=http://del.icio.us/rss/finalcut/wishlist,num_items:=5,random:=true-->

			NOTE when using the filter and named parameters ALL parameters including the URL must be named. Also note that if you are providing different HTML for the before or after parameter you must escape it.  For instance if you want before='<li>' then you must pass before='&lt;li&gt;'  

			Finally note the whole thing must be on ONE line.  No line breaks or else it won't work.


		* random file:
			<!--rssFile:[FilePath]-->

			NOTE: if you aren't using named parameters with the filter only provide the full path to the file or else it won't work.
			NOTE: if you don't provide a filepath the default one set in the file, feedlist.php near line 187 will be used (typically siteroot\wp-content\plugins\feeds.txt)
			
			* Named Parameters
			<!--rssFile:feedsToShow:=1,num_items:=3,file:=c:\dev\websites\wordpress\wp-content\plugins\feeds2.txt-->

			NOTE: this example will pull one feed from the file, and then show 3 items fro the feed


  EXAMPLES:

	NAMED PARAMETER EXAMPLE -- PREFERRED METHOD
		<ol>
		<?php 
			feedList(array("rss_feed_url"=>"http://www.auf-der-hoehe.de/index.php?id=23&type=333&feed_id=71&no_cache=1",
							"num_items"=>10,
							"show_description"=>false,
							"random"=>true,
							"sort"=>"asc",
							"new_window"=>true,
							"show_date"=>true
					)
			); 
		?>
		</ol>

	BASIC
		<ol>
		 <?php 
			feedList("http://del.icio.us/rss/finalcut"); 
		 ?>
		</ol>

		due to the fact that rssLinkList wraps each item with an <li> tag pair by default you need to provide the <ol> or <ul> wrappers	around the function call.


	COMBINING LISTS:

		You can also combine rss calls into one html list simply by wrapping multiple rssLinkList function calls in one set of html list tags.  Notice I only specify the first parameter here.  All parameters have defaults so the only one you really need to provide is the URL.

		<ol>
		 <?php 
			feedList("http://del.icio.us/rss/finalcut"); 
			feedList("http://www.43things.com/rss/uber/author?username=FinalCut");
		 ?>
		</ol>

		since the function, feedList, by default wraps each rss item in <li> tags you will end up with one long list of items to display.

	ENCODING EXAMPLE:

		<ol>
		<?php feedList("http://www.auf-der-hoehe.de/index.php?id=23&type=333&feed_id=71&no_cache=1",10,false,true,"<li>","</li>","-",true); ?>
		</ol>



  NOTE:
	Remember, if you don't want your items to be displayed as an html list - you need to override the default parameters of "before" and "after" in the function call.


	-------------------
	SIMPLE PIE
	-------------------
	If your feeds don't show up properly OR you just want to use a more modern feed parsing engine go into feedList.php and change $useMagPie = false; instead of true.
	Eventually this will be the only way I pull back feeds but to insure backward compatability at the moment magpie is remaining the default parser.


	-------------------
	RANDOM FEEDS
	-------------------
	This is a feature that lets you prepopulate a text file in a easy to read format that feedList will use to display your feeds randomly.
	It supports pretty much every option the normal feedList functionality supports but with the added ability of displaying items from multiple feeds
	at one time.

	There are some potential areas where you might have problems using this.
	1. You don't format your feed file properly.
	2. You don't tell feedList the correct location of your feed file.  99% of the time this will be the problem.

	For an example of a feedFile check out the feedFile_example.txt that comes with the plugin. For the absolutely easiest
	means of using this feature just create a copy of feedFil_example.txt and renamte it as feeds.txt and put it in your wp-content/plugins
	directory.

	USAGE:

	SIMPLE: assuming you put your feeds.txt file in the wp-content/plugins directory
		<?php randomFeedList() ?>


	ADVANCED: 
		<?php randomFeedList("feedsToShow=2&num_items=3") ?>

		there are ALOT of parameters you can pass into randomFeedList.  I am taking a different approach to it here than I do elsewhere in the feedList plugin.
		If you want to pass parameters they must be passed in as shown separating each additional name/value pair with an ampersand &.  

	
	PARAMETERS
	file - the path to your feedfile (default: '.wp-content/plugins/feeds.txt')
	feedsToShow - the number of feeds to poll from your feedfile (default: 5)
	num_items - the number of items to show from each feed polled (default: 1)
	show_description - show the description of each item or not (default: false)
	randomItemsPerFeed - not only can you show random feeds from the feed file but you can also show random items from each feed (default: true)
	beforeItems - what to show before an item  (default: '<li>')
	afterItems - what to show after an item (default: '</li>')
	description_separator - what to show, if the description is displayed, between the item title and the description (default: '-')
	encoding - a weak effort at internationalization support.  If your feeds show up with weird characters try setting this to true (default: false)
	sort - how to sort the feed items by title: asc (ascending order), desc (descending), or none - leave feed in its natural order, typically date of posting (default: none)
	new_window - wheter to open the links in a new window (default: false)
	ignore_cache - wheter to ignore the cached copy of the feed - recommended to leave as false (default: false)
	suppress_link - wheter to remove the link from the title (default: false)
	show_date - wheter to show the date each feed was last updated (default false);
	additional_fields - any additional fields to display with the item.  (default: an empty string)


	
	CRAZY ADVANCED CALLING:

		if you want to specify all of those parameters in one call


		<?php randomFeedList("file=./wp-content/feeds2.txt&feedsToShow=2&itemsPerFeed=3&show_description=true&randomItemsPerFeed=false&beforeItems=&afterItems=&description_separator=::&encoding=false&sort=asc&new_window=true&ignore_cache=200&suppress_link=false&show_date=true&additional_fields=x~y~z.a.b") ?>


== Troubleshooting ==

	1. if your feed isn't being loaded properly then try to replace the following two files in your wp-includes directory of your wordpress install:
		class-snoopy.php and rss.php
	 with the copies found at http://code.google.com/p/wp-feedlist/downloads/list

== Extensions ==
	I have added a rudimentary extension mechanism that will let you add custom behavior to how feedList process the feeds.  This way you can edit the feedListExtensions.php file and
	not have to worry about breaking compatiability with feedList (thus you will get updates without a problem.  Upgrades may become more difficult in the future so we shall see how this
	goes.

	-- transformLinkURL --
		This extension point is used to make changes to the URLs associated with all the links before they are used within feedList.  For example if you wanted to add a tracking code
		to the end of the url you could just update the default function to return as follows:
			return $url . "&trackingCode=mytrackingCode";

		Obviously you'd want to add a little bit of logic to make sure you needed the & and not the ? before appending your new url argument (I leave that to you).  Likewise
		this is a pretty weak example but hopefully it illustrates the extension point well enough.  One user is using this extension point to reroute all URls to a different location
		before they go off to their actual destination (not sure why).