<?php require_once('AspisMain.php'); ?><?php
define('APP_REQUEST',true);
require_once ('./wp-load.php');
require_once (ABSPATH . WPINC . '/atomlib.php');
require_once (ABSPATH . '/wp-admin/includes/image.php');
$_SERVER[0]['PATH_INFO'] = attAspisRCO(preg_replace('/.*\/wp-app\.php/','',deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
$app_logging = 0;
$always_authenticate = 1;
function log_app ( $label,$msg ) {
{global $app_logging;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $app_logging,"\$app_logging",$AspisChangesCache);
}if ( $app_logging)
 {$fp = fopen('wp-app.log','a+');
$date = gmdate('Y-m-d H:i:s');
fwrite($fp,"\n\n$date - $label\n$msg\n");
fclose($fp);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$app_logging",$AspisChangesCache);
 }
function wa_posts_where_include_drafts_filter ( $where ) {
$where = str_replace("post_status = 'publish'","post_status = 'publish' OR post_status = 'future' OR post_status = 'draft' OR post_status = 'inherit'",$where);
{$AspisRetTemp = $where;
return $AspisRetTemp;
} }
add_filter('posts_where','wa_posts_where_include_drafts_filter');
class AtomServer{var $ATOM_CONTENT_TYPE = 'application/atom+xml';
var $CATEGORIES_CONTENT_TYPE = 'application/atomcat+xml';
var $SERVICE_CONTENT_TYPE = 'application/atomsvc+xml';
var $ATOM_NS = 'http://www.w3.org/2005/Atom';
var $ATOMPUB_NS = 'http://www.w3.org/2007/app';
var $ENTRIES_PATH = "posts";
var $CATEGORIES_PATH = "categories";
var $MEDIA_PATH = "attachments";
var $ENTRY_PATH = "post";
var $SERVICE_PATH = "service";
var $MEDIA_SINGLE_PATH = "attachment";
var $params = array();
var $media_content_types = array('image/*','audio/*','video/*');
var $atom_content_types = array('application/atom+xml');
var $selectors = array();
var $do_output = true;
function AtomServer (  ) {
{$this->script_name = array_pop(explode('/',deAspisWarningRC($_SERVER[0]['SCRIPT_NAME'])));
$this->app_base = get_bloginfo('url') . '/' . $this->script_name . '/';
if ( (isset($_SERVER[0]['HTTPS']) && Aspis_isset($_SERVER[0]['HTTPS'])) && strtolower(deAspisWarningRC($_SERVER[0]['HTTPS'])) == 'on')
 {$this->app_base = preg_replace('/^http:\/\//','https://',$this->app_base);
}$this->selectors = array('@/service$@' => array('GET' => 'get_service'),'@/categories$@' => array('GET' => 'get_categories_xml'),'@/post/(\d+)$@' => array('GET' => 'get_post','PUT' => 'put_post','DELETE' => 'delete_post'),'@/posts/?(\d+)?$@' => array('GET' => 'get_posts','POST' => 'create_post'),'@/attachments/?(\d+)?$@' => array('GET' => 'get_attachment','POST' => 'create_attachment'),'@/attachment/file/(\d+)$@' => array('GET' => 'get_file','PUT' => 'put_file','DELETE' => 'delete_file'),'@/attachment/(\d+)$@' => array('GET' => 'get_attachment','PUT' => 'put_attachment','DELETE' => 'delete_attachment'),);
} }
function handle_request (  ) {
{{global $always_authenticate;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $always_authenticate,"\$always_authenticate",$AspisChangesCache);
}if ( !(empty($_SERVER[0]['ORIG_PATH_INFO']) || Aspis_empty($_SERVER[0]['ORIG_PATH_INFO'])))
 $path = deAspisWarningRC($_SERVER[0]['ORIG_PATH_INFO']);
else 
{$path = deAspisWarningRC($_SERVER[0]['PATH_INFO']);
}$method = deAspisWarningRC($_SERVER[0]['REQUEST_METHOD']);
log_app('REQUEST',"$method $path\n================");
$this->process_conditionals();
if ( $method == 'HEAD')
 {$this->do_output = false;
$method = 'GET';
}if ( strlen($path) == 0 || $path == '/')
 {$this->redirect($this->get_service_url());
}if ( !get_option('enable_app'))
 $this->forbidden(sprintf(__('AtomPub services are disabled on this blog.  An admin user can enable them at %s'),admin_url('options-writing.php')));
foreach ( $this->selectors as $regex =>$funcs )
{if ( preg_match($regex,$path,$matches))
 {if ( isset($funcs[$method]))
 {if ( !$this->authenticate())
 {if ( $always_authenticate)
 {$this->auth_required('Credentials required.');
}}array_shift($matches);
AspisUntainted_call_user_func_array(array(&$this,$funcs[$method]),$matches);
exit();
}else 
{{$this->not_allowed(array_keys($funcs));
}}}}$this->not_found();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$always_authenticate",$AspisChangesCache);
 }
function get_service (  ) {
{log_app('function','get_service()');
if ( !current_user_can('edit_posts'))
 $this->auth_required(__('Sorry, you do not have the right to access this blog.'));
$entries_url = esc_attr($this->get_entries_url());
$categories_url = esc_attr($this->get_categories_url());
$media_url = esc_attr($this->get_attachments_url());
$accepted_media_types = '';
foreach ( $this->media_content_types as $med  )
{$accepted_media_types = $accepted_media_types . "<accept>" . $med . "</accept>";
}$atom_prefix = "atom";
$atom_blogname = get_bloginfo('name');
$service_doc = <<<EOD
<service xmlns="$this->ATOMPUB_NS" xmlns:$atom_prefix="$this->ATOM_NS">
  <workspace>
    <$atom_prefix:title>$atom_blogname Workspace</$atom_prefix:title>
    <collection href="$entries_url">
      <$atom_prefix:title>$atom_blogname Posts</$atom_prefix:title>
      <accept>$this->ATOM_CONTENT_TYPE;
type=entry</accept>
      <categories href="$categories_url" />
    </collection>
    <collection href="$media_url">
      <$atom_prefix:title>$atom_blogname Media</$atom_prefix:title>
      $accepted_media_types
    </collection>
  </workspace>
</service>

EOD
;
$this->output($service_doc,$this->SERVICE_CONTENT_TYPE);
} }
function get_categories_xml (  ) {
{log_app('function','get_categories_xml()');
if ( !current_user_can('edit_posts'))
 $this->auth_required(__('Sorry, you do not have the right to access this blog.'));
$home = esc_attr(get_bloginfo_rss('home'));
$categories = "";
$cats = get_categories("hierarchical=0&hide_empty=0");
foreach ( (array)$cats as $cat  )
{$categories .= "    <category term=\"" . esc_attr($cat->name) . "\" />\n";
}$output = <<<EOD
<app:categories xmlns:app="$this->ATOMPUB_NS"
	xmlns="$this->ATOM_NS"
	fixed="yes" scheme="$home">
	$categories
</app:categories>
EOD
;
$this->output($output,$this->CATEGORIES_CONTENT_TYPE);
} }
function create_post (  ) {
{{global $blog_id,$user_ID;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $blog_id,"\$blog_id",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($user_ID,"\$user_ID",$AspisChangesCache);
}$this->get_accepted_content_type($this->atom_content_types);
$parser = new AtomParser();
if ( !$parser->parse())
 {$this->client_error();
}$entry = array_pop($parser->feed->entries);
log_app('Received entry:',print_r($entry,true));
$catnames = array();
foreach ( $entry->categories as $cat  )
array_push($catnames,$cat["term"]);
$wp_cats = get_categories(array('hide_empty' => false));
$post_category = array();
foreach ( $wp_cats as $cat  )
{if ( in_array($cat->name,$catnames))
 array_push($post_category,$cat->term_id);
}$publish = (isset($entry->draft) && trim($entry->draft) == 'yes') ? false : true;
$cap = ($publish) ? 'publish_posts' : 'edit_posts';
if ( !current_user_can($cap))
 $this->auth_required(__('Sorry, you do not have the right to edit/publish new posts.'));
$blog_ID = (int)$blog_id;
$post_status = ($publish) ? 'publish' : 'draft';
$post_author = (int)$user_ID;
$post_title = $entry->title[1];
$post_content = $entry->content[1];
$post_excerpt = $entry->summary[1];
$pubtimes = $this->get_publish_time($entry->published);
$post_date = $pubtimes[0];
$post_date_gmt = $pubtimes[1];
if ( (isset($_SERVER[0]['HTTP_SLUG']) && Aspis_isset($_SERVER[0]['HTTP_SLUG'])))
 $post_name = deAspisWarningRC($_SERVER[0]['HTTP_SLUG']);
$post_data = compact('blog_ID','post_author','post_date','post_date_gmt','post_content','post_title','post_category','post_status','post_excerpt','post_name');
$this->escape($post_data);
log_app('Inserting Post. Data:',print_r($post_data,true));
$postID = wp_insert_post($post_data);
if ( is_wp_error($postID))
 $this->internal_error($postID->get_error_message());
if ( !$postID)
 $this->internal_error(__('Sorry, your entry could not be posted. Something wrong happened.'));
@wp_set_post_categories($postID,$post_category);
do_action('atompub_create_post',$postID,$entry);
$output = $this->get_entry($postID);
log_app('function',"create_post($postID)");
$this->created($postID,$output);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$blog_id",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$user_ID",$AspisChangesCache);
 }
function get_post ( $postID ) {
{{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}if ( !current_user_can('edit_post',$postID))
 $this->auth_required(__('Sorry, you do not have the right to access this post.'));
$this->set_current_entry($postID);
$output = $this->get_entry($postID);
log_app('function',"get_post($postID)");
$this->output($output);
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function put_post ( $postID ) {
{$this->get_accepted_content_type($this->atom_content_types);
$parser = new AtomParser();
if ( !$parser->parse())
 {$this->bad_request();
}$parsed = array_pop($parser->feed->entries);
log_app('Received UPDATED entry:',print_r($parsed,true));
{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}$this->set_current_entry($postID);
if ( !current_user_can('edit_post',$entry['ID']))
 $this->auth_required(__('Sorry, you do not have the right to edit this post.'));
$publish = (isset($parsed->draft) && trim($parsed->draft) == 'yes') ? false : true;
$post_status = ($publish) ? 'publish' : 'draft';
extract(($entry));
$post_title = $parsed->title[1];
$post_content = $parsed->content[1];
$post_excerpt = $parsed->summary[1];
$pubtimes = $this->get_publish_time($entry->published);
$post_date = $pubtimes[0];
$post_date_gmt = $pubtimes[1];
$pubtimes = $this->get_publish_time($parsed->updated);
$post_modified = $pubtimes[0];
$post_modified_gmt = $pubtimes[1];
$postdata = compact('ID','post_content','post_title','post_category','post_status','post_excerpt','post_date','post_date_gmt','post_modified','post_modified_gmt');
$this->escape($postdata);
$result = wp_update_post($postdata);
if ( !$result)
 {$this->internal_error(__('For some strange yet very annoying reason, this post could not be edited.'));
}do_action('atompub_put_post',$ID,$parsed);
log_app('function',"put_post($postID)");
$this->ok();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function delete_post ( $postID ) {
{{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}$this->set_current_entry($postID);
if ( !current_user_can('edit_post',$postID))
 {$this->auth_required(__('Sorry, you do not have the right to delete this post.'));
}if ( $entry['post_type'] == 'attachment')
 {$this->delete_attachment($postID);
}else 
{{$result = wp_delete_post($postID);
if ( !$result)
 {$this->internal_error(__('For some strange yet very annoying reason, this post could not be deleted.'));
}log_app('function',"delete_post($postID)");
$this->ok();
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function get_attachment ( $postID = null ) {
{if ( !current_user_can('upload_files'))
 $this->auth_required(__('Sorry, you do not have permission to upload files.'));
if ( !isset($postID))
 {$this->get_attachments();
}else 
{{$this->set_current_entry($postID);
$output = $this->get_entry($postID,'attachment');
log_app('function',"get_attachment($postID)");
$this->output($output);
}}} }
function create_attachment (  ) {
{$type = $this->get_accepted_content_type();
if ( !current_user_can('upload_files'))
 $this->auth_required(__('You do not have permission to upload files.'));
$fp = fopen("php://input","rb");
$bits = null;
while ( !feof($fp) )
{$bits .= fread($fp,4096);
}fclose($fp);
$slug = '';
if ( (isset($_SERVER[0]['HTTP_SLUG']) && Aspis_isset($_SERVER[0]['HTTP_SLUG'])))
 $slug = sanitize_file_name(deAspisWarningRC($_SERVER[0]['HTTP_SLUG']));
elseif ( (isset($_SERVER[0]['HTTP_TITLE']) && Aspis_isset($_SERVER[0]['HTTP_TITLE'])))
 $slug = sanitize_file_name(deAspisWarningRC($_SERVER[0]['HTTP_TITLE']));
elseif ( empty($slug))
 $slug = substr(md5(uniqid(microtime())),0,7);
$ext = preg_replace('|.*/([a-z0-9]+)|','$1',deAspisWarningRC($_SERVER[0]['CONTENT_TYPE']));
$slug = "$slug.$ext";
$file = wp_upload_bits($slug,NULL,$bits);
log_app('wp_upload_bits returns:',print_r($file,true));
$url = $file['url'];
$file = $file['file'];
do_action('wp_create_file_in_uploads',$file);
$attachment = array('post_title' => $slug,'post_content' => $slug,'post_status' => 'attachment','post_parent' => 0,'post_mime_type' => $type,'guid' => $url);
$postID = wp_insert_attachment($attachment,$file);
if ( !$postID)
 $this->internal_error(__('Sorry, your entry could not be posted. Something wrong happened.'));
$output = $this->get_entry($postID,'attachment');
$this->created($postID,$output,'attachment');
log_app('function',"create_attachment($postID)");
} }
function put_attachment ( $postID ) {
{$this->get_accepted_content_type($this->atom_content_types);
$parser = new AtomParser();
if ( !$parser->parse())
 {$this->bad_request();
}$parsed = array_pop($parser->feed->entries);
{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}$this->set_current_entry($postID);
if ( !current_user_can('edit_post',$entry['ID']))
 $this->auth_required(__('Sorry, you do not have the right to edit this post.'));
extract(($entry));
$post_title = $parsed->title[1];
$post_content = $parsed->summary[1];
$pubtimes = $this->get_publish_time($parsed->updated);
$post_modified = $pubtimes[0];
$post_modified_gmt = $pubtimes[1];
$postdata = compact('ID','post_content','post_title','post_category','post_status','post_excerpt','post_modified','post_modified_gmt');
$this->escape($postdata);
$result = wp_update_post($postdata);
if ( !$result)
 {$this->internal_error(__('For some strange yet very annoying reason, this post could not be edited.'));
}log_app('function',"put_attachment($postID)");
$this->ok();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function delete_attachment ( $postID ) {
{log_app('function',"delete_attachment($postID). File '$location' deleted.");
{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}$this->set_current_entry($postID);
if ( !current_user_can('edit_post',$postID))
 {$this->auth_required(__('Sorry, you do not have the right to delete this post.'));
}$location = get_post_meta($entry['ID'],'_wp_attached_file',true);
$filetype = wp_check_filetype($location);
if ( !isset($location) || 'attachment' != $entry['post_type'] || empty($filetype['ext']))
 $this->internal_error(__('Error ocurred while accessing post metadata for file location.'));
@unlink($location);
$result = wp_delete_post($postID);
if ( !$result)
 {$this->internal_error(__('For some strange yet very annoying reason, this post could not be deleted.'));
}log_app('function',"delete_attachment($postID). File '$location' deleted.");
$this->ok();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function get_file ( $postID ) {
{{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}$this->set_current_entry($postID);
if ( !current_user_can('edit_post',$postID))
 {$this->auth_required(__('Sorry, you do not have the right to edit this post.'));
}$location = get_post_meta($entry['ID'],'_wp_attached_file',true);
$location = get_option('upload_path') . '/' . $location;
$filetype = wp_check_filetype($location);
if ( !isset($location) || 'attachment' != $entry['post_type'] || empty($filetype['ext']))
 $this->internal_error(__('Error ocurred while accessing post metadata for file location.'));
status_header('200');
header('Content-Type: ' . $entry['post_mime_type']);
header('Connection: close');
if ( $fp = fopen($location,"rb"))
 {status_header('200');
header('Content-Type: ' . $entry['post_mime_type']);
header('Connection: close');
while ( !feof($fp) )
{echo fread($fp,4096);
}fclose($fp);
}else 
{{status_header('404');
}}log_app('function',"get_file($postID)");
exit();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function put_file ( $postID ) {
{if ( !current_user_can('upload_files'))
 $this->auth_required(__('You do not have permission to upload files.'));
{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}$this->set_current_entry($postID);
if ( !current_user_can('edit_post',$postID))
 {$this->auth_required(__('Sorry, you do not have the right to edit this post.'));
}$upload_dir = wp_upload_dir();
$location = get_post_meta($entry['ID'],'_wp_attached_file',true);
$filetype = wp_check_filetype($location);
$location = "{$upload_dir['basedir']}/{$location}";
if ( !isset($location) || 'attachment' != $entry['post_type'] || empty($filetype['ext']))
 $this->internal_error(__('Error ocurred while accessing post metadata for file location.'));
$fp = fopen("php://input","rb");
$localfp = fopen($location,"w+");
while ( !feof($fp) )
{fwrite($localfp,fread($fp,4096));
}fclose($fp);
fclose($localfp);
$ID = $entry['ID'];
$pubtimes = $this->get_publish_time($entry->published);
$post_date = $pubtimes[0];
$post_date_gmt = $pubtimes[1];
$pubtimes = $this->get_publish_time($parsed->updated);
$post_modified = $pubtimes[0];
$post_modified_gmt = $pubtimes[1];
$post_data = compact('ID','post_date','post_date_gmt','post_modified','post_modified_gmt');
$result = wp_update_post($post_data);
if ( !$result)
 {$this->internal_error(__('Sorry, your entry could not be posted. Something wrong happened.'));
}wp_update_attachment_metadata($postID,wp_generate_attachment_metadata($postID,$location));
log_app('function',"put_file($postID)");
$this->ok();
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function get_entries_url ( $page = null ) {
{if ( isset($GLOBALS[0]['post_type']) && ($GLOBALS[0]['post_type'] == 'attachment'))
 {$path = $this->MEDIA_PATH;
}else 
{{$path = $this->ENTRIES_PATH;
}}$url = $this->app_base . $path;
if ( isset($page) && is_int($page))
 {$url .= "/$page";
}{$AspisRetTemp = $url;
return $AspisRetTemp;
}} }
function the_entries_url ( $page = null ) {
{echo $this->get_entries_url($page);
} }
function get_categories_url ( $deprecated = '' ) {
{{$AspisRetTemp = $this->app_base . $this->CATEGORIES_PATH;
return $AspisRetTemp;
}} }
function the_categories_url (  ) {
{echo $this->get_categories_url();
} }
function get_attachments_url ( $page = null ) {
{$url = $this->app_base . $this->MEDIA_PATH;
if ( isset($page) && is_int($page))
 {$url .= "/$page";
}{$AspisRetTemp = $url;
return $AspisRetTemp;
}} }
function the_attachments_url ( $page = null ) {
{echo $this->get_attachments_url($page);
} }
function get_service_url (  ) {
{{$AspisRetTemp = $this->app_base . $this->SERVICE_PATH;
return $AspisRetTemp;
}} }
function get_entry_url ( $postID = null ) {
{if ( !isset($postID))
 {{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$postID = (int)$post->ID;
}$url = $this->app_base . $this->ENTRY_PATH . "/$postID";
log_app('function',"get_entry_url() = $url");
{$AspisRetTemp = $url;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function the_entry_url ( $postID = null ) {
{echo $this->get_entry_url($postID);
} }
function get_media_url ( $postID = null ) {
{if ( !isset($postID))
 {{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$postID = (int)$post->ID;
}$url = $this->app_base . $this->MEDIA_SINGLE_PATH . "/file/$postID";
log_app('function',"get_media_url() = $url");
{$AspisRetTemp = $url;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function the_media_url ( $postID = null ) {
{echo $this->get_media_url($postID);
} }
function set_current_entry ( $postID ) {
{{global $entry;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $entry,"\$entry",$AspisChangesCache);
}log_app('function',"set_current_entry($postID)");
if ( !isset($postID))
 {$this->not_found();
}$entry = wp_get_single_post($postID,ARRAY_A);
if ( !isset($entry) || !isset($entry['ID']))
 $this->not_found();
{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
return ;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$entry",$AspisChangesCache);
 }
function get_posts ( $page = 1,$post_type = 'post' ) {
{log_app('function',"get_posts($page, '$post_type')");
$feed = $this->get_feed($page,$post_type);
$this->output($feed);
} }
function get_attachments ( $page = 1,$post_type = 'attachment' ) {
{log_app('function',"get_attachments($page, '$post_type')");
$GLOBALS[0]['post_type'] = $post_type;
$feed = $this->get_feed($page,$post_type);
$this->output($feed);
} }
function get_feed ( $page = 1,$post_type = 'post' ) {
{{global $post,$wp,$wp_query,$posts,$wpdb,$blog_id;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp,"\$wp",$AspisChangesCache);
$AspisVar2 = &AspisCleanTaintedGlobalUntainted($wp_query,"\$wp_query",$AspisChangesCache);
$AspisVar3 = &AspisCleanTaintedGlobalUntainted($posts,"\$posts",$AspisChangesCache);
$AspisVar4 = &AspisCleanTaintedGlobalUntainted($wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar5 = &AspisCleanTaintedGlobalUntainted($blog_id,"\$blog_id",$AspisChangesCache);
}log_app('function',"get_feed($page, '$post_type')");
ob_start();
$this->ENTRY_PATH = $post_type;
if ( !isset($page))
 {$page = 1;
}$page = (int)$page;
$count = get_option('posts_per_rss');
wp('posts_per_page=' . $count . '&offset=' . ($count * ($page - 1) . '&orderby=modified'));
$post = $GLOBALS[0]['post'];
$posts = $GLOBALS[0]['posts'];
$wp = $GLOBALS[0]['wp'];
$wp_query = $GLOBALS[0]['wp_query'];
$wpdb = $GLOBALS[0]['wpdb'];
$blog_id = (int)$GLOBALS[0]['blog_id'];
log_app('function',"query_posts(# " . print_r($wp_query,true) . "#)");
log_app('function',"total_count(# $wp_query->max_num_pages #)");
$last_page = $wp_query->max_num_pages;
$next_page = (($page + 1) > $last_page) ? NULL : $page + 1;
$prev_page = ($page - 1) < 1 ? NULL : $page - 1;
$last_page = ((int)$last_page == 1 || (int)$last_page == 0) ? NULL : (int)$last_page;
$self_page = $page > 1 ? $page : NULL;
;
?><feed xmlns="<?php echo $this->ATOM_NS;
?>" xmlns:app="<?php echo $this->ATOMPUB_NS;
?>" xml:lang="<?php echo get_option('rss_language');
;
?>">
<id><?php $this->the_entries_url();
?></id>
<updated><?php echo mysql2date('Y-m-d\TH:i:s\Z',get_lastpostmodified('GMT'),false);
;
?></updated>
<title type="text"><?php bloginfo_rss('name');
?></title>
<subtitle type="text"><?php bloginfo_rss("description");
?></subtitle>
<link rel="first" type="<?php echo $this->ATOM_CONTENT_TYPE;
?>" href="<?php $this->the_entries_url();
?>" />
<?php if ( isset($prev_page))
 {;
?>
<link rel="previous" type="<?php echo $this->ATOM_CONTENT_TYPE;
?>" href="<?php $this->the_entries_url($prev_page);
?>" />
<?php };
?>
<?php if ( isset($next_page))
 {;
?>
<link rel="next" type="<?php echo $this->ATOM_CONTENT_TYPE;
?>" href="<?php $this->the_entries_url($next_page);
?>" />
<?php };
?>
<link rel="last" type="<?php echo $this->ATOM_CONTENT_TYPE;
?>" href="<?php $this->the_entries_url($last_page);
?>" />
<link rel="self" type="<?php echo $this->ATOM_CONTENT_TYPE;
?>" href="<?php $this->the_entries_url($self_page);
?>" />
<rights type="text">Copyright <?php echo date('Y');
;
?></rights>
<?php the_generator('atom');
;
?>
<?php if ( have_posts())
 {while ( have_posts() )
{the_post();
$this->echo_entry();
}};
?></feed>
<?php $feed = ob_get_contents();
ob_end_clean();
{$AspisRetTemp = $feed;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$posts",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$blog_id",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar2,"\$wp_query",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar3,"\$posts",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar4,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar5,"\$blog_id",$AspisChangesCache);
 }
function get_entry ( $postID,$post_type = 'post' ) {
{log_app('function',"get_entry($postID, '$post_type')");
ob_start();
switch ( $post_type ) {
case 'post':$varname = 'p';
break ;
case 'attachment':$this->ENTRY_PATH = 'attachment';
$varname = 'attachment_id';
break ;
 }
query_posts($varname . '=' . $postID);
if ( have_posts())
 {while ( have_posts() )
{the_post();
$this->echo_entry();
log_app('$post',print_r($GLOBALS[0]['post'],true));
$entry = ob_get_contents();
break ;
}}ob_end_clean();
log_app('get_entry returning:',$entry);
{$AspisRetTemp = $entry;
return $AspisRetTemp;
}} }
function echo_entry (  ) {
{;
?>
<entry xmlns="<?php echo $this->ATOM_NS;
?>"
       xmlns:app="<?php echo $this->ATOMPUB_NS;
?>" xml:lang="<?php echo get_option('rss_language');
;
?>">
	<id><?php the_guid($GLOBALS[0]['post']->ID);
;
?></id>
<?php list($content_type,$content) = prep_atom_text_construct(get_the_title());
;
?>
	<title type="<?php echo $content_type;
?>"><?php echo $content;
?></title>
	<updated><?php echo get_post_modified_time('Y-m-d\TH:i:s\Z',true);
;
?></updated>
	<published><?php echo get_post_time('Y-m-d\TH:i:s\Z',true);
;
?></published>
	<app:edited><?php echo get_post_modified_time('Y-m-d\TH:i:s\Z',true);
;
?></app:edited>
	<app:control>
		<app:draft><?php echo ($GLOBALS[0]['post']->post_status == 'draft' ? 'yes' : 'no');
?></app:draft>
	</app:control>
	<author>
		<name><?php the_author();
?></name>
<?php if ( get_the_author_meta('url') && get_the_author_meta('url') != 'http://')
 {;
?>
		<uri><?php the_author_meta('url');
?></uri>
<?php };
?>
	</author>
<?php if ( $GLOBALS[0]['post']->post_type == 'attachment')
 {;
?>
	<link rel="edit-media" href="<?php $this->the_media_url();
?>" />
	<content type="<?php echo $GLOBALS[0]['post']->post_mime_type;
?>" src="<?php the_guid();
;
?>"/>
<?php }else 
{{;
?>
	<link href="<?php the_permalink_rss();
?>" />
<?php if ( strlen($GLOBALS[0]['post']->post_content))
 {list($content_type,$content) = prep_atom_text_construct(get_the_content());
;
?>
	<content type="<?php echo $content_type;
?>"><?php echo $content;
?></content>
<?php };
?>
<?php }};
?>
	<link rel="edit" href="<?php $this->the_entry_url();
?>" />
	<?php the_category_rss('atom');
;
?>
<?php list($content_type,$content) = prep_atom_text_construct(get_the_excerpt());
;
?>
	<summary type="<?php echo $content_type;
?>"><?php echo $content;
?></summary>
</entry>
<?php } }
function ok (  ) {
{log_app('Status','200: OK');
header('Content-Type: text/plain');
status_header('200');
exit();
} }
function no_content (  ) {
{log_app('Status','204: No Content');
header('Content-Type: text/plain');
status_header('204');
echo "Moved to Trash.";
exit();
} }
function internal_error ( $msg = 'Internal Server Error' ) {
{log_app('Status','500: Server Error');
header('Content-Type: text/plain');
status_header('500');
echo $msg;
exit();
} }
function bad_request (  ) {
{log_app('Status','400: Bad Request');
header('Content-Type: text/plain');
status_header('400');
exit();
} }
function length_required (  ) {
{log_app('Status','411: Length Required');
header("HTTP/1.1 411 Length Required");
header('Content-Type: text/plain');
status_header('411');
exit();
} }
function invalid_media (  ) {
{log_app('Status','415: Unsupported Media Type');
header("HTTP/1.1 415 Unsupported Media Type");
header('Content-Type: text/plain');
exit();
} }
function forbidden ( $reason = '' ) {
{log_app('Status','403: Forbidden');
header('Content-Type: text/plain');
status_header('403');
echo $reason;
exit();
} }
function not_found (  ) {
{log_app('Status','404: Not Found');
header('Content-Type: text/plain');
status_header('404');
exit();
} }
function not_allowed ( $allow ) {
{log_app('Status','405: Not Allowed');
header('Allow: ' . join(',',$allow));
status_header('405');
exit();
} }
function redirect ( $url ) {
{log_app('Status','302: Redirect');
$escaped_url = esc_attr($url);
$content = <<<EOD
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
  <head>
    <title>302 Found</title>
  </head>
<body>
  <h1>Found</h1>
  <p>The document has moved <a href="$escaped_url">here</a>.</p>
  </body>
</html>

EOD
;
header('HTTP/1.1 302 Moved');
header('Content-Type: text/html');
header('Location: ' . $url);
echo $content;
exit();
} }
function client_error ( $msg = 'Client Error' ) {
{log_app('Status','400: Client Error');
header('Content-Type: text/plain');
status_header('400');
exit();
} }
function created ( $post_ID,$content,$post_type = 'post' ) {
{log_app('created()::$post_ID',"$post_ID, $post_type");
$edit = $this->get_entry_url($post_ID);
switch ( $post_type ) {
case 'post':$ctloc = $this->get_entry_url($post_ID);
break ;
case 'attachment':$edit = $this->app_base . "attachments/$post_ID";
break ;
 }
header("Content-Type: $this->ATOM_CONTENT_TYPE");
if ( isset($ctloc))
 header('Content-Location: ' . $ctloc);
header('Location: ' . $edit);
status_header('201');
echo $content;
exit();
} }
function auth_required ( $msg ) {
{log_app('Status','401: Auth Required');
nocache_headers();
header('WWW-Authenticate: Basic realm="WordPress Atom Protocol"');
header("HTTP/1.1 401 $msg");
header('Status: 401 ' . $msg);
header('Content-Type: text/html');
$content = <<<EOD
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
  <head>
    <title>401 Unauthorized</title>
  </head>
<body>
    <h1>401 Unauthorized</h1>
    <p>$msg</p>
  </body>
</html>

EOD
;
echo $content;
exit();
} }
function output ( $xml,$ctype = 'application/atom+xml' ) {
{status_header('200');
$xml = '<?xml version="1.0" encoding="' . strtolower(get_option('blog_charset')) . '"?>' . "\n" . $xml;
header('Connection: close');
header('Content-Length: ' . strlen($xml));
header('Content-Type: ' . $ctype);
header('Content-Disposition: attachment; filename=atom.xml');
header('Date: ' . date('r'));
if ( $this->do_output)
 echo $xml;
log_app('function',"output:\n$xml");
exit();
} }
function escape ( &$array ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}foreach ( $array as $k =>$v )
{if ( is_array($v))
 {$this->escape($array[$k]);
}else 
{if ( is_object($v))
 {}else 
{{$array[$k] = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($v)),array(0));
}}}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function authenticate (  ) {
{log_app("authenticate()",print_r(deAspisWarningRC($_ENV),true));
if ( (isset($_SERVER[0]['HTTP_AUTHORIZATION']) && Aspis_isset($_SERVER[0]['HTTP_AUTHORIZATION'])))
 {list(deAspisWarningRC($_SERVER[0]['PHP_AUTH_USER']),deAspisWarningRC($_SERVER[0]['PHP_AUTH_PW'])) = explode(':',base64_decode(substr(deAspisWarningRC($_SERVER[0]['HTTP_AUTHORIZATION']),6)));
}else 
{if ( (isset($_SERVER[0]['REDIRECT_REMOTE_USER']) && Aspis_isset($_SERVER[0]['REDIRECT_REMOTE_USER'])))
 {list(deAspisWarningRC($_SERVER[0]['PHP_AUTH_USER']),deAspisWarningRC($_SERVER[0]['PHP_AUTH_PW'])) = explode(':',base64_decode(substr(deAspisWarningRC($_SERVER[0]['REDIRECT_REMOTE_USER']),6)));
}}if ( (isset($_SERVER[0]['PHP_AUTH_USER']) && Aspis_isset($_SERVER[0]['PHP_AUTH_USER'])) && (isset($_SERVER[0]['PHP_AUTH_PW']) && Aspis_isset($_SERVER[0]['PHP_AUTH_PW'])))
 {log_app("Basic Auth",deAspisWarningRC($_SERVER[0]['PHP_AUTH_USER']));
$user = wp_authenticate(deAspisWarningRC($_SERVER[0]['PHP_AUTH_USER']),deAspisWarningRC($_SERVER[0]['PHP_AUTH_PW']));
if ( $user && !is_wp_error($user))
 {wp_set_current_user($user->ID);
log_app("authenticate()",$user->user_login);
{$AspisRetTemp = true;
return $AspisRetTemp;
}}}{$AspisRetTemp = false;
return $AspisRetTemp;
}} }
function get_accepted_content_type ( $types = null ) {
{if ( !isset($types))
 {$types = $this->media_content_types;
}if ( !(isset($_SERVER[0]['CONTENT_LENGTH']) && Aspis_isset($_SERVER[0]['CONTENT_LENGTH'])) || !(isset($_SERVER[0]['CONTENT_TYPE']) && Aspis_isset($_SERVER[0]['CONTENT_TYPE'])))
 {$this->length_required();
}$type = deAspisWarningRC($_SERVER[0]['CONTENT_TYPE']);
list($type,$subtype) = explode('/',$type);
list($subtype) = explode(";",$subtype);
log_app("get_accepted_content_type","type=$type, subtype=$subtype");
foreach ( $types as $t  )
{list($acceptedType,$acceptedSubtype) = explode('/',$t);
if ( $acceptedType == '*' || $acceptedType == $type)
 {if ( $acceptedSubtype == '*' || $acceptedSubtype == $subtype)
 {$AspisRetTemp = $type . "/" . $subtype;
return $AspisRetTemp;
}}}$this->invalid_media();
} }
function process_conditionals (  ) {
{if ( empty($this->params))
 {return ;
}if ( deAspisWarningRC($_SERVER[0]['REQUEST_METHOD']) == 'DELETE')
 {return ;
}switch ( $this->params[0] ) {
case $this->ENTRY_PATH:{global $post;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $post,"\$post",$AspisChangesCache);
}$post = wp_get_single_post($this->params[1]);
$wp_last_modified = get_post_modified_time('D, d M Y H:i:s',true);
$post = NULL;
break ;
case $this->ENTRIES_PATH:$wp_last_modified = mysql2date('D, d M Y H:i:s',get_lastpostmodified('GMT'),0) . ' GMT';
break ;
default :{AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
return ;
} }
$wp_etag = md5($wp_last_modified);
@header("Last-Modified: $wp_last_modified");
@header("ETag: $wp_etag");
if ( (isset($_SERVER[0]['HTTP_IF_NONE_MATCH']) && Aspis_isset($_SERVER[0]['HTTP_IF_NONE_MATCH'])))
 $client_etag = stripslashes(deAspisWarningRC($_SERVER[0]['HTTP_IF_NONE_MATCH']));
else 
{$client_etag = false;
}$client_last_modified = trim(deAspisWarningRC($_SERVER[0]['HTTP_IF_MODIFIED_SINCE']));
$client_modified_timestamp = $client_last_modified ? strtotime($client_last_modified) : 0;
$wp_modified_timestamp = strtotime($wp_last_modified);
if ( ($client_last_modified && $client_etag) ? (($client_modified_timestamp >= $wp_modified_timestamp) && ($client_etag == $wp_etag)) : (($client_modified_timestamp >= $wp_modified_timestamp) || ($client_etag == $wp_etag)))
 {status_header(304);
exit();
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$post",$AspisChangesCache);
 }
function rfc3339_str2time ( $str ) {
{$match = false;
if ( !preg_match("/(\d{4}-\d{2}-\d{2})T(\d{2}\:\d{2}\:\d{2})\.?\d{0,3}(Z|[+-]+\d{2}\:\d{2})/",$str,$match))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( $match[3] == 'Z')
 $match[3] == '+0000';
{$AspisRetTemp = strtotime($match[1] . " " . $match[2] . " " . $match[3]);
return $AspisRetTemp;
}} }
function get_publish_time ( $published ) {
{$pubtime = $this->rfc3339_str2time($published);
if ( !$pubtime)
 {{$AspisRetTemp = array(current_time('mysql'),current_time('mysql',1));
return $AspisRetTemp;
}}else 
{{{$AspisRetTemp = array(date("Y-m-d H:i:s",$pubtime),gmdate("Y-m-d H:i:s",$pubtime));
return $AspisRetTemp;
}}}} }
}$server = new AtomServer();
$server->handle_request();
;
?>
<?php 