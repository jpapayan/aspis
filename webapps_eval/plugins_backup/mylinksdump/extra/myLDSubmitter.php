<?php
require_once("wp-load.php"); 
global $wpdb;

$wpdb->hide_errors();
$table     = $wpdb->prefix."links_dump";
if (isset($_POST['title']) && isset($_POST['url']) && isset($_POST['category'])){
$sql_query = $wpdb->prepare("INSERT INTO ".$table." (link_id, category, title, url, description, visits, date_added)
                 VALUES (
                  NULL , '".$_POST['category']."', '".$_POST['title']."', '".$_POST['url']."', '".strip_tags($_POST['description'])."', '".get_option("ld_auto_approve")."', '".time()."'
                 )");
//Admin notification
if (get_option('ld_send_notification') == 1) {
 $to = get_option('admin_email');
 $subject  = "New link submission at ".get_option('blogname') .' - ' . date('Y-m-d');
 $message  = "Link Title: ".$_POST['title']."<br />";
 $message .= "Link URL: ".$_POST['url']."<br />";
 $message .= "Approve: ".get_option('siteurl ').'/wp-admin/link-manager.php?page=myLinksDump/myLinksDump.php';
 $headers  = 'From: ' . get_option('admin_email') . "\r\n" .'X-Mailer: PHP/' . phpversion();
 mail($to, $subject, $message, $headers);
}
                 
$repeated_urls = 0;
$ld_repeated_link = get_option('ld_repeated_link');
if ($ld_repeated_link == 0){
    $sql      = $wpdb->prepare("SELECT count(url) FROM ".$table." WHERE url = '".$_POST['url']."'");
    $repeated_urls  = $wpdb->get_var($sql);
    if ($repeated_urls < 1 ){
     $url = $wpdb->query($sql_query);
    ?>
    <?php
    }else{
    $js = "<script type=\"text/javascript\">
     alert('کاربر گرامی، لینک مد نظر شما تکراری می باشد. این لینک قبلا توسط شخصی دیگر پیشنهاد شده است. با تشکر');
    </script>";
    } 
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="fa" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title></title>
<script type="text/javascript">

function ValidateForm(){
  var titleID=document.submitter.title
  var linkID=document.submitter.url
  var catID=document.submitter.category
   
  if ((titleID.value==null)||(titleID.value=="")){
    alert("لطفا عنوان لینک را وارد نمایید")
    titleID.focus()
    return false
  }
  if ((linkID.value==null)||(linkID.value=="")){
    alert("لطفا آدرس پیوند را وارد نماييد")
    linkID.focus()
    return false
  }
  
   if ((catID.value==null)||(catID.value=="")){
    alert("لطفا موضوع را وارد نماييد")
    catID.focus()
    return false
  }
  return true
  
 }
// End -->

<?php
echo $js;
if (!empty($url) && isset($_POST['url'])) {
?>
  alert('لینک پیشنهادی شما با موفقیت درج شد. این لینک پس از تایید مدیر سایت به نمایش در خواهد آمد');
<?php
}elseif(isset($_POST['url']) && empty($url) && empty($js)) {
?>
 alert('متاسفانه مشکلی در ارسال لینک شما رخ داد و لینک شما ثبت نشد. چنانچه احتمال می دهید مشکل از سایت است لطفا مدیران سایت را از بخش تماس با ما در جریان قرار دهید');
<?php
}
?>
</script>
<style type="text/css">
input{
	 background-image: url('images/input_back.jpg');
	 background-repeat: repeat-x;
	 width: 150px;
	 font-family: Tahoma;
	 font-size: 8pt;
}
.submit_button {
	font-family:Tahoma;
	font-size:8pt;
	height:25px;
	background-image:none;
	width: 60px;
}
#cats {
	font-family:Tahoma;
	font-size:8pt;
	width:150px;
}
</style>

</head>

<body style="font-family: Tahoma; font-size: 8pt; font-weight: bold; font-style: normal;background-image: url('images/sidep-bottom.png'); background-repeat: repeat-x;"">
<form method="post" name="submitter" onsubmit="return ValidateForm();">
 
	<table style="" align="right" dir="rtl">
		<tr>
			<td>عنوان لینک :</td>
		</tr>
		<tr>
			<td>
			<input name="title" type="text" >&nbsp;</td>
		</tr>
		<tr>
			<td>لینک :</td>
		</tr>
		<tr>
			<td><input name="url" type="text" dir="ltr">&nbsp;</td>
		</tr>
		<tr>
			<td>دسته :</td>
		</tr>
		<tr>
			<td>
			<select name="category" id="cats">
			 <option value=""></option>
	         <option value="1" >گوناگون</option>
	         <option value="2" >تصاویر و فیلم</option>
	         <option value="3" >کامپیوتر و اینترنت</option>
	         <option value="4" >سیاسی</option>
			</select>
			</td>
		</tr>
		<tr>
			<td>توضیح مختصر:</td>
		</tr>
		<tr>
			<td><textarea cols="15" name="description" style="height: 56px;width:150px"></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;<input class="submit_button" name="Submit1" type="submit" value="فرستادن" />
			<input class="submit_button" name="Reset1" type="reset" value="از نو" />&nbsp;</td>
		</tr>
	</table>
 
</form>
</body>

</html>
