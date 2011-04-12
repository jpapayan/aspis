<?php require_once('AspisMain.php'); ?><?php
class STP_Import{function header (  ) {
{echo '<div class="wrap">';
screen_icon();
echo '<h2>' . __('Import Simple Tagging') . '</h2>';
echo '<p>' . __('Steps may take a few minutes depending on the size of your database. Please be patient.') . '<br /><br /></p>';
} }
function footer (  ) {
{echo '</div>';
} }
function greet (  ) {
{echo '<div class="narrow">';
echo '<p>' . __('Howdy! This imports tags from Simple Tagging 1.6.2 into WordPress tags.') . '</p>';
echo '<p>' . __('This has not been tested on any other versions of Simple Tagging. Mileage may vary.') . '</p>';
echo '<p>' . __('To accommodate larger databases for those tag-crazy authors out there, we have made this into an easy 4-step program to help you kick that nasty Simple Tagging habit. Just keep clicking along and we will let you know when you are in the clear!') . '</p>';
echo '<p><strong>' . __('Don&#8217;t be stupid - backup your database before proceeding!') . '</strong></p>';
echo '<form action="admin.php?import=stp&amp;step=1" method="post">';
wp_nonce_field('import-stp');
echo '<p class="submit"><input type="submit" name="submit" class="button" value="' . esc_attr__('Step 1') . '" /></p>';
echo '</form>';
echo '</div>';
} }
function dispatch (  ) {
{if ( (empty($_GET[0]['step']) || Aspis_empty($_GET[0]['step'])))
 {$step = 0;
}else 
{{$step = (int)deAspisWarningRC($_GET[0]['step']);
}}$this->header();
switch ( $step ) {
case 0:$this->greet();
break ;
case 1:check_admin_referer('import-stp');
$this->import_posts();
break ;
case 2:check_admin_referer('import-stp');
$this->import_t2p();
break ;
case 3:check_admin_referer('import-stp');
$this->cleanup_import();
break ;
 }
$this->footer();
} }
function import_posts (  ) {
{echo '<div class="narrow">';
echo '<p><h3>' . __('Reading STP Post Tags&#8230;') . '</h3></p>';
$posts = $this->get_stp_posts();
if ( !is_array($posts))
 {echo '<p>' . __('No posts were found to have tags!') . '</p>';
{$AspisRetTemp = false;
return $AspisRetTemp;
}}else 
{{if ( get_option('stpimp_posts'))
 {delete_option('stpimp_posts');
}add_option('stpimp_posts',$posts);
$count = count($posts);
echo '<p>' . sprintf(_n('Done! <strong>%s</strong> tag to post relationships were read.','Done! <strong>%s</strong> tags to post relationships were read.',$count),$count) . '<br /></p>';
}}echo '<form action="admin.php?import=stp&amp;step=2" method="post">';
wp_nonce_field('import-stp');
echo '<p class="submit"><input type="submit" name="submit" class="button" value="' . esc_attr__('Step 2') . '" /></p>';
echo '</form>';
echo '</div>';
} }
function import_t2p (  ) {
{echo '<div class="narrow">';
echo '<p><h3>' . __('Adding Tags to Posts&#8230;') . '</h3></p>';
$tags_added = $this->tag2post();
echo '<p>' . sprintf(_n('Done! <strong>%s</strong> tag was added!','Done! <strong>%s</strong> tags were added!',$tags_added),$tags_added) . '<br /></p>';
echo '<form action="admin.php?import=stp&amp;step=3" method="post">';
wp_nonce_field('import-stp');
echo '<p class="submit"><input type="submit" name="submit" class="button" value="' . esc_attr__('Step 3') . '" /></p>';
echo '</form>';
echo '</div>';
} }
function get_stp_posts (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$posts_query = "SELECT post_id, tag_name FROM " . $wpdb->prefix . "stp_tags";
$posts = $wpdb->get_results($posts_query);
{$AspisRetTemp = $posts;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function tag2post (  ) {
{{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$posts = get_option('stpimp_posts');
$tags_added = 0;
foreach ( $posts as $this_post  )
{$the_post = (int)$this_post->post_id;
$the_tag = AspisReferenceMethodCall($wpdb,"escape",array(AspisPushRefParam($this_post->tag_name)),array(0));
wp_add_post_tags($the_post,$the_tag);
$tags_added++;
}{$AspisRetTemp = $tags_added;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
function cleanup_import (  ) {
{delete_option('stpimp_posts');
$this->done();
} }
function done (  ) {
{echo '<div class="narrow">';
echo '<p><h3>' . __('Import Complete!') . '</h3></p>';
echo '<p>' . __('OK, so we lied about this being a 4-step program! You&#8217;re done!') . '</p>';
echo '<p>' . __('Now wasn&#8217;t that easy?') . '</p>';
echo '</div>';
} }
function STP_Import (  ) {
{} }
}$stp_import = new STP_Import();
register_importer('stp','Simple Tagging',__('Import Simple Tagging tags into WordPress tags.'),array($stp_import,'dispatch'));
;
?>
<?php 