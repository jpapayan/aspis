<?php

$root = dirname(dirname(dirname(dirname(__FILE__))));
if (file_exists($root.'/wp-load.php')) {
	// WP 2.6
	require_once($root.'/wp-load.php');
	} else {
	// before WP 2.6
	require_once($root.'/wp-config.php');
	}

function f_dummy1() {

global $wpdb, $vasthtml, $user_ID, $user_level;

	$vasthtml->setup_links();		
	
	
	//if($_GET['topic'] != "all" || !is_numeric($_GET['topic']))
	//	return false;
		
	$topic = $_GET['topic'];

	if($topic == "all"){
		$posts = $wpdb->get_results("SELECT * FROM $vasthtml->t_posts ORDER BY `date` DESC LIMIT 20 ");
		$count_posts = $wpdb->get_var($wpdb->prepare("SELECT * FROM $vasthtml->t_posts"));
		$title = get_bloginfo('name')."".__("Forum Feed", "vasthtml")."";
		$description = __("Forum Feed", "vasthtml");

	}
	else{
		$posts = $wpdb->get_results("SELECT * FROM $vasthtml->t_posts WHERE parent_id = $topic ORDER BY `date` DESC LIMIT 20 ");
		$count_posts = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $vasthtml->t_posts WHERE parent_id = $topic"));
		$description = __("Forum Topic:", "vasthtml")." - ".$vasthtml->get_subject($topic);
		$title = get_bloginfo('name')." ".__("Forum", "vasthtml")." - ".__("Topic: ", "vasthtml")." ".$vasthtml->get_subject($topic);

	}

	$link = $vasthtml->home_url;
		header ("Content-type: application/rss+xml");    

		echo ("<?xml version=\"1.0\" encoding=\"".get_bloginfo('charset')."\"?>\n");?>
		<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
		<channel>
		<title><?php echo $title;?> </title>
		<description><?php bloginfo('name'); echo $description;?></description>
		<link><?php echo $link;?></link>
		<language><?php bloginfo('language');?></language>
		<?php

		$pagenum = 0;
		$num_pages = ceil($count_posts / $vasthtml->opt['forum_posts_per_page']);

		foreach($posts as $i => $post){

			$link = $vasthtml->get_rss_threadlink($post->parent_id);

			if ($count_posts > $vasthtml->opt['forum_posts_per_page']) {
				$tmp = $count_posts / $vasthtml->opt['forum_posts_per_page'];
				$frac = $tmp - floor($tmp);

				$last_posts = floor($vasthtml->opt['forum_posts_per_page'] * $frac);
				if ($i < $last_posts) {
					$pagenum = $num_pages - 1;
				} else {
					$pagenum = $num_pages - 1 - ceil(($i - $last_posts + 1) / $vasthtml->opt['forum_posts_per_page']);
				}
			}
			$user = get_userdata($post->author_id);
			//$title = __("Topic:", "vasthtml")." ".$vasthtml->get_subject($post->parent_id);
			$title = $post->subject;
			$link = $link.'.'.$pagenum.'#postid-'.$post->id;
			?>
			<item>
			<guid><?= $link."&amp;guid=$post->id" ?></guid>
			<link><?= $link ?></link>
			<title><?= htmlspecialchars($title) ?></title>
			<pubDate><?= date("r", strtotime($post->date)) ?></pubDate>
			<description><?= htmlspecialchars($vasthtml->output_filter($post->text, ENT_NOQUOTES)) ?></description>
			</item>		
			<?php } ?>
		</channel>
		</rss>
<?php } 
f_dummy1();
 ?>
