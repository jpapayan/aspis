<?php require_once('AspisMain.php'); ?><?php
;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes();
;
?>>

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo(array('html_type',false));
;
?>; charset=<?php bloginfo(array('charset',false));
;
?>" />

	<title><?php wp_title(array('&laquo;',false),array(true,false),array('right',false));
;
?> <?php bloginfo(array('name',false));
;
?></title>

	<style type="text/css" media="screen">
		@import url( <?php bloginfo(array('stylesheet_url',false));
;
?> );
	</style>

	<link rel="pingback" href="<?php bloginfo(array('pingback_url',false));
;
?>" />
	<?php wp_get_archives(array('type=monthly&format=link',false));
;
?>
	<?php ;
?>
	<?php wp_head();
;
?>
</head>

<body <?php body_class();
;
?>>
<div id="rap">
<h1 id="header"><a href="<?php bloginfo(array('url',false));
;
?>/"><?php bloginfo(array('name',false));
;
?></a></h1>

<div id="content">
<!-- end header -->
<?php 