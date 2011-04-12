<?php require_once('AspisMain.php'); ?><?php
define(('DOING_AJAX'),true);
define(('WP_ADMIN'),true);
require_once ('../wp-load.php');
require_once ('includes/admin.php');
@header((deconcat1('Content-Type: text/html; charset=',get_option(array('blog_charset',false)))));
do_action(array('admin_init',false));
if ( (denot_boolean(is_user_logged_in())))
 {if ( (deAspis($_POST[0]['action']) == ('autosave')))
 {$id = ((isset($_POST[0][('post_ID')]) && Aspis_isset( $_POST [0][('post_ID')]))) ? int_cast($_POST[0]['post_ID']) : array(0,false);
if ( (denot_boolean($id)))
 Aspis_exit(array('-1',false));
$message = Aspis_sprintf(__(array('<strong>ALERT: You are logged out!</strong> Could not save draft. <a href="%s" target="blank">Please log in again.</a>',false)),wp_login_url());
$x = array(new WP_Ajax_Response(array(array('what' => array('autosave',false,false),deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('data',false)) => addTaint($message)),false)),false);
$x[0]->send();
}if ( (!((empty($_REQUEST[0][('action')]) || Aspis_empty( $_REQUEST [0][('action')])))))
 do_action(concat1('wp_ajax_nopriv_',$_REQUEST[0]['action']));
Aspis_exit(array('-1',false));
}if ( ((isset($_GET[0][('action')]) && Aspis_isset( $_GET [0][('action')]))))
 {switch ( deAspis($action = $_GET[0]['action']) ) {
case ('ajax-tag-search'):if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 Aspis_exit(array('-1',false));
$s = $_GET[0]['q'];
if ( ((isset($_GET[0][('tax')]) && Aspis_isset( $_GET [0][('tax')]))))
 $taxonomy = sanitize_title($_GET[0]['tax']);
else 
{Aspis_exit(array('0',false));
}if ( (false !== strpos($s[0],',')))
 {$s = Aspis_explode(array(',',false),$s);
$s = attachAspis($s,(count($s[0]) - (1)));
}$s = Aspis_trim($s);
if ( (strlen($s[0]) < (2)))
 Aspis_exit();
$results = $wpdb[0]->get_col(concat2(concat(concat2(concat(concat2(concat(concat2(concat1("SELECT t.name FROM ",$wpdb[0]->term_taxonomy)," AS tt INNER JOIN "),$wpdb[0]->terms)," AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = '"),$taxonomy),"' AND t.name LIKE ('%"),$s),"%')"));
echo AspisCheckPrint(Aspis_join($results,array("\n",false)));
Aspis_exit();
break ;
;
case ('wp-compression-test'):if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 Aspis_exit(array('-1',false));
if ( ((ini_get('zlib.output_compression')) || (('ob_gzhandler') == (ini_get('output_handler')))))
 {update_site_option(array('can_compress_scripts',false),array(0,false));
Aspis_exit(array('0',false));
}if ( ((isset($_GET[0][('test')]) && Aspis_isset( $_GET [0][('test')]))))
 {header(('Expires: Wed, 11 Jan 1984 05:00:00 GMT'));
header((deconcat2(concat1('Last-Modified: ',attAspis(gmdate(('D, d M Y H:i:s')))),' GMT')));
header(('Cache-Control: no-cache, must-revalidate, max-age=0'));
header(('Pragma: no-cache'));
header(('Content-Type: application/x-javascript; charset=UTF-8'));
$force_gzip = (array(defined(('ENFORCE_GZIP')) && ENFORCE_GZIP,false));
$test_str = array('"wpCompressionTest Lorem ipsum dolor sit amet consectetuer mollis sapien urna ut a. Eu nonummy condimentum fringilla tempor pretium platea vel nibh netus Maecenas. Hac molestie amet justo quis pellentesque est ultrices interdum nibh Morbi. Cras mattis pretium Phasellus ante ipsum ipsum ut sociis Suspendisse Lorem. Ante et non molestie. Porta urna Vestibulum egestas id congue nibh eu risus gravida sit. Ac augue auctor Ut et non a elit massa id sodales. Elit eu Nulla at nibh adipiscing mattis lacus mauris at tempus. Netus nibh quis suscipit nec feugiat eget sed lorem et urna. Pellentesque lacus at ut massa consectetuer ligula ut auctor semper Pellentesque. Ut metus massa nibh quam Curabitur molestie nec mauris congue. Volutpat molestie elit justo facilisis neque ac risus Ut nascetur tristique. Vitae sit lorem tellus et quis Phasellus lacus tincidunt nunc Fusce. Pharetra wisi Suspendisse mus sagittis libero lacinia Integer consequat ac Phasellus. Et urna ac cursus tortor aliquam Aliquam amet tellus volutpat Vestibulum. Justo interdum condimentum In augue congue tellus sollicitudin Quisque quis nibh."',false);
if ( ((1) == deAspis($_GET[0]['test'])))
 {echo AspisCheckPrint($test_str);
Aspis_exit();
}elseif ( ((2) == deAspis($_GET[0]['test'])))
 {if ( (!((isset($_SERVER[0][('HTTP_ACCEPT_ENCODING')]) && Aspis_isset( $_SERVER [0][('HTTP_ACCEPT_ENCODING')])))))
 Aspis_exit(array('-1',false));
if ( (((false !== strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'deflate')) && function_exists(('gzdeflate'))) && (denot_boolean($force_gzip))))
 {header(('Content-Encoding: deflate'));
$out = array(gzdeflate(deAspisRC($test_str),1),false);
}elseif ( ((false !== strpos(deAspis(Aspis_strtolower($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'gzip')) && function_exists(('gzencode'))))
 {header(('Content-Encoding: gzip'));
$out = array(gzencode(deAspisRC($test_str),1),false);
}else 
{{Aspis_exit(array('-1',false));
}}echo AspisCheckPrint($out);
Aspis_exit();
}elseif ( (('no') == deAspis($_GET[0]['test'])))
 {update_site_option(array('can_compress_scripts',false),array(0,false));
}elseif ( (('yes') == deAspis($_GET[0]['test'])))
 {update_site_option(array('can_compress_scripts',false),array(1,false));
}}Aspis_exit(array('0',false));
break ;
case ('imgedit-preview'):$post_id = Aspis_intval($_GET[0]['postid']);
if ( (((empty($post_id) || Aspis_empty( $post_id))) || (denot_boolean(current_user_can(array('edit_post',false),$post_id)))))
 Aspis_exit(array('-1',false));
check_ajax_referer(concat1("image_editor-",$post_id));
include_once (deconcat12(ABSPATH,'wp-admin/includes/image-edit.php'));
if ( (denot_boolean(stream_preview_image($post_id))))
 Aspis_exit(array('-1',false));
Aspis_exit();
break ;
case ('oembed-cache'):$return = deAspis(($wp_embed[0]->cache_oembed($_GET[0]['post']))) ? array('1',false) : array('0',false);
Aspis_exit($return);
break ;
default :do_action(concat1('wp_ajax_',$_GET[0]['action']));
Aspis_exit(array('0',false));
break ;
 }
}function _wp_ajax_delete_comment_response ( $comment_id ) {
$total = int_cast(@$_POST[0]['_total']);
$per_page = int_cast(@$_POST[0]['_per_page']);
$page = int_cast(@$_POST[0]['_page']);
$url = esc_url_raw(@$_POST[0]['_url']);
if ( ((((denot_boolean($total)) || (denot_boolean($per_page))) || (denot_boolean($page))) || (denot_boolean($url))))
 Aspis_exit(string_cast(attAspis(time())));
if ( (deAspis(predecr($total)) < (0)))
 $total = array(0,false);
if ( (((0) != ($total[0] % $per_page[0])) && ((1) != mt_rand((1),$per_page[0]))))
 Aspis_exit(string_cast(attAspis(time())));
$post_id = array(0,false);
$status = array('total_comments',false);
$parsed = Aspis_parse_url($url);
if ( ((isset($parsed[0][('query')]) && Aspis_isset( $parsed [0][('query')]))))
 {AspisInternalFunctionCall("parse_str",deAspis($parsed[0]['query']),AspisPushRefParam($query_vars),array(1));
if ( (!((empty($query_vars[0][('comment_status')]) || Aspis_empty( $query_vars [0][('comment_status')])))))
 $status = $query_vars[0]['comment_status'];
if ( (!((empty($query_vars[0][('p')]) || Aspis_empty( $query_vars [0][('p')])))))
 $post_id = int_cast($query_vars[0]['p']);
}$comment_count = wp_count_comments($post_id);
$time = attAspis(time());
if ( ((isset($comment_count[0]->$status[0]) && Aspis_isset( $comment_count[0] ->$status[0] ))))
 $total = $comment_count[0]->$status[0];
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('apage',false),array('%#%',false),$url)),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint(attAspis(ceil(($total[0] / $per_page[0])))),deregisterTaint(array('current',false)) => addTaint($page)),false));
$x = array(new WP_Ajax_Response(array(array('what' => array('comment',false,false),deregisterTaint(array('id',false)) => addTaint($comment_id),'supplemental' => array(array(deregisterTaint(array('pageLinks',false)) => addTaint($page_links),deregisterTaint(array('total',false)) => addTaint($total),deregisterTaint(array('time',false)) => addTaint($time)),false,false)),false)),false);
$x[0]->send();
 }
$id = ((isset($_POST[0][('id')]) && Aspis_isset( $_POST [0][('id')]))) ? int_cast($_POST[0]['id']) : array(0,false);
switch ( deAspis($action = $_POST[0]['action']) ) {
case ('delete-comment'):if ( (denot_boolean($comment = get_comment($id))))
 Aspis_exit(string_cast(attAspis(time())));
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment[0]->comment_post_ID))))
 Aspis_exit(array('-1',false));
check_ajax_referer(concat1("delete-comment_",$id));
$status = wp_get_comment_status($comment[0]->comment_ID);
if ( (((isset($_POST[0][('trash')]) && Aspis_isset( $_POST [0][('trash')]))) && ((1) == deAspis($_POST[0]['trash']))))
 {if ( (('trash') == $status[0]))
 Aspis_exit(string_cast(attAspis(time())));
$r = wp_trash_comment($comment[0]->comment_ID);
}elseif ( (((isset($_POST[0][('untrash')]) && Aspis_isset( $_POST [0][('untrash')]))) && ((1) == deAspis($_POST[0]['untrash']))))
 {if ( (('trash') != $status[0]))
 Aspis_exit(string_cast(attAspis(time())));
$r = wp_untrash_comment($comment[0]->comment_ID);
}elseif ( (((isset($_POST[0][('spam')]) && Aspis_isset( $_POST [0][('spam')]))) && ((1) == deAspis($_POST[0]['spam']))))
 {if ( (('spam') == $status[0]))
 Aspis_exit(string_cast(attAspis(time())));
$r = wp_spam_comment($comment[0]->comment_ID);
}elseif ( (((isset($_POST[0][('unspam')]) && Aspis_isset( $_POST [0][('unspam')]))) && ((1) == deAspis($_POST[0]['unspam']))))
 {if ( (('spam') != $status[0]))
 Aspis_exit(string_cast(attAspis(time())));
$r = wp_unspam_comment($comment[0]->comment_ID);
}elseif ( (((isset($_POST[0][('delete')]) && Aspis_isset( $_POST [0][('delete')]))) && ((1) == deAspis($_POST[0]['delete']))))
 {$r = wp_delete_comment($comment[0]->comment_ID);
}else 
{{Aspis_exit(array('-1',false));
}}if ( $r[0])
 _wp_ajax_delete_comment_response($comment[0]->comment_ID);
Aspis_exit(array('0',false));
break ;
;
case ('delete-cat'):check_ajax_referer(concat1("delete-category_",$id));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
$cat = get_category($id);
if ( ((denot_boolean($cat)) || deAspis(is_wp_error($cat))))
 Aspis_exit(array('1',false));
if ( deAspis(wp_delete_category($id)))
 Aspis_exit(array('1',false));
else 
{Aspis_exit(array('0',false));
}break ;
case ('delete-tag'):$tag_id = int_cast($_POST[0]['tag_ID']);
check_ajax_referer(concat1("delete-tag_",$tag_id));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
$taxonomy = (!((empty($_POST[0][('taxonomy')]) || Aspis_empty( $_POST [0][('taxonomy')])))) ? $_POST[0]['taxonomy'] : array('post_tag',false);
$tag = get_term($tag_id,$taxonomy);
if ( ((denot_boolean($tag)) || deAspis(is_wp_error($tag))))
 Aspis_exit(array('1',false));
if ( deAspis(wp_delete_term($tag_id,$taxonomy)))
 Aspis_exit(array('1',false));
else 
{Aspis_exit(array('0',false));
}break ;
case ('delete-link-cat'):check_ajax_referer(concat1("delete-link-category_",$id));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
$cat = get_term($id,array('link_category',false));
if ( ((denot_boolean($cat)) || deAspis(is_wp_error($cat))))
 Aspis_exit(array('1',false));
$cat_name = get_term_field(array('name',false),$id,array('link_category',false));
$default = get_option(array('default_link_category',false));
if ( ($id[0] == $default[0]))
 {$x = array(new WP_AJAX_Response(array(array('what' => array('link-cat',false,false),deregisterTaint(array('id',false)) => addTaint($id),'data' => array(new WP_Error(array('default-link-cat',false),Aspis_sprintf(__(array("Can&#8217;t delete the <strong>%s</strong> category: this is the default one",false)),$cat_name)),false,false)),false)),false);
$x[0]->send();
}$r = wp_delete_term($id,array('link_category',false),array(array(deregisterTaint(array('default',false)) => addTaint($default)),false));
if ( (denot_boolean($r)))
 Aspis_exit(array('0',false));
if ( deAspis(is_wp_error($r)))
 {$x = array(new WP_AJAX_Response(array(array('what' => array('link-cat',false,false),deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('data',false)) => addTaint($r)),false)),false);
$x[0]->send();
}Aspis_exit(array('1',false));
break ;
case ('delete-link'):check_ajax_referer(concat1("delete-bookmark_",$id));
if ( (denot_boolean(current_user_can(array('manage_links',false)))))
 Aspis_exit(array('-1',false));
$link = get_bookmark($id);
if ( ((denot_boolean($link)) || deAspis(is_wp_error($link))))
 Aspis_exit(array('1',false));
if ( deAspis(wp_delete_link($id)))
 Aspis_exit(array('1',false));
else 
{Aspis_exit(array('0',false));
}break ;
case ('delete-meta'):check_ajax_referer(concat1("delete-meta_",$id));
if ( (denot_boolean($meta = get_post_meta_by_id($id))))
 Aspis_exit(array('1',false));
if ( (denot_boolean(current_user_can(array('edit_post',false),$meta[0]->post_id))))
 Aspis_exit(array('-1',false));
if ( deAspis(delete_meta($meta[0]->meta_id)))
 Aspis_exit(array('1',false));
Aspis_exit(array('0',false));
break ;
case ('delete-post'):check_ajax_referer(concat(concat2($action,"_"),$id));
if ( (denot_boolean(current_user_can(array('delete_post',false),$id))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean(get_post($id))))
 Aspis_exit(array('1',false));
if ( deAspis(wp_delete_post($id)))
 Aspis_exit(array('1',false));
else 
{Aspis_exit(array('0',false));
}break ;
case ('trash-post'):case ('untrash-post'):check_ajax_referer(concat(concat2($action,"_"),$id));
if ( (denot_boolean(current_user_can(array('delete_post',false),$id))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean(get_post($id))))
 Aspis_exit(array('1',false));
if ( (('trash-post') == $action[0]))
 $done = wp_trash_post($id);
else 
{$done = wp_untrash_post($id);
}if ( $done[0])
 Aspis_exit(array('1',false));
Aspis_exit(array('0',false));
break ;
case ('delete-page'):check_ajax_referer(concat(concat2($action,"_"),$id));
if ( (denot_boolean(current_user_can(array('delete_page',false),$id))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean(get_page($id))))
 Aspis_exit(array('1',false));
if ( deAspis(wp_delete_post($id)))
 Aspis_exit(array('1',false));
else 
{Aspis_exit(array('0',false));
}break ;
case ('dim-comment'):if ( (denot_boolean($comment = get_comment($id))))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('comment',false,false),'id' => array(new WP_Error(array('invalid_comment',false),Aspis_sprintf(__(array('Comment %d does not exist',false)),$id)),false,false)),false)),false);
$x[0]->send();
}if ( ((denot_boolean(current_user_can(array('edit_post',false),$comment[0]->comment_post_ID))) && (denot_boolean(current_user_can(array('moderate_comments',false))))))
 Aspis_exit(array('-1',false));
$current = wp_get_comment_status($comment[0]->comment_ID);
if ( (deAspis($_POST[0]['new']) == $current[0]))
 Aspis_exit(string_cast(attAspis(time())));
check_ajax_referer(concat1("approve-comment_",$id));
if ( deAspis(Aspis_in_array($current,array(array(array('unapproved',false),array('spam',false)),false))))
 $result = wp_set_comment_status($comment[0]->comment_ID,array('approve',false),array(true,false));
else 
{$result = wp_set_comment_status($comment[0]->comment_ID,array('hold',false),array(true,false));
}if ( deAspis(is_wp_error($result)))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('comment',false,false),deregisterTaint(array('id',false)) => addTaint($result)),false)),false);
$x[0]->send();
}_wp_ajax_delete_comment_response($comment[0]->comment_ID);
Aspis_exit(array('0',false));
break ;
case ('add-category'):check_ajax_referer($action);
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
$names = Aspis_explode(array(',',false),$_POST[0]['newcat']);
if ( ((0) > deAspis($parent = int_cast($_POST[0]['newcat_parent']))))
 $parent = array(0,false);
$post_category = ((isset($_POST[0][('post_category')]) && Aspis_isset( $_POST [0][('post_category')]))) ? array_cast($_POST[0]['post_category']) : array(array(),false);
$checked_categories = attAspisRC(array_map(AspisInternalCallback(array('absint',false)),deAspisRC(array_cast($post_category))));
$popular_ids = wp_popular_terms_checklist(array('category',false),array(0,false),array(10,false),array(false,false));
foreach ( $names[0] as $cat_name  )
{$cat_name = Aspis_trim($cat_name);
$category_nicename = sanitize_title($cat_name);
if ( (('') === $category_nicename[0]))
 continue ;
$cat_id = wp_create_category($cat_name,$parent);
arrayAssignAdd($checked_categories[0][],addTaint($cat_id));
if ( $parent[0])
 continue ;
$category = get_category($cat_id);
ob_start();
wp_category_checklist(array(0,false),$cat_id,$checked_categories,$popular_ids);
$data = attAspis(ob_get_contents());
ob_end_clean();
$add = array(array('what' => array('category',false,false),deregisterTaint(array('id',false)) => addTaint($cat_id),deregisterTaint(array('data',false)) => addTaint(Aspis_str_replace(array(array(array("\n",false),array("\t",false)),false),array('',false),$data)),deregisterTaint(array('position',false)) => addTaint(negate(array(1,false)))),false);
}if ( $parent[0])
 {$parent = get_category($parent);
$term_id = $parent[0]->term_id;
while ( $parent[0]->parent[0] )
{$parent = &get_category($parent[0]->parent);
if ( deAspis(is_wp_error($parent)))
 break ;
$term_id = $parent[0]->term_id;
}ob_start();
wp_category_checklist(array(0,false),$term_id,$checked_categories,$popular_ids,array(null,false),array(false,false));
$data = attAspis(ob_get_contents());
ob_end_clean();
$add = array(array('what' => array('category',false,false),deregisterTaint(array('id',false)) => addTaint($term_id),deregisterTaint(array('data',false)) => addTaint(Aspis_str_replace(array(array(array("\n",false),array("\t",false)),false),array('',false),$data)),deregisterTaint(array('position',false)) => addTaint(negate(array(1,false)))),false);
}ob_start();
wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('newcat_parent',false,false),'orderby' => array('name',false,false),'hierarchical' => array(1,false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('Parent category',false)))),false));
$sup = attAspis(ob_get_contents());
ob_end_clean();
arrayAssign($add[0],deAspis(registerTaint(array('supplemental',false))),addTaint(array(array(deregisterTaint(array('newcat_parent',false)) => addTaint($sup)),false)));
$x = array(new WP_Ajax_Response($add),false);
$x[0]->send();
break ;
case ('add-link-category'):check_ajax_referer($action);
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
$names = Aspis_explode(array(',',false),$_POST[0]['newcat']);
$x = array(new WP_Ajax_Response(),false);
foreach ( $names[0] as $cat_name  )
{$cat_name = Aspis_trim($cat_name);
$slug = sanitize_title($cat_name);
if ( (('') === $slug[0]))
 continue ;
if ( (denot_boolean($cat_id = is_term($cat_name,array('link_category',false)))))
 {$cat_id = wp_insert_term($cat_name,array('link_category',false));
}$cat_id = $cat_id[0]['term_id'];
$cat_name = esc_html(Aspis_stripslashes($cat_name));
$x[0]->add(array(array('what' => array('link-category',false,false),deregisterTaint(array('id',false)) => addTaint($cat_id),deregisterTaint(array('data',false)) => addTaint(concat(concat(concat2(concat(concat2(concat1("<li id='link-category-",$cat_id),"'><label for='in-link-category-"),$cat_id),"' class='selectit'><input value='"),esc_attr($cat_id)),concat2(concat(concat2(concat1("' type='checkbox' checked='checked' name='link_category[]' id='in-link-category-",$cat_id),"'/> "),$cat_name),"</label></li>"))),deregisterTaint(array('position',false)) => addTaint(negate(array(1,false)))),false));
}$x[0]->send();
break ;
case ('add-cat'):check_ajax_referer(array('add-category',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
if ( (('') === deAspis(Aspis_trim($_POST[0]['cat_name']))))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('cat',false,false),'id' => array(new WP_Error(array('cat_name',false),__(array('You did not enter a category name.',false))),false,false)),false)),false);
$x[0]->send();
}if ( deAspis(category_exists(Aspis_trim($_POST[0]['cat_name']),$_POST[0]['category_parent'])))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('cat',false,false),'id' => array(new WP_Error(array('cat_exists',false),__(array('The category you are trying to create already exists.',false)),array(array('form-field' => array('cat_name',false,false)),false)),false,false),),false)),false);
$x[0]->send();
}$cat = wp_insert_category($_POST,array(true,false));
if ( deAspis(is_wp_error($cat)))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('cat',false,false),deregisterTaint(array('id',false)) => addTaint($cat)),false)),false);
$x[0]->send();
}if ( ((denot_boolean($cat)) || (denot_boolean($cat = get_category($cat)))))
 Aspis_exit(array('0',false));
$level = array(0,false);
$cat_full_name = $cat[0]->name;
$_cat = $cat;
while ( $_cat[0]->parent[0] )
{$_cat = get_category($_cat[0]->parent);
$cat_full_name = concat(concat2($_cat[0]->name,' &#8212; '),$cat_full_name);
postincr($level);
}$cat_full_name = esc_attr($cat_full_name);
$x = array(new WP_Ajax_Response(array(array('what' => array('cat',false,false),deregisterTaint(array('id',false)) => addTaint($cat[0]->term_id),deregisterTaint(array('position',false)) => addTaint(negate(array(1,false))),deregisterTaint(array('data',false)) => addTaint(_cat_row($cat,$level,$cat_full_name)),'supplemental' => array(array(deregisterTaint(array('name',false)) => addTaint($cat_full_name),deregisterTaint(array('show-link',false)) => addTaint(Aspis_sprintf(__(array('Category <a href="#%s">%s</a> added',false)),concat1("cat-",$cat[0]->term_id),$cat_full_name))),false,false)),false)),false);
$x[0]->send();
break ;
case ('add-link-cat'):check_ajax_referer(array('add-link-category',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
if ( (('') === deAspis(Aspis_trim($_POST[0]['name']))))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('link-cat',false,false),'id' => array(new WP_Error(array('name',false),__(array('You did not enter a category name.',false))),false,false)),false)),false);
$x[0]->send();
}$r = wp_insert_term($_POST[0]['name'],array('link_category',false),$_POST);
if ( deAspis(is_wp_error($r)))
 {$x = array(new WP_AJAX_Response(array(array('what' => array('link-cat',false,false),deregisterTaint(array('id',false)) => addTaint($r)),false)),false);
$x[0]->send();
}extract(($r[0]),EXTR_SKIP);
if ( (denot_boolean($link_cat = link_cat_row($term_id))))
 Aspis_exit(array('0',false));
$x = array(new WP_Ajax_Response(array(array('what' => array('link-cat',false,false),deregisterTaint(array('id',false)) => addTaint($term_id),deregisterTaint(array('position',false)) => addTaint(negate(array(1,false))),deregisterTaint(array('data',false)) => addTaint($link_cat)),false)),false);
$x[0]->send();
break ;
case ('add-tag'):check_ajax_referer(array('add-tag',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(array('-1',false));
$taxonomy = (!((empty($_POST[0][('taxonomy')]) || Aspis_empty( $_POST [0][('taxonomy')])))) ? $_POST[0]['taxonomy'] : array('post_tag',false);
$tag = wp_insert_term($_POST[0]['tag-name'],$taxonomy,$_POST);
if ( (((denot_boolean($tag)) || deAspis(is_wp_error($tag))) || (denot_boolean($tag = get_term($tag[0]['term_id'],$taxonomy)))))
 {echo AspisCheckPrint(concat2(concat1('<div class="error"><p>',__(array('An error has occured. Please reload the page and try again.',false))),'</p></div>'));
Aspis_exit();
}echo AspisCheckPrint(_tag_row($tag,array('',false),$taxonomy));
Aspis_exit();
break ;
case ('get-tagcloud'):if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 Aspis_exit(array('-1',false));
if ( ((isset($_POST[0][('tax')]) && Aspis_isset( $_POST [0][('tax')]))))
 $taxonomy = sanitize_title($_POST[0]['tax']);
else 
{Aspis_exit(array('0',false));
}$tags = get_terms($taxonomy,array(array('number' => array(45,false,false),'orderby' => array('count',false,false),'order' => array('DESC',false,false)),false));
if ( ((empty($tags) || Aspis_empty( $tags))))
 Aspis_exit(__(array('No tags found!',false)));
if ( deAspis(is_wp_error($tags)))
 Aspis_exit($tags[0]->get_error_message());
foreach ( $tags[0] as $key =>$tag )
{restoreTaint($key,$tag);
{$tags[0][$key[0]][0]->link = array('#',false);
$tags[0][$key[0]][0]->id = $tag[0]->term_id;
}}$return = wp_generate_tag_cloud($tags,array(array('filter' => array(0,false,false)),false));
if ( ((empty($return) || Aspis_empty( $return))))
 Aspis_exit(array('0',false));
echo AspisCheckPrint($return);
Aspis_exit();
break ;
case ('add-comment'):check_ajax_referer($action);
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 Aspis_exit(array('-1',false));
$search = ((isset($_POST[0][('s')]) && Aspis_isset( $_POST [0][('s')]))) ? $_POST[0]['s'] : array(false,false);
$status = ((isset($_POST[0][('comment_status')]) && Aspis_isset( $_POST [0][('comment_status')]))) ? $_POST[0]['comment_status'] : array('all',false);
$per_page = ((isset($_POST[0][('per_page')]) && Aspis_isset( $_POST [0][('per_page')]))) ? array(deAspis(int_cast($_POST[0]['per_page'])) + (8),false) : array(28,false);
$start = ((isset($_POST[0][('page')]) && Aspis_isset( $_POST [0][('page')]))) ? array((deAspis(Aspis_intval($_POST[0]['page'])) * $per_page[0]) - (1),false) : array($per_page[0] - (1),false);
if ( ((1) > $start[0]))
 $start = array(27,false);
$mode = ((isset($_POST[0][('mode')]) && Aspis_isset( $_POST [0][('mode')]))) ? $_POST[0]['mode'] : array('detail',false);
$p = ((isset($_POST[0][('p')]) && Aspis_isset( $_POST [0][('p')]))) ? $_POST[0]['p'] : array(0,false);
$comment_type = ((isset($_POST[0][('comment_type')]) && Aspis_isset( $_POST [0][('comment_type')]))) ? $_POST[0]['comment_type'] : array('',false);
list($comments,$total) = deAspisList(_wp_get_comment_list($status,$search,$start,array(1,false),$p,$comment_type),array());
if ( deAspis(get_option(array('show_avatars',false))))
 add_filter(array('comment_author',false),array('floated_admin_avatar',false));
if ( (denot_boolean($comments)))
 Aspis_exit(array('1',false));
$x = array(new WP_Ajax_Response(),false);
foreach ( deAspis(array_cast($comments)) as $comment  )
{get_comment($comment);
ob_start();
_wp_comment_row($comment[0]->comment_ID,$mode,$status,array(true,false),array(true,false));
$comment_list_item = attAspis(ob_get_contents());
ob_end_clean();
$x[0]->add(array(array('what' => array('comment',false,false),deregisterTaint(array('id',false)) => addTaint($comment[0]->comment_ID),deregisterTaint(array('data',false)) => addTaint($comment_list_item)),false));
}$x[0]->send();
break ;
case ('get-comments'):check_ajax_referer($action);
$post_ID = int_cast($_POST[0]['post_ID']);
if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 Aspis_exit(array('-1',false));
$start = ((isset($_POST[0][('start')]) && Aspis_isset( $_POST [0][('start')]))) ? Aspis_intval($_POST[0]['start']) : array(0,false);
$num = ((isset($_POST[0][('num')]) && Aspis_isset( $_POST [0][('num')]))) ? Aspis_intval($_POST[0]['num']) : array(10,false);
list($comments,$total) = deAspisList(_wp_get_comment_list(array(false,false),array(false,false),$start,$num,$post_ID),array());
if ( (denot_boolean($comments)))
 Aspis_exit(array('1',false));
$comment_list_item = array('',false);
$x = array(new WP_Ajax_Response(),false);
foreach ( deAspis(array_cast($comments)) as $comment  )
{get_comment($comment);
ob_start();
_wp_comment_row($comment[0]->comment_ID,array('single',false),array(false,false),array(false,false));
$comment_list_item = concat($comment_list_item,attAspis(ob_get_contents()));
ob_end_clean();
}$x[0]->add(array(array('what' => array('comments',false,false),deregisterTaint(array('data',false)) => addTaint($comment_list_item)),false));
$x[0]->send();
break ;
case ('replyto-comment'):check_ajax_referer($action);
$comment_post_ID = int_cast($_POST[0]['comment_post_ID']);
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment_post_ID))))
 Aspis_exit(array('-1',false));
$status = $wpdb[0]->get_var($wpdb[0]->prepare(concat2(concat1("SELECT post_status FROM ",$wpdb[0]->posts)," WHERE ID = %d"),$comment_post_ID));
if ( ((empty($status) || Aspis_empty( $status))))
 Aspis_exit(array('1',false));
elseif ( deAspis(Aspis_in_array($status,array(array(array('draft',false),array('pending',false),array('trash',false)),false))))
 Aspis_exit(__(array('Error: you are replying to a comment on a draft post.',false)));
$user = wp_get_current_user();
if ( $user[0]->ID[0])
 {$comment_author = $wpdb[0]->escape($user[0]->display_name);
$comment_author_email = $wpdb[0]->escape($user[0]->user_email);
$comment_author_url = $wpdb[0]->escape($user[0]->user_url);
$comment_content = Aspis_trim($_POST[0]['content']);
if ( deAspis(current_user_can(array('unfiltered_html',false))))
 {if ( (deAspis(wp_create_nonce(concat1('unfiltered-html-comment_',$comment_post_ID))) != deAspis($_POST[0]['_wp_unfiltered_html_comment'])))
 {kses_remove_filters();
kses_init_filters();
}}}else 
{{Aspis_exit(__(array('Sorry, you must be logged in to reply to a comment.',false)));
}}if ( (('') == $comment_content[0]))
 Aspis_exit(__(array('Error: please type a comment.',false)));
$comment_parent = absint($_POST[0]['comment_ID']);
$commentdata = array(compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_content','comment_type','comment_parent','user_ID'),false);
$comment_id = wp_new_comment($commentdata);
$comment = get_comment($comment_id);
if ( (denot_boolean($comment)))
 Aspis_exit(array('1',false));
$modes = array(array(array('single',false),array('detail',false),array('dashboard',false)),false);
$mode = (((isset($_POST[0][('mode')]) && Aspis_isset( $_POST [0][('mode')]))) && deAspis(Aspis_in_array($_POST[0]['mode'],$modes))) ? $_POST[0]['mode'] : array('detail',false);
$position = (((isset($_POST[0][('position')]) && Aspis_isset( $_POST [0][('position')]))) && deAspis(int_cast($_POST[0]['position']))) ? int_cast($_POST[0]['position']) : array('-1',false);
$checkbox = (((isset($_POST[0][('checkbox')]) && Aspis_isset( $_POST [0][('checkbox')]))) && (true == deAspis($_POST[0]['checkbox']))) ? array(1,false) : array(0,false);
if ( (deAspis(get_option(array('show_avatars',false))) && (('single') != $mode[0])))
 add_filter(array('comment_author',false),array('floated_admin_avatar',false));
$x = array(new WP_Ajax_Response(),false);
ob_start();
if ( (('dashboard') == $mode[0]))
 {require_once (deconcat12(ABSPATH,'wp-admin/includes/dashboard.php'));
_wp_dashboard_recent_comments_row($comment,array(false,false));
}else 
{{_wp_comment_row($comment[0]->comment_ID,$mode,array(false,false),$checkbox);
}}$comment_list_item = attAspis(ob_get_contents());
ob_end_clean();
$x[0]->add(array(array('what' => array('comment',false,false),deregisterTaint(array('id',false)) => addTaint($comment[0]->comment_ID),deregisterTaint(array('data',false)) => addTaint($comment_list_item),deregisterTaint(array('position',false)) => addTaint($position)),false));
$x[0]->send();
break ;
case ('edit-comment'):check_ajax_referer(array('replyto-comment',false));
$comment_post_ID = int_cast($_POST[0]['comment_post_ID']);
if ( (denot_boolean(current_user_can(array('edit_post',false),$comment_post_ID))))
 Aspis_exit(array('-1',false));
if ( (('') == deAspis($_POST[0]['content'])))
 Aspis_exit(__(array('Error: please type a comment.',false)));
$comment_id = int_cast($_POST[0]['comment_ID']);
arrayAssign($_POST[0],deAspis(registerTaint(array('comment_status',false))),addTaint($_POST[0]['status']));
edit_comment();
$mode = (((isset($_POST[0][('mode')]) && Aspis_isset( $_POST [0][('mode')]))) && (('single') == deAspis($_POST[0]['mode']))) ? array('single',false) : array('detail',false);
$position = (((isset($_POST[0][('position')]) && Aspis_isset( $_POST [0][('position')]))) && deAspis(int_cast($_POST[0]['position']))) ? int_cast($_POST[0]['position']) : array('-1',false);
$checkbox = (((isset($_POST[0][('checkbox')]) && Aspis_isset( $_POST [0][('checkbox')]))) && (true == deAspis($_POST[0]['checkbox']))) ? array(1,false) : array(0,false);
$comments_listing = ((isset($_POST[0][('comments_listing')]) && Aspis_isset( $_POST [0][('comments_listing')]))) ? $_POST[0]['comments_listing'] : array('',false);
if ( (deAspis(get_option(array('show_avatars',false))) && (('single') != $mode[0])))
 add_filter(array('comment_author',false),array('floated_admin_avatar',false));
$x = array(new WP_Ajax_Response(),false);
ob_start();
_wp_comment_row($comment_id,$mode,$comments_listing,$checkbox);
$comment_list_item = attAspis(ob_get_contents());
ob_end_clean();
$x[0]->add(array(array('what' => array('edit_comment',false,false),deregisterTaint(array('id',false)) => addTaint($comment[0]->comment_ID),deregisterTaint(array('data',false)) => addTaint($comment_list_item),deregisterTaint(array('position',false)) => addTaint($position)),false));
$x[0]->send();
break ;
case ('add-meta'):check_ajax_referer(array('add-meta',false));
$c = array(0,false);
$pid = int_cast($_POST[0]['post_id']);
if ( (((isset($_POST[0][('metakeyselect')]) && Aspis_isset( $_POST [0][('metakeyselect')]))) || ((isset($_POST[0][('metakeyinput')]) && Aspis_isset( $_POST [0][('metakeyinput')])))))
 {if ( (denot_boolean(current_user_can(array('edit_post',false),$pid))))
 Aspis_exit(array('-1',false));
if ( ((((isset($_POST[0][('metakeyselect')]) && Aspis_isset( $_POST [0][('metakeyselect')]))) && (('#NONE#') == deAspis($_POST[0]['metakeyselect']))) && ((empty($_POST[0][('metakeyinput')]) || Aspis_empty( $_POST [0][('metakeyinput')])))))
 Aspis_exit(array('1',false));
if ( ($pid[0] < (0)))
 {$now = current_time(array('timestamp',false),array(1,false));
if ( deAspis($pid = wp_insert_post(array(array(deregisterTaint(array('post_title',false)) => addTaint(Aspis_sprintf(array('Draft created on %s at %s',false),attAspis(date(deAspis(get_option(array('date_format',false))),$now[0])),attAspis(date(deAspis(get_option(array('time_format',false))),$now[0]))))),false))))
 {if ( deAspis(is_wp_error($pid)))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('meta',false,false),deregisterTaint(array('data',false)) => addTaint($pid)),false)),false);
$x[0]->send();
}if ( (denot_boolean($mid = add_meta($pid))))
 Aspis_exit(__(array('Please provide a custom field value.',false)));
}else 
{{Aspis_exit(array('0',false));
}}}else 
{if ( (denot_boolean($mid = add_meta($pid))))
 {Aspis_exit(__(array('Please provide a custom field value.',false)));
}}$meta = get_post_meta_by_id($mid);
$pid = int_cast($meta[0]->post_id);
$meta = attAspis(get_object_vars(deAspisRC($meta)));
$x = array(new WP_Ajax_Response(array(array('what' => array('meta',false,false),deregisterTaint(array('id',false)) => addTaint($mid),deregisterTaint(array('data',false)) => addTaint(_list_meta_row($meta,$c)),'position' => array(1,false,false),'supplemental' => array(array(deregisterTaint(array('postid',false)) => addTaint($pid)),false,false)),false)),false);
}else 
{{$mid = int_cast(Aspis_array_pop(attAspisRC(array_keys(deAspisRC($_POST[0]['meta'])))));
$key = $_POST[0][('meta')][0][$mid[0]][0]['key'];
$value = $_POST[0][('meta')][0][$mid[0]][0]['value'];
if ( (denot_boolean($meta = get_post_meta_by_id($mid))))
 Aspis_exit(array('0',false));
if ( (denot_boolean(current_user_can(array('edit_post',false),$meta[0]->post_id))))
 Aspis_exit(array('-1',false));
if ( ($meta[0]->meta_value[0] != deAspis(Aspis_stripslashes($value))))
 {if ( (denot_boolean($u = update_meta($mid,$key,$value))))
 Aspis_exit(array('0',false));
}$key = Aspis_stripslashes($key);
$value = Aspis_stripslashes($value);
$x = array(new WP_Ajax_Response(array(array('what' => array('meta',false,false),deregisterTaint(array('id',false)) => addTaint($mid),deregisterTaint(array('old_id',false)) => addTaint($mid),deregisterTaint(array('data',false)) => addTaint(_list_meta_row(array(array(deregisterTaint(array('meta_key',false)) => addTaint($key),deregisterTaint(array('meta_value',false)) => addTaint($value),deregisterTaint(array('meta_id',false)) => addTaint($mid)),false),$c)),'position' => array(0,false,false),'supplemental' => array(array(deregisterTaint(array('postid',false)) => addTaint($meta[0]->post_id)),false,false)),false)),false);
}}$x[0]->send();
break ;
case ('add-user'):check_ajax_referer($action);
if ( (denot_boolean(current_user_can(array('create_users',false)))))
 Aspis_exit(array('-1',false));
require_once (deconcat2(concat12(ABSPATH,WPINC),'/registration.php'));
if ( (denot_boolean($user_id = add_user())))
 Aspis_exit(array('0',false));
elseif ( deAspis(is_wp_error($user_id)))
 {$x = array(new WP_Ajax_Response(array(array('what' => array('user',false,false),deregisterTaint(array('id',false)) => addTaint($user_id)),false)),false);
$x[0]->send();
}$user_object = array(new WP_User($user_id),false);
$x = array(new WP_Ajax_Response(array(array('what' => array('user',false,false),deregisterTaint(array('id',false)) => addTaint($user_id),deregisterTaint(array('data',false)) => addTaint(user_row($user_object,array('',false),$user_object[0]->roles[0][(0)])),'supplemental' => array(array(deregisterTaint(array('show-link',false)) => addTaint(Aspis_sprintf(__(array('User <a href="#%s">%s</a> added',false)),concat1("user-",$user_id),$user_object[0]->user_login)),deregisterTaint(array('role',false)) => addTaint($user_object[0]->roles[0][(0)])),false,false)),false)),false);
$x[0]->send();
break ;
case ('autosave'):define(('DOING_AUTOSAVE'),true);
$nonce_age = check_ajax_referer(array('autosave',false),array('autosavenonce',false));
global $current_user;
arrayAssign($_POST[0],deAspis(registerTaint(array('post_category',false))),addTaint(Aspis_explode(array(",",false),$_POST[0]['catslist'])));
if ( ((deAspis($_POST[0]['post_type']) == ('page')) || ((empty($_POST[0][('post_category')]) || Aspis_empty( $_POST [0][('post_category')])))))
 unset($_POST[0][('post_category')]);
$do_autosave = bool_cast($_POST[0]['autosave']);
$do_lock = array(true,false);
$data = array('',false);
$draft_saved_date_format = __(array('g:i:s a',false));
$message = Aspis_sprintf(__(array('Draft Saved at %s.',false)),date_i18n($draft_saved_date_format));
$supplemental = array(array(),false);
if ( ((isset($login_grace_period) && Aspis_isset( $login_grace_period))))
 arrayAssign($supplemental[0],deAspis(registerTaint(array('session_expired',false))),addTaint(add_query_arg(array('interim-login',false),array(1,false),wp_login_url())));
$id = $revision_id = array(0,false);
if ( (deAspis($_POST[0]['post_ID']) < (0)))
 {arrayAssign($_POST[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('draft',false)));
arrayAssign($_POST[0],deAspis(registerTaint(array('temp_ID',false))),addTaint($_POST[0]['post_ID']));
if ( $do_autosave[0])
 {$id = wp_write_post();
$data = $message;
}}else 
{{$post_ID = int_cast($_POST[0]['post_ID']);
arrayAssign($_POST[0],deAspis(registerTaint(array('ID',false))),addTaint($post_ID));
$post = get_post($post_ID);
if ( deAspis($last = wp_check_post_lock($post[0]->ID)))
 {$do_autosave = $do_lock = array(false,false);
$last_user = get_userdata($last);
$last_user_name = $last_user[0] ? $last_user[0]->display_name : __(array('Someone',false));
$data = array(new WP_Error(array('locked',false),Aspis_sprintf((deAspis($_POST[0]['post_type']) == ('page')) ? __(array('Autosave disabled: %s is currently editing this page.',false)) : __(array('Autosave disabled: %s is currently editing this post.',false)),esc_html($last_user_name))),false);
arrayAssign($supplemental[0],deAspis(registerTaint(array('disable_autosave',false))),addTaint(array('disable',false)));
}if ( (('page') == $post[0]->post_type[0]))
 {if ( (denot_boolean(current_user_can(array('edit_page',false),$post_ID))))
 Aspis_exit(__(array('You are not allowed to edit this page.',false)));
}else 
{{if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 Aspis_exit(__(array('You are not allowed to edit this post.',false)));
}}if ( $do_autosave[0])
 {if ( (('draft') == $post[0]->post_status[0]))
 {$id = edit_post();
}else 
{{$revision_id = wp_create_post_autosave($post[0]->ID);
if ( deAspis(is_wp_error($revision_id)))
 $id = $revision_id;
else 
{$id = $post[0]->ID;
}}}$data = $message;
}else 
{{$id = $post[0]->ID;
}}}}if ( (($do_lock[0] && $id[0]) && is_numeric(deAspisRC($id))))
 wp_set_post_lock($id);
if ( ($nonce_age[0] == (2)))
 {arrayAssign($supplemental[0],deAspis(registerTaint(array('replace-autosavenonce',false))),addTaint(wp_create_nonce(array('autosave',false))));
arrayAssign($supplemental[0],deAspis(registerTaint(array('replace-getpermalinknonce',false))),addTaint(wp_create_nonce(array('getpermalink',false))));
arrayAssign($supplemental[0],deAspis(registerTaint(array('replace-samplepermalinknonce',false))),addTaint(wp_create_nonce(array('samplepermalink',false))));
arrayAssign($supplemental[0],deAspis(registerTaint(array('replace-closedpostboxesnonce',false))),addTaint(wp_create_nonce(array('closedpostboxes',false))));
if ( $id[0])
 {if ( (deAspis($_POST[0]['post_type']) == ('post')))
 arrayAssign($supplemental[0],deAspis(registerTaint(array('replace-_wpnonce',false))),addTaint(wp_create_nonce(concat1('update-post_',$id))));
elseif ( (deAspis($_POST[0]['post_type']) == ('page')))
 arrayAssign($supplemental[0],deAspis(registerTaint(array('replace-_wpnonce',false))),addTaint(wp_create_nonce(concat1('update-page_',$id))));
}}$x = array(new WP_Ajax_Response(array(array('what' => array('autosave',false,false),deregisterTaint(array('id',false)) => addTaint($id),deregisterTaint(array('data',false)) => addTaint($id[0] ? $data : array('',false)),deregisterTaint(array('supplemental',false)) => addTaint($supplemental)),false)),false);
$x[0]->send();
break ;
case ('autosave-generate-nonces'):check_ajax_referer(array('autosave',false),array('autosavenonce',false));
$ID = int_cast($_POST[0]['post_ID']);
$post_type = (('page') == deAspis($_POST[0]['post_type'])) ? array('page',false) : array('post',false);
if ( deAspis(current_user_can(concat1("edit_",$post_type),$ID)))
 Aspis_exit(array(json_encode(deAspisRC(array(array(deregisterTaint(array('updateNonce',false)) => addTaint(wp_create_nonce(concat(concat2(concat1("update-",$post_type),"_"),$ID))),deregisterTaint(array('deleteURL',false)) => addTaint(Aspis_str_replace(array('&amp;',false),array('&',false),wp_nonce_url(admin_url(concat(concat2($post_type,'.php?action=trash&post='),$ID)),concat(concat2(concat1("trash-",$post_type),"_"),$ID))))),false))),false));
do_action(array('autosave_generate_nonces',false));
Aspis_exit(array('0',false));
break ;
case ('closed-postboxes'):check_ajax_referer(array('closedpostboxes',false),array('closedpostboxesnonce',false));
$closed = ((isset($_POST[0][('closed')]) && Aspis_isset( $_POST [0][('closed')]))) ? $_POST[0]['closed'] : array('',false);
$closed = Aspis_explode(array(',',false),$_POST[0]['closed']);
$hidden = ((isset($_POST[0][('hidden')]) && Aspis_isset( $_POST [0][('hidden')]))) ? $_POST[0]['hidden'] : array('',false);
$hidden = Aspis_explode(array(',',false),$_POST[0]['hidden']);
$page = ((isset($_POST[0][('page')]) && Aspis_isset( $_POST [0][('page')]))) ? $_POST[0]['page'] : array('',false);
if ( (denot_boolean(Aspis_preg_match(array('/^[a-z_-]+$/',false),$page))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean($user = wp_get_current_user())))
 Aspis_exit(array('-1',false));
if ( is_array($closed[0]))
 update_usermeta($user[0]->ID,concat1('closedpostboxes_',$page),$closed);
if ( is_array($hidden[0]))
 {$hidden = Aspis_array_diff($hidden,array(array(array('submitdiv',false),array('linksubmitdiv',false)),false));
update_usermeta($user[0]->ID,concat1('meta-box-hidden_',$page),$hidden);
}Aspis_exit(array('1',false));
break ;
case ('hidden-columns'):check_ajax_referer(array('screen-options-nonce',false),array('screenoptionnonce',false));
$hidden = ((isset($_POST[0][('hidden')]) && Aspis_isset( $_POST [0][('hidden')]))) ? $_POST[0]['hidden'] : array('',false);
$hidden = Aspis_explode(array(',',false),$_POST[0]['hidden']);
$page = ((isset($_POST[0][('page')]) && Aspis_isset( $_POST [0][('page')]))) ? $_POST[0]['page'] : array('',false);
if ( (denot_boolean(Aspis_preg_match(array('/^[a-z_-]+$/',false),$page))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean($user = wp_get_current_user())))
 Aspis_exit(array('-1',false));
if ( is_array($hidden[0]))
 update_usermeta($user[0]->ID,concat2(concat1("manage-",$page),"-columns-hidden"),$hidden);
Aspis_exit(array('1',false));
break ;
case ('meta-box-order'):check_ajax_referer(array('meta-box-order',false));
$order = ((isset($_POST[0][('order')]) && Aspis_isset( $_POST [0][('order')]))) ? array_cast($_POST[0]['order']) : array(false,false);
$page_columns = ((isset($_POST[0][('page_columns')]) && Aspis_isset( $_POST [0][('page_columns')]))) ? int_cast($_POST[0]['page_columns']) : array(0,false);
$page = ((isset($_POST[0][('page')]) && Aspis_isset( $_POST [0][('page')]))) ? $_POST[0]['page'] : array('',false);
if ( (denot_boolean(Aspis_preg_match(array('/^[a-z_-]+$/',false),$page))))
 Aspis_exit(array('-1',false));
if ( (denot_boolean($user = wp_get_current_user())))
 Aspis_exit(array('-1',false));
if ( $order[0])
 update_user_option($user[0]->ID,concat1("meta-box-order_",$page),$order);
if ( $page_columns[0])
 update_usermeta($user[0]->ID,concat1("screen_layout_",$page),$page_columns);
Aspis_exit(array('1',false));
break ;
case ('get-permalink'):check_ajax_referer(array('getpermalink',false),array('getpermalinknonce',false));
$post_id = ((isset($_POST[0][('post_id')]) && Aspis_isset( $_POST [0][('post_id')]))) ? Aspis_intval($_POST[0]['post_id']) : array(0,false);
Aspis_exit(add_query_arg(array(array('preview' => array('true',false,false)),false),get_permalink($post_id)));
break ;
case ('sample-permalink'):check_ajax_referer(array('samplepermalink',false),array('samplepermalinknonce',false));
$post_id = ((isset($_POST[0][('post_id')]) && Aspis_isset( $_POST [0][('post_id')]))) ? Aspis_intval($_POST[0]['post_id']) : array(0,false);
$title = ((isset($_POST[0][('new_title')]) && Aspis_isset( $_POST [0][('new_title')]))) ? $_POST[0]['new_title'] : array('',false);
$slug = ((isset($_POST[0][('new_slug')]) && Aspis_isset( $_POST [0][('new_slug')]))) ? $_POST[0]['new_slug'] : array('',false);
Aspis_exit(get_sample_permalink_html($post_id,$title,$slug));
break ;
case ('inline-save'):check_ajax_referer(array('inlineeditnonce',false),array('_inline_edit',false));
if ( ((!((isset($_POST[0][('post_ID')]) && Aspis_isset( $_POST [0][('post_ID')])))) || (denot_boolean(($post_ID = int_cast($_POST[0]['post_ID']))))))
 Aspis_exit();
if ( (('page') == deAspis($_POST[0]['post_type'])))
 {if ( (denot_boolean(current_user_can(array('edit_page',false),$post_ID))))
 Aspis_exit(__(array('You are not allowed to edit this page.',false)));
}else 
{{if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 Aspis_exit(__(array('You are not allowed to edit this post.',false)));
}}if ( deAspis($last = wp_check_post_lock($post_ID)))
 {$last_user = get_userdata($last);
$last_user_name = $last_user[0] ? $last_user[0]->display_name : __(array('Someone',false));
printf(((deAspis($_POST[0]['post_type']) == ('page')) ? deAspis(__(array('Saving is disabled: %s is currently editing this page.',false))) : deAspis(__(array('Saving is disabled: %s is currently editing this post.',false)))),deAspisRC(esc_html($last_user_name)));
Aspis_exit();
}$data = &$_POST;
$post = get_post($post_ID,array(ARRAY_A,false));
$post = add_magic_quotes($post);
arrayAssign($data[0],deAspis(registerTaint(array('content',false))),addTaint($post[0]['post_content']));
arrayAssign($data[0],deAspis(registerTaint(array('excerpt',false))),addTaint($post[0]['post_excerpt']));
arrayAssign($data[0],deAspis(registerTaint(array('user_ID',false))),addTaint($GLOBALS[0]['user_ID']));
if ( ((isset($data[0][('post_parent')]) && Aspis_isset( $data [0][('post_parent')]))))
 arrayAssign($data[0],deAspis(registerTaint(array('parent_id',false))),addTaint($data[0]['post_parent']));
if ( (((isset($data[0][('keep_private')]) && Aspis_isset( $data [0][('keep_private')]))) && (('private') == deAspis($data[0]['keep_private']))))
 arrayAssign($data[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('private',false)));
else 
{arrayAssign($data[0],deAspis(registerTaint(array('post_status',false))),addTaint($data[0]['_status']));
}if ( ((empty($data[0][('comment_status')]) || Aspis_empty( $data [0][('comment_status')]))))
 arrayAssign($data[0],deAspis(registerTaint(array('comment_status',false))),addTaint(array('closed',false)));
if ( ((empty($data[0][('ping_status')]) || Aspis_empty( $data [0][('ping_status')]))))
 arrayAssign($data[0],deAspis(registerTaint(array('ping_status',false))),addTaint(array('closed',false)));
edit_post();
$post = array(array(),false);
if ( (('page') == deAspis($_POST[0]['post_type'])))
 {arrayAssignAdd($post[0][],addTaint(get_post($_POST[0]['post_ID'])));
page_rows($post);
}elseif ( (('post') == deAspis($_POST[0]['post_type'])))
 {$mode = $_POST[0]['post_view'];
arrayAssignAdd($post[0][],addTaint(get_post($_POST[0]['post_ID'])));
post_rows($post);
}Aspis_exit();
break ;
case ('inline-save-tax'):check_ajax_referer(array('taxinlineeditnonce',false),array('_inline_edit',false));
if ( (denot_boolean(current_user_can(array('manage_categories',false)))))
 Aspis_exit(__(array('Cheatin&#8217; uh?',false)));
if ( ((!((isset($_POST[0][('tax_ID')]) && Aspis_isset( $_POST [0][('tax_ID')])))) || (denot_boolean(($id = int_cast($_POST[0]['tax_ID']))))))
 Aspis_exit(negate(array(1,false)));
switch ( deAspis($_POST[0]['tax_type']) ) {
case ('cat'):$data = array(array(),false);
arrayAssign($data[0],deAspis(registerTaint(array('cat_ID',false))),addTaint($id));
arrayAssign($data[0],deAspis(registerTaint(array('cat_name',false))),addTaint($_POST[0]['name']));
arrayAssign($data[0],deAspis(registerTaint(array('category_nicename',false))),addTaint($_POST[0]['slug']));
if ( (((isset($_POST[0][('parent')]) && Aspis_isset( $_POST [0][('parent')]))) && (deAspis(int_cast($_POST[0]['parent'])) > (0))))
 arrayAssign($data[0],deAspis(registerTaint(array('category_parent',false))),addTaint($_POST[0]['parent']));
$cat = get_category($id,array(ARRAY_A,false));
arrayAssign($data[0],deAspis(registerTaint(array('category_description',false))),addTaint($cat[0]['category_description']));
$updated = wp_update_category($data);
if ( ($updated[0] && (denot_boolean(is_wp_error($updated)))))
 echo AspisCheckPrint(_cat_row($updated,array(0,false)));
else 
{Aspis_exit(__(array('Category not updated.',false)));
}break ;
case ('link-cat'):$updated = wp_update_term($id,array('link_category',false),$_POST);
if ( ($updated[0] && (denot_boolean(is_wp_error($updated)))))
 echo AspisCheckPrint(link_cat_row($updated[0]['term_id']));
else 
{Aspis_exit(__(array('Category not updated.',false)));
}break ;
case ('tag'):$taxonomy = (!((empty($_POST[0][('taxonomy')]) || Aspis_empty( $_POST [0][('taxonomy')])))) ? $_POST[0]['taxonomy'] : array('post_tag',false);
$tag = get_term($id,$taxonomy);
arrayAssign($_POST[0],deAspis(registerTaint(array('description',false))),addTaint($tag[0]->description));
$updated = wp_update_term($id,$taxonomy,$_POST);
if ( ($updated[0] && (denot_boolean(is_wp_error($updated)))))
 {$tag = get_term($updated[0]['term_id'],$taxonomy);
if ( ((denot_boolean($tag)) || deAspis(is_wp_error($tag))))
 Aspis_exit(__(array('Tag not updated.',false)));
echo AspisCheckPrint(_tag_row($tag,array('',false),$taxonomy));
}else 
{{Aspis_exit(__(array('Tag not updated.',false)));
}}break ;
 }
Aspis_exit();
break ;
case ('find_posts'):check_ajax_referer(array('find-posts',false));
if ( ((empty($_POST[0][('ps')]) || Aspis_empty( $_POST [0][('ps')]))))
 Aspis_exit();
$what = ((isset($_POST[0][('pages')]) && Aspis_isset( $_POST [0][('pages')]))) ? array('page',false) : array('post',false);
$s = Aspis_stripslashes($_POST[0]['ps']);
Aspis_preg_match_all(array('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/',false),$s,$matches);
$search_terms = attAspisRC(array_map(AspisInternalCallback(array('_search_terms_tidy',false)),deAspisRC(attachAspis($matches,(0)))));
$searchand = $search = array('',false);
foreach ( deAspis(array_cast($search_terms)) as $term  )
{$term = addslashes_gpc($term);
$search = concat($search,concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2($searchand,"(("),$wpdb[0]->posts),".post_title LIKE '%"),$term),"%') OR ("),$wpdb[0]->posts),".post_content LIKE '%"),$term),"%'))"));
$searchand = array(' AND ',false);
}$term = $wpdb[0]->escape($s);
if ( ((count($search_terms[0]) > (1)) && (deAspis(attachAspis($search_terms,(0))) != $s[0])))
 $search = concat($search,concat2(concat(concat2(concat(concat2(concat(concat2(concat1(" OR (",$wpdb[0]->posts),".post_title LIKE '%"),$term),"%') OR ("),$wpdb[0]->posts),".post_content LIKE '%"),$term),"%')"));
$posts = $wpdb[0]->get_results(concat2(concat(concat2(concat(concat2(concat1("SELECT ID, post_title, post_status, post_date FROM ",$wpdb[0]->posts)," WHERE post_type = '"),$what),"' AND post_status IN ('draft', 'publish') AND ("),$search),") ORDER BY post_date_gmt DESC LIMIT 50"));
if ( (denot_boolean($posts)))
 Aspis_exit(__(array('No posts found.',false)));
$html = concat2(concat(concat2(concat(concat2(concat1('<table class="widefat" cellspacing="0"><thead><tr><th class="found-radio"><br /></th><th>',__(array('Title',false))),'</th><th>'),__(array('Date',false))),'</th><th>'),__(array('Status',false))),'</th></tr></thead><tbody>');
foreach ( $posts[0] as $post  )
{switch ( $post[0]->post_status[0] ) {
case ('publish'):case ('private'):$stat = __(array('Published',false));
break ;
case ('future'):$stat = __(array('Scheduled',false));
break ;
case ('pending'):$stat = __(array('Pending Review',false));
break ;
case ('draft'):$stat = __(array('Draft',false));
break ;
 }
if ( (('0000-00-00 00:00:00') == $post[0]->post_date[0]))
 {$time = array('',false);
}else 
{{$time = mysql2date(__(array('Y/m/d',false)),$post[0]->post_date);
}}$html = concat($html,concat2(concat(concat2(concat1('<tr class="found-posts"><td class="found-radio"><input type="radio" id="found-',$post[0]->ID),'" name="found_post_id" value="'),esc_attr($post[0]->ID)),'"></td>'));
$html = concat($html,concat2(concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<td><label for="found-',$post[0]->ID),'">'),esc_html($post[0]->post_title)),'</label></td><td>'),esc_html($time)),'</td><td>'),esc_html($stat)),'</td></tr>'),"\n\n"));
}$html = concat2($html,'</tbody></table>');
$x = array(new WP_Ajax_Response(),false);
$x[0]->add(array(array(deregisterTaint(array('what',false)) => addTaint($what),deregisterTaint(array('data',false)) => addTaint($html)),false));
$x[0]->send();
break ;
case ('lj-importer'):check_ajax_referer(array('lj-api-import',false));
if ( (denot_boolean(current_user_can(array('publish_posts',false)))))
 Aspis_exit(array('-1',false));
if ( ((empty($_POST[0][('step')]) || Aspis_empty( $_POST [0][('step')]))))
 Aspis_exit(array('-1',false));
define(('WP_IMPORTING'),true);
include (deconcat12(ABSPATH,'wp-admin/import/livejournal.php'));
$result = $lj_api_import[0]->{(deconcat1('step',(int_cast($_POST[0]['step']))))}();
if ( deAspis(is_wp_error($result)))
 echo AspisCheckPrint($result[0]->get_error_message());
Aspis_exit();
break ;
case ('widgets-order'):check_ajax_referer(array('save-sidebar-widgets',false),array('savewidgets',false));
if ( (denot_boolean(current_user_can(array('switch_themes',false)))))
 Aspis_exit(array('-1',false));
unset($_POST[0][('savewidgets')],$_POST[0][('action')]);
if ( is_array(deAspis($_POST[0]['sidebars'])))
 {$sidebars = array(array(),false);
foreach ( deAspis($_POST[0]['sidebars']) as $key =>$val )
{restoreTaint($key,$val);
{$sb = array(array(),false);
if ( (!((empty($val) || Aspis_empty( $val)))))
 {$val = Aspis_explode(array(',',false),$val);
foreach ( $val[0] as $k =>$v )
{restoreTaint($k,$v);
{if ( (strpos($v[0],'widget-') === false))
 continue ;
arrayAssign($sb[0],deAspis(registerTaint($k)),addTaint(Aspis_substr($v,array(strpos($v[0],'_') + (1),false))));
}}}arrayAssign($sidebars[0],deAspis(registerTaint($key)),addTaint($sb));
}}wp_set_sidebars_widgets($sidebars);
Aspis_exit(array('1',false));
}Aspis_exit(array('-1',false));
break ;
case ('save-widget'):check_ajax_referer(array('save-sidebar-widgets',false),array('savewidgets',false));
if ( ((denot_boolean(current_user_can(array('switch_themes',false)))) || (!((isset($_POST[0][('id_base')]) && Aspis_isset( $_POST [0][('id_base')]))))))
 Aspis_exit(array('-1',false));
unset($_POST[0][('savewidgets')],$_POST[0][('action')]);
do_action(array('load-widgets.php',false));
do_action(array('widgets.php',false));
do_action(array('sidebar_admin_setup',false));
$id_base = $_POST[0]['id_base'];
$widget_id = $_POST[0]['widget-id'];
$sidebar_id = $_POST[0]['sidebar'];
$multi_number = (!((empty($_POST[0][('multi_number')]) || Aspis_empty( $_POST [0][('multi_number')])))) ? int_cast($_POST[0]['multi_number']) : array(0,false);
$settings = (((isset($_POST[0][(deconcat1('widget-',$id_base))]) && Aspis_isset( $_POST [0][(deconcat1('widget-',$id_base))]))) && is_array(deAspis(attachAspis($_POST,(deconcat1('widget-',$id_base)))))) ? attachAspis($_POST,(deconcat1('widget-',$id_base))) : array(false,false);
$error = concat2(concat1('<p>',__(array('An error has occured. Please reload the page and try again.',false))),'</p>');
$sidebars = wp_get_sidebars_widgets();
$sidebar = ((isset($sidebars[0][$sidebar_id[0]]) && Aspis_isset( $sidebars [0][$sidebar_id[0]]))) ? attachAspis($sidebars,$sidebar_id[0]) : array(array(),false);
if ( (((isset($_POST[0][('delete_widget')]) && Aspis_isset( $_POST [0][('delete_widget')]))) && deAspis($_POST[0]['delete_widget'])))
 {if ( (!((isset($wp_registered_widgets[0][$widget_id[0]]) && Aspis_isset( $wp_registered_widgets [0][$widget_id[0]])))))
 Aspis_exit($error);
$sidebar = Aspis_array_diff($sidebar,array(array($widget_id),false));
$_POST = array(array(deregisterTaint(array('sidebar',false)) => addTaint($sidebar_id),deregisterTaint(concat1('widget-',$id_base)) => addTaint(array(array(),false)),deregisterTaint(array('the-widget-id',false)) => addTaint($widget_id),'delete_widget' => array('1',false,false)),false);
}elseif ( ($settings[0] && deAspis(Aspis_preg_match(array('/__i__|%i%/',false),Aspis_key($settings)))))
 {if ( (denot_boolean($multi_number)))
 Aspis_exit($error);
arrayAssign($_POST[0],deAspis(registerTaint(concat1('widget-',$id_base))),addTaint(array(array(deregisterTaint($multi_number) => addTaint(Aspis_array_shift($settings))),false)));
$widget_id = concat(concat2($id_base,'-'),$multi_number);
arrayAssignAdd($sidebar[0][],addTaint($widget_id));
}arrayAssign($_POST[0],deAspis(registerTaint(array('widget-id',false))),addTaint($sidebar));
foreach ( deAspis(array_cast($wp_registered_widget_updates)) as $name =>$control )
{restoreTaint($name,$control);
{if ( ($name[0] == $id_base[0]))
 {if ( (!(is_callable(deAspisRC($control[0]['callback'])))))
 continue ;
ob_start();
Aspis_call_user_func_array($control[0]['callback'],$control[0]['params']);
ob_end_clean();
break ;
}}}if ( (((isset($_POST[0][('delete_widget')]) && Aspis_isset( $_POST [0][('delete_widget')]))) && deAspis($_POST[0]['delete_widget'])))
 {arrayAssign($sidebars[0],deAspis(registerTaint($sidebar_id)),addTaint($sidebar));
wp_set_sidebars_widgets($sidebars);
echo AspisCheckPrint(concat1("deleted:",$widget_id));
Aspis_exit();
}if ( (!((empty($_POST[0][('add_new')]) || Aspis_empty( $_POST [0][('add_new')])))))
 Aspis_exit();
if ( deAspis($form = attachAspis($wp_registered_widget_controls,$widget_id[0])))
 Aspis_call_user_func_array($form[0]['callback'],$form[0]['params']);
Aspis_exit();
break ;
case ('image-editor'):$attachment_id = Aspis_intval($_POST[0]['postid']);
if ( (((empty($attachment_id) || Aspis_empty( $attachment_id))) || (denot_boolean(current_user_can(array('edit_post',false),$attachment_id)))))
 Aspis_exit(array('-1',false));
check_ajax_referer(concat1("image_editor-",$attachment_id));
include_once (deconcat12(ABSPATH,'wp-admin/includes/image-edit.php'));
$msg = array(false,false);
switch ( deAspis($_POST[0]['do']) ) {
case ('save'):$msg = wp_save_image($attachment_id);
$msg = array(json_encode(deAspisRC($msg)),false);
Aspis_exit($msg);
break ;
case ('scale'):$msg = wp_save_image($attachment_id);
break ;
case ('restore'):$msg = wp_restore_image($attachment_id);
break ;
 }
wp_image_editor($attachment_id,$msg);
Aspis_exit();
break ;
case ('set-post-thumbnail'):$post_id = Aspis_intval($_POST[0]['post_id']);
if ( (denot_boolean(current_user_can(array('edit_post',false),$post_id))))
 Aspis_exit(array('-1',false));
$thumbnail_id = Aspis_intval($_POST[0]['thumbnail_id']);
if ( ($thumbnail_id[0] == ('-1')))
 {delete_post_meta($post_id,array('_thumbnail_id',false));
Aspis_exit(_wp_post_thumbnail_html());
}if ( ($thumbnail_id[0] && deAspis(get_post($thumbnail_id))))
 {$thumbnail_html = wp_get_attachment_image($thumbnail_id,array('thumbnail',false));
if ( (!((empty($thumbnail_html) || Aspis_empty( $thumbnail_html)))))
 {update_post_meta($post_id,array('_thumbnail_id',false),$thumbnail_id);
Aspis_exit(_wp_post_thumbnail_html($thumbnail_id));
}}Aspis_exit(array('0',false));
default :do_action(concat1('wp_ajax_',$_POST[0]['action']));
Aspis_exit(array('0',false));
break ;
 }
;
?>
<?php 