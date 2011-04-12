<h1><?php echo $_SESSION['wpsqt']['current_name']; ?></h1>

<?php if ( isset($errors) && !empty($errors) ){ ?>
<ul>
	<?php foreach ($errors as $error){ ?>
	<li><?php echo $error; ?></li>
	<?php } ?>
</ul>
<?php }?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<?php foreach($fields as $field){ ?>
		<tr>
			<th><?php echo $field['name']; if ($field['required'] == 'yes'){?> <font color="#FF0000">*</font><?php } ?></th>
			<td>
		<?php if ($field['type'] == 'text'){?>
			<input type="text" name="<?php echo $field['name']; ?>" value="" />
		<?php } else { ?>
			<textarea name="<?php echo $field['name']; ?>" rows="4" cols="40"></textarea>
		<?php } ?>
			</td>
		</tr>	
	<?php } ?>
	</table>
	<p><input type='submit' value='Next &raquo;' class='button-secondary' /></p>
</form>

