<?php
/*
Plugin Name:  RSS Feed Reader for WordPress
Plugin URI:   http://pleer.co.uk/wordpress/plugins/rss-feed-reader
Description:  Output RSS to HTML with this simple plugin. Easy to install, set up and customise.
Version:      0.1
Author:       Alex Moss
Author URI:   http://alex-moss.co.uk/

Copyright (C) 2010-2010, Alex Moss
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
Neither the name of Alex Moss or pleer nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

Credit goes to Magpie RSS for RSS to PHP integration: http://magpierss.sourceforge.net/

*/

require_once("magpie/rss_fetch.inc");


function RSSfeedreader($atts) {
    extract(shortcode_atts(array(
		"url" => 'http://pleer.co.uk/feed',
		"num" => '10',
		"scrape" => 'no',
		"links" => 'yes',
		"encoding" => 'no',
		"pubdate" => 'no',
		"conditional" => 'no',
		"phpdate" => 'j F Y',
		"pubtext" => 'on ',
		"desc" => 'no',
		"divid" => '',
		"ulclass" => '',
		"liclass" => '',
		"linklove" => 'yes',
    ), $atts));

	$rss = RSS_feed_fetch_rss_feed($url);

	ob_start();
	$count = 1;
	$now = time();
	$page = get_bloginfo('url');

	if ($divid != "") {
		$divstart = "<div id=\"".$divid."\">\n";
		$divend = "</div>";
	}
	if ($ulclass != "") {
		$ulstart = "<ul class=\"".$ulclass."\">" . $entry;
	} else {
		$ulstart = "<ul>" . $entry;
	}

	foreach ($rss->items as $item) {
		if ($num > 0) {
			if ($count > $num) {
				continue;
			}
		}
		$entry = $item['title'];
		if ($encoding == "yes") {
			$entry = htmlentities($entry);
		}

		if ($page != "") {
			if (!strpos($entry, $page) === false) {
				continue;
			}
		}

		if ($links != "no") {
			$entryurl = $item['link'];
			$entry = "<a href=\"".$entryurl."\">".$item['title']."</a>";
		}

		if ($pubdate == "yes") {
			$when = ($now - strtotime($item['pubdate']));
			$posted = "";
			if ($conditional == "yes") {
				if ($when < 60) {
					$posted = $when . " seconds ago";
				}
				if (($posted == "") & ($when < 3600)) {
					$posted = "about " . (floor($when / 60)) . " minutes ago";
				}
				if (($posted == "") & ($when < 7200)) {
					$posted = "about 1 hour ago";
				}
				if (($posted == "") & ($when < 86400)) {
					$posted = "about " . (floor($when / 3600)) . " hours ago";
				}
				if (($posted == "") & ($when < 172800)) {
					$posted = "about 1 day ago";
				}
				if ($posted == "") {
					$posted = (floor($when / 86400)) . " days ago";
				}
			} else {
				$date = date($phpdate, strtotime($item['pubdate']));
				$posted = $date;
			}
		$entry = $entry."\n<br />".$pubtext.$posted;
		}

		if ($desc == "yes"){
			$entry = $entry."\n<br />".$item['description'];
		}

		if ($liclass != ""){
			$entry = "\n<li class=\"".$liclass."\">".$entry."</li>";
		} else {
			$entry = "\n<li>".$entry."</li>";
		}
		$allentries = $allentries.$entry;
		$count++;
	}
	ob_end_flush();

	if ($linklove != "no"){	$pleer = "\nPowered by <a href=\"http://pleer.co.uk/wordpress/plugins/rss-feed-reader\">RSS Feed Reader</a><br />\n"; }
	$whole = "\n<!-- RSS Feed Reader Plugin for WordPress: http://pleer.co.uk/wordpress/plugins/rss-feed-reader -->\n".$divstart.$ulstart.$allentries."\n</ul>\n".$pleer.$divend."\n";
	return $whole;
}
define('MAGPIE_CACHE_AGE', '1*3');
add_filter('widget_text', 'do_shortcode');
add_shortcode('rss-feed', 'RSSfeedreader');
?>