<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('manage_options',false)))))
 wp_die(__(array('You do not have sufficient permissions to manage options for this blog.',false)));
$title = __(array('Permalink Settings',false));
$parent_file = array('options-general.php',false);
function add_js (  ) {
;
?>
<script type="text/javascript">
//<![CDATA[
function GetElementsWithClassName(elementName, className) {
var allElements = document.getElementsByTagName(elementName);
var elemColl = new Array();
for (i = 0; i < allElements.length; i++) {
if (allElements[i].className == className) {
elemColl[elemColl.length] = allElements[i];
}
}
return elemColl;
}

function upit() {
var inputColl = GetElementsWithClassName('input', 'tog');
var structure = document.getElementById('permalink_structure');
var inputs = '';
for (i = 0; i < inputColl.length; i++) {
if ( inputColl[i].checked && inputColl[i].value != '') {
inputs += inputColl[i].value + ' ';
}
}
inputs = inputs.substr(0,inputs.length - 1);
if ( 'custom' != inputs )
structure.value = inputs;
}

function blurry() {
if (!document.getElementById) return;

var structure = document.getElementById('permalink_structure');
structure.onfocus = function () { document.getElementById('custom_selection').checked = 'checked'; }

var aInputs = document.getElementsByTagName('input');

for (var i = 0; i < aInputs.length; i++) {
aInputs[i].onclick = aInputs[i].onkeyup = upit;
}
}

window.onload = blurry;
//]]>
</script>
<?php  }
add_filter(array('admin_head',false),array('add_js',false));
include ('admin-header.php');
$home_path = get_home_path();
$iis7_permalinks = iis7_supports_permalinks();
if ( (((isset($_POST[0][('permalink_structure')]) && Aspis_isset( $_POST [0][('permalink_structure')]))) || ((isset($_POST[0][('category_base')]) && Aspis_isset( $_POST [0][('category_base')])))))
 {check_admin_referer(array('update-permalink',false));
if ( ((isset($_POST[0][('permalink_structure')]) && Aspis_isset( $_POST [0][('permalink_structure')]))))
 {$permalink_structure = $_POST[0]['permalink_structure'];
if ( (!((empty($permalink_structure) || Aspis_empty( $permalink_structure)))))
 $permalink_structure = Aspis_preg_replace(array('#/+#',false),array('/',false),concat1('/',$_POST[0]['permalink_structure']));
$wp_rewrite[0]->set_permalink_structure($permalink_structure);
}if ( ((isset($_POST[0][('category_base')]) && Aspis_isset( $_POST [0][('category_base')]))))
 {$category_base = $_POST[0]['category_base'];
if ( (!((empty($category_base) || Aspis_empty( $category_base)))))
 $category_base = Aspis_preg_replace(array('#/+#',false),array('/',false),concat1('/',$_POST[0]['category_base']));
$wp_rewrite[0]->set_category_base($category_base);
}if ( ((isset($_POST[0][('tag_base')]) && Aspis_isset( $_POST [0][('tag_base')]))))
 {$tag_base = $_POST[0]['tag_base'];
if ( (!((empty($tag_base) || Aspis_empty( $tag_base)))))
 $tag_base = Aspis_preg_replace(array('#/+#',false),array('/',false),concat1('/',$_POST[0]['tag_base']));
$wp_rewrite[0]->set_tag_base($tag_base);
}}$permalink_structure = get_option(array('permalink_structure',false));
$category_base = get_option(array('category_base',false));
$tag_base = get_option(array('tag_base',false));
if ( $iis7_permalinks[0])
 {if ( (((!(file_exists((deconcat2($home_path,'web.config'))))) && deAspis(win_is_writable($home_path))) || deAspis(win_is_writable(concat2($home_path,'web.config')))))
 $writable = array(true,false);
else 
{$writable = array(false,false);
}}else 
{{if ( (((!(file_exists((deconcat2($home_path,'.htaccess'))))) && is_writable($home_path[0])) || is_writable((deconcat2($home_path,'.htaccess')))))
 $writable = array(true,false);
else 
{$writable = array(false,false);
}}}if ( deAspis($wp_rewrite[0]->using_index_permalinks()))
 $usingpi = array(true,false);
else 
{$usingpi = array(false,false);
}$wp_rewrite[0]->flush_rules();
;
?>

<?php if ( ((isset($_POST[0][('submit')]) && Aspis_isset( $_POST [0][('submit')]))))
 {;
?>
<div id="message" class="updated fade"><p><?php if ( $iis7_permalinks[0])
 {if ( (($permalink_structure[0] && (denot_boolean($usingpi))) && (denot_boolean($writable))))
 _e(array('You should update your web.config now',false));
else 
{if ( (($permalink_structure[0] && (denot_boolean($usingpi))) && $writable[0]))
 _e(array('Permalink structure updated. Remove write access on web.config file now!',false));
else 
{_e(array('Permalink structure updated',false));
}}}else 
{{if ( (($permalink_structure[0] && (denot_boolean($usingpi))) && (denot_boolean($writable))))
 _e(array('You should update your .htaccess now.',false));
else 
{_e(array('Permalink structure updated.',false));
}}};
?>
</p></div>
<?php };
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<form name="form" action="options-permalink.php" method="post">
<?php wp_nonce_field(array('update-permalink',false));
;
?>

  <p><?php _e(array('By default WordPress uses web <abbr title="Universal Resource Locator">URL</abbr>s which have question marks and lots of numbers in them, however WordPress offers you the ability to create a custom URL structure for your permalinks and archives. This can improve the aesthetics, usability, and forward-compatibility of your links. A <a href="http://codex.wordpress.org/Using_Permalinks">number of tags are available</a>, and here are some examples to get you started.',false));
;
?></p>

<?php $prefix = array('',false);
if ( ((denot_boolean(got_mod_rewrite())) && (denot_boolean($iis7_permalinks))))
 $prefix = array('/index.php',false);
$structures = array(array(array('',false),concat2($prefix,'/%year%/%monthnum%/%day%/%postname%/'),concat2($prefix,'/%year%/%monthnum%/%postname%/'),concat2($prefix,'/archives/%post_id%')),false);
;
?>
<h3><?php _e(array('Common settings',false));
;
?></h3>
<table class="form-table">
	<tr>
		<th><label><input name="selection" type="radio" value="" class="tog" <?php checked(array('',false),$permalink_structure);
;
?> /> <?php _e(array('Default',false));
;
?></label></th>
		<td><code><?php echo AspisCheckPrint(get_option(array('home',false)));
;
?>/?p=123</code></td>
	</tr>
	<tr>
		<th><label><input name="selection" type="radio" value="<?php echo AspisCheckPrint(esc_attr(attachAspis($structures,(1))));
;
?>" class="tog" <?php checked(attachAspis($structures,(1)),$permalink_structure);
;
?> /> <?php _e(array('Day and name',false));
;
?></label></th>
		<td><code><?php echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(concat2(concat(get_option(array('home',false)),$prefix),'/'),attAspis(date(('Y')))),'/'),attAspis(date(('m')))),'/'),attAspis(date(('d')))),'/sample-post/'));
;
?></code></td>
	</tr>
	<tr>
		<th><label><input name="selection" type="radio" value="<?php echo AspisCheckPrint(esc_attr(attachAspis($structures,(2))));
;
?>" class="tog" <?php checked(attachAspis($structures,(2)),$permalink_structure);
;
?> /> <?php _e(array('Month and name',false));
;
?></label></th>
		<td><code><?php echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat(get_option(array('home',false)),$prefix),'/'),attAspis(date(('Y')))),'/'),attAspis(date(('m')))),'/sample-post/'));
;
?></code></td>
	</tr>
	<tr>
		<th><label><input name="selection" type="radio" value="<?php echo AspisCheckPrint(esc_attr(attachAspis($structures,(3))));
;
?>" class="tog" <?php checked(attachAspis($structures,(3)),$permalink_structure);
;
?> /> <?php _e(array('Numeric',false));
;
?></label></th>
		<td><code><?php echo AspisCheckPrint(concat(get_option(array('home',false)),$prefix));
;
?>/archives/123</code></td>
	</tr>
	<tr>
		<th>
			<label><input name="selection" id="custom_selection" type="radio" value="custom" class="tog"
			<?php if ( (denot_boolean(Aspis_in_array($permalink_structure,$structures))))
 {;
?>
			checked="checked"
			<?php };
?>
			 />
			<?php _e(array('Custom Structure',false));
;
?>
			</label>
		</th>
		<td>
			<input name="permalink_structure" id="permalink_structure" type="text" value="<?php echo AspisCheckPrint(esc_attr($permalink_structure));
;
?>" class="regular-text code" />
		</td>
	</tr>
</table>

<h3><?php _e(array('Optional',false));
;
?></h3>
<?php if ( ($is_apache[0] || $iis7_permalinks[0]))
 {;
?>
	<p><?php _e(array('If you like, you may enter custom structures for your category and tag <abbr title="Universal Resource Locator">URL</abbr>s here. For example, using <kbd>topics</kbd> as your category base would make your category links like <code>http://example.org/topics/uncategorized/</code>. If you leave these blank the defaults will be used.',false));
;
?></p>
<?php }else 
{;
?>
	<p><?php _e(array('If you like, you may enter custom structures for your category and tag <abbr title="Universal Resource Locator">URL</abbr>s here. For example, using <code>topics</code> as your category base would make your category links like <code>http://example.org/index.php/topics/uncategorized/</code>. If you leave these blank the defaults will be used.',false));
;
?></p>
<?php };
?>

<table class="form-table">
	<tr>
		<th><label for="category_base"><?php _e(array('Category base',false));
;
?></label></th>
		<td><input name="category_base" id="category_base" type="text" value="<?php echo AspisCheckPrint(esc_attr($category_base));
;
?>" class="regular-text code" /></td>
	</tr>
	<tr>
		<th><label for="tag_base"><?php _e(array('Tag base',false));
;
?></label></th>
		<td><input name="tag_base" id="tag_base" type="text" value="<?php echo AspisCheckPrint(esc_attr($tag_base));
;
?>" class="regular-text code" /></td>
	</tr>
	<?php do_settings_fields(array('permalink',false),array('optional',false));
;
?>
</table>

<?php do_settings_sections(array('permalink',false));
;
?>

<p class="submit">
	<input type="submit" name="submit" class="button-primary" value="<?php esc_attr_e(array('Save Changes',false));
;
?>" />
</p>
  </form>
<?php if ( $iis7_permalinks[0])
 {if ( (((((isset($_POST[0][('submit')]) && Aspis_isset( $_POST [0][('submit')]))) && $permalink_structure[0]) && (denot_boolean($usingpi))) && (denot_boolean($writable))))
 {if ( file_exists((deconcat2($home_path,'web.config'))))
 {;
?>
<p><?php _e(array('If your <code>web.config</code> file were <a href="http://codex.wordpress.org/Changing_File_Permissions">writable</a>, we could do this automatically, but it isn&#8217;t so this is the url rewrite rule you should have in your <code>web.config</code> file. Click in the field and press <kbd>CTRL + a</kbd> to select all. Then insert this rule inside of the <code>/&lt;configuration&gt;/&lt;system.webServer&gt;/&lt;rewrite&gt;/&lt;rules&gt;</code> element in <code>web.config</code> file.',false));
;
?></p>
<form action="options-permalink.php" method="post">
<?php wp_nonce_field(array('update-permalink',false));
;
?>
	<p><textarea rows="9" class="large-text readonly" name="rules" id="rules" readonly="readonly"><?php echo AspisCheckPrint(esc_html($wp_rewrite[0]->iis7_url_rewrite_rules()));
;
?></textarea></p>
</form>
<p><?php _e(array('If you temporarily make your <code>web.config</code> file writable for us to generate rewrite rules automatically, do not forget to revert the permissions after rule has been saved.',false));
;
?></p>
		<?php }else 
{;
?>
<p><?php _e(array('If the root directory of your site were <a href="http://codex.wordpress.org/Changing_File_Permissions">writable</a>, we could do this automatically, but it isn&#8217;t so this is the url rewrite rule you should have in your <code>web.config</code> file. Create a new file, called <code>web.config</code> in the root directory of your site. Click in the field and press <kbd>CTRL + a</kbd> to select all. Then insert this code into the <code>web.config</code> file.',false));
;
?></p>
<form action="options-permalink.php" method="post">
<?php wp_nonce_field(array('update-permalink',false));
;
?>
	<p><textarea rows="18" class="large-text readonly" name="rules" id="rules" readonly="readonly"><?php echo AspisCheckPrint(esc_html($wp_rewrite[0]->iis7_url_rewrite_rules(array(true,false))));
;
?></textarea></p>
</form>
<p><?php _e(array('If you temporarily make your site&#8217;s root directory writable for us to generate the <code>web.config</code> file automatically, do not forget to revert the permissions after the file has been created.',false));
;
?></p>
		<?php };
?>
	<?php };
?>
<?php }else 
{if ( (($permalink_structure[0] && (denot_boolean($usingpi))) && (denot_boolean($writable))))
 {;
?>
<p><?php _e(array('If your <code>.htaccess</code> file were <a href="http://codex.wordpress.org/Changing_File_Permissions">writable</a>, we could do this automatically, but it isn&#8217;t so these are the mod_rewrite rules you should have in your <code>.htaccess</code> file. Click in the field and press <kbd>CTRL + a</kbd> to select all.',false));
;
?></p>
<form action="options-permalink.php" method="post">
<?php wp_nonce_field(array('update-permalink',false));
;
?>
	<p><textarea rows="6" class="large-text readonly" name="rules" id="rules" readonly="readonly"><?php echo AspisCheckPrint(esc_html($wp_rewrite[0]->mod_rewrite_rules()));
;
?></textarea></p>
</form>
	<?php };
?>
<?php };
?>

</div>

<?php require ('./admin-footer.php');
;
?>
<?php 