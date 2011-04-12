<?php
	/*
		Plugin Name: myLinksDump
		Plugin URI: http://silvercover.wordpress.com/myLinksDump
		Description: Plugin for displaying daily links.
		Author: Hamed Takmil
		Version: 1.1
		Author URI: http://silvercover.wordpress.com
		*/
		
		/*  Copyright 2010  Hamed Takmil aka silvercover
		
		Email: ham55464@yahoo.com
		
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
   */
   
require_once("wp-load.php");
$inc_url = 'wp-content/plugins/myLinksDump/inc/rss_generator.inc.php'; 
require_once("$inc_url");

global $wpdb;
$table              = $wpdb->prefix."links_dump";
$ld_number_of_links = 15;
$sql_query          = $wpdb->prepare(" SELECT * FROM ".$table." WHERE approval='1' ORDER BY link_id DESC LIMIT ".$ld_number_of_links);
$ret_links          = $wpdb->get_results($sql_query , ARRAY_A);

$rss_channel = new rssGenerator_channel();
$rss_channel->atomLinkHref   = '';
$rss_channel->title          = get_option('ld_linkdump_title');
$rss_channel->link           = get_settings('siteurl').'/'.get_page_uri(get_option('ld_archive_pid'));
$rss_channel->description    = get_option('ld_linkdump_rss_desc');
$rss_channel->language       = get_option('rss_language');
$rss_channel->generator      = 'myLinksDump Plug-In';
$rss_channel->managingEditor = get_option('admin_email');
$rss_channel->webMaster      = get_option('admin_email');

foreach ($ret_links as $ldlink) {
  $item = new rssGenerator_item();
  $item->title       = $ldlink['title'];
  $item->description = $ldlink['description'];
  $item->link = get_settings('siteurl')."/myLDlinker.php?url=".$ldlink['link_id'];
  $item->guid = get_settings('siteurl')."/myLDlinker.php?url=".$ldlink['link_id'];
  $item->pubDate = date("D, d M Y H:i:s O", $ldlink['date_added']);
  $rss_channel->items[] = $item;
}

  $rss_feed = new rssGenerator_rss();
  $rss_feed->encoding = 'UTF-8';
  $rss_feed->version = '2.0';
  header('Content-Type: text/xml');
  echo $rss_feed->createFeed($rss_channel);
  
?>