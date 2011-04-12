<?php
	/*
		Plugin Name: myLinksDump
		Plugin URI: http://silvercover.wordpress.com/myLinksDump
		Description: Plugin for displaying daily links.
		Author: Hamed Takmil
		Version: 1.0
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

function update_counter() {
  global $wpdb;
  $wpdb->hide_errors();
  $table     = $wpdb->prefix."links_dump";
  $q="SELECT * FROM ".$table." WHERE link_id=".$_GET['url'];
  echo "query= $q<br>";

  $sql_query = $wpdb->prepare($q);
  $url       = $wpdb->get_row($sql_query, ARRAY_A);
  
  $visits    = $url['visits'] + 1;
  
  //Update link vist counter
  $sql_query = $wpdb->prepare("UPDATE ".$table." SET visits='".$visits."' WHERE link_id=".$_GET['url']." LIMIT 1");
  $wpdb->query($sql_query);
  
  //Redirect user to destination URL
  if (get_option('ld_open_branding') == 0){
   header("Location:".$url['url']);
  }
?>
<html>

<head>
<title><?php echo get_option('ld_linkdump_title').":".$url['title'];?></title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
</head>

<frameset rows="30,*" frameborder="0">
	<frame name="header" noresize="noresize" scrolling="no" src="<?php echo get_settings('siteurl').'/myLDbranding.php?url='.$_GET['url']; ?>" />
	<frame name="main" src="<?php echo $url['url']; ?>" />
	<noframes>
	<body>

	<p>This page uses frames, but your browser doesn&#39;t support them.</p>


</body>
	</noframes>
</frameset>

</html>
<?php
}

update_counter();
?>

