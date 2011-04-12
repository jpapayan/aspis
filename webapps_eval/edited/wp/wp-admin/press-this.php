<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
header((deconcat(concat2(concat1('Content-Type: ',get_option(array('html_type',false))),'; charset='),get_option(array('blog_charset',false)))));
if ( (denot_boolean(current_user_can(array('edit_posts',false)))))
 wp_die(__(array('Cheatin&#8217; uh?',false)));
function aposfix ( $text ) {
arrayAssign($translation_table[0],deAspis(registerTaint(attAspis(chr((34))))),addTaint(array('&quot;',false)));
arrayAssign($translation_table[0],deAspis(registerTaint(attAspis(chr((38))))),addTaint(array('&',false)));
arrayAssign($translation_table[0],deAspis(registerTaint(attAspis(chr((39))))),addTaint(array('&apos;',false)));
return Aspis_preg_replace(array("/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/",false),array("&amp;",false),Aspis_strtr($text,$translation_table));
 }
function press_it (  ) {
arrayAssign($quick[0],deAspis(registerTaint(array('post_status',false))),addTaint(array('draft',false)));
arrayAssign($quick[0],deAspis(registerTaint(array('post_category',false))),addTaint(((isset($_POST[0][('post_category')]) && Aspis_isset( $_POST [0][('post_category')]))) ? $_POST[0]['post_category'] : array(null,false)));
arrayAssign($quick[0],deAspis(registerTaint(array('tax_input',false))),addTaint(((isset($_POST[0][('tax_input')]) && Aspis_isset( $_POST [0][('tax_input')]))) ? $_POST[0]['tax_input'] : array(null,false)));
arrayAssign($quick[0],deAspis(registerTaint(array('post_title',false))),addTaint((deAspis(Aspis_trim($_POST[0]['title'])) != ('')) ? $_POST[0]['title'] : array('  ',false)));
arrayAssign($quick[0],deAspis(registerTaint(array('post_content',false))),addTaint(((isset($_POST[0][('post_content')]) && Aspis_isset( $_POST [0][('post_content')]))) ? $_POST[0]['post_content'] : array('',false)));
$post_ID = wp_insert_post($quick,array(true,false));
if ( deAspis(is_wp_error($post_ID)))
 wp_die($post_ID);
$content = ((isset($_POST[0][('content')]) && Aspis_isset( $_POST [0][('content')]))) ? $_POST[0]['content'] : array('',false);
$upload = array(false,false);
if ( ((!((empty($_POST[0][('photo_src')]) || Aspis_empty( $_POST [0][('photo_src')])))) && deAspis(current_user_can(array('upload_files',false)))))
 {foreach ( deAspis(array_cast($_POST[0]['photo_src'])) as $key =>$image )
{restoreTaint($key,$image);
{if ( (strpos(deAspis($_POST[0]['content']),deAspisRC(Aspis_htmlspecialchars($image))) !== false))
 {$desc = ((isset($_POST[0][('photo_description')][0][$key[0]]) && Aspis_isset( $_POST [0][('photo_description')] [0][$key[0]]))) ? attachAspis($_POST[0][('photo_description')],$key[0]) : array('',false);
$upload = media_sideload_image($image,$post_ID,$desc);
if ( (denot_boolean(is_wp_error($upload))))
 $content = Aspis_preg_replace(concat2(concat1('/<img ([^>]*)src=\\\?(\"|\')',Aspis_preg_quote(Aspis_htmlspecialchars($image),array('/',false))),'\\\?(\2)([^>\/]*)\/*>/is'),$upload,$content);
}}}}arrayAssign($quick[0],deAspis(registerTaint(array('post_status',false))),addTaint(((isset($_POST[0][('publish')]) && Aspis_isset( $_POST [0][('publish')]))) ? array('publish',false) : array('draft',false)));
arrayAssign($quick[0],deAspis(registerTaint(array('post_content',false))),addTaint($content));
if ( deAspis(is_wp_error($upload)))
 {wp_delete_post($post_ID);
wp_die($upload);
}else 
{{arrayAssign($quick[0],deAspis(registerTaint(array('ID',false))),addTaint($post_ID));
wp_update_post($quick);
}}return $post_ID;
 }
if ( (((isset($_REQUEST[0][('action')]) && Aspis_isset( $_REQUEST [0][('action')]))) && (('post') == deAspis($_REQUEST[0]['action']))))
 {check_admin_referer(array('press-this',false));
$post_ID = press_it();
$posted = $post_ID;
}else 
{{$post_ID = array(0,false);
}}$title = ((isset($_GET[0][('t')]) && Aspis_isset( $_GET [0][('t')]))) ? Aspis_trim(Aspis_strip_tags(aposfix(Aspis_stripslashes($_GET[0]['t'])))) : array('',false);
$selection = ((isset($_GET[0][('s')]) && Aspis_isset( $_GET [0][('s')]))) ? Aspis_trim(Aspis_htmlspecialchars(Aspis_html_entity_decode(aposfix(Aspis_stripslashes($_GET[0]['s']))))) : array('',false);
if ( (!((empty($selection) || Aspis_empty( $selection)))))
 {$selection = Aspis_preg_replace(array('/(\r?\n|\r)/',false),array('</p><p>',false),$selection);
$selection = concat2(concat1('<p>',Aspis_str_replace(array('<p></p>',false),array('',false),$selection)),'</p>');
}$url = ((isset($_GET[0][('u')]) && Aspis_isset( $_GET [0][('u')]))) ? esc_url($_GET[0]['u']) : array('',false);
$image = ((isset($_GET[0][('i')]) && Aspis_isset( $_GET [0][('i')]))) ? $_GET[0]['i'] : array('',false);
if ( (!((empty($_REQUEST[0][('ajax')]) || Aspis_empty( $_REQUEST [0][('ajax')])))))
 {switch ( deAspis($_REQUEST[0]['ajax']) ) {
case ('video'):;
?>
			<script type="text/javascript" charset="utf-8">
			/* <![CDATA[ */
				jQuery('.select').click(function() {
					append_editor(jQuery('#embed-code').val());
					jQuery('#extra-fields').hide();
					jQuery('#extra-fields').html('');
				});
				jQuery('.close').click(function() {
					jQuery('#extra-fields').hide();
					jQuery('#extra-fields').html('');
				});
			/* ]]> */
			</script>
			<div class="postbox">
				<h2><label for="embed-code"><?php _e(array('Embed Code',false));
?></label></h2>
				<div class="inside">
					<textarea name="embed-code" id="embed-code" rows="8" cols="40"><?php echo AspisCheckPrint(wp_htmledit_pre($selection));
;
?></textarea>
					<p id="options"><a href="#" class="select button"><?php _e(array('Insert Video',false));
;
?></a> <a href="#" class="close button"><?php _e(array('Cancel',false));
;
?></a></p>
				</div>
			</div>
			<?php break ;
case ('photo_thickbox'):;
?>
			<script type="text/javascript" charset="utf-8">
				/* <![CDATA[ */
				jQuery('.cancel').click(function() {
					tb_remove();
				});
				jQuery('.select').click(function() {
					image_selector();
				});
				/* ]]> */
			</script>
			<h3 class="tb"><label for="this_photo_description"><?php _e(array('Description',false));
?></label></h3>
			<div class="titlediv">
				<div class="titlewrap">
					<input id="this_photo_description" name="photo_description" class="tbtitle text" onkeypress="if(event.keyCode==13) image_selector();" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>"/>
				</div>
			</div>

			<p class="centered">
				<input type="hidden" name="this_photo" value="<?php echo AspisCheckPrint(esc_attr($image));
;
?>" id="this_photo" />
				<a href="#" class="select">
					<img src="<?php echo AspisCheckPrint(esc_url($image));
;
?>" alt="<?php echo AspisCheckPrint(esc_attr(__(array('Click to insert.',false))));
;
?>" title="<?php echo AspisCheckPrint(esc_attr(__(array('Click to insert.',false))));
;
?>" />
				</a>
			</p>

			<p id="options"><a href="#" class="select button"><?php _e(array('Insert Image',false));
;
?></a> <a href="#" class="cancel button"><?php _e(array('Cancel',false));
;
?></a></p>
			<?php break ;
case ('photo_thickbox_url'):;
?>
			<script type="text/javascript" charset="utf-8">
				/* <![CDATA[ */
				jQuery('.cancel').click(function() {
					tb_remove();
				});

				jQuery('.select').click(function() {
					image_selector();
				});
				/* ]]> */
			</script>
			<h3 class="tb"><label for="this_photo"><?php _e(array('URL',false));
?></label></h3>
			<div class="titlediv">
				<div class="titlewrap">
					<input id="this_photo" name="this_photo" class="tbtitle text" onkeypress="if(event.keyCode==13) image_selector();" />
				</div>
			</div>
			<h3 class="tb"><label for="photo_description"><?php _e(array('Description',false));
?></label></h3>
			<div id="titlediv">
				<div class="titlewrap">
					<input id="this_photo_description" name="photo_description" class="tbtitle text" onkeypress="if(event.keyCode==13) image_selector();" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>"/>
				</div>
			</div>

			<p id="options"><a href="#" class="select"><?php _e(array('Insert Image',false));
;
?></a> | <a href="#" class="cancel"><?php _e(array('Cancel',false));
;
?></a></p>
			<?php break ;
case ('photo_images'):function get_images_from_uri ( $uri ) {
$uri = Aspis_preg_replace(array('/\/#.+?$/',false),array('',false),$uri);
if ( (deAspis(Aspis_preg_match(array('/\.(jpg|jpe|jpeg|png|gif)$/',false),$uri)) && (!(strpos($uri[0],'blogger.com')))))
 return concat2(concat1("'",esc_attr(Aspis_html_entity_decode($uri))),"'");
$content = wp_remote_fopen($uri);
if ( (false === $content[0]))
 return array('',false);
$host = Aspis_parse_url($uri);
$pattern = array('/<img ([^>]*)src=(\"|\')([^<>\'\"]+)(\2)([^>]*)\/*>/i',false);
$content = Aspis_str_replace(array(array(array("\n",false),array("\t",false),array("\r",false)),false),array('',false),$content);
Aspis_preg_match_all($pattern,$content,$matches);
if ( ((empty($matches[0][(0)]) || Aspis_empty( $matches [0][(0)]))))
 return array('',false);
$sources = array(array(),false);
foreach ( deAspis(attachAspis($matches,(3))) as $src  )
{if ( (strpos($src[0],'http') === false))
 if ( (((strpos($src[0],'../') === false) && (strpos($src[0],'./') === false)) && (strpos($src[0],'/') === (0))))
 $src = concat1('http://',Aspis_str_replace(array('//',false),array('/',false),concat(concat2($host[0]['host'],'/'),$src)));
else 
{$src = concat1('http://',Aspis_str_replace(array('//',false),array('/',false),concat(concat2(concat(concat2($host[0]['host'],'/'),Aspis_dirname($host[0]['path'])),'/'),$src)));
}arrayAssignAdd($sources[0][],addTaint(esc_attr($src)));
}return concat2(concat1("'",Aspis_implode(array("','",false),$sources)),"'");
 }
$url = wp_kses(Aspis_urldecode($url),array(null,false));
echo AspisCheckPrint(concat2(concat1('new Array(',get_images_from_uri($url)),')'));
break ;
case ('photo_js'):;
?>
		// gather images and load some default JS
		var last = null
		var img, img_tag, aspect, w, h, skip, i, strtoappend = "";
		if(photostorage == false) {
		var my_src = eval(
			jQuery.ajax({
		   		type: "GET",
		   		url: "<?php echo AspisCheckPrint(esc_url($_SERVER[0]['PHP_SELF']));
;
?>",
				cache : false,
				async : false,
		   		data: "ajax=photo_images&u=<?php echo AspisCheckPrint(Aspis_urlencode($url));
;
?>",
				dataType : "script"
			}).responseText
		);
		if(my_src.length == 0) {
			var my_src = eval(
				jQuery.ajax({
		   			type: "GET",
		   			url: "<?php echo AspisCheckPrint(esc_url($_SERVER[0]['PHP_SELF']));
;
?>",
					cache : false,
					async : false,
		   			data: "ajax=photo_images&u=<?php echo AspisCheckPrint(Aspis_urlencode($url));
;
?>",
					dataType : "script"
				}).responseText
			);
			if(my_src.length == 0) {
				strtoappend = '<?php _e(array('Unable to retrieve images or no images on page.',false));
;
?>';
			}
		}
		}
		for (i = 0; i < my_src.length; i++) {
			img = new Image();
			img.src = my_src[i];
			img_attr = 'id="img' + i + '"';
			skip = false;

			maybeappend = '<a href="?ajax=photo_thickbox&amp;i=' + encodeURIComponent(img.src) + '&amp;u=<?php echo AspisCheckPrint(Aspis_urlencode($url));
;
?>&amp;height=400&amp;width=500" title="" class="thickbox"><img src="' + img.src + '" ' + img_attr + '/></a>';

			if (img.width && img.height) {
				if (img.width >= 30 && img.height >= 30) {
					aspect = img.width / img.height;
					scale = (aspect > 1) ? (71 / img.width) : (71 / img.height);

					w = img.width;
					h = img.height;

					if (scale < 1) {
						w = parseInt(img.width * scale);
						h = parseInt(img.height * scale);
					}
					img_attr += ' style="width: ' + w + 'px; height: ' + h + 'px;"';
					strtoappend += maybeappend;
				}
			} else {
				strtoappend += maybeappend;
			}
		}

		function pick(img, desc) {
			if (img) {
				if('object' == typeof jQuery('.photolist input') && jQuery('.photolist input').length != 0) length = jQuery('.photolist input').length;
				if(length == 0) length = 1;
				jQuery('.photolist').append('<input name="photo_src[' + length + ']" value="' + img +'" type="hidden"/>');
				jQuery('.photolist').append('<input name="photo_description[' + length + ']" value="' + desc +'" type="hidden"/>');
				insert_editor( "\n\n" + encodeURI('<p style="text-align: center;"><a href="<?php echo AspisCheckPrint($url);
;
?>"><img src="' + img +'" alt="' + desc + '" /></a></p>'));
			}
			return false;
		}

		function image_selector() {
			tb_remove();
			desc = jQuery('#this_photo_description').val();
			src = jQuery('#this_photo').val();
			pick(src, desc);
			jQuery('#extra-fields').hide();
			jQuery('#extra-fields').html('');
			return false;
		}
			jQuery('#extra-fields').html('<div class="postbox"><h2>Add Photos <small id="photo_directions">(<?php _e(array("click images to select",false));
?>)</small></h2><ul class="actions"><li><a href="#" id="photo-add-url" class="thickbox button"><?php _e(array("Add from URL",false));
?> +</a></li></ul><div class="inside"><div class="titlewrap"><div id="img_container"></div></div><p id="options"><a href="#" class="close button"><?php _e(array('Cancel',false));
;
?></a><a href="#" class="refresh button"><?php _e(array('Refresh',false));
;
?></a></p></div>');
			jQuery('#img_container').html(strtoappend);
		<?php break ;
 }
Aspis_exit();
};
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php do_action(array('admin_xml_ns',false));
;
?> <?php language_attributes();
;
?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php echo AspisCheckPrint(get_option(array('blog_charset',false)));
;
?>" />
	<title><?php _e(array('Press This',false));
?></title>

<?php add_thickbox();
wp_enqueue_style(array('press-this',false));
wp_enqueue_style(array('press-this-ie',false));
wp_enqueue_style(array('colors',false));
wp_enqueue_script(array('post',false));
wp_enqueue_script(array('editor',false));
;
?>
<script type="text/javascript">
//<![CDATA[
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
var userSettings = {'url':'<?php echo AspisCheckPrint(array(SITECOOKIEPATH,false));
;
?>','uid':'<?php if ( (!((isset($current_user) && Aspis_isset( $current_user)))))
 $current_user = wp_get_current_user();
echo AspisCheckPrint($current_user[0]->ID);
;
?>','time':'<?php echo AspisCheckPrint(attAspis(time()));
?>'};
var ajaxurl = '<?php echo AspisCheckPrint(admin_url(array('admin-ajax.php',false)));
;
?>', pagenow = 'press-this';
var photostorage = false;
//]]>
</script>

<?php do_action(array('admin_print_styles',false));
do_action(array('admin_print_scripts',false));
do_action(array('admin_head',false));
if ( deAspis(user_can_richedit()))
 wp_tiny_mce(array(true,false),array(array('height' => array('370',false,false)),false));
;
?>
	<script type="text/javascript">
	function insert_plain_editor(text) {
		edCanvas = document.getElementById('content');
		edInsertContent(edCanvas, text);
	}
	function set_editor(text) {
		if ( '' == text || '<p></p>' == text ) text = '<p><br /></p>';
		if ( tinyMCE.activeEditor ) tinyMCE.execCommand('mceSetContent', false, text);
	}
	function insert_editor(text) {
		if ( '' != text && tinyMCE.activeEditor && ! tinyMCE.activeEditor.isHidden()) {
			tinyMCE.execCommand('mceInsertContent', false, '<p>' + decodeURI(tinymce.DOM.decode(text)) + '</p>', {format : 'raw'});
		} else {
			insert_plain_editor(decodeURI(text));
		}
	}
	function append_editor(text) {
		if ( '' != text && tinyMCE.activeEditor && ! tinyMCE.activeEditor.isHidden()) {
			tinyMCE.execCommand('mceSetContent', false, tinyMCE.activeEditor.getContent({format : 'raw'}) + '<p>' + text + '</p>');
			tinyMCE.execCommand('mceCleanup');
		} else {
			insert_plain_editor(text);
		}
	}

	function show(tab_name) {
		jQuery('#extra-fields').html('');
		switch(tab_name) {
			case 'video' :
				jQuery('#extra-fields').load('<?php echo AspisCheckPrint(esc_url($_SERVER[0]['PHP_SELF']));
;
?>', { ajax: 'video', s: '<?php echo AspisCheckPrint(esc_attr($selection));
;
?>'}, function() {
					<?php $content = array('',false);
if ( deAspis(Aspis_preg_match(array("/youtube\.com\/watch/i",false),$url)))
 {list($domain,$video_id) = deAspisList(Aspis_split(array("v=",false),$url),array());
$video_id = esc_attr($video_id);
$content = concat2(concat(concat2(concat1('<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/',$video_id),'"></param><param name="wmode" value="transparent"></param><embed src="http://www.youtube.com/v/'),$video_id),'" type="application/x-shockwave-flash" wmode="transparent" width="425" height="350"></embed></object>');
}elseif ( deAspis(Aspis_preg_match(array("/vimeo\.com\/[0-9]+/i",false),$url)))
 {list($domain,$video_id) = deAspisList(Aspis_split(array(".com/",false),$url),array());
$video_id = esc_attr($video_id);
$content = concat2(concat(concat2(concat1('<object width="400" height="225"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://www.vimeo.com/moogaloop.swf?clip_id=',$video_id),'&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" />	<embed src="http://www.vimeo.com/moogaloop.swf?clip_id='),$video_id),'&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="225"></embed></object>');
if ( (deAspis(Aspis_trim($selection)) == ('')))
 $selection = concat2(concat(concat2(concat(concat2(concat(concat2(concat1('<p><a href="http://www.vimeo.com/',$video_id),'?pg=embed&sec='),$video_id),'">'),$title),'</a> on <a href="http://vimeo.com?pg=embed&sec='),$video_id),'">Vimeo</a></p>');
}elseif ( (strpos($selection[0],'<object') !== false))
 {$content = $selection;
};
?>
					jQuery('#embed-code').prepend('<?php echo AspisCheckPrint(Aspis_htmlentities($content));
;
?>');
				});
				jQuery('#extra-fields').show();
				return false;
				break;
			case 'photo' :
				function setup_photo_actions() {
					jQuery('.close').click(function() {
						jQuery('#extra-fields').hide();
						jQuery('#extra-fields').html('');
					});
					jQuery('.refresh').click(function() {
						photostorage = false;
						show('photo');
					});
					jQuery('#photo-add-url').attr('href', '?ajax=photo_thickbox_url&height=200&width=500');
					tb_init('#extra-fields .thickbox');
					jQuery('#waiting').hide();
					jQuery('#extra-fields').show();
				}
				jQuery('#extra-fields').before('<div id="waiting"><img src="images/wpspin_light.gif" alt="" /> <?php echo AspisCheckPrint(esc_js(__(array('Loading...',false))));
;
?></div>');
				
				if(photostorage == false) {
					jQuery.ajax({
						type: "GET",
						cache : false,
						url: "<?php echo AspisCheckPrint(esc_url($_SERVER[0]['PHP_SELF']));
;
?>",
						data: "ajax=photo_js&u=<?php echo AspisCheckPrint(Aspis_urlencode($url));
?>",
						dataType : "script",
						success : function(data) {
							eval(data);
							photostorage = jQuery('#extra-fields').html();
							setup_photo_actions();
						}
					});
				} else {
					jQuery('#extra-fields').html(photostorage);
					setup_photo_actions();
				}
				return false;
				break;
		}
	}
	jQuery(document).ready(function($) {
		//resize screen
		window.resizeTo(720,540);
		// set button actions
    	jQuery('#photo_button').click(function() { show('photo'); return false; });
		jQuery('#video_button').click(function() { show('video'); return false; });
		// auto select
		<?php if ( deAspis(Aspis_preg_match(array("/youtube\.com\/watch/i",false),$url)))
 {;
?>
			show('video');
		<?php }elseif ( deAspis(Aspis_preg_match(array("/vimeo\.com\/[0-9]+/i",false),$url)))
 {;
?>
			show('video');
		<?php }elseif ( deAspis(Aspis_preg_match(array("/flickr\.com/i",false),$url)))
 {;
?>
			show('photo');
		<?php };
?>
		jQuery('#title').unbind();
		jQuery('#publish, #save').click(function() { jQuery('#saving').css('display', 'inline'); });

		$('#tagsdiv-post_tag, #categorydiv').children('h3, .handlediv').click(function(){
			$(this).siblings('.inside').toggle();
		});
	});
</script>
</head>
<body class="press-this wp-admin">
<div id="wphead"></div>
<form action="press-this.php?action=post" method="post">
<div id="poststuff" class="metabox-holder">
	<div id="side-info-column">
		<div class="sleeve">
			<h1 id="viewsite"><a href="<?php echo AspisCheckPrint(get_option(array('home',false)));
;
?>/" target="_blank"><?php bloginfo(array('name',false));
;
?> &rsaquo; <?php _e(array('Press This',false));
?></a></span></h1>

			<?php wp_nonce_field(array('press-this',false));
?>
			<input type="hidden" name="post_type" id="post_type" value="text"/>
			<input type="hidden" name="autosave" id="autosave" />
			<input type="hidden" id="original_post_status" name="original_post_status" value="draft" />
			<input type="hidden" id="prev_status" name="prev_status" value="draft" />

			<!-- This div holds the photo metadata -->
			<div class="photolist"></div>

			<div id="submitdiv" class="stuffbox">
				<div class="handlediv" title="<?php _e(array('Click to toggle',false));
;
?>">
					<br/>
				</div>
				<h3><?php _e(array('Publish',false));
?></h3>
				<div class="inside">
					<p>
						<input class="button" type="submit" name="draft" value="<?php esc_attr_e(array('Save Draft',false));
?>" id="save" />
						<?php if ( deAspis(current_user_can(array('publish_posts',false))))
 {;
?>
							<input class="button-primary" type="submit" name="publish" value="<?php esc_attr_e(array('Publish',false));
?>" id="publish" />
						<?php }else 
{{;
?>
							<br /><br /><input class="button-primary" type="submit" name="review" value="<?php esc_attr_e(array('Submit for Review',false));
?>" id="review" />
						<?php }};
?>
						<img src="images/wpspin_light.gif" alt="" id="saving" style="display:none;" />
					</p>
				</div>
			</div>

			<div id="categorydiv" class="stuffbox">
				<div class="handlediv" title="<?php _e(array('Click to toggle',false));
;
?>">
					<br/>
				</div>
				<h3><?php _e(array('Categories',false));
?></h3>
				<div class="inside">

					<div id="categories-all" class="tabs-panel">

						<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">
							<?php wp_category_checklist($post_ID,array(false,false));
?>
						</ul>
					</div>

					<div id="category-adder" class="wp-hidden-children">
						<a id="category-add-toggle" href="#category-add" class="hide-if-no-js" tabindex="3"><?php _e(array('+ Add New Category',false));
;
?></a>
						<p id="category-add" class="wp-hidden-child">
							<label class="screen-reader-text" for="newcat"><?php _e(array('Add New Category',false));
;
?></label><input type="text" name="newcat" id="newcat" class="form-required form-input-tip" value="<?php esc_attr_e(array('New category name',false));
;
?>" tabindex="3" aria-required="true"/>
							<label class="screen-reader-text" for="newcat_parent"><?php _e(array('Parent category',false));
;
?>:</label><?php wp_dropdown_categories(array(array('hide_empty' => array(0,false,false),'name' => array('newcat_parent',false,false),'orderby' => array('name',false,false),'hierarchical' => array(1,false,false),deregisterTaint(array('show_option_none',false)) => addTaint(__(array('Parent category',false))),'tab_index' => array(3,false,false)),false));
;
?>
							<input type="button" id="category-add-sumbit" class="add:categorychecklist:category-add button" value="<?php esc_attr_e(array('Add',false));
;
?>" tabindex="3" />
							<?php wp_nonce_field(array('add-category',false),array('_ajax_nonce',false),array(false,false));
;
?>
							<span id="category-ajax-response"></span>
						</p>
					</div>
				</div>
			</div>

			<div id="tagsdiv-post_tag" class="stuffbox" >
				<div class="handlediv" title="<?php _e(array('Click to toggle',false));
;
?>">
					<br/>
				</div>
				<h3><span><?php _e(array('Post Tags',false));
;
?></span></h3>
				<div class="inside">
					<div class="tagsdiv" id="post_tag">
						<p class="jaxtag">
							<label class="screen-reader-text" for="newtag"><?php _e(array('Post Tags',false));
;
?></label>
							<input type="hidden" name="tax_input[post_tag]" class="the-tags" id="tax-input[post_tag]" value="" />
							<div class="ajaxtag">
								<input type="text" name="newtag[post_tag]" class="newtag form-input-tip" size="16" autocomplete="off" value="" />
								<input type="button" class="button tagadd" value="<?php esc_attr_e(array('Add',false));
;
?>" tabindex="3" />
							</div>
						</p>
						<div class="tagchecklist"></div>
					</div>
					<p class="tagcloud-link"><a href="#titlediv" class="tagcloud-link" id="link-post_tag"><?php _e(array('Choose from the most used tags in Post Tags',false));
;
?></a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="posting">
		<?php if ( (((isset($posted) && Aspis_isset( $posted))) && deAspis(Aspis_intval($posted))))
 {$post_ID = Aspis_intval($posted);
;
?>
		<div id="message" class="updated fade"><p><strong><?php _e(array('Your post has been saved.',false));
;
?></strong> <a onclick="window.opener.location.replace(this.href); window.close();" href="<?php echo AspisCheckPrint(get_permalink($post_ID));
;
?>"><?php _e(array('View post',false));
;
?></a> | <a href="<?php echo AspisCheckPrint(get_edit_post_link($post_ID));
;
?>" onclick="window.opener.location.replace(this.href); window.close();"><?php _e(array('Edit post',false));
;
?></a> | <a href="#" onclick="window.close();"><?php _e(array('Close Window',false));
;
?></a></p></div>
		<?php };
?>

		<div id="titlediv">
			<div class="titlewrap">
				<input name="title" id="title" class="text" value="<?php echo AspisCheckPrint(esc_attr($title));
;
?>"/>
			</div>
		</div>

		<div id="extra-fields" style="display: none"></div>

		<div class="postdivrich">
			<ul id="actions" class="actions">

				<li id="photo_button">
					Add: <?php if ( deAspis(current_user_can(array('upload_files',false))))
 {;
?><a title="<?php _e(array('Insert an Image',false));
;
?>" href="#">
<img alt="<?php _e(array('Insert an Image',false));
;
?>" src="images/media-button-image.gif"/></a>
					<?php };
?>
				</li>
				<li id="video_button">
					<a title="<?php _e(array('Embed a Video',false));
;
?>" href="#"><img alt="<?php _e(array('Embed a Video',false));
;
?>" src="images/media-button-video.gif"/></a>
				</li>
				<?php if ( deAspis(user_can_richedit()))
 {;
?>
				<li id="switcher">
					<?php wp_print_scripts(array('quicktags',false));
;
?>
					<?php add_filter(array('the_editor_content',false),array('wp_richedit_pre',false));
;
?>
					<a id="edButtonHTML" onclick="switchEditors.go('content', 'html');"><?php _e(array('HTML',false));
;
?></a>
					<a id="edButtonPreview" class="active" onclick="switchEditors.go('content', 'tinymce');"><?php _e(array('Visual',false));
;
?></a>
					<div class="zerosize"><input accesskey="e" type="button" onclick="switchEditors.go('content')" /></div>
				</li>
				<?php };
?>
			</ul>
			<div id="quicktags"></div>
			<div class="editor-container">
				<textarea name="content" id="content" style="width:100%;" class="theEditor" rows="15"><?php if ( $selection[0])
 echo AspisCheckPrint(wp_richedit_pre($selection));
if ( $url[0])
 {echo AspisCheckPrint(array('<p>',false));
if ( $selection[0])
 _e(array('via ',false));
printf(("<a href='%s'>%s</a>.</p>"),deAspisRC(esc_url($url)),deAspisRC(esc_html($title)));
};
?></textarea>
			</div>
		</div>
	</div>
</div>
</form>
<?php do_action(array('admin_print_footer_scripts',false));
;
?>
<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>
</body>
</html>
<?php 