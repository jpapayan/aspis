<?php
	/*
		Plugin Name: myLinksDump
		Plugin URI: http://silvercover.wordpress.com/myLinksDump
		Description: Plugin for displaying daily links.
		Author: Hamed Takmil
		Version: 1.2
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


global $wpdb;
$wpdb->hide_errors();
$table      = $wpdb->prefix."links_dump";
if (!empty($_GET['url']) && is_numeric($_GET['url']) ){
 $sql_query = $wpdb->prepare("SELECT * FROM ".$table." WHERE link_id=".$_GET['url']);
 $url       = $wpdb->get_row($sql_query, ARRAY_A);
}

//Getting next & previous links
$pre_query   = "SELECT link_id FROM ".$table." WHERE link_id < ".$_GET['url']." ORDER BY link_id DESC LIMIT 1";
$pre_result  = $wpdb->get_row($pre_query, ARRAY_A);
if (!empty($pre_result)){
 $pre_link  = '<li><a href="'.get_settings('siteurl').'/myLDlinker.php?url='.$pre_result['link_id'].'" target="_parent">';
 $pre_link .= __('Previous Link', 'myLinksDump').'</a></li>';
}else{
 $pre_link = '';
}
$next_query  = "SELECT link_id FROM ".$table." WHERE link_id > ".$_GET['url']." ORDER BY link_id ASC LIMIT 1";
$next_result = $wpdb->get_row($next_query, ARRAY_A);
if (!empty($next_result)){
 $next_link  = '<li><a href="'.get_settings('siteurl').'/myLDlinker.php?url='.$next_result['link_id'].'" target="_parent">';
 $next_link .= __('Next Link', 'myLinksDump').'</a></li>';
}else{
 $next_link = '';
}


$images_folder   = get_settings('siteurl').'/wp-content/plugins/myLinksDump/images/';
$archive_page_id = get_option('ld_archive_pid');
if ($archive_page_id ==-1){
 $archive = '';
}else{
 //We add target attribute to generated archive page link.
 $archive = wp_list_pages('include='.$archive_page_id.'&title_li=&echo=0');
 $archive = str_replace( '<a', '<a target="_parent" ', $archive);
}

if (get_option('ld_linkdump_fd') != ''){
 $rss_feed = get_option('ld_linkdump_fd');
}else{
 $rss_feed = get_settings('siteurl').'/myLDRSS.php'; 
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >
<title></title>
<style>

body{
 margin:0px;
}

img {
 border:0;
 margin: 3px 2px;
}

a{
  border:0;
  text-decoration:none;
  color: white;
}

a:hover{
  border-bottom-style: solid;
  border-width: 1px; 
  border-color: #FFFFFF;
  color: white;
}

.divider{
 color: white;
}

#topBar{
 margin:0;
 width:100%;
 height:30px;
 background-color:#<?php echo get_option('ld_branding_bg');?>;
 font-family:Tahoma, Arial;
 font-size:8pt;
}

#rightSection{
 float:right;
 margin-right:5px;
 margin-top:8px;
 display: inline-block;
 width: 450px;
 text-align:right;
}


#leftSection{
 float:left;
 margin-left:10px;
 margin-top:3px;
 
}

#navigation {
 font-size: 95%; 
 margin:3px 0 3px 0 ;
 float:right;
 margin-right:5px;
 margin-top:0px;
 display: inline-block;
 width: 450px;
 text-align:right;
 height: 30px;
} 
#navigation ul {
 list-style: none;
 margin: 0;
 padding: 0;
 padding-top: 1em; 
} 
#navigation li {
 display: inline; 
} 
#navigation a:link, #navigation a:visited {
 padding: 0.4em 1em 0.4em 1em; 
 color: #FFFFFF;
 background-color: #B51032;
 text-decoration: none;
 border: 1px solid #711515; 
} 
#navigation a:hover {
 color: #FFFFFF;
 background-color: #711515; 
} 

</style>
</head>

<body>
<div id="topBar">
 
 <div id="navigation">
  <ul>
   <?php echo $pre_link ?>
   <?php echo $next_link ?>
   <li><?php echo $archive ?></li>
   <li><a href="<?php echo get_settings('siteurl');?>" target="_parent"><?php echo __('Home Page', 'myLinksDump'); ?></a></li>
  </ul>
 </div>
 

 <div id="leftSection">
  <a href="ymsgr:im?msg=<?php echo __('Visit this', 'myLinksDump');?> : <?php echo $url['url'];?>" title="<?php echo __('Send to Yahoo messenger friends', 'myLinksDump'); ?>">
   <img src="<?php echo $images_folder.'yahoo.gif'?>" alt="<?php echo __('Send to Yahoo messenger friends', 'myLinksDump'); ?>">
  </a>
  <a href="<?php echo $rss_feed ?>" title="<?php echo __('RSS Feed', 'myLinksDump'); ?>" target="_parent">
   <img src="<?php echo $images_folder.'feed.gif'?>" alt="<?php echo __('RSS Feed', 'myLinksDump'); ?>">
  </a>
  <a href="http://digg.com/submit?phase=2&url=<?php echo $url['url'];?>" title="<?php echo __('Add to Digg', 'myLinksDump'); ?> target="_parent">
   <img src="<?php echo $images_folder.'digg.png'; ?>" alt="<?php echo __('Add to Digg', 'myLinksDump'); ?>">
  </a>
  <a href="http://del.icio.us/post?url=<?php echo $url['url'].'&title='.$url['title']; ?>" title="<?php echo __('Add to Delicious', 'myLinksDump'); ?>" target="_parent">
   <img src="<?php echo $images_folder.'delicious.png';?>" alt="<?php echo __('Add to Delicious', 'myLinksDump'); ?>">
  </a>
  <a href="http://friendfeed.com/share?url=<?php echo $url['url'].'&title='.$url['title']; ?>" title="<?php echo __('Add to FriendFeed', 'myLinksDump'); ?>" target="_parent">
   <img src="<?php echo $images_folder.'friendfeed.png';?>" alt="<?php echo __('Add to FriendFeed', 'myLinksDump'); ?>">
  </a>
  <a href="http://balatarin.com/links/submit?phase=2&url=<?php echo $url['url'].'&title='.$url['title']; ?>" title="<?php echo __('Add to Balatarin', 'myLinksDump'); ?>" target="_parent">
   <img src="<?php echo $images_folder.'balatarin.png';?>" alt="<?php echo __('Add to Balatarin', 'myLinksDump'); ?>">
  </a>
   <a href="http://www.mohand.es/submit?phase=1&url=<?php echo $url['url'].'&title='.$url['title']; ?>" title="<?php echo __('Add to Mohandes', 'myLinksDump'); ?>" target="_parent">
   <img src="<?php echo $images_folder.'mohandes.png';?>" alt="<?php echo __('Add to Mohandes', 'myLinksDump'); ?>">
  </a>
 </div>
</div>
</body>

</html>
