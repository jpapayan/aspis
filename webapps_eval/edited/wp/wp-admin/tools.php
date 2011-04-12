<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
$title = __(array('Tools',false));
wp_enqueue_script(array('wp-gears',false));
require_once ('admin-header.php');
;
?>
<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>

<div class="tool-box">
<?php if ( (denot_boolean($is_opera)))
 {;
?>
	<div id="gears-msg1">
	<h3 class="title"><?php _e(array('Turbo:',false));
;
?> <?php _e(array('Speed up WordPress',false));
;
?></h3>
	<p><?php _e(array('WordPress now has support for Gears, which adds new features to your web browser.',false));
;
?><br />
	<a href="http://gears.google.com/" target="_blank" style="font-weight:normal;"><?php _e(array('More information...',false));
;
?></a></p>
	<p><?php _e(array('After you install and enable Gears, most of WordPress&#8217; images, scripts, and CSS files will be stored locally on your computer. This speeds up page load time.',false));
;
?></p>
	<p><strong><?php _e(array('Don&#8217;t install on a public or shared computer.',false));
;
?></strong></p>
	<div class="buttons"><button onclick="window.location = 'http://gears.google.com/?action=install&amp;return=<?php echo AspisCheckPrint(Aspis_urlencode(admin_url()));
;
?>';" class="button"><?php _e(array('Install Now',false));
;
?></button></div>
	</div>

	<div id="gears-msg2" style="display:none;">
	<h3 class="title"><?php _e(array('Turbo:',false));
;
?> <?php _e(array('Gears Status',false));
;
?></h3>
	<p><?php _e(array('Gears is installed on this computer, but is not enabled for use with WordPress.',false));
;
?></p>
	<p><?php _e(array('To enable it click the button below.',false));
;
?></p>
	<p><strong><?php _e(array('Note: Do not enable Gears if this is a public or shared computer!',false));
;
?></strong></p>
	<div class="buttons"><button class="button" onclick="wpGears.getPermission();"><?php _e(array('Enable Gears',false));
;
?></button></div>
	</div>

	<div id="gears-msg3" style="display:none;">
	<h3 class="title"><?php _e(array('Turbo:',false));
;
?> <?php _e(array('Gears Status',false));
;
?></h3>
	<p><?php if ( $is_chrome[0])
 _e(array('Gears is installed and enabled on this computer. You can disable it from the Under the Hood tab in Chrome&#8217;s Options menu.',false));
elseif ( $is_safari[0])
 _e(array('Gears is installed and enabled on this computer. You can disable it from the Safari menu.',false));
else 
{_e(array('Gears is installed and enabled on this computer. You can disable it from your browser&#8217;s Tools menu.',false));
};
?></p>
	<p><?php _e(array('If there are any errors try disabling Gears, reloading the page, and re-enabling Gears.',false));
;
?></p>
	<p><?php _e(array('Local storage status:',false));
;
?> <span id="gears-wait"><span style="color:#f00;"><?php _e(array('Updating files:',false));
;
?></span> <span id="gears-upd-number"></span></span></p>
	</div>

	<div id="gears-msg4" style="display:none;">
	<h3 class="title"><?php _e(array('Turbo:',false));
;
?> <?php _e(array('Gears Status',false));
;
?></h3>
	<p><?php _e(array('Your browser&#8217;s settings do not permit this website to use Google Gears.',false));
;
?></p>
	<p><?php if ( $is_chrome[0])
 _e(array('To allow it, change the Gears settings in your browser&#8217;s Options, Under the Hood menu and reload this page.',false));
elseif ( $is_safari[0])
 _e(array('To allow it, change the Gears settings in the Safari menu and reload this page.',false));
else 
{_e(array('To allow it, change the Gears settings in your browser&#8217;s Tools menu and reload this page.',false));
};
?></p>
	<p><strong><?php _e(array('Note: Do not enable Gears if this is a public or shared computer!',false));
;
?></strong></p>
	</div>
	<script type="text/javascript">wpGears.message();</script>
<?php }else 
{{_e(array('Turbo is not available for your browser.',false));
}};
?>
</div>

<?php if ( deAspis(current_user_can(array('edit_posts',false))))
 {;
?>
<div class="tool-box">
	<h3 class="title"><?php _e(array('Press This',false));
?></h3>
	<p><?php _e(array('Press This is a bookmarklet: a little app that runs in your browser and lets you grab bits of the web.',false));
;
?></p>

	<p><?php _e(array('Use Press This to clip text, images and videos from any web page. Then edit and add more straight from Press This before you save or publish it in a post on your blog.',false));
;
?></p>
	<p><?php _e(array('Drag-and-drop the following link to your bookmarks bar or right click it and add it to your favorites for a posting shortcut.',false));
?></p>
	<p class="pressthis"><a href="<?php echo AspisCheckPrint(Aspis_htmlspecialchars(get_shortcut_link()));
;
?>" title="<?php echo AspisCheckPrint(esc_attr(__(array('Press This',false))));
?>"><?php _e(array('Press This',false));
?></a></p>
</div>
<?php }do_action(array('tool_box',false));
;
?>
</div>
<?php include ('admin-footer.php');
;
?>
<?php 