<?php
	global $vasthtml, $forum_instance;

	if (!empty($forum_instance) && $forum_instance === true) {
		return false;
	}
	
	if($user_ID || $this->allow_unreg()){
	$options = get_option("vasthtml_options");
	$this->current_view = NEWTOPIC;
	$out = $this->header();
	
	$out .= "<form action='".WPFURL."wpf-insert.php' name='addform' method='post'>";
	$out .= "<table class='wpf-table' width='100%'>
			<tr>
				<th colspan='2'>".__("Post new Topic", "vasthtml")."</th>
			</tr>
			<tr>	
				<td>".__("Subject:", "vasthtml")."</td>
				<td><input type='text' name='add_topic_subject' /></td>
			</tr>
			<tr>	
				<td valign='top'>".__("Message:", "vasthtml")."</td>
				<td>
					".$this->form_buttons()."

					<br /><textarea ".ROW_COL." name='message' ></textarea>
				</td>
			</tr>";
			
				$out .= $this->get_captcha();

			$out .= "<tr>
				<td></td>
				<td><input type='submit' name='add_topic_submit' value='".__("Submit", "vasthtml")."' /></td>
				<input type='hidden' name='add_topic_forumid' value='".$this->check_parms($_GET['forum'])."'/>
				<input type='hidden' name='add_topic_plink' value='".get_permalink($this->page_id)."'/>
			</tr>

			</table></form>";
		$this->o .= $out;
	}
	else
		wp_die(__("Sorry. you don't have permission to post.", "vasthtml"))
?>