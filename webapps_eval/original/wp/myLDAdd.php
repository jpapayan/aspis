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


$passed_title = $_GET['title'];
$passed_url   = $_GET['url'];

function is_valid_url ( $url )
{
		$url = @parse_url($url);
		if ( ! $url) {
			return false;
		}
		$url = array_map('trim', $url);
		$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
		$path = (isset($url['path'])) ? $url['path'] : '';
		if ($path == '')
		{
			$path = '/';
		}
		$path .= ( isset ( $url['query'] ) ) ? "?$url[query]" : '';

		if ( isset ( $url['host'] ) AND $url['host'] != gethostbyname ( $url['host'] ) )
		{
			if ( PHP_VERSION >= 5 )
			{
				$headers = get_headers("$url[scheme]://$url[host]:$url[port]$path");
			}
			else
			{
				$fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

				if ( ! $fp )
				{
					return false;
				}
				fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
				$headers = fread ( $fp, 128 );
				fclose ( $fp );
			}
			$headers = ( is_array ( $headers ) ) ? implode ( "\n", $headers ) : $headers;
			return ( bool ) preg_match ( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
		}
		return false;
}

function quick_add(){

 global $current_user;
 global $wpdb;

 $table = $wpdb->prefix."links_dump";
 $ld_repeated_link = get_option('ld_repeated_link');

 if (!empty($_POST['url']) && is_valid_url($_POST['url']) && !empty($_POST['title'])){
  get_currentuserinfo();
  if (!empty($current_user->user_login) && !empty($current_user->ID)){
     $sql_query = $wpdb->prepare("INSERT INTO ".$table." (link_id, title, url, description, visits, date_added, approval)
                                 VALUES (NULL , '".strip_tags($_POST['title'])."', '".$_POST['url'] ."', '"
                                 .strip_tags($_POST['description'])."', '0', '".time()."', '1')");
    if ($ld_repeated_link == 0){
     $sql      = "SELECT count(url) FROM ".$table." WHERE url = '".$_POST['url']."'";
     $repeated_urls  = $wpdb->get_var($sql);
    if ($repeated_urls < 1 ){
     $results   = $wpdb->query($sql_query);
    ?>
    <?php
    }else{
    ?>
    <?php
    } 
    }else{
    $results   = $wpdb->query($sql_query);
     ?>
    <?php
    }
    if ($results){
      ?>
      <div class="updated"><p><strong><?php _e('Link saved.', 'myLinksDump'); ?></strong></p></div>
      <?php
     }else{
      ?>
      <div class="error"><p><strong><?php _e('Link not saved. Entered link is already in database.', 'myLinksDump'); ?></strong></p></div>
      <?php
     }
  }else{
      echo '<span style="color:red;">Access denied.</span>';
  }
  
 }elseif(empty($_GET['url']) || empty($_GET['title'])){
      echo '<span style="color:red;">Please fill required fields.</span>'; 
 }

}

get_currentuserinfo();
if (!empty($current_user->user_login) && !empty($current_user->ID)){
  $access = 1;
}else{
  $access = 0;
}

if ($access){
?>
<html>
<head>
<title>Add New Link</title>
<style>
h1 {
 font: 1.2em Arial, Helvetica, sans-serif; 
}
 
input.txt {
 color: #00008B;
 background-color: #E3F2F7;
 border: 1px inset #00008B; 
 font: normal 0.7em Tahoma, Arial, Helvetica, sans-serif;
}
 
input.btn {
 color: #00008B;
 background-color: #ADD8E6;
 border: 1px outset #00008B; 
}
 
form div {
 clear: left;
 margin: 0;
 padding: 0;
 padding-top: 0.6em; 
 }
 
form div label {
 float: left;
 width: 40%;
 font: bold 0.8em Tahoma, Arial, Helvetica, sans-serif;
}
</style>
<script type="text/javascript">
 function ValidateForm(){
 
  var title=document.quickAddForm.title
  var url=document.quickAddForm.url
 
  if ((title.value==null)||(title.value=="")){
    alert("Please enter link title.")
    title.focus()
    return false
  }
 if ((url.value==null)||(url.value=="")){
    alert("Please enter link URL.")
    url.focus()
    return false
  }

  return true
  
 }

</script>
</head>

<body>
<form method="post" action="myLDAdd.php" name="quickAddForm" onsubmit="return ValidateForm();">
<fieldset>
 <legend><strong>Add your link</strong></legend>
 <div>
 <label for="title">Link Title:</label>
 <input type="text" name="title" id="title" class="txt" size="25" value="<?php echo $passed_title; ?>" />
 <span style="color:red;">*</span>
 </div>
 <div>
 <label for="url">URL:</label>
 <input type="text" name="url" id="url" class="txt" size="40" value="<?php echo $passed_url; ?>"/>
 <span style="color:red;">*</span>
 </div>
 <div>
 <label for="description">Description:</label> 
<input type="text" name="description" id="description" class="txt" size="40"/>
 </div>
 <div>
 <input type="submit" name="btnSubmit" id="btnSubmit" value="Add My Link!" class="btn" />
 <input type="reset" name="btnSubmit" id="btnSubmit" value="Reset" class="btn" />
 </div>
</fieldset>
</form>

</body>
</html>


<?php

}else{
  echo '<span style="color:red;">Access denied.</span>';
}
quick_add();
?>