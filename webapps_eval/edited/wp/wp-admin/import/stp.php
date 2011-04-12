<?php require_once('AspisMain.php'); ?><?php
class STP_Import{function header (  ) {
{echo AspisCheckPrint(array('<div class="wrap">',false));
screen_icon();
echo AspisCheckPrint(concat2(concat1('<h2>',__(array('Import Simple Tagging',false))),'</h2>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Steps may take a few minutes depending on the size of your database. Please be patient.',false))),'<br /><br /></p>'));
} }
function footer (  ) {
{echo AspisCheckPrint(array('</div>',false));
} }
function greet (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Howdy! This imports tags from Simple Tagging 1.6.2 into WordPress tags.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('This has not been tested on any other versions of Simple Tagging. Mileage may vary.',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('To accommodate larger databases for those tag-crazy authors out there, we have made this into an easy 4-step program to help you kick that nasty Simple Tagging habit. Just keep clicking along and we will let you know when you are in the clear!',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p><strong>',__(array('Don&#8217;t be stupid - backup your database before proceeding!',false))),'</strong></p>'));
echo AspisCheckPrint(array('<form action="admin.php?import=stp&amp;step=1" method="post">',false));
wp_nonce_field(array('import-stp',false));
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Step 1',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function dispatch (  ) {
{if ( ((empty($_GET[0][('step')]) || Aspis_empty( $_GET [0][('step')]))))
 {$step = array(0,false);
}else 
{{$step = int_cast($_GET[0]['step']);
}}$this->header();
switch ( $step[0] ) {
case (0):$this->greet();
break ;
case (1):check_admin_referer(array('import-stp',false));
$this->import_posts();
break ;
case (2):check_admin_referer(array('import-stp',false));
$this->import_t2p();
break ;
case (3):check_admin_referer(array('import-stp',false));
$this->cleanup_import();
break ;
 }
$this->footer();
} }
function import_posts (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p><h3>',__(array('Reading STP Post Tags&#8230;',false))),'</h3></p>'));
$posts = $this->get_stp_posts();
if ( (!(is_array($posts[0]))))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('No posts were found to have tags!',false))),'</p>'));
return array(false,false);
}else 
{{if ( deAspis(get_option(array('stpimp_posts',false))))
 {delete_option(array('stpimp_posts',false));
}add_option(array('stpimp_posts',false),$posts);
$count = attAspis(count($posts[0]));
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(_n(array('Done! <strong>%s</strong> tag to post relationships were read.',false),array('Done! <strong>%s</strong> tags to post relationships were read.',false),$count),$count)),'<br /></p>'));
}}echo AspisCheckPrint(array('<form action="admin.php?import=stp&amp;step=2" method="post">',false));
wp_nonce_field(array('import-stp',false));
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Step 2',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function import_t2p (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p><h3>',__(array('Adding Tags to Posts&#8230;',false))),'</h3></p>'));
$tags_added = $this->tag2post();
echo AspisCheckPrint(concat2(concat1('<p>',Aspis_sprintf(_n(array('Done! <strong>%s</strong> tag was added!',false),array('Done! <strong>%s</strong> tags were added!',false),$tags_added),$tags_added)),'<br /></p>'));
echo AspisCheckPrint(array('<form action="admin.php?import=stp&amp;step=3" method="post">',false));
wp_nonce_field(array('import-stp',false));
echo AspisCheckPrint(concat2(concat1('<p class="submit"><input type="submit" name="submit" class="button" value="',esc_attr__(array('Step 3',false))),'" /></p>'));
echo AspisCheckPrint(array('</form>',false));
echo AspisCheckPrint(array('</div>',false));
} }
function get_stp_posts (  ) {
{global $wpdb;
$posts_query = concat2(concat1("SELECT post_id, tag_name FROM ",$wpdb[0]->prefix),"stp_tags");
$posts = $wpdb[0]->get_results($posts_query);
return $posts;
} }
function tag2post (  ) {
{global $wpdb;
$posts = get_option(array('stpimp_posts',false));
$tags_added = array(0,false);
foreach ( $posts[0] as $this_post  )
{$the_post = int_cast($this_post[0]->post_id);
$the_tag = $wpdb[0]->escape($this_post[0]->tag_name);
wp_add_post_tags($the_post,$the_tag);
postincr($tags_added);
}return $tags_added;
} }
function cleanup_import (  ) {
{delete_option(array('stpimp_posts',false));
$this->done();
} }
function done (  ) {
{echo AspisCheckPrint(array('<div class="narrow">',false));
echo AspisCheckPrint(concat2(concat1('<p><h3>',__(array('Import Complete!',false))),'</h3></p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('OK, so we lied about this being a 4-step program! You&#8217;re done!',false))),'</p>'));
echo AspisCheckPrint(concat2(concat1('<p>',__(array('Now wasn&#8217;t that easy?',false))),'</p>'));
echo AspisCheckPrint(array('</div>',false));
} }
function STP_Import (  ) {
{} }
}$stp_import = array(new STP_Import(),false);
register_importer(array('stp',false),array('Simple Tagging',false),__(array('Import Simple Tagging tags into WordPress tags.',false)),array(array($stp_import,array('dispatch',false)),false));
;
?>
<?php 