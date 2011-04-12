<?php require_once('AspisMain.php'); ?><?php
class WP_Import{var $post_ids_processed = array();
var $orphans = array();
var $file;
var $id;
var $mtnames = array();
var $newauthornames = array();
var $allauthornames = array();
var $author_ids = array();
var $tags = array();
var $categories = array();
var $terms = array();
var $j = -1;
var $fetch_attachments = false;
var $url_remap = array();
function header (  ) {
{echo '<div class="wrap">';
screen_icon();
echo '<h2>' . __('Import WordPress') . '</h2>';
} }
function footer (  ) {
{echo '</div>';
} }
function unhtmlentities ( $string ) {
{$trans_tbl = get_html_translation_table(HTML_ENTITIES);
$trans_tbl = array_flip($trans_tbl);
{$AspisRetTemp = strtr($string,$trans_tbl);
return $AspisRetTemp;
}} }
function greet (  ) {
{echo '<div class="narrow">';
echo '<p>' . __('Howdy! Upload your WordPress eXtended RSS (WXR) file and we&#8217;ll import the posts, pages, comments, custom fields, categories, and tags into this blog.') . '</p>';
echo '<p>' . __('Choose a WordPress WXR file to upload, then click Upload file and import.') . '</p>';
wp_import_upload_form("admin.php?import=wordpress&amp;step=1");
echo '</div>';
} }
function get_tag ( $string,$tag ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}preg_match("|<$tag.*?>(.*?)</$tag>|is",$string,$return);
$return = preg_replace('|^<!\[CDATA\[(.*)\]\]>$|s','$1',$return[1]);
$return = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam(trim($return))),array(0));
{$AspisRetTemp = $return;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function has_gzip (  ) {
{{$AspisRetTemp = is_callable('gzopen');
return $AspisRetTemp;
}} }
function fopen ( $filename,$mode = 'r' ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzopen($filename,$mode);
return $AspisRetTemp;
}{$AspisRetTemp = fopen($filename,$mode);
return $AspisRetTemp;
}} }
function feof ( $fp ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzeof($fp);
return $AspisRetTemp;
}{$AspisRetTemp = feof($fp);
return $AspisRetTemp;
}} }
function fgets ( $fp,$len = 8192 ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzgets($fp,$len);
return $AspisRetTemp;
}{$AspisRetTemp = fgets($fp,$len);
return $AspisRetTemp;
}} }
function fclose ( $fp ) {
{if ( $this->has_gzip())
 {$AspisRetTemp = gzclose($fp);
return $AspisRetTemp;
}{$AspisRetTemp = fclose($fp);
return $AspisRetTemp;
}} }
function get_entries ( $process_post_func = NULL ) {
{set_magic_quotes_runtime(0);
$doing_entry = false;
$is_wxr_file = false;
$fp = $this->fopen($this->file,'r');
if ( $fp)
 {while ( !$this->feof($fp) )
{$importline = rtrim($this->fgets($fp));
if ( !$is_wxr_file && preg_match('|xmlns:wp="http://wordpress[.]org/export/\d+[.]\d+/"|',$importline))
 $is_wxr_file = true;
if ( false !== strpos($importline,'<wp:base_site_url>'))
 {preg_match('|<wp:base_site_url>(.*?)</wp:base_site_url>|is',$importline,$url);
$this->base_url = $url[1];
continue ;
}if ( false !== strpos($importline,'<wp:category>'))
 {preg_match('|<wp:category>(.*?)</wp:category>|is',$importline,$category);
$this->categories[] = $category[1];
continue ;
}if ( false !== strpos($importline,'<wp:tag>'))
 {preg_match('|<wp:tag>(.*?)</wp:tag>|is',$importline,$tag);
$this->tags[] = $tag[1];
continue ;
}if ( false !== strpos($importline,'<wp:term>'))
 {preg_match('|<wp:term>(.*?)</wp:term>|is',$importline,$term);
$this->terms[] = $term[1];
continue ;
}if ( false !== strpos($importline,'<item>'))
 {$this->post = '';
$doing_entry = true;
continue ;
}if ( false !== strpos($importline,'</item>'))
 {$doing_entry = false;
if ( $process_post_func)
 AspisUntainted_call_user_func($process_post_func,$this->post);
continue ;
}if ( $doing_entry)
 {$this->post .= $importline . "\n";
}}$this->fclose($fp);
}{$AspisRetTemp = $is_wxr_file;
return $AspisRetTemp;
}} }
function get_wp_authors (  ) {
{$temp = $this->allauthornames;
$authors[0] = array_shift($temp);
$y = count($temp) + 1;
for ( $x = 1 ; $x < $y ; $x++ )
{$next = array_shift($temp);
if ( !(in_array($next,$authors)))
 array_push($authors,"$next");
}{$AspisRetTemp = $authors;
return $AspisRetTemp;
}} }
function get_authors_from_post (  ) {
{{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}foreach ( deAspisWarningRC($_POST[0]['author_in']) as $i =>$in_author_name )
{if ( !(empty($_POST[0]['user_select'][0][$i]) || Aspis_empty($_POST[0]['user_select'][0][$i])))
 {$user = get_userdata(intval(deAspisWarningRC($_POST[0]['user_select'][0][$i])));
if ( isset($user->ID))
 $this->author_ids[$in_author_name] = $user->ID;
}elseif ( $this->allow_create_users())
 {$new_author_name = trim(deAspisWarningRC($_POST[0]['user_create'][0][$i]));
if ( empty($new_author_name))
 $new_author_name = $in_author_name;
$user_id = username_exists($new_author_name);
if ( !$user_id)
 {$user_id = wp_create_user($new_author_name,wp_generate_password());
}$this->author_ids[$in_author_name] = $user_id;
}if ( empty($this->author_ids[$in_author_name]))
 {$this->author_ids[$in_author_name] = intval($current_user->ID);
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
 }
function wp_authors_form (  ) {
{;
?>
<h2><?php _e('Assign Authors');
;
?></h2>
<p><?php _e('To make it easier for you to edit and save the imported posts and drafts, you may want to change the name of the author of the posts. For example, you may want to import all the entries as <code>admin</code>s entries.');
;
?></p>
<?php if ( $this->allow_create_users())
 {echo '<p>' . __('If a new user is created by WordPress, a password will be randomly generated. Manually change the user&#8217;s details if necessary.') . "</p>\n";
}$authors = $this->get_wp_authors();
echo '<form action="?import=wordpress&amp;step=2&amp;id=' . $this->id . '" method="post">';
wp_nonce_field('import-wordpress');
;
?>
<ol id="authors">
<?php $j = -1;
foreach ( $authors as $author  )
{++$j;
echo '<li>' . __('Import author:') . ' <strong>' . $author . '</strong><br />';
$this->users_form($j,$author);
echo '</li>';
}if ( $this->allow_fetch_attachments())
 {;
?>
</ol>
<h2><?php _e('Import Attachments');
;
?></h2>
<p>
	<input type="checkbox" value="1" name="attachments" id="import-attachments" />
	<label for="import-attachments"><?php _e('Download and import file attachments');
?></label>
</p>

<?php }echo '<p class="submit">';
echo '<input type="submit" class="button" value="' . esc_attr__('Submit') . '" />' . '<br />';
echo '</p>';
echo '</form>';
} }
function users_form ( $n,$author ) {
{if ( $this->allow_create_users())
 {printf('<label>' . __('Create user %1$s or map to existing'),' <input type="text" value="' . esc_attr($author) . '" name="' . 'user_create[' . intval($n) . ']' . '" maxlength="30" /></label> <br />');
}else 
{{echo __('Map to existing') . '<br />';
}}echo '<input type="hidden" name="author_in[' . intval($n) . ']" value="' . esc_attr($author) . '" />';
$users = get_users_of_blog();
;
?><select name="user_select[<?php echo $n;
;
?>]">
	<option value="0"><?php _e('- Select -');
;
?></option>
	<?php foreach ( $users as $user  )
{echo '<option value="' . $user->user_id . '">' . $user->user_login . '</option>';
};
?>
	</select>
	<?php } }
function select_authors (  ) {
{$is_wxr_file = $this->get_entries(array(&$this,'process_author'));
if ( $is_wxr_file)
 {$this->wp_authors_form();
}else 
{{echo '<h2>' . __('Invalid file') . '</h2>';
echo '<p>' . __('Please upload a valid WXR (WordPress eXtended RSS) export file.') . '</p>';
}}} }
function checkauthor ( $author ) {
{{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}if ( !empty($this->author_ids[$author]))
 {$AspisRetTemp = $this->author_ids[$author];
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}{$AspisRetTemp = $current_user->ID;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
 }
function process_categories (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$cat_names = (array)get_terms('category','fields=names');
while ( $c = array_shift($this->categories) )
{$cat_name = trim($this->get_tag($c,'wp:cat_name'));
if ( in_array($cat_name,$cat_names))
 continue ;
$category_nicename = $this->get_tag($c,'wp:category_nicename');
$category_description = $this->get_tag($c,'wp:category_description');
$posts_private = (int)$this->get_tag($c,'wp:posts_private');
$links_private = (int)$this->get_tag($c,'wp:links_private');
$parent = $this->get_tag($c,'wp:category_parent');
if ( empty($parent))
 $category_parent = '0';
else 
{$category_parent = category_exists($parent);
}$catarr = compact('category_nicename','category_parent','posts_private','links_private','posts_private','cat_name','category_description');
$cat_ID = wp_insert_category($catarr);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function process_tags (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$tag_names = (array)get_terms('post_tag','fields=names');
while ( $c = array_shift($this->tags) )
{$tag_name = trim($this->get_tag($c,'wp:tag_name'));
if ( in_array($tag_name,$tag_names))
 continue ;
$slug = $this->get_tag($c,'wp:tag_slug');
$description = $this->get_tag($c,'wp:tag_description');
$tagarr = compact('slug','description');
$tag_ID = wp_insert_term($tag_name,'post_tag',$tagarr);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function process_terms (  ) {
{{global $wpdb,$wp_taxonomies;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
$AspisVar1 = &AspisCleanTaintedGlobalUntainted($wp_taxonomies,"\$wp_taxonomies",$AspisChangesCache);
}$custom_taxonomies = $wp_taxonomies;
unset($custom_taxonomies['category']);
unset($custom_taxonomies['post_tag']);
unset($custom_taxonomies['link_category']);
$custom_taxonomies = array_keys($custom_taxonomies);
$current_terms = (array)get_terms($custom_taxonomies,'get=all');
$taxonomies = array();
foreach ( $current_terms as $term  )
{if ( isset($_terms[$term->taxonomy]))
 {$taxonomies[$term->taxonomy] = array_merge($taxonomies[$term->taxonomy],array($term->name));
}else 
{{$taxonomies[$term->taxonomy] = array($term->name);
}}}while ( $c = array_shift($this->terms) )
{$term_name = trim($this->get_tag($c,'wp:term_name'));
$term_taxonomy = trim($this->get_tag($c,'wp:term_taxonomy'));
if ( isset($taxonomies[$term_taxonomy]) && in_array($term_name,$taxonomies[$term_taxonomy]))
 continue ;
$slug = $this->get_tag($c,'wp:term_slug');
$description = $this->get_tag($c,'wp:term_description');
$termarr = compact('slug','description');
$term_ID = wp_insert_term($term_name,$this->get_tag($c,'wp:term_taxonomy'),$termarr);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
AspisRestoreTaintedGlobalUntainted($AspisVar1,"\$wp_taxonomies",$AspisChangesCache);
 }
function process_author ( $post ) {
{$author = $this->get_tag($post,'dc:creator');
if ( $author)
 $this->allauthornames[] = $author;
} }
function process_posts (  ) {
{echo '<ol>';
$this->get_entries(array(&$this,'process_post'));
echo '</ol>';
wp_import_cleanup($this->id);
do_action('import_done','wordpress');
echo '<h3>' . sprintf(__('All done.') . ' <a href="%s">' . __('Have fun!') . '</a>',get_option('home')) . '</h3>';
} }
function _normalize_tag ( $matches ) {
{{$AspisRetTemp = '<' . strtolower($matches[1]);
return $AspisRetTemp;
}} }
function process_post ( $post ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$post_ID = (int)$this->get_tag($post,'wp:post_id');
if ( $post_ID && !empty($this->post_ids_processed[$post_ID]))
 {$AspisRetTemp = 0;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}set_time_limit(60);
$post_title = $this->get_tag($post,'title');
$post_date = $this->get_tag($post,'wp:post_date');
$post_date_gmt = $this->get_tag($post,'wp:post_date_gmt');
$comment_status = $this->get_tag($post,'wp:comment_status');
$ping_status = $this->get_tag($post,'wp:ping_status');
$post_status = $this->get_tag($post,'wp:status');
$post_name = $this->get_tag($post,'wp:post_name');
$post_parent = $this->get_tag($post,'wp:post_parent');
$menu_order = $this->get_tag($post,'wp:menu_order');
$post_type = $this->get_tag($post,'wp:post_type');
$post_password = $this->get_tag($post,'wp:post_password');
$is_sticky = $this->get_tag($post,'wp:is_sticky');
$guid = $this->get_tag($post,'guid');
$post_author = $this->get_tag($post,'dc:creator');
$post_excerpt = $this->get_tag($post,'excerpt:encoded');
$post_excerpt = preg_replace_callback('|<(/?[A-Z]+)|',array(&$this,'_normalize_tag'),$post_excerpt);
$post_excerpt = str_replace('<br>','<br />',$post_excerpt);
$post_excerpt = str_replace('<hr>','<hr />',$post_excerpt);
$post_content = $this->get_tag($post,'content:encoded');
$post_content = preg_replace_callback('|<(/?[A-Z]+)|',array(&$this,'_normalize_tag'),$post_content);
$post_content = str_replace('<br>','<br />',$post_content);
$post_content = str_replace('<hr>','<hr />',$post_content);
preg_match_all('|<category domain="tag">(.*?)</category>|is',$post,$tags);
$tags = $tags[1];
$tag_index = 0;
foreach ( $tags as $tag  )
{$tags[$tag_index] = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($this->unhtmlentities(str_replace(array('<![CDATA[',']]>'),'',$tag)))),array(0));
$tag_index++;
}preg_match_all('|<category>(.*?)</category>|is',$post,$categories);
$categories = $categories[1];
$cat_index = 0;
foreach ( $categories as $category  )
{$categories[$cat_index] = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($this->unhtmlentities(str_replace(array('<![CDATA[',']]>'),'',$category)))),array(0));
$cat_index++;
}$post_exists = post_exists($post_title,'',$post_date);
if ( $post_exists)
 {echo '<li>';
printf(__('Post <em>%s</em> already exists.'),stripslashes($post_title));
$comment_post_ID = $post_id = $post_exists;
}else 
{{$post_parent = (int)$post_parent;
if ( $post_parent)
 {if ( $parent = $this->post_ids_processed[$post_parent])
 {$post_parent = $parent;
}else 
{{$this->orphans[intval($post_ID)] = $post_parent;
}}}echo '<li>';
$post_author = $this->checkauthor($post_author);
$postdata = compact('post_author','post_date','post_date_gmt','post_content','post_excerpt','post_title','post_status','post_name','comment_status','ping_status','guid','post_parent','menu_order','post_type','post_password');
$postdata['import_id'] = $post_ID;
if ( $post_type == 'attachment')
 {$remote_url = $this->get_tag($post,'wp:attachment_url');
if ( !$remote_url)
 $remote_url = $guid;
$comment_post_ID = $post_id = $this->process_attachment($postdata,$remote_url);
if ( !$post_id or is_wp_error($post_id))
 {$AspisRetTemp = $post_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}else 
{{printf(__('Importing post <em>%s</em>...'),stripslashes($post_title));
$comment_post_ID = $post_id = wp_insert_post($postdata);
if ( $post_id && $is_sticky == 1)
 stick_post($post_id);
}}if ( is_wp_error($post_id))
 {$AspisRetTemp = $post_id;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( $post_id && $post_ID)
 {$this->post_ids_processed[intval($post_ID)] = intval($post_id);
}if ( count($categories) > 0)
 {$post_cats = array();
foreach ( $categories as $category  )
{if ( '' == $category)
 continue ;
$slug = sanitize_term_field('slug',$category,0,'category','db');
$cat = get_term_by('slug',$slug,'category');
$cat_ID = 0;
if ( !empty($cat))
 $cat_ID = $cat->term_id;
if ( $cat_ID == 0)
 {$category = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($category)),array(0));
$cat_ID = wp_insert_category(array('cat_name' => $category));
if ( is_wp_error($cat_ID))
 continue ;
}$post_cats[] = $cat_ID;
}wp_set_post_categories($post_id,$post_cats);
}if ( count($tags) > 0)
 {$post_tags = array();
foreach ( $tags as $tag  )
{if ( '' == $tag)
 continue ;
$slug = sanitize_term_field('slug',$tag,0,'post_tag','db');
$tag_obj = get_term_by('slug',$slug,'post_tag');
$tag_id = 0;
if ( !empty($tag_obj))
 $tag_id = $tag_obj->term_id;
if ( $tag_id == 0)
 {$tag = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($tag)),array(0));
$tag_id = wp_insert_term($tag,'post_tag');
if ( is_wp_error($tag_id))
 continue ;
$tag_id = $tag_id['term_id'];
}$post_tags[] = intval($tag_id);
}wp_set_post_tags($post_id,$post_tags);
}}}preg_match_all('|<wp:comment>(.*?)</wp:comment>|is',$post,$comments);
$comments = $comments[1];
$num_comments = 0;
$inserted_comments = array();
if ( $comments)
 {foreach ( $comments as $comment  )
{$comment_id = $this->get_tag($comment,'wp:comment_id');
$newcomments[$comment_id]['comment_post_ID'] = $comment_post_ID;
$newcomments[$comment_id]['comment_author'] = $this->get_tag($comment,'wp:comment_author');
$newcomments[$comment_id]['comment_author_email'] = $this->get_tag($comment,'wp:comment_author_email');
$newcomments[$comment_id]['comment_author_IP'] = $this->get_tag($comment,'wp:comment_author_IP');
$newcomments[$comment_id]['comment_author_url'] = $this->get_tag($comment,'wp:comment_author_url');
$newcomments[$comment_id]['comment_date'] = $this->get_tag($comment,'wp:comment_date');
$newcomments[$comment_id]['comment_date_gmt'] = $this->get_tag($comment,'wp:comment_date_gmt');
$newcomments[$comment_id]['comment_content'] = $this->get_tag($comment,'wp:comment_content');
$newcomments[$comment_id]['comment_approved'] = $this->get_tag($comment,'wp:comment_approved');
$newcomments[$comment_id]['comment_type'] = $this->get_tag($comment,'wp:comment_type');
$newcomments[$comment_id]['comment_parent'] = $this->get_tag($comment,'wp:comment_parent');
}ksort($newcomments);
foreach ( $newcomments as $key =>$comment )
{if ( !$post_exists || !comment_exists($comment['comment_author'],$comment['comment_date']))
 {if ( isset($inserted_comments[$comment['comment_parent']]))
 $comment['comment_parent'] = $inserted_comments[$comment['comment_parent']];
$comment = wp_filter_comment($comment);
$inserted_comments[$key] = wp_insert_comment($comment);
$num_comments++;
}}}if ( $num_comments)
 printf(' ' . _n('(%s comment)','(%s comments)',$num_comments),$num_comments);
preg_match_all('|<wp:postmeta>(.*?)</wp:postmeta>|is',$post,$postmeta);
$postmeta = $postmeta[1];
if ( $postmeta)
 {foreach ( $postmeta as $p  )
{$key = $this->get_tag($p,'wp:meta_key');
$value = $this->get_tag($p,'wp:meta_value');
$value = stripslashes($value);
$this->process_post_meta($post_id,$key,$value);
}}do_action('import_post_added',$post_id);
print "</li>\n";
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function process_post_meta ( $post_id,$key,$value ) {
{$_key = apply_filters('import_post_meta_key',$key);
if ( $_key)
 {add_post_meta($post_id,$_key,$value);
do_action('import_post_meta',$post_id,$_key,$value);
}} }
function process_attachment ( $postdata,$remote_url ) {
{if ( $this->fetch_attachments and $remote_url)
 {printf(__('Importing attachment <em>%s</em>... '),htmlspecialchars($remote_url));
if ( preg_match('/^\/[\w\W]+$/',$remote_url))
 $remote_url = rtrim($this->base_url,'/') . $remote_url;
$upload = $this->fetch_remote_file($postdata,$remote_url);
if ( is_wp_error($upload))
 {printf(__('Remote file error: %s'),htmlspecialchars($upload->get_error_message()));
{$AspisRetTemp = $upload;
return $AspisRetTemp;
}}else 
{{print '(' . size_format(filesize($upload['file'])) . ')';
}}if ( $info = wp_check_filetype($upload['file']))
 {$postdata['post_mime_type'] = $info['type'];
}else 
{{print __('Invalid file type');
{return ;
}}}$postdata['guid'] = $upload['url'];
$post_id = wp_insert_attachment($postdata,$upload['file']);
wp_update_attachment_metadata($post_id,wp_generate_attachment_metadata($post_id,$upload['file']));
if ( preg_match('@^image/@',$info['type']) && $thumb_url = wp_get_attachment_thumb_url($post_id))
 {$parts = pathinfo($remote_url);
$ext = $parts['extension'];
$name = basename($parts['basename'],".{$ext}");
$this->url_remap[$parts['dirname'] . '/' . $name . '.thumbnail.' . $ext] = $thumb_url;
}{$AspisRetTemp = $post_id;
return $AspisRetTemp;
}}else 
{{printf(__('Skipping attachment <em>%s</em>'),htmlspecialchars($remote_url));
}}} }
function fetch_remote_file ( $post,$url ) {
{$upload = wp_upload_dir($post['post_date']);
$file_name = basename($url);
$upload = wp_upload_bits($file_name,0,'',$post['post_date']);
if ( $upload['error'])
 {echo $upload['error'];
{$AspisRetTemp = new WP_Error('upload_dir_error',$upload['error']);
return $AspisRetTemp;
}}$headers = wp_get_http($url,$upload['file']);
if ( !$headers)
 {@unlink($upload['file']);
{$AspisRetTemp = new WP_Error('import_file_error',__('Remote server did not respond'));
return $AspisRetTemp;
}}if ( $headers['response'] != '200')
 {@unlink($upload['file']);
{$AspisRetTemp = new WP_Error('import_file_error',sprintf(__('Remote file returned error response %1$d %2$s'),$headers['response'],get_status_header_desc($headers['response'])));
return $AspisRetTemp;
}}elseif ( isset($headers['content-length']) && filesize($upload['file']) != $headers['content-length'])
 {@unlink($upload['file']);
{$AspisRetTemp = new WP_Error('import_file_error',__('Remote file is incorrect size'));
return $AspisRetTemp;
}}$max_size = $this->max_attachment_size();
if ( !empty($max_size) and filesize($upload['file']) > $max_size)
 {@unlink($upload['file']);
{$AspisRetTemp = new WP_Error('import_file_error',sprintf(__('Remote file is too large, limit is %s',size_format($max_size))));
return $AspisRetTemp;
}}$this->url_remap[$url] = $upload['url'];
if ( $headers['x-final-location'] != $url)
 $this->url_remap[$headers['x-final-location']] = $upload['url'];
{$AspisRetTemp = $upload;
return $AspisRetTemp;
}} }
function cmpr_strlen ( $a,$b ) {
{{$AspisRetTemp = strlen($b) - strlen($a);
return $AspisRetTemp;
}} }
function backfill_attachment_urls (  ) {
{uksort($this->url_remap,array(&$this,'cmpr_strlen'));
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}foreach ( $this->url_remap as $from_url =>$to_url )
{$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, '%s', '%s')",$from_url,$to_url));
$result = $wpdb->query($wpdb->prepare("UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, '%s', '%s') WHERE meta_key='enclosure'",$from_url,$to_url));
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function backfill_parents (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}foreach ( $this->orphans as $child_id =>$parent_id )
{$local_child_id = $this->post_ids_processed[$child_id];
$local_parent_id = $this->post_ids_processed[$parent_id];
if ( $local_child_id and $local_parent_id)
 {$wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_parent = %d WHERE ID = %d",$local_parent_id,$local_child_id));
}}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function is_valid_meta_key ( $key ) {
{if ( $key == '_wp_attached_file' || $key == '_wp_attachment_metadata')
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = $key;
return $AspisRetTemp;
}} }
function allow_create_users (  ) {
{{$AspisRetTemp = apply_filters('import_allow_create_users',true);
return $AspisRetTemp;
}} }
function allow_fetch_attachments (  ) {
{{$AspisRetTemp = apply_filters('import_allow_fetch_attachments',true);
return $AspisRetTemp;
}} }
function max_attachment_size (  ) {
{{$AspisRetTemp = apply_filters('import_attachment_size_limit',0);
return $AspisRetTemp;
}} }
function import_start (  ) {
{wp_defer_term_counting(true);
wp_defer_comment_counting(true);
do_action('import_start');
} }
function import_end (  ) {
{do_action('import_end');
foreach ( $this->post_ids_processed as $post_id  )
clean_post_cache($post_id);
wp_defer_term_counting(false);
wp_defer_comment_counting(false);
} }
function import ( $id,$fetch_attachments = false ) {
{$this->id = (int)$id;
$this->fetch_attachments = ($this->allow_fetch_attachments() && (bool)$fetch_attachments);
add_filter('import_post_meta_key',array($this,'is_valid_meta_key'));
$file = get_attached_file($this->id);
$this->import_file($file);
} }
function import_file ( $file ) {
{$this->file = $file;
$this->import_start();
$this->get_authors_from_post();
wp_suspend_cache_invalidation(true);
$this->get_entries();
$this->process_categories();
$this->process_tags();
$this->process_terms();
$result = $this->process_posts();
wp_suspend_cache_invalidation(false);
$this->backfill_parents();
$this->backfill_attachment_urls();
$this->import_end();
if ( is_wp_error($result))
 {$AspisRetTemp = $result;
return $AspisRetTemp;
}} }
function handle_upload (  ) {
{$file = wp_import_handle_upload();
if ( isset($file['error']))
 {echo '<p>' . __('Sorry, there has been an error.') . '</p>';
echo '<p><strong>' . $file['error'] . '</strong></p>';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$this->file = $file['file'];
$this->id = (int)$file['id'];
{$AspisRetTemp = true;
return $AspisRetTemp;
}} }
function dispatch (  ) {
{if ( (empty($_GET[0]['step']) || Aspis_empty($_GET[0]['step'])))
 $step = 0;
else 
{$step = (int)deAspisWarningRC($_GET[0]['step']);
}$this->header();
switch ( $step ) {
case 0:$this->greet();
break ;
case 1:check_admin_referer('import-upload');
if ( $this->handle_upload())
 $this->select_authors();
break ;
case 2:check_admin_referer('import-wordpress');
$result = $this->import(deAspisWarningRC($_GET[0]['id']),deAspisWarningRC($_POST[0]['attachments']));
if ( is_wp_error($result))
 echo $result->get_error_message();
break ;
 }
$this->footer();
} }
function WP_Import (  ) {
{} }
}$wp_import = new WP_Import();
register_importer('wordpress','WordPress',__('Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.'),array($wp_import,'dispatch'));
;
?>
<?php 