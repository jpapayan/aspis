<?php require_once('AspisMain.php'); ?><?php
define(('APP_REQUEST'),true);
require_once ('./wp-load.php');
require_once (deconcat2(concat12(ABSPATH,WPINC),'/atomlib.php'));
require_once (deconcat12(ABSPATH,'/wp-admin/includes/image.php'));
arrayAssign($_SERVER[0],deAspis(registerTaint(array('PATH_INFO',false))),addTaint(Aspis_preg_replace(array('/.*\/wp-app\.php/',false),array('',false),$_SERVER[0]['REQUEST_URI'])));
$app_logging = array(0,false);
$always_authenticate = array(1,false);
function log_app ( $label,$msg ) {
global $app_logging;
if ( $app_logging[0])
 {$fp = attAspis(fopen(('wp-app.log'),('a+')));
$date = attAspis(gmdate(('Y-m-d H:i:s')));
fwrite($fp[0],(deconcat2(concat(concat2(concat(concat2(concat1("\n\n",$date)," - "),$label),"\n"),$msg),"\n")));
fclose($fp[0]);
} }
function wa_posts_where_include_drafts_filter ( $where ) {
$where = Aspis_str_replace(array("post_status = 'publish'",false),array("post_status = 'publish' OR post_status = 'future' OR post_status = 'draft' OR post_status = 'inherit'",false),$where);
return $where;
 }
add_filter(array('posts_where',false),array('wa_posts_where_include_drafts_filter',false));
class AtomServer{var $ATOM_CONTENT_TYPE = array('application/atom+xml',false);
var $CATEGORIES_CONTENT_TYPE = array('application/atomcat+xml',false);
var $SERVICE_CONTENT_TYPE = array('application/atomsvc+xml',false);
var $ATOM_NS = array('http://www.w3.org/2005/Atom',false);
var $ATOMPUB_NS = array('http://www.w3.org/2007/app',false);
var $ENTRIES_PATH = array("posts",false);
var $CATEGORIES_PATH = array("categories",false);
var $MEDIA_PATH = array("attachments",false);
var $ENTRY_PATH = array("post",false);
var $SERVICE_PATH = array("service",false);
var $MEDIA_SINGLE_PATH = array("attachment",false);
var $params = array(array(),false);
var $media_content_types = array(array(array('image/*',false),array('audio/*',false),array('video/*',false)),false);
var $atom_content_types = array(array(array('application/atom+xml',false)),false);
var $selectors = array(array(),false);
var $do_output = array(true,false);
function AtomServer (  ) {
{$this->script_name = Aspis_array_pop(Aspis_explode(array('/',false),$_SERVER[0]['SCRIPT_NAME']));
$this->app_base = concat2(concat(concat2(get_bloginfo(array('url',false)),'/'),$this->script_name),'/');
if ( (((isset($_SERVER[0][('HTTPS')]) && Aspis_isset( $_SERVER [0][('HTTPS')]))) && (deAspis(Aspis_strtolower($_SERVER[0]['HTTPS'])) == ('on'))))
 {$this->app_base = Aspis_preg_replace(array('/^http:\/\//',false),array('https://',false),$this->app_base);
}$this->selectors = array(array('@/service$@' => array(array('GET' => array('get_service',false,false)),false,false),'@/categories$@' => array(array('GET' => array('get_categories_xml',false,false)),false,false),'@/post/(\d+)$@' => array(array('GET' => array('get_post',false,false),'PUT' => array('put_post',false,false),'DELETE' => array('delete_post',false,false)),false,false),'@/posts/?(\d+)?$@' => array(array('GET' => array('get_posts',false,false),'POST' => array('create_post',false,false)),false,false),'@/attachments/?(\d+)?$@' => array(array('GET' => array('get_attachment',false,false),'POST' => array('create_attachment',false,false)),false,false),'@/attachment/file/(\d+)$@' => array(array('GET' => array('get_file',false,false),'PUT' => array('put_file',false,false),'DELETE' => array('delete_file',false,false)),false,false),'@/attachment/(\d+)$@' => array(array('GET' => array('get_attachment',false,false),'PUT' => array('put_attachment',false,false),'DELETE' => array('delete_attachment',false,false)),false,false),),false);
} }
function handle_request (  ) {
{global $always_authenticate;
if ( (!((empty($_SERVER[0][('ORIG_PATH_INFO')]) || Aspis_empty( $_SERVER [0][('ORIG_PATH_INFO')])))))
 $path = $_SERVER[0]['ORIG_PATH_INFO'];
else 
{$path = $_SERVER[0]['PATH_INFO'];
}$method = $_SERVER[0]['REQUEST_METHOD'];
log_app(array('REQUEST',false),concat2(concat(concat2($method," "),$path),"\n================"));
$this->process_conditionals();
if ( ($method[0] == ('HEAD')))
 {$this->do_output = array(false,false);
$method = array('GET',false);
}if ( ((strlen($path[0]) == (0)) || ($path[0] == ('/'))))
 {$this->redirect($this->get_service_url());
}if ( (denot_boolean(get_option(array('enable_app',false)))))
 $this->forbidden(Aspis_sprintf(__(array('AtomPub services are disabled on this blog.  An admin user can enable them at %s',false)),admin_url(array('options-writing.php',false))));
foreach ( $this->selectors[0] as $regex =>$funcs )
{restoreTaint($regex,$funcs);
{if ( deAspis(Aspis_preg_match($regex,$path,$matches)))
 {if ( ((isset($funcs[0][$method[0]]) && Aspis_isset( $funcs [0][$method[0]]))))
 {if ( (denot_boolean($this->authenticate())))
 {if ( $always_authenticate[0])
 {$this->auth_required(array('Credentials required.',false));
}}Aspis_array_shift($matches);
Aspis_call_user_func_array(array(array(array($this,false),attachAspis($funcs,$method[0])),false),$matches);
Aspis_exit();
}else 
{{$this->not_allowed(attAspisRC(array_keys(deAspisRC($funcs))));
}}}}}$this->not_found();
} }
function get_service (  ) {
{log_app(array('function',false),array('get_service()',false));
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 $this->auth_required(__(array('Sorry, you do not have the right to access this blog.',false)));
$entries_url = esc_attr($this->get_entries_url());
$categories_url = esc_attr($this->get_categories_url());
$media_url = esc_attr($this->get_attachments_url());
$accepted_media_types = array('',false);
foreach ( $this->media_content_types[0] as $med  )
{$accepted_media_types = concat2(concat(concat2($accepted_media_types,"<accept>"),$med),"</accept>");
}$atom_prefix = array("atom",false);
$atom_blogname = get_bloginfo(array('name',false));
$service_doc = concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat(concat2(concat1(<<<EOD_PHPAspis_Part0
<service xmlns="
EOD_PHPAspis_Part0
,$this->ATOMPUB_NS),<<<EOD_PHPAspis_Part1
" xmlns:
EOD_PHPAspis_Part1
),$atom_prefix),<<<EOD_PHPAspis_Part2
="
EOD_PHPAspis_Part2
),$this->ATOM_NS),<<<EOD_PHPAspis_Part3
">
  <workspace>
    <
EOD_PHPAspis_Part3
),$atom_prefix),<<<EOD_PHPAspis_Part4
:title>
EOD_PHPAspis_Part4
),$atom_blogname),<<<EOD_PHPAspis_Part5
 Workspace</
EOD_PHPAspis_Part5
),$atom_prefix),<<<EOD_PHPAspis_Part6
:title>
    <collection href="
EOD_PHPAspis_Part6
),$entries_url),<<<EOD_PHPAspis_Part7
">
      <
EOD_PHPAspis_Part7
),$atom_prefix),<<<EOD_PHPAspis_Part8
:title>
EOD_PHPAspis_Part8
),$atom_blogname),<<<EOD_PHPAspis_Part9
 Posts</
EOD_PHPAspis_Part9
),$atom_prefix),<<<EOD_PHPAspis_Part10
:title>
      <accept>
EOD_PHPAspis_Part10
),$this->ATOM_CONTENT_TYPE),<<<EOD_PHPAspis_Part11
;type=entry</accept>
      <categories href="
EOD_PHPAspis_Part11
),$categories_url),<<<EOD_PHPAspis_Part12
" />
    </collection>
    <collection href="
EOD_PHPAspis_Part12
),$media_url),<<<EOD_PHPAspis_Part13
">
      <
EOD_PHPAspis_Part13
),$atom_prefix),<<<EOD_PHPAspis_Part14
:title>
EOD_PHPAspis_Part14
),$atom_blogname),<<<EOD_PHPAspis_Part15
 Media</
EOD_PHPAspis_Part15
),$atom_prefix),<<<EOD_PHPAspis_Part16
:title>
      
EOD_PHPAspis_Part16
),$accepted_media_types),<<<EOD_PHPAspis_Part17

    </collection>
  </workspace>
</service>

EOD_PHPAspis_Part17
);
$this->output($service_doc,$this->SERVICE_CONTENT_TYPE);
} }
function get_categories_xml (  ) {
{log_app(array('function',false),array('get_categories_xml()',false));
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 $this->auth_required(__(array('Sorry, you do not have the right to access this blog.',false)));
$home = esc_attr(get_bloginfo_rss(array('home',false)));
$categories = array("",false);
$cats = get_categories(array("hierarchical=0&hide_empty=0",false));
foreach ( deAspis(array_cast($cats)) as $cat  )
{$categories = concat($categories,concat2(concat1("    <category term=\"",esc_attr($cat[0]->name)),"\" />\n"));
}$output = concat2(concat(concat2(concat(concat2(concat(concat2(concat1(<<<EOD_PHPAspis_Part0
<app:categories xmlns:app="
EOD_PHPAspis_Part0
,$this->ATOMPUB_NS),<<<EOD_PHPAspis_Part1
"
	xmlns="
EOD_PHPAspis_Part1
),$this->ATOM_NS),<<<EOD_PHPAspis_Part2
"
	fixed="yes" scheme="
EOD_PHPAspis_Part2
),$home),<<<EOD_PHPAspis_Part3
">
	
EOD_PHPAspis_Part3
),$categories),<<<EOD_PHPAspis_Part4

</app:categories>
EOD_PHPAspis_Part4
);
$this->output($output,$this->CATEGORIES_CONTENT_TYPE);
} }
function create_post (  ) {
{global $blog_id,$user_ID;
$this->get_accepted_content_type($this->atom_content_types);
$parser = array(new AtomParser(),false);
if ( (denot_boolean($parser[0]->parse())))
 {$this->client_error();
}$entry = Aspis_array_pop($parser[0]->feed[0]->entries);
log_app(array('Received entry:',false),Aspis_print_r($entry,array(true,false)));
$catnames = array(array(),false);
foreach ( $entry[0]->categories[0] as $cat  )
Aspis_array_push($catnames,$cat[0]["term"]);
$wp_cats = get_categories(array(array('hide_empty' => array(false,false,false)),false));
$post_category = array(array(),false);
foreach ( $wp_cats[0] as $cat  )
{if ( deAspis(Aspis_in_array($cat[0]->name,$catnames)))
 Aspis_array_push($post_category,$cat[0]->term_id);
}$publish = (((isset($entry[0]->draft) && Aspis_isset( $entry[0] ->draft ))) && (deAspis(Aspis_trim($entry[0]->draft)) == ('yes'))) ? array(false,false) : array(true,false);
$cap = deAspis(($publish)) ? array('publish_posts',false) : array('edit_posts',false);
if ( (denot_boolean(current_user_can($cap))))
 $this->auth_required(__(array('Sorry, you do not have the right to edit/publish new posts.',false)));
$blog_ID = int_cast($blog_id);
$post_status = deAspis(($publish)) ? array('publish',false) : array('draft',false);
$post_author = int_cast($user_ID);
$post_title = $entry[0]->title[0][(1)];
$post_content = $entry[0]->content[0][(1)];
$post_excerpt = $entry[0]->summary[0][(1)];
$pubtimes = $this->get_publish_time($entry[0]->published);
$post_date = attachAspis($pubtimes,(0));
$post_date_gmt = attachAspis($pubtimes,(1));
if ( ((isset($_SERVER[0][('HTTP_SLUG')]) && Aspis_isset( $_SERVER [0][('HTTP_SLUG')]))))
 $post_name = $_SERVER[0]['HTTP_SLUG'];
$post_data = array(compact('blog_ID','post_author','post_date','post_date_gmt','post_content','post_title','post_category','post_status','post_excerpt','post_name'),false);
$this->escape($post_data);
log_app(array('Inserting Post. Data:',false),Aspis_print_r($post_data,array(true,false)));
$postID = wp_insert_post($post_data);
if ( deAspis(is_wp_error($postID)))
 $this->internal_error($postID[0]->get_error_message());
if ( (denot_boolean($postID)))
 $this->internal_error(__(array('Sorry, your entry could not be posted. Something wrong happened.',false)));
@wp_set_post_categories($postID,$post_category);
do_action(array('atompub_create_post',false),$postID,$entry);
$output = $this->get_entry($postID);
log_app(array('function',false),concat2(concat1("create_post(",$postID),")"));
$this->created($postID,$output);
} }
function get_post ( $postID ) {
{global $entry;
if ( (denot_boolean(current_user_can(array('edit_post',false),$postID))))
 $this->auth_required(__(array('Sorry, you do not have the right to access this post.',false)));
$this->set_current_entry($postID);
$output = $this->get_entry($postID);
log_app(array('function',false),concat2(concat1("get_post(",$postID),")"));
$this->output($output);
} }
function put_post ( $postID ) {
{$this->get_accepted_content_type($this->atom_content_types);
$parser = array(new AtomParser(),false);
if ( (denot_boolean($parser[0]->parse())))
 {$this->bad_request();
}$parsed = Aspis_array_pop($parser[0]->feed[0]->entries);
log_app(array('Received UPDATED entry:',false),Aspis_print_r($parsed,array(true,false)));
global $entry;
$this->set_current_entry($postID);
if ( (denot_boolean(current_user_can(array('edit_post',false),$entry[0]['ID']))))
 $this->auth_required(__(array('Sorry, you do not have the right to edit this post.',false)));
$publish = (((isset($parsed[0]->draft) && Aspis_isset( $parsed[0] ->draft ))) && (deAspis(Aspis_trim($parsed[0]->draft)) == ('yes'))) ? array(false,false) : array(true,false);
$post_status = deAspis(($publish)) ? array('publish',false) : array('draft',false);
extract(($entry[0]));
$post_title = $parsed[0]->title[0][(1)];
$post_content = $parsed[0]->content[0][(1)];
$post_excerpt = $parsed[0]->summary[0][(1)];
$pubtimes = $this->get_publish_time($entry[0]->published);
$post_date = attachAspis($pubtimes,(0));
$post_date_gmt = attachAspis($pubtimes,(1));
$pubtimes = $this->get_publish_time($parsed[0]->updated);
$post_modified = attachAspis($pubtimes,(0));
$post_modified_gmt = attachAspis($pubtimes,(1));
$postdata = array(compact('ID','post_content','post_title','post_category','post_status','post_excerpt','post_date','post_date_gmt','post_modified','post_modified_gmt'),false);
$this->escape($postdata);
$result = wp_update_post($postdata);
if ( (denot_boolean($result)))
 {$this->internal_error(__(array('For some strange yet very annoying reason, this post could not be edited.',false)));
}do_action(array('atompub_put_post',false),$ID,$parsed);
log_app(array('function',false),concat2(concat1("put_post(",$postID),")"));
$this->ok();
} }
function delete_post ( $postID ) {
{global $entry;
$this->set_current_entry($postID);
if ( (denot_boolean(current_user_can(array('edit_post',false),$postID))))
 {$this->auth_required(__(array('Sorry, you do not have the right to delete this post.',false)));
}if ( (deAspis($entry[0]['post_type']) == ('attachment')))
 {$this->delete_attachment($postID);
}else 
{{$result = wp_delete_post($postID);
if ( (denot_boolean($result)))
 {$this->internal_error(__(array('For some strange yet very annoying reason, this post could not be deleted.',false)));
}log_app(array('function',false),concat2(concat1("delete_post(",$postID),")"));
$this->ok();
}}} }
function get_attachment ( $postID = array(null,false) ) {
{if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 $this->auth_required(__(array('Sorry, you do not have permission to upload files.',false)));
if ( (!((isset($postID) && Aspis_isset( $postID)))))
 {$this->get_attachments();
}else 
{{$this->set_current_entry($postID);
$output = $this->get_entry($postID,array('attachment',false));
log_app(array('function',false),concat2(concat1("get_attachment(",$postID),")"));
$this->output($output);
}}} }
function create_attachment (  ) {
{$type = $this->get_accepted_content_type();
if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 $this->auth_required(__(array('You do not have permission to upload files.',false)));
$fp = attAspis(fopen(("php://input"),("rb")));
$bits = array(null,false);
while ( (!(feof($fp[0]))) )
{$bits = concat($bits,attAspis(fread($fp[0],(4096))));
}fclose($fp[0]);
$slug = array('',false);
if ( ((isset($_SERVER[0][('HTTP_SLUG')]) && Aspis_isset( $_SERVER [0][('HTTP_SLUG')]))))
 $slug = sanitize_file_name($_SERVER[0]['HTTP_SLUG']);
elseif ( ((isset($_SERVER[0][('HTTP_TITLE')]) && Aspis_isset( $_SERVER [0][('HTTP_TITLE')]))))
 $slug = sanitize_file_name($_SERVER[0]['HTTP_TITLE']);
elseif ( ((empty($slug) || Aspis_empty( $slug))))
 $slug = Aspis_substr(attAspis(md5(uniqid(deAspisRC(attAspisRC(microtime()))))),array(0,false),array(7,false));
$ext = Aspis_preg_replace(array('|.*/([a-z0-9]+)|',false),array('$1',false),$_SERVER[0]['CONTENT_TYPE']);
$slug = concat(concat2($slug,"."),$ext);
$file = wp_upload_bits($slug,array(NULL,false),$bits);
log_app(array('wp_upload_bits returns:',false),Aspis_print_r($file,array(true,false)));
$url = $file[0]['url'];
$file = $file[0]['file'];
do_action(array('wp_create_file_in_uploads',false),$file);
$attachment = array(array(deregisterTaint(array('post_title',false)) => addTaint($slug),deregisterTaint(array('post_content',false)) => addTaint($slug),'post_status' => array('attachment',false,false),'post_parent' => array(0,false,false),deregisterTaint(array('post_mime_type',false)) => addTaint($type),deregisterTaint(array('guid',false)) => addTaint($url)),false);
$postID = wp_insert_attachment($attachment,$file);
if ( (denot_boolean($postID)))
 $this->internal_error(__(array('Sorry, your entry could not be posted. Something wrong happened.',false)));
$output = $this->get_entry($postID,array('attachment',false));
$this->created($postID,$output,array('attachment',false));
log_app(array('function',false),concat2(concat1("create_attachment(",$postID),")"));
} }
function put_attachment ( $postID ) {
{$this->get_accepted_content_type($this->atom_content_types);
$parser = array(new AtomParser(),false);
if ( (denot_boolean($parser[0]->parse())))
 {$this->bad_request();
}$parsed = Aspis_array_pop($parser[0]->feed[0]->entries);
global $entry;
$this->set_current_entry($postID);
if ( (denot_boolean(current_user_can(array('edit_post',false),$entry[0]['ID']))))
 $this->auth_required(__(array('Sorry, you do not have the right to edit this post.',false)));
extract(($entry[0]));
$post_title = $parsed[0]->title[0][(1)];
$post_content = $parsed[0]->summary[0][(1)];
$pubtimes = $this->get_publish_time($parsed[0]->updated);
$post_modified = attachAspis($pubtimes,(0));
$post_modified_gmt = attachAspis($pubtimes,(1));
$postdata = array(compact('ID','post_content','post_title','post_category','post_status','post_excerpt','post_modified','post_modified_gmt'),false);
$this->escape($postdata);
$result = wp_update_post($postdata);
if ( (denot_boolean($result)))
 {$this->internal_error(__(array('For some strange yet very annoying reason, this post could not be edited.',false)));
}log_app(array('function',false),concat2(concat1("put_attachment(",$postID),")"));
$this->ok();
} }
function delete_attachment ( $postID ) {
{log_app(array('function',false),concat2(concat(concat2(concat1("delete_attachment(",$postID),"). File '"),$location),"' deleted."));
global $entry;
$this->set_current_entry($postID);
if ( (denot_boolean(current_user_can(array('edit_post',false),$postID))))
 {$this->auth_required(__(array('Sorry, you do not have the right to delete this post.',false)));
}$location = get_post_meta($entry[0]['ID'],array('_wp_attached_file',false),array(true,false));
$filetype = wp_check_filetype($location);
if ( (((!((isset($location) && Aspis_isset( $location)))) || (('attachment') != deAspis($entry[0]['post_type']))) || ((empty($filetype[0][('ext')]) || Aspis_empty( $filetype [0][('ext')])))))
 $this->internal_error(__(array('Error ocurred while accessing post metadata for file location.',false)));
@attAspis(unlink($location[0]));
$result = wp_delete_post($postID);
if ( (denot_boolean($result)))
 {$this->internal_error(__(array('For some strange yet very annoying reason, this post could not be deleted.',false)));
}log_app(array('function',false),concat2(concat(concat2(concat1("delete_attachment(",$postID),"). File '"),$location),"' deleted."));
$this->ok();
} }
function get_file ( $postID ) {
{global $entry;
$this->set_current_entry($postID);
if ( (denot_boolean(current_user_can(array('edit_post',false),$postID))))
 {$this->auth_required(__(array('Sorry, you do not have the right to edit this post.',false)));
}$location = get_post_meta($entry[0]['ID'],array('_wp_attached_file',false),array(true,false));
$location = concat(concat2(get_option(array('upload_path',false)),'/'),$location);
$filetype = wp_check_filetype($location);
if ( (((!((isset($location) && Aspis_isset( $location)))) || (('attachment') != deAspis($entry[0]['post_type']))) || ((empty($filetype[0][('ext')]) || Aspis_empty( $filetype [0][('ext')])))))
 $this->internal_error(__(array('Error ocurred while accessing post metadata for file location.',false)));
status_header(array('200',false));
header((deconcat1('Content-Type: ',$entry[0]['post_mime_type'])));
header(('Connection: close'));
if ( deAspis($fp = attAspis(fopen($location[0],("rb")))))
 {status_header(array('200',false));
header((deconcat1('Content-Type: ',$entry[0]['post_mime_type'])));
header(('Connection: close'));
while ( (!(feof($fp[0]))) )
{echo AspisCheckPrint(attAspis(fread($fp[0],(4096))));
}fclose($fp[0]);
}else 
{{status_header(array('404',false));
}}log_app(array('function',false),concat2(concat1("get_file(",$postID),")"));
Aspis_exit();
} }
function put_file ( $postID ) {
{if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 $this->auth_required(__(array('You do not have permission to upload files.',false)));
global $entry;
$this->set_current_entry($postID);
if ( (denot_boolean(current_user_can(array('edit_post',false),$postID))))
 {$this->auth_required(__(array('Sorry, you do not have the right to edit this post.',false)));
}$upload_dir = wp_upload_dir();
$location = get_post_meta($entry[0]['ID'],array('_wp_attached_file',false),array(true,false));
$filetype = wp_check_filetype($location);
$location = concat(concat2($upload_dir[0]['basedir'],"/"),$location);
if ( (((!((isset($location) && Aspis_isset( $location)))) || (('attachment') != deAspis($entry[0]['post_type']))) || ((empty($filetype[0][('ext')]) || Aspis_empty( $filetype [0][('ext')])))))
 $this->internal_error(__(array('Error ocurred while accessing post metadata for file location.',false)));
$fp = attAspis(fopen(("php://input"),("rb")));
$localfp = attAspis(fopen($location[0],("w+")));
while ( (!(feof($fp[0]))) )
{fwrite($localfp[0],fread($fp[0],(4096)));
}fclose($fp[0]);
fclose($localfp[0]);
$ID = $entry[0]['ID'];
$pubtimes = $this->get_publish_time($entry[0]->published);
$post_date = attachAspis($pubtimes,(0));
$post_date_gmt = attachAspis($pubtimes,(1));
$pubtimes = $this->get_publish_time($parsed[0]->updated);
$post_modified = attachAspis($pubtimes,(0));
$post_modified_gmt = attachAspis($pubtimes,(1));
$post_data = array(compact('ID','post_date','post_date_gmt','post_modified','post_modified_gmt'),false);
$result = wp_update_post($post_data);
if ( (denot_boolean($result)))
 {$this->internal_error(__(array('Sorry, your entry could not be posted. Something wrong happened.',false)));
}wp_update_attachment_metadata($postID,wp_generate_attachment_metadata($postID,$location));
log_app(array('function',false),concat2(concat1("put_file(",$postID),")"));
$this->ok();
} }
function get_entries_url ( $page = array(null,false) ) {
{if ( (((isset($GLOBALS[0][('post_type')]) && Aspis_isset( $GLOBALS [0][('post_type')]))) && (deAspis($GLOBALS[0]['post_type']) == ('attachment'))))
 {$path = $this->MEDIA_PATH;
}else 
{{$path = $this->ENTRIES_PATH;
}}$url = concat($this->app_base,$path);
if ( (((isset($page) && Aspis_isset( $page))) && is_int(deAspisRC($page))))
 {$url = concat($url,concat1("/",$page));
}return $url;
} }
function the_entries_url ( $page = array(null,false) ) {
{echo AspisCheckPrint($this->get_entries_url($page));
} }
function get_categories_url ( $deprecated = array('',false) ) {
{return concat($this->app_base,$this->CATEGORIES_PATH);
} }
function the_categories_url (  ) {
{echo AspisCheckPrint($this->get_categories_url());
} }
function get_attachments_url ( $page = array(null,false) ) {
{$url = concat($this->app_base,$this->MEDIA_PATH);
if ( (((isset($page) && Aspis_isset( $page))) && is_int(deAspisRC($page))))
 {$url = concat($url,concat1("/",$page));
}return $url;
} }
function the_attachments_url ( $page = array(null,false) ) {
{echo AspisCheckPrint($this->get_attachments_url($page));
} }
function get_service_url (  ) {
{return concat($this->app_base,$this->SERVICE_PATH);
} }
function get_entry_url ( $postID = array(null,false) ) {
{if ( (!((isset($postID) && Aspis_isset( $postID)))))
 {global $post;
$postID = int_cast($post[0]->ID);
}$url = concat(concat($this->app_base,$this->ENTRY_PATH),concat1("/",$postID));
log_app(array('function',false),concat1("get_entry_url() = ",$url));
return $url;
} }
function the_entry_url ( $postID = array(null,false) ) {
{echo AspisCheckPrint($this->get_entry_url($postID));
} }
function get_media_url ( $postID = array(null,false) ) {
{if ( (!((isset($postID) && Aspis_isset( $postID)))))
 {global $post;
$postID = int_cast($post[0]->ID);
}$url = concat(concat($this->app_base,$this->MEDIA_SINGLE_PATH),concat1("/file/",$postID));
log_app(array('function',false),concat1("get_media_url() = ",$url));
return $url;
} }
function the_media_url ( $postID = array(null,false) ) {
{echo AspisCheckPrint($this->get_media_url($postID));
} }
function set_current_entry ( $postID ) {
{global $entry;
log_app(array('function',false),concat2(concat1("set_current_entry(",$postID),")"));
if ( (!((isset($postID) && Aspis_isset( $postID)))))
 {$this->not_found();
}$entry = wp_get_single_post($postID,array(ARRAY_A,false));
if ( ((!((isset($entry) && Aspis_isset( $entry)))) || (!((isset($entry[0][('ID')]) && Aspis_isset( $entry [0][('ID')]))))))
 $this->not_found();
return ;
} }
function get_posts ( $page = array(1,false),$post_type = array('post',false) ) {
{log_app(array('function',false),concat2(concat(concat2(concat1("get_posts(",$page),", '"),$post_type),"')"));
$feed = $this->get_feed($page,$post_type);
$this->output($feed);
} }
function get_attachments ( $page = array(1,false),$post_type = array('attachment',false) ) {
{log_app(array('function',false),concat2(concat(concat2(concat1("get_attachments(",$page),", '"),$post_type),"')"));
arrayAssign($GLOBALS[0],deAspis(registerTaint(array('post_type',false))),addTaint($post_type));
$feed = $this->get_feed($page,$post_type);
$this->output($feed);
} }
function get_feed ( $page = array(1,false),$post_type = array('post',false) ) {
{global $post,$wp,$wp_query,$posts,$wpdb,$blog_id;
log_app(array('function',false),concat2(concat(concat2(concat1("get_feed(",$page),", '"),$post_type),"')"));
ob_start();
$this->ENTRY_PATH = $post_type;
if ( (!((isset($page) && Aspis_isset( $page)))))
 {$page = array(1,false);
}$page = int_cast($page);
$count = get_option(array('posts_per_rss',false));
wp(concat(concat2(concat1('posts_per_page=',$count),'&offset='),(concat12($count[0] * ($page[0] - (1)),'&orderby=modified'))));
$post = $GLOBALS[0]['post'];
$posts = $GLOBALS[0]['posts'];
$wp = $GLOBALS[0]['wp'];
$wp_query = $GLOBALS[0]['wp_query'];
$wpdb = $GLOBALS[0]['wpdb'];
$blog_id = int_cast($GLOBALS[0]['blog_id']);
log_app(array('function',false),concat2(concat1("query_posts(# ",Aspis_print_r($wp_query,array(true,false))),"#)"));
log_app(array('function',false),concat2(concat1("total_count(# ",$wp_query[0]->max_num_pages)," #)"));
$last_page = $wp_query[0]->max_num_pages;
$next_page = (($page[0] + (1)) > $last_page[0]) ? array(NULL,false) : array($page[0] + (1),false);
$prev_page = (($page[0] - (1)) < (1)) ? array(NULL,false) : array($page[0] - (1),false);
$last_page = ((deAspis(int_cast($last_page)) == (1)) || (deAspis(int_cast($last_page)) == (0))) ? array(NULL,false) : int_cast($last_page);
$self_page = ($page[0] > (1)) ? $page : array(NULL,false);
;
?><feed xmlns="<?php echo AspisCheckPrint($this->ATOM_NS);
?>" xmlns:app="<?php echo AspisCheckPrint($this->ATOMPUB_NS);
?>" xml:lang="<?php echo AspisCheckPrint(get_option(array('rss_language',false)));
;
?>">
<id><?php $this->the_entries_url();
?></id>
<updated><?php echo AspisCheckPrint(mysql2date(array('Y-m-d\TH:i:s\Z',false),get_lastpostmodified(array('GMT',false)),array(false,false)));
;
?></updated>
<title type="text"><?php bloginfo_rss(array('name',false));
?></title>
<subtitle type="text"><?php bloginfo_rss(array("description",false));
?></subtitle>
<link rel="first" type="<?php echo AspisCheckPrint($this->ATOM_CONTENT_TYPE);
?>" href="<?php $this->the_entries_url();
?>" />
<?php if ( ((isset($prev_page) && Aspis_isset( $prev_page))))
 {;
?>
<link rel="previous" type="<?php echo AspisCheckPrint($this->ATOM_CONTENT_TYPE);
?>" href="<?php $this->the_entries_url($prev_page);
?>" />
<?php };
?>
<?php if ( ((isset($next_page) && Aspis_isset( $next_page))))
 {;
?>
<link rel="next" type="<?php echo AspisCheckPrint($this->ATOM_CONTENT_TYPE);
?>" href="<?php $this->the_entries_url($next_page);
?>" />
<?php };
?>
<link rel="last" type="<?php echo AspisCheckPrint($this->ATOM_CONTENT_TYPE);
?>" href="<?php $this->the_entries_url($last_page);
?>" />
<link rel="self" type="<?php echo AspisCheckPrint($this->ATOM_CONTENT_TYPE);
?>" href="<?php $this->the_entries_url($self_page);
?>" />
<rights type="text">Copyright <?php echo AspisCheckPrint(attAspis(date(('Y'))));
;
?></rights>
<?php the_generator(array('atom',false));
;
?>
<?php if ( deAspis(have_posts()))
 {while ( deAspis(have_posts()) )
{the_post();
$this->echo_entry();
}};
?></feed>
<?php $feed = attAspis(ob_get_contents());
ob_end_clean();
return $feed;
} }
function get_entry ( $postID,$post_type = array('post',false) ) {
{log_app(array('function',false),concat2(concat(concat2(concat1("get_entry(",$postID),", '"),$post_type),"')"));
ob_start();
switch ( $post_type[0] ) {
case ('post'):$varname = array('p',false);
break ;
case ('attachment'):$this->ENTRY_PATH = array('attachment',false);
$varname = array('attachment_id',false);
break ;
 }
query_posts(concat(concat2($varname,'='),$postID));
if ( deAspis(have_posts()))
 {while ( deAspis(have_posts()) )
{the_post();
$this->echo_entry();
log_app(array('$post',false),Aspis_print_r($GLOBALS[0]['post'],array(true,false)));
$entry = attAspis(ob_get_contents());
break ;
}}ob_end_clean();
log_app(array('get_entry returning:',false),$entry);
return $entry;
} }
function echo_entry (  ) {
{;
?>
<entry xmlns="<?php echo AspisCheckPrint($this->ATOM_NS);
?>"
       xmlns:app="<?php echo AspisCheckPrint($this->ATOMPUB_NS);
?>" xml:lang="<?php echo AspisCheckPrint(get_option(array('rss_language',false)));
;
?>">
	<id><?php the_guid($GLOBALS[0][('post')][0]->ID);
;
?></id>
<?php list($content_type,$content) = deAspisList(prep_atom_text_construct(get_the_title()),array());
;
?>
	<title type="<?php echo AspisCheckPrint($content_type);
?>"><?php echo AspisCheckPrint($content);
?></title>
	<updated><?php echo AspisCheckPrint(get_post_modified_time(array('Y-m-d\TH:i:s\Z',false),array(true,false)));
;
?></updated>
	<published><?php echo AspisCheckPrint(get_post_time(array('Y-m-d\TH:i:s\Z',false),array(true,false)));
;
?></published>
	<app:edited><?php echo AspisCheckPrint(get_post_modified_time(array('Y-m-d\TH:i:s\Z',false),array(true,false)));
;
?></app:edited>
	<app:control>
		<app:draft><?php echo AspisCheckPrint((($GLOBALS[0][('post')][0]->post_status[0] == ('draft')) ? array('yes',false) : array('no',false)));
?></app:draft>
	</app:control>
	<author>
		<name><?php the_author();
?></name>
<?php if ( (deAspis(get_the_author_meta(array('url',false))) && (deAspis(get_the_author_meta(array('url',false))) != ('http://'))))
 {;
?>
		<uri><?php the_author_meta(array('url',false));
?></uri>
<?php };
?>
	</author>
<?php if ( ($GLOBALS[0][('post')][0]->post_type[0] == ('attachment')))
 {;
?>
	<link rel="edit-media" href="<?php $this->the_media_url();
?>" />
	<content type="<?php echo AspisCheckPrint($GLOBALS[0][('post')][0]->post_mime_type);
?>" src="<?php the_guid();
;
?>"/>
<?php }else 
{{;
?>
	<link href="<?php the_permalink_rss();
?>" />
<?php if ( strlen($GLOBALS[0][('post')][0]->post_content[0]))
 {list($content_type,$content) = deAspisList(prep_atom_text_construct(get_the_content()),array());
;
?>
	<content type="<?php echo AspisCheckPrint($content_type);
?>"><?php echo AspisCheckPrint($content);
?></content>
<?php };
?>
<?php }};
?>
	<link rel="edit" href="<?php $this->the_entry_url();
?>" />
	<?php the_category_rss(array('atom',false));
;
?>
<?php list($content_type,$content) = deAspisList(prep_atom_text_construct(get_the_excerpt()),array());
;
?>
	<summary type="<?php echo AspisCheckPrint($content_type);
?>"><?php echo AspisCheckPrint($content);
?></summary>
</entry>
<?php } }
function ok (  ) {
{log_app(array('Status',false),array('200: OK',false));
header(('Content-Type: text/plain'));
status_header(array('200',false));
Aspis_exit();
} }
function no_content (  ) {
{log_app(array('Status',false),array('204: No Content',false));
header(('Content-Type: text/plain'));
status_header(array('204',false));
echo AspisCheckPrint(array("Moved to Trash.",false));
Aspis_exit();
} }
function internal_error ( $msg = array('Internal Server Error',false) ) {
{log_app(array('Status',false),array('500: Server Error',false));
header(('Content-Type: text/plain'));
status_header(array('500',false));
echo AspisCheckPrint($msg);
Aspis_exit();
} }
function bad_request (  ) {
{log_app(array('Status',false),array('400: Bad Request',false));
header(('Content-Type: text/plain'));
status_header(array('400',false));
Aspis_exit();
} }
function length_required (  ) {
{log_app(array('Status',false),array('411: Length Required',false));
header(("HTTP/1.1 411 Length Required"));
header(('Content-Type: text/plain'));
status_header(array('411',false));
Aspis_exit();
} }
function invalid_media (  ) {
{log_app(array('Status',false),array('415: Unsupported Media Type',false));
header(("HTTP/1.1 415 Unsupported Media Type"));
header(('Content-Type: text/plain'));
Aspis_exit();
} }
function forbidden ( $reason = array('',false) ) {
{log_app(array('Status',false),array('403: Forbidden',false));
header(('Content-Type: text/plain'));
status_header(array('403',false));
echo AspisCheckPrint($reason);
Aspis_exit();
} }
function not_found (  ) {
{log_app(array('Status',false),array('404: Not Found',false));
header(('Content-Type: text/plain'));
status_header(array('404',false));
Aspis_exit();
} }
function not_allowed ( $allow ) {
{log_app(array('Status',false),array('405: Not Allowed',false));
header((deconcat1('Allow: ',Aspis_join(array(',',false),$allow))));
status_header(array('405',false));
Aspis_exit();
} }
function redirect ( $url ) {
{log_app(array('Status',false),array('302: Redirect',false));
$escaped_url = esc_attr($url);
$content = concat2(concat1(<<<EOD_PHPAspis_Part0
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
  <head>
    <title>302 Found</title>
  </head>
<body>
  <h1>Found</h1>
  <p>The document has moved <a href="
EOD_PHPAspis_Part0
,$escaped_url),<<<EOD_PHPAspis_Part1
">here</a>.</p>
  </body>
</html>

EOD_PHPAspis_Part1
);
header(('HTTP/1.1 302 Moved'));
header(('Content-Type: text/html'));
header((deconcat1('Location: ',$url)));
echo AspisCheckPrint($content);
Aspis_exit();
} }
function client_error ( $msg = array('Client Error',false) ) {
{log_app(array('Status',false),array('400: Client Error',false));
header(('Content-Type: text/plain'));
status_header(array('400',false));
Aspis_exit();
} }
function created ( $post_ID,$content,$post_type = array('post',false) ) {
{log_app(array('created()::$post_ID',false),concat(concat2($post_ID,", "),$post_type));
$edit = $this->get_entry_url($post_ID);
switch ( $post_type[0] ) {
case ('post'):$ctloc = $this->get_entry_url($post_ID);
break ;
case ('attachment'):$edit = concat($this->app_base,concat1("attachments/",$post_ID));
break ;
 }
header((deconcat1("Content-Type: ",$this->ATOM_CONTENT_TYPE)));
if ( ((isset($ctloc) && Aspis_isset( $ctloc))))
 header((deconcat1('Content-Location: ',$ctloc)));
header((deconcat1('Location: ',$edit)));
status_header(array('201',false));
echo AspisCheckPrint($content);
Aspis_exit();
} }
function auth_required ( $msg ) {
{log_app(array('Status',false),array('401: Auth Required',false));
nocache_headers();
header(('WWW-Authenticate: Basic realm="WordPress Atom Protocol"'));
header((deconcat1("HTTP/1.1 401 ",$msg)));
header((deconcat1('Status: 401 ',$msg)));
header(('Content-Type: text/html'));
$content = concat2(concat1(<<<EOD_PHPAspis_Part0
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
  <head>
    <title>401 Unauthorized</title>
  </head>
<body>
    <h1>401 Unauthorized</h1>
    <p>
EOD_PHPAspis_Part0
,$msg),<<<EOD_PHPAspis_Part1
</p>
  </body>
</html>

EOD_PHPAspis_Part1
);
echo AspisCheckPrint($content);
Aspis_exit();
} }
function output ( $xml,$ctype = array('application/atom+xml',false) ) {
{status_header(array('200',false));
$xml = concat(concat2(concat2(concat1('<?xml version="1.0" encoding="',Aspis_strtolower(get_option(array('blog_charset',false)))),'"?>'),"\n"),$xml);
header(('Connection: close'));
header((deconcat1('Content-Length: ',attAspis(strlen($xml[0])))));
header((deconcat1('Content-Type: ',$ctype)));
header(('Content-Disposition: attachment; filename=atom.xml'));
header((deconcat1('Date: ',attAspis(date(('r'))))));
if ( $this->do_output[0])
 echo AspisCheckPrint($xml);
log_app(array('function',false),concat1("output:\n",$xml));
Aspis_exit();
} }
function escape ( &$array ) {
{global $wpdb;
foreach ( $array[0] as $k =>$v )
{restoreTaint($k,$v);
{if ( is_array($v[0]))
 {$this->escape(attachAspis($array,$k[0]));
}else 
{if ( is_object($v[0]))
 {}else 
{{arrayAssign($array[0],deAspis(registerTaint($k)),addTaint($wpdb[0]->escape($v)));
}}}}}} }
function authenticate (  ) {
{log_app(array("authenticate()",false),Aspis_print_r($_ENV,array(true,false)));
if ( ((isset($_SERVER[0][('HTTP_AUTHORIZATION')]) && Aspis_isset( $_SERVER [0][('HTTP_AUTHORIZATION')]))))
 {list($_SERVER[0][('PHP_AUTH_USER')],$_SERVER[0][('PHP_AUTH_PW')]) = deAspisList(Aspis_explode(array(':',false),Aspis_base64_decode(Aspis_substr($_SERVER[0]['HTTP_AUTHORIZATION'],array(6,false)))),array());
}else 
{if ( ((isset($_SERVER[0][('REDIRECT_REMOTE_USER')]) && Aspis_isset( $_SERVER [0][('REDIRECT_REMOTE_USER')]))))
 {list($_SERVER[0][('PHP_AUTH_USER')],$_SERVER[0][('PHP_AUTH_PW')]) = deAspisList(Aspis_explode(array(':',false),Aspis_base64_decode(Aspis_substr($_SERVER[0]['REDIRECT_REMOTE_USER'],array(6,false)))),array());
}}if ( (((isset($_SERVER[0][('PHP_AUTH_USER')]) && Aspis_isset( $_SERVER [0][('PHP_AUTH_USER')]))) && ((isset($_SERVER[0][('PHP_AUTH_PW')]) && Aspis_isset( $_SERVER [0][('PHP_AUTH_PW')])))))
 {log_app(array("Basic Auth",false),$_SERVER[0]['PHP_AUTH_USER']);
$user = wp_authenticate($_SERVER[0]['PHP_AUTH_USER'],$_SERVER[0]['PHP_AUTH_PW']);
if ( ($user[0] && (denot_boolean(is_wp_error($user)))))
 {wp_set_current_user($user[0]->ID);
log_app(array("authenticate()",false),$user[0]->user_login);
return array(true,false);
}}return array(false,false);
} }
function get_accepted_content_type ( $types = array(null,false) ) {
{if ( (!((isset($types) && Aspis_isset( $types)))))
 {$types = $this->media_content_types;
}if ( ((!((isset($_SERVER[0][('CONTENT_LENGTH')]) && Aspis_isset( $_SERVER [0][('CONTENT_LENGTH')])))) || (!((isset($_SERVER[0][('CONTENT_TYPE')]) && Aspis_isset( $_SERVER [0][('CONTENT_TYPE')]))))))
 {$this->length_required();
}$type = $_SERVER[0]['CONTENT_TYPE'];
list($type,$subtype) = deAspisList(Aspis_explode(array('/',false),$type),array());
list($subtype) = deAspisList(Aspis_explode(array(";",false),$subtype),array());
log_app(array("get_accepted_content_type",false),concat(concat2(concat1("type=",$type),", subtype="),$subtype));
foreach ( $types[0] as $t  )
{list($acceptedType,$acceptedSubtype) = deAspisList(Aspis_explode(array('/',false),$t),array());
if ( (($acceptedType[0] == ('*')) || ($acceptedType[0] == $type[0])))
 {if ( (($acceptedSubtype[0] == ('*')) || ($acceptedSubtype[0] == $subtype[0])))
 return concat(concat2($type,"/"),$subtype);
}}$this->invalid_media();
} }
function process_conditionals (  ) {
{if ( ((empty($this->params) || Aspis_empty( $this ->params ))))
 return ;
if ( (deAspis($_SERVER[0]['REQUEST_METHOD']) == ('DELETE')))
 return ;
switch ( $this->params[0][(0)][0] ) {
case $this->ENTRY_PATH[0]:global $post;
$post = wp_get_single_post($this->params[0][(1)]);
$wp_last_modified = get_post_modified_time(array('D, d M Y H:i:s',false),array(true,false));
$post = array(NULL,false);
break ;
case $this->ENTRIES_PATH[0]:$wp_last_modified = concat2(mysql2date(array('D, d M Y H:i:s',false),get_lastpostmodified(array('GMT',false)),array(0,false)),' GMT');
break ;
default :return ;
 }
$wp_etag = attAspis(md5($wp_last_modified[0]));
@header((deconcat1("Last-Modified: ",$wp_last_modified)));
@header((deconcat1("ETag: ",$wp_etag)));
if ( ((isset($_SERVER[0][('HTTP_IF_NONE_MATCH')]) && Aspis_isset( $_SERVER [0][('HTTP_IF_NONE_MATCH')]))))
 $client_etag = Aspis_stripslashes($_SERVER[0]['HTTP_IF_NONE_MATCH']);
else 
{$client_etag = array(false,false);
}$client_last_modified = Aspis_trim($_SERVER[0]['HTTP_IF_MODIFIED_SINCE']);
$client_modified_timestamp = $client_last_modified[0] ? attAspis(strtotime($client_last_modified[0])) : array(0,false);
$wp_modified_timestamp = attAspis(strtotime($wp_last_modified[0]));
if ( (($client_last_modified[0] && $client_etag[0]) ? (($client_modified_timestamp[0] >= $wp_modified_timestamp[0]) && ($client_etag[0] == $wp_etag[0])) : (($client_modified_timestamp[0] >= $wp_modified_timestamp[0]) || ($client_etag[0] == $wp_etag[0]))))
 {status_header(array(304,false));
Aspis_exit();
}} }
function rfc3339_str2time ( $str ) {
{$match = array(false,false);
if ( (denot_boolean(Aspis_preg_match(array("/(\d{4}-\d{2}-\d{2})T(\d{2}\:\d{2}\:\d{2})\.?\d{0,3}(Z|[+-]+\d{2}\:\d{2})/",false),$str,$match))))
 return array(false,false);
if ( (deAspis(attachAspis($match,(3))) == ('Z')))
 deAspis(attachAspis($match,(3))) == ('+0000');
return attAspis(strtotime((deconcat(concat2(concat(concat2(attachAspis($match,(1))," "),attachAspis($match,(2)))," "),attachAspis($match,(3))))));
} }
function get_publish_time ( $published ) {
{$pubtime = $this->rfc3339_str2time($published);
if ( (denot_boolean($pubtime)))
 {return array(array(current_time(array('mysql',false)),current_time(array('mysql',false),array(1,false))),false);
}else 
{{return array(array(attAspis(date(("Y-m-d H:i:s"),$pubtime[0])),attAspis(gmdate(("Y-m-d H:i:s"),$pubtime[0]))),false);
}}} }
}$server = array(new AtomServer(),false);
$server[0]->handle_request();
;
?>
<?php 