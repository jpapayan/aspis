<?php require_once('AspisMain.php'); ?><?php
require_once ('admin.php');
if ( (denot_boolean(current_user_can(array('edit_files',false)))))
 wp_die(__(array('You do not have sufficient permissions to import content in this blog.',false)));
$title = __(array('Import',false));
require_once ('admin-header.php');
$parent_file = array('tools.php',false);
;
?>

<div class="wrap">
<?php screen_icon();
;
?>
<h2><?php echo AspisCheckPrint(esc_html($title));
;
?></h2>
<p><?php _e(array('If you have posts or comments in another system, WordPress can import those into this blog. To get started, choose a system to import from below:',false));
;
?></p>

<?php $import_loc = array('wp-admin/import',false);
$import_root = concat1(ABSPATH,$import_loc);
$imports_dir = @attAspis(opendir($import_root[0]));
if ( $imports_dir[0])
 {while ( (deAspis(($file = attAspis(readdir($imports_dir[0])))) !== false) )
{if ( (deAspis(attachAspis($file,(0))) == ('.')))
 {continue ;
}elseif ( (deAspis(Aspis_substr($file,negate(array(4,false)))) == ('.php')))
 {require_once (deconcat(concat2($import_root,'/'),$file));
}}}@closedir($imports_dir[0]);
$importers = get_importers();
if ( ((empty($importers) || Aspis_empty( $importers))))
 {echo AspisCheckPrint(concat2(concat1('<p>',__(array('No importers are available.',false))),'</p>'));
}else 
{{;
?>
<table class="widefat" cellspacing="0">

<?php $style = array('',false);
foreach ( $importers[0] as $id =>$data )
{restoreTaint($id,$data);
{$style = ((('class="alternate"') == $style[0]) || (('class="alternate active"') == $style[0])) ? array('',false) : array('alternate',false);
$action = concat(concat(concat2(concat1("<a href='admin.php?import=",$id),"' title='"),wptexturize(Aspis_strip_tags(attachAspis($data,(1))))),concat2(concat1("'>",attachAspis($data,(0))),"</a>"));
if ( ($style[0] != ('')))
 $style = concat2(concat1('class="',$style),'"');
echo AspisCheckPrint(concat2(concat(concat2(concat(concat2(concat1("
			<tr ",$style),">
				<td class='import-system row-title'>"),$action),"</td>
				<td class='desc'>"),attachAspis($data,(1))),"</td>
			</tr>"));
}};
?>

</table>
<?php }};
?>

</div>

<?php include ('admin-footer.php');
;
?>

<?php 