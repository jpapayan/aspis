<?php require_once('AspisMain.php'); ?><?php
require_once ("wp-load.php");
$passed_title = deAspisWarningRC($_GET[0]['title']);
$passed_url = deAspisWarningRC($_GET[0]['url']);
function is_valid_url ( $url ) {
$url = @parse_url($url);
if ( !$url)
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}$url = array_map('trim',$url);
$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
$path = (isset($url['path'])) ? $url['path'] : '';
if ( $path == '')
 {$path = '/';
}$path .= (isset($url['query'])) ? "?$url[query]" : '';
if ( isset($url['host']) and $url['host'] != gethostbyname($url['host']))
 {if ( PHP_VERSION >= 5)
 {$headers = get_headers("$url[scheme]://$url[host]:$url[port]$path");
}else 
{{$fp = fsockopen($url['host'],$url['port'],$errno,$errstr,30);
if ( !$fp)
 {{$AspisRetTemp = false;
return $AspisRetTemp;
}}fputs($fp,"HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
$headers = fread($fp,128);
fclose($fp);
}}$headers = (is_array($headers)) ? implode("\n",$headers) : $headers;
{$AspisRetTemp = (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i',$headers);
return $AspisRetTemp;
}}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
function quick_add (  ) {
{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}{global $wpdb;
$AspisVar1 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$table = $wpdb->prefix . "links_dump";
$ld_repeated_link = get_option('ld_repeated_link');
if ( !(empty($_POST[0]['url']) || Aspis_empty($_POST[0]['url'])) && is_valid_url(deAspisWarningRC($_POST[0]['url'])) && !(empty($_POST[0]['title']) || Aspis_empty($_POST[0]['title'])))
 {get_currentuserinfo();
if ( !empty($current_user->user_login) && !empty($current_user->ID))
 {$sql_query = $wpdb->prepare("INSERT INTO " . $table . " (link_id, title, url, description, visits, date_added, approval)
                                 VALUES (NULL , '" . strip_tags(deAspisWarningRC($_POST[0]['title'])) . "', '" . deAspisWarningRC($_POST[0]['url']) . "', '" . strip_tags(deAspisWarningRC($_POST[0]['description'])) . "', '0', '" . time() . "', '1')");
if ( $ld_repeated_link == 0)
 {$sql = "SELECT count(url) FROM " . $table . " WHERE url = '" . deAspisWarningRC($_POST[0]['url']) . "'";
$repeated_urls = $wpdb->get_var($sql);
if ( $repeated_urls < 1)
 {$results = $wpdb->query($sql_query);
;
?>
    <?php }else 
{{;
?>
    <?php }}}else 
{{$results = $wpdb->query($sql_query);
;
?>
    <?php }}if ( $results)
 {;
?>
      <div class="updated"><p><strong><?php _e('Link saved.','myLinksDump');
;
?></strong></p></div>
      <?php }else 
{{;
?>
      <div class="error"><p><strong><?php _e('Link not saved. Entered link is already in database.','myLinksDump');
;
?></strong></p></div>
      <?php }}}else 
{{echo '<span style="color:red;">Access denied.</span>';
}}}elseif ( (empty($_GET[0]['url']) || Aspis_empty($_GET[0]['url'])) || (empty($_GET[0]['title']) || Aspis_empty($_GET[0]['title'])))
 {echo '<span style="color:red;">Please fill required fields.</span>';
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wpdb",$AspisChangesCache);
 }
get_currentuserinfo();
if ( !empty($current_user->user_login) && !empty($current_user->ID))
 {$access = 1;
}else 
{{$access = 0;
}}if ( $access)
 {;
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
 <input type="text" name="title" id="title" class="txt" size="25" value="<?php echo $passed_title;
;
?>" />
 <span style="color:red;">*</span>
 </div>
 <div>
 <label for="url">URL:</label>
 <input type="text" name="url" id="url" class="txt" size="40" value="<?php echo $passed_url;
;
?>"/>
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


<?php }else 
{{echo '<span style="color:red;">Access denied.</span>';
}}quick_add();
;
