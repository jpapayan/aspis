<?php require_once('AspisMain.php'); ?><?php
function get_the_author ( $deprecated = array('',false) ) {
global $authordata;
return apply_filters(array('the_author',false),is_object($authordata[0]) ? $authordata[0]->display_name : array(null,false));
 }
function the_author ( $deprecated = array('',false),$deprecated_echo = array(true,false) ) {
if ( $deprecated_echo[0])
 echo AspisCheckPrint(get_the_author());
return get_the_author();
 }
function get_the_modified_author (  ) {
global $post;
if ( deAspis($last_id = get_post_meta($post[0]->ID,array('_edit_last',false),array(true,false))))
 {$last_user = get_userdata($last_id);
return apply_filters(array('the_modified_author',false),$last_user[0]->display_name);
} }
function the_modified_author (  ) {
echo AspisCheckPrint(get_the_modified_author());
 }
function get_the_author_meta ( $field = array('',false),$user_id = array(false,false) ) {
if ( (denot_boolean($user_id)))
 global $authordata;
else 
{$authordata = get_userdata($user_id);
}$field = Aspis_strtolower($field);
$user_field = concat1("user_",$field);
if ( (('id') == $field[0]))
 $value = ((isset($authordata[0]->ID) && Aspis_isset( $authordata[0] ->ID ))) ? int_cast($authordata[0]->ID) : array(0,false);
elseif ( ((isset($authordata[0]->$user_field[0]) && Aspis_isset( $authordata[0] ->$user_field[0] ))))
 $value = $authordata[0]->$user_field[0];
else 
{$value = ((isset($authordata[0]->$field[0]) && Aspis_isset( $authordata[0] ->$field[0] ))) ? $authordata[0]->$field[0] : array('',false);
}return apply_filters(concat1('get_the_author_',$field),$value,$user_id);
 }
function the_author_meta ( $field = array('',false),$user_id = array(false,false) ) {
echo AspisCheckPrint(apply_filters(concat1('the_author_',$field),get_the_author_meta($field,$user_id),$user_id));
 }
function the_author_link (  ) {
if ( deAspis(get_the_author_meta(array('url',false))))
 {echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1('<a href="',get_the_author_meta(array('url',false))),'" title="'),esc_attr(Aspis_sprintf(__(array("Visit %s&#8217;s website",false)),get_the_author()))),'" rel="external">'),get_the_author()),'</a>'));
}else 
{{the_author();
}} }
function get_the_author_posts (  ) {
global $post;
return get_usernumposts($post[0]->post_author);
 }
function the_author_posts (  ) {
echo AspisCheckPrint(get_the_author_posts());
 }
function the_author_posts_link ( $deprecated = array('',false) ) {
global $authordata;
$link = Aspis_sprintf(array('<a href="%1$s" title="%2$s">%3$s</a>',false),get_author_posts_url($authordata[0]->ID,$authordata[0]->user_nicename),esc_attr(Aspis_sprintf(__(array('Posts by %s',false)),get_the_author())),get_the_author());
echo AspisCheckPrint(apply_filters(array('the_author_posts_link',false),$link));
 }
function get_author_posts_url ( $author_id,$author_nicename = array('',false) ) {
global $wp_rewrite;
$auth_ID = int_cast($author_id);
$link = $wp_rewrite[0]->get_author_permastruct();
if ( ((empty($link) || Aspis_empty( $link))))
 {$file = concat2(get_option(array('home',false)),'/');
$link = concat(concat2($file,'?author='),$auth_ID);
}else 
{{if ( (('') == $author_nicename[0]))
 {$user = get_userdata($author_id);
if ( (!((empty($user[0]->user_nicename) || Aspis_empty( $user[0] ->user_nicename )))))
 $author_nicename = $user[0]->user_nicename;
}$link = Aspis_str_replace(array('%author%',false),$author_nicename,$link);
$link = concat(get_option(array('home',false)),trailingslashit($link));
}}$link = apply_filters(array('author_link',false),$link,$author_id,$author_nicename);
return $link;
 }
function wp_list_authors ( $args = array('',false) ) {
global $wpdb;
$defaults = array(array('optioncount' => array(false,false,false),'exclude_admin' => array(true,false,false),'show_fullname' => array(false,false,false),'hide_empty' => array(true,false,false),'feed' => array('',false,false),'feed_image' => array('',false,false),'feed_type' => array('',false,false),'echo' => array(true,false,false),'style' => array('list',false,false),'html' => array(true,false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$return = array('',false);
$authors = $wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT ID, user_nicename from ",$wpdb[0]->users)," "),($exclude_admin[0] ? array("WHERE user_login <> 'admin' ",false) : array('',false))),"ORDER BY display_name"));
$author_count = array(array(),false);
foreach ( deAspis(array_cast($wpdb[0]->get_results(concat2(concat(concat2(concat1("SELECT DISTINCT post_author, COUNT(ID) AS count FROM ",$wpdb[0]->posts)," WHERE post_type = 'post' AND "),get_private_posts_cap_sql(array('post',false)))," GROUP BY post_author")))) as $row  )
{arrayAssign($author_count[0],deAspis(registerTaint($row[0]->post_author)),addTaint($row[0]->count));
}foreach ( deAspis(array_cast($authors)) as $author  )
{$link = array('',false);
$author = get_userdata($author[0]->ID);
$posts = ((isset($author_count[0][$author[0]->ID[0]]) && Aspis_isset( $author_count [0][$author[0] ->ID [0]]))) ? attachAspis($author_count,$author[0]->ID[0]) : array(0,false);
$name = $author[0]->display_name;
if ( ($show_fullname[0] && (($author[0]->first_name[0] != ('')) && ($author[0]->last_name[0] != ('')))))
 $name = concat(concat2($author[0]->first_name," "),$author[0]->last_name);
if ( (denot_boolean($html)))
 {if ( ($posts[0] == (0)))
 {if ( (denot_boolean($hide_empty)))
 $return = concat($return,concat2($name,', '));
}else 
{$return = concat($return,concat2($name,', '));
}continue ;
}if ( ((!(($posts[0] == (0)) && $hide_empty[0])) && (('list') == $style[0])))
 $return = concat2($return,'<li>');
if ( ($posts[0] == (0)))
 {if ( (denot_boolean($hide_empty)))
 $link = $name;
}else 
{{$link = concat2(concat(concat2(concat(concat2(concat1('<a href="',get_author_posts_url($author[0]->ID,$author[0]->user_nicename)),'" title="'),esc_attr(Aspis_sprintf(__(array("Posts by %s",false)),$author[0]->display_name))),'">'),$name),'</a>');
if ( ((!((empty($feed_image) || Aspis_empty( $feed_image)))) || (!((empty($feed) || Aspis_empty( $feed))))))
 {$link = concat2($link,' ');
if ( ((empty($feed_image) || Aspis_empty( $feed_image))))
 $link = concat2($link,'(');
$link = concat($link,concat2(concat1('<a href="',get_author_feed_link($author[0]->ID)),'"'));
if ( (!((empty($feed) || Aspis_empty( $feed)))))
 {$title = concat2(concat1(' title="',esc_attr($feed)),'"');
$alt = concat2(concat1(' alt="',esc_attr($feed)),'"');
$name = $feed;
$link = concat($link,$title);
}$link = concat2($link,'>');
if ( (!((empty($feed_image) || Aspis_empty( $feed_image)))))
 $link = concat($link,concat2(concat(concat1("<img src=\"",esc_url($feed_image)),concat(concat1("\" style=\"border: none;\"",$alt),$title)),' />'));
else 
{$link = concat($link,$name);
}$link = concat2($link,'</a>');
if ( ((empty($feed_image) || Aspis_empty( $feed_image))))
 $link = concat2($link,')');
}if ( $optioncount[0])
 $link = concat($link,concat2(concat1(' (',$posts),')'));
}}if ( ((!(($posts[0] == (0)) && $hide_empty[0])) && (('list') == $style[0])))
 $return = concat($return,concat2($link,'</li>'));
else 
{if ( (denot_boolean($hide_empty)))
 $return = concat($return,concat2($link,', '));
}}$return = Aspis_trim($return,array(', ',false));
if ( (denot_boolean($echo)))
 return $return;
echo AspisCheckPrint($return);
 }
;
?>
<?php 