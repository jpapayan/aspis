<?php require_once('AspisMain.php'); ?><?php
define('DOING_AJAX',true);
define('WP_ADMIN',true);
require_once ('../wp-load.php');
require_once ('includes/admin.php');
@header('Content-Type: text/html; charset=' . get_option('blog_charset'));
do_action('admin_init');
if ( !is_user_logged_in())
 {if ( deAspisWarningRC($_POST[0]['action']) == 'autosave')
 {$id = (isset($_POST[0]['post_ID']) && Aspis_isset($_POST[0]['post_ID'])) ? (int)deAspisWarningRC($_POST[0]['post_ID']) : 0;
if ( !$id)
 exit('-1');
$message = sprintf(__('<strong>ALERT: You are logged out!</strong> Could not save draft. <a href="%s" target="blank">Please log in again.</a>'),wp_login_url());
$x = new WP_Ajax_Response(array('what' => 'autosave','id' => $id,'data' => $message));
$x->send();
}if ( !(empty($_REQUEST[0]['action']) || Aspis_empty($_REQUEST[0]['action'])))
 do_action('wp_ajax_nopriv_' . deAspisWarningRC($_REQUEST[0]['action']));
exit('-1');
}if ( (isset($_GET[0]['action']) && Aspis_isset($_GET[0]['action'])))
 {switch ( $action = deAspisWarningRC($_GET[0]['action']) ) {
case 'ajax-tag-search':if ( !current_user_can('edit_posts'))
 exit('-1');
$s = deAspisWarningRC($_GET[0]['q']);
if ( (isset($_GET[0]['tax']) && Aspis_isset($_GET[0]['tax'])))
 $taxonomy = sanitize_title(deAspisWarningRC($_GET[0]['tax']));
else 
{exit('0');
}if ( false !== strpos($s,','))
 {$s = explode(',',$s);
$s = $s[count($s) - 1];
}$s = trim($s);
if ( strlen($s) < 2)
 exit();
$results = $wpdb->get_col("SELECT t.name FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = '$taxonomy' AND t.name LIKE ('%" . $s . "%')");
echo join($results,"\n");
exit();
break ;
;
case 'wp-compression-test':if ( !current_user_can('manage_options'))
 exit('-1');
if ( ini_get('zlib.output_compression') || 'ob_gzhandler' == ini_get('output_handler'))
 {update_site_option('can_compress_scripts',0);
exit('0');
}if ( (isset($_GET[0]['test']) && Aspis_isset($_GET[0]['test'])))
 {header('Expires: Wed, 11 Jan 1984 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Content-Type: application/x-javascript; charset=UTF-8');
$force_gzip = (defined('ENFORCE_GZIP') && ENFORCE_GZIP);
$test_str = '"wpCompressionTest Lorem ipsum dolor sit amet consectetuer mollis sapien urna ut a. Eu nonummy condimentum fringilla tempor pretium platea vel nibh netus Maecenas. Hac molestie amet justo quis pellentesque est ultrices interdum nibh Morbi. Cras mattis pretium Phasellus ante ipsum ipsum ut sociis Suspendisse Lorem. Ante et non molestie. Porta urna Vestibulum egestas id congue nibh eu risus gravida sit. Ac augue auctor Ut et non a elit massa id sodales. Elit eu Nulla at nibh adipiscing mattis lacus mauris at tempus. Netus nibh quis suscipit nec feugiat eget sed lorem et urna. Pellentesque lacus at ut massa consectetuer ligula ut auctor semper Pellentesque. Ut metus massa nibh quam Curabitur molestie nec mauris congue. Volutpat molestie elit justo facilisis neque ac risus Ut nascetur tristique. Vitae sit lorem tellus et quis Phasellus lacus tincidunt nunc Fusce. Pharetra wisi Suspendisse mus sagittis libero lacinia Integer consequat ac Phasellus. Et urna ac cursus tortor aliquam Aliquam amet tellus volutpat Vestibulum. Justo interdum condimentum In augue congue tellus sollicitudin Quisque quis nibh."';
if ( 1 == deAspisWarningRC($_GET[0]['test']))
 {echo $test_str;
exit();
}elseif ( 2 == deAspisWarningRC($_GET[0]['test']))
 {if ( !(isset($_SERVER[0]['HTTP_ACCEPT_ENCODING']) && Aspis_isset($_SERVER[0]['HTTP_ACCEPT_ENCODING'])))
 exit('-1');
if ( false !== strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'deflate') && function_exists('gzdeflate') && !$force_gzip)
 {header('Content-Encoding: deflate');
$out = gzdeflate($test_str,1);
}elseif ( false !== strpos(strtolower(deAspisWarningRC($_SERVER[0]['HTTP_ACCEPT_ENCODING'])),'gzip') && function_exists('gzencode'))
 {header('Content-Encoding: gzip');
$out = gzencode($test_str,1);
}else 
{{exit('-1');
}}echo $out;
exit();
}elseif ( 'no' == deAspisWarningRC($_GET[0]['test']))
 {update_site_option('can_compress_scripts',0);
}elseif ( 'yes' == deAspisWarningRC($_GET[0]['test']))
 {update_site_option('can_compress_scripts',1);
}}exit('0');
break ;
case 'imgedit-preview':$post_id = intval(deAspisWarningRC($_GET[0]['postid']));
if ( empty($post_id) || !current_user_can('edit_post',$post_id))
 exit('-1');
check_ajax_referer("image_editor-$post_id");
include_once (ABSPATH . 'wp-admin/includes/image-edit.php');
if ( !stream_preview_image($post_id))
 exit('-1');
exit();
break ;
case 'oembed-cache':$return = ($wp_embed->cache_oembed(deAspisWarningRC($_GET[0]['post']))) ? '1' : '0';
exit($return);
break ;
default :do_action('wp_ajax_' . deAspisWarningRC($_GET[0]['action']));
exit('0');
break ;
 }
}function _wp_ajax_delete_comment_response ( $comment_id ) {
$total = (int)@deAspisWarningRC($_POST[0]['_total']);
$per_page = (int)@deAspisWarningRC($_POST[0]['_per_page']);
$page = (int)@deAspisWarningRC($_POST[0]['_page']);
$url = esc_url_raw(@deAspisWarningRC($_POST[0]['_url']));
if ( !$total || !$per_page || !$page || !$url)
 exit((string)time());
if ( --$total < 0)
 $total = 0;
if ( 0 != $total % $per_page && 1 != mt_rand(1,$per_page))
 exit((string)time());
$post_id = 0;
$status = 'total_comments';
$parsed = parse_url($url);
if ( isset($parsed['query']))
 {parse_str($parsed['query'],$query_vars);
if ( !empty($query_vars['comment_status']))
 $status = $query_vars['comment_status'];
if ( !empty($query_vars['p']))
 $post_id = (int)$query_vars['p'];
}$comment_count = wp_count_comments($post_id);
$time = time();
if ( isset($comment_count->$status))
 $total = $comment_count->$status;
$page_links = paginate_links(array('base' => add_query_arg('apage','%#%',$url),'format' => '','prev_text' => __('&laquo;'),'next_text' => __('&raquo;'),'total' => ceil($total / $per_page),'current' => $page));
$x = new WP_Ajax_Response(array('what' => 'comment','id' => $comment_id,'supplemental' => array('pageLinks' => $page_links,'total' => $total,'time' => $time)));
$x->send();
 }
$id = (isset($_POST[0]['id']) && Aspis_isset($_POST[0]['id'])) ? (int)deAspisWarningRC($_POST[0]['id']) : 0;
switch ( $action = deAspisWarningRC($_POST[0]['action']) ) {
case 'delete-comment':if ( !$comment = get_comment($id))
 exit((string)time());
if ( !current_user_can('edit_post',$comment->comment_post_ID))
 exit('-1');
check_ajax_referer("delete-comment_$id");
$status = wp_get_comment_status($comment->comment_ID);
if ( (isset($_POST[0]['trash']) && Aspis_isset($_POST[0]['trash'])) && 1 == deAspisWarningRC($_POST[0]['trash']))
 {if ( 'trash' == $status)
 exit((string)time());
$r = wp_trash_comment($comment->comment_ID);
}elseif ( (isset($_POST[0]['untrash']) && Aspis_isset($_POST[0]['untrash'])) && 1 == deAspisWarningRC($_POST[0]['untrash']))
 {if ( 'trash' != $status)
 exit((string)time());
$r = wp_untrash_comment($comment->comment_ID);
}elseif ( (isset($_POST[0]['spam']) && Aspis_isset($_POST[0]['spam'])) && 1 == deAspisWarningRC($_POST[0]['spam']))
 {if ( 'spam' == $status)
 exit((string)time());
$r = wp_spam_comment($comment->comment_ID);
}elseif ( (isset($_POST[0]['unspam']) && Aspis_isset($_POST[0]['unspam'])) && 1 == deAspisWarningRC($_POST[0]['unspam']))
 {if ( 'spam' != $status)
 exit((string)time());
$r = wp_unspam_comment($comment->comment_ID);
}elseif ( (isset($_POST[0]['delete']) && Aspis_isset($_POST[0]['delete'])) && 1 == deAspisWarningRC($_POST[0]['delete']))
 {$r = wp_delete_comment($comment->comment_ID);
}else 
{{exit('-1');
}}if ( $r)
 _wp_ajax_delete_comment_response($comment->comment_ID);
exit('0');
break ;
;
case 'delete-cat':check_ajax_referer("delete-category_$id");
if ( !current_user_can('manage_categories'))
 exit('-1');
$cat = get_category($id);
if ( !$cat || is_wp_error($cat))
 exit('1');
if ( wp_delete_category($id))
 exit('1');
else 
{exit('0');
}break ;
case 'delete-tag':$tag_id = (int)deAspisWarningRC($_POST[0]['tag_ID']);
check_ajax_referer("delete-tag_$tag_id");
if ( !current_user_can('manage_categories'))
 exit('-1');
$taxonomy = !(empty($_POST[0]['taxonomy']) || Aspis_empty($_POST[0]['taxonomy'])) ? deAspisWarningRC($_POST[0]['taxonomy']) : 'post_tag';
$tag = get_term($tag_id,$taxonomy);
if ( !$tag || is_wp_error($tag))
 exit('1');
if ( wp_delete_term($tag_id,$taxonomy))
 exit('1');
else 
{exit('0');
}break ;
case 'delete-link-cat':check_ajax_referer("delete-link-category_$id");
if ( !current_user_can('manage_categories'))
 exit('-1');
$cat = get_term($id,'link_category');
if ( !$cat || is_wp_error($cat))
 exit('1');
$cat_name = get_term_field('name',$id,'link_category');
$default = get_option('default_link_category');
if ( $id == $default)
 {$x = new WP_AJAX_Response(array('what' => 'link-cat','id' => $id,'data' => new WP_Error('default-link-cat',sprintf(__("Can&#8217;t delete the <strong>%s</strong> category: this is the default one"),$cat_name))));
$x->send();
}$r = wp_delete_term($id,'link_category',array('default' => $default));
if ( !$r)
 exit('0');
if ( is_wp_error($r))
 {$x = new WP_AJAX_Response(array('what' => 'link-cat','id' => $id,'data' => $r));
$x->send();
}exit('1');
break ;
case 'delete-link':check_ajax_referer("delete-bookmark_$id");
if ( !current_user_can('manage_links'))
 exit('-1');
$link = get_bookmark($id);
if ( !$link || is_wp_error($link))
 exit('1');
if ( wp_delete_link($id))
 exit('1');
else 
{exit('0');
}break ;
case 'delete-meta':check_ajax_referer("delete-meta_$id");
if ( !$meta = get_post_meta_by_id($id))
 exit('1');
if ( !current_user_can('edit_post',$meta->post_id))
 exit('-1');
if ( delete_meta($meta->meta_id))
 exit('1');
exit('0');
break ;
case 'delete-post':check_ajax_referer("{$action}_$id");
if ( !current_user_can('delete_post',$id))
 exit('-1');
if ( !get_post($id))
 exit('1');
if ( wp_delete_post($id))
 exit('1');
else 
{exit('0');
}break ;
case 'trash-post':case 'untrash-post':check_ajax_referer("{$action}_$id");
if ( !current_user_can('delete_post',$id))
 exit('-1');
if ( !get_post($id))
 exit('1');
if ( 'trash-post' == $action)
 $done = wp_trash_post($id);
else 
{$done = wp_untrash_post($id);
}if ( $done)
 exit('1');
exit('0');
break ;
case 'delete-page':check_ajax_referer("{$action}_$id");
if ( !current_user_can('delete_page',$id))
 exit('-1');
if ( !get_page($id))
 exit('1');
if ( wp_delete_post($id))
 exit('1');
else 
{exit('0');
}break ;
case 'dim-comment':if ( !$comment = get_comment($id))
 {$x = new WP_Ajax_Response(array('what' => 'comment','id' => new WP_Error('invalid_comment',sprintf(__('Comment %d does not exist'),$id))));
$x->send();
}if ( !current_user_can('edit_post',$comment->comment_post_ID) && !current_user_can('moderate_comments'))
 exit('-1');
$current = wp_get_comment_status($comment->comment_ID);
if ( deAspisWarningRC($_POST[0]['new']) == $current)
 exit((string)time());
check_ajax_referer("approve-comment_$id");
if ( in_array($current,array('unapproved','spam')))
 $result = wp_set_comment_status($comment->comment_ID,'approve',true);
else 
{$result = wp_set_comment_status($comment->comment_ID,'hold',true);
}if ( is_wp_error($result))
 {$x = new WP_Ajax_Response(array('what' => 'comment','id' => $result));
$x->send();
}_wp_ajax_delete_comment_response($comment->comment_ID);
exit('0');
break ;
case 'add-category':check_ajax_referer($action);
if ( !current_user_can('manage_categories'))
 exit('-1');
$names = explode(',',deAspisWarningRC($_POST[0]['newcat']));
if ( 0 > $parent = (int)deAspisWarningRC($_POST[0]['newcat_parent']))
 $parent = 0;
$post_category = (isset($_POST[0]['post_category']) && Aspis_isset($_POST[0]['post_category'])) ? (array)deAspisWarningRC($_POST[0]['post_category']) : array();
$checked_categories = array_map('absint',(array)$post_category);
$popular_ids = wp_popular_terms_checklist('category',0,10,false);
foreach ( $names as $cat_name  )
{$cat_name = trim($cat_name);
$category_nicename = sanitize_title($cat_name);
if ( '' === $category_nicename)
 continue ;
$cat_id = wp_create_category($cat_name,$parent);
$checked_categories[] = $cat_id;
if ( $parent)
 continue ;
$category = get_category($cat_id);
ob_start();
wp_category_checklist(0,$cat_id,$checked_categories,$popular_ids);
$data = ob_get_contents();
ob_end_clean();
$add = array('what' => 'category','id' => $cat_id,'data' => str_replace(array("\n","\t"),'',$data),'position' => -1);
}if ( $parent)
 {$parent = get_category($parent);
$term_id = $parent->term_id;
while ( $parent->parent )
{$parent = &get_category($parent->parent);
if ( is_wp_error($parent))
 break ;
$term_id = $parent->term_id;
}ob_start();
wp_category_checklist(0,$term_id,$checked_categories,$popular_ids,null,false);
$data = ob_get_contents();
ob_end_clean();
$add = array('what' => 'category','id' => $term_id,'data' => str_replace(array("\n","\t"),'',$data),'position' => -1);
}ob_start();
wp_dropdown_categories(array('hide_empty' => 0,'name' => 'newcat_parent','orderby' => 'name','hierarchical' => 1,'show_option_none' => __('Parent category')));
$sup = ob_get_contents();
ob_end_clean();
$add['supplemental'] = array('newcat_parent' => $sup);
$x = new WP_Ajax_Response($add);
$x->send();
break ;
case 'add-link-category':check_ajax_referer($action);
if ( !current_user_can('manage_categories'))
 exit('-1');
$names = explode(',',deAspisWarningRC($_POST[0]['newcat']));
$x = new WP_Ajax_Response();
foreach ( $names as $cat_name  )
{$cat_name = trim($cat_name);
$slug = sanitize_title($cat_name);
if ( '' === $slug)
 continue ;
if ( !$cat_id = is_term($cat_name,'link_category'))
 {$cat_id = wp_insert_term($cat_name,'link_category');
}$cat_id = $cat_id['term_id'];
$cat_name = esc_html(stripslashes($cat_name));
$x->add(array('what' => 'link-category','id' => $cat_id,'data' => "<li id='link-category-$cat_id'><label for='in-link-category-$cat_id' class='selectit'><input value='" . esc_attr($cat_id) . "' type='checkbox' checked='checked' name='link_category[]' id='in-link-category-$cat_id'/> $cat_name</label></li>",'position' => -1));
}$x->send();
break ;
case 'add-cat':check_ajax_referer('add-category');
if ( !current_user_can('manage_categories'))
 exit('-1');
if ( '' === trim(deAspisWarningRC($_POST[0]['cat_name'])))
 {$x = new WP_Ajax_Response(array('what' => 'cat','id' => new WP_Error('cat_name',__('You did not enter a category name.'))));
$x->send();
}if ( category_exists(trim(deAspisWarningRC($_POST[0]['cat_name'])),deAspisWarningRC($_POST[0]['category_parent'])))
 {$x = new WP_Ajax_Response(array('what' => 'cat','id' => new WP_Error('cat_exists',__('The category you are trying to create already exists.'),array('form-field' => 'cat_name')),));
$x->send();
}$cat = wp_insert_category(deAspisWarningRC($_POST),true);
if ( is_wp_error($cat))
 {$x = new WP_Ajax_Response(array('what' => 'cat','id' => $cat));
$x->send();
}if ( !$cat || (!$cat = get_category($cat)))
 exit('0');
$level = 0;
$cat_full_name = $cat->name;
$_cat = $cat;
while ( $_cat->parent )
{$_cat = get_category($_cat->parent);
$cat_full_name = $_cat->name . ' &#8212; ' . $cat_full_name;
$level++;
}$cat_full_name = esc_attr($cat_full_name);
$x = new WP_Ajax_Response(array('what' => 'cat','id' => $cat->term_id,'position' => -1,'data' => _cat_row($cat,$level,$cat_full_name),'supplemental' => array('name' => $cat_full_name,'show-link' => sprintf(__('Category <a href="#%s">%s</a> added'),"cat-$cat->term_id",$cat_full_name))));
$x->send();
break ;
case 'add-link-cat':check_ajax_referer('add-link-category');
if ( !current_user_can('manage_categories'))
 exit('-1');
if ( '' === trim(deAspisWarningRC($_POST[0]['name'])))
 {$x = new WP_Ajax_Response(array('what' => 'link-cat','id' => new WP_Error('name',__('You did not enter a category name.'))));
$x->send();
}$r = wp_insert_term(deAspisWarningRC($_POST[0]['name']),'link_category',deAspisWarningRC($_POST));
if ( is_wp_error($r))
 {$x = new WP_AJAX_Response(array('what' => 'link-cat','id' => $r));
$x->send();
}extract(($r),EXTR_SKIP);
if ( !$link_cat = link_cat_row($term_id))
 exit('0');
$x = new WP_Ajax_Response(array('what' => 'link-cat','id' => $term_id,'position' => -1,'data' => $link_cat));
$x->send();
break ;
case 'add-tag':check_ajax_referer('add-tag');
if ( !current_user_can('manage_categories'))
 exit('-1');
$taxonomy = !(empty($_POST[0]['taxonomy']) || Aspis_empty($_POST[0]['taxonomy'])) ? deAspisWarningRC($_POST[0]['taxonomy']) : 'post_tag';
$tag = wp_insert_term(deAspisWarningRC($_POST[0]['tag-name']),$taxonomy,deAspisWarningRC($_POST));
if ( !$tag || is_wp_error($tag) || (!$tag = get_term($tag['term_id'],$taxonomy)))
 {echo '<div class="error"><p>' . __('An error has occured. Please reload the page and try again.') . '</p></div>';
exit();
}echo _tag_row($tag,'',$taxonomy);
exit();
break ;
case 'get-tagcloud':if ( !current_user_can('edit_posts'))
 exit('-1');
if ( (isset($_POST[0]['tax']) && Aspis_isset($_POST[0]['tax'])))
 $taxonomy = sanitize_title(deAspisWarningRC($_POST[0]['tax']));
else 
{exit('0');
}$tags = get_terms($taxonomy,array('number' => 45,'orderby' => 'count','order' => 'DESC'));
if ( empty($tags))
 exit(__('No tags found!'));
if ( is_wp_error($tags))
 exit($tags->get_error_message());
foreach ( $tags as $key =>$tag )
{$tags[$key]->link = '#';
$tags[$key]->id = $tag->term_id;
}$return = wp_generate_tag_cloud($tags,array('filter' => 0));
if ( empty($return))
 exit('0');
echo $return;
exit();
break ;
case 'add-comment':check_ajax_referer($action);
if ( !current_user_can('edit_posts'))
 exit('-1');
$search = (isset($_POST[0]['s']) && Aspis_isset($_POST[0]['s'])) ? deAspisWarningRC($_POST[0]['s']) : false;
$status = (isset($_POST[0]['comment_status']) && Aspis_isset($_POST[0]['comment_status'])) ? deAspisWarningRC($_POST[0]['comment_status']) : 'all';
$per_page = (isset($_POST[0]['per_page']) && Aspis_isset($_POST[0]['per_page'])) ? (int)deAspisWarningRC($_POST[0]['per_page']) + 8 : 28;
$start = (isset($_POST[0]['page']) && Aspis_isset($_POST[0]['page'])) ? (intval(deAspisWarningRC($_POST[0]['page'])) * $per_page) - 1 : $per_page - 1;
if ( 1 > $start)
 $start = 27;
$mode = (isset($_POST[0]['mode']) && Aspis_isset($_POST[0]['mode'])) ? deAspisWarningRC($_POST[0]['mode']) : 'detail';
$p = (isset($_POST[0]['p']) && Aspis_isset($_POST[0]['p'])) ? deAspisWarningRC($_POST[0]['p']) : 0;
$comment_type = (isset($_POST[0]['comment_type']) && Aspis_isset($_POST[0]['comment_type'])) ? deAspisWarningRC($_POST[0]['comment_type']) : '';
list($comments,$total) = _wp_get_comment_list($status,$search,$start,1,$p,$comment_type);
if ( get_option('show_avatars'))
 add_filter('comment_author','floated_admin_avatar');
if ( !$comments)
 exit('1');
$x = new WP_Ajax_Response();
foreach ( (array)$comments as $comment  )
{get_comment($comment);
ob_start();
_wp_comment_row($comment->comment_ID,$mode,$status,true,true);
$comment_list_item = ob_get_contents();
ob_end_clean();
$x->add(array('what' => 'comment','id' => $comment->comment_ID,'data' => $comment_list_item));
}$x->send();
break ;
case 'get-comments':check_ajax_referer($action);
$post_ID = (int)deAspisWarningRC($_POST[0]['post_ID']);
if ( !current_user_can('edit_post',$post_ID))
 exit('-1');
$start = (isset($_POST[0]['start']) && Aspis_isset($_POST[0]['start'])) ? intval(deAspisWarningRC($_POST[0]['start'])) : 0;
$num = (isset($_POST[0]['num']) && Aspis_isset($_POST[0]['num'])) ? intval(deAspisWarningRC($_POST[0]['num'])) : 10;
list($comments,$total) = _wp_get_comment_list(false,false,$start,$num,$post_ID);
if ( !$comments)
 exit('1');
$comment_list_item = '';
$x = new WP_Ajax_Response();
foreach ( (array)$comments as $comment  )
{get_comment($comment);
ob_start();
_wp_comment_row($comment->comment_ID,'single',false,false);
$comment_list_item .= ob_get_contents();
ob_end_clean();
}$x->add(array('what' => 'comments','data' => $comment_list_item));
$x->send();
break ;
case 'replyto-comment':check_ajax_referer($action);
$comment_post_ID = (int)deAspisWarningRC($_POST[0]['comment_post_ID']);
if ( !current_user_can('edit_post',$comment_post_ID))
 exit('-1');
$status = $wpdb->get_var($wpdb->prepare("SELECT post_status FROM $wpdb->posts WHERE ID = %d",$comment_post_ID));
if ( empty($status))
 exit('1');
elseif ( in_array($status,array('draft','pending','trash')))
 exit(__('Error: you are replying to a comment on a draft post.'));
$user = wp_get_current_user();
if ( $user->ID)
 {$comment_author = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->display_name)),array(0));
$comment_author_email = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_email)),array(0));
$comment_author_url = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($user->user_url)),array(0));
$comment_content = trim(deAspisWarningRC($_POST[0]['content']));
if ( current_user_can('unfiltered_html'))
 {if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != deAspisWarningRC($_POST[0]['_wp_unfiltered_html_comment']))
 {kses_remove_filters();
kses_init_filters();
}}}else 
{{exit(__('Sorry, you must be logged in to reply to a comment.'));
}}if ( '' == $comment_content)
 exit(__('Error: please type a comment.'));
$comment_parent = absint(deAspisWarningRC($_POST[0]['comment_ID']));
$commentdata = compact('comment_post_ID','comment_author','comment_author_email','comment_author_url','comment_content','comment_type','comment_parent','user_ID');
$comment_id = wp_new_comment($commentdata);
$comment = get_comment($comment_id);
if ( !$comment)
 exit('1');
$modes = array('single','detail','dashboard');
$mode = (isset($_POST[0]['mode']) && Aspis_isset($_POST[0]['mode'])) && in_array(deAspisWarningRC($_POST[0]['mode']),$modes) ? deAspisWarningRC($_POST[0]['mode']) : 'detail';
$position = ((isset($_POST[0]['position']) && Aspis_isset($_POST[0]['position'])) && (int)deAspisWarningRC($_POST[0]['position'])) ? (int)deAspisWarningRC($_POST[0]['position']) : '-1';
$checkbox = ((isset($_POST[0]['checkbox']) && Aspis_isset($_POST[0]['checkbox'])) && true == deAspisWarningRC($_POST[0]['checkbox'])) ? 1 : 0;
if ( get_option('show_avatars') && 'single' != $mode)
 add_filter('comment_author','floated_admin_avatar');
$x = new WP_Ajax_Response();
ob_start();
if ( 'dashboard' == $mode)
 {require_once (ABSPATH . 'wp-admin/includes/dashboard.php');
_wp_dashboard_recent_comments_row($comment,false);
}else 
{{_wp_comment_row($comment->comment_ID,$mode,false,$checkbox);
}}$comment_list_item = ob_get_contents();
ob_end_clean();
$x->add(array('what' => 'comment','id' => $comment->comment_ID,'data' => $comment_list_item,'position' => $position));
$x->send();
break ;
case 'edit-comment':check_ajax_referer('replyto-comment');
$comment_post_ID = (int)deAspisWarningRC($_POST[0]['comment_post_ID']);
if ( !current_user_can('edit_post',$comment_post_ID))
 exit('-1');
if ( '' == deAspisWarningRC($_POST[0]['content']))
 exit(__('Error: please type a comment.'));
$comment_id = (int)deAspisWarningRC($_POST[0]['comment_ID']);
$_POST[0]['comment_status'] = attAspisRCO(deAspisWarningRC($_POST[0]['status']));
edit_comment();
$mode = ((isset($_POST[0]['mode']) && Aspis_isset($_POST[0]['mode'])) && 'single' == deAspisWarningRC($_POST[0]['mode'])) ? 'single' : 'detail';
$position = ((isset($_POST[0]['position']) && Aspis_isset($_POST[0]['position'])) && (int)deAspisWarningRC($_POST[0]['position'])) ? (int)deAspisWarningRC($_POST[0]['position']) : '-1';
$checkbox = ((isset($_POST[0]['checkbox']) && Aspis_isset($_POST[0]['checkbox'])) && true == deAspisWarningRC($_POST[0]['checkbox'])) ? 1 : 0;
$comments_listing = (isset($_POST[0]['comments_listing']) && Aspis_isset($_POST[0]['comments_listing'])) ? deAspisWarningRC($_POST[0]['comments_listing']) : '';
if ( get_option('show_avatars') && 'single' != $mode)
 add_filter('comment_author','floated_admin_avatar');
$x = new WP_Ajax_Response();
ob_start();
_wp_comment_row($comment_id,$mode,$comments_listing,$checkbox);
$comment_list_item = ob_get_contents();
ob_end_clean();
$x->add(array('what' => 'edit_comment','id' => $comment->comment_ID,'data' => $comment_list_item,'position' => $position));
$x->send();
break ;
case 'add-meta':check_ajax_referer('add-meta');
$c = 0;
$pid = (int)deAspisWarningRC($_POST[0]['post_id']);
if ( (isset($_POST[0]['metakeyselect']) && Aspis_isset($_POST[0]['metakeyselect'])) || (isset($_POST[0]['metakeyinput']) && Aspis_isset($_POST[0]['metakeyinput'])))
 {if ( !current_user_can('edit_post',$pid))
 exit('-1');
if ( (isset($_POST[0]['metakeyselect']) && Aspis_isset($_POST[0]['metakeyselect'])) && '#NONE#' == deAspisWarningRC($_POST[0]['metakeyselect']) && (empty($_POST[0]['metakeyinput']) || Aspis_empty($_POST[0]['metakeyinput'])))
 exit('1');
if ( $pid < 0)
 {$now = current_time('timestamp',1);
if ( $pid = wp_insert_post(array('post_title' => sprintf('Draft created on %s at %s',date(get_option('date_format'),$now),date(get_option('time_format'),$now)))))
 {if ( is_wp_error($pid))
 {$x = new WP_Ajax_Response(array('what' => 'meta','data' => $pid));
$x->send();
}if ( !$mid = add_meta($pid))
 exit(__('Please provide a custom field value.'));
}else 
{{exit('0');
}}}else 
{if ( !$mid = add_meta($pid))
 {exit(__('Please provide a custom field value.'));
}}$meta = get_post_meta_by_id($mid);
$pid = (int)$meta->post_id;
$meta = get_object_vars($meta);
$x = new WP_Ajax_Response(array('what' => 'meta','id' => $mid,'data' => _list_meta_row($meta,$c),'position' => 1,'supplemental' => array('postid' => $pid)));
}else 
{{$mid = (int)array_pop(array_keys(deAspisWarningRC($_POST[0]['meta'])));
$key = deAspisWarningRC($_POST[0]['meta'][0][$mid][0]['key']);
$value = deAspisWarningRC($_POST[0]['meta'][0][$mid][0]['value']);
if ( !$meta = get_post_meta_by_id($mid))
 exit('0');
if ( !current_user_can('edit_post',$meta->post_id))
 exit('-1');
if ( $meta->meta_value != stripslashes($value))
 {if ( !$u = update_meta($mid,$key,$value))
 exit('0');
}$key = stripslashes($key);
$value = stripslashes($value);
$x = new WP_Ajax_Response(array('what' => 'meta','id' => $mid,'old_id' => $mid,'data' => _list_meta_row(array('meta_key' => $key,'meta_value' => $value,'meta_id' => $mid),$c),'position' => 0,'supplemental' => array('postid' => $meta->post_id)));
}}$x->send();
break ;
case 'add-user':check_ajax_referer($action);
if ( !current_user_can('create_users'))
 exit('-1');
require_once (ABSPATH . WPINC . '/registration.php');
if ( !$user_id = add_user())
 exit('0');
elseif ( is_wp_error($user_id))
 {$x = new WP_Ajax_Response(array('what' => 'user','id' => $user_id));
$x->send();
}$user_object = new WP_User($user_id);
$x = new WP_Ajax_Response(array('what' => 'user','id' => $user_id,'data' => user_row($user_object,'',$user_object->roles[0]),'supplemental' => array('show-link' => sprintf(__('User <a href="#%s">%s</a> added'),"user-$user_id",$user_object->user_login),'role' => $user_object->roles[0])));
$x->send();
break ;
case 'autosave':define('DOING_AUTOSAVE',true);
$nonce_age = check_ajax_referer('autosave','autosavenonce');
global $current_user;
$_POST[0]['post_category'] = attAspisRCO(explode(",",deAspisWarningRC($_POST[0]['catslist'])));
if ( deAspisWarningRC($_POST[0]['post_type']) == 'page' || (empty($_POST[0]['post_category']) || Aspis_empty($_POST[0]['post_category'])))
 unset($_POST[0]['post_category']);
$do_autosave = (bool)deAspisWarningRC($_POST[0]['autosave']);
$do_lock = true;
$data = '';
$draft_saved_date_format = __('g:i:s a');
$message = sprintf(__('Draft Saved at %s.'),date_i18n($draft_saved_date_format));
$supplemental = array();
if ( isset($login_grace_period))
 $supplemental['session_expired'] = add_query_arg('interim-login',1,wp_login_url());
$id = $revision_id = 0;
if ( deAspisWarningRC($_POST[0]['post_ID']) < 0)
 {$_POST[0]['post_status'] = attAspisRCO('draft');
$_POST[0]['temp_ID'] = attAspisRCO(deAspisWarningRC($_POST[0]['post_ID']));
if ( $do_autosave)
 {$id = wp_write_post();
$data = $message;
}}else 
{{$post_ID = (int)deAspisWarningRC($_POST[0]['post_ID']);
$_POST[0]['ID'] = attAspisRCO($post_ID);
$post = get_post($post_ID);
if ( $last = wp_check_post_lock($post->ID))
 {$do_autosave = $do_lock = false;
$last_user = get_userdata($last);
$last_user_name = $last_user ? $last_user->display_name : __('Someone');
$data = new WP_Error('locked',sprintf(deAspisWarningRC($_POST[0]['post_type']) == 'page' ? __('Autosave disabled: %s is currently editing this page.') : __('Autosave disabled: %s is currently editing this post.'),esc_html($last_user_name)));
$supplemental['disable_autosave'] = 'disable';
}if ( 'page' == $post->post_type)
 {if ( !current_user_can('edit_page',$post_ID))
 exit(__('You are not allowed to edit this page.'));
}else 
{{if ( !current_user_can('edit_post',$post_ID))
 exit(__('You are not allowed to edit this post.'));
}}if ( $do_autosave)
 {if ( 'draft' == $post->post_status)
 {$id = edit_post();
}else 
{{$revision_id = wp_create_post_autosave($post->ID);
if ( is_wp_error($revision_id))
 $id = $revision_id;
else 
{$id = $post->ID;
}}}$data = $message;
}else 
{{$id = $post->ID;
}}}}if ( $do_lock && $id && is_numeric($id))
 wp_set_post_lock($id);
if ( $nonce_age == 2)
 {$supplemental['replace-autosavenonce'] = wp_create_nonce('autosave');
$supplemental['replace-getpermalinknonce'] = wp_create_nonce('getpermalink');
$supplemental['replace-samplepermalinknonce'] = wp_create_nonce('samplepermalink');
$supplemental['replace-closedpostboxesnonce'] = wp_create_nonce('closedpostboxes');
if ( $id)
 {if ( deAspisWarningRC($_POST[0]['post_type']) == 'post')
 $supplemental['replace-_wpnonce'] = wp_create_nonce('update-post_' . $id);
elseif ( deAspisWarningRC($_POST[0]['post_type']) == 'page')
 $supplemental['replace-_wpnonce'] = wp_create_nonce('update-page_' . $id);
}}$x = new WP_Ajax_Response(array('what' => 'autosave','id' => $id,'data' => $id ? $data : '','supplemental' => $supplemental));
$x->send();
break ;
case 'autosave-generate-nonces':check_ajax_referer('autosave','autosavenonce');
$ID = (int)deAspisWarningRC($_POST[0]['post_ID']);
$post_type = ('page' == deAspisWarningRC($_POST[0]['post_type'])) ? 'page' : 'post';
if ( current_user_can("edit_{$post_type}",$ID))
 exit(json_encode(array('updateNonce' => wp_create_nonce("update-{$post_type}_{$ID}"),'deleteURL' => str_replace('&amp;','&',wp_nonce_url(admin_url($post_type . '.php?action=trash&post=' . $ID),"trash-{$post_type}_{$ID}")))));
do_action('autosave_generate_nonces');
exit('0');
break ;
case 'closed-postboxes':check_ajax_referer('closedpostboxes','closedpostboxesnonce');
$closed = (isset($_POST[0]['closed']) && Aspis_isset($_POST[0]['closed'])) ? deAspisWarningRC($_POST[0]['closed']) : '';
$closed = explode(',',deAspisWarningRC($_POST[0]['closed']));
$hidden = (isset($_POST[0]['hidden']) && Aspis_isset($_POST[0]['hidden'])) ? deAspisWarningRC($_POST[0]['hidden']) : '';
$hidden = explode(',',deAspisWarningRC($_POST[0]['hidden']));
$page = (isset($_POST[0]['page']) && Aspis_isset($_POST[0]['page'])) ? deAspisWarningRC($_POST[0]['page']) : '';
if ( !preg_match('/^[a-z_-]+$/',$page))
 exit('-1');
if ( !$user = wp_get_current_user())
 exit('-1');
if ( is_array($closed))
 update_usermeta($user->ID,'closedpostboxes_' . $page,$closed);
if ( is_array($hidden))
 {$hidden = array_diff($hidden,array('submitdiv','linksubmitdiv'));
update_usermeta($user->ID,'meta-box-hidden_' . $page,$hidden);
}exit('1');
break ;
case 'hidden-columns':check_ajax_referer('screen-options-nonce','screenoptionnonce');
$hidden = (isset($_POST[0]['hidden']) && Aspis_isset($_POST[0]['hidden'])) ? deAspisWarningRC($_POST[0]['hidden']) : '';
$hidden = explode(',',deAspisWarningRC($_POST[0]['hidden']));
$page = (isset($_POST[0]['page']) && Aspis_isset($_POST[0]['page'])) ? deAspisWarningRC($_POST[0]['page']) : '';
if ( !preg_match('/^[a-z_-]+$/',$page))
 exit('-1');
if ( !$user = wp_get_current_user())
 exit('-1');
if ( is_array($hidden))
 update_usermeta($user->ID,"manage-$page-columns-hidden",$hidden);
exit('1');
break ;
case 'meta-box-order':check_ajax_referer('meta-box-order');
$order = (isset($_POST[0]['order']) && Aspis_isset($_POST[0]['order'])) ? (array)deAspisWarningRC($_POST[0]['order']) : false;
$page_columns = (isset($_POST[0]['page_columns']) && Aspis_isset($_POST[0]['page_columns'])) ? (int)deAspisWarningRC($_POST[0]['page_columns']) : 0;
$page = (isset($_POST[0]['page']) && Aspis_isset($_POST[0]['page'])) ? deAspisWarningRC($_POST[0]['page']) : '';
if ( !preg_match('/^[a-z_-]+$/',$page))
 exit('-1');
if ( !$user = wp_get_current_user())
 exit('-1');
if ( $order)
 update_user_option($user->ID,"meta-box-order_$page",$order);
if ( $page_columns)
 update_usermeta($user->ID,"screen_layout_$page",$page_columns);
exit('1');
break ;
case 'get-permalink':check_ajax_referer('getpermalink','getpermalinknonce');
$post_id = (isset($_POST[0]['post_id']) && Aspis_isset($_POST[0]['post_id'])) ? intval(deAspisWarningRC($_POST[0]['post_id'])) : 0;
exit(add_query_arg(array('preview' => 'true'),get_permalink($post_id)));
break ;
case 'sample-permalink':check_ajax_referer('samplepermalink','samplepermalinknonce');
$post_id = (isset($_POST[0]['post_id']) && Aspis_isset($_POST[0]['post_id'])) ? intval(deAspisWarningRC($_POST[0]['post_id'])) : 0;
$title = (isset($_POST[0]['new_title']) && Aspis_isset($_POST[0]['new_title'])) ? deAspisWarningRC($_POST[0]['new_title']) : '';
$slug = (isset($_POST[0]['new_slug']) && Aspis_isset($_POST[0]['new_slug'])) ? deAspisWarningRC($_POST[0]['new_slug']) : '';
exit(get_sample_permalink_html($post_id,$title,$slug));
break ;
case 'inline-save':check_ajax_referer('inlineeditnonce','_inline_edit');
if ( !(isset($_POST[0]['post_ID']) && Aspis_isset($_POST[0]['post_ID'])) || !($post_ID = (int)deAspisWarningRC($_POST[0]['post_ID'])))
 exit();
if ( 'page' == deAspisWarningRC($_POST[0]['post_type']))
 {if ( !current_user_can('edit_page',$post_ID))
 exit(__('You are not allowed to edit this page.'));
}else 
{{if ( !current_user_can('edit_post',$post_ID))
 exit(__('You are not allowed to edit this post.'));
}}if ( $last = wp_check_post_lock($post_ID))
 {$last_user = get_userdata($last);
$last_user_name = $last_user ? $last_user->display_name : __('Someone');
printf(deAspisWarningRC($_POST[0]['post_type']) == 'page' ? __('Saving is disabled: %s is currently editing this page.') : __('Saving is disabled: %s is currently editing this post.'),esc_html($last_user_name));
exit();
}$data = &deAspisWarningRC($_POST);
$post = get_post($post_ID,ARRAY_A);
$post = deAspisWarningRC(add_magic_quotes(attAspisRCO($post)));
$data['content'] = $post['post_content'];
$data['excerpt'] = $post['post_excerpt'];
$data['user_ID'] = $GLOBALS[0]['user_ID'];
if ( isset($data['post_parent']))
 $data['parent_id'] = $data['post_parent'];
if ( isset($data['keep_private']) && 'private' == $data['keep_private'])
 $data['post_status'] = 'private';
else 
{$data['post_status'] = $data['_status'];
}if ( empty($data['comment_status']))
 $data['comment_status'] = 'closed';
if ( empty($data['ping_status']))
 $data['ping_status'] = 'closed';
edit_post();
$post = array();
if ( 'page' == deAspisWarningRC($_POST[0]['post_type']))
 {$post[] = get_post(deAspisWarningRC($_POST[0]['post_ID']));
page_rows($post);
}elseif ( 'post' == deAspisWarningRC($_POST[0]['post_type']))
 {$mode = deAspisWarningRC($_POST[0]['post_view']);
$post[] = get_post(deAspisWarningRC($_POST[0]['post_ID']));
post_rows($post);
}exit();
break ;
case 'inline-save-tax':check_ajax_referer('taxinlineeditnonce','_inline_edit');
if ( !current_user_can('manage_categories'))
 exit(__('Cheatin&#8217; uh?'));
if ( !(isset($_POST[0]['tax_ID']) && Aspis_isset($_POST[0]['tax_ID'])) || !($id = (int)deAspisWarningRC($_POST[0]['tax_ID'])))
 exit(-1);
switch ( deAspisWarningRC($_POST[0]['tax_type']) ) {
case 'cat':$data = array();
$data['cat_ID'] = $id;
$data['cat_name'] = deAspisWarningRC($_POST[0]['name']);
$data['category_nicename'] = deAspisWarningRC($_POST[0]['slug']);
if ( (isset($_POST[0]['parent']) && Aspis_isset($_POST[0]['parent'])) && (int)deAspisWarningRC($_POST[0]['parent']) > 0)
 $data['category_parent'] = deAspisWarningRC($_POST[0]['parent']);
$cat = get_category($id,ARRAY_A);
$data['category_description'] = $cat['category_description'];
$updated = wp_update_category($data);
if ( $updated && !is_wp_error($updated))
 echo _cat_row($updated,0);
else 
{exit(__('Category not updated.'));
}break ;
case 'link-cat':$updated = wp_update_term($id,'link_category',deAspisWarningRC($_POST));
if ( $updated && !is_wp_error($updated))
 echo link_cat_row($updated['term_id']);
else 
{exit(__('Category not updated.'));
}break ;
case 'tag':$taxonomy = !(empty($_POST[0]['taxonomy']) || Aspis_empty($_POST[0]['taxonomy'])) ? deAspisWarningRC($_POST[0]['taxonomy']) : 'post_tag';
$tag = get_term($id,$taxonomy);
$_POST[0]['description'] = attAspisRCO($tag->description);
$updated = wp_update_term($id,$taxonomy,deAspisWarningRC($_POST));
if ( $updated && !is_wp_error($updated))
 {$tag = get_term($updated['term_id'],$taxonomy);
if ( !$tag || is_wp_error($tag))
 exit(__('Tag not updated.'));
echo _tag_row($tag,'',$taxonomy);
}else 
{{exit(__('Tag not updated.'));
}}break ;
 }
exit();
break ;
case 'find_posts':check_ajax_referer('find-posts');
if ( (empty($_POST[0]['ps']) || Aspis_empty($_POST[0]['ps'])))
 exit();
$what = (isset($_POST[0]['pages']) && Aspis_isset($_POST[0]['pages'])) ? 'page' : 'post';
$s = stripslashes(deAspisWarningRC($_POST[0]['ps']));
preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/',$s,$matches);
$search_terms = array_map('_search_terms_tidy',$matches[0]);
$searchand = $search = '';
foreach ( (array)$search_terms as $term  )
{$term = addslashes_gpc($term);
$search .= "{$searchand}(($wpdb->posts.post_title LIKE '%{$term}%') OR ($wpdb->posts.post_content LIKE '%{$term}%'))";
$searchand = ' AND ';
}$term = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($s)),array(0));
if ( count($search_terms) > 1 && $search_terms[0] != $s)
 $search .= " OR ($wpdb->posts.post_title LIKE '%{$term}%') OR ($wpdb->posts.post_content LIKE '%{$term}%')";
$posts = $wpdb->get_results("SELECT ID, post_title, post_status, post_date FROM $wpdb->posts WHERE post_type = '$what' AND post_status IN ('draft', 'publish') AND ($search) ORDER BY post_date_gmt DESC LIMIT 50");
if ( !$posts)
 exit(__('No posts found.'));
$html = '<table class="widefat" cellspacing="0"><thead><tr><th class="found-radio"><br /></th><th>' . __('Title') . '</th><th>' . __('Date') . '</th><th>' . __('Status') . '</th></tr></thead><tbody>';
foreach ( $posts as $post  )
{switch ( $post->post_status ) {
case 'publish':case 'private':$stat = __('Published');
break ;
case 'future':$stat = __('Scheduled');
break ;
case 'pending':$stat = __('Pending Review');
break ;
case 'draft':$stat = __('Draft');
break ;
 }
if ( '0000-00-00 00:00:00' == $post->post_date)
 {$time = '';
}else 
{{$time = mysql2date(__('Y/m/d'),$post->post_date);
}}$html .= '<tr class="found-posts"><td class="found-radio"><input type="radio" id="found-' . $post->ID . '" name="found_post_id" value="' . esc_attr($post->ID) . '"></td>';
$html .= '<td><label for="found-' . $post->ID . '">' . esc_html($post->post_title) . '</label></td><td>' . esc_html($time) . '</td><td>' . esc_html($stat) . '</td></tr>' . "\n\n";
}$html .= '</tbody></table>';
$x = new WP_Ajax_Response();
$x->add(array('what' => $what,'data' => $html));
$x->send();
break ;
case 'lj-importer':check_ajax_referer('lj-api-import');
if ( !current_user_can('publish_posts'))
 exit('-1');
if ( (empty($_POST[0]['step']) || Aspis_empty($_POST[0]['step'])))
 exit('-1');
define('WP_IMPORTING',true);
include (ABSPATH . 'wp-admin/import/livejournal.php');
$result = $lj_api_import->{'step' . ((int)deAspisWarningRC($_POST[0]['step']))}();
if ( is_wp_error($result))
 echo $result->get_error_message();
exit();
break ;
case 'widgets-order':check_ajax_referer('save-sidebar-widgets','savewidgets');
if ( !current_user_can('switch_themes'))
 exit('-1');
unset($_POST[0]['savewidgets'],$_POST['action']);
if ( is_array(deAspisWarningRC($_POST[0]['sidebars'])))
 {$sidebars = array();
foreach ( deAspisWarningRC($_POST[0]['sidebars']) as $key =>$val )
{$sb = array();
if ( !empty($val))
 {$val = explode(',',$val);
foreach ( $val as $k =>$v )
{if ( strpos($v,'widget-') === false)
 continue ;
$sb[$k] = substr($v,strpos($v,'_') + 1);
}}$sidebars[$key] = $sb;
}wp_set_sidebars_widgets($sidebars);
exit('1');
}exit('-1');
break ;
case 'save-widget':check_ajax_referer('save-sidebar-widgets','savewidgets');
if ( !current_user_can('switch_themes') || !(isset($_POST[0]['id_base']) && Aspis_isset($_POST[0]['id_base'])))
 exit('-1');
unset($_POST[0]['savewidgets'],$_POST['action']);
do_action('load-widgets.php');
do_action('widgets.php');
do_action('sidebar_admin_setup');
$id_base = deAspisWarningRC($_POST[0]['id_base']);
$widget_id = deAspisWarningRC($_POST[0]['widget-id']);
$sidebar_id = deAspisWarningRC($_POST[0]['sidebar']);
$multi_number = !(empty($_POST[0]['multi_number']) || Aspis_empty($_POST[0]['multi_number'])) ? (int)deAspisWarningRC($_POST[0]['multi_number']) : 0;
$settings = (isset($_POST[0]['widget-' . $id_base]) && Aspis_isset($_POST[0]['widget-' . $id_base])) && is_array(deAspisWarningRC($_POST[0]['widget-' . $id_base])) ? deAspisWarningRC($_POST[0]['widget-' . $id_base]) : false;
$error = '<p>' . __('An error has occured. Please reload the page and try again.') . '</p>';
$sidebars = wp_get_sidebars_widgets();
$sidebar = isset($sidebars[$sidebar_id]) ? $sidebars[$sidebar_id] : array();
if ( (isset($_POST[0]['delete_widget']) && Aspis_isset($_POST[0]['delete_widget'])) && deAspisWarningRC($_POST[0]['delete_widget']))
 {if ( !isset($wp_registered_widgets[$widget_id]))
 exit($error);
$sidebar = array_diff($sidebar,array($widget_id));
$_POST = attAspisRCO(array('sidebar' => $sidebar_id,'widget-' . $id_base => array(),'the-widget-id' => $widget_id,'delete_widget' => '1'));
}elseif ( $settings && preg_match('/__i__|%i%/',key($settings)))
 {if ( !$multi_number)
 exit($error);
$_POST[0]['widget-' . $id_base] = attAspisRCO(array($multi_number => array_shift($settings)));
$widget_id = $id_base . '-' . $multi_number;
$sidebar[] = $widget_id;
}$_POST[0]['widget-id'] = attAspisRCO($sidebar);
foreach ( (array)$wp_registered_widget_updates as $name =>$control )
{if ( $name == $id_base)
 {if ( !is_callable($control['callback']))
 continue ;
ob_start();
AspisUntainted_call_user_func_array($control['callback'],$control['params']);
ob_end_clean();
break ;
}}if ( (isset($_POST[0]['delete_widget']) && Aspis_isset($_POST[0]['delete_widget'])) && deAspisWarningRC($_POST[0]['delete_widget']))
 {$sidebars[$sidebar_id] = $sidebar;
wp_set_sidebars_widgets($sidebars);
echo "deleted:$widget_id";
exit();
}if ( !(empty($_POST[0]['add_new']) || Aspis_empty($_POST[0]['add_new'])))
 exit();
if ( $form = $wp_registered_widget_controls[$widget_id])
 AspisUntainted_call_user_func_array($form['callback'],$form['params']);
exit();
break ;
case 'image-editor':$attachment_id = intval(deAspisWarningRC($_POST[0]['postid']));
if ( empty($attachment_id) || !current_user_can('edit_post',$attachment_id))
 exit('-1');
check_ajax_referer("image_editor-$attachment_id");
include_once (ABSPATH . 'wp-admin/includes/image-edit.php');
$msg = false;
switch ( deAspisWarningRC($_POST[0]['do']) ) {
case 'save':$msg = wp_save_image($attachment_id);
$msg = json_encode($msg);
exit($msg);
break ;
case 'scale':$msg = wp_save_image($attachment_id);
break ;
case 'restore':$msg = wp_restore_image($attachment_id);
break ;
 }
wp_image_editor($attachment_id,$msg);
exit();
break ;
case 'set-post-thumbnail':$post_id = intval(deAspisWarningRC($_POST[0]['post_id']));
if ( !current_user_can('edit_post',$post_id))
 exit('-1');
$thumbnail_id = intval(deAspisWarningRC($_POST[0]['thumbnail_id']));
if ( $thumbnail_id == '-1')
 {delete_post_meta($post_id,'_thumbnail_id');
exit(_wp_post_thumbnail_html());
}if ( $thumbnail_id && get_post($thumbnail_id))
 {$thumbnail_html = wp_get_attachment_image($thumbnail_id,'thumbnail');
if ( !empty($thumbnail_html))
 {update_post_meta($post_id,'_thumbnail_id',$thumbnail_id);
exit(_wp_post_thumbnail_html($thumbnail_id));
}}exit('0');
default :do_action('wp_ajax_' . deAspisWarningRC($_POST[0]['action']));
exit('0');
break ;
 }
;
?>
<?php 