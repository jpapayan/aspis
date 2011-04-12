<?php require_once('AspisMain.php'); ?><?php
function _walk_bookmarks ( $bookmarks,$args = array('',false) ) {
$defaults = array(array('show_updated' => array(0,false,false),'show_description' => array(0,false,false),'show_images' => array(1,false,false),'show_name' => array(0,false,false),'before' => array('<li>',false,false),'after' => array('</li>',false,false),'between' => array("\n",false,false),'show_rating' => array(0,false,false),'link_before' => array('',false,false),'link_after' => array('',false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$output = array('',false);
foreach ( deAspis(array_cast($bookmarks)) as $bookmark  )
{if ( (!((isset($bookmark[0]->recently_updated) && Aspis_isset( $bookmark[0] ->recently_updated )))))
 $bookmark[0]->recently_updated = array(false,false);
$output = concat($output,$before);
if ( ($show_updated[0] && $bookmark[0]->recently_updated[0]))
 $output = concat($output,get_option(array('links_recently_updated_prepend',false)));
$the_link = array('#',false);
if ( (!((empty($bookmark[0]->link_url) || Aspis_empty( $bookmark[0] ->link_url )))))
 $the_link = esc_url($bookmark[0]->link_url);
$desc = esc_attr(sanitize_bookmark_field(array('link_description',false),$bookmark[0]->link_description,$bookmark[0]->link_id,array('display',false)));
$name = esc_attr(sanitize_bookmark_field(array('link_name',false),$bookmark[0]->link_name,$bookmark[0]->link_id,array('display',false)));
$title = $desc;
if ( $show_updated[0])
 if ( (('00') != deAspis(Aspis_substr($bookmark[0]->link_updated_f,array(0,false),array(2,false)))))
 {$title = concat2($title,' (');
$title = concat($title,Aspis_sprintf(__(array('Last updated: %s',false)),attAspis(date(deAspis(get_option(array('links_updated_date_format',false))),($bookmark[0]->link_updated_f[0] + (deAspis(get_option(array('gmt_offset',false))) * (3600)))))));
$title = concat2($title,')');
}$alt = concat2(concat(concat1(' alt="',$name),($show_description[0] ? concat1(' ',$title) : array('',false))),'"');
if ( (('') != $title[0]))
 $title = concat2(concat1(' title="',$title),'"');
$rel = $bookmark[0]->link_rel;
if ( (('') != $rel[0]))
 $rel = concat2(concat1(' rel="',esc_attr($rel)),'"');
$target = $bookmark[0]->link_target;
if ( (('') != $target[0]))
 $target = concat2(concat1(' target="',$target),'"');
$output = concat($output,concat2(concat(concat(concat(concat2(concat1('<a href="',$the_link),'"'),$rel),$title),$target),'>'));
$output = concat($output,$link_before);
if ( (($bookmark[0]->link_image[0] != null) && $show_images[0]))
 {if ( (strpos($bookmark[0]->link_image[0],'http') === (0)))
 $output = concat($output,concat2(concat(concat2(concat(concat2(concat1("<img src=\"",$bookmark[0]->link_image),"\" "),$alt)," "),$title)," />"));
else 
{$output = concat($output,concat(concat1("<img src=\"",get_option(array('siteurl',false))),concat2(concat(concat2(concat(concat2($bookmark[0]->link_image,"\" "),$alt)," "),$title)," />")));
}if ( $show_name[0])
 $output = concat($output,concat1(" ",$name));
}else 
{{$output = concat($output,$name);
}}$output = concat($output,$link_after);
$output = concat2($output,'</a>');
if ( ($show_updated[0] && $bookmark[0]->recently_updated[0]))
 $output = concat($output,get_option(array('links_recently_updated_append',false)));
if ( ($show_description[0] && (('') != $desc[0])))
 $output = concat($output,concat($between,$desc));
if ( $show_rating[0])
 $output = concat($output,concat($between,sanitize_bookmark_field(array('link_rating',false),$bookmark[0]->link_rating,$bookmark[0]->link_id,array('display',false))));
$output = concat($output,concat2($after,"\n"));
}return $output;
 }
function wp_list_bookmarks ( $args = array('',false) ) {
$defaults = array(array('orderby' => array('name',false,false),'order' => array('ASC',false,false),deregisterTaint(array('limit',false)) => addTaint(negate(array(1,false))),'category' => array('',false,false),'exclude_category' => array('',false,false),'category_name' => array('',false,false),'hide_invisible' => array(1,false,false),'show_updated' => array(0,false,false),'echo' => array(1,false,false),'categorize' => array(1,false,false),deregisterTaint(array('title_li',false)) => addTaint(__(array('Bookmarks',false))),'title_before' => array('<h2>',false,false),'title_after' => array('</h2>',false,false),'category_orderby' => array('name',false,false),'category_order' => array('ASC',false,false),'class' => array('linkcat',false,false),'category_before' => array('<li id="%id" class="%class">',false,false),'category_after' => array('</li>',false,false)),false);
$r = wp_parse_args($args,$defaults);
extract(($r[0]),EXTR_SKIP);
$output = array('',false);
if ( $categorize[0])
 {$cats = get_terms(array('link_category',false),array(array(deregisterTaint(array('name__like',false)) => addTaint($category_name),deregisterTaint(array('include',false)) => addTaint($category),deregisterTaint(array('exclude',false)) => addTaint($exclude_category),deregisterTaint(array('orderby',false)) => addTaint($category_orderby),deregisterTaint(array('order',false)) => addTaint($category_order),'hierarchical' => array(0,false,false)),false));
foreach ( deAspis(array_cast($cats)) as $cat  )
{$params = Aspis_array_merge($r,array(array(deregisterTaint(array('category',false)) => addTaint($cat[0]->term_id)),false));
$bookmarks = get_bookmarks($params);
if ( ((empty($bookmarks) || Aspis_empty( $bookmarks))))
 continue ;
$output = concat($output,Aspis_str_replace(array(array(array('%id',false),array('%class',false)),false),array(array(concat1("linkcat-",$cat[0]->term_id),$class),false),$category_before));
$catname = apply_filters(array("link_category",false),$cat[0]->name);
$output = concat($output,concat2(concat(concat($title_before,$catname),$title_after),"\n\t<ul class='xoxo blogroll'>\n"));
$output = concat($output,_walk_bookmarks($bookmarks,$r));
$output = concat($output,concat2(concat1("\n\t</ul>\n",$category_after),"\n"));
}}else 
{{$bookmarks = get_bookmarks($r);
if ( (!((empty($bookmarks) || Aspis_empty( $bookmarks)))))
 {if ( (!((empty($title_li) || Aspis_empty( $title_li)))))
 {$output = concat($output,Aspis_str_replace(array(array(array('%id',false),array('%class',false)),false),array(array(concat1("linkcat-",$category),$class),false),$category_before));
$output = concat($output,concat2(concat(concat($title_before,$title_li),$title_after),"\n\t<ul class='xoxo blogroll'>\n"));
$output = concat($output,_walk_bookmarks($bookmarks,$r));
$output = concat($output,concat2(concat1("\n\t</ul>\n",$category_after),"\n"));
}else 
{{$output = concat($output,_walk_bookmarks($bookmarks,$r));
}}}}}$output = apply_filters(array('wp_list_bookmarks',false),$output);
if ( (denot_boolean($echo)))
 return $output;
echo AspisCheckPrint($output);
 }
;
?>
<?php 