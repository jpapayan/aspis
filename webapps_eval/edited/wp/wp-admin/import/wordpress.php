<?php require_once('AspisMain.php'); ?><?php
class WP_Import{var $post_ids_processed = array(array(),false);
var $orphans = array(array(),false);
var $file;
var $id;
var $mtnames = array(array(),false);
var $newauthornames = array(array(),false);
var $allauthornames = array(array(),false);
var $author_ids = array(array(),false);
var $tags = array(array(),false);
var $categories = array(array(),false);
var $terms = array(array(),false);
var $j = array(-1,false);
var $fetch_attachments = array(false,false);
var $url_remap = array(array(),false);
function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import WordPress',false))),'</h2>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function unhtmlentities ( $string ) {
{$trans_tbl = attAspisRC(get_html_translation_table(HTML_ENTITIES));
$trans_tbl = Aspis_array_flip($trans_tbl);
return Aspis_strtr($string,$trans_tbl);
} }
function greet (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Howdy! Upload your WordPress eXtended RSS (WXR) file and we&#8217;ll import the posts, pages, comments, custom fields, categories, and tags into this blog.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Choose a WordPress WXR file to upload, then click Upload file and import.',false))),'</p>'));
wp_import_upload_form(array("admin.php?import=wordpress&amp;step=1",false));
echo AspisCheckPrint(array('</div>',false));
} }
function get_tag ( $string,$tag ) {
{global $wpdb;
Aspis_preg_match(concat2(concat(concat2(concat1("|<",$tag),".*?>(.*?)</"),$tag),">|is"),$string,$return);
$return = Aspis_preg_replace(array('|^<!\[CDATA\[(.*)\]\]>$|s',false),array('$1',false),attachAspis($return,(1)));
$return = $wpdb[0]->escape(Aspis_trim($return));
return $return;
} }
function has_gzip (  ) {
{return attAspis(is_callable('gzopen'));
} }
function fopen ( $filename,$mode = array('r',false) ) {
{if ( deAspis($this->has_gzip()))
 return array(gzopen(deAspisRC($filename),deAspisRC($mode)),false);
return attAspis(fopen($filename[0],$mode[0]));
} }
function feof ( $fp ) {
{if ( deAspis($this->has_gzip()))
 return array(gzeof(deAspisRC($fp)),false);
return attAspis(feof($fp[0]));
} }
function fgets ( $fp,$len = array(8192,false) ) {
{if ( deAspis($this->has_gzip()))
 return array(gzgets(deAspisRC($fp),deAspisRC($len)),false);
return attAspis(fgets($fp[0],$len[0]));
} }
function fclose ( $fp ) {
{if ( deAspis($this->has_gzip()))
 return array(gzclose(deAspisRC($fp)),false);
return attAspis(fclose($fp[0]));
} }
function get_entries ( $process_post_func = array(NULL,false) ) {
{set_magic_quotes_runtime(0);
$doing_entry = array(false,false);
$is_wxr_file = array(false,false);
$fp = $this->fopen($this->file,array('r',false));
if ( $fp[0])
 {while ( (denot_boolean($this->feof($fp))) )
{$importline = Aspis_rtrim($this->fgets($fp));
if ( ((denot_boolean($is_wxr_file)) && deAspis(Aspis_preg_match(array('|xmlns:wp="http://wordpress[.]org/export/\d+[.]\d+/"|',false),$importline))))
 $is_wxr_file = array(true,false);
if ( (false !== strpos($importline[0],'<wp:base_site_url>')))
 {Aspis_preg_match(array('|<wp:base_site_url>(.*?)</wp:base_site_url>|is',false),$importline,$url);
$this->base_url = attachAspis($url,(1));
continue ;
}if ( (false !== strpos($importline[0],'<wp:category>')))
 {Aspis_preg_match(array('|<wp:category>(.*?)</wp:category>|is',false),$importline,$category);
arrayAssignAdd($this->categories[0][],addTaint(attachAspis($category,(1))));
continue ;
}if ( (false !== strpos($importline[0],'<wp:tag>')))
 {Aspis_preg_match(array('|<wp:tag>(.*?)</wp:tag>|is',false),$importline,$tag);
arrayAssignAdd($this->tags[0][],addTaint(attachAspis($tag,(1))));
continue ;
}if ( (false !== strpos($importline[0],'<wp:term>')))
 {Aspis_preg_match(array('|<wp:term>(.*?)</wp:term>|is',false),$importline,$term);
arrayAssignAdd($this->terms[0][],addTaint(attachAspis($term,(1))));
continue ;
}if ( (false !== strpos($importline[0],'<item>')))
 {$this->post = array('',false);
$doing_entry = array(true,false);
continue ;
}if ( (false !== strpos($importline[0],'</item>')))
 {$doing_entry = array(false,false);
if ( $process_post_func[0])
 Aspis_call_user_func($process_post_func,$this->post);
continue ;
}if ( $doing_entry[0])
 {$this->post = concat($this->post ,concat2($importline,"\n"));
}}$this->fclose($fp);
}return $is_wxr_file;
} }
function get_wp_authors (  ) {
{$temp = $this->allauthornames;
arrayAssign($authors[0],deAspis(registerTaint(array(0,false))),addTaint(Aspis_array_shift($temp)));
$y = array(count($temp[0]) + (1),false);
for ( $x = array(1,false) ; ($x[0] < $y[0]) ; postincr($x) )
{$next = Aspis_array_shift($temp);
if ( (denot_boolean((Aspis_in_array($next,$authors)))))
 Aspis_array_push($authors,$next);
}return $authors;
} }
function get_authors_from_post (  ) {
{global $current_user;
foreach ( deAspis($_POST[0]['author_in']) as $i =>$in_author_name )
{restoreTaint($i,$in_author_name);
{if ( (!((empty($_POST[0][('user_select')][0][$i[0]]) || Aspis_empty( $_POST [0][('user_select')] [0][$i[0]])))))
 {$user = get_userdata(Aspis_intval(attachAspis($_POST[0][('user_select')],$i[0])));
if ( ((isset($user[0]->ID) && Aspis_isset( $user[0] ->ID ))))
 arrayAssign($this->author_ids[0],deAspis(registerTaint($in_author_name)),addTaint($user[0]->ID));
}elseif ( deAspis($this->allow_create_users()))
 {$new_author_name = Aspis_trim(attachAspis($_POST[0][('user_create')],$i[0]));
if ( ((empty($new_author_name) || Aspis_empty( $new_author_name))))
 $new_author_name = $in_author_name;
$user_id = username_exists($new_author_name);
if ( (denot_boolean($user_id)))
 {$user_id = wp_create_user($new_author_name,wp_generate_password());
}arrayAssign($this->author_ids[0],deAspis(registerTaint($in_author_name)),addTaint($user_id));
}if ( ((empty($this->author_ids[0][$in_author_name[0]]) || Aspis_empty( $this ->author_ids [0][$in_author_name[0]] ))))
 {arrayAssign($this->author_ids[0],deAspis(registerTaint($in_author_name)),addTaint(Aspis_intval($current_user[0]->ID)));
}}}} }
function wp_authors_form (  ) {
{;
?>
<h2><?php _e(array('Assign Authors',false));
;
?></h2>
<p><?php _e(array('To make it easier for you to edit and save the imported posts and drafts, you may want to change the name of the author of the posts. For example, you may want to import all the entries as <code>admin</code>s entries.',false));
;
?></p>
<?php if ( deAspis($this->allow_create_users()))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('If a new user is created by WordPress, a password will be randomly generated. Manually change the user&#8217;s details if necessary.',false))),"</p>\n"));
}$authors = $this->get_wp_authors();
echo AspisCheckPrint(concat2(concat1('<form action="?import=wordpress&amp;step=2&amp;id=',$this->id),'" method="post">'));
wp_nonce_field(array('import-wordpress',false));
;
?>
<ol id="authors">
<?php $j = negate(array(1,false));
foreach ( $authors[0] as $author  )
{preincr($j);
echo AspisCheckPrint(concat2(concat(concat2(concat1('<li>',__(array('Import author:',false))),' <strong>'),$author),'</strong><br />'));
$this->users_form($j,$author);
echo AspisCheckPrint(array('</li>',false));
}if ( deAspis($this->allow_fetch_attachments()))
 {;
?>
</ol>
<h2><?php _e(array('Import Attachments',false));
;
?></h2>
<p>
	<input type="checkbox" value="1" name="attachments" id="import-attachments" />
	<label for="import-attachments"><?php _e(array('Download and import file attachments',false));
?></label>
</p>

<?php }echo AspisCheckPrint(array('<p class="submit">',false));
echo AspisCheckPrint(concat2(concat2(concat1('<input type="submit" class="button" value="',esc_attr__(array('Submit',false))),'" />'),'<br />'));
echo AspisCheckPrint(array('</p>',false));
echo AspisCheckPrint(array('</form>',false));
} }
function users_form ( $n,$author ) {
{if ( deAspis($this->allow_create_users()))
 {printf((deconcat1('<label>',__(array('Create user %1$s or map to existing',false)))),(deconcat2(concat2(concat(concat2(concat2(concat1(' <input type="text" value="',esc_attr($author)),'" name="'),'user_create['),Aspis_intval($n)),']'),'" maxlength="30" /></label> <br />')));
}else 
{{echo AspisCheckPrint(concat2(__(array('Map to existing',false)),'<br />'));
}}echo AspisCheckPrint(concat2(concat(concat2(concat1('<input type="hidden" name="author_in[',Aspis_intval($n)),']" value="'),esc_attr($author)),'" />'));
$users = get_users_of_blog();
;
?><select name="user_select[<?php echo AspisCheckPrint($n);
;
?>]">
	<option value="0"><?php _e(array('- Select -',false));
;
?></option>
	<?php foreach ( $users[0] as $user  )
{echo AspisCheckPrint(concat2(concat(concat2(concat1('<option value="',$user[0]->user_id),'">'),$user[0]->user_login),'</option>'));
};
?>
	</select>
	<?php } }
function select_authors (  ) {
{$is_wxr_file = $this->get_entries(array(array(array($this,false),array('process_author',false)),false));
if ( $is_wxr_file[0])
 {$this->wp_authors_form();
}else 
{{echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Invalid file',false))),'</h2>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Please upload a valid WXR (WordPress eXtended RSS) export file.',false))),'</p>'));
}}} }
function checkauthor ( $author ) {
{global $current_user;
if ( (!((empty($this->author_ids[0][$author[0]]) || Aspis_empty( $this ->author_ids [0][$author[0]] )))))
 return $this->author_ids[0][$author[0]];
return $current_user[0]->ID;
} }
function process_categories (  ) {
{global $wpdb;
$cat_names = array_cast(get_terms(array('category',false),array('fields=names',false)));
while ( deAspis($c = Aspis_array_shift($this->categories)) )
{$cat_name = Aspis_trim($this->get_tag($c,array('wp:cat_name',false)));
if ( deAspis(Aspis_in_array($cat_name,$cat_names)))
 continue ;
$category_nicename = $this->get_tag($c,array('wp:category_nicename',false));
$category_description = $this->get_tag($c,array('wp:category_description',false));
$posts_private = int_cast($this->get_tag($c,array('wp:posts_private',false)));
$links_private = int_cast($this->get_tag($c,array('wp:links_private',false)));
$parent = $this->get_tag($c,array('wp:category_parent',false));
if ( ((empty($parent) || Aspis_empty( $parent))))
 $category_parent = array('0',false);
else 
{$category_parent = category_exists($parent);
}$catarr = array(compact('category_nicename','category_parent','posts_private','links_private','posts_private','cat_name','category_description'),false);
$cat_ID = wp_insert_category($catarr);
}} }
function process_tags (  ) {
{global $wpdb;
$tag_names = array_cast(get_terms(array('post_tag',false),array('fields=names',false)));
while ( deAspis($c = Aspis_array_shift($this->tags)) )
{$tag_name = Aspis_trim($this->get_tag($c,array('wp:tag_name',false)));
if ( deAspis(Aspis_in_array($tag_name,$tag_names)))
 continue ;
$slug = $this->get_tag($c,array('wp:tag_slug',false));
$description = $this->get_tag($c,array('wp:tag_description',false));
$tagarr = array(compact('slug','description'),false);
$tag_ID = wp_insert_term($tag_name,array('post_tag',false),$tagarr);
}} }
function process_terms (  ) {
{global $wpdb,$wp_taxonomies;
$custom_taxonomies = $wp_taxonomies;
unset($custom_taxonomies[0][('category')]);
unset($custom_taxonomies[0][('post_tag')]);
unset($custom_taxonomies[0][('link_category')]);
$custom_taxonomies = attAspisRC(array_keys(deAspisRC($custom_taxonomies)));
$current_terms = array_cast(get_terms($custom_taxonomies,array('get=all',false)));
$taxonomies = array(array(),false);
foreach ( $current_terms[0] as $term  )
{if ( ((isset($_terms[0][$term[0]->taxonomy[0]]) && Aspis_isset( $_terms [0][$term[0] ->taxonomy [0]]))))
 {arrayAssign($taxonomies[0],deAspis(registerTaint($term[0]->taxonomy)),addTaint(Aspis_array_merge(attachAspis($taxonomies,$term[0]->taxonomy[0]),array(array($term[0]->name),false))));
}else 
{{arrayAssign($taxonomies[0],deAspis(registerTaint($term[0]->taxonomy)),addTaint(array(array($term[0]->name),false)));
}}}while ( deAspis($c = Aspis_array_shift($this->terms)) )
{$term_name = Aspis_trim($this->get_tag($c,array('wp:term_name',false)));
$term_taxonomy = Aspis_trim($this->get_tag($c,array('wp:term_taxonomy',false)));
if ( (((isset($taxonomies[0][$term_taxonomy[0]]) && Aspis_isset( $taxonomies [0][$term_taxonomy[0]]))) && deAspis(Aspis_in_array($term_name,attachAspis($taxonomies,$term_taxonomy[0])))))
 continue ;
$slug = $this->get_tag($c,array('wp:term_slug',false));
$description = $this->get_tag($c,array('wp:term_description',false));
$termarr = array(compact('slug','description'),false);
$term_ID = wp_insert_term($term_name,$this->get_tag($c,array('wp:term_taxonomy',false)),$termarr);
}} }
function process_author ( $post ) {
{$author = $this->get_tag($post,array('dc:creator',false));
if ( $author[0])
 arrayAssignAdd($this->allauthornames[0][],addTaint($author));
} }
function process_posts (  ) {
{echo AspisCheckPrint(array('<ol>',false));
$this->get_entries(array(array(array($this,false),array('process_post',false)),false));
echo AspisCheckPrint(array('</ol>',false));
wp_import_cleanup($this->id);
do_action(array('import_done',false),array('wordpress',false));
echo AspisCheckPrint(concat2(concat1('<h3>',Aspis_sprintf(concat2(concat(concat2(__(array('All done.',false)),' <a href="%s">'),__(array('Have fun!',false))),'</a>'),get_option(array('home',false)))),'</h3>'));
} }
function _normalize_tag ( $matches ) {
{return concat1('<',Aspis_strtolower(attachAspis($matches,(1))));
} }
function process_post ( $post ) {
{global $wpdb;
$post_ID = int_cast($this->get_tag($post,array('wp:post_id',false)));
if ( ($post_ID[0] && (!((empty($this->post_ids_processed[0][$post_ID[0]]) || Aspis_empty( $this ->post_ids_processed [0][$post_ID[0]] ))))))
 return array(0,false);
set_time_limit(60);
$post_title = $this->get_tag($post,array('title',false));
$post_date = $this->get_tag($post,array('wp:post_date',false));
$post_date_gmt = $this->get_tag($post,array('wp:post_date_gmt',false));
$comment_status = $this->get_tag($post,array('wp:comment_status',false));
$ping_status = $this->get_tag($post,array('wp:ping_status',false));
$post_status = $this->get_tag($post,array('wp:status',false));
$post_name = $this->get_tag($post,array('wp:post_name',false));
$post_parent = $this->get_tag($post,array('wp:post_parent',false));
$menu_order = $this->get_tag($post,array('wp:menu_order',false));
$post_type = $this->get_tag($post,array('wp:post_type',false));
$post_password = $this->get_tag($post,array('wp:post_password',false));
$is_sticky = $this->get_tag($post,array('wp:is_sticky',false));
$guid = $this->get_tag($post,array('guid',false));
$post_author = $this->get_tag($post,array('dc:creator',false));
$post_excerpt = $this->get_tag($post,array('excerpt:encoded',false));
$post_excerpt = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$post_excerpt);
$post_excerpt = Aspis_str_replace(array('<br>',false),array('<br />',false),$post_excerpt);
$post_excerpt = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$post_excerpt);
$post_content = $this->get_tag($post,array('content:encoded',false));
$post_content = Aspis_preg_replace_callback(array('|<(/?[A-Z]+)|',false),array(array(array($this,false),array('_normalize_tag',false)),false),$post_content);
$post_content = Aspis_str_replace(array('<br>',false),array('<br />',false),$post_content);
$post_content = Aspis_str_replace(array('<hr>',false),array('<hr />',false),$post_content);
Aspis_preg_match_all(array('|<category domain="tag">(.*?)</category>|is',false),$post,$tags);
$tags = attachAspis($tags,(1));
$tag_index = array(0,false);
foreach ( $tags[0] as $tag  )
{arrayAssign($tags[0],deAspis(registerTaint($tag_index)),addTaint($wpdb[0]->escape($this->unhtmlentities(Aspis_str_replace(array(array(array('<![CDATA[',false),array(']]>',false)),false),array('',false),$tag)))));
postincr($tag_index);
}Aspis_preg_match_all(array('|<category>(.*?)</category>|is',false),$post,$categories);
$categories = attachAspis($categories,(1));
$cat_index = array(0,false);
foreach ( $categories[0] as $category  )
{arrayAssign($categories[0],deAspis(registerTaint($cat_index)),addTaint($wpdb[0]->escape($this->unhtmlentities(Aspis_str_replace(array(array(array('<![CDATA[',false),array(']]>',false)),false),array('',false),$category)))));
postincr($cat_index);
}$post_exists = post_exists($post_title,array('',false),$post_date);
if ( $post_exists[0])
 {echo AspisCheckPrint(array('<li>',false));
printf(deAspis(__(array('Post <em>%s</em> already exists.',false))),deAspisRC(Aspis_stripslashes($post_title)));
$comment_post_ID = $post_id = $post_exists;
}else 
{{$post_parent = int_cast($post_parent);
if ( $post_parent[0])
 {if ( deAspis($parent = $this->post_ids_processed[0][$post_parent[0]]))
 {$post_parent = $parent;
}else 
{{arrayAssign($this->orphans[0],deAspis(registerTaint(Aspis_intval($post_ID))),addTaint($post_parent));
}}}echo AspisCheckPrint(array('<li>',false));
$post_author = $this->checkauthor($post_author);
$postdata = array(compact('post_author','post_date','post_date_gmt','post_content','post_excerpt','post_title','post_status','post_name','comment_status','ping_status','guid','post_parent','menu_order','post_type','post_password'),false);
arrayAssign($postdata[0],deAspis(registerTaint(array('import_id',false))),addTaint($post_ID));
if ( ($post_type[0] == ('attachment')))
 {$remote_url = $this->get_tag($post,array('wp:attachment_url',false));
if ( (denot_boolean($remote_url)))
 $remote_url = $guid;
$comment_post_ID = $post_id = $this->process_attachment($postdata,$remote_url);
if ( ((denot_boolean($post_id)) or deAspis(is_wp_error($post_id))))
 return $post_id;
}else 
{{printf(deAspis(__(array('Importing post <em>%s</em>...',false))),deAspisRC(Aspis_stripslashes($post_title)));
$comment_post_ID = $post_id = wp_insert_post($postdata);
if ( ($post_id[0] && ($is_sticky[0] == (1))))
 stick_post($post_id);
}}if ( deAspis(is_wp_error($post_id)))
 return $post_id;
if ( ($post_id[0] && $post_ID[0]))
 {arrayAssign($this->post_ids_processed[0],deAspis(registerTaint(Aspis_intval($post_ID))),addTaint(Aspis_intval($post_id)));
}if ( (count($categories[0]) > (0)))
 {$post_cats = array(array(),false);
foreach ( $categories[0] as $category  )
{if ( (('') == $category[0]))
 continue ;
$slug = sanitize_term_field(array('slug',false),$category,array(0,false),array('category',false),array('db',false));
$cat = get_term_by(array('slug',false),$slug,array('category',false));
$cat_ID = array(0,false);
if ( (!((empty($cat) || Aspis_empty( $cat)))))
 $cat_ID = $cat[0]->term_id;
if ( ($cat_ID[0] == (0)))
 {$category = $wpdb[0]->escape($category);
$cat_ID = wp_insert_category(array(array(deregisterTaint(array('cat_name',false)) => addTaint($category)),false));
if ( deAspis(is_wp_error($cat_ID)))
 continue ;
}arrayAssignAdd($post_cats[0][],addTaint($cat_ID));
}wp_set_post_categories($post_id,$post_cats);
}if ( (count($tags[0]) > (0)))
 {$post_tags = array(array(),false);
foreach ( $tags[0] as $tag  )
{if ( (('') == $tag[0]))
 continue ;
$slug = sanitize_term_field(array('slug',false),$tag,array(0,false),array('post_tag',false),array('db',false));
$tag_obj = get_term_by(array('slug',false),$slug,array('post_tag',false));
$tag_id = array(0,false);
if ( (!((empty($tag_obj) || Aspis_empty( $tag_obj)))))
 $tag_id = $tag_obj[0]->term_id;
if ( ($tag_id[0] == (0)))
 {$tag = $wpdb[0]->escape($tag);
$tag_id = wp_insert_term($tag,array('post_tag',false));
if ( deAspis(is_wp_error($tag_id)))
 continue ;
$tag_id = $tag_id[0]['term_id'];
}arrayAssignAdd($post_tags[0][],addTaint(Aspis_intval($tag_id)));
}wp_set_post_tags($post_id,$post_tags);
}}}Aspis_preg_match_all(array('|<wp:comment>(.*?)</wp:comment>|is',false),$post,$comments);
$comments = attachAspis($comments,(1));
$num_comments = array(0,false);
$inserted_comments = array(array(),false);
if ( $comments[0])
 {foreach ( $comments[0] as $comment  )
{$comment_id = $this->get_tag($comment,array('wp:comment_id',false));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_post_ID',false))),addTaint($comment_post_ID));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_author',false))),addTaint($this->get_tag($comment,array('wp:comment_author',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_author_email',false))),addTaint($this->get_tag($comment,array('wp:comment_author_email',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_author_IP',false))),addTaint($this->get_tag($comment,array('wp:comment_author_IP',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_author_url',false))),addTaint($this->get_tag($comment,array('wp:comment_author_url',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_date',false))),addTaint($this->get_tag($comment,array('wp:comment_date',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_date_gmt',false))),addTaint($this->get_tag($comment,array('wp:comment_date_gmt',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_content',false))),addTaint($this->get_tag($comment,array('wp:comment_content',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_approved',false))),addTaint($this->get_tag($comment,array('wp:comment_approved',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_type',false))),addTaint($this->get_tag($comment,array('wp:comment_type',false))));
arrayAssign($newcomments[0][$comment_id[0]][0],deAspis(registerTaint(array('comment_parent',false))),addTaint($this->get_tag($comment,array('wp:comment_parent',false))));
}Aspis_ksort($newcomments);
foreach ( $newcomments[0] as $key =>$comment )
{restoreTaint($key,$comment);
{if ( ((denot_boolean($post_exists)) || (denot_boolean(comment_exists($comment[0]['comment_author'],$comment[0]['comment_date'])))))
 {if ( ((isset($inserted_comments[0][deAspis($comment[0]['comment_parent'])]) && Aspis_isset( $inserted_comments [0][deAspis($comment [0]['comment_parent'])]))))
 arrayAssign($comment[0],deAspis(registerTaint(array('comment_parent',false))),addTaint(attachAspis($inserted_comments,deAspis($comment[0]['comment_parent']))));
$comment = wp_filter_comment($comment);
arrayAssign($inserted_comments[0],deAspis(registerTaint($key)),addTaint(wp_insert_comment($comment)));
postincr($num_comments);
}}}}if ( $num_comments[0])
 printf((deconcat1(' ',_n(array('(%s comment)',false),array('(%s comments)',false),$num_comments))),deAspisRC($num_comments));
Aspis_preg_match_all(array('|<wp:postmeta>(.*?)</wp:postmeta>|is',false),$post,$postmeta);
$postmeta = attachAspis($postmeta,(1));
if ( $postmeta[0])
 {foreach ( $postmeta[0] as $p  )
{$key = $this->get_tag($p,array('wp:meta_key',false));
$value = $this->get_tag($p,array('wp:meta_value',false));
$value = Aspis_stripslashes($value);
$this->process_post_meta($post_id,$key,$value);
}}do_action(array('import_post_added',false),$post_id);
print AspisCheckPrint(array("</li>\n",false));
} }
function process_post_meta ( $post_id,$key,$value ) {
{$_key = apply_filters(array('import_post_meta_key',false),$key);
if ( $_key[0])
 {add_post_meta($post_id,$_key,$value);
do_action(array('import_post_meta',false),$post_id,$_key,$value);
}} }
function process_attachment ( $postdata,$remote_url ) {
{if ( ($this->fetch_attachments[0] and $remote_url[0]))
 {printf(deAspis(__(array('Importing attachment <em>%s</em>... ',false))),deAspisRC(Aspis_htmlspecialchars($remote_url)));
if ( deAspis(Aspis_preg_match(array('/^\/[\w\W]+$/',false),$remote_url)))
 $remote_url = concat(Aspis_rtrim($this->base_url,array('/',false)),$remote_url);
$upload = $this->fetch_remote_file($postdata,$remote_url);
if ( deAspis(is_wp_error($upload)))
 {printf(deAspis(__(array('Remote file error: %s',false))),deAspisRC(Aspis_htmlspecialchars($upload[0]->get_error_message())));
return $upload;
}else 
{{print AspisCheckPrint(concat2(concat1('(',size_format(attAspis(filesize(deAspis($upload[0]['file']))))),')'));
}}if ( deAspis($info = wp_check_filetype($upload[0]['file'])))
 {arrayAssign($postdata[0],deAspis(registerTaint(array('post_mime_type',false))),addTaint($info[0]['type']));
}else 
{{print AspisCheckPrint(__(array('Invalid file type',false)));
return ;
}}arrayAssign($postdata[0],deAspis(registerTaint(array('guid',false))),addTaint($upload[0]['url']));
$post_id = wp_insert_attachment($postdata,$upload[0]['file']);
wp_update_attachment_metadata($post_id,wp_generate_attachment_metadata($post_id,$upload[0]['file']));
if ( (deAspis(Aspis_preg_match(array('@^image/@',false),$info[0]['type'])) && deAspis($thumb_url = wp_get_attachment_thumb_url($post_id))))
 {$parts = Aspis_pathinfo($remote_url);
$ext = $parts[0]['extension'];
$name = Aspis_basename($parts[0]['basename'],concat1(".",$ext));
arrayAssign($this->url_remap[0],deAspis(registerTaint(concat(concat2(concat(concat2($parts[0]['dirname'],'/'),$name),'.thumbnail.'),$ext))),addTaint($thumb_url));
}return $post_id;
}else 
{{printf(deAspis(__(array('Skipping attachment <em>%s</em>',false))),deAspisRC(Aspis_htmlspecialchars($remote_url)));
}}} }
function fetch_remote_file ( $post,$url ) {
{$upload = wp_upload_dir($post[0]['post_date']);
$file_name = Aspis_basename($url);
$upload = wp_upload_bits($file_name,array(0,false),array('',false),$post[0]['post_date']);
if ( deAspis($upload[0]['error']))
 {echo AspisCheckPrint($upload[0]['error']);
return array(new WP_Error(array('upload_dir_error',false),$upload[0]['error']),false);
}$headers = wp_get_http($url,$upload[0]['file']);
if ( (denot_boolean($headers)))
 {@attAspis(unlink(deAspis($upload[0]['file'])));
return array(new WP_Error(array('import_file_error',false),__(array('Remote server did not respond',false))),false);
}if ( (deAspis($headers[0]['response']) != ('200')))
 {@attAspis(unlink(deAspis($upload[0]['file'])));
return array(new WP_Error(array('import_file_error',false),Aspis_sprintf(__(array('Remote file returned error response %1$d %2$s',false)),$headers[0]['response'],get_status_header_desc($headers[0]['response']))),false);
}elseif ( (((isset($headers[0][('content-length')]) && Aspis_isset( $headers [0][('content-length')]))) && (filesize(deAspis($upload[0]['file'])) != deAspis($headers[0]['content-length']))))
 {@attAspis(unlink(deAspis($upload[0]['file'])));
return array(new WP_Error(array('import_file_error',false),__(array('Remote file is incorrect size',false))),false);
}$max_size = $this->max_attachment_size();
if ( ((!((empty($max_size) || Aspis_empty( $max_size)))) and (filesize(deAspis($upload[0]['file'])) > $max_size[0])))
 {@attAspis(unlink(deAspis($upload[0]['file'])));
return array(new WP_Error(array('import_file_error',false),Aspis_sprintf(__(array('Remote file is too large, limit is %s',false),size_format($max_size)))),false);
}arrayAssign($this->url_remap[0],deAspis(registerTaint($url)),addTaint($upload[0]['url']));
if ( (deAspis($headers[0]['x-final-location']) != $url[0]))
 arrayAssign($this->url_remap[0],deAspis(registerTaint($headers[0]['x-final-location'])),addTaint($upload[0]['url']));
return $upload;
} }
function cmpr_strlen ( $a,$b ) {
{return array(strlen($b[0]) - strlen($a[0]),false);
} }
function backfill_attachment_urls (  ) {
{AspisInternalFunctionCall("uksort",AspisPushRefParam($this->url_remap),AspisInternalCallback(array(array(array($this,false),array('cmpr_strlen',false)),false)),array(0));
global $wpdb;
foreach ( $this->url_remap[0] as $from_url =>$to_url )
{restoreTaint($from_url,$to_url);
{$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_content = REPLACE(post_content, '%s', '%s')"),$from_url,$to_url));
$result = $wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->postmeta)," SET meta_value = REPLACE(meta_value, '%s', '%s') WHERE meta_key='enclosure'"),$from_url,$to_url));
}}} }
function backfill_parents (  ) {
{global $wpdb;
foreach ( $this->orphans[0] as $child_id =>$parent_id )
{restoreTaint($child_id,$parent_id);
{$local_child_id = $this->post_ids_processed[0][$child_id[0]];
$local_parent_id = $this->post_ids_processed[0][$parent_id[0]];
if ( ($local_child_id[0] and $local_parent_id[0]))
 {$wpdb[0]->query($wpdb[0]->prepare(concat2(concat1("UPDATE ",$wpdb[0]->posts)," SET post_parent = %d WHERE ID = %d"),$local_parent_id,$local_child_id));
}}}} }
function is_valid_meta_key ( $key ) {
{if ( (($key[0] == ('_wp_attached_file')) || ($key[0] == ('_wp_attachment_metadata'))))
 return array(false,false);
return $key;
} }
function allow_create_users (  ) {
{return apply_filters(array('import_allow_create_users',false),array(true,false));
} }
function allow_fetch_attachments (  ) {
{return apply_filters(array('import_allow_fetch_attachments',false),array(true,false));
} }
function max_attachment_size (  ) {
{return apply_filters(array('import_attachment_size_limit',false),array(0,false));
} }
function import_start (  ) {
{wp_defer_term_counting(array(true,false));
wp_defer_comment_counting(array(true,false));
do_action(array('import_start',false));
} }
function import_end (  ) {
{do_action(array('import_end',false));
foreach ( $this->post_ids_processed[0] as $post_id  )
clean_post_cache($post_id);
wp_defer_term_counting(array(false,false));
wp_defer_comment_counting(array(false,false));
} }
function import ( $id,$fetch_attachments = array(false,false) ) {
{$this->id = int_cast($id);
$this->fetch_attachments = (array(deAspis($this->allow_fetch_attachments()) && deAspis(bool_cast($fetch_attachments)),false));
add_filter(array('import_post_meta_key',false),array(array(array($this,false),array('is_valid_meta_key',false)),false));
$file = get_attached_file($this->id);
$this->import_file($file);
} }
function import_file ( $file ) {
{$this->file = $file;
$this->import_start();
$this->get_authors_from_post();
wp_suspend_cache_invalidation(array(true,false));
$this->get_entries();
$this->process_categories();
$this->process_tags();
$this->process_terms();
$result = $this->process_posts();
wp_suspend_cache_invalidation(array(false,false));
$this->backfill_parents();
$this->backfill_attachment_urls();
$this->import_end();
if ( deAspis(is_wp_error($result)))
 return $result;
} }
function handle_upload (  ) {
{$file = wp_import_handle_upload();
if ( ((isset($file[0][('error')]) && Aspis_isset( $file [0][('error')]))))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('Sorry, there has been an error.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p><strong>',$file[0]['error']),'</strong></p>'));
return array(false,false);
}$this->file = $file[0]['file'];
$this->id = int_cast($file[0]['id']);
return array(true,false);
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 $step = array(0,false);
else 
{$step = int_cast($_GET[0]['step']);
}$this->header();
switch ( $step[0] ) {
case (0):$this->greet();
break ;
case (1):check_admin_referer(array('import-upload',false));
if ( deAspis($this->handle_upload()))
 $this->select_authors();
break ;
case (2):check_admin_referer(array('import-wordpress',false));
$result = $this->import($_GET[0]['id'],$_POST[0]['attachments']);
if ( deAspis(is_wp_error($result)))
 echo AspisCheckPrint($result[0]->get_error_message());
break ;
 }
$this->footer();
} }
function WP_Import (  ) {
{} }
}$wp_import = array(new WP_Import(),false);
register_importer(array('wordpress',false),array('WordPress',false),__(array('Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.',false)),array(array($wp_import,array('dispatch',false)),false));
;
?>
<?php 