<?php require_once('AspisMain.php'); ?><?php
require_once ("wp-load.php");
$passed_title = $_GET[0]['title'];
$passed_url = $_GET[0]['url'];
function is_valid_url ( $url ) {
$url = @Aspis_parse_url($url);
if ( (denot_boolean($url)))
 {return array(false,false);
}$url = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC($url)));
arrayAssign($url[0],deAspis(registerTaint(array('port',false))),addTaint((!((isset($url[0][('port')]) && Aspis_isset( $url [0][('port')])))) ? array(80,false) : int_cast($url[0]['port'])));
$path = ((isset($url[0][('path')]) && Aspis_isset( $url [0][('path')]))) ? $url[0]['path'] : array('',false);
if ( ($path[0] == ('')))
 {$path = array('/',false);
}$path = concat($path,((isset($url[0][('query')]) && Aspis_isset( $url [0][('query')]))) ? concat1("?",attachAspis($url,query)) : array('',false));
if ( (((isset($url[0][('host')]) && Aspis_isset( $url [0][('host')]))) and (deAspis($url[0]['host']) != gethostbyname(deAspis($url[0]['host'])))))
 {if ( (PHP_VERSION >= (5)))
 {$headers = array(get_headers((deconcat(concat(concat2(concat(concat2(attachAspis($url,scheme),"://"),attachAspis($url,host)),":"),attachAspis($url,port)),$path))),false);
}else 
{{$fp = AspisInternalFunctionCall("fsockopen",deAspis($url[0]['host']),deAspis($url[0]['port']),AspisPushRefParam($errno),AspisPushRefParam($errstr),(30),array(2,3));
if ( (denot_boolean($fp)))
 {return array(false,false);
}fputs($fp[0],(deconcat2(concat(concat2(concat1("HEAD ",$path)," HTTP/1.1\r\nHost: "),attachAspis($url,host)),"\r\n\r\n")));
$headers = attAspis(fread($fp[0],(128)));
fclose($fp[0]);
}}$headers = is_array($headers[0]) ? Aspis_implode(array("\n",false),$headers) : $headers;
return bool_cast(Aspis_preg_match(array('#^HTTP/.*\s+[(200|301|302)]+\s#i',false),$headers));
}return array(false,false);
 }
function quick_add (  ) {
global $current_user;
global $wpdb;
$table = concat2($wpdb[0]->prefix,"links_dump");
$ld_repeated_link = get_option(array('ld_repeated_link',false));
if ( (((!((empty($_POST[0][('url')]) || Aspis_empty( $_POST [0][('url')])))) && deAspis(is_valid_url($_POST[0]['url']))) && (!((empty($_POST[0][('title')]) || Aspis_empty( $_POST [0][('title')]))))))
 {get_currentuserinfo();
if ( ((!((empty($current_user[0]->user_login) || Aspis_empty( $current_user[0] ->user_login )))) && (!((empty($current_user[0]->ID) || Aspis_empty( $current_user[0] ->ID ))))))
 {$sql_query = $wpdb[0]->prepare(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("INSERT INTO ",$table)," (link_id, title, url, description, visits, date_added, approval)
                                 VALUES (NULL , '"),Aspis_strip_tags($_POST[0]['title'])),"', '"),$_POST[0]['url']),"', '"),Aspis_strip_tags($_POST[0]['description'])),"', '0', '"),attAspis(time())),"', '1')"));
if ( ($ld_repeated_link[0] == (0)))
 {$sql = concat2(concat(concat2(concat1("SELECT count(url) FROM ",$table)," WHERE url = '"),$_POST[0]['url']),"'");
$repeated_urls = $wpdb[0]->get_var($sql);
if ( ($repeated_urls[0] < (1)))
 {$results = $wpdb[0]->query($sql_query);
;
?>
    <?php }else 
{{;
?>
    <?php }}}else 
{{$results = $wpdb[0]->query($sql_query);
;
?>
    <?php }}if ( $results[0])
 {;
?>
      <div class="updated"><p><strong><?php _e(array('Link saved.',false),array('myLinksDump',false));
;
?></strong></p></div>
      <?php }else 
{{;
?>
      <div class="error"><p><strong><?php _e(array('Link not saved. Entered link is already in database.',false),array('myLinksDump',false));
;
?></strong></p></div>
      <?php }}}else 
{{echo AspisCheckPrint(array('<span style="color:red;">Access denied.</span>',false));
}}}elseif ( (((empty($_GET[0][('url')]) || Aspis_empty( $_GET [0][('url')]))) || ((empty($_GET[0][('title')]) || Aspis_empty( $_GET [0][('title')])))))
 {echo AspisCheckPrint(array('<span style="color:red;">Please fill required fields.</span>',false));
} }
get_currentuserinfo();
if ( ((!((empty($current_user[0]->user_login) || Aspis_empty( $current_user[0] ->user_login )))) && (!((empty($current_user[0]->ID) || Aspis_empty( $current_user[0] ->ID ))))))
 {$access = array(1,false);
}else 
{{$access = array(0,false);
}}if ( $access[0])
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
 <input type="text" name="title" id="title" class="txt" size="25" value="<?php echo AspisCheckPrint($passed_title);
;
?>" />
 <span style="color:red;">*</span>
 </div>
 <div>
 <label for="url">URL:</label>
 <input type="text" name="url" id="url" class="txt" size="40" value="<?php echo AspisCheckPrint($passed_url);
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
{{echo AspisCheckPrint(array('<span style="color:red;">Access denied.</span>',false));
}}quick_add();
;
