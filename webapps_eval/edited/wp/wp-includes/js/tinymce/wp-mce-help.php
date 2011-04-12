<?php require_once('AspisMain.php'); ?><?php
require_once ('../../../wp-load.php');
header((deconcat1('Content-Type: text/html; charset=',get_bloginfo(array('charset',false)))));
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes();
;
?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php echo AspisCheckPrint(get_option(array('blog_charset',false)));
;
?>" />
<title><?php _e(array('Rich Editor Help',false));
?></title>
<script type="text/javascript" src="tiny_mce_popup.js?ver=3223"></script>
<?php wp_admin_css(array('global',false),array(true,false));
wp_admin_css(array('wp-admin',false),array(true,false));
;
?>
<style type="text/css">
	#wphead {
		font-size: 80%;
		border-top: 0;
		color: #555;
		background-color: #f1f1f1;
	}
	#wphead h1 {
		font-size: 24px;
		color: #555;
		margin: 0;
		padding: 10px;
	}
	#tabs {
		padding: 15px 15px 3px;
		background-color: #f1f1f1;
		border-bottom: 1px solid #dfdfdf;
	}
	#tabs li {
		display: inline;
	}
	#tabs a.current {
		background-color: #fff;
		border-color: #dfdfdf;
		border-bottom-color: #fff;
		color: #d54e21;
	}
	#tabs a {
		color: #2583AD;
		padding: 6px;
		border-width: 1px 1px 0;
		border-style: solid solid none;
		border-color: #f1f1f1;
		text-decoration: none;
	}
	#tabs a:hover {
		color: #d54e21;
	}
	.wrap h2 {
		border-bottom-color: #dfdfdf;
		color: #555;
		margin: 5px 0;
		padding: 0;
		font-size: 18px;
	}
	#user_info {
		right: 5%;
		top: 5px;
	}
	h3 {
		font-size: 1.1em;
		margin-top: 10px;
		margin-bottom: 0px;
	}
	#flipper {
		margin: 0;
		padding: 5px 20px 10px;
		background-color: #fff;
		border-left: 1px solid #dfdfdf;
		border-bottom: 1px solid #dfdfdf;
	}
	* html {
        overflow-x: hidden;
        overflow-y: scroll;
    }
	#flipper div p {
		margin-top: 0.4em;
		margin-bottom: 0.8em;
		text-align: justify;
	}
	th {
		text-align: center;
	}
	.top th {
		text-decoration: underline;
	}
	.top .key {
		text-align: center;
		width: 5em;
	}
	.top .action {
		text-align: left;
	}
	.align {
		border-left: 3px double #333;
		border-right: 3px double #333;
	}
	.keys {
		margin-bottom: 15px;
	}
	.keys p {
		display: inline-block;
		margin: 0px;
		padding: 0px;
	}
	.keys .left { text-align: left; }
	.keys .center { text-align: center; }
	.keys .right { text-align: right; }
	td b {
		font-family: "Times New Roman" Times serif;
	}
	#buttoncontainer {
		text-align: center;
		margin-bottom: 20px;
	}
	#buttoncontainer a, #buttoncontainer a:hover {
		border-bottom: 0px;
	}
</style>
<?php if ( (('rtl') == $wp_locale[0]->text_direction[0]))
 {;
?>
<style type="text/css">
	#wphead, #tabs {
		padding-left: auto;
		padding-right: 15px;
	}
	#flipper {
		margin: 5px 0 3px 10px;
	}
	.keys .left, .top, .action { text-align: right; }
	.keys .right { text-align: left; }
	td b { font-family: Tahoma, "Times New Roman", Times, serif }
</style>
<?php };
?>
<script type="text/javascript">
	function d(id) { return document.getElementById(id); }

	function flipTab(n) {
		for (i=1;i<=4;i++) {
			c = d('content'+i.toString());
			t = d('tab'+i.toString());
			if ( n == i ) {
				c.className = '';
				t.className = 'current';
			} else {
				c.className = 'hidden';
				t.className = '';
			}
		}
	}

    function init() {
        document.getElementById('version').innerHTML = tinymce.majorVersion + "." + tinymce.minorVersion;
        document.getElementById('date').innerHTML = tinymce.releaseDate;
    }
    tinyMCEPopup.onInit.add(init);
</script>
</head>
<body>

<div id="wphead"><h1><?php echo AspisCheckPrint(get_bloginfo(array('blogtitle',false)));
;
?></h1></div>

<ul id="tabs">
	<li><a id="tab1" href="javascript:flipTab(1)" title="<?php _e(array('Basics of Rich Editing',false));
?>" accesskey="1" tabindex="1" class="current"><?php _e(array('Basics',false));
?></a></li>
	<li><a id="tab2" href="javascript:flipTab(2)" title="<?php _e(array('Advanced use of the Rich Editor',false));
?>" accesskey="2" tabindex="2"><?php _e(array('Advanced',false));
?></a></li>
	<li><a id="tab3" href="javascript:flipTab(3)" title="<?php _e(array('Hotkeys',false));
?>" accesskey="3" tabindex="3"><?php _e(array('Hotkeys',false));
?></a></li>
	<li><a id="tab4" href="javascript:flipTab(4)" title="<?php _e(array('About the software',false));
?>" accesskey="4" tabindex="4"><?php _e(array('About',false));
?></a></li>
</ul>

<div id="flipper" class="wrap">

<div id="content1">
	<h2><?php _e(array('Rich Editing Basics',false));
?></h2>
	<p><?php _e(array('<em>Rich editing</em>, also called WYSIWYG for What You See Is What You Get, means your text is formatted as you type. The rich editor creates HTML code behind the scenes while you concentrate on writing. Font styles, links and images all appear approximately as they will on the internet.',false));
?></p>
	<p><?php _e(array('WordPress includes a rich HTML editor that works well in all major web browsers used today. However editing HTML is not the same as typing text. Each web page has two major components: the structure, which is the actual HTML code and is produced by the editor as you type, and the display, that is applied to it by the currently selected WordPress theme and is defined in style.css. WordPress is producing valid XHTML 1.0 which means that inserting multiple line breaks (BR tags) after a paragraph would not produce white space on the web page. The BR tags will be removed as invalid by the internal HTML correcting functions.',false));
?></p>
	<p><?php _e(array('While using the editor, most basic keyboard shortcuts work like in any other text editor. For example: Shift+Enter inserts line break, Ctrl+C = copy, Ctrl+X = cut, Ctrl+Z = undo, Ctrl+Y = redo, Ctrl+A = select all, etc. (on Mac use the Command key instead of Ctrl). See the Hotkeys tab for all available keyboard shortcuts.',false));
?></p>
    <p><?php _e(array('If you do not like the way the rich editor works, you may turn it off from Your Profile submenu, under Users in the admin menu.',false));
?></p>
</div>

<div id="content2" class="hidden">
	<h2><?php _e(array('Advanced Rich Editing',false));
?></h2>
	<h3><?php _e(array('Images and Attachments',false));
?></h3>
	<p><?php _e(array('There is a button in the editor toolbar for inserting images that are already hosted somewhere on the internet. If you have a URL for an image, click this button and enter the URL in the box which appears.',false));
?></p>
	<p><?php _e(array('If you need to upload an image or another media file from your computer, you can use the Media Library buttons above the editor. The media library will attempt to create a thumbnail-sized copy from each uploaded image. To insert your image into the post, first click on the thumbnail to reveal a menu of options. When you have selected the options you like, click "Send to Editor" and your image or file will appear in the post you are editing. If you are inserting a movie, there are additional options in the "Media" dialog that can be opened from the second toolbar row.',false));
?></p>
	<h3><?php _e(array('HTML in the Rich Editor',false));
?></h3>
	<p><?php _e(array('Any HTML entered directly into the rich editor will show up as text when the post is viewed. What you see is what you get. When you want to include HTML elements that cannot be generated with the toolbar buttons, you must enter it by hand in the HTML editor. Examples are tables and &lt;code&gt;. To do this, click the HTML tab and edit the code, then switch back to Visual mode. If the code is valid and understood by the editor, you should see it rendered immediately.',false));
?></p>
	<h3><?php _e(array('Pasting in the Rich Editor',false));
?></h3>
	<p><?php _e(array('When pasting content from another web page the results can be inconsistent and depend on your browser and on the web page you are pasting from. The editor tries to correct any invalid HTML code that was pasted, but for best results try using the HTML tab or one of the paste buttons that are on the second row. Alternatively try pasting paragraph by paragraph. In most browsers to select one paragraph at a time, triple-click on it.',false));
?></p>
	<p><?php _e(array('Pasting content from another application, like Word or Excel, is best done with the Paste from Word button on the second row, or in HTML mode.',false));
?></p>
</div>

<div id="content3" class="hidden">
	<h2><?php _e(array('Writing at Full Speed',false));
?></h2>
    <p><?php _e(array('Rather than reaching for your mouse to click on the toolbar, use these access keys. Windows and Linux use Ctrl + letter. Macintosh uses Command + letter.',false));
?></p>
	<table class="keys" width="100%" style="border: 0 none;">
		<tr class="top"><th class="key center"><?php _e(array('Letter',false));
?></th><th class="left"><?php _e(array('Action',false));
?></th><th class="key center"><?php _e(array('Letter',false));
?></th><th class="left"><?php _e(array('Action',false));
?></th></tr>
		<tr><th>c</th><td><?php _e(array('Copy',false));
?></td><th>v</th><td><?php _e(array('Paste',false));
?></td></tr>
		<tr><th>a</th><td><?php _e(array('Select all',false));
?></td><th>x</th><td><?php _e(array('Cut',false));
?></td></tr>
		<tr><th>z</th><td><?php _e(array('Undo',false));
?></td><th>y</th><td><?php _e(array('Redo',false));
?></td></tr>
		<script type="text/javascript">
		if ( ! tinymce.isWebKit )
			document.write("<tr><th>b</th><td><?php _e(array('Bold',false));
?></td><th>i</th><td><?php _e(array('Italic',false));
?></td></tr>"+
			"<tr><th>u</th><td><?php _e(array('Underline',false));
?></td><th>1</th><td><?php _e(array('Header 1',false));
?></td></tr>"+
			"<tr><th>2</th><td><?php _e(array('Header 2',false));
?></td><th>3</th><td><?php _e(array('Header 3',false));
?></td></tr>"+
			"<tr><th>4</th><td><?php _e(array('Header 4',false));
?></td><th>5</th><td><?php _e(array('Header 5',false));
?></td></tr>"+
			"<tr><th>6</th><td><?php _e(array('Header 6',false));
?></td><th>9</th><td><?php _e(array('Address',false));
?></td></tr>")
		</script>
	</table>

	<p><?php _e(array('The following shortcuts use different access keys: Alt + Shift + letter.',false));
?></p>
	<table class="keys" width="100%" style="border: 0 none;">
		<tr class="top"><th class="key center"><?php _e(array('Letter',false));
?></th><th class="left"><?php _e(array('Action',false));
?></th><th class="key center"><?php _e(array('Letter',false));
?></th><th class="left"><?php _e(array('Action',false));
?></th></tr>
		<script type="text/javascript">
		if ( tinymce.isWebKit )
			document.write("<tr><th>b</th><td><?php _e(array('Bold',false));
?></td><th>i</th><td><?php _e(array('Italic',false));
?></td></tr>")
		</script>
		<tr><th>n</th><td><?php _e(array('Check Spelling',false));
?></td><th>l</th><td><?php _e(array('Align Left',false));
?></td></tr>
		<tr><th>j</th><td><?php _e(array('Justify Text',false));
?></td><th>c</th><td><?php _e(array('Align Center',false));
?></td></tr>
		<tr><th>d</th><td><span style="text-decoration: line-through;"><?php _e(array('Strikethrough',false));
?></span></td><th>r</th><td><?php _e(array('Align Right',false));
?></td></tr>
		<tr><th>u</th><td><strong>&bull;</strong> <?php _e(array('List',false));
?></td><th>a</th><td><?php _e(array('Insert link',false));
?></td></tr>
		<tr><th>o</th><td>1. <?php _e(array('List',false));
?></td><th>s</th><td><?php _e(array('Remove link',false));
?></td></tr>
		<tr><th>q</th><td><?php _e(array('Quote',false));
?></td><th>m</th><td><?php _e(array('Insert Image',false));
?></td></tr>
		<tr><th>g</th><td><?php _e(array('Full Screen',false));
?></td><th>t</th><td><?php _e(array('Insert More Tag',false));
?></td></tr>
		<tr><th>p</th><td><?php _e(array('Insert Page Break tag',false));
?></td><th>h</th><td><?php _e(array('Help',false));
?></td></tr>
		<tr><th>e</th><td colspan="3"><?php _e(array('Switch to HTML mode',false));
?></td></tr>
	</table>
</div>

<div id="content4" class="hidden">
	<h2><?php _e(array('About TinyMCE',false));
;
?></h2>

    <p><?php _e(array('Version:',false));
;
?> <span id="version"></span> (<span id="date"></span>)</p>
	<p><?php printf(deAspis(__(array('TinyMCE is a platform independent web based Javascript HTML WYSIWYG editor control released as Open Source under %sLGPL</a>	by Moxiecode Systems AB. It has the ability to convert HTML TEXTAREA fields or other HTML elements to editor instances.',false))),(deconcat2(concat(concat2(concat1('<a href="',get_bloginfo(array('url',false))),'/wp-includes/js/tinymce/license.txt" target="_blank" title="'),__(array('GNU Library General Public Licence',false))),'">')));
?></p>
	<p><?php _e(array('Copyright &copy; 2003-2007, <a href="http://www.moxiecode.com" target="_blank">Moxiecode Systems AB</a>, All rights reserved.',false));
?></p>
	<p><?php _e(array('For more information about this software visit the <a href="http://tinymce.moxiecode.com" target="_blank">TinyMCE website</a>.',false));
?></p>

	<div id="buttoncontainer">
		<a href="http://www.moxiecode.com" target="_blank"><img src="themes/advanced/img/gotmoxie.png" alt="<?php _e(array('Got Moxie?',false));
?>" style="border: none;" /></a>
		<a href="http://sourceforge.net/projects/tinymce/" target="_blank"><img src="themes/advanced/img/sflogo.png" alt="<?php _e(array('Hosted By Sourceforge',false));
?>" style="border: none;" /></a>
		<a href="http://www.freshmeat.net/projects/tinymce" target="_blank"><img src="themes/advanced/img/fm.gif" alt="<?php _e(array('Also on freshmeat',false));
?>" style="border: none;" /></a>
	</div>

</div>
</div>

<div class="mceActionPanel">
	<div style="margin: 8px auto; text-align: center;padding-bottom: 10px;">
		<input type="button" id="cancel" name="cancel" value="<?php _e(array('Close',false));
;
?>" title="<?php _e(array('Close',false));
;
?>" onclick="tinyMCEPopup.close();" />
	</div>
</div>

</body>
</html>
<?php 