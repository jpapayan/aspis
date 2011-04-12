<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 include_once ('./../../../wp-blog-header.php');
require_once (deconcat12(ABSPATH,'/wp-admin/admin.php'));
if ( ((isset($_POST[0][('action')]) && Aspis_isset( $_POST [0][('action')]))))
 {$mimes = is_array($mimes[0]) ? $mimes : apply_filters(array('upload_mimes',false),array(array('avi' => array('video/avi',false,false),'mov|qt' => array('video/quicktime',false,false),'mpeg|mpg|mpe' => array('video/mpeg',false,false),'asf|asx|wax|wmv|wmx' => array('video/asf',false,false),'swf' => array('application/x-shockwave-flash',false,false),'flv' => array('video/x-flv',false,false)),false));
$overrides = array(array('action' => array('save',false,false),deregisterTaint(array('mimes',false)) => addTaint($mimes)),false);
$file = wp_handle_upload($_FILES[0]['video'],$overrides);
if ( (!((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')])))))
 {$url = $file[0]['url'];
$type = $file[0]['type'];
$file = $file[0]['file'];
$filename = Aspis_basename($file);
$attachment = array(array(deregisterTaint(array('post_title',false)) => addTaint(deAspis($_POST[0]['videotitle']) ? $_POST[0]['videotitle'] : $filename),deregisterTaint(array('post_content',false)) => addTaint($_POST[0]['descr']),'post_status' => array('attachment',false,false),deregisterTaint(array('post_parent',false)) => addTaint($_GET[0]['post']),deregisterTaint(array('post_mime_type',false)) => addTaint($type),deregisterTaint(array('guid',false)) => addTaint($url)),false);
$id = wp_insert_attachment($attachment,$file,$post);
if ( deAspis(Aspis_preg_match(array('!^image/!',false),$attachment[0]['post_mime_type'])))
 {$imagesize = attAspisRC(getimagesize($file[0]));
arrayAssign($imagedata[0],deAspis(registerTaint(array('width',false))),addTaint($imagesize[0]['0']));
arrayAssign($imagedata[0],deAspis(registerTaint(array('height',false))),addTaint($imagesize[0]['1']));
list($uwidth,$uheight) = deAspisList(get_udims($imagedata[0]['width'],$imagedata[0]['height']),array());
arrayAssign($imagedata[0],deAspis(registerTaint(array('hwstring_small',false))),addTaint(concat2(concat(concat2(concat1("height='",$uheight),"' width='"),$uwidth),"'")));
arrayAssign($imagedata[0],deAspis(registerTaint(array('file',false))),addTaint($file));
add_post_meta($id,array('_wp_attachment_metadata',false),$imagedata);
if ( ((deAspis($imagedata[0]['width']) * deAspis($imagedata[0]['height'])) < (((3) * (1024)) * (1024))))
 {if ( ((deAspis($imagedata[0]['width']) > (128)) && (deAspis($imagedata[0]['width']) >= ((deAspis($imagedata[0]['height']) * (4)) / (3)))))
 $thumb = wp_create_thumbnail($file,array(128,false));
elseif ( (deAspis($imagedata[0]['height']) > (96)))
 $thumb = wp_create_thumbnail($file,array(96,false));
if ( deAspis(@attAspis(file_exists($thumb[0]))))
 {$newdata = $imagedata;
arrayAssign($newdata[0],deAspis(registerTaint(array('thumb',false))),addTaint(Aspis_basename($thumb)));
update_post_meta($id,array('_wp_attachment_metadata',false),$newdata,$imagedata);
}else 
{{$error = $thumb;
}}}}else 
{{add_post_meta($id,array('_wp_attachment_metadata',false),array(array(),false));
}}arrayAssign($_GET[0],deAspis(registerTaint(array('tab',false))),addTaint(array('select',false)));
}}if ( (denot_boolean(current_user_can(array('edit_others_posts',false)))))
 $and_user = concat1("AND post_author = ",$user_ID);
$and_type = array("AND (post_mime_type = 'video/avi' OR post_mime_type = 'video/quicktime' OR post_mime_type = 'video/mpeg' OR post_mime_type = 'video/asf' OR post_mime_type = 'video/x-flv' OR post_mime_type = 'application/x-shockwave-flash')",false);
if ( ((3664) <= $wp_db_version[0]))
 $attachments = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat1("SELECT post_title, guid FROM ",$wpdb[0]->posts)," WHERE post_type = 'attachment' "),$and_type)," "),$and_user)," ORDER BY post_date_gmt DESC LIMIT 0, 10"),array(ARRAY_A,false));
else 
{$attachments = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat1("SELECT post_title, guid FROM ",$wpdb[0]->posts)," WHERE post_status = 'attachment' "),$and_type)," "),$and_user)," ORDER BY post_date_gmt DESC LIMIT 0, 10"),array(ARRAY_A,false));
};
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script language="javascript" type="text/javascript" src="<?php echo AspisCheckPrint(get_option(array('siteurl',false)));
?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo AspisCheckPrint(get_option(array('siteurl',false)));
?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo AspisCheckPrint(get_option(array('siteurl',false)));
?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript" src="embedded-video.js"></script>
	<base target="_self" />
	<style type="text/css">
		#embeddedvideo .panel_wrapper, #embeddedvideo div.current {
			height: 165px;
			padding-top: 5px;
		}
		#portal_insert, #portal_cancel, #select_insert, #select_cancel, #upload_insert, #upload_cancel, #remote_insert, #remote_cancel {
					font: 13px Verdana, Arial, Helvetica, sans-serif;
					height: auto;
					width: auto;
					background-color: transparent;
					background-image: url(../../../../../wp-admin/images/fade-butt.png);
					background-repeat: repeat;
					border: 3px double;
					border-right-color: rgb(153, 153, 153);
					border-bottom-color: rgb(153, 153, 153);
					border-left-color: rgb(204, 204, 204);
					border-top-color: rgb(204, 204, 204);
					color: rgb(51, 51, 51);
					padding: 0.25em 0.75em;
		}
		#portal_insert:active, #portal_cancel:active, #select_insert:active, #select_cancel:active, #upload_insert:active, #upload_cancel:active, #remote_insert:active, #remote_cancel:active {
					background: #f4f4f4;
					border-left-color: #999;
					border-top-color: #999;
		}
	</style>
	<title><?php echo AspisCheckPrint(_e(array('Embed Video',false),array('embeddedvideo',false)));
;
?></title>
</head>

<body id="embeddedvideo" onload="<?php $tab = ((isset($_GET[0][('tab')]) && Aspis_isset( $_GET [0][('tab')]))) ? $_GET[0]['tab'] : $_POST[0]['tab'];
echo AspisCheckPrint(concat2(concat(concat2(concat1("mcTabs.displayTab('",$tab),"_tab','"),$tab),"_panel');"));
if ( (deAspis($_GET[0]['tab']) == ('portal')))
 echo AspisCheckPrint(array("document.forms.portal_form.vid.style.backgroundColor = '#f30';",false));
?>tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">

  <div class="tabs">
    <ul>
      <li id="portal_tab" class="current"><span><a href="javascript:mcTabs.displayTab('portal_tab','portal_panel');" onmousedown="return false;"><?php echo AspisCheckPrint(_e(array('Portal video',false),array('embeddedvideo',false)));
;
?></a></span></li>
      <?php if ( $attachments[0])
 {;
?><li id="select_tab"><span><a href="javascript:mcTabs.displayTab('select_tab','select_panel');" onmousedown="return false;"><?php echo AspisCheckPrint(_e(array('Local video',false),array('embeddedvideo',false)));
;
?></a></span></li><?php };
?>
      <li id="upload_tab"><span><a href="javascript:mcTabs.displayTab('upload_tab','upload_panel');" onmousedown="return false;"><?php echo AspisCheckPrint(_e(array('Upload video',false),array('embeddedvideo',false)));
;
?></a></span></li>
      <li id="remote_tab"><span><a href="javascript:mcTabs.displayTab('remote_tab','remote_panel');" onmousedown="return false;"><?php echo AspisCheckPrint(_e(array('Video URL',false),array('embeddedvideo',false)));
;
?></a></span></li>
    </ul>
  </div>

<div class="panel_wrapper">

  <div id="portal_panel" class="current">
    <form name="portal_form" action="#">
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Select video portal:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><select name="portal" id="portal_portal" style="width: 200px" onChange="dailymotion(this, this.form.linktext, this.form.nolink);">
                    <option value="youtube">YouTube</option>
                    <option value="google">Google Video</option>
                    <option value="myspace">Myspace Video</option>
                    <option value="dailymotion">dailymotion</option>
                    <option value="revver">Revver</option>
                    <option value="sevenload">Sevenload</option>
                    <option value="clipfish">Clipfish</option>
                    <option value="metacafe">Metacaf&eacute;</option>
                    <option value="myvideo">MyVideo</option>
                    <option value="yahoo">Yahoo! Video</option>
                    <option value="ifilm">ifilm</option>
                    <option value="brightcove">brightcove</option>
                    <option value="aniboom">aniBOOM</option>
                    <option value="vimeo">vimeo</option>
                    <option value="guba">GUBA</option>
                    <option value="garagetv">Garage TV</option>
                    <option value="gamevideo">GameVideos</option>
                    <option value="vsocial">vSocial</option>
                    <option value="veoh">Veoh</option>
                    <option value="gametrailers">Gametrailers</option>
                  </select>
                  </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Insert video ID:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="vid" type="text" id="portal_vid" value="" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td nowrap="nowrap"></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="nolink" type="checkbox" id="portal_nolink" onClick="disable_enable(this, this.form.linktext);" /></td>
                  <td><?php echo AspisCheckPrint(_e(array('Show video without link',false),array('embeddedvideo',false)));
;
?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Link text:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="linktext" type="text" id="portal_linktext" value="<?php echo AspisCheckPrint($_GET[0]['linktext']);
;
?>" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>
	    <input type="submit" id="portal_insert" name="insert" value="<?php echo AspisCheckPrint(_e(array('Insert',false),array('embeddedvideo',false)));
;
?>" onclick="ev_checkData(this.form);" />
            </td>
            <td align="right"><input type="button" id="portal_cancel" name="cancel" value="<?php echo AspisCheckPrint(_e(array('Cancel',false),array('embeddedvideo',false)));
;
?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input type="hidden" name="tab" value="portal" />
    </form>
  </div>

<?php if ( $attachments[0])
 {foreach ( $attachments[0] as $key =>$attachment )
{restoreTaint($key,$attachment);
{$title = $attachment[0]['post_title'];
$url = Aspis_str_replace(get_option(array('siteurl',false)),array('',false),$attachment[0]['guid']);
arrayAssignAdd($option[0][],addTaint(concat2(concat(concat2(concat1('<option value="',$url),'">'),$title),'</option>')));
}}$size = (count($option[0]) < (5)) ? attAspis(count($option[0])) : array(5,false);
;
?>
  <div id="select_panel" class="panel">
    <form name="select_form" action="#">
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Select video file:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <select size="<?php echo AspisCheckPrint($size);
;
?>" name="vid">
                      <?php foreach ( $option[0] as $key =>$opt )
{restoreTaint($key,$opt);
echo AspisCheckPrint($opt);
};
?>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap"></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="nolink" type="checkbox" id="select_nolink" onClick="disable_enable(this, this.form.linktext);" /></td>
                  <td><?php echo AspisCheckPrint(_e(array('Show video without link',false),array('embeddedvideo',false)));
;
?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Link text:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="linktext" type="text" id="select_linktext" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><input type="submit" id="select_insert" name="insert" value="<?php echo AspisCheckPrint(_e(array('Insert',false),array('embeddedvideo',false)));
;
?>" onclick="ev_checkData(this.form);"/>
            </td>
            <td align="right"><input type="button" id="select_cancel" name="cancel" value="<?php echo AspisCheckPrint(_e(array('Cancel',false),array('embeddedvideo',false)));
;
?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input name="portal" type="hidden" id="select_portal" value="local" />
      <input type="hidden" name="tab" value="select" />
    </form>

  </div>
<?php };
?>

  <div id="upload_panel" class="panel">
    <form name="upload_form" enctype="multipart/form-data" method="post" action="#">
        <table border="0" cellpadding="4" cellspacing="0">
          <?php if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 {;
?>
            <tr>
              <td colspan="2"><?php echo AspisCheckPrint($file[0]['error']);
;
?></td>
            </tr>
          <?php };
?>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Local video file:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="video" type="file" id="upload" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Title:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="videotitle" type="text" id="videotitle" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Description:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="descr" type="text" id="descr" value="" style="width: 200px" /></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><input type="submit" id="upload_insert" name="insert" value="<?php echo AspisCheckPrint(_e(array('Upload',false),array('embeddedvideo',false)));
;
?>" />
            </td>
            <td align="right"><input type="button" id="upload_cancel" name="cancel" value="<?php echo AspisCheckPrint(_e(array('Cancel',false),array('embeddedvideo',false)));
;
?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input type="hidden" name="action" value="save" />
      <input type="hidden" name="tab" value="upload" />
    </form>

  </div>


  <div id="remote_panel" class="panel">
    <form name="remote_form" action="#">
        <input name="portal" type="hidden" id="remote_portal" value="video" />
        <table border="0" cellpadding="4" cellspacing="0">
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Insert video URL:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="vid" type="text" id="remote_vid" value="" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="nolink" type="checkbox" id="remote_nolink" onClick="disable_enable(this, this.form.linktext);" /></td>
                  <td><?php echo AspisCheckPrint(_e(array('Show video without link',false),array('embeddedvideo',false)));
;
?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td nowrap="nowrap" style="text-align:right;"><?php echo AspisCheckPrint(_e(array('Link text:',false),array('embeddedvideo',false)));
;
?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><input name="linktext" type="text" id="remote_linktext" value="<?php echo AspisCheckPrint($_GET[0]['linktext']);
;
?>" style="width: 200px" /></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><input type="submit" id="remote_insert" name="insert" value="<?php echo AspisCheckPrint(_e(array('Insert',false),array('embeddedvideo',false)));
;
?>" onclick="ev_checkData(this.form);" />
            </td>
            <td align="right"><input type="button" id="remote_cancel" name="cancel" value="<?php echo AspisCheckPrint(_e(array('Cancel',false),array('embeddedvideo',false)));
;
?>" onclick="tinyMCEPopup.close();" /></td>
          </tr>
        </table>
      <input type="hidden" name="tab" value="remote" />
    </form>
  </div>

</div>

</body>
</html>
<?php 