<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('Reading Settings',false));
$parent_file = array('options-general.php',false);
include ('admin-header.php');
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form name="form1" method="post" action="options.php">
<?php settings_fields(array('reading',false));
;
?>

<table class="form-table">
<?php if ( deAspis(get_pages()))
 {;
?>
<tr valign="top">
<th scope="row"><?php _e(array('Front page displays',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Front page displays',false));
?></span></legend>
	<p><label>
		<input name="show_on_front" type="radio" value="posts" class="tog" <?php checked(array('posts',false),get_option(array('show_on_front',false)));
;
?> />
		<?php _e(array('Your latest posts',false));
;
?>
	</label>
	</p>
	<p><label>
		<input name="show_on_front" type="radio" value="page" class="tog" <?php checked(array('page',false),get_option(array('show_on_front',false)));
;
?> />
		<?php printf(deAspis(__(array('A <a href="%s">static page</a> (select below)',false))),'edit-pages.php');
;
?>
	</label>
	</p>
<ul>
	<li><?php printf((deconcat2(concat1("<label for='page_on_front'>",__(array('Front page: %s',false))),"</label>")),deAspisRC(wp_dropdown_pages(concat(concat2(concat1("name=page_on_front&echo=0&show_option_none=",__(array('- Select -',false))),"&selected="),get_option(array('page_on_front',false))))));
;
?></li>
	<li><?php printf((deconcat2(concat1("<label for='page_for_posts'>",__(array('Posts page: %s',false))),"</label>")),deAspisRC(wp_dropdown_pages(concat(concat2(concat1("name=page_for_posts&echo=0&show_option_none=",__(array('- Select -',false))),"&selected="),get_option(array('page_for_posts',false))))));
;
?></li>
</ul>
<?php if ( ((('page') == deAspis(get_option(array('show_on_front',false)))) && (deAspis(get_option(array('page_for_posts',false))) == deAspis(get_option(array('page_on_front',false))))))
 {;
?>
<div id="front-page-warning" class="updated fade-ff0000">
	<p>
		<?php _e(array('<strong>Warning:</strong> these pages should not be the same!',false));
;
?>
	</p>
</div>
<?php };
?>
</fieldset></td>
</tr>
<?php };
?>
<tr valign="top">
<th scope="row"><label for="posts_per_page"><?php _e(array('Blog pages show at most',false));
?></label></th>
<td>
<input name="posts_per_page" type="text" id="posts_per_page" value="<?php form_option(array('posts_per_page',false));
;
?>" class="small-text" /> <?php _e(array('posts',false));
?>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="posts_per_rss"><?php _e(array('Syndication feeds show the most recent',false));
?></label></th>
<td><input name="posts_per_rss" type="text" id="posts_per_rss" value="<?php form_option(array('posts_per_rss',false));
;
?>" class="small-text" /> <?php _e(array('posts',false));
?></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('For each article in a feed, show',false));
?> </th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('For each article in a feed, show',false));
?> </span></legend>
<p><label><input name="rss_use_excerpt"  type="radio" value="0" <?php checked(array(0,false),get_option(array('rss_use_excerpt',false)));
;
?>	/> <?php _e(array('Full text',false));
?></label><br />
<label><input name="rss_use_excerpt" type="radio" value="1" <?php checked(array(1,false),get_option(array('rss_use_excerpt',false)));
;
?> /> <?php _e(array('Summary',false));
?></label></p>
</fieldset></td>
</tr>

<tr valign="top">
<th scope="row"><label for="blog_charset"><?php _e(array('Encoding for pages and feeds',false));
?></label></th>
<td><input name="blog_charset" type="text" id="blog_charset" value="<?php form_option(array('blog_charset',false));
;
?>" class="regular-text" />
<span class="description"><?php _e(array('The <a href="http://codex.wordpress.org/Glossary#Character_set">character encoding</a> of your blog (UTF-8 is recommended, if you are adventurous there are some <a href="http://en.wikipedia.org/wiki/Character_set">other encodings</a>)',false));
?></span></td>
</tr>
<?php do_settings_fields(array('reading',false),array('default',false));
;
?>
</table>

<?php do_settings_sections(array('reading',false));
;
?>

<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e(array('Save Changes',false));
?>" />
</p>
</form>
</div>
<?php include ('./admin-footer.php');
;
?>
<?php 