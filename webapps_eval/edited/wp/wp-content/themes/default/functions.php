<?php require_once('AspisMain.php'); ?><?php
$content_width = array(450,false);
automatic_feed_links();
if ( function_exists(('register_sidebar')))
 {register_sidebar(array(array('before_widget' => array('<li id="%1$s" class="widget %2$s">',false,false),'after_widget' => array('</li>',false,false),'before_title' => array('<h2 class="widgettitle">',false,false),'after_title' => array('</h2>',false,false),),false));
}function kubrick_head (  ) {
$head = array("<style type='text/css'>\n<!--",false);
$output = array('',false);
if ( deAspis(kubrick_header_image()))
 {$url = kubrick_header_image_url();
$output = concat($output,concat2(concat1("#header { background: url('",$url),"') no-repeat bottom center; }\n"));
}if ( (false !== deAspis(($color = kubrick_header_color()))))
 {$output = concat($output,concat2(concat1("#headerimg h1 a, #headerimg h1 a:visited, #headerimg .description { color: ",$color),"; }\n"));
}if ( (false !== deAspis(($display = kubrick_header_display()))))
 {$output = concat($output,concat2(concat1("#headerimg { display: ",$display)," }\n"));
}$foot = array("--></style>\n",false);
if ( (('') != $output[0]))
 echo AspisCheckPrint(concat(concat($head,$output),$foot));
 }
add_action(array('wp_head',false),array('kubrick_head',false));
function kubrick_header_image (  ) {
return apply_filters(array('kubrick_header_image',false),get_option(array('kubrick_header_image',false)));
 }
function kubrick_upper_color (  ) {
if ( (strpos(deAspis($url = kubrick_header_image_url()),'header-img.php?') !== false))
 {AspisInternalFunctionCall("parse_str",deAspis(Aspis_substr($url,array(strpos($url[0],'?') + (1),false))),AspisPushRefParam($q),array(1));
return $q[0]['upper'];
}else 
{return array('69aee7',false);
} }
function kubrick_lower_color (  ) {
if ( (strpos(deAspis($url = kubrick_header_image_url()),'header-img.php?') !== false))
 {AspisInternalFunctionCall("parse_str",deAspis(Aspis_substr($url,array(strpos($url[0],'?') + (1),false))),AspisPushRefParam($q),array(1));
return $q[0]['lower'];
}else 
{return array('4180b6',false);
} }
function kubrick_header_image_url (  ) {
if ( deAspis($image = kubrick_header_image()))
 $url = concat(concat2(get_template_directory_uri(),'/images/'),$image);
else 
{$url = concat2(get_template_directory_uri(),'/images/kubrickheader.jpg');
}return $url;
 }
function kubrick_header_color (  ) {
return apply_filters(array('kubrick_header_color',false),get_option(array('kubrick_header_color',false)));
 }
function kubrick_header_color_string (  ) {
$color = kubrick_header_color();
if ( (false === $color[0]))
 return array('white',false);
return $color;
 }
function kubrick_header_display (  ) {
return apply_filters(array('kubrick_header_display',false),get_option(array('kubrick_header_display',false)));
 }
function kubrick_header_display_string (  ) {
$display = kubrick_header_display();
return $display[0] ? $display : array('inline',false);
 }
add_action(array('admin_menu',false),array('kubrick_add_theme_page',false));
function kubrick_add_theme_page (  ) {
if ( (((isset($_GET[0][('page')]) && Aspis_isset( $_GET [0][('page')]))) && (deAspis($_GET[0]['page']) == deAspis(Aspis_basename(array(__FILE__,false))))))
 {if ( (((isset($_REQUEST[0][('action')]) && Aspis_isset( $_REQUEST [0][('action')]))) && (('save') == deAspis($_REQUEST[0]['action']))))
 {check_admin_referer(array('kubrick-header',false));
if ( ((isset($_REQUEST[0][('njform')]) && Aspis_isset( $_REQUEST [0][('njform')]))))
 {if ( ((isset($_REQUEST[0][('defaults')]) && Aspis_isset( $_REQUEST [0][('defaults')]))))
 {delete_option(array('kubrick_header_image',false));
delete_option(array('kubrick_header_color',false));
delete_option(array('kubrick_header_display',false));
}else 
{{if ( (('') == deAspis($_REQUEST[0]['njfontcolor'])))
 delete_option(array('kubrick_header_color',false));
else 
{{$fontcolor = Aspis_preg_replace(array('/^.*(#[0-9a-fA-F]{6})?.*$/',false),array('$1',false),$_REQUEST[0]['njfontcolor']);
update_option(array('kubrick_header_color',false),$fontcolor);
}}if ( (deAspis(Aspis_preg_match(array('/[0-9A-F]{6}|[0-9A-F]{3}/i',false),$_REQUEST[0]['njuppercolor'],$uc)) && deAspis(Aspis_preg_match(array('/[0-9A-F]{6}|[0-9A-F]{3}/i',false),$_REQUEST[0]['njlowercolor'],$lc))))
 {$uc = (strlen(deAspis(attachAspis($uc,(0)))) == (3)) ? concat(concat(concat(concat(concat(attachAspis($uc[0][(0)],(0)),attachAspis($uc[0][(0)],(0))),attachAspis($uc[0][(0)],(1))),attachAspis($uc[0][(0)],(1))),attachAspis($uc[0][(0)],(2))),attachAspis($uc[0][(0)],(2))) : attachAspis($uc,(0));
$lc = (strlen(deAspis(attachAspis($lc,(0)))) == (3)) ? concat(concat(concat(concat(concat(attachAspis($lc[0][(0)],(0)),attachAspis($lc[0][(0)],(0))),attachAspis($lc[0][(0)],(1))),attachAspis($lc[0][(0)],(1))),attachAspis($lc[0][(0)],(2))),attachAspis($lc[0][(0)],(2))) : attachAspis($lc,(0));
update_option(array('kubrick_header_image',false),concat(concat2(concat1("header-img.php?upper=",$uc),"&lower="),$lc));
}if ( ((isset($_REQUEST[0][('toggledisplay')]) && Aspis_isset( $_REQUEST [0][('toggledisplay')]))))
 {if ( (false === deAspis(get_option(array('kubrick_header_display',false)))))
 update_option(array('kubrick_header_display',false),array('none',false));
else 
{delete_option(array('kubrick_header_display',false));
}}}}}else 
{{if ( ((isset($_REQUEST[0][('headerimage')]) && Aspis_isset( $_REQUEST [0][('headerimage')]))))
 {check_admin_referer(array('kubrick-header',false));
if ( (('') == deAspis($_REQUEST[0]['headerimage'])))
 delete_option(array('kubrick_header_image',false));
else 
{{$headerimage = Aspis_preg_replace(array('/^.*?(header-img.php\?upper=[0-9a-fA-F]{6}&lower=[0-9a-fA-F]{6})?.*$/',false),array('$1',false),$_REQUEST[0]['headerimage']);
update_option(array('kubrick_header_image',false),$headerimage);
}}}if ( ((isset($_REQUEST[0][('fontcolor')]) && Aspis_isset( $_REQUEST [0][('fontcolor')]))))
 {check_admin_referer(array('kubrick-header',false));
if ( (('') == deAspis($_REQUEST[0]['fontcolor'])))
 delete_option(array('kubrick_header_color',false));
else 
{{$fontcolor = Aspis_preg_replace(array('/^.*?(#[0-9a-fA-F]{6})?.*$/',false),array('$1',false),$_REQUEST[0]['fontcolor']);
update_option(array('kubrick_header_color',false),$fontcolor);
}}}if ( ((isset($_REQUEST[0][('fontdisplay')]) && Aspis_isset( $_REQUEST [0][('fontdisplay')]))))
 {check_admin_referer(array('kubrick-header',false));
if ( ((('') == deAspis($_REQUEST[0]['fontdisplay'])) || (('inline') == deAspis($_REQUEST[0]['fontdisplay']))))
 delete_option(array('kubrick_header_display',false));
else 
{update_option(array('kubrick_header_display',false),array('none',false));
}}}}wp_redirect(array("themes.php?page=functions.php&saved=true",false));
Aspis_exit();
}add_action(array('admin_head',false),array('kubrick_theme_page_head',false));
}add_theme_page(__(array('Custom Header',false)),__(array('Custom Header',false)),array('edit_themes',false),Aspis_basename(array(__FILE__,false)),array('kubrick_theme_page',false));
 }
function kubrick_theme_page_head (  ) {
;
?>
<script type="text/javascript" src="../wp-includes/js/colorpicker.js"></script>
<script type='text/javascript'>
// <![CDATA[
	function pickColor(color) {
		ColorPicker_targetInput.value = color;
		kUpdate(ColorPicker_targetInput.id);
	}
	function PopupWindow_populate(contents) {
		contents += '<br /><p style="text-align:center;margin-top:0px;"><input type="button" class="button-secondary" value="<?php esc_attr_e(array('Close Color Picker',false));
;
?>" onclick="cp.hidePopup(\'prettyplease\')"></input></p>';
		this.contents = contents;
		this.populated = false;
	}
	function PopupWindow_hidePopup(magicword) {
		if ( magicword != 'prettyplease' )
			return false;
		if (this.divName != null) {
			if (this.use_gebi) {
				document.getElementById(this.divName).style.visibility = "hidden";
			}
			else if (this.use_css) {
				document.all[this.divName].style.visibility = "hidden";
			}
			else if (this.use_layers) {
				document.layers[this.divName].visibility = "hidden";
			}
		}
		else {
			if (this.popupWindow && !this.popupWindow.closed) {
				this.popupWindow.close();
				this.popupWindow = null;
			}
		}
		return false;
	}
	function colorSelect(t,p) {
		if ( cp.p == p && document.getElementById(cp.divName).style.visibility != "hidden" )
			cp.hidePopup('prettyplease');
		else {
			cp.p = p;
			cp.select(t,p);
		}
	}
	function PopupWindow_setSize(width,height) {
		this.width = 162;
		this.height = 210;
	}

	var cp = new ColorPicker();
	function advUpdate(val, obj) {
		document.getElementById(obj).value = val;
		kUpdate(obj);
	}
	function kUpdate(oid) {
		if ( 'uppercolor' == oid || 'lowercolor' == oid ) {
			uc = document.getElementById('uppercolor').value.replace('#', '');
			lc = document.getElementById('lowercolor').value.replace('#', '');
			hi = document.getElementById('headerimage');
			hi.value = 'header-img.php?upper='+uc+'&lower='+lc;
			document.getElementById('header').style.background = 'url("<?php echo AspisCheckPrint(get_template_directory_uri());
;
?>/images/'+hi.value+'") center no-repeat';
			document.getElementById('advuppercolor').value = '#'+uc;
			document.getElementById('advlowercolor').value = '#'+lc;
		}
		if ( 'fontcolor' == oid ) {
			document.getElementById('header').style.color = document.getElementById('fontcolor').value;
			document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value;
		}
		if ( 'fontdisplay' == oid ) {
			document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
		}
	}
	function toggleDisplay() {
		td = document.getElementById('fontdisplay');
		td.value = ( td.value == 'none' ) ? 'inline' : 'none';
		kUpdate('fontdisplay');
	}
	function toggleAdvanced() {
		a = document.getElementById('jsAdvanced');
		if ( a.style.display == 'none' )
			a.style.display = 'block';
		else
			a.style.display = 'none';
	}
	function kDefaults() {
		document.getElementById('headerimage').value = '';
		document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#69aee7';
		document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#4180b6';
		document.getElementById('header').style.background = 'url("<?php echo AspisCheckPrint(get_template_directory_uri());
;
?>/images/kubrickheader.jpg") center no-repeat';
		document.getElementById('header').style.color = '#FFFFFF';
		document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '';
		document.getElementById('fontdisplay').value = 'inline';
		document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
	}
	function kRevert() {
		document.getElementById('headerimage').value = '<?php echo AspisCheckPrint(esc_js(kubrick_header_image()));
;
?>';
		document.getElementById('advuppercolor').value = document.getElementById('uppercolor').value = '#<?php echo AspisCheckPrint(esc_js(kubrick_upper_color()));
;
?>';
		document.getElementById('advlowercolor').value = document.getElementById('lowercolor').value = '#<?php echo AspisCheckPrint(esc_js(kubrick_lower_color()));
;
?>';
		document.getElementById('header').style.background = 'url("<?php echo AspisCheckPrint(esc_js(kubrick_header_image_url()));
;
?>") center no-repeat';
		document.getElementById('header').style.color = '';
		document.getElementById('advfontcolor').value = document.getElementById('fontcolor').value = '<?php echo AspisCheckPrint(esc_js(kubrick_header_color_string()));
;
?>';
		document.getElementById('fontdisplay').value = '<?php echo AspisCheckPrint(esc_js(kubrick_header_display_string()));
;
?>';
		document.getElementById('headerimg').style.display = document.getElementById('fontdisplay').value;
	}
	function kInit() {
		document.getElementById('jsForm').style.display = 'block';
		document.getElementById('nonJsForm').style.display = 'none';
	}
	addLoadEvent(kInit);
// ]]>
</script>
<style type='text/css'>
	#headwrap {
		text-align: center;
	}
	#kubrick-header {
		font-size: 80%;
	}
	#kubrick-header .hibrowser {
		width: 780px;
		height: 260px;
		overflow: scroll;
	}
	#kubrick-header #hitarget {
		display: none;
	}
	#kubrick-header #header h1 {
		font-family: 'Trebuchet MS', 'Lucida Grande', Verdana, Arial, Sans-Serif;
		font-weight: bold;
		font-size: 4em;
		text-align: center;
		padding-top: 70px;
		margin: 0;
	}

	#kubrick-header #header .description {
		font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif;
		font-size: 1.2em;
		text-align: center;
	}
	#kubrick-header #header {
		text-decoration: none;
		color: <?php echo AspisCheckPrint(kubrick_header_color_string());
;
?>;
		padding: 0;
		margin: 0;
		height: 200px;
		text-align: center;
		background: url('<?php echo AspisCheckPrint(kubrick_header_image_url());
;
?>') center no-repeat;
	}
	#kubrick-header #headerimg {
		margin: 0;
		height: 200px;
		width: 100%;
		display: <?php echo AspisCheckPrint(kubrick_header_display_string());
;
?>;
	}
	
	.description {
		margin-top: 16px;
		color: #fff;
	}

	#jsForm {
		display: none;
		text-align: center;
	}
	#jsForm input.submit, #jsForm input.button, #jsAdvanced input.button {
		padding: 0px;
		margin: 0px;
	}
	#advanced {
		text-align: center;
		width: 620px;
	}
	html>body #advanced {
		text-align: center;
		position: relative;
		left: 50%;
		margin-left: -380px;
	}
	#jsAdvanced {
		text-align: right;
	}
	#nonJsForm {
		position: relative;
		text-align: left;
		margin-left: -370px;
		left: 50%;
	}
	#nonJsForm label {
		padding-top: 6px;
		padding-right: 5px;
		float: left;
		width: 100px;
		text-align: right;
	}
	.defbutton {
		font-weight: bold;
	}
	.zerosize {
		width: 0px;
		height: 0px;
		overflow: hidden;
	}
	#colorPickerDiv a, #colorPickerDiv a:hover {
		padding: 1px;
		text-decoration: none;
		border-bottom: 0px;
	}
</style>
<?php  }
function kubrick_theme_page (  ) {
if ( ((isset($_REQUEST[0][('saved')]) && Aspis_isset( $_REQUEST [0][('saved')]))))
 echo AspisCheckPrint(concat2(concat1('<div id="message" class="updated fade"><p><strong>',__(array('Options saved.',false))),'</strong></p></div>'));
;
?>
<div class='wrap'>
	<h2><?php _e(array('Customize Header',false));
;
?></h2>
	<div id="kubrick-header">
		<div id="headwrap">
			<div id="header">
				<div id="headerimg">
					<h1><?php bloginfo(array('name',false));
;
?></h1>
					<div class="description"><?php bloginfo(array('description',false));
;
?></div>
				</div>
			</div>
		</div>
		<br />
		<div id="nonJsForm">
			<form method="post" action="">
				<?php wp_nonce_field(array('kubrick-header',false));
;
?>
				<div class="zerosize"><input type="submit" name="defaultsubmit" value="<?php esc_attr_e(array('Save',false));
;
?>" /></div>
					<label for="njfontcolor"><?php _e(array('Font Color:',false));
;
?></label><input type="text" name="njfontcolor" id="njfontcolor" value="<?php echo AspisCheckPrint(esc_attr(kubrick_header_color()));
;
?>" /> <?php printf(deAspis(__(array('Any CSS color (%s or %s or %s)',false))),'<code>red</code>','<code>#FF0000</code>','<code>rgb(255, 0, 0)</code>');
;
?><br />
					<label for="njuppercolor"><?php _e(array('Upper Color:',false));
;
?></label><input type="text" name="njuppercolor" id="njuppercolor" value="#<?php echo AspisCheckPrint(esc_attr(kubrick_upper_color()));
;
?>" /> <?php printf(deAspis(__(array('HEX only (%s or %s)',false))),'<code>#FF0000</code>','<code>#F00</code>');
;
?><br />
				<label for="njlowercolor"><?php _e(array('Lower Color:',false));
;
?></label><input type="text" name="njlowercolor" id="njlowercolor" value="#<?php echo AspisCheckPrint(esc_attr(kubrick_lower_color()));
;
?>" /> <?php printf(deAspis(__(array('HEX only (%s or %s)',false))),'<code>#FF0000</code>','<code>#F00</code>');
;
?><br />
				<input type="hidden" name="hi" id="hi" value="<?php echo AspisCheckPrint(esc_attr(kubrick_header_image()));
;
?>" />
				<input type="submit" name="toggledisplay" id="toggledisplay" value="<?php esc_attr_e(array('Toggle Text',false));
;
?>" />
				<input type="submit" name="defaults" value="<?php esc_attr_e(array('Use Defaults',false));
;
?>" />
				<input type="submit" class="defbutton" name="submitform" value="&nbsp;&nbsp;<?php esc_attr_e(array('Save',false));
;
?>&nbsp;&nbsp;" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="njform" value="true" />
			</form>
		</div>
		<div id="jsForm">
			<form style="display:inline;" method="post" name="hicolor" id="hicolor" action="<?php echo AspisCheckPrint(esc_attr($_SERVER[0]['REQUEST_URI']));
;
?>">
				<?php wp_nonce_field(array('kubrick-header',false));
;
?>
	<input type="button"  class="button-secondary" onclick="tgt=document.getElementById('fontcolor');colorSelect(tgt,'pick1');return false;" name="pick1" id="pick1" value="<?php esc_attr_e(array('Font Color',false));
;
?>"></input>
		<input type="button" class="button-secondary" onclick="tgt=document.getElementById('uppercolor');colorSelect(tgt,'pick2');return false;" name="pick2" id="pick2" value="<?php esc_attr_e(array('Upper Color',false));
;
?>"></input>
		<input type="button" class="button-secondary" onclick="tgt=document.getElementById('lowercolor');colorSelect(tgt,'pick3');return false;" name="pick3" id="pick3" value="<?php esc_attr_e(array('Lower Color',false));
;
?>"></input>
				<input type="button" class="button-secondary" name="revert" value="<?php esc_attr_e(array('Revert',false));
;
?>" onclick="kRevert()" />
				<input type="button" class="button-secondary" value="<?php esc_attr_e(array('Advanced',false));
;
?>" onclick="toggleAdvanced()" />
				<input type="hidden" name="action" value="save" />
				<input type="hidden" name="fontdisplay" id="fontdisplay" value="<?php echo AspisCheckPrint(esc_attr(kubrick_header_display()));
;
?>" />
				<input type="hidden" name="fontcolor" id="fontcolor" value="<?php echo AspisCheckPrint(esc_attr(kubrick_header_color()));
;
?>" />
				<input type="hidden" name="uppercolor" id="uppercolor" value="<?php echo AspisCheckPrint(esc_attr(kubrick_upper_color()));
;
?>" />
				<input type="hidden" name="lowercolor" id="lowercolor" value="<?php echo AspisCheckPrint(esc_attr(kubrick_lower_color()));
;
?>" />
				<input type="hidden" name="headerimage" id="headerimage" value="<?php echo AspisCheckPrint(esc_attr(kubrick_header_image()));
;
?>" />
				<p class="submit"><input type="submit" name="submitform" class="button-primary" value="<?php esc_attr_e(array('Update Header',false));
;
?>" onclick="cp.hidePopup('prettyplease')" /></p>
			</form>
			<div id="colorPickerDiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;visibility:hidden;"> </div>
			<div id="advanced">
				<form id="jsAdvanced" style="display:none;" action="">
					<?php wp_nonce_field(array('kubrick-header',false));
;
?>
					<label for="advfontcolor"><?php _e(array('Font Color (CSS):',false));
;
?> </label><input type="text" id="advfontcolor" onchange="advUpdate(this.value, 'fontcolor')" value="<?php echo AspisCheckPrint(esc_attr(kubrick_header_color()));
;
?>" /><br />
					<label for="advuppercolor"><?php _e(array('Upper Color (HEX):',false));
;
?> </label><input type="text" id="advuppercolor" onchange="advUpdate(this.value, 'uppercolor')" value="#<?php echo AspisCheckPrint(esc_attr(kubrick_upper_color()));
;
?>" /><br />
					<label for="advlowercolor"><?php _e(array('Lower Color (HEX):',false));
;
?> </label><input type="text" id="advlowercolor" onchange="advUpdate(this.value, 'lowercolor')" value="#<?php echo AspisCheckPrint(esc_attr(kubrick_lower_color()));
;
?>" /><br />
					<input type="button" class="button-secondary" name="default" value="<?php esc_attr_e(array('Select Default Colors',false));
;
?>" onclick="kDefaults()" /><br />
					<input type="button" class="button-secondary" onclick="toggleDisplay();return false;" name="pick" id="pick" value="<?php esc_attr_e(array('Toggle Text Display',false));
;
?>"></input><br />
				</form>
			</div>
		</div>
	</div>
</div>
<?php  }
;
?>
<?php 