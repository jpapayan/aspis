<?php require_once('AspisMain.php'); ?><?php
;
?>

<hr />
<div id="footer" role="contentinfo">
<!-- If you'd like to support WordPress, having the "powered by" link somewhere on your blog is the best way; it's our only promotion or advertising. -->
	<p> 

		<?php bloginfo(array('name',false));
;
?> is proudly powered by
		<a href="http://wordpress.org/">WordPress</a>
		<br /><a href="<?php bloginfo(array('rss2_url',false));
;
?>">Entries (RSS)</a>
		and <a href="<?php bloginfo(array('comments_rss2_url',false));
;
?>">Comments (RSS)</a>.
		<!-- <?php echo AspisCheckPrint(get_num_queries());
;
?> queries. <?php timer_stop(array(1,false));
;
?> seconds. -->
	</p>
</div>
</div>

<!-- Gorgeous design by Michael Heilemann - http://binarybonsai.com/kubrick/ -->
<?php ;
?>

		<?php wp_footer();
;
?>

</body>
</html>
<?php 