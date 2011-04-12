<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Options</h2>	
	
	<?php if ( isset($successMessage) ){ ?>
		<div class="updated" id="question_added"><?php echo $successMessage; ?></div>
	<?php } ?>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	
	<p>Our preferred method of contacting us is though the forums on wordpress.org however if you don't have an account or for some other reason can't or don't want to use that method we have provided a form below that will be emailed to us.</p>
	
	<p><strong>Please note that using the below form will result in information such as your current wordpress version and plugin version being sent aswell.</strong>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		
		<table class="form-table">
			<tr>
				<th scope="row">Name</th>
				<td><input type="text" name="name" value="" /></td>
			</tr>
			<tr>
				<th scope="row">Email</th>
				<td><input type="text" name="email" value="" /></td>
			</tr>
			<tr>
				<th scope="row">Contact Reason</th>
				<td><select name="reason">
						<option value="Bug">Bug</option>
						<option value="Suggestion">Suggestion</option>
						<option value="You guys rock">You guys rock</option>
						<option value="You guys are the suck!!!">You guys are the suck</option>
				</select></td>
			</tr>
			<tr>
				<th valign="top" scope="row">Message</th>
				<td><textarea cols="70" rows="5" name="message"></textarea></td>
			</tr>
		</table>
	
		<p class="submit">
			<input class="button-primary" type="submit" name="Send" value="Send" id="submitbutton" />
		</p>
		
	</form>
	
</div>	