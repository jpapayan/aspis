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

<link rel="stylesheet" href="<?php bloginfo(array('stylesheet_url',false));
;
?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo(array('pingback_url',false));
;
?>" />

<style type="text/css" media="screen">

<?php if ( (((empty($withcomments) || Aspis_empty( $withcomments))) && (denot_boolean(is_single()))))
 {;
?>
	#page { background: url("<?php bloginfo(array('stylesheet_directory',false));
;
?>/images/kubrickbg-<?php bloginfo(array('text_direction',false));
;
?>.jpg") repeat-y top; border: none; }
<?php }else 
{{;
?>
	#page { background: url("<?php bloginfo(array('stylesheet_directory',false));
;
?>/images/kubrickbgwide.jpg") repeat-y top; border: none; }
<?php }};
?>

</style>

<?php if ( deAspis(is_singular()))
 wp_enqueue_script(array('comment-reply',false));
;
?>

<?php wp_head();
;
?>
</head>
<body <?php body_class();
;
?>>
<div id="page">


<div id="header" role="banner">
	<div id="headerimg">
		<h1><a href="<?php echo AspisCheckPrint(get_option(array('home',false)));
;
?>/"><?php bloginfo(array('name',false));
;
?></a></h1>
		<div class="description"><?php bloginfo(array('description',false));
;
?></div>
	</div>
</div>
<hr />
<?php 