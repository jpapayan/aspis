<?php require_once('AspisMain.php'); ?><?php
$parent_file = 'tools.php';
$submenu_file = 'import.php';
$title = __('Import Blogroll');
class OPML_Import{function dispatch (  ) {
{{global $wpdb,$user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($user_ID,"\$user_ID",$AspisChangesCache);
}$step = deAspisWarningRC($_POST[0]['step']);
if ( !$step)
 $step = 0;
;
?>
<?php switch ( $step ) {
case 0:{include_once ('admin-header.php');
if ( !current_user_can('manage_links'))
 wp_die(__('Cheatin&#8217; uh?'));
$opmltype = 'blogrolling';
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php _e('Import your blogroll from another system');
?> </h2>
<form enctype="multipart/form-data" action="admin.php?import=opml" method="post" name="blogroll">
<?php wp_nonce_field('import-bookmarks');
?>

<p><?php _e('If a program or website you use allows you to export your links or subscriptions as OPML you may import them here.');
;
?></p>
<div style="width: 70%; margin: auto; height: 8em;">
<input type="hidden" name="step" value="1" />
<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
<div style="width: 48%;" class="alignleft">
<h3><label for="opml_url"><?php _e('Specify an OPML URL:');
;
?></label></h3>
<input type="text" name="opml_url" id="opml_url" size="50" class="code" style="width: 90%;" value="http://" />
</div>

<div style="width: 48%;" class="alignleft">
<h3><label for="userfile"><?php _e('Or choose from your local disk:');
;
?></label></h3>
<input id="userfile" name="userfile" type="file" size="30" />
</div>

</div>

<p style="clear: both; margin-top: 1em;"><label for="cat_id"><?php _e('Now select a category you want to put these links in.');
?></label><br />
<?php _e('Category:');
?> <select name="cat_id" id="cat_id">
<?php $categories = get_terms('link_category','get=all');
foreach ( $categories as $category  )
{;
?>
<option value="<?php echo $category->term_id;
;
?>"><?php echo esc_html(apply_filters('link_category',$category->name));
;
?></option>
<?php };
?>
</select></p>

<p class="submit"><input type="submit" name="submit" value="<?php esc_attr_e('Import OPML File');
?>" /></p>
</form>

</div>
<?php break ;
}case 1:{check_admin_referer('import-bookmarks');
include_once ('admin-header.php');
if ( !current_user_can('manage_links'))
 wp_die(__('Cheatin&#8217; uh?'));
;
?>
<div class="wrap">

<h2><?php _e('Importing...');
?></h2>
<?php $cat_id = abs((int)deAspisWarningRC($_POST[0]['cat_id']));
if ( $cat_id < 1)
 $cat_id = 1;
$opml_url = deAspisWarningRC($_POST[0]['opml_url']);
if ( isset($opml_url) && $opml_url != '' && $opml_url != 'http://')
 {$blogrolling = true;
}else 
{{$overrides = array('test_form' => false,'test_type' => false);
$_FILES[0]['userfile'][0]['name'] .= attAspisRCO('.txt');
$file = wp_handle_upload(deAspisWarningRC($_FILES[0]['userfile']),$overrides);
if ( isset($file['error']))
 wp_die($file['error']);
$url = $file['url'];
$opml_url = $file['file'];
$blogrolling = false;
}}{global $opml,$updated_timestamp,$all_links,$map,$names,$urls,$targets,$descriptions,$feeds;
$AspisVar2 = &AspisCleanTaintedGlobalUntainted( $opml,"\$opml",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($updated_timestamp,"\$updated_timestamp",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($all_links,"\$all_links",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($map,"\$map",$AspisChangesCache);
$AspisVar6 = &AspisCleanTaintedGlobalUntainted($names,"\$names",$AspisChangesCache);
$AspisVar7 = &AspisCleanTaintedGlobalUntainted($urls,"\$urls",$AspisChangesCache);
$AspisVar8 = &AspisCleanTaintedGlobalUntainted($targets,"\$targets",$AspisChangesCache);
$AspisVar9 = &AspisCleanTaintedGlobalUntainted($descriptions,"\$descriptions",$AspisChangesCache);
$AspisVar10 = &AspisCleanTaintedGlobalUntainted($feeds,"\$feeds",$AspisChangesCache);
}if ( isset($opml_url) && $opml_url != '')
 {if ( $blogrolling === true)
 {$opml = wp_remote_fopen($opml_url);
}else 
{{$opml = file_get_contents($opml_url);
}}include_once ('link-parse-opml.php');
$link_count = count($names);
for ( $i = 0 ; $i < $link_count ; $i++ )
{if ( 'Last' == substr($titles[$i],0,4))
 $titles[$i] = '';
if ( 'http' == substr($titles[$i],0,4))
 $titles[$i] = '';
$link = array('link_url' => $urls[$i],'link_name' => AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($names[$i])),array(0)),'link_category' => array($cat_id),'link_description' => AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($descriptions[$i])),array(0)),'link_owner' => $user_ID,'link_rss' => $feeds[$i]);
wp_insert_link($link);
echo sprintf('<p>' . __('Inserted <strong>%s</strong>') . '</p>',$names[$i]);
};
?>

<p><?php printf(__('Inserted %1$d links into category %2$s. All done! Go <a href="%3$s">manage those links</a>.'),$link_count,$cat_id,'link-manager.php');
?></p>

<?php }else 
{{echo "<p>" . __("You need to supply your OPML url. Press back on your browser and try again") . "</p>\n";
}}if ( !$blogrolling)
 do_action('wp_delete_file',$opml_url);
@unlink($opml_url);
;
?>
</div>
<?php break ;
} }
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$user_ID",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$opml",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$updated_timestamp",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$all_links",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$map",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar6,"\$names",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar7,"\$urls",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar8,"\$targets",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar9,"\$descriptions",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar10,"\$feeds",$AspisChangesCache);
 }
function OPML_Import (  ) {
{} }
}$opml_importer = new OPML_Import();
register_importer('opml',__('Blogroll'),__('Import links in OPML format.'),array($opml_importer,'dispatch'));
;
?>
<?php 