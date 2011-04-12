<?php require_once('AspisMain.php'); ?><?php
$parent_file = array('tools.php',false);
$submenu_file = array('import.php',false);
$title = __(array('Import Blogroll',false));
class OPML_Import{function dispatch (  ) {
{global $wpdb,$user_ID;
$step = $_POST[0]['step'];
if ( (denot_boolean($step)))
 $step = array(0,false);
;
?>
<?php switch ( $step[0] ) {
case (0):{include_once ('admin-header.php');
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
$opmltype = array('blogrolling',false);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e(array('Import your blogroll from another system',false));
?> </h2>
<form enctype="multipart/form-data" action="admin.php?import=opml" method="post" name="blogroll">
<?php wp_nonce_field(array('import-bookmarks',false));
?>

<p><?php _e(array('If a program or website you use allows you to export your links or subscriptions as OPML you may import them here.',false));
;
?></p>
<div style="width: 70%; margin: auto; height: 8em;">
<input type="hidden" name="step" value="1" />
<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
<div style="width: 48%;" class="alignleft">
<h3><label for="opml_url"><?php _e(array('Specify an OPML URL:',false));
;
?></label></h3>
<input type="text" name="opml_url" id="opml_url" size="50" class="code" style="width: 90%;" value="http://" />
</div>

<div style="width: 48%;" class="alignleft">
<h3><label for="userfile"><?php _e(array('Or choose from your local disk:',false));
;
?></label></h3>
<input id="userfile" name="userfile" type="file" size="30" />
</div>

</div>

<p style="clear: both; margin-top: 1em;"><label for="cat_id"><?php _e(array('Now select a category you want to put these links in.',false));
?></label><br />
<?php _e(array('Category:',false));
?> <select name="cat_id" id="cat_id">
<?php $categories = get_terms(array('link_category',false),array('get=all',false));
foreach ( $categories[0] as $category  )
{;
?>
<option value="<?php echo AspisCheckPrint($category[0]->term_id);
;
?>"><?php echo AspisCheckPrint(esc_html(apply_filters(array('link_category',false),$category[0]->name)));
;
?></option>
<?php };
?>
</select></p>

<p class="submit"><input type="submit" name="submit" value="<?php esc_attr_e(array('Import OPML File',false));
?>" /></p>
</form>

</div>
<?php break ;
}case (1):{check_admin_referer(array('import-bookmarks',false));
include_once ('admin-header.php');
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
;
?>
<div class="wrap">

<h2><?php _e(array('Importing...',false));
?></h2>
<?php $cat_id = Aspis_abs(int_cast($_POST[0]['cat_id']));
if ( ($cat_id[0] < (1)))
 $cat_id = array(1,false);
$opml_url = $_POST[0]['opml_url'];
if ( ((((isset($opml_url) && Aspis_isset( $opml_url))) && ($opml_url[0] != (''))) && ($opml_url[0] != ('http://'))))
 {$blogrolling = array(true,false);
}else 
{{$overrides = array(array('test_form' => array(false,false,false),'test_type' => array(false,false,false)),false);
arrayAssign($_FILES[0][('userfile')][0],deAspis(registerTaint(array('name',false))),addTaint(concat2($_FILES[0][('userfile')][0]['name'],'.txt')));
$file = wp_handle_upload($_FILES[0]['userfile'],$overrides);
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 wp_die($file[0]['error']);
$url = $file[0]['url'];
$opml_url = $file[0]['file'];
$blogrolling = array(false,false);
}}global $opml,$updated_timestamp,$all_links,$map,$names,$urls,$targets,$descriptions,$feeds;
if ( (((isset($opml_url) && Aspis_isset( $opml_url))) && ($opml_url[0] != (''))))
 {if ( ($blogrolling[0] === true))
 {$opml = wp_remote_fopen($opml_url);
}else 
{{$opml = attAspis(file_get_contents($opml_url[0]));
}}include_once ('link-parse-opml.php');
$link_count = attAspis(count($names[0]));
for ( $i = array(0,false) ; ($i[0] < $link_count[0]) ; postincr($i) )
{if ( (('Last') == deAspis(Aspis_substr(attachAspis($titles,$i[0]),array(0,false),array(4,false)))))
 arrayAssign($titles[0],deAspis(registerTaint($i)),addTaint(array('',false)));
if ( (('http') == deAspis(Aspis_substr(attachAspis($titles,$i[0]),array(0,false),array(4,false)))))
 arrayAssign($titles[0],deAspis(registerTaint($i)),addTaint(array('',false)));
$link = array(array(deregisterTaint(array('link_url',false)) => addTaint(attachAspis($urls,$i[0])),deregisterTaint(array('link_name',false)) => addTaint($wpdb[0]->escape(attachAspis($names,$i[0]))),'link_category' => array(array($cat_id),false,false),deregisterTaint(array('link_description',false)) => addTaint($wpdb[0]->escape(attachAspis($descriptions,$i[0]))),deregisterTaint(array('link_owner',false)) => addTaint($user_ID),deregisterTaint(array('link_rss',false)) => addTaint(attachAspis($feeds,$i[0]))),false);
wp_insert_link($link);
echo AspisCheckPrint(Aspis_sprintf(concat2(concat1('<p>',__(array('Inserted <strong>%s</strong>',false))),'</p>'),attachAspis($names,$i[0])));
};
?>

<p><?php printf(deAspis(__(array('Inserted %1$d links into category %2$s. All done! Go <a href="%3$s">manage those links</a>.',false))),deAspisRC($link_count),deAspisRC($cat_id),'link-manager.php');
?></p>

<?php }else 
{{echo AspisCheckPrint(concat2(concat1("<p>",__(array("You need to supply your OPML url. Press back on your browser and try again",false))),"</p>\n"));
}}if ( (denot_boolean($blogrolling)))
 do_action(array('wp_delete_file',false),$opml_url);
@attAspis(unlink($opml_url[0]));
;
?>
</div>
<?php break ;
} }
} }
function OPML_Import (  ) {
{} }
}$opml_importer = array(new OPML_Import(),false);
register_importer(array('opml',false),__(array('Blogroll',false)),__(array('Import links in OPML format.',false)),array(array(&$opml_importer,array('dispatch',false)),false));
;
?>
<?php 