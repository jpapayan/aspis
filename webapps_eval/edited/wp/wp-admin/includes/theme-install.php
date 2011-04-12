<?php require_once('AspisMain.php'); ?><?php
$themes_allowedtags = array(array('a' => array(array('href' => array(array(),false,false),'title' => array(array(),false,false),'target' => array(array(),false,false)),false,false),'abbr' => array(array('title' => array(array(),false,false)),false,false),'acronym' => array(array('title' => array(array(),false,false)),false,false),'code' => array(array(),false,false),'pre' => array(array(),false,false),'em' => array(array(),false,false),'strong' => array(array(),false,false),'div' => array(array(),false,false),'p' => array(array(),false,false),'ul' => array(array(),false,false),'ol' => array(array(),false,false),'li' => array(array(),false,false),'h1' => array(array(),false,false),'h2' => array(array(),false,false),'h3' => array(array(),false,false),'h4' => array(array(),false,false),'h5' => array(array(),false,false),'h6' => array(array(),false,false),'img' => array(array('src' => array(array(),false,false),'class' => array(array(),false,false),'alt' => array(array(),false,false)),false,false)),false);
$theme_field_defaults = array(array('description' => array(true,false,false),'sections' => array(false,false,false),'tested' => array(true,false,false),'requires' => array(true,false,false),'rating' => array(true,false,false),'downloaded' => array(true,false,false),'downloadlink' => array(true,false,false),'last_updated' => array(true,false,false),'homepage' => array(true,false,false),'tags' => array(true,false,false),'num_ratings' => array(true,false,false)),false);
function themes_api ( $action,$args = array(null,false) ) {
if ( is_array($args[0]))
 $args = object_cast($args);
if ( (!((isset($args[0]->per_page) && Aspis_isset( $args[0] ->per_page )))))
 $args[0]->per_page = array(24,false);
$args = apply_filters(array('themes_api_args',false),$args,$action);
$res = apply_filters(array('themes_api',false),array(false,false),$action,$args);
if ( (denot_boolean($res)))
 {$request = wp_remote_post(array('http://api.wordpress.org/themes/info/1.0/',false),array(array('body' => array(array(deregisterTaint(array('action',false)) => addTaint($action),deregisterTaint(array('request',false)) => addTaint(Aspis_serialize($args))),false,false)),false));
if ( deAspis(is_wp_error($request)))
 {$res = array(new WP_Error(array('themes_api_failed',false),__(array('An Unexpected HTTP Error occured during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>',false)),$request[0]->get_error_message()),false);
}else 
{{$res = Aspis_unserialize($request[0]['body']);
if ( (denot_boolean($res)))
 $res = array(new WP_Error(array('themes_api_failed',false),__(array('An unknown error occured',false)),$request[0]['body']),false);
}}}return apply_filters(array('themes_api_result',false),$res,$action,$args);
 }
function install_themes_feature_list (  ) {
if ( (denot_boolean($cache = get_transient(array('wporg_theme_feature_list',false)))))
 set_transient(array('wporg_theme_feature_list',false),array(array(),false),array(10800,false));
if ( $cache[0])
 return $cache;
$feature_list = themes_api(array('feature_list',false),array(array(),false));
if ( deAspis(is_wp_error($feature_list)))
 return $features;
set_transient(array('wporg_theme_feature_list',false),$feature_list,array(10800,false));
return $feature_list;
 }
add_action(array('install_themes_search',false),array('install_theme_search',false),array(10,false),array(1,false));
function install_theme_search ( $page ) {
global $theme_field_defaults;
$type = ((isset($_REQUEST[0][('type')]) && Aspis_isset( $_REQUEST [0][('type')]))) ? Aspis_stripslashes($_REQUEST[0]['type']) : array('',false);
$term = ((isset($_REQUEST[0][('s')]) && Aspis_isset( $_REQUEST [0][('s')]))) ? Aspis_stripslashes($_REQUEST[0]['s']) : array('',false);
$args = array(array(),false);
switch ( $type[0] ) {
case ('tag'):$terms = Aspis_explode(array(',',false),$term);
$terms = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC($terms)));
$terms = attAspisRC(array_map(AspisInternalCallback(array('sanitize_title_with_dashes',false)),deAspisRC($terms)));
arrayAssign($args[0],deAspis(registerTaint(array('tag',false))),addTaint($terms));
break ;
case ('term'):arrayAssign($args[0],deAspis(registerTaint(array('search',false))),addTaint($term));
break ;
case ('author'):arrayAssign($args[0],deAspis(registerTaint(array('author',false))),addTaint($term));
break ;
 }
arrayAssign($args[0],deAspis(registerTaint(array('page',false))),addTaint($page));
arrayAssign($args[0],deAspis(registerTaint(array('fields',false))),addTaint($theme_field_defaults));
if ( (!((empty($_POST[0][('features')]) || Aspis_empty( $_POST [0][('features')])))))
 {$terms = $_POST[0]['features'];
$terms = attAspisRC(array_map(AspisInternalCallback(array('trim',false)),deAspisRC($terms)));
$terms = attAspisRC(array_map(AspisInternalCallback(array('sanitize_title_with_dashes',false)),deAspisRC($terms)));
arrayAssign($args[0],deAspis(registerTaint(array('tag',false))),addTaint($terms));
arrayAssign($_REQUEST[0],deAspis(registerTaint(array('s',false))),addTaint(Aspis_implode(array(',',false),$terms)));
arrayAssign($_REQUEST[0],deAspis(registerTaint(array('type',false))),addTaint(array('tag',false)));
}$api = themes_api(array('query_themes',false),$args);
if ( deAspis(is_wp_error($api)))
 wp_die($api);
add_action(array('install_themes_table_header',false),array('install_theme_search_form',false));
display_themes($api[0]->themes,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
function install_theme_search_form (  ) {
$type = ((isset($_REQUEST[0][('type')]) && Aspis_isset( $_REQUEST [0][('type')]))) ? Aspis_stripslashes($_REQUEST[0]['type']) : array('',false);
$term = ((isset($_REQUEST[0][('s')]) && Aspis_isset( $_REQUEST [0][('s')]))) ? Aspis_stripslashes($_REQUEST[0]['s']) : array('',false);
;
?>
<p class="install-help"><?php _e(array('Search for themes by keyword, author, or tag.',false));
?></p>

<form id="search-themes" method="post" action="<?php echo AspisCheckPrint(admin_url(array('theme-install.php?tab=search',false)));
;
?>">
	<select	name="type" id="typeselector">
	<option value="term" <?php selected(array('term',false),$type);
?>><?php _e(array('Term',false));
;
?></option>
	<option value="author" <?php selected(array('author',false),$type);
?>><?php _e(array('Author',false));
;
?></option>
	<option value="tag" <?php selected(array('tag',false),$type);
?>><?php echo AspisCheckPrint(_x(array('Tag',false),array('Theme Installer',false)));
;
?></option>
	</select>
	<input type="text" name="s" size="30" value="<?php echo AspisCheckPrint(esc_attr($term));
?>" />
	<input type="submit" name="search" value="<?php esc_attr_e(array('Search',false));
;
?>" class="button" />
</form>
<?php  }
add_action(array('install_themes_dashboard',false),array('install_themes_dashboard',false));
function install_themes_dashboard (  ) {
install_theme_search_form();
;
?>
<h4><?php _e(array('Feature Filter',false));
?></h4>
<form method="post" action="<?php echo AspisCheckPrint(admin_url(array('theme-install.php?tab=search',false)));
;
?>">
<p class="install-help"><?php _e(array('Find a theme based on specific features',false));
?></p>
	<?php $feature_list = install_themes_feature_list();
echo AspisCheckPrint(array('<div class="feature-filter">',false));
$trans = array(array(deregisterTaint(array('Colors',false)) => addTaint(__(array('Colors',false))),deregisterTaint(array('black',false)) => addTaint(__(array('Black',false))),deregisterTaint(array('blue',false)) => addTaint(__(array('Blue',false))),deregisterTaint(array('brown',false)) => addTaint(__(array('Brown',false))),deregisterTaint(array('green',false)) => addTaint(__(array('Green',false))),deregisterTaint(array('orange',false)) => addTaint(__(array('Orange',false))),deregisterTaint(array('pink',false)) => addTaint(__(array('Pink',false))),deregisterTaint(array('purple',false)) => addTaint(__(array('Purple',false))),deregisterTaint(array('red',false)) => addTaint(__(array('Red',false))),deregisterTaint(array('silver',false)) => addTaint(__(array('Silver',false))),deregisterTaint(array('tan',false)) => addTaint(__(array('Tan',false))),deregisterTaint(array('white',false)) => addTaint(__(array('White',false))),deregisterTaint(array('yellow',false)) => addTaint(__(array('Yellow',false))),deregisterTaint(array('dark',false)) => addTaint(__(array('Dark',false))),deregisterTaint(array('light',false)) => addTaint(__(array('Light',false))),deregisterTaint(array('Columns',false)) => addTaint(__(array('Columns',false))),deregisterTaint(array('one-column',false)) => addTaint(__(array('One Column',false))),deregisterTaint(array('two-columns',false)) => addTaint(__(array('Two Columns',false))),deregisterTaint(array('three-columns',false)) => addTaint(__(array('Three Columns',false))),deregisterTaint(array('four-columns',false)) => addTaint(__(array('Four Columns',false))),deregisterTaint(array('left-sidebar',false)) => addTaint(__(array('Left Sidebar',false))),deregisterTaint(array('right-sidebar',false)) => addTaint(__(array('Right Sidebar',false))),deregisterTaint(array('Width',false)) => addTaint(__(array('Width',false))),deregisterTaint(array('fixed-width',false)) => addTaint(__(array('Fixed Width',false))),deregisterTaint(array('flexible-width',false)) => addTaint(__(array('Flexible Width',false))),deregisterTaint(array('Features',false)) => addTaint(__(array('Features',false))),deregisterTaint(array('custom-colors',false)) => addTaint(__(array('Custom Colors',false))),deregisterTaint(array('custom-header',false)) => addTaint(__(array('Custom Header',false))),deregisterTaint(array('theme-options',false)) => addTaint(__(array('Theme Options',false))),deregisterTaint(array('threaded-comments',false)) => addTaint(__(array('Threaded Comments',false))),deregisterTaint(array('sticky-post',false)) => addTaint(__(array('Sticky Post',false))),deregisterTaint(array('microformats',false)) => addTaint(__(array('Microformats',false))),deregisterTaint(array('Subject',false)) => addTaint(__(array('Subject',false))),deregisterTaint(array('holiday',false)) => addTaint(__(array('Holiday',false))),deregisterTaint(array('photoblogging',false)) => addTaint(__(array('Photoblogging',false))),deregisterTaint(array('seasonal',false)) => addTaint(__(array('Seasonal',false))),),false);
foreach ( deAspis(array_cast($feature_list)) as $feature_name =>$features )
{restoreTaint($feature_name,$features);
{if ( ((isset($trans[0][$feature_name[0]]) && Aspis_isset( $trans [0][$feature_name[0]]))))
 $feature_name = attachAspis($trans,$feature_name[0]);
$feature_name = esc_html($feature_name);
echo AspisCheckPrint(concat2(concat1('<div class="feature-name">',$feature_name),'</div>'));
echo AspisCheckPrint(array('<ol style="float: left; width: 725px;" class="feature-group">',false));
foreach ( $features[0] as $feature  )
{$feature_name = $feature;
if ( ((isset($trans[0][$feature[0]]) && Aspis_isset( $trans [0][$feature[0]]))))
 $feature_name = attachAspis($trans,$feature[0]);
$feature_name = esc_html($feature_name);
$feature = esc_attr($feature);
;
?>

<li>
	<input type="checkbox" name="features[<?php echo AspisCheckPrint($feature);
;
?>]" id="feature-id-<?php echo AspisCheckPrint($feature);
;
?>" value="<?php echo AspisCheckPrint($feature);
;
?>" />
	<label for="feature-id-<?php echo AspisCheckPrint($feature);
;
?>"><?php echo AspisCheckPrint($feature_name);
;
?></label>
</li>

<?php };
?>
</ol>
<br class="clear" />
<?php }};
?>

</div>
<br class="clear" />
<p><input type="submit" name="search" value="<?php esc_attr_e(array('Find Themes',false));
;
?>" class="button" /></p>
</form>
<?php  }
add_action(array('install_themes_featured',false),array('install_themes_featured',false),array(10,false),array(1,false));
function install_themes_featured ( $page = array(1,false) ) {
global $theme_field_defaults;
$args = array(array('browse' => array('featured',false,false),deregisterTaint(array('page',false)) => addTaint($page),deregisterTaint(array('fields',false)) => addTaint($theme_field_defaults)),false);
$api = themes_api(array('query_themes',false),$args);
if ( deAspis(is_wp_error($api)))
 wp_die($api);
display_themes($api[0]->themes,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
add_action(array('install_themes_new',false),array('install_themes_new',false),array(10,false),array(1,false));
function install_themes_new ( $page = array(1,false) ) {
global $theme_field_defaults;
$args = array(array('browse' => array('new',false,false),deregisterTaint(array('page',false)) => addTaint($page),deregisterTaint(array('fields',false)) => addTaint($theme_field_defaults)),false);
$api = themes_api(array('query_themes',false),$args);
if ( deAspis(is_wp_error($api)))
 wp_die($api);
display_themes($api[0]->themes,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
add_action(array('install_themes_updated',false),array('install_themes_updated',false),array(10,false),array(1,false));
function install_themes_updated ( $page = array(1,false) ) {
global $theme_field_defaults;
$args = array(array('browse' => array('updated',false,false),deregisterTaint(array('page',false)) => addTaint($page),deregisterTaint(array('fields',false)) => addTaint($theme_field_defaults)),false);
$api = themes_api(array('query_themes',false),$args);
display_themes($api[0]->themes,$api[0]->info[0][('page')],$api[0]->info[0][('pages')]);
 }
add_action(array('install_themes_upload',false),array('install_themes_upload',false),array(10,false),array(1,false));
function install_themes_upload ( $page = array(1,false) ) {
;
?>
<h4><?php _e(array('Install a theme in .zip format',false));
?></h4>
<p class="install-help"><?php _e(array('If you have a theme in a .zip format, you may install it by uploading it here.',false));
?></p>
<form method="post" enctype="multipart/form-data" action="<?php echo AspisCheckPrint(admin_url(array('update.php?action=upload-theme',false)));
?>">
	<?php wp_nonce_field(array('theme-upload',false));
?>
	<input type="file" name="themezip" />
	<input type="submit"
	class="button" value="<?php esc_attr_e(array('Install Now',false));
?>" />
</form>
	<?php  }
function display_theme ( $theme,$actions = array(null,false),$show_details = array(true,false) ) {
global $themes_allowedtags;
if ( ((empty($theme) || Aspis_empty( $theme))))
 return ;
$name = wp_kses($theme[0]->name,$themes_allowedtags);
$desc = wp_kses($theme[0]->description,$themes_allowedtags);
$preview_link = concat2($theme[0]->preview_url,'?TB_iframe=true&amp;width=600&amp;height=400');
if ( (!(is_array($actions[0]))))
 {$actions = array(array(),false);
arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',admin_url(concat2(concat1('theme-install.php?tab=theme-information&amp;theme=',$theme[0]->slug),'&amp;TB_iframe=true&amp;tbWidth=500&amp;tbHeight=350'))),'" class="thickbox thickbox-preview onclick" title="'),esc_attr(Aspis_sprintf(__(array('Install &#8220;%s&#8221;',false)),$name))),'">'),__(array('Install',false))),'</a>')));
arrayAssignAdd($actions[0][],addTaint(concat2(concat(concat2(concat(concat2(concat1('<a href="',$preview_link),'" class="thickbox thickbox-preview onclick previewlink" title="'),esc_attr(Aspis_sprintf(__(array('Preview &#8220;%s&#8221;',false)),$name))),'">'),__(array('Preview',false))),'</a>')));
$actions = apply_filters(array('theme_install_action_links',false),$actions,$theme);
}$actions = Aspis_implode(array(' | ',false),$actions);
;
?>
<a class='thickbox thickbox-preview screenshot'
	href='<?php echo AspisCheckPrint(esc_url($preview_link));
;
?>'
	title='<?php echo AspisCheckPrint(esc_attr(Aspis_sprintf(__(array('Preview &#8220;%s&#8221;',false)),$name)));
;
?>'>
<img src='<?php echo AspisCheckPrint(esc_url($theme[0]->screenshot_url));
;
?>' width='150' />
</a>
<h3><?php echo AspisCheckPrint($name);
?></h3>
<span class='action-links'><?php echo AspisCheckPrint($actions);
?></span>
<p><?php echo AspisCheckPrint($desc);
?></p>
<?php if ( $show_details[0])
 {;
?>
<a href="#theme_detail" class="theme-detail hide-if-no-js" tabindex='4'><?php _e(array('Details',false));
?></a>
<div class="themedetaildiv hide-if-js">
<p><strong><?php _e(array('Version:',false));
?></strong> <?php echo AspisCheckPrint(wp_kses($theme[0]->version,$themes_allowedtags));
?></p>
<p><strong><?php _e(array('Author:',false));
?></strong> <?php echo AspisCheckPrint(wp_kses($theme[0]->author,$themes_allowedtags));
?></p>
<?php if ( (!((empty($theme[0]->last_updated) || Aspis_empty( $theme[0] ->last_updated )))))
 {;
?>
<p><strong><?php _e(array('Last Updated:',false));
?></strong> <span title="<?php echo AspisCheckPrint($theme[0]->last_updated);
?>"><?php printf(deAspis(__(array('%s ago',false))),deAspisRC(human_time_diff(attAspis(strtotime($theme[0]->last_updated[0])))));
?></span></p>
<?php }if ( (!((empty($theme[0]->requires) || Aspis_empty( $theme[0] ->requires )))))
 {;
?>
<p><strong><?php _e(array('Requires WordPress Version:',false));
?></strong> <?php printf(deAspis(__(array('%s or higher',false))),deAspisRC($theme[0]->requires));
?></p>
<?php }if ( (!((empty($theme[0]->tested) || Aspis_empty( $theme[0] ->tested )))))
 {;
?>
<p><strong><?php _e(array('Compatible up to:',false));
?></strong> <?php echo AspisCheckPrint($theme[0]->tested);
?></p>
<?php }if ( (!((empty($theme[0]->downloaded) || Aspis_empty( $theme[0] ->downloaded )))))
 {;
?>
<p><strong><?php _e(array('Downloaded:',false));
?></strong> <?php printf(deAspis(_n(array('%s time',false),array('%s times',false),$theme[0]->downloaded)),deAspisRC(number_format_i18n($theme[0]->downloaded)));
?></p>
<?php };
?>
<div class="star-holder" title="<?php printf(deAspis(_n(array('(based on %s rating)',false),array('(based on %s ratings)',false),$theme[0]->num_ratings)),deAspisRC(number_format_i18n($theme[0]->num_ratings)));
?>">
	<div class="star star-rating" style="width: <?php echo AspisCheckPrint(esc_attr($theme[0]->rating));
?>px"></div>
	<div class="star star5"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('5 stars',false));
?>" /></div>
	<div class="star star4"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('4 stars',false));
?>" /></div>
	<div class="star star3"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('3 stars',false));
?>" /></div>
	<div class="star star2"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('2 stars',false));
?>" /></div>
	<div class="star star1"><img src="<?php echo AspisCheckPrint(admin_url(array('images/star.gif',false)));
;
?>" alt="<?php _e(array('1 star',false));
?>" /></div>
</div>
</div>
<?php } }
function display_themes ( $themes,$page = array(1,false),$totalpages = array(1,false) ) {
global $themes_allowedtags;
$type = ((isset($_REQUEST[0][('type')]) && Aspis_isset( $_REQUEST [0][('type')]))) ? Aspis_stripslashes($_REQUEST[0]['type']) : array('',false);
$term = ((isset($_REQUEST[0][('s')]) && Aspis_isset( $_REQUEST [0][('s')]))) ? Aspis_stripslashes($_REQUEST[0]['s']) : array('',false);
;
?>
<div class="tablenav">
<div class="alignleft actions"><?php do_action(array('install_themes_table_header',false));
;
?></div>
	<?php $url = esc_url($_SERVER[0]['REQUEST_URI']);
if ( (!((empty($term) || Aspis_empty( $term)))))
 $url = add_query_arg(array('s',false),$term,$url);
if ( (!((empty($type) || Aspis_empty( $type)))))
 $url = add_query_arg(array('type',false),$type,$url);
$page_links = paginate_links(array(array(deregisterTaint(array('base',false)) => addTaint(add_query_arg(array('paged',false),array('%#%',false),$url)),'format' => array('',false,false),deregisterTaint(array('prev_text',false)) => addTaint(__(array('&laquo;',false))),deregisterTaint(array('next_text',false)) => addTaint(__(array('&raquo;',false))),deregisterTaint(array('total',false)) => addTaint($totalpages),deregisterTaint(array('current',false)) => addTaint($page)),false));
if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("\t\t<div class='tablenav-pages'>",$page_links),"</div>"));
;
?>
</div>
<br class="clear" />
<?php if ( ((empty($themes) || Aspis_empty( $themes))))
 {_e(array('No themes found',false));
return ;
};
?>
<table id="availablethemes" cellspacing="0" cellpadding="0">
<?php $rows = attAspis(ceil((count($themes[0]) / (3))));
$table = array(array(),false);
$theme_keys = attAspisRC(array_keys(deAspisRC($themes)));
for ( $row = array(1,false) ; ($row[0] <= $rows[0]) ; postincr($row) )
for ( $col = array(1,false) ; ($col[0] <= (3)) ; postincr($col) )
arrayAssign($table[0][$row[0]][0],deAspis(registerTaint($col)),addTaint(Aspis_array_shift($theme_keys)));
foreach ( $table[0] as $row =>$cols )
{restoreTaint($row,$cols);
{;
?>
	<tr>
	<?php foreach ( $cols[0] as $col =>$theme_index )
{restoreTaint($col,$theme_index);
{$class = array(array(array('available-theme',false)),false);
if ( ($row[0] == (1)))
 arrayAssignAdd($class[0][],addTaint(array('top',false)));
if ( ($col[0] == (1)))
 arrayAssignAdd($class[0][],addTaint(array('left',false)));
if ( ($row[0] == $rows[0]))
 arrayAssignAdd($class[0][],addTaint(array('bottom',false)));
if ( ($col[0] == (3)))
 arrayAssignAdd($class[0][],addTaint(array('right',false)));
;
?>
		<td class="<?php echo AspisCheckPrint(Aspis_join(array(' ',false),$class));
;
?>"><?php if ( ((isset($themes[0][$theme_index[0]]) && Aspis_isset( $themes [0][$theme_index[0]]))))
 display_theme(attachAspis($themes,$theme_index[0]));
;
?></td>
		<?php }};
?>
	</tr>
	<?php }};
?>
</table>

<div class="tablenav"><?php if ( $page_links[0])
 echo AspisCheckPrint(concat2(concat1("\t\t<div class='tablenav-pages'>",$page_links),"</div>"));
;
?> <br
	class="clear" />
</div>

<?php  }
add_action(array('install_themes_pre_theme-information',false),array('install_theme_information',false));
function install_theme_information (  ) {
global $tab,$themes_allowedtags;
$api = themes_api(array('theme_information',false),array(array(deregisterTaint(array('slug',false)) => addTaint(Aspis_stripslashes($_REQUEST[0]['theme']))),false));
if ( deAspis(is_wp_error($api)))
 wp_die($api);
foreach ( deAspis(array_cast($api[0]->sections)) as $section_name =>$content )
{restoreTaint($section_name,$content);
arrayAssign($api[0]->sections[0],deAspis(registerTaint($section_name)),addTaint(wp_kses($content,$themes_allowedtags)));
}foreach ( (array(array('version',false),array('author',false),array('requires',false),array('tested',false),array('homepage',false),array('downloaded',false),array('slug',false))) as $key  )
$api[0]->$key[0] = wp_kses($api[0]->$key[0],$themes_allowedtags);
iframe_header(__(array('Theme Install',false)));
if ( ((empty($api[0]->download_link) || Aspis_empty( $api[0] ->download_link ))))
 {echo AspisCheckPrint(concat2(concat1('<div id="message" class="error"><p>',__(array('<strong>Error:</strong> This theme is currently not available. Please try again later.',false))),'</p></div>'));
iframe_footer();
Aspis_exit();
}if ( ((!((empty($api[0]->tested) || Aspis_empty( $api[0] ->tested )))) && (version_compare(deAspisRC($GLOBALS[0]['wp_version']),deAspisRC($api[0]->tested),'>'))))
 echo AspisCheckPrint(concat2(concat1('<div class="updated"><p>',__(array('<strong>Warning:</strong> This theme has <strong>not been tested</strong> with your current version of WordPress.',false))),'</p></div>'));
else 
{if ( ((!((empty($api[0]->requires) || Aspis_empty( $api[0] ->requires )))) && (version_compare(deAspisRC($GLOBALS[0]['wp_version']),deAspisRC($api[0]->requires),'<'))))
 echo AspisCheckPrint(concat2(concat1('<div class="updated"><p>',__(array('<strong>Warning:</strong> This theme has not been marked as <strong>compatible</strong> with your version of WordPress.',false))),'</p></div>'));
}$type = array('install',false);
$update_themes = get_transient(array('update_themes',false));
if ( (is_object($update_themes[0]) && ((isset($update_themes[0]->response) && Aspis_isset( $update_themes[0] ->response )))))
 {foreach ( deAspis(array_cast($update_themes[0]->response)) as $theme_slug =>$theme_info )
{restoreTaint($theme_slug,$theme_info);
{if ( ($theme_slug[0] === $api[0]->slug[0]))
 {$type = array('update_available',false);
$update_file = $theme_slug;
break ;
}}}}$themes = get_themes();
foreach ( $themes[0] as $this_theme  )
{if ( (is_array($this_theme[0]) && (deAspis($this_theme[0]['Stylesheet']) == $api[0]->slug[0])))
 {if ( (deAspis($this_theme[0]['Version']) == $api[0]->version[0]))
 {$type = array('latest_installed',false);
}elseif ( (deAspis($this_theme[0]['Version']) > $api[0]->version[0]))
 {$type = array('newer_installed',false);
$newer_version = $this_theme[0]['Version'];
}break ;
}};
?>

<div class='available-theme'>
<img src='<?php echo AspisCheckPrint(esc_url($api[0]->screenshot_url));
?>' width='300' class="theme-preview-img" />
<h3><?php echo AspisCheckPrint($api[0]->name);
;
?></h3>
<p><?php printf(deAspis(__(array('by %s',false))),deAspisRC($api[0]->author));
;
?></p>
<p><?php printf(deAspis(__(array('Version: %s',false))),deAspisRC($api[0]->version));
;
?></p>

<?php $buttons = concat2(concat1('<a class="button" id="cancel" href="#" onclick="tb_close();return false;">',__(array('Cancel',false))),'</a> ');
switch ( $type[0] ) {
default :case ('install'):if ( deAspis(current_user_can(array('install_themes',false))))
 {$buttons = concat($buttons,concat2(concat(concat2(concat1('<a class="button-primary" id="install" href="',wp_nonce_url(admin_url(concat1('update.php?action=install-theme&theme=',$api[0]->slug)),concat1('install-theme_',$api[0]->slug))),'" target="_parent">'),__(array('Install Now',false))),'</a>'));
}break ;
case ('update_available'):if ( deAspis(current_user_can(array('update_themes',false))))
 {$buttons = concat($buttons,concat2(concat(concat2(concat1('<a class="button-primary" id="install"	href="',wp_nonce_url(admin_url(concat1('update.php?action=upgrade-theme&theme=',$update_file)),concat1('upgrade-theme_',$update_file))),'" target="_parent">'),__(array('Install Update Now',false))),'</a>'));
}break ;
case ('newer_installed'):if ( (deAspis(current_user_can(array('install_themes',false))) || deAspis(current_user_can(array('update_themes',false)))))
 {;
?><p><?php printf(deAspis(__(array('Newer version (%s) is installed.',false))),deAspisRC($newer_version));
;
?></p><?php }break ;
case ('latest_installed'):if ( (deAspis(current_user_can(array('install_themes',false))) || deAspis(current_user_can(array('update_themes',false)))))
 {;
?><p><?php _e(array('This version is already installed.',false));
;
?></p><?php }break ;
 }
;
?>
<br class="clear" />
</div>

<p class="action-button">
<?php echo AspisCheckPrint($buttons);
;
?>
<br class="clear" />
</p>

<?php iframe_footer();
Aspis_exit();
 }
