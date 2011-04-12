<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('Writing Settings',false));
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

<form method="post" action="options.php">
<?php settings_fields(array('writing',false));
;
?>

<table class="form-table">
<tr valign="top">
<th scope="row"><label for="default_post_edit_rows"> <?php _e(array('Size of the post box',false));
?></label></th>
<td><input name="default_post_edit_rows" type="text" id="default_post_edit_rows" value="<?php form_option(array('default_post_edit_rows',false));
;
?>" class="small-text" />
<?php _e(array('lines',false));
?></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('Formatting',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Formatting',false));
?></span></legend>
<label for="use_smilies">
<input name="use_smilies" type="checkbox" id="use_smilies" value="1" <?php checked(array('1',false),get_option(array('use_smilies',false)));
;
?> />
<?php _e(array('Convert emoticons like <code>:-)</code> and <code>:-P</code> to graphics on display',false));
?></label><br />
<label for="use_balanceTags"><input name="use_balanceTags" type="checkbox" id="use_balanceTags" value="1" <?php checked(array('1',false),get_option(array('use_balanceTags',false)));
;
?> /> <?php _e(array('WordPress should correct invalidly nested XHTML automatically',false));
?></label>
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><label for="default_category"><?php _e(array('Default Post Category',false));
?></label></th>
<td>
<?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('default_category',false,false),'orderby' => array('name',false,false),deregisterTaint(array('selected',false)) => addTaint(get_option(array('default_category',false))),'hierarchical' => array(true,false,false)),false));
;
?>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="default_link_category"><?php _e(array('Default Link Category',false));
?></label></th>
<td>
<?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('default_link_category',false,false),'orderby' => array('name',false,false),deregisterTaint(array('selected',false)) => addTaint(get_option(array('default_link_category',false))),'hierarchical' => array(true,false,false),'type' => array('link',false,false)),false));
;
?>
</td>
</tr>
<?php do_settings_fields(array('writing',false),array('default',false));
;
?>
</table>

<h3><?php _e(array('Remote Publishing',false));
?></h3>
<p><?php printf(deAspis(__(array('To post to WordPress from a desktop blogging client or remote website that uses the Atom Publishing Protocol or one of the XML-RPC publishing interfaces you must enable them below.',false))));
?></p>
<table class="form-table">
<tr valign="top">
<th scope="row"><?php _e(array('Atom Publishing Protocol',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('Atom Publishing Protocol',false));
?></span></legend>
<label for="enable_app">
<input name="enable_app" type="checkbox" id="enable_app" value="1" <?php checked(array('1',false),get_option(array('enable_app',false)));
;
?> />
<?php _e(array('Enable the Atom Publishing Protocol.',false));
?></label><br />
</fieldset></td>
</tr>
<tr valign="top">
<th scope="row"><?php _e(array('XML-RPC',false));
?></th>
<td><fieldset><legend class="screen-reader-text"><span><?php _e(array('XML-RPC',false));
?></span></legend>
<label for="enable_xmlrpc">
<input name="enable_xmlrpc" type="checkbox" id="enable_xmlrpc" value="1" <?php checked(array('1',false),get_option(array('enable_xmlrpc',false)));
;
?> />
<?php _e(array('Enable the WordPress, Movable Type, MetaWeblog and Blogger XML-RPC publishing protocols.',false));
?></label><br />
</fieldset></td>
</tr>
<?php do_settings_fields(array('writing',false),array('remote_publishing',false));
;
?>
</table>

<h3><?php _e(array('Post via e-mail',false));
?></h3>
<p><?php printf(deAspis(__(array('To post to WordPress by e-mail you must set up a secret e-mail account with POP3 access. Any mail received at this address will be posted, so it&#8217;s a good idea to keep this address very secret. Here are three random strings you could use: <kbd>%s</kbd>, <kbd>%s</kbd>, <kbd>%s</kbd>.',false))),deAspisRC(wp_generate_password(array(8,false),array(false,false))),deAspisRC(wp_generate_password(array(8,false),array(false,false))),deAspisRC(wp_generate_password(array(8,false),array(false,false))));
?></p>

<table class="form-table">
<tr valign="top">
<th scope="row"><label for="mailserver_url"><?php _e(array('Mail Server',false));
?></label></th>
<td><input name="mailserver_url" type="text" id="mailserver_url" value="<?php form_option(array('mailserver_url',false));
;
?>" class="regular-text code" />
<label for="mailserver_port"><?php _e(array('Port',false));
?></label>
<input name="mailserver_port" type="text" id="mailserver_port" value="<?php form_option(array('mailserver_port',false));
;
?>" class="small-text" />
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="mailserver_login"><?php _e(array('Login Name',false));
?></label></th>
<td><input name="mailserver_login" type="text" id="mailserver_login" value="<?php form_option(array('mailserver_login',false));
;
?>" class="regular-text" /></td>
</tr>
<tr valign="top">
<th scope="row"><label for="mailserver_pass"><?php _e(array('Password',false));
?></label></th>
<td>
<input name="mailserver_pass" type="text" id="mailserver_pass" value="<?php form_option(array('mailserver_pass',false));
;
?>" class="regular-text" />
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="default_email_category"><?php _e(array('Default Mail Category',false));
?></label></th>
<td>
<?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('default_email_category',false,false),'orderby' => array('name',false,false),deregisterTaint(array('selected',false)) => addTaint(get_option(array('default_email_category',false))),'hierarchical' => array(true,false,false)),false));
;
?>
</td>
</tr>
<?php do_settings_fields(array('writing',false),array('post_via_email',false));
;
?>
</table>

<h3><?php _e(array('Update Services',false));
?></h3>

<?php if ( deAspis(get_option(array('blog_public',false))))
 {;
?>

<p><label for="ping_sites"><?php _e(array('When you publish a new post, WordPress automatically notifies the following site update services. For more about this, see <a href="http://codex.wordpress.org/Update_Services">Update Services</a> on the Codex. Separate multiple service <abbr title="Universal Resource Locator">URL</abbr>s with line breaks.',false));
?></label></p>

<textarea name="ping_sites" id="ping_sites" class="large-text code" rows="3"><?php form_option(array('ping_sites',false));
;
?></textarea>

<?php }else 
{;
?>

	<p><?php printf(deAspis(__(array('WordPress is not notifying any <a href="http://codex.wordpress.org/Update_Services">Update Services</a> because of your blog&#8217;s <a href="%s">privacy settings</a>.',false))),'options-privacy.php');
;
?></p>

<?php };
?>

<?php do_settings_sections(array('writing',false));
;
?>

<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e(array('Save Changes',false));
?>" />
</p>
</form>
</div>

<?php include ('./admin-footer.php');
?>
<?php 