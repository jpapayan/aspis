<?php require_once('AspisMain.php'); ?><?php
define(('XMLRPC_REQUEST'),true);
$_COOKIE = array(array(),false);
if ( (!((isset($HTTP_RAW_POST_DATA) && Aspis_isset( $HTTP_RAW_POST_DATA)))))
 {$HTTP_RAW_POST_DATA = attAspis(file_get_contents(('php://input')));
}if ( ((isset($HTTP_RAW_POST_DATA) && Aspis_isset( $HTTP_RAW_POST_DATA))))
 $HTTP_RAW_POST_DATA = Aspis_trim($HTTP_RAW_POST_DATA);
include ('./wp-load.php');
if ( ((isset($_GET[0][('rsd')]) && Aspis_isset( $_GET [0][('rsd')]))))
 {header((deconcat1('Content-Type: text/xml; charset=',get_option(array('blog_charset',false)))),true);
;
?>
<?php echo AspisCheckPrint(concat2(concat2(concat1('<?xml version="1.0" encoding="',get_option(array('blog_charset',false))),'"?'),'>'));
;
?>
<rsd version="1.0" xmlns="http://archipelago.phrasewise.com/rsd">
  <service>
    <engineName>WordPress</engineName>
    <engineLink>http://wordpress.org/</engineLink>
    <homePageLink><?php bloginfo_rss(array('url',false));
?></homePageLink>
    <apis>
      <api name="WordPress" blogID="1" preferred="true" apiLink="<?php echo AspisCheckPrint(site_url(array('xmlrpc.php',false),array('rpc',false)));
?>" />
      <api name="Movable Type" blogID="1" preferred="false" apiLink="<?php echo AspisCheckPrint(site_url(array('xmlrpc.php',false),array('rpc',false)));
?>" />
      <api name="MetaWeblog" blogID="1" preferred="false" apiLink="<?php echo AspisCheckPrint(site_url(array('xmlrpc.php',false),array('rpc',false)));
?>" />
      <api name="Blogger" blogID="1" preferred="false" apiLink="<?php echo AspisCheckPrint(site_url(array('xmlrpc.php',false),array('rpc',false)));
?>" />
      <api name="Atom" blogID="" preferred="false" apiLink="<?php echo AspisCheckPrint(apply_filters(array('atom_service_url',false),site_url(array('wp-app.php/service',false),array('rpc',false))));
?>" />
    </apis>
  </service>
</rsd>
<?php Aspis_exit();
}include_once (deconcat12(ABSPATH,'wp-admin/includes/admin.php'));
include_once (deconcat2(concat12(ABSPATH,WPINC),'/class-IXR.php'));
$post_default_title = array("",false);
$xmlrpc_logging = array(0,false);
function logIO ( $io,$msg ) {
global $xmlrpc_logging;
if ( $xmlrpc_logging[0])
 {$fp = attAspis(fopen(("../xmlrpc.log"),("a+")));
$date = attAspis(gmdate(("Y-m-d H:i:s ")));
$iot = ($io[0] == ("I")) ? array(" Input: ",false) : array(" Output: ",false);
fwrite($fp[0],(deconcat(concat(concat1("\n\n",$date),$iot),$msg)));
fclose($fp[0]);
}return array(true,false);
 }
if ( ((isset($HTTP_RAW_POST_DATA) && Aspis_isset( $HTTP_RAW_POST_DATA))))
 logIO(array("I",false),$HTTP_RAW_POST_DATA);
class wp_xmlrpc_server extends IXR_Server{function wp_xmlrpc_server (  ) {
{$this->methods = array(array('wp.getUsersBlogs' => array('this:wp_getUsersBlogs',false,false),'wp.getPage' => array('this:wp_getPage',false,false),'wp.getPages' => array('this:wp_getPages',false,false),'wp.newPage' => array('this:wp_newPage',false,false),'wp.deletePage' => array('this:wp_deletePage',false,false),'wp.editPage' => array('this:wp_editPage',false,false),'wp.getPageList' => array('this:wp_getPageList',false,false),'wp.getAuthors' => array('this:wp_getAuthors',false,false),'wp.getCategories' => array('this:mw_getCategories',false,false),'wp.getTags' => array('this:wp_getTags',false,false),'wp.newCategory' => array('this:wp_newCategory',false,false),'wp.deleteCategory' => array('this:wp_deleteCategory',false,false),'wp.suggestCategories' => array('this:wp_suggestCategories',false,false),'wp.uploadFile' => array('this:mw_newMediaObject',false,false),'wp.getCommentCount' => array('this:wp_getCommentCount',false,false),'wp.getPostStatusList' => array('this:wp_getPostStatusList',false,false),'wp.getPageStatusList' => array('this:wp_getPageStatusList',false,false),'wp.getPageTemplates' => array('this:wp_getPageTemplates',false,false),'wp.getOptions' => array('this:wp_getOptions',false,false),'wp.setOptions' => array('this:wp_setOptions',false,false),'wp.getComment' => array('this:wp_getComment',false,false),'wp.getComments' => array('this:wp_getComments',false,false),'wp.deleteComment' => array('this:wp_deleteComment',false,false),'wp.editComment' => array('this:wp_editComment',false,false),'wp.newComment' => array('this:wp_newComment',false,false),'wp.getCommentStatusList' => array('this:wp_getCommentStatusList',false,false),'blogger.getUsersBlogs' => array('this:blogger_getUsersBlogs',false,false),'blogger.getUserInfo' => array('this:blogger_getUserInfo',false,false),'blogger.getPost' => array('this:blogger_getPost',false,false),'blogger.getRecentPosts' => array('this:blogger_getRecentPosts',false,false),'blogger.getTemplate' => array('this:blogger_getTemplate',false,false),'blogger.setTemplate' => array('this:blogger_setTemplate',false,false),'blogger.newPost' => array('this:blogger_newPost',false,false),'blogger.editPost' => array('this:blogger_editPost',false,false),'blogger.deletePost' => array('this:blogger_deletePost',false,false),'metaWeblog.newPost' => array('this:mw_newPost',false,false),'metaWeblog.editPost' => array('this:mw_editPost',false,false),'metaWeblog.getPost' => array('this:mw_getPost',false,false),'metaWeblog.getRecentPosts' => array('this:mw_getRecentPosts',false,false),'metaWeblog.getCategories' => array('this:mw_getCategories',false,false),'metaWeblog.newMediaObject' => array('this:mw_newMediaObject',false,false),'metaWeblog.deletePost' => array('this:blogger_deletePost',false,false),'metaWeblog.getTemplate' => array('this:blogger_getTemplate',false,false),'metaWeblog.setTemplate' => array('this:blogger_setTemplate',false,false),'metaWeblog.getUsersBlogs' => array('this:blogger_getUsersBlogs',false,false),'mt.getCategoryList' => array('this:mt_getCategoryList',false,false),'mt.getRecentPostTitles' => array('this:mt_getRecentPostTitles',false,false),'mt.getPostCategories' => array('this:mt_getPostCategories',false,false),'mt.setPostCategories' => array('this:mt_setPostCategories',false,false),'mt.supportedMethods' => array('this:mt_supportedMethods',false,false),'mt.supportedTextFilters' => array('this:mt_supportedTextFilters',false,false),'mt.getTrackbackPings' => array('this:mt_getTrackbackPings',false,false),'mt.publishPost' => array('this:mt_publishPost',false,false),'pingback.ping' => array('this:pingback_ping',false,false),'pingback.extensions.getPingbacks' => array('this:pingback_extensions_getPingbacks',false,false),'demo.sayHello' => array('this:sayHello',false,false),'demo.addTwoNumbers' => array('this:addTwoNumbers',false,false)),false);
$this->initialise_blog_option_info();
$this->methods = apply_filters(array('xmlrpc_methods',false),$this->methods);
} }
function serve_request (  ) {
{$this->IXR_Server($this->methods);
} }
function sayHello ( $args ) {
{return array('Hello!',false);
} }
function addTwoNumbers ( $args ) {
{$number1 = attachAspis($args,(0));
$number2 = attachAspis($args,(1));
return array($number1[0] + $number2[0],false);
} }
function login_pass_ok ( $user_login,$user_pass ) {
{if ( (denot_boolean(get_option(array('enable_xmlrpc',false)))))
 {$this->error = array(new IXR_Error(array(405,false),Aspis_sprintf(__(array('XML-RPC services are disabled on this blog.  An admin user can enable them at %s',false)),admin_url(array('options-writing.php',false)))),false);
return array(false,false);
}if ( (denot_boolean(user_pass_ok($user_login,$user_pass))))
 {$this->error = array(new IXR_Error(array(403,false),__(array('Bad login/pass combination.',false))),false);
return array(false,false);
}return array(true,false);
} }
function login ( $username,$password ) {
{if ( (denot_boolean(get_option(array('enable_xmlrpc',false)))))
 {$this->error = array(new IXR_Error(array(405,false),Aspis_sprintf(__(array('XML-RPC services are disabled on this blog.  An admin user can enable them at %s',false)),admin_url(array('options-writing.php',false)))),false);
return array(false,false);
}$user = wp_authenticate($username,$password);
if ( deAspis(is_wp_error($user)))
 {$this->error = array(new IXR_Error(array(403,false),__(array('Bad login/pass combination.',false))),false);
return array(false,false);
}set_current_user($user[0]->ID);
return $user;
} }
function escape ( &$array ) {
{global $wpdb;
if ( (!(is_array($array[0]))))
 {return ($wpdb[0]->escape($array));
}else 
{{foreach ( deAspis(array_cast($array)) as $k =>$v )
{restoreTaint($k,$v);
{if ( is_array($v[0]))
 {$this->escape(attachAspis($array,$k[0]));
}else 
{if ( is_object($v[0]))
 {}else 
{{arrayAssign($array[0],deAspis(registerTaint($k)),addTaint($wpdb[0]->escape($v)));
}}}}}}}} }
function get_custom_fields ( $post_id ) {
{$post_id = int_cast($post_id);
$custom_fields = array(array(),false);
foreach ( deAspis(array_cast(has_meta($post_id))) as $meta  )
{if ( (strpos(deAspis($meta[0]['meta_key']),'_wp_') === (0)))
 {continue ;
}arrayAssignAdd($custom_fields[0][],addTaint(array(array(deregisterTaint(array("id",false)) => addTaint($meta[0]['meta_id']),deregisterTaint(array("key",false)) => addTaint($meta[0]['meta_key']),deregisterTaint(array("value",false)) => addTaint($meta[0]['meta_value'])),false)));
}return $custom_fields;
} }
function set_custom_fields ( $post_id,$fields ) {
{$post_id = int_cast($post_id);
foreach ( deAspis(array_cast($fields)) as $meta  )
{if ( ((isset($meta[0][('id')]) && Aspis_isset( $meta [0][('id')]))))
 {arrayAssign($meta[0],deAspis(registerTaint(array('id',false))),addTaint(int_cast($meta[0]['id'])));
if ( ((isset($meta[0][('key')]) && Aspis_isset( $meta [0][('key')]))))
 {update_meta($meta[0]['id'],$meta[0]['key'],$meta[0]['value']);
}else 
{{delete_meta($meta[0]['id']);
}}}else 
{{arrayAssign($_POST[0],deAspis(registerTaint(array('metakeyinput',false))),addTaint($meta[0]['key']));
arrayAssign($_POST[0],deAspis(registerTaint(array('metavalue',false))),addTaint($meta[0]['value']));
add_meta($post_id);
}}}} }
function initialise_blog_option_info (  ) {
{global $wp_version;
$this->blog_options = array(array('software_name' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Software Name',false))),'readonly' => array(true,false,false),'value' => array('WordPress',false,false)),false,false),'software_version' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Software Version',false))),'readonly' => array(true,false,false),deregisterTaint(array('value',false)) => addTaint($wp_version)),false,false),'blog_url' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Blog URL',false))),'readonly' => array(true,false,false),'option' => array('siteurl',false,false)),false,false),'time_zone' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Time Zone',false))),'readonly' => array(false,false,false),'option' => array('gmt_offset',false,false)),false,false),'blog_title' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Blog Title',false))),'readonly' => array(false,false,false),'option' => array('blogname',false,false)),false,false),'blog_tagline' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Blog Tagline',false))),'readonly' => array(false,false,false),'option' => array('blogdescription',false,false)),false,false),'date_format' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Date Format',false))),'readonly' => array(false,false,false),'option' => array('date_format',false,false)),false,false),'time_format' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Time Format',false))),'readonly' => array(false,false,false),'option' => array('time_format',false,false)),false,false),'users_can_register' => array(array(deregisterTaint(array('desc',false)) => addTaint(__(array('Allow new users to sign up',false))),'readonly' => array(false,false,false),'option' => array('users_can_register',false,false)),false,false)),false);
$this->blog_options = apply_filters(array('xmlrpc_blog_options',false),$this->blog_options);
} }
function wp_getUsersBlogs ( $args ) {
{if ( (!(function_exists(('is_site_admin')))))
 {Aspis_array_unshift($args,array(1,false));
return $this->blogger_getUsersBlogs($args);
}$this->escape($args);
$username = attachAspis($args,(0));
$password = attachAspis($args,(1));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('wp.getUsersBlogs',false));
$blogs = array_cast(get_blogs_of_user($user[0]->ID));
$struct = array(array(),false);
foreach ( $blogs[0] as $blog  )
{if ( ($blog[0]->site_id[0] != $current_site[0]->id[0]))
 continue ;
$blog_id = $blog[0]->userblog_id;
switch_to_blog($blog_id);
$is_admin = current_user_can(array('level_8',false));
arrayAssignAdd($struct[0][],addTaint(array(array(deregisterTaint(array('isAdmin',false)) => addTaint($is_admin),deregisterTaint(array('url',false)) => addTaint(concat2(get_option(array('home',false)),'/')),deregisterTaint(array('blogid',false)) => addTaint($blog_id),deregisterTaint(array('blogName',false)) => addTaint(get_option(array('blogname',false))),deregisterTaint(array('xmlrpc',false)) => addTaint(site_url(array('xmlrpc.php',false)))),false)));
restore_current_blog();
}return $struct;
} }
function wp_getPage ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$page_id = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_page',false),$page_id))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit this page.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.getPage',false));
$page = get_page($page_id);
if ( ($page[0]->ID[0] && ($page[0]->post_type[0] == ("page"))))
 {$full_page = get_extended($page[0]->post_content);
$link = post_permalink($page[0]->ID);
$parent_title = array("",false);
if ( (!((empty($page[0]->post_parent) || Aspis_empty( $page[0] ->post_parent )))))
 {$parent = get_page($page[0]->post_parent);
$parent_title = $parent[0]->post_title;
}$allow_comments = deAspis(comments_open($page[0]->ID)) ? array(1,false) : array(0,false);
$allow_pings = deAspis(pings_open($page[0]->ID)) ? array(1,false) : array(0,false);
$page_date = mysql2date(array("Ymd\TH:i:s",false),$page[0]->post_date,array(false,false));
$page_date_gmt = mysql2date(array("Ymd\TH:i:s",false),$page[0]->post_date_gmt,array(false,false));
if ( ($page[0]->post_status[0] == ('draft')))
 {$page_date_gmt = get_gmt_from_date(mysql2date(array('Y-m-d H:i:s',false),$page[0]->post_date),array('Ymd\TH:i:s',false));
}$categories = array(array(),false);
foreach ( deAspis(wp_get_post_categories($page[0]->ID)) as $cat_id  )
{arrayAssignAdd($categories[0][],addTaint(get_cat_name($cat_id)));
}$author = get_userdata($page[0]->post_author);
$page_template = get_post_meta($page[0]->ID,array('_wp_page_template',false),array(true,false));
if ( ((empty($page_template) || Aspis_empty( $page_template))))
 $page_template = array('default',false);
$page_struct = array(array("dateCreated" => array(new IXR_Date($page_date),false,false),deregisterTaint(array("userid",false)) => addTaint($page[0]->post_author),deregisterTaint(array("page_id",false)) => addTaint($page[0]->ID),deregisterTaint(array("page_status",false)) => addTaint($page[0]->post_status),deregisterTaint(array("description",false)) => addTaint($full_page[0]["main"]),deregisterTaint(array("title",false)) => addTaint($page[0]->post_title),deregisterTaint(array("link",false)) => addTaint($link),deregisterTaint(array("permaLink",false)) => addTaint($link),deregisterTaint(array("categories",false)) => addTaint($categories),deregisterTaint(array("excerpt",false)) => addTaint($page[0]->post_excerpt),deregisterTaint(array("text_more",false)) => addTaint($full_page[0]["extended"]),deregisterTaint(array("mt_allow_comments",false)) => addTaint($allow_comments),deregisterTaint(array("mt_allow_pings",false)) => addTaint($allow_pings),deregisterTaint(array("wp_slug",false)) => addTaint($page[0]->post_name),deregisterTaint(array("wp_password",false)) => addTaint($page[0]->post_password),deregisterTaint(array("wp_author",false)) => addTaint($author[0]->display_name),deregisterTaint(array("wp_page_parent_id",false)) => addTaint($page[0]->post_parent),deregisterTaint(array("wp_page_parent_title",false)) => addTaint($parent_title),deregisterTaint(array("wp_page_order",false)) => addTaint($page[0]->menu_order),deregisterTaint(array("wp_author_id",false)) => addTaint($author[0]->ID),deregisterTaint(array("wp_author_display_name",false)) => addTaint($author[0]->display_name),"date_created_gmt" => array(new IXR_Date($page_date_gmt),false,false),deregisterTaint(array("custom_fields",false)) => addTaint($this->get_custom_fields($page_id)),deregisterTaint(array("wp_page_template",false)) => addTaint($page_template)),false);
return ($page_struct);
}else 
{{return (array(new IXR_Error(array(404,false),__(array("Sorry, no such page.",false))),false));
}}} }
function wp_getPages ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$num_pages = ((isset($args[0][(3)]) && Aspis_isset( $args [0][(3)]))) ? int_cast(attachAspis($args,(3))) : array(10,false);
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_pages',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit pages.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.getPages',false));
$pages = get_posts(array(array('post_type' => array('page',false,false),'post_status' => array('any',false,false),deregisterTaint(array('numberposts',false)) => addTaint($num_pages)),false));
$num_pages = attAspis(count($pages[0]));
if ( ($num_pages[0] >= (1)))
 {$pages_struct = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < $num_pages[0]) ; postincr($i) )
{$page = wp_xmlrpc_server::wp_getPage(array(array($blog_id,$pages[0][$i[0]][0]->ID,$username,$password),false));
arrayAssignAdd($pages_struct[0][],addTaint($page));
}return ($pages_struct);
}else 
{{return (array(array(),false));
}}} }
function wp_newPage ( $args ) {
{$username = $this->escape(attachAspis($args,(1)));
$password = $this->escape(attachAspis($args,(2)));
$page = attachAspis($args,(3));
$publish = attachAspis($args,(4));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('wp.newPage',false));
if ( (denot_boolean(current_user_can(array("publish_pages",false)))))
 {return (array(new IXR_Error(array(401,false),__(array("Sorry, you cannot add new pages.",false))),false));
}arrayAssign($args[0][(3)][0],deAspis(registerTaint(array("post_type",false))),addTaint(array("page",false)));
return ($this->mw_newPost($args));
} }
function wp_deletePage ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$page_id = int_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('wp.deletePage',false));
$actual_page = wp_get_single_post($page_id,array(ARRAY_A,false));
if ( ((denot_boolean($actual_page)) || (deAspis($actual_page[0]["post_type"]) != ("page"))))
 {return (array(new IXR_Error(array(404,false),__(array("Sorry, no such page.",false))),false));
}if ( (denot_boolean(current_user_can(array("delete_page",false),$page_id))))
 {return (array(new IXR_Error(array(401,false),__(array("Sorry, you do not have the right to delete this page.",false))),false));
}$result = wp_delete_post($page_id);
if ( (denot_boolean($result)))
 {return (array(new IXR_Error(array(500,false),__(array("Failed to delete the page.",false))),false));
}return (array(true,false));
} }
function wp_editPage ( $args ) {
{$blog_id = int_cast(attachAspis($args,(0)));
$page_id = int_cast($this->escape(attachAspis($args,(1))));
$username = $this->escape(attachAspis($args,(2)));
$password = $this->escape(attachAspis($args,(3)));
$content = attachAspis($args,(4));
$publish = attachAspis($args,(5));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('wp.editPage',false));
$actual_page = wp_get_single_post($page_id,array(ARRAY_A,false));
if ( ((denot_boolean($actual_page)) || (deAspis($actual_page[0]["post_type"]) != ("page"))))
 {return (array(new IXR_Error(array(404,false),__(array("Sorry, no such page.",false))),false));
}if ( (denot_boolean(current_user_can(array("edit_page",false),$page_id))))
 {return (array(new IXR_Error(array(401,false),__(array("Sorry, you do not have the right to edit this page.",false))),false));
}arrayAssign($content[0],deAspis(registerTaint(array("post_type",false))),addTaint(array("page",false)));
$args = array(array($page_id,$username,$password,$content,$publish),false);
return ($this->mw_editPost($args));
} }
function wp_getPageList ( $args ) {
{global $wpdb;
$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_pages',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit pages.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.getPageList',false));
$page_list = $wpdb[0]->get_results(concat2(concat1("
			SELECT ID page_id,
				post_title page_title,
				post_parent page_parent_id,
				post_date_gmt,
				post_date,
				post_status
			FROM ",$wpdb[0]->posts),"
			WHERE post_type = 'page'
			ORDER BY ID
		"));
$num_pages = attAspis(count($page_list[0]));
for ( $i = array(0,false) ; ($i[0] < $num_pages[0]) ; postincr($i) )
{$post_date = mysql2date(array("Ymd\TH:i:s",false),$page_list[0][$i[0]][0]->post_date,array(false,false));
$post_date_gmt = mysql2date(array("Ymd\TH:i:s",false),$page_list[0][$i[0]][0]->post_date_gmt,array(false,false));
$page_list[0][$i[0]][0]->dateCreated = array(new IXR_Date($post_date),false);
$page_list[0][$i[0]][0]->date_created_gmt = array(new IXR_Date($post_date_gmt),false);
if ( ($page_list[0][$i[0]][0]->post_status[0] == ('draft')))
 {$page_list[0][$i[0]][0]->date_created_gmt = get_gmt_from_date(mysql2date(array('Y-m-d H:i:s',false),$page_list[0][$i[0]][0]->post_date),array('Ymd\TH:i:s',false));
$page_list[0][$i[0]][0]->date_created_gmt = array(new IXR_Date($page_list[0][$i[0]][0]->date_created_gmt),false);
}unset($page_list[0][$i[0]][0]->post_date_gmt);
unset($page_list[0][$i[0]][0]->post_date);
unset($page_list[0][$i[0]][0]->post_status);
}return ($page_list);
} }
function wp_getAuthors ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array("edit_posts",false)))))
 {return (array(new IXR_Error(array(401,false),__(array("Sorry, you cannot edit posts on this blog.",false))),false));
}do_action(array('xmlrpc_call',false),array('wp.getAuthors',false));
$authors = array(array(),false);
foreach ( deAspis(array_cast(get_users_of_blog())) as $row  )
{arrayAssignAdd($authors[0][],addTaint(array(array(deregisterTaint(array("user_id",false)) => addTaint($row[0]->user_id),deregisterTaint(array("user_login",false)) => addTaint($row[0]->user_login),deregisterTaint(array("display_name",false)) => addTaint($row[0]->display_name)),false)));
}return ($authors);
} }
function wp_getTags ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 {return array(new IXR_Error(array(401,false),__(array('Sorry, you must be able to edit posts on this blog in order to view tags.',false))),false);
}do_action(array('xmlrpc_call',false),array('wp.getKeywords',false));
$tags = array(array(),false);
if ( deAspis($all_tags = get_tags()))
 {foreach ( deAspis(array_cast($all_tags)) as $tag  )
{arrayAssign($struct[0],deAspis(registerTaint(array('tag_id',false))),addTaint($tag[0]->term_id));
arrayAssign($struct[0],deAspis(registerTaint(array('name',false))),addTaint($tag[0]->name));
arrayAssign($struct[0],deAspis(registerTaint(array('count',false))),addTaint($tag[0]->count));
arrayAssign($struct[0],deAspis(registerTaint(array('slug',false))),addTaint($tag[0]->slug));
arrayAssign($struct[0],deAspis(registerTaint(array('html_url',false))),addTaint(esc_html(get_tag_link($tag[0]->term_id))));
arrayAssign($struct[0],deAspis(registerTaint(array('rss_url',false))),addTaint(esc_html(get_tag_feed_link($tag[0]->term_id))));
arrayAssignAdd($tags[0][],addTaint($struct));
}}return $tags;
} }
function wp_newCategory ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$category = attachAspis($args,(3));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('wp.newCategory',false));
if ( (denot_boolean(current_user_can(array("manage_categories",false)))))
 {return (array(new IXR_Error(array(401,false),__(array("Sorry, you do not have the right to add a category.",false))),false));
}if ( ((empty($category[0][("slug")]) || Aspis_empty( $category [0][("slug")]))))
 {arrayAssign($category[0],deAspis(registerTaint(array("slug",false))),addTaint(array("",false)));
}if ( (!((isset($category[0][("parent_id")]) && Aspis_isset( $category [0][("parent_id")])))))
 arrayAssign($category[0],deAspis(registerTaint(array("parent_id",false))),addTaint(array("",false)));
if ( ((empty($category[0][("description")]) || Aspis_empty( $category [0][("description")]))))
 {arrayAssign($category[0],deAspis(registerTaint(array("description",false))),addTaint(array("",false)));
}$new_category = array(array(deregisterTaint(array("cat_name",false)) => addTaint($category[0]["name"]),deregisterTaint(array("category_nicename",false)) => addTaint($category[0]["slug"]),deregisterTaint(array("category_parent",false)) => addTaint($category[0]["parent_id"]),deregisterTaint(array("category_description",false)) => addTaint($category[0]["description"])),false);
$cat_id = wp_insert_category($new_category);
if ( (denot_boolean($cat_id)))
 {return (array(new IXR_Error(array(500,false),__(array("Sorry, the new category failed.",false))),false));
}return ($cat_id);
} }
function wp_deleteCategory ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$category_id = int_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('wp.deleteCategory',false));
if ( (denot_boolean(current_user_can(array("manage_categories",false)))))
 {return array(new IXR_Error(array(401,false),__(array("Sorry, you do not have the right to delete a category.",false))),false);
}return wp_delete_category($category_id);
} }
function wp_suggestCategories ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$category = attachAspis($args,(3));
$max_results = int_cast(attachAspis($args,(4)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you must be able to edit posts to this blog in order to view categories.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.suggestCategories',false));
$category_suggestions = array(array(),false);
$args = array(array('get' => array('all',false,false),deregisterTaint(array('number',false)) => addTaint($max_results),deregisterTaint(array('name__like',false)) => addTaint($category)),false);
foreach ( deAspis(array_cast(get_categories($args))) as $cat  )
{arrayAssignAdd($category_suggestions[0][],addTaint(array(array(deregisterTaint(array("category_id",false)) => addTaint($cat[0]->cat_ID),deregisterTaint(array("category_name",false)) => addTaint($cat[0]->cat_name)),false)));
}return ($category_suggestions);
} }
function wp_getComment ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$comment_id = int_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('moderate_comments',false)))))
 return array(new IXR_Error(array(403,false),__(array('You are not allowed to moderate comments on this blog.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.getComment',false));
if ( (denot_boolean($comment = get_comment($comment_id))))
 return array(new IXR_Error(array(404,false),__(array('Invalid comment ID.',false))),false);
$comment_date = mysql2date(array("Ymd\TH:i:s",false),$comment[0]->comment_date,array(false,false));
$comment_date_gmt = mysql2date(array("Ymd\TH:i:s",false),$comment[0]->comment_date_gmt,array(false,false));
if ( (('0') == $comment[0]->comment_approved[0]))
 $comment_status = array('hold',false);
else 
{if ( (('spam') == $comment[0]->comment_approved[0]))
 $comment_status = array('spam',false);
else 
{if ( (('1') == $comment[0]->comment_approved[0]))
 $comment_status = array('approve',false);
else 
{$comment_status = $comment[0]->comment_approved;
}}}$link = get_comment_link($comment);
$comment_struct = array(array("date_created_gmt" => array(new IXR_Date($comment_date_gmt),false,false),deregisterTaint(array("user_id",false)) => addTaint($comment[0]->user_id),deregisterTaint(array("comment_id",false)) => addTaint($comment[0]->comment_ID),deregisterTaint(array("parent",false)) => addTaint($comment[0]->comment_parent),deregisterTaint(array("status",false)) => addTaint($comment_status),deregisterTaint(array("content",false)) => addTaint($comment[0]->comment_content),deregisterTaint(array("link",false)) => addTaint($link),deregisterTaint(array("post_id",false)) => addTaint($comment[0]->comment_post_ID),deregisterTaint(array("post_title",false)) => addTaint(get_the_title($comment[0]->comment_post_ID)),deregisterTaint(array("author",false)) => addTaint($comment[0]->comment_author),deregisterTaint(array("author_url",false)) => addTaint($comment[0]->comment_author_url),deregisterTaint(array("author_email",false)) => addTaint($comment[0]->comment_author_email),deregisterTaint(array("author_ip",false)) => addTaint($comment[0]->comment_author_IP),deregisterTaint(array("type",false)) => addTaint($comment[0]->comment_type),),false);
return $comment_struct;
} }
function wp_getComments ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$struct = attachAspis($args,(3));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('moderate_comments',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit comments.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.getComments',false));
if ( ((isset($struct[0][('status')]) && Aspis_isset( $struct [0][('status')]))))
 $status = $struct[0]['status'];
else 
{$status = array('',false);
}$post_id = array('',false);
if ( ((isset($struct[0][('post_id')]) && Aspis_isset( $struct [0][('post_id')]))))
 $post_id = absint($struct[0]['post_id']);
$offset = array(0,false);
if ( ((isset($struct[0][('offset')]) && Aspis_isset( $struct [0][('offset')]))))
 $offset = absint($struct[0]['offset']);
$number = array(10,false);
if ( ((isset($struct[0][('number')]) && Aspis_isset( $struct [0][('number')]))))
 $number = absint($struct[0]['number']);
$comments = get_comments(array(array(deregisterTaint(array('status',false)) => addTaint($status),deregisterTaint(array('post_id',false)) => addTaint($post_id),deregisterTaint(array('offset',false)) => addTaint($offset),deregisterTaint(array('number',false)) => addTaint($number)),false));
$num_comments = attAspis(count($comments[0]));
if ( (denot_boolean($num_comments)))
 return array(array(),false);
$comments_struct = array(array(),false);
for ( $i = array(0,false) ; ($i[0] < $num_comments[0]) ; postincr($i) )
{$comment = wp_xmlrpc_server::wp_getComment(array(array($blog_id,$username,$password,$comments[0][$i[0]][0]->comment_ID,),false));
arrayAssignAdd($comments_struct[0][],addTaint($comment));
}return $comments_struct;
} }
function wp_deleteComment ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$comment_ID = int_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('moderate_comments',false)))))
 return array(new IXR_Error(array(403,false),__(array('You are not allowed to moderate comments on this blog.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.deleteComment',false));
if ( (denot_boolean(get_comment($comment_ID))))
 return array(new IXR_Error(array(404,false),__(array('Invalid comment ID.',false))),false);
return wp_delete_comment($comment_ID);
} }
function wp_editComment ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$comment_ID = int_cast(attachAspis($args,(3)));
$content_struct = attachAspis($args,(4));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('moderate_comments',false)))))
 return array(new IXR_Error(array(403,false),__(array('You are not allowed to moderate comments on this blog.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.editComment',false));
if ( (denot_boolean(get_comment($comment_ID))))
 return array(new IXR_Error(array(404,false),__(array('Invalid comment ID.',false))),false);
if ( ((isset($content_struct[0][('status')]) && Aspis_isset( $content_struct [0][('status')]))))
 {$statuses = get_comment_statuses();
$statuses = attAspisRC(array_keys(deAspisRC($statuses)));
if ( (denot_boolean(Aspis_in_array($content_struct[0]['status'],$statuses))))
 return array(new IXR_Error(array(401,false),__(array('Invalid comment status.',false))),false);
$comment_approved = $content_struct[0]['status'];
}if ( (!((empty($content_struct[0][('date_created_gmt')]) || Aspis_empty( $content_struct [0][('date_created_gmt')])))))
 {$dateCreated = concat2(Aspis_str_replace(array('Z',false),array('',false),$content_struct[0][('date_created_gmt')][0]->getIso()),'Z');
$comment_date = get_date_from_gmt(iso8601_to_datetime($dateCreated));
$comment_date_gmt = iso8601_to_datetime($dateCreated,array(GMT,false));
}if ( ((isset($content_struct[0][('content')]) && Aspis_isset( $content_struct [0][('content')]))))
 $comment_content = $content_struct[0]['content'];
if ( ((isset($content_struct[0][('author')]) && Aspis_isset( $content_struct [0][('author')]))))
 $comment_author = $content_struct[0]['author'];
if ( ((isset($content_struct[0][('author_url')]) && Aspis_isset( $content_struct [0][('author_url')]))))
 $comment_author_url = $content_struct[0]['author_url'];
if ( ((isset($content_struct[0][('author_email')]) && Aspis_isset( $content_struct [0][('author_email')]))))
 $comment_author_email = $content_struct[0]['author_email'];
$comment = array(compact('comment_ID','comment_content','comment_approved','comment_date','comment_date_gmt','comment_author','comment_author_email','comment_author_url'),false);
$result = wp_update_comment($comment);
if ( deAspis(is_wp_error($result)))
 return array(new IXR_Error(array(500,false),$result[0]->get_error_message()),false);
if ( (denot_boolean($result)))
 return array(new IXR_Error(array(500,false),__(array('Sorry, the comment could not be edited. Something wrong happened.',false))),false);
return array(true,false);
} }
function wp_newComment ( $args ) {
{global $wpdb;
$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$post = attachAspis($args,(3));
$content_struct = attachAspis($args,(4));
$allow_anon = apply_filters(array('xmlrpc_allow_anonymous_comments',false),array(false,false));
$user = $this->login($username,$password);
if ( (denot_boolean($user)))
 {$logged_in = array(false,false);
if ( ($allow_anon[0] && deAspis(get_option(array('comment_registration',false)))))
 return array(new IXR_Error(array(403,false),__(array('You must be registered to comment',false))),false);
else 
{if ( (denot_boolean($allow_anon)))
 return $this->error;
}}else 
{{$logged_in = array(true,false);
}}if ( is_numeric(deAspisRC($post)))
 $post_id = absint($post);
else 
{$post_id = url_to_postid($post);
}if ( (denot_boolean($post_id)))
 return array(new IXR_Error(array(404,false),__(array('Invalid post ID.',false))),false);
if ( (denot_boolean(get_post($post_id))))
 return array(new IXR_Error(array(404,false),__(array('Invalid post ID.',false))),false);
arrayAssign($comment[0],deAspis(registerTaint(array('comment_post_ID',false))),addTaint($post_id));
if ( $logged_in[0])
 {arrayAssign($comment[0],deAspis(registerTaint(array('comment_author',false))),addTaint($wpdb[0]->escape($user[0]->display_name)));
arrayAssign($comment[0],deAspis(registerTaint(array('comment_author_email',false))),addTaint($wpdb[0]->escape($user[0]->user_email)));
arrayAssign($comment[0],deAspis(registerTaint(array('comment_author_url',false))),addTaint($wpdb[0]->escape($user[0]->user_url)));
arrayAssign($comment[0],deAspis(registerTaint(array('user_ID',false))),addTaint($user[0]->ID));
}else 
{{arrayAssign($comment[0],deAspis(registerTaint(array('comment_author',false))),addTaint(array('',false)));
if ( ((isset($content_struct[0][('author')]) && Aspis_isset( $content_struct [0][('author')]))))
 arrayAssign($comment[0],deAspis(registerTaint(array('comment_author',false))),addTaint($content_struct[0]['author']));
arrayAssign($comment[0],deAspis(registerTaint(array('comment_author_email',false))),addTaint(array('',false)));
if ( ((isset($content_struct[0][('author_email')]) && Aspis_isset( $content_struct [0][('author_email')]))))
 arrayAssign($comment[0],deAspis(registerTaint(array('comment_author_email',false))),addTaint($content_struct[0]['author_email']));
arrayAssign($comment[0],deAspis(registerTaint(array('comment_author_url',false))),addTaint(array('',false)));
if ( ((isset($content_struct[0][('author_url')]) && Aspis_isset( $content_struct [0][('author_url')]))))
 arrayAssign($comment[0],deAspis(registerTaint(array('comment_author_url',false))),addTaint($content_struct[0]['author_url']));
arrayAssign($comment[0],deAspis(registerTaint(array('user_ID',false))),addTaint(array(0,false)));
if ( deAspis(get_option(array('require_name_email',false))))
 {if ( (((6) > strlen(deAspis($comment[0]['comment_author_email']))) || (('') == deAspis($comment[0]['comment_author']))))
 return array(new IXR_Error(array(403,false),__(array('Comment author name and email are required',false))),false);
elseif ( (denot_boolean(is_email($comment[0]['comment_author_email']))))
 return array(new IXR_Error(array(403,false),__(array('A valid email address is required',false))),false);
}}}arrayAssign($comment[0],deAspis(registerTaint(array('comment_parent',false))),addTaint(((isset($content_struct[0][('comment_parent')]) && Aspis_isset( $content_struct [0][('comment_parent')]))) ? absint($content_struct[0]['comment_parent']) : array(0,false)));
arrayAssign($comment[0],deAspis(registerTaint(array('comment_content',false))),addTaint($content_struct[0]['content']));
do_action(array('xmlrpc_call',false),array('wp.newComment',false));
return wp_new_comment($comment);
} }
function wp_getCommentStatusList ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('moderate_comments',false)))))
 return array(new IXR_Error(array(403,false),__(array('You are not allowed access to details about this blog.',false))),false);
do_action(array('xmlrpc_call',false),array('wp.getCommentStatusList',false));
return get_comment_statuses();
} }
function wp_getCommentCount ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$post_id = int_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 {return array(new IXR_Error(array(403,false),__(array('You are not allowed access to details about comments.',false))),false);
}do_action(array('xmlrpc_call',false),array('wp.getCommentCount',false));
$count = wp_count_comments($post_id);
return array(array(deregisterTaint(array("approved",false)) => addTaint($count[0]->approved),deregisterTaint(array("awaiting_moderation",false)) => addTaint($count[0]->moderated),deregisterTaint(array("spam",false)) => addTaint($count[0]->spam),deregisterTaint(array("total_comments",false)) => addTaint($count[0]->total_comments)),false);
} }
function wp_getPostStatusList ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 {return array(new IXR_Error(array(403,false),__(array('You are not allowed access to details about this blog.',false))),false);
}do_action(array('xmlrpc_call',false),array('wp.getPostStatusList',false));
return get_post_statuses();
} }
function wp_getPageStatusList ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 {return array(new IXR_Error(array(403,false),__(array('You are not allowed access to details about this blog.',false))),false);
}do_action(array('xmlrpc_call',false),array('wp.getPageStatusList',false));
return get_page_statuses();
} }
function wp_getPageTemplates ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_pages',false)))))
 {return array(new IXR_Error(array(403,false),__(array('You are not allowed access to details about this blog.',false))),false);
}$templates = get_page_templates();
arrayAssign($templates[0],deAspis(registerTaint(array('Default',false))),addTaint(array('default',false)));
return $templates;
} }
function wp_getOptions ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$options = array_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (count($options[0]) == (0)))
 {$options = attAspisRC(array_keys(deAspisRC($this->blog_options)));
}return $this->_getOptions($options);
} }
function _getOptions ( $options ) {
{$data = array(array(),false);
foreach ( $options[0] as $option  )
{if ( array_key_exists(deAspisRC($option),deAspisRC($this->blog_options)))
 {arrayAssign($data[0],deAspis(registerTaint($option)),addTaint($this->blog_options[0][$option[0]]));
if ( ((isset($data[0][$option[0]][0][('option')]) && Aspis_isset( $data [0][$option[0]] [0][('option')]))))
 {arrayAssign($data[0][$option[0]][0],deAspis(registerTaint(array('value',false))),addTaint(get_option($data[0][$option[0]][0]['option'])));
unset($data[0][$option[0]][0][('option')]);
}}}return $data;
} }
function wp_setOptions ( $args ) {
{$this->escape($args);
$blog_id = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$options = array_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 return array(new IXR_Error(array(403,false),__(array('You are not allowed to update options.',false))),false);
foreach ( $options[0] as $o_name =>$o_value )
{restoreTaint($o_name,$o_value);
{arrayAssignAdd($option_names[0][],addTaint($o_name));
if ( (!(array_key_exists(deAspisRC($o_name),deAspisRC($this->blog_options)))))
 continue ;
if ( ($this->blog_options[0][$o_name[0]][0][('readonly')][0] == true))
 continue ;
update_option($this->blog_options[0][$o_name[0]][0][('option')],$o_value);
}}return $this->_getOptions($option_names);
} }
function blogger_getUsersBlogs ( $args ) {
{$this->escape($args);
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('blogger.getUsersBlogs',false));
$is_admin = current_user_can(array('manage_options',false));
$struct = array(array(deregisterTaint(array('isAdmin',false)) => addTaint($is_admin),deregisterTaint(array('url',false)) => addTaint(concat2(get_option(array('home',false)),'/')),'blogid' => array('1',false,false),deregisterTaint(array('blogName',false)) => addTaint(get_option(array('blogname',false))),deregisterTaint(array('xmlrpc',false)) => addTaint(site_url(array('xmlrpc.php',false)))),false);
return array(array($struct),false);
} }
function blogger_getUserInfo ( $args ) {
{$this->escape($args);
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you do not have access to user data on this blog.',false))),false);
do_action(array('xmlrpc_call',false),array('blogger.getUserInfo',false));
$struct = array(array(deregisterTaint(array('nickname',false)) => addTaint($user[0]->nickname),deregisterTaint(array('userid',false)) => addTaint($user[0]->ID),deregisterTaint(array('url',false)) => addTaint($user[0]->user_url),deregisterTaint(array('lastname',false)) => addTaint($user[0]->last_name),deregisterTaint(array('firstname',false)) => addTaint($user[0]->first_name)),false);
return $struct;
} }
function blogger_getPost ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit this post.',false))),false);
do_action(array('xmlrpc_call',false),array('blogger.getPost',false));
$post_data = wp_get_single_post($post_ID,array(ARRAY_A,false));
$categories = Aspis_implode(array(',',false),wp_get_post_categories($post_ID));
$content = concat2(concat1('<title>',Aspis_stripslashes($post_data[0]['post_title'])),'</title>');
$content = concat($content,concat2(concat1('<category>',$categories),'</category>'));
$content = concat($content,Aspis_stripslashes($post_data[0]['post_content']));
$struct = array(array(deregisterTaint(array('userid',false)) => addTaint($post_data[0]['post_author']),'dateCreated' => array(new IXR_Date(mysql2date(array('Ymd\TH:i:s',false),$post_data[0]['post_date'],array(false,false))),false,false),deregisterTaint(array('content',false)) => addTaint($content),deregisterTaint(array('postid',false)) => addTaint($post_data[0]['ID'])),false);
return $struct;
} }
function blogger_getRecentPosts ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
$num_posts = attachAspis($args,(4));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('blogger.getRecentPosts',false));
$posts_list = wp_get_recent_posts($num_posts);
if ( (denot_boolean($posts_list)))
 {$this->error = array(new IXR_Error(array(500,false),__(array('Either there are no posts, or something went wrong.',false))),false);
return $this->error;
}foreach ( $posts_list[0] as $entry  )
{if ( (denot_boolean(current_user_can(array('edit_post',false),$entry[0]['ID']))))
 continue ;
$post_date = mysql2date(array('Ymd\TH:i:s',false),$entry[0]['post_date'],array(false,false));
$categories = Aspis_implode(array(',',false),wp_get_post_categories($entry[0]['ID']));
$content = concat2(concat1('<title>',Aspis_stripslashes($entry[0]['post_title'])),'</title>');
$content = concat($content,concat2(concat1('<category>',$categories),'</category>'));
$content = concat($content,Aspis_stripslashes($entry[0]['post_content']));
arrayAssignAdd($struct[0][],addTaint(array(array(deregisterTaint(array('userid',false)) => addTaint($entry[0]['post_author']),'dateCreated' => array(new IXR_Date($post_date),false,false),deregisterTaint(array('content',false)) => addTaint($content),deregisterTaint(array('postid',false)) => addTaint($entry[0]['ID']),),false)));
}$recent_posts = array(array(),false);
for ( $j = array(0,false) ; ($j[0] < count($struct[0])) ; postincr($j) )
{Aspis_array_push($recent_posts,attachAspis($struct,$j[0]));
}return $recent_posts;
} }
function blogger_getTemplate ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
$template = attachAspis($args,(4));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('blogger.getTemplate',false));
if ( (denot_boolean(current_user_can(array('edit_themes',false)))))
 {return array(new IXR_Error(array(401,false),__(array('Sorry, this user can not edit the template.',false))),false);
}$filename = concat2(get_option(array('home',false)),'/');
$filename = Aspis_preg_replace(array('#https?://.+?/#',false),concat2($_SERVER[0]['DOCUMENT_ROOT'],'/'),$filename);
$f = attAspis(fopen($filename[0],('r')));
$content = attAspis(fread($f[0],filesize($filename[0])));
fclose($f[0]);
return $content;
} }
function blogger_setTemplate ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
$content = attachAspis($args,(4));
$template = attachAspis($args,(5));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('blogger.setTemplate',false));
if ( (denot_boolean(current_user_can(array('edit_themes',false)))))
 {return array(new IXR_Error(array(401,false),__(array('Sorry, this user cannot edit the template.',false))),false);
}$filename = concat2(get_option(array('home',false)),'/');
$filename = Aspis_preg_replace(array('#https?://.+?/#',false),concat2($_SERVER[0]['DOCUMENT_ROOT'],'/'),$filename);
if ( deAspis($f = attAspis(fopen($filename[0],('w+')))))
 {fwrite($f[0],$content[0]);
fclose($f[0]);
}else 
{{return array(new IXR_Error(array(500,false),__(array('Either the file is not writable, or something wrong happened. The file has not been updated.',false))),false);
}}return array(true,false);
} }
function blogger_newPost ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
$content = attachAspis($args,(4));
$publish = attachAspis($args,(5));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('blogger.newPost',false));
$cap = deAspis(($publish)) ? array('publish_posts',false) : array('edit_posts',false);
if ( (denot_boolean(current_user_can($cap))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you are not allowed to post on this blog.',false))),false);
$post_status = deAspis(($publish)) ? array('publish',false) : array('draft',false);
$post_author = $user[0]->ID;
$post_title = xmlrpc_getposttitle($content);
$post_category = xmlrpc_getpostcategory($content);
$post_content = xmlrpc_removepostdata($content);
$post_date = current_time(array('mysql',false));
$post_date_gmt = current_time(array('mysql',false),array(1,false));
$post_data = array(compact('blog_ID','post_author','post_date','post_date_gmt','post_content','post_title','post_category','post_status'),false);
$post_ID = wp_insert_post($post_data);
if ( deAspis(is_wp_error($post_ID)))
 return array(new IXR_Error(array(500,false),$post_ID[0]->get_error_message()),false);
if ( (denot_boolean($post_ID)))
 return array(new IXR_Error(array(500,false),__(array('Sorry, your entry could not be posted. Something wrong happened.',false))),false);
$this->attach_uploads($post_ID,$post_content);
logIO(array('O',false),concat1("Posted ! ID: ",$post_ID));
return $post_ID;
} }
function blogger_editPost ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
$content = attachAspis($args,(4));
$publish = attachAspis($args,(5));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('blogger.editPost',false));
$actual_post = wp_get_single_post($post_ID,array(ARRAY_A,false));
if ( ((denot_boolean($actual_post)) || (deAspis($actual_post[0]['post_type']) != ('post'))))
 {return array(new IXR_Error(array(404,false),__(array('Sorry, no such post.',false))),false);
}$this->escape($actual_post);
if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you do not have the right to edit this post.',false))),false);
extract(($actual_post[0]),EXTR_SKIP);
if ( ((('publish') == $post_status[0]) && (denot_boolean(current_user_can(array('publish_posts',false))))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you do not have the right to publish this post.',false))),false);
$post_title = xmlrpc_getposttitle($content);
$post_category = xmlrpc_getpostcategory($content);
$post_content = xmlrpc_removepostdata($content);
$postdata = array(compact('ID','post_content','post_title','post_category','post_status','post_excerpt'),false);
$result = wp_update_post($postdata);
if ( (denot_boolean($result)))
 {return array(new IXR_Error(array(500,false),__(array('For some strange yet very annoying reason, this post could not be edited.',false))),false);
}$this->attach_uploads($ID,$post_content);
return array(true,false);
} }
function blogger_deletePost ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(1)));
$username = attachAspis($args,(2));
$password = attachAspis($args,(3));
$publish = attachAspis($args,(4));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('blogger.deletePost',false));
$actual_post = wp_get_single_post($post_ID,array(ARRAY_A,false));
if ( ((denot_boolean($actual_post)) || (deAspis($actual_post[0]['post_type']) != ('post'))))
 {return array(new IXR_Error(array(404,false),__(array('Sorry, no such post.',false))),false);
}if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you do not have the right to delete this post.',false))),false);
$result = wp_delete_post($post_ID);
if ( (denot_boolean($result)))
 {return array(new IXR_Error(array(500,false),__(array('For some strange yet very annoying reason, this post could not be deleted.',false))),false);
}return array(true,false);
} }
function mw_newPost ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$content_struct = attachAspis($args,(3));
$publish = attachAspis($args,(4));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('metaWeblog.newPost',false));
$cap = deAspis(($publish)) ? array('publish_posts',false) : array('edit_posts',false);
$error_message = __(array('Sorry, you are not allowed to publish posts on this blog.',false));
$post_type = array('post',false);
$page_template = array('',false);
if ( (!((empty($content_struct[0][('post_type')]) || Aspis_empty( $content_struct [0][('post_type')])))))
 {if ( (deAspis($content_struct[0]['post_type']) == ('page')))
 {$cap = deAspis(($publish)) ? array('publish_pages',false) : array('edit_pages',false);
$error_message = __(array('Sorry, you are not allowed to publish pages on this blog.',false));
$post_type = array('page',false);
if ( (!((empty($content_struct[0][('wp_page_template')]) || Aspis_empty( $content_struct [0][('wp_page_template')])))))
 $page_template = $content_struct[0]['wp_page_template'];
}elseif ( (deAspis($content_struct[0]['post_type']) == ('post')))
 {}else 
{{return array(new IXR_Error(array(401,false),__(array('Invalid post type.',false))),false);
}}}if ( (denot_boolean(current_user_can($cap))))
 {return array(new IXR_Error(array(401,false),$error_message),false);
}$post_name = array("",false);
if ( ((isset($content_struct[0][("wp_slug")]) && Aspis_isset( $content_struct [0][("wp_slug")]))))
 {$post_name = $content_struct[0]["wp_slug"];
}if ( ((isset($content_struct[0][("wp_password")]) && Aspis_isset( $content_struct [0][("wp_password")]))))
 {$post_password = $content_struct[0]["wp_password"];
}if ( ((isset($content_struct[0][("wp_page_parent_id")]) && Aspis_isset( $content_struct [0][("wp_page_parent_id")]))))
 {$post_parent = $content_struct[0]["wp_page_parent_id"];
}if ( ((isset($content_struct[0][("wp_page_order")]) && Aspis_isset( $content_struct [0][("wp_page_order")]))))
 {$menu_order = $content_struct[0]["wp_page_order"];
}$post_author = $user[0]->ID;
if ( (((isset($content_struct[0][("wp_author_id")]) && Aspis_isset( $content_struct [0][("wp_author_id")]))) && ($user[0]->ID[0] != deAspis($content_struct[0]["wp_author_id"]))))
 {switch ( $post_type[0] ) {
case ("post"):if ( (denot_boolean(current_user_can(array("edit_others_posts",false)))))
 {return (array(new IXR_Error(array(401,false),__(array("You are not allowed to post as this user",false))),false));
}break ;
case ("page"):if ( (denot_boolean(current_user_can(array("edit_others_pages",false)))))
 {return (array(new IXR_Error(array(401,false),__(array("You are not allowed to create pages as this user",false))),false));
}break ;
default :return (array(new IXR_Error(array(401,false),__(array("Invalid post type.",false))),false));
break ;
 }
$post_author = $content_struct[0]["wp_author_id"];
}$post_title = $content_struct[0]['title'];
$post_content = $content_struct[0]['description'];
$post_status = $publish[0] ? array('publish',false) : array('draft',false);
if ( ((isset($content_struct[0][(deconcat2($post_type,"_status"))]) && Aspis_isset( $content_struct [0][(deconcat2( $post_type,"_status"))]))))
 {switch ( deAspis(attachAspis($content_struct,(deconcat2($post_type,"_status")))) ) {
case ('draft'):case ('private'):case ('publish'):$post_status = attachAspis($content_struct,(deconcat2($post_type,"_status")));
break ;
case ('pending'):if ( ($post_type[0] === ('post')))
 {$post_status = attachAspis($content_struct,(deconcat2($post_type,"_status")));
}break ;
default :$post_status = $publish[0] ? array('publish',false) : array('draft',false);
break ;
 }
}$post_excerpt = $content_struct[0]['mt_excerpt'];
$post_more = $content_struct[0]['mt_text_more'];
$tags_input = $content_struct[0]['mt_keywords'];
if ( ((isset($content_struct[0][("mt_allow_comments")]) && Aspis_isset( $content_struct [0][("mt_allow_comments")]))))
 {if ( (!(is_numeric(deAspisRC($content_struct[0]["mt_allow_comments"])))))
 {switch ( deAspis($content_struct[0]["mt_allow_comments"]) ) {
case ("closed"):$comment_status = array("closed",false);
break ;
case ("open"):$comment_status = array("open",false);
break ;
default :$comment_status = get_option(array("default_comment_status",false));
break ;
 }
}else 
{{switch ( deAspis(int_cast($content_struct[0]["mt_allow_comments"])) ) {
case (0):case (2):$comment_status = array("closed",false);
break ;
case (1):$comment_status = array("open",false);
break ;
default :$comment_status = get_option(array("default_comment_status",false));
break ;
 }
}}}else 
{{$comment_status = get_option(array("default_comment_status",false));
}}if ( ((isset($content_struct[0][("mt_allow_pings")]) && Aspis_isset( $content_struct [0][("mt_allow_pings")]))))
 {if ( (!(is_numeric(deAspisRC($content_struct[0]["mt_allow_pings"])))))
 {switch ( deAspis($content_struct[0]['mt_allow_pings']) ) {
case ("closed"):$ping_status = array("closed",false);
break ;
case ("open"):$ping_status = array("open",false);
break ;
default :$ping_status = get_option(array("default_ping_status",false));
break ;
 }
}else 
{{switch ( deAspis(int_cast($content_struct[0]["mt_allow_pings"])) ) {
case (0):$ping_status = array("closed",false);
break ;
case (1):$ping_status = array("open",false);
break ;
default :$ping_status = get_option(array("default_ping_status",false));
break ;
 }
}}}else 
{{$ping_status = get_option(array("default_ping_status",false));
}}if ( $post_more[0])
 {$post_content = concat(concat2($post_content,"<!--more-->"),$post_more);
}$to_ping = $content_struct[0]['mt_tb_ping_urls'];
if ( is_array($to_ping[0]))
 $to_ping = Aspis_implode(array(' ',false),$to_ping);
if ( (!((empty($content_struct[0][('date_created_gmt')]) || Aspis_empty( $content_struct [0][('date_created_gmt')])))))
 $dateCreated = concat2(Aspis_str_replace(array('Z',false),array('',false),$content_struct[0][('date_created_gmt')][0]->getIso()),'Z');
elseif ( (!((empty($content_struct[0][('dateCreated')]) || Aspis_empty( $content_struct [0][('dateCreated')])))))
 $dateCreated = $content_struct[0][('dateCreated')][0]->getIso();
if ( (!((empty($dateCreated) || Aspis_empty( $dateCreated)))))
 {$post_date = get_date_from_gmt(iso8601_to_datetime($dateCreated));
$post_date_gmt = iso8601_to_datetime($dateCreated,array(GMT,false));
}else 
{{$post_date = current_time(array('mysql',false));
$post_date_gmt = current_time(array('mysql',false),array(1,false));
}}$catnames = $content_struct[0]['categories'];
logIO(array('O',false),concat1('Post cats: ',Aspis_var_export($catnames,array(true,false))));
$post_category = array(array(),false);
if ( is_array($catnames[0]))
 {foreach ( $catnames[0] as $cat  )
{arrayAssignAdd($post_category[0][],addTaint(get_cat_ID($cat)));
}}$postdata = array(compact('post_author','post_date','post_date_gmt','post_content','post_title','post_category','post_status','post_excerpt','comment_status','ping_status','to_ping','post_type','post_name','post_password','post_parent','menu_order','tags_input','page_template'),false);
$post_ID = wp_insert_post($postdata,array(true,false));
if ( deAspis(is_wp_error($post_ID)))
 return array(new IXR_Error(array(500,false),$post_ID[0]->get_error_message()),false);
if ( (denot_boolean($post_ID)))
 {return array(new IXR_Error(array(500,false),__(array('Sorry, your entry could not be posted. Something wrong happened.',false))),false);
}if ( (($post_type[0] == ('post')) && ((isset($content_struct[0][('sticky')]) && Aspis_isset( $content_struct [0][('sticky')])))))
 if ( (deAspis($content_struct[0]['sticky']) == true))
 stick_post($post_ID);
elseif ( (deAspis($content_struct[0]['sticky']) == false))
 unstick_post($post_ID);
if ( ((isset($content_struct[0][('custom_fields')]) && Aspis_isset( $content_struct [0][('custom_fields')]))))
 {$this->set_custom_fields($post_ID,$content_struct[0]['custom_fields']);
}$this->add_enclosure_if_new($post_ID,$content_struct[0]['enclosure']);
$this->attach_uploads($post_ID,$post_content);
logIO(array('O',false),concat1("Posted ! ID: ",$post_ID));
return Aspis_strval($post_ID);
} }
function add_enclosure_if_new ( $post_ID,$enclosure ) {
{if ( (((is_array($enclosure[0]) && ((isset($enclosure[0][('url')]) && Aspis_isset( $enclosure [0][('url')])))) && ((isset($enclosure[0][('length')]) && Aspis_isset( $enclosure [0][('length')])))) && ((isset($enclosure[0][('type')]) && Aspis_isset( $enclosure [0][('type')])))))
 {$encstring = concat(concat2(concat(concat2($enclosure[0]['url'],"\n"),$enclosure[0]['length']),"\n"),$enclosure[0]['type']);
$found = array(false,false);
foreach ( deAspis(array_cast(get_post_custom($post_ID))) as $key =>$val )
{restoreTaint($key,$val);
{if ( ($key[0] == ('enclosure')))
 {foreach ( deAspis(array_cast($val)) as $enc  )
{if ( ($enc[0] == $encstring[0]))
 {$found = array(true,false);
break (2);
}}}}}if ( (denot_boolean($found)))
 {add_post_meta($post_ID,array('enclosure',false),$encstring);
}}} }
function attach_uploads ( $post_ID,$post_content ) {
{global $wpdb;
$attachments = $wpdb[0]->get_results(concat2(concat1("SELECT ID, guid FROM ",$wpdb[0]->posts)," WHERE post_parent = '0' AND post_type = 'attachment'"));
if ( is_array($attachments[0]))
 {foreach ( $attachments[0] as $file  )
{if ( (strpos($post_content[0],deAspisRC($file[0]->guid)) !== false))
 {$wpdb[0]->update($wpdb[0]->posts,array(array(deregisterTaint(array('post_parent',false)) => addTaint($post_ID)),false),array(array(deregisterTaint(array('ID',false)) => addTaint($file[0]->ID)),false));
}}}} }
function mw_editPost ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$content_struct = attachAspis($args,(3));
$publish = attachAspis($args,(4));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('metaWeblog.editPost',false));
$cap = deAspis(($publish)) ? array('publish_posts',false) : array('edit_posts',false);
$error_message = __(array('Sorry, you are not allowed to publish posts on this blog.',false));
$post_type = array('post',false);
$page_template = array('',false);
if ( (!((empty($content_struct[0][('post_type')]) || Aspis_empty( $content_struct [0][('post_type')])))))
 {if ( (deAspis($content_struct[0]['post_type']) == ('page')))
 {$cap = deAspis(($publish)) ? array('publish_pages',false) : array('edit_pages',false);
$error_message = __(array('Sorry, you are not allowed to publish pages on this blog.',false));
$post_type = array('page',false);
if ( (!((empty($content_struct[0][('wp_page_template')]) || Aspis_empty( $content_struct [0][('wp_page_template')])))))
 $page_template = $content_struct[0]['wp_page_template'];
}elseif ( (deAspis($content_struct[0]['post_type']) == ('post')))
 {}else 
{{return array(new IXR_Error(array(401,false),__(array('Invalid post type.',false))),false);
}}}if ( (denot_boolean(current_user_can($cap))))
 {return array(new IXR_Error(array(401,false),$error_message),false);
}$postdata = wp_get_single_post($post_ID,array(ARRAY_A,false));
if ( ((empty($postdata[0][("ID")]) || Aspis_empty( $postdata [0][("ID")]))))
 {return (array(new IXR_Error(array(404,false),__(array("Invalid post ID.",false))),false));
}$this->escape($postdata);
extract(($postdata[0]),EXTR_SKIP);
$post_name = array("",false);
if ( ((isset($content_struct[0][("wp_slug")]) && Aspis_isset( $content_struct [0][("wp_slug")]))))
 {$post_name = $content_struct[0]["wp_slug"];
}if ( ((isset($content_struct[0][("wp_password")]) && Aspis_isset( $content_struct [0][("wp_password")]))))
 {$post_password = $content_struct[0]["wp_password"];
}if ( ((isset($content_struct[0][("wp_page_parent_id")]) && Aspis_isset( $content_struct [0][("wp_page_parent_id")]))))
 {$post_parent = $content_struct[0]["wp_page_parent_id"];
}if ( ((isset($content_struct[0][("wp_page_order")]) && Aspis_isset( $content_struct [0][("wp_page_order")]))))
 {$menu_order = $content_struct[0]["wp_page_order"];
}$post_author = $postdata[0]["post_author"];
if ( (((isset($content_struct[0][("wp_author_id")]) && Aspis_isset( $content_struct [0][("wp_author_id")]))) && ($user[0]->ID[0] != deAspis($content_struct[0]["wp_author_id"]))))
 {switch ( $post_type[0] ) {
case ("post"):if ( (denot_boolean(current_user_can(array("edit_others_posts",false)))))
 {return (array(new IXR_Error(array(401,false),__(array("You are not allowed to change the post author as this user.",false))),false));
}break ;
case ("page"):if ( (denot_boolean(current_user_can(array("edit_others_pages",false)))))
 {return (array(new IXR_Error(array(401,false),__(array("You are not allowed to change the page author as this user.",false))),false));
}break ;
default :return (array(new IXR_Error(array(401,false),__(array("Invalid post type.",false))),false));
break ;
 }
$post_author = $content_struct[0]["wp_author_id"];
}if ( ((isset($content_struct[0][("mt_allow_comments")]) && Aspis_isset( $content_struct [0][("mt_allow_comments")]))))
 {if ( (!(is_numeric(deAspisRC($content_struct[0]["mt_allow_comments"])))))
 {switch ( deAspis($content_struct[0]["mt_allow_comments"]) ) {
case ("closed"):$comment_status = array("closed",false);
break ;
case ("open"):$comment_status = array("open",false);
break ;
default :$comment_status = get_option(array("default_comment_status",false));
break ;
 }
}else 
{{switch ( deAspis(int_cast($content_struct[0]["mt_allow_comments"])) ) {
case (0):case (2):$comment_status = array("closed",false);
break ;
case (1):$comment_status = array("open",false);
break ;
default :$comment_status = get_option(array("default_comment_status",false));
break ;
 }
}}}if ( ((isset($content_struct[0][("mt_allow_pings")]) && Aspis_isset( $content_struct [0][("mt_allow_pings")]))))
 {if ( (!(is_numeric(deAspisRC($content_struct[0]["mt_allow_pings"])))))
 {switch ( deAspis($content_struct[0]["mt_allow_pings"]) ) {
case ("closed"):$ping_status = array("closed",false);
break ;
case ("open"):$ping_status = array("open",false);
break ;
default :$ping_status = get_option(array("default_ping_status",false));
break ;
 }
}else 
{{switch ( deAspis(int_cast($content_struct[0]["mt_allow_pings"])) ) {
case (0):$ping_status = array("closed",false);
break ;
case (1):$ping_status = array("open",false);
break ;
default :$ping_status = get_option(array("default_ping_status",false));
break ;
 }
}}}$post_title = $content_struct[0]['title'];
$post_content = $content_struct[0]['description'];
$catnames = $content_struct[0]['categories'];
$post_category = array(array(),false);
if ( is_array($catnames[0]))
 {foreach ( $catnames[0] as $cat  )
{arrayAssignAdd($post_category[0][],addTaint(get_cat_ID($cat)));
}}$post_excerpt = $content_struct[0]['mt_excerpt'];
$post_more = $content_struct[0]['mt_text_more'];
$post_status = $publish[0] ? array('publish',false) : array('draft',false);
if ( ((isset($content_struct[0][(deconcat2($post_type,"_status"))]) && Aspis_isset( $content_struct [0][(deconcat2( $post_type,"_status"))]))))
 {switch ( deAspis(attachAspis($content_struct,(deconcat2($post_type,"_status")))) ) {
case ('draft'):case ('private'):case ('publish'):$post_status = attachAspis($content_struct,(deconcat2($post_type,"_status")));
break ;
case ('pending'):if ( ($post_type[0] === ('post')))
 {$post_status = attachAspis($content_struct,(deconcat2($post_type,"_status")));
}break ;
default :$post_status = $publish[0] ? array('publish',false) : array('draft',false);
break ;
 }
}$tags_input = $content_struct[0]['mt_keywords'];
if ( (('publish') == $post_status[0]))
 {if ( ((('page') == $post_type[0]) && (denot_boolean(current_user_can(array('publish_pages',false))))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you do not have the right to publish this page.',false))),false);
else 
{if ( (denot_boolean(current_user_can(array('publish_posts',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you do not have the right to publish this post.',false))),false);
}}if ( $post_more[0])
 {$post_content = concat(concat2($post_content,"<!--more-->"),$post_more);
}$to_ping = $content_struct[0]['mt_tb_ping_urls'];
if ( is_array($to_ping[0]))
 $to_ping = Aspis_implode(array(' ',false),$to_ping);
if ( (!((empty($content_struct[0][('date_created_gmt')]) || Aspis_empty( $content_struct [0][('date_created_gmt')])))))
 $dateCreated = concat2(Aspis_str_replace(array('Z',false),array('',false),$content_struct[0][('date_created_gmt')][0]->getIso()),'Z');
elseif ( (!((empty($content_struct[0][('dateCreated')]) || Aspis_empty( $content_struct [0][('dateCreated')])))))
 $dateCreated = $content_struct[0][('dateCreated')][0]->getIso();
if ( (!((empty($dateCreated) || Aspis_empty( $dateCreated)))))
 {$post_date = get_date_from_gmt(iso8601_to_datetime($dateCreated));
$post_date_gmt = iso8601_to_datetime($dateCreated,array(GMT,false));
}else 
{{$post_date = $postdata[0]['post_date'];
$post_date_gmt = $postdata[0]['post_date_gmt'];
}}$newpost = array(compact('ID','post_content','post_title','post_category','post_status','post_excerpt','comment_status','ping_status','post_date','post_date_gmt','to_ping','post_name','post_password','post_parent','menu_order','post_author','tags_input','page_template'),false);
$result = wp_update_post($newpost,array(true,false));
if ( deAspis(is_wp_error($result)))
 return array(new IXR_Error(array(500,false),$result[0]->get_error_message()),false);
if ( (denot_boolean($result)))
 {return array(new IXR_Error(array(500,false),__(array('Sorry, your entry could not be edited. Something wrong happened.',false))),false);
}if ( (($post_type[0] == ('post')) && ((isset($content_struct[0][('sticky')]) && Aspis_isset( $content_struct [0][('sticky')])))))
 if ( (deAspis($content_struct[0]['sticky']) == true))
 stick_post($post_ID);
elseif ( (deAspis($content_struct[0]['sticky']) == false))
 unstick_post($post_ID);
if ( ((isset($content_struct[0][('custom_fields')]) && Aspis_isset( $content_struct [0][('custom_fields')]))))
 {$this->set_custom_fields($post_ID,$content_struct[0]['custom_fields']);
}$this->add_enclosure_if_new($post_ID,$content_struct[0]['enclosure']);
$this->attach_uploads($ID,$post_content);
logIO(array('O',false),concat1("(MW) Edited ! ID: ",$post_ID));
return array(true,false);
} }
function mw_getPost ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit this post.',false))),false);
do_action(array('xmlrpc_call',false),array('metaWeblog.getPost',false));
$postdata = wp_get_single_post($post_ID,array(ARRAY_A,false));
if ( (deAspis($postdata[0]['post_date']) != ('')))
 {$post_date = mysql2date(array('Ymd\TH:i:s',false),$postdata[0]['post_date'],array(false,false));
$post_date_gmt = mysql2date(array('Ymd\TH:i:s',false),$postdata[0]['post_date_gmt'],array(false,false));
if ( (deAspis($postdata[0]['post_status']) == ('draft')))
 {$post_date_gmt = get_gmt_from_date(mysql2date(array('Y-m-d H:i:s',false),$postdata[0]['post_date']),array('Ymd\TH:i:s',false));
}$categories = array(array(),false);
$catids = wp_get_post_categories($post_ID);
foreach ( $catids[0] as $catid  )
arrayAssignAdd($categories[0][],addTaint(get_cat_name($catid)));
$tagnames = array(array(),false);
$tags = wp_get_post_tags($post_ID);
if ( (!((empty($tags) || Aspis_empty( $tags)))))
 {foreach ( $tags[0] as $tag  )
arrayAssignAdd($tagnames[0][],addTaint($tag[0]->name));
$tagnames = Aspis_implode(array(', ',false),$tagnames);
}else 
{{$tagnames = array('',false);
}}$post = get_extended($postdata[0]['post_content']);
$link = post_permalink($postdata[0]['ID']);
$author = get_userdata($postdata[0]['post_author']);
$allow_comments = (('open') == deAspis($postdata[0]['comment_status'])) ? array(1,false) : array(0,false);
$allow_pings = (('open') == deAspis($postdata[0]['ping_status'])) ? array(1,false) : array(0,false);
if ( (deAspis($postdata[0]['post_status']) === ('future')))
 {arrayAssign($postdata[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('publish',false)));
}$sticky = array(false,false);
if ( deAspis(is_sticky($post_ID)))
 $sticky = array(true,false);
$enclosure = array(array(),false);
foreach ( deAspis(array_cast(get_post_custom($post_ID))) as $key =>$val )
{restoreTaint($key,$val);
{if ( ($key[0] == ('enclosure')))
 {foreach ( deAspis(array_cast($val)) as $enc  )
{$encdata = Aspis_split(array("\n",false),$enc);
arrayAssign($enclosure[0],deAspis(registerTaint(array('url',false))),addTaint(Aspis_trim(Aspis_htmlspecialchars(attachAspis($encdata,(0))))));
arrayAssign($enclosure[0],deAspis(registerTaint(array('length',false))),addTaint(Aspis_trim(attachAspis($encdata,(1)))));
arrayAssign($enclosure[0],deAspis(registerTaint(array('type',false))),addTaint(Aspis_trim(attachAspis($encdata,(2)))));
break (2);
}}}}$resp = array(array('dateCreated' => array(new IXR_Date($post_date),false,false),deregisterTaint(array('userid',false)) => addTaint($postdata[0]['post_author']),deregisterTaint(array('postid',false)) => addTaint($postdata[0]['ID']),deregisterTaint(array('description',false)) => addTaint($post[0]['main']),deregisterTaint(array('title',false)) => addTaint($postdata[0]['post_title']),deregisterTaint(array('link',false)) => addTaint($link),deregisterTaint(array('permaLink',false)) => addTaint($link),deregisterTaint(array('categories',false)) => addTaint($categories),deregisterTaint(array('mt_excerpt',false)) => addTaint($postdata[0]['post_excerpt']),deregisterTaint(array('mt_text_more',false)) => addTaint($post[0]['extended']),deregisterTaint(array('mt_allow_comments',false)) => addTaint($allow_comments),deregisterTaint(array('mt_allow_pings',false)) => addTaint($allow_pings),deregisterTaint(array('mt_keywords',false)) => addTaint($tagnames),deregisterTaint(array('wp_slug',false)) => addTaint($postdata[0]['post_name']),deregisterTaint(array('wp_password',false)) => addTaint($postdata[0]['post_password']),deregisterTaint(array('wp_author_id',false)) => addTaint($author[0]->ID),deregisterTaint(array('wp_author_display_name',false)) => addTaint($author[0]->display_name),'date_created_gmt' => array(new IXR_Date($post_date_gmt),false,false),deregisterTaint(array('post_status',false)) => addTaint($postdata[0]['post_status']),deregisterTaint(array('custom_fields',false)) => addTaint($this->get_custom_fields($post_ID)),deregisterTaint(array('sticky',false)) => addTaint($sticky)),false);
if ( (!((empty($enclosure) || Aspis_empty( $enclosure)))))
 arrayAssign($resp[0],deAspis(registerTaint(array('enclosure',false))),addTaint($enclosure));
return $resp;
}else 
{{return array(new IXR_Error(array(404,false),__(array('Sorry, no such post.',false))),false);
}}} }
function mw_getRecentPosts ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$num_posts = int_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('metaWeblog.getRecentPosts',false));
$posts_list = wp_get_recent_posts($num_posts);
if ( (denot_boolean($posts_list)))
 {return array(array(),false);
}foreach ( $posts_list[0] as $entry  )
{if ( (denot_boolean(current_user_can(array('edit_post',false),$entry[0]['ID']))))
 continue ;
$post_date = mysql2date(array('Ymd\TH:i:s',false),$entry[0]['post_date'],array(false,false));
$post_date_gmt = mysql2date(array('Ymd\TH:i:s',false),$entry[0]['post_date_gmt'],array(false,false));
if ( (deAspis($entry[0]['post_status']) == ('draft')))
 {$post_date_gmt = get_gmt_from_date(mysql2date(array('Y-m-d H:i:s',false),$entry[0]['post_date']),array('Ymd\TH:i:s',false));
}$categories = array(array(),false);
$catids = wp_get_post_categories($entry[0]['ID']);
foreach ( $catids[0] as $catid  )
{arrayAssignAdd($categories[0][],addTaint(get_cat_name($catid)));
}$tagnames = array(array(),false);
$tags = wp_get_post_tags($entry[0]['ID']);
if ( (!((empty($tags) || Aspis_empty( $tags)))))
 {foreach ( $tags[0] as $tag  )
{arrayAssignAdd($tagnames[0][],addTaint($tag[0]->name));
}$tagnames = Aspis_implode(array(', ',false),$tagnames);
}else 
{{$tagnames = array('',false);
}}$post = get_extended($entry[0]['post_content']);
$link = post_permalink($entry[0]['ID']);
$author = get_userdata($entry[0]['post_author']);
$allow_comments = (('open') == deAspis($entry[0]['comment_status'])) ? array(1,false) : array(0,false);
$allow_pings = (('open') == deAspis($entry[0]['ping_status'])) ? array(1,false) : array(0,false);
if ( (deAspis($entry[0]['post_status']) === ('future')))
 {arrayAssign($entry[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('publish',false)));
}arrayAssignAdd($struct[0][],addTaint(array(array('dateCreated' => array(new IXR_Date($post_date),false,false),deregisterTaint(array('userid',false)) => addTaint($entry[0]['post_author']),deregisterTaint(array('postid',false)) => addTaint($entry[0]['ID']),deregisterTaint(array('description',false)) => addTaint($post[0]['main']),deregisterTaint(array('title',false)) => addTaint($entry[0]['post_title']),deregisterTaint(array('link',false)) => addTaint($link),deregisterTaint(array('permaLink',false)) => addTaint($link),deregisterTaint(array('categories',false)) => addTaint($categories),deregisterTaint(array('mt_excerpt',false)) => addTaint($entry[0]['post_excerpt']),deregisterTaint(array('mt_text_more',false)) => addTaint($post[0]['extended']),deregisterTaint(array('mt_allow_comments',false)) => addTaint($allow_comments),deregisterTaint(array('mt_allow_pings',false)) => addTaint($allow_pings),deregisterTaint(array('mt_keywords',false)) => addTaint($tagnames),deregisterTaint(array('wp_slug',false)) => addTaint($entry[0]['post_name']),deregisterTaint(array('wp_password',false)) => addTaint($entry[0]['post_password']),deregisterTaint(array('wp_author_id',false)) => addTaint($author[0]->ID),deregisterTaint(array('wp_author_display_name',false)) => addTaint($author[0]->display_name),'date_created_gmt' => array(new IXR_Date($post_date_gmt),false,false),deregisterTaint(array('post_status',false)) => addTaint($entry[0]['post_status']),deregisterTaint(array('custom_fields',false)) => addTaint($this->get_custom_fields($entry[0]['ID']))),false)));
}$recent_posts = array(array(),false);
for ( $j = array(0,false) ; ($j[0] < count($struct[0])) ; postincr($j) )
{Aspis_array_push($recent_posts,attachAspis($struct,$j[0]));
}return $recent_posts;
} }
function mw_getCategories ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you must be able to edit posts on this blog in order to view categories.',false))),false);
do_action(array('xmlrpc_call',false),array('metaWeblog.getCategories',false));
$categories_struct = array(array(),false);
if ( deAspis($cats = get_categories(array('get=all',false))))
 {foreach ( $cats[0] as $cat  )
{arrayAssign($struct[0],deAspis(registerTaint(array('categoryId',false))),addTaint($cat[0]->term_id));
arrayAssign($struct[0],deAspis(registerTaint(array('parentId',false))),addTaint($cat[0]->parent));
arrayAssign($struct[0],deAspis(registerTaint(array('description',false))),addTaint($cat[0]->name));
arrayAssign($struct[0],deAspis(registerTaint(array('categoryDescription',false))),addTaint($cat[0]->description));
arrayAssign($struct[0],deAspis(registerTaint(array('categoryName',false))),addTaint($cat[0]->name));
arrayAssign($struct[0],deAspis(registerTaint(array('htmlUrl',false))),addTaint(esc_html(get_category_link($cat[0]->term_id))));
arrayAssign($struct[0],deAspis(registerTaint(array('rssUrl',false))),addTaint(esc_html(get_category_feed_link($cat[0]->term_id,array('rss2',false)))));
arrayAssignAdd($categories_struct[0][],addTaint($struct));
}}return $categories_struct;
} }
function mw_newMediaObject ( $args ) {
{global $wpdb;
$blog_ID = int_cast(attachAspis($args,(0)));
$username = $wpdb[0]->escape(attachAspis($args,(1)));
$password = $wpdb[0]->escape(attachAspis($args,(2)));
$data = attachAspis($args,(3));
$name = sanitize_file_name($data[0]['name']);
$type = $data[0]['type'];
$bits = $data[0]['bits'];
logIO(array('O',false),concat2(concat1('(MW) Received ',attAspis(strlen($bits[0]))),' bytes'));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('metaWeblog.newMediaObject',false));
if ( (denot_boolean(current_user_can(array('upload_files',false)))))
 {logIO(array('O',false),array('(MW) User does not have upload_files capability',false));
$this->error = array(new IXR_Error(array(401,false),__(array('You are not allowed to upload files to this site.',false))),false);
return $this->error;
}if ( deAspis($upload_err = apply_filters(array("pre_upload_error",false),array(false,false))))
 return array(new IXR_Error(array(500,false),$upload_err),false);
if ( ((!((empty($data[0][("overwrite")]) || Aspis_empty( $data [0][("overwrite")])))) && (deAspis($data[0]["overwrite"]) == true)))
 {$old_file = $wpdb[0]->get_row(concat2(concat(concat2(concat1("
				SELECT ID
				FROM ",$wpdb[0]->posts),"
				WHERE post_title = '"),$name),"'
					AND post_type = 'attachment'
			"));
wp_delete_attachment($old_file[0]->ID);
$filename = Aspis_preg_replace(array("/^wpid\d+-/",false),array("",false),$name);
$name = concat(concat2(concat1("wpid",$old_file[0]->ID),"-"),$filename);
}$upload = wp_upload_bits($name,$type,$bits);
if ( (!((empty($upload[0][('error')]) || Aspis_empty( $upload [0][('error')])))))
 {$errorString = Aspis_sprintf(__(array('Could not write file %1$s (%2$s)',false)),$name,$upload[0]['error']);
logIO(array('O',false),concat1('(MW) ',$errorString));
return array(new IXR_Error(array(500,false),$errorString),false);
}$post_id = array(0,false);
$attachment = array(array(deregisterTaint(array('post_title',false)) => addTaint($name),'post_content' => array('',false,false),'post_type' => array('attachment',false,false),deregisterTaint(array('post_parent',false)) => addTaint($post_id),deregisterTaint(array('post_mime_type',false)) => addTaint($type),deregisterTaint(array('guid',false)) => addTaint($upload[0]['url'])),false);
$id = wp_insert_attachment($attachment,$upload[0]['file'],$post_id);
wp_update_attachment_metadata($id,wp_generate_attachment_metadata($id,$upload[0]['file']));
return apply_filters(array('wp_handle_upload',false),array(array(deregisterTaint(array('file',false)) => addTaint($name),deregisterTaint(array('url',false)) => addTaint($upload[0]['url']),deregisterTaint(array('type',false)) => addTaint($type)),false));
} }
function mt_getRecentPostTitles ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$num_posts = int_cast(attachAspis($args,(3)));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('mt.getRecentPostTitles',false));
$posts_list = wp_get_recent_posts($num_posts);
if ( (denot_boolean($posts_list)))
 {$this->error = array(new IXR_Error(array(500,false),__(array('Either there are no posts, or something went wrong.',false))),false);
return $this->error;
}foreach ( $posts_list[0] as $entry  )
{if ( (denot_boolean(current_user_can(array('edit_post',false),$entry[0]['ID']))))
 continue ;
$post_date = mysql2date(array('Ymd\TH:i:s',false),$entry[0]['post_date'],array(false,false));
$post_date_gmt = mysql2date(array('Ymd\TH:i:s',false),$entry[0]['post_date_gmt'],array(false,false));
if ( (deAspis($entry[0]['post_status']) == ('draft')))
 {$post_date_gmt = get_gmt_from_date(mysql2date(array('Y-m-d H:i:s',false),$entry[0]['post_date']),array('Ymd\TH:i:s',false));
}arrayAssignAdd($struct[0][],addTaint(array(array('dateCreated' => array(new IXR_Date($post_date),false,false),deregisterTaint(array('userid',false)) => addTaint($entry[0]['post_author']),deregisterTaint(array('postid',false)) => addTaint($entry[0]['ID']),deregisterTaint(array('title',false)) => addTaint($entry[0]['post_title']),'date_created_gmt' => array(new IXR_Date($post_date_gmt),false,false)),false)));
}$recent_posts = array(array(),false);
for ( $j = array(0,false) ; ($j[0] < count($struct[0])) ; postincr($j) )
{Aspis_array_push($recent_posts,attachAspis($struct,$j[0]));
}return $recent_posts;
} }
function mt_getCategoryList ( $args ) {
{$this->escape($args);
$blog_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you must be able to edit posts on this blog in order to view categories.',false))),false);
do_action(array('xmlrpc_call',false),array('mt.getCategoryList',false));
$categories_struct = array(array(),false);
if ( deAspis($cats = get_categories(array('hide_empty=0&hierarchical=0',false))))
 {foreach ( $cats[0] as $cat  )
{arrayAssign($struct[0],deAspis(registerTaint(array('categoryId',false))),addTaint($cat[0]->term_id));
arrayAssign($struct[0],deAspis(registerTaint(array('categoryName',false))),addTaint($cat[0]->name));
arrayAssignAdd($categories_struct[0][],addTaint($struct));
}}return $categories_struct;
} }
function mt_getPostCategories ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you can not edit this post.',false))),false);
do_action(array('xmlrpc_call',false),array('mt.getPostCategories',false));
$categories = array(array(),false);
$catids = wp_get_post_categories(Aspis_intval($post_ID));
$isPrimary = array(true,false);
foreach ( $catids[0] as $catid  )
{arrayAssignAdd($categories[0][],addTaint(array(array(deregisterTaint(array('categoryName',false)) => addTaint(get_cat_name($catid)),deregisterTaint(array('categoryId',false)) => addTaint(string_cast($catid)),deregisterTaint(array('isPrimary',false)) => addTaint($isPrimary)),false)));
$isPrimary = array(false,false);
}return $categories;
} }
function mt_setPostCategories ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
$categories = attachAspis($args,(3));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('mt.setPostCategories',false));
if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit this post.',false))),false);
foreach ( $categories[0] as $cat  )
{arrayAssignAdd($catids[0][],addTaint($cat[0]['categoryId']));
}wp_set_post_categories($post_ID,$catids);
return array(true,false);
} }
function mt_supportedMethods ( $args ) {
{do_action(array('xmlrpc_call',false),array('mt.supportedMethods',false));
$supported_methods = array(array(),false);
foreach ( $this->methods[0] as $key =>$value )
{restoreTaint($key,$value);
{arrayAssignAdd($supported_methods[0][],addTaint($key));
}}return $supported_methods;
} }
function mt_supportedTextFilters ( $args ) {
{do_action(array('xmlrpc_call',false),array('mt.supportedTextFilters',false));
return apply_filters(array('xmlrpc_text_filters',false),array(array(),false));
} }
function mt_getTrackbackPings ( $args ) {
{global $wpdb;
$post_ID = Aspis_intval($args);
do_action(array('xmlrpc_call',false),array('mt.getTrackbackPings',false));
$actual_post = wp_get_single_post($post_ID,array(ARRAY_A,false));
if ( (denot_boolean($actual_post)))
 {return array(new IXR_Error(array(404,false),__(array('Sorry, no such post.',false))),false);
}$comments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT comment_author_url, comment_content, comment_author_IP, comment_type FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d"),$post_ID));
if ( (denot_boolean($comments)))
 {return array(array(),false);
}$trackback_pings = array(array(),false);
foreach ( $comments[0] as $comment  )
{if ( (('trackback') == $comment[0]->comment_type[0]))
 {$content = $comment[0]->comment_content;
$title = Aspis_substr($content,array(8,false),(array(strpos($content[0],'</strong>') - (8),false)));
arrayAssignAdd($trackback_pings[0][],addTaint(array(array(deregisterTaint(array('pingTitle',false)) => addTaint($title),deregisterTaint(array('pingURL',false)) => addTaint($comment[0]->comment_author_url),deregisterTaint(array('pingIP',false)) => addTaint($comment[0]->comment_author_IP)),false)));
}}return $trackback_pings;
} }
function mt_publishPost ( $args ) {
{$this->escape($args);
$post_ID = int_cast(attachAspis($args,(0)));
$username = attachAspis($args,(1));
$password = attachAspis($args,(2));
if ( (denot_boolean($user = $this->login($username,$password))))
 {return $this->error;
}do_action(array('xmlrpc_call',false),array('mt.publishPost',false));
if ( (denot_boolean(current_user_can(array('edit_post',false),$post_ID))))
 return array(new IXR_Error(array(401,false),__(array('Sorry, you cannot edit this post.',false))),false);
$postdata = wp_get_single_post($post_ID,array(ARRAY_A,false));
arrayAssign($postdata[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('publish',false)));
$cats = wp_get_post_categories($post_ID);
arrayAssign($postdata[0],deAspis(registerTaint(array('post_category',false))),addTaint($cats));
$this->escape($postdata);
$result = wp_update_post($postdata);
return $result;
} }
function pingback_ping ( $args ) {
{global $wpdb;
do_action(array('xmlrpc_call',false),array('pingback.ping',false));
$this->escape($args);
$pagelinkedfrom = attachAspis($args,(0));
$pagelinkedto = attachAspis($args,(1));
$title = array('',false);
$pagelinkedfrom = Aspis_str_replace(array('&amp;',false),array('&',false),$pagelinkedfrom);
$pagelinkedto = Aspis_str_replace(array('&amp;',false),array('&',false),$pagelinkedto);
$pagelinkedto = Aspis_str_replace(array('&',false),array('&amp;',false),$pagelinkedto);
$pos1 = attAspis(strpos($pagelinkedto[0],deAspisRC(Aspis_str_replace(array(array(array('http://www.',false),array('http://',false),array('https://www.',false),array('https://',false)),false),array('',false),get_option(array('home',false))))));
if ( (denot_boolean($pos1)))
 return array(new IXR_Error(array(0,false),__(array('Is there no link to us?',false))),false);
$urltest = Aspis_parse_url($pagelinkedto);
if ( deAspis($post_ID = url_to_postid($pagelinkedto)))
 {$way = array('url_to_postid()',false);
}elseif ( deAspis(Aspis_preg_match(array('#p/[0-9]{1,}#',false),$urltest[0]['path'],$match)))
 {$blah = Aspis_explode(array('/',false),attachAspis($match,(0)));
$post_ID = int_cast(attachAspis($blah,(1)));
$way = array('from the path',false);
}elseif ( deAspis(Aspis_preg_match(array('#p=[0-9]{1,}#',false),$urltest[0]['query'],$match)))
 {$blah = Aspis_explode(array('=',false),attachAspis($match,(0)));
$post_ID = int_cast(attachAspis($blah,(1)));
$way = array('from the querystring',false);
}elseif ( ((isset($urltest[0][('fragment')]) && Aspis_isset( $urltest [0][('fragment')]))))
 {if ( deAspis(Aspis_intval($urltest[0]['fragment'])))
 {$post_ID = int_cast($urltest[0]['fragment']);
$way = array('from the fragment (numeric)',false);
}elseif ( deAspis(Aspis_preg_match(array('/post-[0-9]+/',false),$urltest[0]['fragment'])))
 {$post_ID = Aspis_preg_replace(array('/[^0-9]+/',false),array('',false),$urltest[0]['fragment']);
$way = array('from the fragment (post-###)',false);
}elseif ( is_string(deAspisRC($urltest[0]['fragment'])))
 {$title = Aspis_preg_replace(array('/[^a-z0-9]/i',false),array('.',false),$urltest[0]['fragment']);
$sql = $wpdb[0]->prepare(concat2(concat1("SELECT ID FROM ",$wpdb[0]->posts)," WHERE post_title RLIKE %s"),$title);
if ( (denot_boolean(($post_ID = $wpdb[0]->get_var($sql)))))
 {return array(new IXR_Error(array(0,false),array('',false)),false);
}$way = array('from the fragment (title)',false);
}}else 
{{return array(new IXR_Error(array(33,false),__(array('The specified target URL cannot be used as a target. It either doesn&#8217;t exist, or it is not a pingback-enabled resource.',false))),false);
}}$post_ID = int_cast($post_ID);
logIO(array("O",false),concat2(concat(concat2(concat(concat2(concat1("(PB) URL='",$pagelinkedto),"' ID='"),$post_ID),"' Found='"),$way),"'"));
$post = get_post($post_ID);
if ( (denot_boolean($post)))
 return array(new IXR_Error(array(33,false),__(array('The specified target URL cannot be used as a target. It either doesn&#8217;t exist, or it is not a pingback-enabled resource.',false))),false);
if ( ($post_ID[0] == deAspis(url_to_postid($pagelinkedfrom))))
 return array(new IXR_Error(array(0,false),__(array('The source URL and the target URL cannot both point to the same resource.',false))),false);
if ( (denot_boolean(pings_open($post))))
 return array(new IXR_Error(array(33,false),__(array('The specified target URL cannot be used as a target. It either doesn&#8217;t exist, or it is not a pingback-enabled resource.',false))),false);
$wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT * FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d AND comment_author_url = %s"),$post_ID,$pagelinkedfrom));
if ( $wpdb[0]->num_rows[0])
 return array(new IXR_Error(array(48,false),__(array('The pingback has already been registered.',false))),false);
sleep((1));
$linea = wp_remote_fopen($pagelinkedfrom);
if ( (denot_boolean($linea)))
 return array(new IXR_Error(array(16,false),__(array('The source URL does not exist.',false))),false);
$linea = apply_filters(array('pre_remote_source',false),$linea,$pagelinkedto);
$linea = Aspis_str_replace(array('<!DOC',false),array('<DOC',false),$linea);
$linea = Aspis_preg_replace(array('/[\s\r\n\t]+/',false),array(' ',false),$linea);
$linea = Aspis_preg_replace(array("/ <(h1|h2|h3|h4|h5|h6|p|th|td|li|dt|dd|pre|caption|input|textarea|button|body)[^>]*>/",false),array("\n\n",false),$linea);
Aspis_preg_match(array('|<title>([^<]*?)</title>|is',false),$linea,$matchtitle);
$title = attachAspis($matchtitle,(1));
if ( ((empty($title) || Aspis_empty( $title))))
 return array(new IXR_Error(array(32,false),__(array('We cannot find a title on that page.',false))),false);
$linea = Aspis_strip_tags($linea,array('<a>',false));
$p = Aspis_explode(array("\n\n",false),$linea);
$preg_target = Aspis_preg_quote($pagelinkedto,array('|',false));
foreach ( $p[0] as $para  )
{if ( (strpos($para[0],deAspisRC($pagelinkedto)) !== false))
 {Aspis_preg_match(concat2(concat1("|<a[^>]+?",$preg_target),"[^>]*>([^>]+?)</a>|"),$para,$context);
if ( ((empty($context) || Aspis_empty( $context))))
 continue ;
$excerpt = Aspis_preg_replace(array('|\</?wpcontext\>|',false),array('',false),$para);
if ( (strlen(deAspis(attachAspis($context,(1)))) > (100)))
 arrayAssign($context[0],deAspis(registerTaint(array(1,false))),addTaint(concat2(Aspis_substr(attachAspis($context,(1)),array(0,false),array(100,false)),'...')));
$marker = concat2(concat1('<wpcontext>',attachAspis($context,(1))),'</wpcontext>');
$excerpt = Aspis_str_replace(attachAspis($context,(0)),$marker,$excerpt);
$excerpt = Aspis_strip_tags($excerpt,array('<wpcontext>',false));
$excerpt = Aspis_trim($excerpt);
$preg_marker = Aspis_preg_quote($marker,array('|',false));
$excerpt = Aspis_preg_replace(concat2(concat1("|.*?\s(.{0,100}",$preg_marker),".{0,100})\s.*|s"),array('$1',false),$excerpt);
$excerpt = Aspis_strip_tags($excerpt);
break ;
}}if ( ((empty($context) || Aspis_empty( $context))))
 return array(new IXR_Error(array(17,false),__(array('The source URL does not contain a link to the target URL, and so cannot be used as a source.',false))),false);
$pagelinkedfrom = Aspis_str_replace(array('&',false),array('&amp;',false),$pagelinkedfrom);
$context = concat2(concat1('[...] ',esc_html($excerpt)),' [...]');
$pagelinkedfrom = $wpdb[0]->escape($pagelinkedfrom);
$comment_post_ID = int_cast($post_ID);
$comment_author = $title;
$this->escape($comment_author);
$comment_author_url = $pagelinkedfrom;
$comment_content = $context;
$this->escape($comment_content);
$comment_type = array('pingback',false);
$commentdata = array(compact('comment_post_ID','comment_author','comment_author_url','comment_content','comment_type'),false);
$comment_ID = wp_new_comment($commentdata);
do_action(array('pingback_post',false),$comment_ID);
return Aspis_sprintf(__(array('Pingback from %1$s to %2$s registered. Keep the web talking! :-)',false)),$pagelinkedfrom,$pagelinkedto);
} }
function pingback_extensions_getPingbacks ( $args ) {
{global $wpdb;
do_action(array('xmlrpc_call',false),array('pingback.extensions.getPingbacks',false));
$this->escape($args);
$url = $args;
$post_ID = url_to_postid($url);
if ( (denot_boolean($post_ID)))
 {return array(new IXR_Error(array(33,false),__(array('The specified target URL cannot be used as a target. It either doesn&#8217;t exist, or it is not a pingback-enabled resource.',false))),false);
}$actual_post = wp_get_single_post($post_ID,array(ARRAY_A,false));
if ( (denot_boolean($actual_post)))
 {return array(new IXR_Error(array(32,false),__(array('The specified target URL does not exist.',false))),false);
}$comments = $wpdb[0]->get_results($wpdb[0]->prepare(concat2(concat1("SELECT comment_author_url, comment_content, comment_author_IP, comment_type FROM ",$wpdb[0]->comments)," WHERE comment_post_ID = %d"),$post_ID));
if ( (denot_boolean($comments)))
 {return array(array(),false);
}$pingbacks = array(array(),false);
foreach ( $comments[0] as $comment  )
{if ( (('pingback') == $comment[0]->comment_type[0]))
 arrayAssignAdd($pingbacks[0][],addTaint($comment[0]->comment_author_url));
}return $pingbacks;
} }
}$wp_xmlrpc_server = array(new wp_xmlrpc_server(),false);
$wp_xmlrpc_server[0]->serve_request();
;
?>
<?php 