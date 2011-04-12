<?php 
session_start();
global $wpdb, $vasthtml, $user_ID, $user_level;

$error = false;
$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
	} else {
	// before WP 2.6
	require_once($root.'/wp-config.php');
	}
	$vasthtml->setup_linksdk($_POST['add_topic_plink']);
	$options = get_option("vasthtml_options");

	if($options['forum_captcha'] == true && !$user_ID){
   		if(($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code'])) ) {
    	  unset($_SESSION['security_code']);
  	 	}
		else {
			$error = true;
			$msg = __("Security code does not mach", "vasthtml");
		}
	}
	 
	if(isset($_POST['add_topic_submit'])){
		$subject = $vasthtml->input_filter($_POST['add_topic_subject']);
		$content = $vasthtml->input_filter($_POST['message']);
		$forum_id = $vasthtml->check_parms($_POST['add_topic_forumid']);
		
		if($subject == ""){
			$msg .= "<h2>".__("An error occured", "vasthtml")."</h2>";
			$msg .= ("<div id='error'><p>".__("You must enter a subject", "vasthtml")."</p></div>");
			$error = true;
		}
		elseif($content == ""){
			$msg .=  "<h2>".__("An error occured", "vasthtml")."</h2>";
			$msg .=  ("<div id='error'><p>".__("You must enter a message", "vasthtml")."</p></div>");
			$error = true;
		}
		else{
			$date = date("Y-m-d H:i:s", time());

			$sql_thread = "INSERT INTO $vasthtml->t_threads 
					(last_post, subject, parent_id, `date`, status, starter) 
			 VALUES('$date', '".stripslashes($subject)."', '$forum_id', '$date', 'open', '$user_ID')";
			
			$wpdb->query($sql_thread);
			
		$id=$wpdb->insert_id; 
			$sql_post = "INSERT INTO $vasthtml->t_posts 
						(text, parent_id, `date`, author_id, subject)
				 VALUES('".stripslashes($content)."', '$id', '$date', '$user_ID', '".stripslashes($subject)."')";
			$wpdb->query($sql_post);
		}
		if(!$error){
			if ($options['forum_seo_urls']) {
				header("Location: ".html_entity_decode($vasthtml->get_forumlink($forum_id))); exit;
			} else {
				header("Location: ".html_entity_decode($vasthtml->get_forumlink($forum_id)."0")); exit;
			}
		}
		else	
			wp_die($msg);

	}
	if(isset($_POST['add_post_submit'])){
		$subject = $vasthtml->input_filter($_POST['add_post_subject']);
		$content = $vasthtml->input_filter($_POST['message']);
		
		$thread = $vasthtml->check_parms($_POST['add_post_forumid']);
		
		if($subject == ""){
			$msg .= "<h2>".__("An error occured", "vasthtml")."</h2>";
			$msg .= ("<div id='error'><p>".__("You must enter a subject", "vasthtml")."</p></div>");
			$error = true;
		}
		elseif($content == ""){
			$msg .=  "<h2>".__("An error occured", "vasthtml")."</h2>";
			$msg .=  ("<div id='error'><p>".__("You must enter a message", "vasthtml")."</p></div>");
			$error = true;
		}
		else{
			$date = date("Y-m-d H:i:s", time());
			
			$sql_post = "INSERT INTO $vasthtml->t_posts 
						(text, parent_id, `date`, author_id, subject)
				 VALUES('".stripslashes($content)."', '$thread', '$date', '$user_ID', '".stripslashes($subject)."')";
			$wpdb->query($sql_post);
			$wpdb->query("UPDATE $vasthtml->t_threads SET last_post = '$date' WHERE id = $thread");
			
		}
			
		if(!$error){
			$vasthtml->notify_starter($thread, stripslashes($subject), stripslashes($content), $date);
			$page = $_POST['add_topic_page'] ? $_POST['add_topic_page'] : 0;

			$count = $wpdb->get_var("SELECT count(*) FROM $vasthtml->t_posts WHERE parent_id = $thread");
			$page = floor(($count-1)/$vasthtml->opt['forum_posts_per_page']);
			

			if ($options[forum_seo_urls]) {
				header("Location: ".html_entity_decode($vasthtml->get_threadlink($thread).".".$page)); exit;
			} else {
				header("Location: ".html_entity_decode($vasthtml->get_threadlink($thread).$page)); exit;
			}
		}
		else	
			wp_die($msg);

	}
	if(isset($_POST['edit_post_submit'])){
		$subject = $vasthtml->input_filter($_POST['edit_post_subject']);
		$content = $vasthtml->input_filter($_POST['message']);
		$thread = $vasthtml->check_parms($_POST['thread_id']);
		$edit_post_id = $_POST['edit_post_id'];
		
		if($subject == ""){
			$msg .= "<h2>".__("An error occured", "vasthtml")."</h2>";
			$msg .= ("<div id='error'><p>".__("You must enter a subject", "vasthtml")."</p></div>");
			$error = true;
		}
		elseif($content == ""){
			$msg .=  "<h2>".__("An error occured", "vasthtml")."</h2>";
			$msg .=  ("<div id='error'><p>".__("You must enter a message", "vasthtml")."</p></div>");
			$error = true;
		}
		$sql = ("UPDATE $vasthtml->t_posts SET text = '".stripslashes($content)."', subject = '".stripslashes($subject)."' WHERE id = $edit_post_id");
		$wpdb->query($sql);
		
		if(!$error){
			$page = $_POST['edit_topic_page'] ? $_POST['edit_topic_page'] : 0;
			if ($options[forum_seo_urls]) {
				header("Location: ".html_entity_decode($vasthtml->get_threadlink($thread).".".$page)); exit;
			} else {
				header("Location: ".html_entity_decode($vasthtml->get_threadlink($thread).$page)); exit;
			}
		} else
			wp_die($msg);
	}
	
?>








