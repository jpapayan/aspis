<h1><?php echo $_SESSION['wpsqt']['current_name']; ?></h1>

<?php if ( isset($errors) && !empty($errors) ){ ?>
<ul>
	<?php foreach ($errors as $error){ ?>
	<li><?php echo $error; ?></li>
	<?php } ?>
</ul>
<?php }?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<input type="hidden" name="step" value="<?php echo ++$_SESSION['wpsqt']['current_step']; ?>" />
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td>Name <font color="#FF0000">*</font></td>
			<td><input type="text" name="user_name" value="" /></td>
		</tr>
		<tr>
			<td scope="row">E-Mail <font color="#FF0000">*</font></td>
			<td><input type="text" name="email" value="" /></td>
		</tr>
		<tr>
			<td scope="row">Phone <font color="#FF0000">*</font></td>
			<td><input type="text" name="phone" value="" /></td>
		</tr>
		<tr>
			<td scope="row">Heard of us from?</td>
			<td><input type="text" name="heard" value="" /></td>
		</tr>
		<tr>
			<td scope="row">Address <font color="#FF0000">*</font></td>
			<td><textarea rows="5" cols="30" name="address"></textarea></td>
		</tr>
		<tr>
			<td scope="row">Extra Notes <font color="#FF0000">*</font></td>
			<td><textarea rows="5" cols="30" name="notes"></textarea></td>
		</tr>
	</table>
	<p><input type='submit' value='Next &raquo;' class='button-secondary' /></p>
</form>