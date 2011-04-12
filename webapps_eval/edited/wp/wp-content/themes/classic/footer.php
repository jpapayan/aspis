<?php require_once('AspisMain.php'); ?><?php
;
?>
<!-- begin footer -->
</div>

<?php get_sidebar();
;
?>

<p class="credit"><!--<?php echo AspisCheckPrint(get_num_queries());
;
?> queries. <?php timer_stop(array(1,false));
;
?> seconds. --> <cite>Loaded in <?php timer_stop(array(2,false));
;
?> seconds.<?php echo AspisCheckPrint(Aspis_sprintf(__(array("Powered by <a href='http://wordpress.org/' title='%s'><strong>WordPress</strong></a>",false)),__(array("Powered by WordPress, state-of-the-art semantic personal publishing platform.",false))));
;
?></cite></p>

</div>

<?php wp_footer();
;
?>
</body>
</html>
<?php 