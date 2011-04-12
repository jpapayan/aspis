<?php require_once('AspisMain.php'); ?><?php
if ( (!(defined(('ABSPATH')))))
 Aspis_exit(array('-1',false));
;
?>

<div class="clear"></div></div><!-- wpbody-content -->
<div class="clear"></div></div><!-- wpbody -->
<div class="clear"></div></div><!-- wpcontent -->
</div><!-- wpwrap -->

<div id="footer">
<p id="footer-left" class="alignleft"><?php do_action(array('in_admin_footer',false));
$upgrade = apply_filters(array('update_footer',false),array('',false));
echo AspisCheckPrint(apply_filters(array('admin_footer_text',false),concat(concat2(concat(concat2(concat1('<span id="footer-thankyou">',__(array('Thank you for creating with <a href="http://wordpress.org/">WordPress</a>.',false))),'</span> | '),__(array('<a href="http://codex.wordpress.org/">Documentation</a>',false))),' | '),__(array('<a href="http://wordpress.org/support/forum/4">Feedback</a>',false)))));
;
?>
</p>
<?php ;
?>
<p id="footer-upgrade" class="alignright"><?php echo AspisCheckPrint($upgrade);
;
?></p>
<div class="clear"></div>
</div>
<?php do_action(array('admin_footer',false),array('',false));
do_action(array('admin_print_footer_scripts',false));
do_action(concat1("admin_footer-",$hook_suffix));
if ( function_exists(('get_site_option')))
 {if ( (false === deAspis(get_site_option(array('can_compress_scripts',false)))))
 compression_test();
};
?>

<script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>
</body>
</html>
<?php 