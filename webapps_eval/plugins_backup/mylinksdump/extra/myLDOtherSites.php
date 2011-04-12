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
global $wpdb;
$style_path         = get_settings('siteurl').'/wp-content/plugins/myLinksDump/styles/myLDOtherSite.css';
$linker             = get_settings('siteurl').'/myLDlinker.php?url=';
$table              = $wpdb->prefix."links_dump";
$ld_number_of_links = get_option('ld_number_of_links');
$sql_query          = $wpdb->prepare(" SELECT * FROM ".$table." ORDER BY link_id DESC LIMIT 0,".$ld_number_of_links);
$ret_links          = $wpdb->get_results($sql_query , ARRAY_A);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title><?php echo get_option('ld_linkdump_title'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="all">
<link href="<?php echo $style_path; ?>" rel="stylesheet" type="text/css">
</head>

<body>
<?php echo myLinksDump_show() ;?>
<div>
<a style="font-family: Tahoma; font-size:8pt;text-decoration:none" href="http://linkgardi.com/?page_id=3">دریافت کد</a>
<a style="font-family: Tahoma; font-size:8pt;float:right;text-decoration:none" href="http://linkgardi.com">ارسال لینک</a>
</div>
</body>

</html>
