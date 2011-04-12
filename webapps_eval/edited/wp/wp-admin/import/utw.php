<?php require_once('AspisMain.php'); ?><?php
class UTW_Import{function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import Ultimate Tag Warrior',false))),'</h2>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Steps may take a few minutes depending on the size of your database. Please be patient.',false))),'<br /><br /></p>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function greet (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Howdy! This imports tags from Ultimate Tag Warrior 3 into WordPress tags.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('This has not been tested on any other versions of Ultimate Tag Warrior. Mileage may vary.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('To accommodate larger databases for those tag-crazy authors out there, we have made this into an easy 5-step program to help you kick that nasty UTW habit. Just keep clicking along and we will let you know when you are in the clear!',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p><strong>',__(array('Don&#8217;t be stupid - backup your database before proceeding!',false))),'</strong></p>'));
echo AspisCheckPrint(array('<form action="admin.php?import=utw&amp;step=1" method="post">',false));
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Step 1',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 {$step = array(0,false);
}else 
{{$step = int_cast($_GET[0]['step']);
}}if ( ($step[0] > (1)))
 check_admin_referer(array('import-utw',false));
$this->header();
switch ( $step[0] ) {
case (0):$this->greet();
break ;
case (1):$this->import_tags();
break ;
case (2):$this->import_posts();
break ;
case (3):$this->import_t2p();
break ;
case (4):$this->cleanup_import();
break ;
 }
$this->footer();
} }
function import_tags (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p><h3>',__(array('Reading UTW Tags&#8230;',false))),'</h3></p>'));
$tags = $this->get_utw_tags();
if ( (!(is_array($tags[0]))))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('No Tags Found!',false))),'</p>'));
return array(false,false);
}else 
{{if ( deAspis(get_option(array('utwimp_tags',false))))
 {delete_option(array('utwimp_tags',false));
}add_option(array('utwimp_tags',false),$tags);
$count = attAspis(count($tags[0]));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(_n(array('Done! <strong>%s</strong> tag were read.',false),array('Done! <strong>%s</strong> tags were read.',false),$count),$count)),'<br /></p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('The following tags were found:',false))),'</p>'));
echo AspisCheckPrint(array('<ul>',false));
foreach ( $tags[0] as $tag_id =>$tag_name )
{restoreTaint($tag_id,$tag_name);
{echo AspisCheckPrint(concat2(concat1('<li>',$tag_name),'</li>'));
}}echo AspisCheckPrint(array('</ul>',false));
echo AspisCheckPrint(array('<br />',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('If you don&#8217;t want to import any of these tags, you should delete them from the UTW tag management page and then re-run this import.',false))),'</p>'));
}}echo AspisCheckPrint(array('<form action="admin.php?import=utw&amp;step=2" method="post">',false));
wp_nonce_field(array('import-utw',false));
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Step 2',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function import_posts (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p><h3>',__(array('Reading UTW Post Tags&#8230;',false))),'</h3></p>'));
$posts = $this->get_utw_posts();
if ( (!(is_array($posts[0]))))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('No posts were found to have tags!',false))),'</p>'));
return array(false,false);
}else 
{{if ( deAspis(get_option(array('utwimp_posts',false))))
 {delete_option(array('utwimp_posts',false));
}add_option(array('utwimp_posts',false),$posts);
$count = attAspis(count($posts[0]));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(_n(array('Done! <strong>%s</strong> tag to post relationships were read.',false),array('Done! <strong>%s</strong> tags to post relationships were read.',false),$count),$count)),'<br /></p>'));
}}echo AspisCheckPrint(array('<form action="admin.php?import=utw&amp;step=3" method="post">',false));
wp_nonce_field(array('import-utw',false));
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Step 3',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function import_t2p (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p><h3>',__(array('Adding Tags to Posts&#8230;',false))),'</h3></p>'));
$tags_added = $this->tag2post();
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(_n(array('Done! <strong>%s</strong> tag were added!',false),array('Done! <strong>%s</strong> tags were added!',false),$tags_added),$tags_added)),'<br /></p>'));
echo AspisCheckPrint(array('<form action="admin.php?import=utw&amp;step=4" method="post">',false));
wp_nonce_field(array('import-utw',false));
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Step 4',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function get_utw_tags (  ) {
{global $wpdb;
$tags_query = concat2(concat1("SELECT tag_id, tag FROM ",$wpdb[0]->prefix),"tags");
$tags = $wpdb[0]->get_results($tags_query);
foreach ( $tags[0] as $tag  )
{arrayAssign($new_tags[0],deAspis(registerTaint($tag[0]->tag_id)),addTaint($tag[0]->tag));
}return $new_tags;
} }
function get_utw_posts (  ) {
{global $wpdb;
$posts_query = concat2(concat1("SELECT tag_id, post_id FROM ",$wpdb[0]->prefix),"post2tag");
$posts = $wpdb[0]->get_results($posts_query);
return $posts;
} }
function tag2post (  ) {
{$tags = get_option(array('utwimp_tags',false));
$posts = get_option(array('utwimp_posts',false));
$tags_added = array(0,false);
foreach ( $posts[0] as $this_post  )
{$the_post = int_cast($this_post[0]->post_id);
$the_tag = int_cast($this_post[0]->tag_id);
$the_tag = attachAspis($tags,$the_tag[0]);
wp_add_post_tags($the_post,$the_tag);
postincr($tags_added);
}return $tags_added;
} }
function cleanup_import (  ) {
{delete_option(array('utwimp_tags',false));
delete_option(array('utwimp_posts',false));
$this->done();
} }
function done (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p><h3>',__(array('Import Complete!',false))),'</h3></p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('OK, so we lied about this being a 5-step program! You&#8217;re done!',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Now wasn&#8217;t that easy?',false))),'</p>'));
echo AspisCheckPrint(array('</div>',false));
} }
function UTW_Import (  ) {
{} }
}$utw_import = array(new UTW_Import(),false);
register_importer(array('utw',false),array('Ultimate Tag Warrior',false),__(array('Import Ultimate Tag Warrior tags into WordPress tags.',false)),array(array($utw_import,array('dispatch',false)),false));
;
?>
<?php 