<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$title = __(array('Settings',false));
$this_file = array('options.php',false);
$parent_file = array('options-general.php',false);
wp_reset_vars(array(array(array('action',false)),false));
$whitelist_options = array(array('general' => array(array(array('blogname',false),array('blogdescription',false),array('admin_email',false),array('users_can_register',false),array('gmt_offset',false),array('date_format',false),array('time_format',false),array('start_of_week',false),array('default_role',false),array('timezone_string',false)),false,false),'discussion' => array(array(array('default_pingback_flag',false),array('default_ping_status',false),array('default_comment_status',false),array('comments_notify',false),array('moderation_notify',false),array('comment_moderation',false),array('require_name_email',false),array('comment_whitelist',false),array('comment_max_links',false),array('moderation_keys',false),array('blacklist_keys',false),array('show_avatars',false),array('avatar_rating',false),array('avatar_default',false),array('close_comments_for_old_posts',false),array('close_comments_days_old',false),array('thread_comments',false),array('thread_comments_depth',false),array('page_comments',false),array('comments_per_page',false),array('default_comments_page',false),array('comment_order',false),array('comment_registration',false)),false,false),'misc' => array(array(array('use_linksupdate',false),array('uploads_use_yearmonth_folders',false),array('upload_path',false),array('upload_url_path',false)),false,false),'media' => array(array(array('thumbnail_size_w',false),array('thumbnail_size_h',false),array('thumbnail_crop',false),array('medium_size_w',false),array('medium_size_h',false),array('large_size_w',false),array('large_size_h',false),array('image_default_size',false),array('image_default_align',false),array('image_default_link_type',false),array('embed_autourls',false),array('embed_size_w',false),array('embed_size_h',false)),false,false),'privacy' => array(array(array('blog_public',false)),false,false),'reading' => array(array(array('posts_per_page',false),array('posts_per_rss',false),array('rss_use_excerpt',false),array('blog_charset',false),array('show_on_front',false),array('page_on_front',false),array('page_for_posts',false)),false,false),'writing' => array(array(array('default_post_edit_rows',false),array('use_smilies',false),array('ping_sites',false),array('mailserver_url',false),array('mailserver_port',false),array('mailserver_login',false),array('mailserver_pass',false),array('default_category',false),array('default_email_category',false),array('use_balanceTags',false),array('default_link_category',false),array('enable_app',false),array('enable_xmlrpc',false)),false,false),'options' => array(array(array('',false)),false,false)),false);
if ( (!(defined(('WP_SITEURL')))))
 arrayAssignAdd($whitelist_options[0][('general')][0][],addTaint(array('siteurl',false)));
if ( (!(defined(('WP_HOME')))))
 arrayAssignAdd($whitelist_options[0][('general')][0][],addTaint(array('home',false)));
$whitelist_options = apply_filters(array('whitelist_options',false),$whitelist_options);
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
switch ( $action[0] ) {
case ('update'):if ( ((isset($_POST[0][('option_page')]) && Aspis_isset( $_POST [0][('option_page')]))))
 {$option_page = $_POST[0]['option_page'];
check_admin_referer(concat2($option_page,'-options'));
}else 
{{$option_page = array('options',false);
check_admin_referer(array('update-options',false));
}}if ( (!((isset($whitelist_options[0][$option_page[0]]) && Aspis_isset( $whitelist_options [0][$option_page[0]])))))
 wp_die(__(array('Error! Options page not found.',false)));
if ( (('options') == $option_page[0]))
 {$options = Aspis_explode(array(',',false),Aspis_stripslashes($_POST[0]['page_options']));
}else 
{{$options = attachAspis($whitelist_options,$option_page[0]);
}}if ( (('general') == $option_page[0]))
 {if ( (((!((empty($_POST[0][('date_format')]) || Aspis_empty( $_POST [0][('date_format')])))) && ((isset($_POST[0][('date_format_custom')]) && Aspis_isset( $_POST [0][('date_format_custom')])))) && (('\c\u\s\t\o\m') == deAspis(Aspis_stripslashes($_POST[0]['date_format'])))))
 arrayAssign($_POST[0],deAspis(registerTaint(array('date_format',false))),addTaint($_POST[0]['date_format_custom']));
if ( (((!((empty($_POST[0][('time_format')]) || Aspis_empty( $_POST [0][('time_format')])))) && ((isset($_POST[0][('time_format_custom')]) && Aspis_isset( $_POST [0][('time_format_custom')])))) && (('\c\u\s\t\o\m') == deAspis(Aspis_stripslashes($_POST[0]['time_format'])))))
 arrayAssign($_POST[0],deAspis(registerTaint(array('time_format',false))),addTaint($_POST[0]['time_format_custom']));
if ( ((!((empty($_POST[0][('timezone_string')]) || Aspis_empty( $_POST [0][('timezone_string')])))) && deAspis(Aspis_preg_match(array('/^UTC[+-]/',false),$_POST[0]['timezone_string']))))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('gmt_offset',false))),addTaint($_POST[0]['timezone_string']));
arrayAssign($_POST[0],deAspis(registerTaint(array('gmt_offset',false))),addTaint(Aspis_preg_replace(array('/UTC\+?/',false),array('',false),$_POST[0]['gmt_offset'])));
arrayAssign($_POST[0],deAspis(registerTaint(array('timezone_string',false))),addTaint(array('',false)));
}}if ( $options[0])
 {foreach ( $options[0] as $option  )
{$option = Aspis_trim($option);
$value = array(null,false);
if ( ((isset($_POST[0][$option[0]]) && Aspis_isset( $_POST [0][$option[0]]))))
 $value = attachAspis($_POST,$option[0]);
if ( (!(is_array($value[0]))))
 $value = Aspis_trim($value);
$value = stripslashes_deep($value);
update_option($option,$value);
}}$goback = add_query_arg(array('updated',false),array('true',false),wp_get_referer());
wp_redirect($goback);
break ;
default :include ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
  <h2><?php _e(array('All Settings',false));
;
?></h2>
  <form name="form" action="options.php" method="post" id="all-options">
  <?php wp_nonce_field(array('options-options',false));
?>
  <input type="hidden" name="action" value="update" />
  <input type='hidden' name='option_page' value='options' />
  <table class="form-table">
<?php $options = $wpdb[0]->get_results(concat2(concat1("SELECT * FROM ",$wpdb[0]->options)," ORDER BY option_name"));
foreach ( deAspis(array_cast($options)) as $option  )
{$disabled = array('',false);
$option[0]->option_name = esc_attr($option[0]->option_name);
if ( deAspis(is_serialized($option[0]->option_value)))
 {if ( deAspis(is_serialized_string($option[0]->option_value)))
 {$value = maybe_unserialize($option[0]->option_value);
arrayAssignAdd($options_to_update[0][],addTaint($option[0]->option_name));
$class = array('all-options',false);
}else 
{{$value = array('SERIALIZED DATA',false);
$disabled = array(' disabled="disabled"',false);
$class = array('all-options disabled',false);
}}}else 
{{$value = $option[0]->option_value;
arrayAssignAdd($options_to_update[0][],addTaint($option[0]->option_name));
$class = array('all-options',false);
}}echo AspisCheckPrint(concat2(concat(concat2(concat1("
<tr>
	<th scope='row'><label for='",$option[0]->option_name),"'>"),$option[0]->option_name),"</label></th>
<td>"));
if ( (strpos($value[0],"\n") !== false))
 echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("<textarea class='",$class),"' name='"),$option[0]->option_name),"' id='"),$option[0]->option_name),"' cols='30' rows='5'>"),esc_html($value)),"</textarea>"));
else 
{echo AspisCheckPrint(concat(concat(concat2(concat(concat2(concat(concat2(concat1("<input class='regular-text ",$class),"' type='text' name='"),$option[0]->option_name),"' id='"),$option[0]->option_name),"' value='"),esc_attr($value)),concat2(concat1("'",$disabled)," />")));
}echo AspisCheckPrint(array("</td>
</tr>",false));
};
?>
  </table>
<?php $options_to_update = Aspis_implode(array(',',false),$options_to_update);
;
?>
<p class="submit"><input type="hidden" name="page_options" value="<?php echo AspisCheckPrint(esc_attr($options_to_update));
;
?>" /><input type="submit" name="Update" value="<?php _e(array('Save Changes',false));
?>" class="button-primary" /></p>
  </form>
</div>


<?php include ('admin-footer.php');
break ;
 }
;
?>
<?php 