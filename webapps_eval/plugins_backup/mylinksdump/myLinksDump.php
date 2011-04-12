<?php
		/*
		Plugin Name: myLinksDump
		Plugin URI: http://silvercover.wordpress.com/myLinksDump
		Description: Plugin for displaying daily links. Insert favorite links while you are surfing web into yout blog.
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


//We call this for localization.   
load_plugin_textdomain('myLinksDump', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)), dirname(plugin_basename(__FILE__)).'/languages');

//Define plugin base name and folder as a constant.
$mldp = plugin_basename(__FILE__);  
$tipStyle = 'font-size:8pt;color:#808080';
$myLDNavigationBarStyle = 'style="text-align:center;font-size:8pt;color:#808080;"';

define('tipStyle', $tipStyle);
define('myLinksDumpPath', $mldp);
define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
define('SITE_URL', get_option('siteurl'));
define('myLDPlugInVersion', "1.2");

//Plugin installation function which will be called on activation.
function linkdoni_install(){
    global $wpdb;
    $table = $wpdb->prefix."links_dump";
    $rating_table = $wpdb->prefix."links_dump_rating";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    if($wpdb->get_var("show tables like '".$table."'") != $table) {    
        $structure = "CREATE TABLE $table (
                      link_id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                      title VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL  ,
                      url TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                      description VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                      visits INT UNSIGNED NOT NULL DEFAULT '0',
                      date_added INT UNSIGNED NOT NULL ,
                      approval TINYINT UNSIGNED NOT NULL DEFAULT '1' ,
                      delicious_status TINYINT UNSIGNED NOT NULL DEFAULT '0' ,
                      PRIMARY KEY (link_id))";

        dbDelta($structure);      
        $structure = "CREATE TABLE $rating_table (
                      id varchar(11) NOT NULL,
                      total_votes int(11) NOT NULL default 0,
                      total_value int(11) NOT NULL default 0,
                      used_ips longtext,
                      PRIMARY KEY  (id))";
        dbDelta($structure);                      
        
        update_option("ld_number_of_links_be", "15");
        update_option("ld_linkdump_title", "Welcome to My Links Dump");
        update_option('ld_linkdump_widget_title', "My Links Dump");
        update_option("ld_number_of_links", "20");
        update_option('ld_number_of_links_widget', "10");
        update_option("ld_number_of_rss_links", "10");  
        update_option("ld_open_nw", "1");
        update_option("ld_repeated_link", "0");
        update_option("ld_stylesheet", "default.css");
        update_option("ld_linkdump_fd", "");
        update_option("ld_linkdump_rss_desc", "");
        update_option('ld_open_branding', "B7CEFF");
        update_option('ld_archive_days', "10");
        update_option('ld_archive_pid', "-1");
        update_option('ld_show_counter', "1");
        update_option("ld_show_description_w", "0");
        update_option("ld_show_description", "0");
        update_option("ld_send_notification", "1");
        update_option("ld_auto_approve", "1");   
        update_option("ld_short_url", "1");   
        update_option("ld_delicous_username", "");   
        update_option("ld_delicous_password", "");   
 
    }else{
    
        $structure = "CREATE TABLE $table (
                      link_id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
                      title VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL  ,
                      url TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                      description VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                      visits INT UNSIGNED NOT NULL DEFAULT '0',
                      date_added INT UNSIGNED NOT NULL ,
                      approval TINYINT UNSIGNED NOT NULL DEFAULT '1' ,
                      delicious_status TINYINT UNSIGNED NOT NULL DEFAULT '0' ,
                      PRIMARY KEY (link_id))";
        dbDelta($structure);
        $structure = "CREATE TABLE $rating_table (
                      id varchar(11) NOT NULL,
                      total_votes int(11) NOT NULL default 0,
                      total_value int(11) NOT NULL default 0,
                      used_ips longtext,
                      PRIMARY KEY  (id))";
        dbDelta($structure); 
                
        update_option("ld_send_notification", "1");
        update_option("ld_auto_approve", "1");
        update_option("ld_number_of_rss_links", "1");
        update_option("ld_short_url", "1");  
        update_option("ld_delicous_username", "");   
        update_option("ld_delicous_password", "");
    }
  update_option("ld_db_version", myLDPlugInVersion);
}
register_activation_hook(__FILE__, 'linkdoni_install');

//Add/EDdit/Delete links page on administration backend.
function linkdoni_admin_actions() {
    add_submenu_page('post-new.php', __('myLinksDump', 'myLinksDump'), __('myLinksDump', 'myLinksDump'), 1, __FILE__, 'linkdoni_admin_page' ) ;  
}
add_action('admin_menu', 'linkdoni_admin_actions');
function linkdoni_admin_page() {
 global $wpdb;
 $edit_mode = 0;
 $table = $wpdb->prefix."links_dump";
 
 //Here we check for proper link id passed to our function.
 if (!empty($_GET['editlink']) && is_numeric($_GET['editlink'])){
  $link_id   = $_GET['editlink'];
  $sql_query = $wpdb->prepare("SELECT * FROM ".$table." WHERE link_id='".$link_id."'");
  $ret_link  = $wpdb->get_row($sql_query);
  if (!empty($ret_link)){
   $edit_mode = 1;
  }
 }
 $path    = "edit.php?page=".myLinksDumpPath;
 $del_url = "edit.php?page=".myLinksDumpPath."&editlink=".$_GET['editlink']."&del=1";
?>
<script type="text/javascript">
function replaceDoc(){
  window.location.replace("<?php echo $path?>")
}

function warning(){
 action = window.confirm("<?php echo __('Are you sure?', 'myLinksDump') ?>");
 if (action){
  window.location.replace("<?php echo $del_url?>")
 }
}

function reset_form(){
 document.links_form.reset();
}

</script>
<div class="wrap">
   <?php echo "<h2>" . __('Add new link', 'myLinksDump') . "</h2>"; ?>
   <form name="links_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
   <?php wp_nonce_field('update-options'); ?>
   <table class="form-table">
    <tr valign="top">
     <th scope="row"><?php echo __('Link Title', 'myLinksDump')?>:</th>
      <td>
       <input type="text" name="link_title" value="<?php echo ($edit_mode && $_POST['action_type'] != 1)?$ret_link->title:"";?>" size="70"/>
       <span style="color:red;">*</span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Link URL', 'myLinksDump')?>:</th>
      <td>
       <input dir="ltr" type="text" name="link_url" value="<?php echo ($edit_mode && $_POST['action_type'] != 1)?$ret_link->url:""?>" size="70"/>
       <span style="color:red;">*</span>
       <br/>
       <span style="font-size:8pt;color:#808080"><?php echo __('Please input fully qaulified URL with <code>http://</code>', 'myLinksDump')?></span>
      </td>
     </tr>	
     <!--
     <tr valign="top">
     <th scope="row"><?php echo __('موضوع', 'myLinksDump')?>:</th>
      <td>
      <?php
       //$selected_cat = ($edit_mode && $_POST['action_type'] != 1)?$ret_link->category:"";
       // switch ($selected_cat) {
        
       // case 1:
       //  $sel1 = 'selected="selected"';
       //  break;
       // case 2:
       //  $sel2 = 'selected="selected"';
       //  break;
       // case 3:
       //  $sel3 = 'selected="selected"';
       //  break;
       // case 4:
       //  $sel4 = 'selected="selected"';
       //  break;
       // default:
       // }
      ?>
      <select name="category">
        <option value=""></option>
	      <option value="1" <?php //echo $sel1?>>گوناگون</option>
	      <option value="2" <?php //echo $sel2?>>تصاویر و فیلم</option>
	      <option value="3" <?php //echo $sel3?>>کامپیوتر و اینترنت</option>
	      <option value="4" <?php //echo $sel4?>>سیاسی</option>
	    </select>
      </td>
     </tr>
     -->
     <tr valign="top">
     <th scope="row"><?php echo __('Little Description', 'myLinksDump')?>:</th>
      <td>
      <textarea name="link_description" cols="60"><?php echo ($edit_mode && $_POST['action_type'] != 1)?$ret_link->description:""?></textarea>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __(' Approval ', 'myLinksDump')?>:</th>
      <td>
       <?php
       $approval_status = ($edit_mode && $_POST['action_type'] != 1)?$ret_link->approval:"";
        switch ($approval_status) {
        case 1:
         $sel1 = 'checked="checked"';
         break;
        case 0:
         $sel2 = 'checked="checked"';
         break;
        default:
        }
       ?>
       <input type="radio" name="link_approval" value="1" <?php echo $sel1; ?>/>
       <span><?php echo __(' Yes ', 'myLinksDump'); ?></span>
       <input type="radio" name="link_approval" value="0" <?php echo $sel2; ?>/>
       <span><?php echo __(' No ', 'myLinksDump'); ?></span>
      </td>
     </tr>
  
   </table>
   <input type="hidden" name="action_type" value="<?php echo $edit_mode?>" />
   <input type="hidden" name="page_options" value="link_title,link" />
   <p class="submit">
    <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
    <?php
    if ($edit_mode != 1){
    ?>
     <input type="reset" name="Reset" value="<?php _e('Reset Form','myLinksDump') ?>" />
    <?php
    }else{
    
    ?>
     <input type="button" name="DeleteLink" value="<?php _e('Delete','myLinksDump') ?>" onclick="warning()"/>
     <input type="button" name="AddNew" value="<?php _e('Add New Link') ?>" onclick="replaceDoc()"/>
    <?php
    }
    ?>
   </p>
 
   </form>
</div>

<?php

//This is link deletion routine.
if ($_GET['del'] == 1 && $edit_mode == 1){
 $sql_query = $wpdb->prepare("DELETE FROM ".$table." WHERE link_id=".$link_id);
 $wpdb->query($sql_query);
 ?>
 <script type="text/javascript">
  window.location.replace("<?php echo $path."&deleted=1"?>");
 </script>
 <?php

}
 if ($_GET['deleted'] == 1 && empty($_POST['link_title'])){
 ?>
  <div class="updated fade"><p><strong><?php _e('Link deleted.', 'myLinksDump'); ?></strong></p></div>
 <?php
 }

if(isset($_POST['link_title']) && isset($_POST['link_url'])) {
 if (!empty($_POST['link_title']) && !empty($_POST['link_url'])) {
  //This is for updating previous links.
  if ($_POST['action_type'] == 1){
   $sql_query = $wpdb->prepare("UPDATE ".$table." SET
                 title = '".$_POST['link_title']."', url='".$_POST['link_url']."',description='".strip_tags($_POST['link_description'])."' 
                 , approval='".$_POST['link_approval']."', delicious_status='0' WHERE link_id =".$link_id." LIMIT 1");
               
  }else{
   $sql_query = $wpdb->prepare("INSERT INTO ".$table." (link_id, title, url, description, visits, date_added, approval, delicious_status)
                 VALUES (
                  NULL , '".$_POST['link_title']."', '".urldecode($_POST['link_url']) ."', '".strip_tags($_POST['link_description'])."', '0', '".time()."', '1', '0'
                 )");

  }
 $repeated_urls = 0;
 $ld_repeated_link = get_option('ld_repeated_link');
 
                
 if ($edit_mode == 1){
  $wpdb->query($sql_query);
     ?>
    <div class="updated fade"><p><strong><?php _e('Link saved.','myLinksDump'); ?></strong></p></div>
 <?php
 }else{
 if ($ld_repeated_link == 0){
    $sql      = $wpdb->prepare("SELECT count(url) FROM ".$table." WHERE url = '".$_POST['link_url']."'");
    $repeated_urls  = $wpdb->get_var($sql);
    if ($repeated_urls < 1 ){
     $wpdb->query($sql_query);
    ?>
     <div class="updated fade"><p><strong><?php _e('Link saved.', 'myLinksDump'); ?></strong></p></div>
    <?php
    }else{
    ?>
     <div class="error"><p><strong><?php _e('Link not saved. Entered link is already in database.', 'myLinksDump'); ?></strong></p></div>
    <?php
    } 
 }else{
    $wpdb->query($sql_query);
     ?>
    <div class="updated fade"><p><strong><?php _e('Link saved.', 'myLinksDump'); ?></strong></p></div>
 <?php
  }
 }
 
}else{
?>
<div class="error"><p><strong><?php _e('Link not saved. Please fill required field.', 'myLinksDump'); ?></strong></p></div>
<?php
  }
 }
 $edit_mode = 0;
}

//Displays entered links list page.
function linkdoni_edit_actions() {
  add_submenu_page('link-manager.php', __('EditLinksDump', 'myLinksDump'), __('EditLinksDump', 'myLinksDump'), 1, __FILE__, 'linkdoni_edit_page');  
}
add_action('admin_menu', 'linkdoni_edit_actions');

function linkdoni_edit_page() {

 global $myLDNavigationBarStyle;
 global $wpdb;
 $wpdb->hide_errors();
 $table     = $wpdb->prefix."links_dump";
 
 if (isset($_GET['pge'])) {
   $pageno = $_GET['pge'];
  } else {
   $pageno = 1;
 }
 $sql_query = (" SELECT count(url) FROM ".$table." WHERE title LIKE '%".$_POST['s']."%'");
 $all_links = $wpdb->get_var($sql_query);
 
 $rows_per_page = get_option('ld_number_of_links_be');;
 $lastpage      = @ceil($all_links/$rows_per_page);

 $pageno = (int)$pageno;
 if ($pageno > $lastpage) {
   $pageno = $lastpage;
 } 
 if ($pageno < 1) {
   $pageno = 1;
 } 
 
 $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;

 if ($_POST['search_status'] !='Y'){
  $sql_query = $wpdb->prepare(" SELECT * FROM ".$table." ORDER BY link_id DESC ".$limit );
 }else{
 

 //Here we build our search query to find and sort our list.
 if (empty($_POST['sort_by'])){
  $cloumn = "ORDER BY link_id";
 }else{
  $cloumn = "ORDER BY ".$_POST['sort_by'];
 }
 
 if (empty($_POST['sort_order'])){
  $order = "DESC";
 }else{
  $order = $_POST['sort_order'];
 }
 
  $sql_query = (" SELECT * FROM ".$table." WHERE title LIKE '%".$_POST['s']."%' ".$cloumn." ".$order." ".$limit);
 }
  $ret_links = $wpdb->get_results($sql_query , ARRAY_A);
  
 //Check posted order and direction to set corresponding listbox show selected one.
 switch ($_POST['sort_by']) {
  case "visits":
    $selected_vistis     = 'selected="selected"';
    break;
  case "title":
    $selected_title      = 'selected="selected"';
    break;
  case "url":
    $selected_url        = 'selected="selected"';
    break;
  case "date_added":
    $selected_date_added = 'selected="selected"';
    break;
  case "approval":
    $selected_approved = 'selected="selected"';
    break;
 }

 switch ($_POST['sort_order']) {
  case "ASC":
    $selectd_order_asc     = 'selected="selected"';
    break;
  case "DESC":
    $selectd_order_desc    = 'selected="selected"';
    break;
 }
 //

?>
 <?php

 if (isset($_POST['action2']) && $_POST['action2'] =='approve'){
  foreach($_POST['links_group'] as $link=>$value){
   $sql_query = ("UPDATE $table SET approval = '1' WHERE link_id ='".$value."' LIMIT 1");
   $wpdb->query($sql_query );
  }
  $up_url = "link-manager.php?page=".myLinksDumpPath;
  ?>
  <script type="text/javascript">
  window.location.replace("<?php echo $up_url?>")
 </script>
  <?php
 }else if (isset($_POST['action2']) && $_POST['action2'] =='delete'){
        foreach($_POST['links_group'] as $link=>$value){
         $sql_query = ("DELETE FROM $table WHERE link_id ='".$value."' LIMIT 1");
         $wpdb->query($sql_query );
        }
        $up_url = "link-manager.php?page=".myLinksDumpPath;
        ?>
        <script type="text/javascript">
        window.location.replace("<?php echo $up_url?>")
       </script>
 <?php
 }
 if (isset($_GET['editlink']) && $_GET['editlink'] > 0){
   $sql_query = ("UPDATE $table SET approval = '1' WHERE link_id ='".$_GET['editlink']."' LIMIT 1");
   $wpdb->query($sql_query );
   $up_url = "link-manager.php?page=".myLinksDumpPath;
   ?>
   <script type="text/javascript">
     window.location.replace("<?php echo $up_url?>")
   </script>
   <?php
  }
 ?>

<div class="wrap"> 
<?php echo "<h2>" . __('List of links', 'myLinksDump') . "</h2>"; ?>
<form method="post" action="<?php echo "link-manager.php?page=".myLinksDumpPath; ?>" name="link_form">
<ul class="subsubsub">
 <li><strong><?php echo __('Total Links', 'myLinksDump').": </strong>".$all_links ?></li>
</ul>
<p class="search-box">
<span><?php echo __('Sort by:', 'myLinksDump') ?></span>
<select name="sort_by">
 <option value="" ><?php echo __('Select Column', 'myLinksDump') ?></option>
 <option value="visits"     <?php echo $selected_vistis ?>><?php echo __('Visits', 'myLinksDump') ?></option>
 <option value="title"      <?php echo $selected_title ?>><?php echo __('Title', 'myLinksDump') ?></option>
 <option value="url"        <?php echo $selected_url ?>><?php echo __('Link URL', 'myLinksDump') ?></option>
 <option value="date_added" <?php echo $selected_date_added ?>><?php echo __('Date Added', 'myLinksDump') ?></option>
 <option value="approval" <?php echo $selected_approved ?>><?php echo __('تاییده', 'myLinksDump') ?></option>
</select>
<select name="sort_order">
 <option value=""><?php echo __('Select Direction', 'myLinksDump') ?></option>
 <option value="ASC"  <?php echo $selectd_order_asc ?>><?php echo __('Ascending', 'myLinksDump') ?></option>
 <option value="DESC" <?php echo $selectd_order_desc ?>><?php echo __('Descending', 'myLinksDump') ?></option>
</select>
<input id="post-search-input" class="search-input" type="text" value="" name="s"/>
<input type="hidden" value="Y" name="search_status"/>
<input class="button" type="submit" value="<?php echo _e('Search', 'myLinksDump')?>"/>
</p>
 <table class="widefat fixed" cellspacing="0">
 <thead>
  <tr>
   <th id="cb" scope="col" class="manage-column column-cb check-column">
    <input type="checkbox" name="checkAll" value=""/>
   </th>
   <th scope="col" class="manage-column column-name"><?php echo __('Title', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name"><?php echo __('Description', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name" style="text-align:center"><?php echo __('Date Added', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name" style="text-align:center;width:60px"><?php echo __('Visits', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name" style="width:40px"><?php echo __('Edit', 'myLinksDump') ?></th>
  </tr>
 </thead>
 <tbody>
 <?php
 if (!empty($ret_links)){
  foreach ($ret_links as $ldlink) {
   $a++;
  if ($ldlink['approval'] == 0 ){
   $style = 'style="background-color: #FFFFD2"';
  }else{
   $style = '';
  }
  if ($a % 2) {
  ?> 
   <tr class="alternate" valign="middle" id="link-2" <?php echo $style; ?>>
  <?php
   }else{
   ?>
   <tr valign="middle" id="link-2" <?php echo $style; ?>>
   <?php
   }
   ?>
    <th class="check-column" scope="row">
      <input type="checkbox" name="links_group[]" value="<?php echo $ldlink['link_id']?>"/>
    </th>
    <td class="column-name">
     <strong>
      <a href="<?php echo $ldlink['url']?>" title="<?php echo $ldlink['url']?>" onclick="window.open(this.href,'newwin'); return false;"><?php echo $ldlink['title']?></a>
     </strong>
    </td>
    
    <td class="column-name">
     <p>
      <?php echo $ldlink['description']?>
     </p>
    </td>
    <td class="column-name">
       <?php 
       if (function_exists('jdate')) {
        //Jalali Calendar specific styling.
        echo '<p style="direction:ltr;text-align:center">'.$post_date = jdate("Y/m/d", $ldlink['date_added']);
       }else{
        echo '<p>'.$post_date = date("Y-d-m", $ldlink['date_added']);
       }
        ?>
     </p>
    </td>
    <td class="column-name" style="text-align:center;">
     <strong>
      <?php echo $ldlink['visits']?>
     </strong>
    </td>
    <td class="column-name" style="width:40px">
     <strong>
      <a href="<?php echo "edit.php?page=".myLinksDumpPath; ?>&editlink=<?php echo $ldlink['link_id']?>" >
       <img src="<?php echo get_option('siteurl');?>/wp-content/plugins/myLinksDump/images/edit.png" title="<?php echo __('Edit Link', 'myLinksDump') ?>" alt="<?php echo __('Edit Link', 'myLinksDump') ?>" />       
      </a>
      <a href="<?php echo "link-manager.php?page=".myLinksDumpPath; ?>&editlink=<?php echo $ldlink['link_id']?>" >
      <img src="<?php echo get_option('siteurl');?>/wp-content/plugins/myLinksDump/images/thumb-up.png" title="<?php echo __('Approve Link', 'myLinksDump') ?>" alt="<?php echo __('Edit Link', 'myLinksDump') ?>" />
      </a>
     </strong>
    </td>
   </tr>
 <?php
 
 //Flush sorting variables.
 $selected_vistis     = '';
 $selected_url        = '';
 $selected_date_added = '';
 $selected_title      = '';
 $selectd_order_asc   = '';
 $selectd_order_desc  = '';
  }
 }
 ?>
 </tbody>
 <tfoot>
  <tr>
   <th id="cb" scope="col" class="manage-column column-cb check-column">
    <input type="checkbox" name="checkAll" value=""/>
   </th>
   <th scope="col" class="manage-column column-name"><?php echo __('Title', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name"><?php echo __('Description', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name" style="text-align:center"><?php echo __('Date Added', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name" style="text-align:center;width:60px"><?php echo __('Visits', 'myLinksDump') ?></th>
   <th scope="col" class="manage-column column-name" style="width:40px"><?php echo __('Edit', 'myLinksDump') ?></th>
  </tr>
 </tfoot>
 </table>

  <div class="tablenav">
  <div class="alignleft actions">
  <select name="action2">
   <option selected="selected" value="-1"><?php echo __('Bulk Actions', 'myLinksDump') ?></option>
   <option value="delete"><?php echo __('Delete', 'myLinksDump') ?></option>
   <option value="approve"><?php echo __('Approve', 'myLinksDump') ?></option>
  </select>
  <script type="text/javascript">
  function warning(){
   action = window.confirm("<?php echo __('Are you sure?', 'myLinksDump') ?>");
   if (action){
    document.link_form.submit();
   }else{
    return false;
   }
  }
  </script>
  <input type="submit" class="button-secondary action" id="doaction2" name="doaction2" value="<?php echo __('Apply', 'myLinksDump') ?>" onclick="return warning();"/>
  <br class="clear"/>
  </div>
  <br class="clear"/>
  </div>
  <br />
  <table class="widefat">
			<tr class="alternate">
				<td colspan="2" align="center">
				  <div <?php echo $myLDNavigationBarStyle; ?>>
            <?php
            if ($pageno == 1) {
             echo " ".__('First', 'myLinksDump')." ".__('Prev', 'myLinksDump')." ";
            } else {
             echo " <a href=\"link-manager.php?page=".myLinksDumpPath."&pge=1\">".__('First', 'myLinksDump')."</a>";
             $prevpage = $pageno-1;
             echo " <a href=\"link-manager.php?page=".myLinksDumpPath."&pge=".$prevpage."\">&laquo ".__('Prev', 'myLinksDump')."</a> ";
            }
           echo " ( ".__('Page', 'myLinksDump')." $pageno ".__('of', 'myLinksDump')." $lastpage ) ";
           if ($pageno == $lastpage) {
             echo " ".__('Next', 'myLinksDump')." ".__('Last', 'myLinksDump')." ";
          } else {
             $nextpage = $pageno+1;
             echo " <a href=\"link-manager.php?page=".myLinksDumpPath."&pge=".$nextpage."\">".__('Next', 'myLinksDump')." &raquo</a> ";
             echo " <a href=\"link-manager.php?page=".myLinksDumpPath."&pge=".$lastpage."\">".__('Last', 'myLinksDump')."</a> ";
          }
          ?>
        </div>
				</td>
			</tr>
	</table>
</form>
<br />
<h2 style="background-image:url('<?php echo get_option('siteurl');?>/wp-content/plugins/myLinksDump/images/stat.png');background-repeat: no-repeat;padding-left:60px">
 <?php 
 echo __('Top 10 Links', 'myLinksDump');
 ?>
 </h2>
 <table class="widefat">
 <?php
 $sql_query = (" SELECT * FROM ".$table." ORDER BY visits DESC LIMIT 0, 10");
 $ret_links = $wpdb->get_results($sql_query , ARRAY_A);
 if (!empty($ret_links)){
  foreach ($ret_links as $ldlink) {
 ?>
  <tr>
		<td class="column-name">
		<a target="_blank" href="<?php echo $ldlink['url']; ?>">
		 <?php echo $ldlink['title']; ?>
		</a>
		</td>
		<td class="column-name" style="text-align:center">
		<?php echo $ldlink['visits']; ?>
		</td>
	</tr>
 <?php
  }
 }
  ?>
</table>			
<br />
<h2 style="background-image:url('<?php echo get_option('siteurl');?>/wp-content/plugins/myLinksDump/images/stat_month.png');background-repeat: no-repeat;padding-left:60px">
 <?php 
 echo __('Top 10 Links of Month', 'myLinksDump');
 ?>
 </h2>
 <table class="widefat">
 <?php
 $sql_query = (" SELECT * FROM ".$table." WHERE month(FROM_UNIXTIME(date_added)) = month(now()) ORDER BY visits DESC LIMIT 0, 10");
 $ret_links = $wpdb->get_results($sql_query , ARRAY_A);
 if (!empty($ret_links)){
  foreach ($ret_links as $ldlink) {
 ?>
  <tr>
		<td class="column-name">
		<a target="_blank" href="<?php echo $ldlink['url']; ?>">
		 <?php echo $ldlink['title']; ?>
		</a>
		</td>
		<td class="column-name">
		<?php echo $ldlink['visits']; ?>
		</td>
	</tr>
 <?php
  }
 }
  ?>
</table>
<br />
<h2 style="background-image:url('<?php echo get_option('siteurl');?>/wp-content/plugins/myLinksDump/images/stat_week.png');background-repeat: no-repeat;padding-left:60px">
 <?php 
 echo __('Top 10 Links of Week', 'myLinksDump');
 ?>
 </h2>
 <table class="widefat">
 <?php
 $sql_query = (" SELECT * FROM ".$table." WHERE week(FROM_UNIXTIME(date_added)) = week(now()) ORDER BY visits DESC LIMIT 0, 10");
 $ret_links = $wpdb->get_results($sql_query , ARRAY_A);
 if (!empty($ret_links)){
  foreach ($ret_links as $ldlink) {
 ?>
  <tr>
		<td class="column-name">
		<a target="_blank" href="<?php echo $ldlink['url']; ?>">
		 <?php echo $ldlink['title']; ?>
		</a>
		</td>
		<td class="column-name">
		<?php echo $ldlink['visits']; ?>
		</td>
	</tr>
 <?php
  }
 }
  ?>
</table>				
</div>

<div class="clear"/></div>	
<?php


}

//Setting page.
add_action('admin_menu', 'myLinksDump_option_page');
function myLinksDump_option_page() {
 add_options_page(__('myLinksDump', 'myLinksDump'), __('myLinksDump', 'myLinksDump'), 1, __FILE__, 'myLinksDump_options');
}

function myLinksDump_options() {

 if($_POST['posted_option_hidden'] == 'Y') {

    
    $ld_linkdump_title  = $_POST['ld_linkdump_title'];
		update_option('ld_linkdump_title', $ld_linkdump_title);
		
		$ld_linkdump_widget_title = $_POST['ld_linkdump_widget_title'];
		update_option('ld_linkdump_widget_title', $ld_linkdump_widget_title);
		
    $nw_option  = $_POST['ld_open_nw'];
		update_option('ld_open_nw', $nw_option);
		
		$ld_open_branding = $_POST['ld_open_branding'];
		update_option('ld_open_branding', $ld_open_branding);
		
		$ld_stylesheet_option  = $_POST['ld_stylesheet'];
		update_option('ld_stylesheet', $ld_stylesheet_option);
		
		$ld_number_of_links = $_POST['ld_number_of_links'];
		update_option('ld_number_of_links', $ld_number_of_links);
		
		$ld_number_of_links_widget = $_POST['ld_number_of_links_widget'];
		update_option('ld_number_of_links_widget', $ld_number_of_links_widget);
		
		$ld_number_of_rss_links = $_POST['ld_number_of_rss_links'];
		update_option('ld_number_of_rss_links', $ld_number_of_rss_links);
		
		$ld_number_of_links_be = $_POST['ld_number_of_links_be'];
		update_option('ld_number_of_links_be', $ld_number_of_links_be);
		
		$ld_repeated_link = $_POST['ld_repeated_link'];
		update_option('ld_repeated_link', $ld_repeated_link);
		
		$ld_linkdump_fd = $_POST['ld_linkdump_fd'];
		update_option('ld_linkdump_fd', $ld_linkdump_fd);
		
		$ld_linkdump_rss_desc = $_POST['ld_linkdump_rss_desc'];
		update_option('ld_linkdump_rss_desc', $ld_linkdump_rss_desc);
		
		$ld_branding_bg = str_replace("#", "", $_POST['ld_branding_bg']);
		update_option('ld_branding_bg', $ld_branding_bg);
		
		$ld_archive_days = $_POST['ld_archive_days'];
		update_option('ld_archive_days', $ld_archive_days);
		
		$ld_archive_pid = $_POST['ld_archive_pid'];
		update_option('ld_archive_pid', $ld_archive_pid);
		
		$ld_show_counter = $_POST['ld_show_counter'];
		update_option('ld_show_counter', $ld_show_counter);
		
		$ld_show_description = $_POST['ld_show_description'];
		update_option('ld_show_description', $ld_show_description);
		
		$ld_show_description_w = $_POST['ld_show_description_w'];
		update_option('ld_show_description_w', $ld_show_description_w);
						
		$ld_send_notification = $_POST['ld_send_notification'];
		update_option('ld_send_notification', $ld_send_notification);
		
		$ld_auto_approve = $_POST['ld_auto_approve'];
		update_option('ld_auto_approve', $ld_auto_approve);
		
		$ld_short_url = $_POST['ld_short_url'];
		update_option('ld_short_url', $ld_short_url);
		
		//$ld_delicous_username = $_POST['ld_delicous_username'];
		//update_option('ld_delicous_username', $ld_delicous_username);
		
		//if (!empty($_POST['ld_delicous_password'])){
		// $ld_delicous_password = md5($_POST['ld_delicous_password']);
		// update_option('ld_delicous_password', $ld_delicous_password);
		//}

		
		?>
		<div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
		<?php
		} else {
       $ld_linkdump_title         = get_option('ld_linkdump_title');
       $ld_linkdump_widget_title  = get_option('ld_linkdump_widget_title');
		   $nw_option                 = get_option('ld_open_nw');
		   $ld_open_branding          = get_option('ld_open_branding');
		   $ld_stylesheet_option      = get_option('ld_stylesheet');
		   $ld_number_of_links        = get_option('ld_number_of_links');
		   $ld_number_of_links_widget = get_option('ld_number_of_links_widget');
		   $ld_number_of_rss_links    = get_option('ld_number_of_rss_links');
		   $ld_number_of_links_be     = get_option('ld_number_of_links_be');
		   $ld_repeated_link          = get_option('ld_repeated_link');
		   $ld_linkdump_fd            = get_option('ld_linkdump_fd');
		   $ld_linkdump_rss_desc      = get_option('ld_linkdump_rss_desc');
		   $ld_branding_bg            = get_option('ld_branding_bg');
		   $ld_archive_days           = get_option('ld_archive_days');
		   $ld_archive_pid            = get_option('ld_archive_pid');
		   $ld_show_counter           = get_option('ld_show_counter');
		   $ld_show_description       = get_option('ld_show_description');
		   $ld_show_description_w     = get_option('ld_show_description_w');
		   $ld_send_notification      = get_option('ld_send_notification');
		   $ld_auto_approve           = get_option('ld_auto_approve');
		   $ld_short_url              = get_option('ld_short_url');
		   //$ld_delicous_username      = get_option('ld_delicous_username');
		}

?>
 <div class="wrap">
   <?php echo "<h2>" . __('myLinksDump Settings', 'myLinksDump') . "</h2>"; ?>
   <img style="float:right;" src="<?php echo get_option('siteurl');?>/wp-content/plugins/myLinksDump/images/myLinksDumpLogo.gif" />
   <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
   <?php wp_nonce_field('update-options'); ?>
   <input type="hidden" name="posted_option_hidden" value="Y">
   <table class="form-table">
     <tr valign="top">
     <th scope="row"><?php echo __('Links Dump Title', 'myLinksDump')?>:</th>
      <td><input type="text" name="ld_linkdump_title" value="<?php echo $ld_linkdump_title?>" size="40"/></td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Links Dump Title(Widget)', 'myLinksDump')?>:</th>
      <td><input type="text" name="ld_linkdump_widget_title" value="<?php echo $ld_linkdump_widget_title?>" size="40"/></td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Number of links to display(front-end)', 'myLinksDump')?>:</th>
      <td>
          <input type="text" name="ld_number_of_links" value="<?php echo $ld_number_of_links?>" size="2"/>
          <span style="<?php echo tipStyle; ?>"><?php echo __('Items per page.', 'myLinksDump')?></span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Number of links to display(widget)', 'myLinksDump')?>:</th>
      <td>
          <input type="text" name="ld_number_of_links_widget" value="<?php echo $ld_number_of_links_widget?>" size="2"/>
          <span style="<?php echo tipStyle; ?>"><?php echo __('Items per page.', 'myLinksDump')?></span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Number of links to display(back-end)', 'myLinksDump')?>:</th>
      <td>
          <input type="text" name="ld_number_of_links_be" value="<?php echo $ld_number_of_links_be?>" size="2"/>
          <span style="<?php echo tipStyle; ?>"><?php echo __('Items per page.', 'myLinksDump')?></span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Number of links to display(RSS feed)', 'myLinksDump')?>:</th>
      <td>
          <input type="text" name="ld_number_of_rss_links" value="<?php echo $ld_number_of_rss_links?>" size="2"/>
          <span style="<?php echo tipStyle; ?>"><?php echo __('Items per page.', 'myLinksDump')?></span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Number of days to display(archive)', 'myLinksDump')?>:</th>
      <td>
       <input type="text" name="ld_archive_days" value="<?php echo $ld_archive_days?>" size="2"/>
       <span style="<?php echo tipStyle; ?>"><?php echo __('Items per page.', 'myLinksDump')?></span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Archive page ID', 'myLinksDump')?>:</th>
      <td>
      <input type="text" name="ld_archive_pid" value="<?php echo $ld_archive_pid?>" size="2"/><br />
      <span style="<?php echo tipStyle; ?>"><?php echo __('If you don\'t know about this, then read FAQ in readme.txt file.', 'myLinksDump')?></span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Show counter', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_show_counter">
      <?php
        if ($ld_show_counter == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Short URL', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_short_url">
      <?php
        if ($ld_short_url == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
      <br/>
      <span style="<?php echo tipStyle; ?>"><?php echo __('Whether to show full address upon showing link or just show short form.', 'myLinksDump')?></span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Show description(front-end)', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_show_description">
      <?php
        if ($ld_show_description == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Show description(widget)', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_show_description_w">
      <?php
        if ($ld_show_description_w == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Allow repeated link', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_repeated_link">
      <?php
        if ($ld_repeated_link == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Open links in new window', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_open_nw">
      <?php
        if ($nw_option == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
     </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Open links with my branding', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_open_branding">
      <?php
        if ($ld_open_branding == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
     </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Send notification email on user submission', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_send_notification">
      <?php
        if ($ld_send_notification == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
     </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Auto approve submitted links', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_auto_approve">
      <?php
        if ($ld_auto_approve == 1){
      ?>
        <option value="1" selected="selected"><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" ><?php echo __(' No ', 'myLinksDump')?></option>
      <?php 
        }else{
      ?>
        <option value="1" ><?php echo __(' Yes ', 'myLinksDump')?></option>
        <option value="0" selected="selected"><?php echo __(' No ', 'myLinksDump')?></option>
      <?php
        }
      ?>
      </select>
     </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('Branding bar background color', 'myLinksDump')?>:</th>
      <td>
       <input type="text" name="ld_branding_bg" value="<?php echo $ld_branding_bg?>" size="8"/>
       <br/>
       <span style="<?php echo tipStyle; ?>"><?php echo __('It must be in HEX format without leading # sign.', 'myLinksDump')?></span>
     </td>
     </tr>
     
     <tr valign="top">
     <th scope="row"><?php echo __('Links dump style', 'myLinksDump')?>:</th>
      <td>
      <select name="ld_stylesheet">
      <?php
      $dir_path = str_replace( $_SERVER['SCRIPT_FILENAME'], "", dirname(realpath(__FILE__)) ) . DIRECTORY_SEPARATOR;
      $handle=opendir($dir_path.'/styles/');
       while (false!==($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
         if ($ld_stylesheet_option == $file )
          echo "<option value=\"".$file."\" selected=\"selected\">".$file."</option>\n";
         else
          echo "<option value=\"".$file."\">".$file."</option>\n";
         }
        }
        closedir($handle); 
         
      ?>
      </select><br/>
      <span style="<?php echo tipStyle; ?>"><?php echo __('This will be used to set style of Link Dump on front-end.', 'myLinksDump')?></span>
      
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('myLinksDump FeedBurner address', 'myLinksDump')?>:</th>
      <td>
      <input type="text" name="ld_linkdump_fd" value="<?php echo $ld_linkdump_fd?>" size="40"/>
      <br/>
      <span style="<?php echo tipStyle; ?>">
       <?php echo __('If you leave this field blank, default RSS output will be shown.', 'myLinksDump')?>
      </span>
      </td>
     </tr>
     <tr valign="top">
     <th scope="row"><?php echo __('myLinksDump RSS description', 'myLinksDump')?>:</th>
      <td>
      <input type="text" name="ld_linkdump_rss_desc" value="<?php echo $ld_linkdump_rss_desc?>" size="40"/>
      <br/>
      <span style="<?php echo tipStyle; ?>">
       <?php echo __('Specify your description for myLinksDump RSS feed.', 'myLinksDump')?>
      </span>
      </td>
     </tr>
   </table>
   <input type="hidden" name="action" value="update" />
   <input type="hidden" name="page_options" value="link_title,link" />
   <p class="submit">
    <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
   </p>

   </form>
   <center>
    <img title="Image by Vane Kosturanov" src="<?php echo get_option('siteurl');?>/wp-content/plugins/myLinksDump/images/hr-vane-kosturanov-enjoy.jpg"/>
   </center>
   <h4><?php _e('Notes on using quick add feature', 'myLinksDump'); ?></h4>
   <p><?php _e('You can add link to your links dump while you are surfing using your browser. 
      In order to do this bookmark generated link and press it when ever you liked a 
      link. When you press this bookmark, you\'ll be presented with pop-up window filled with 
      the URL and title of the link you&#39;ve liked. By the time you did this, you can 
      type your remark on that link and press <strong>Add My Link!</strong> button.', 'myLinksDump');?>
   </p>
   <br/>
   <span class="<?php echo tipStyle; ?>"><?php echo __('Generated Bookmard', 'myLinksDump');?>:</span>
   <a href="<?php echo "javascript:void(window.open('".get_option('siteurl')."/myLDAdd.php?url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title),null,'height=200,width=450,scrollbars=yes'))"?>" title=""><?php echo __('myLD Quick Adder', 'myLinksDump');?></a><br /><br />
   <div style="border:1px solid #FFCC00;width:225px;height:25px;background-color: #FFFFCC;text-align:center;padding:8px 0px 1px 0px;">
   <a style="text-decoration:none" href="<?php echo get_option('siteurl').'/wp-content/plugins/myLinksDump/images/dragndrop.gif'?>" target="_blank">
    <?php echo __('Click Here to See How', 'myLinksDump');?>
   </a>
   </div>
</div>	
<?php

}

if (get_option('ld_linkdump_fd') != ''){
 $rss_feed = get_option('ld_linkdump_fd');
}else{
 $rss_feed = get_option('siteurl').'/myLDRSS.php'; 
}

function writeCSS() {
 $ld_stylesheet_option  = get_option('ld_stylesheet');
 $style_path = get_option('siteurl').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/styles/'.$ld_stylesheet_option;
 echo '<link rel="stylesheet" type="text/css" href="'.$style_path.'" >'; 
 global $rss_feed ;
 echo '<link rel="alternate" type="application/rss+xml" title="'.get_option('ld_linkdump_rss_desc').'" href="'.$rss_feed.'" />';
}
add_action('wp_head', 'writeCSS');

//Making widget.
function myLinksDump_widget($args) {  
  echo myLinksDump_show("widget") ;
} 
function myLinksDump_widget_init() {  
   wp_register_sidebar_widget('myLinksDump_widget', __('myLinksDump', 'myLinksDump'), 'myLinksDump_widget');  
   wp_register_widget_control('myLinksDump_widget', __('myLinksDump', 'myLinksDump'), 'myLinksDump_widget_control');
}  
   
// Register widget to WordPress  
add_action("plugins_loaded", "myLinksDump_widget_init");

function myLinksDump_widget_control() { 

 $widget_data = $_POST['widget_options_hidden'];  
 if ($widget_data == 'Y') { 
 
  $ld_linkdump_widget_title    = $_POST['ld_linkdump_widget_title'];
	update_option('ld_linkdump_widget_title', $ld_linkdump_widget_title);

  $ld_number_of_links_widget    = $_POST['ld_number_of_links_widget'];
	update_option('ld_number_of_links_widget', $ld_number_of_links_widget);
	
 }else{
  $ld_linkdump_widget_title   = get_option('ld_linkdump_widget_title');
  $ld_number_of_links_widget  = get_option('ld_number_of_links_widget');
  
 }
?>
 <p>  
   <label for="ld_linkdump_widget_title">  
   <?php
     echo __('Widget Title:', 'myLinksDump');
   ?>    
   </label>  
   <input class="widefat" type="text" name="ld_linkdump_widget_title" id="" value="<?php echo $ld_linkdump_widget_title; ?>"/> 
   <label for="ld_number_of_links_widget">  
   <?php
     echo __('Number of links to display:', 'myLinksDump');
   ?>    
   </label>  
   <input class="widefat" type="text" name="ld_number_of_links_widget" id="" value="<?php echo $ld_number_of_links_widget; ?>"/>  
 </p>  
  <input type="hidden" name="widget_options_hidden" value="Y">
<?php
}

/*
function myLinksDump_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_myplugin_tinymce_plugin");
     add_filter('mce_buttons', 'register_myplugin_button');
   }
}
 
function register_myLinksDump_button($buttons) {
   array_push($buttons, "separator", "myplugin");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_myplugin_tinymce_plugin($plugin_array) {
   $plugin_array['myplugin'] = URLPATH.'tinymce/editor_plugin.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'myLinksDump_addbuttons');

*/


//Display links at Front-end.
function myLinksDump_show($type="standard") {
 global $wpdb;
 $wpdb->hide_errors();
 $table    = $wpdb->prefix."links_dump";

 
 if ($type != "widget"){
  $ld_number_of_links = get_option('ld_number_of_links');
 }else{
  $ld_number_of_links = get_option('ld_number_of_links_widget');
 }
 $nw_option          = get_option('ld_open_nw');
 if ($nw_option == 1){
  $open_in_new_win = 'onclick="window.open(this.href,\'newwin\'); return false;"';
 }else{
  $open_in_new_win = '';
 }
 
 $order = 'ORDER BY link_id DESC';
 if (isset($_GET['sort']) && $_GET['sort'] == "visits"){
  $order = ' ORDER BY visits DESC';
 }
 if (isset($_GET['sort']) && $_GET['sort'] == "title"){
  $order = ' ORDER BY title DESC';
 }

 $sql_query          = $wpdb->prepare(" SELECT * FROM ".$table." WHERE approval = '1' $order LIMIT 0 ,".$ld_number_of_links);
 $returned_links     = $wpdb->get_results($sql_query , ARRAY_A);
 
  
 //Widget specific markup
 if ($type == "widget"){
 $ldBlock            = '<li class="widget">';
 $ldBlock           .= '<h2 class="widgettitle">'.get_option('ld_linkdump_widget_title').'</h2>
                       <ul>';
 if (!empty($returned_links)){
  $linker = get_option('siteurl').'/myLDlinker.php?url=';
  foreach ($returned_links as $ldlink) {
   //Check for counter display status.
   $counter  = get_option('ld_show_counter');
   if ($counter == 1){
    $counter_status = '&nbsp;('.$ldlink['visits'].')';
   }else{
    $counter_status = '';
   }
   //Check for description display status.
   $desc  = get_option('ld_show_description_w');
   if ($desc == 1){
    $desc_status = '<p class="ldDescriptionW">'.$ldlink['description'].'</p>';
   }else{
    $desc_status = '';
   }
   if (!get_option('ld_short_url')){
    $short_url = '&site='.$ldlink['url'];
   }else{
    $short_url = "";
   }
   $ldBlock .= '<li>
                 <a href="'.$linker.$ldlink['link_id'].$short_url.'" title="'.$ldlink['description'].'" '.$open_in_new_win.'>'.$ldlink['title'].'</a>
                 <span>'.$counter_status.'</span></li>'.$desc_status;
  }
 }
 $ldBlock .= '</ul></li>';

 }else{
 
 $ldBlock            = '<div class="ldWrapper">
                         <h2 id="ldTitle">'.get_option('ld_linkdump_title').'</h2>
                         <ul>';
 if (!empty($returned_links)){
  $linker = get_option('siteurl').'/myLDlinker.php?url=';
  foreach ($returned_links as $ldlink) {
  
   //Check for counter display status.
   $counter  = get_option('ld_show_counter');
   if ($counter == 1){
    $counter_status = '&nbsp;('.$ldlink['visits'].')';
   }else{
    $counter_status = '';
   }
  
   //Check for description display status.
   $desc  = get_option('ld_show_description');
   if ($desc == 1){
    $desc_status = '<p class="ldDescription">'.$ldlink['description'].'</p>';
   }else{
    $desc_status = '';
   }
   if (!get_option('ld_short_url')){
    $short_url = '&site='.$ldlink['url'];
   }else{
    $short_url = "";
   }
   $ldBlock .= '<li>
                 <a href="'.$linker.$ldlink['link_id'].$short_url.'" title="'.$ldlink['description'].'" '.$open_in_new_win.'>'.$ldlink['title'].'</a>
                 <span>'.$counter_status.'</span></li>'.$desc_status;
  }
 }
 $ldBlock .= '</ul></div>';
 
}
  
 return $ldBlock;

}

function myLinksDumpRandom() {
 global $wpdb;
 $table = $wpdb->prefix."links_dump";
 $nw_option          = get_option('ld_open_nw');
 if ($nw_option == 1){
  $open_in_new_win = 'onclick="window.open(this.href,\'newwin\'); return false;"';
 }else{
  $open_in_new_win = '';
 }
 $ld_number_of_links = 10;
   $sql = "SELECT * FROM $table WHERE approval = 1 ORDER BY RAND() LIMIT 0, $ld_number_of_links";
 $returned_links = $wpdb->get_results($sql , ARRAY_A);
 //$ldBlock .= '<ul class="ldRandom">';
 if (!empty($returned_links)){
  $linker = get_option('siteurl').'/myLDlinker.php?url=';
  foreach ($returned_links as $ldlink) {
   //Check for counter display status.
   $counter  = get_option('ld_show_counter');
   if ($counter == 1){
    $counter_status = '&nbsp;('.$ldlink['visits'].')';
   }else{
    $counter_status = '';
   }
   //Check for description display status.
   $desc  = get_option('ld_show_description_w');
   if ($desc == 1){
    $desc_status = '<p class="ldDescriptionW">'.$ldlink['description'].'</p>';
   }else{
    $desc_status = '';
   }
   $ldBlock .= '<li>
                 <a href="'.$linker.$ldlink['link_id'].'&site='.$ldlink['url'].'" title="'.$ldlink['description'].'" '.$open_in_new_win.'>'.$ldlink['title'].'</a>
                 <span>'.$counter_status.'</span></li>'.$desc_status;
  }
 }
 $ldBlock .= '';
 return $ldBlock;
}

function myLinksTopMonth() {
 global $wpdb;
 $table = $wpdb->prefix."links_dump";
 $nw_option          = get_option('ld_open_nw');
 if ($nw_option == 1){
  $open_in_new_win = 'onclick="window.open(this.href,\'newwin\'); return false;"';
 }else{
  $open_in_new_win = '';
 }
 $ld_number_of_links = 20;
   $sql = "SELECT * FROM ".$table." WHERE month(FROM_UNIXTIME(date_added)) = month(now()) AND approval = 1 ORDER BY visits DESC LIMIT 0, $ld_number_of_links";
 $returned_links = $wpdb->get_results($sql , ARRAY_A);
 //$ldBlock .= '<ul class="ldRandom">';
 if (!empty($returned_links)){
  $linker = get_option('siteurl').'/myLDlinker.php?url=';
  foreach ($returned_links as $ldlink) {
   //Check for counter display status.
   $counter  = get_option('ld_show_counter');
   if ($counter == 1){
    $counter_status = '&nbsp;('.$ldlink['visits'].')';
   }else{
    $counter_status = '';
   }
   //Check for description display status.
   $desc  = get_option('ld_show_description_w');
   if ($desc == 1){
    $desc_status = '<p class="ldDescriptionW">'.$ldlink['description'].'</p>';
   }else{
    $desc_status = '';
   }
   $ldBlock .= '<li>
                 <a href="'.$linker.$ldlink['link_id'].'&site='.$ldlink['url'].'" title="'.$ldlink['description'].'" '.$open_in_new_win.'>'.$ldlink['title'].'</a>
                 <span>'.$counter_status.'</span></li>'.$desc_status;
  }
 }
 $ldBlock .= '';
 return $ldBlock;
}

function myLinksDump_Archive($option=''){

$pid = get_option('ld_archive_pid');
if (is_page($pid)){
 $lastdate = '';
 $rows_per_page = get_option('ld_archive_days');
 global $wpdb;
 $table              = $wpdb->prefix."links_dump";
 
 if (isset($_GET['pge'])) {
   $pageno = $_GET['pge'];
  } else {
   $pageno = 1;
 }
 
 $sql_query = " SELECT count(link_id) as cnt FROM ".$table;
 $all_links =  $wpdb->get_var($sql_query);

 $days = $all_links;
 
 $lastpage  = ceil($days/$rows_per_page);
 
 $pageno = (int)$pageno;
 if ($pageno > $lastpage) {
   $pageno = $lastpage;
 } 
 if ($pageno < 1) {
   $pageno = 1;
 } 
 $order = 'ORDER BY date_added DESC';
 if (isset($_GET['sort']) && $_GET['sort'] == "visit"){
  $order = 'ORDER BY visits DESC';
 }
 if (isset($_GET['sort']) && $_GET['sort'] == "title"){
  $order = 'ORDER BY title DESC';
 }

 $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
 $sql_query = " SELECT link_id, title, url, description,date_added, visits, DATE_FORMAT(FROM_UNIXTIME(`date_added`), '%Y %M %D') AS thedate 
                                        FROM ".$table." WHERE approval = '1' ".$order. " ".$limit;
 $ret_links = $wpdb->get_results($sql_query , ARRAY_A);
 
 $linker = get_option('siteurl').'/myLDlinker.php?url=';
 $nw_option          = get_option('ld_open_nw');
 if ($nw_option == 1){
  $open_in_new_win = 'onclick="window.open(this.href,\'newwin\'); return false;"';
 }else{
  $open_in_new_win = '';
 }
 
 
 

  $wpdb->hide_errors();
  $table     = $wpdb->prefix."links_dump";
  $sql_query = "SELECT count(link_id) FROM $table";
  $total_links = $wpdb->get_var($sql_query);
 
?>
 
<div class="ldWrapper">
 <h2 id="ldTitle"><?php echo get_option('ld_linkdump_title')?></h2>
 <span style="display:inline-block;float:left">
 <?php
  echo __('Total Links', 'myLinksDump') ." : ".$total_links;
 ?>
 </span>
 <?php
 if (get_settings('permalink_structure') != ""){
  $archive_url = get_permalink($pid)."?sort=";
 }else{
  $archive_url = get_permalink($pid)."&sort=";
 }
 ?>
 <span style="display:inline-block;float:right">
  <a href="<?php echo $archive_url; ?>visit"><?php echo __('Sort by Visits', 'myLinksDump'); ?></a>&nbsp;&nbsp;<span style="color:#5EAFD7">|</span>&nbsp;&nbsp;<a href="<?php echo $archive_url; ?>title"><?php echo __('Sort by Title', 'myLinksDump'); ?></a>
 </span>
 <br />
<ul>
<?php
 if (!empty($ret_links)){
 foreach ($ret_links as $ldlink) {
 
  if (function_exists('jdate')) {
     $post_date = jdate('l d F Y', $ldlink['date_added']);
  }else{
     $post_date = date("Y-d-m", $ldlink['date_added']);
  }
  //Check for counter display status.
   $counter  = get_option('ld_show_counter');
   if ($counter == 1){
    $counter_status = '&nbsp;('.$ldlink['visits'].')';
   }else{
    $counter_status = '';
   }
  if ($ldlink['thedate'] != $lastdate){
    ?>
    <div class="dateTitleArea"> 
    <span>
    <?php   
        echo $post_date;
    ?>
    </span>
    </div>    
    <?php   
       $lastdate = $ldlink['thedate'];
    }
    ?>
   <li>
   <?php
   //switch($ldlink['category']){
   //case 1:
   // $links_category = 'گوناگون';
   //break;
   //case 2:
   // $links_category = 'تصاویر و فیلم';
   //break;
   //case 3:
   // $links_category = 'کامپیوتر و اینترنت';
   //break;
   //case 4:
   // $links_category = 'سیاسی';
   //break;
   //}
   //$tip_block = '<strong>موضوع: '.$links_category.'</strong><p>'.$ldlink['description'].'</p>';
   ?>
   <span class="hotspot" onmouseover="tooltip.show('<?php echo $tip_block; ?>');" onmouseout="tooltip.hide();">
   <a href="<?php echo $linker.$ldlink['link_id'].'&site='.$ldlink['url'];?>" title="<?php echo $ldlink['description']."\"".$open_in_new_win; ?>><?php echo $ldlink['title'];?></a>
       <span>
        <?php echo $counter_status; ?>
       </span>
   </span>
   </li>
<?php
 }
 }
 $parsed_url = parse_url($_SERVER['REQUEST_URI']);
?>
  </ul> 
</div>
<br />
<?php 
if ($total_links > $rows_per_page){
?>
<div <?php echo $myLDNavigationBarStyle; ?>>
  <?php
  if (get_settings('permalink_structure') != ""){
   if ($pageno == 1) {
    echo " ".__('First', 'myLinksDump')." ".__('Prev', 'myLinksDump')." ";
   } else {
    echo " <a href=\"".get_permalink($pid)."?pge=1\">".__('First', 'myLinksDump')."</a>";
    $prevpage = $pageno-1;
    echo " <a href=\"".get_permalink($pid)."?pge=".$prevpage."\">&laquo ".__('Prev', 'myLinksDump')."</a> ";
   }
   echo " ( ".__('Page', 'myLinksDump')." $pageno ".__('of', 'myLinksDump')." $lastpage ) ";
   if ($pageno == $lastpage) {
    echo " ".__('Next', 'myLinksDump')." ".__('Last', 'myLinksDump')." ";
   } else {
    $nextpage = $pageno+1;
    echo " <a href=\"".get_permalink($pid)."?pge=".$nextpage."\">".__('Next', 'myLinksDump')." &raquo</a> ";
    echo " <a href=\"".get_permalink($pid)."?pge=".$lastpage."\">".__('Last', 'myLinksDump')."</a> ";
   }
  }else{
   if ($pageno == 1) {
    echo " ".__('First', 'myLinksDump')." ".__('Prev', 'myLinksDump')." ";
   } else {
    echo " <a href=\"".get_permalink($pid)."&pge=1\">".__('First', 'myLinksDump')."</a>";
    $prevpage = $pageno-1;
    echo " <a href=\"".get_permalink($pid)."&pge=".$prevpage."\">&laquo ".__('Prev', 'myLinksDump')."</a> ";
   }
   echo " ( ".__('Page', 'myLinksDump')." $pageno ".__('of', 'myLinksDump')." $lastpage ) ";
   if ($pageno == $lastpage) {
    echo " ".__('Next', 'myLinksDump')." ".__('Last', 'myLinksDump')." ";
   } else {
    $nextpage = $pageno+1;
    echo " <a href=\"".get_permalink($pid)."&pge=".$nextpage."\">".__('Next', 'myLinksDump')." &raquo</a> ";
    echo " <a href=\"".get_permalink($pid)."&pge=".$lastpage."\">".__('Last', 'myLinksDump')."</a> ";
   }
  }
  ?>
</div>
<?php
 }
//if ($option == 1){
//}
//}
}
}
?>
