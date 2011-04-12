<?php
/*
Plugin Name: WordPress Related Posts
Version: 1.2
Plugin URI: http://fairyfish.net/2007/09/12/wordpress-23-related-posts-plugin/
Description: Generate a related posts list via tags of WordPress
Author: Denis
Author URI: http://fairyfish.net/
*/

add_action('init', 'init_textdomain');
function init_textdomain(){
  load_plugin_textdomain('wp_related_posts',PLUGINDIR . '/' . dirname(plugin_basename (__FILE__)) . '/lang');
}

function wp_get_related_posts($before_title="",$after_title="") {	
	global $wpdb, $post;
	$wp_rp = get_option("wp_rp");
	
	$wp_rp_title = $wp_rp["wp_rp_title"];
	
	$exclude = explode(",",$wp_rp["wp_rp_exclude"]);	
	if ( $exclude != '' ) {
		$q = 'SELECT tt.term_id FROM '. $wpdb->term_taxonomy.'  tt, ' . $wpdb->term_relationships.' tr WHERE tt.taxonomy = \'category\' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id = '.$post->ID;

		$cats = $wpdb->get_results($q);
		
		foreach(($cats) as $cat) {
			if (in_array($cat->term_id, $exclude) != false){
				return;
			}
		}
	}
		
	if(!$post->ID){return;}
	$now = current_time('mysql', 1);
	$tags = wp_get_post_tags($post->ID);
	
	$taglist = "'" . $tags[0]->term_id. "'";
	
	$tagcount = count($tags);
	if ($tagcount > 1) {
		for ($i = 1; $i < $tagcount; $i++) {
			$taglist = $taglist . ", '" . $tags[$i]->term_id . "'";
		}
	}
	
	$limit = $wp_rp["wp_rp_limit"];
	if ($limit) {
		$limitclause = "LIMIT $limit";
	}	else {
		$limitclause = "LIMIT 10";
	}
	
	$q = "SELECT p.ID, p.post_title, p.post_content,p.post_excerpt, p.post_date,  p.comment_count, count(t_r.object_id) as cnt FROM $wpdb->term_taxonomy t_t, $wpdb->term_relationships t_r, $wpdb->posts p WHERE t_t.taxonomy ='post_tag' AND t_t.term_taxonomy_id = t_r.term_taxonomy_id AND t_r.object_id  = p.ID AND (t_t.term_id IN ($taglist)) AND p.ID != $post->ID AND p.post_status = 'publish' AND p.post_date_gmt < '$now' GROUP BY t_r.object_id ORDER BY cnt DESC, p.post_date_gmt DESC $limitclause;";
	
	$related_posts = $wpdb->get_results($q);
	
	$output = "";
	
	if (!$related_posts){
		$wp_no_rp = $wp_rp["wp_no_rp"];
		$wp_no_rp_text = $wp_rp["wp_no_rp_text"];
	
		if(!$wp_no_rp || ($wp_no_rp == "popularity" && !function_exists('akpc_most_popular'))) $wp_no_rp = "text";
		
		if($wp_no_rp == "text"){
			if(!$wp_no_rp_text) $wp_no_rp_text= __("No Related Post",'wp_related_posts');
			$output  .= '<li>'.$wp_no_rp_text .'</li>';
		}	else{
			if($wp_no_rp == "random"){
				if(!$wp_no_rp_text) $wp_no_rp_text= __("Random Posts",'wp_related_posts');
				$related_posts = wp_get_random_posts($limitclause);
			}	elseif($wp_no_rp == "commented"){
				if(!$wp_no_rp_text) $wp_no_rp_text= __("Most Commented Posts",'wp_related_posts');
				$related_posts = wp_get_most_commented_posts($limitclause);
			}	elseif($wp_no_rp == "popularity"){
				if(!$wp_no_rp_text) $wp_no_rp_text= __("Most Popular Posts",'wp_related_posts');
				$related_posts = wp_get_most_popular_posts($limitclause);
			}
			$wp_rp_title = $wp_no_rp_text;
		}
	}
	
	foreach ($related_posts as $related_post ){
		$output .= '<li>';
		
		if ($wp_rp["wp_rp_thumbnail"]){
			$output .=  '<a href="'.get_permalink($related_post->ID).'" title="'.wptexturize($related_post->post_title).'"><img src="'.get_post_meta($related_post->ID, $wp_rp["wp_rp_thumbnail_post_meta"], true).'" alt="'.wptexturize($related_post->post_title).'" /></a>';
		}
		
		if ((!$wp_rp["wp_rp_thumbnail"])||($wp_rp["wp_rp_thumbnail"] && $wp_rp["wp_rp_thumbnail_text"])){
		
			if ($wp_rp["wp_rp_date"]){
				$dateformat = get_option('date_format');
				$output .= mysql2date($dateformat, $related_post->post_date) . " -- ";
			}
			
			$output .=  '<a href="'.get_permalink($related_post->ID).'" title="'.wptexturize($related_post->post_title).'">'.wptexturize($related_post->post_title).'</a>';
			
			if ($wp_rp["wp_rp_comments"]){
				$output .=  " (" . $related_post->comment_count . ")";
			}
			
			if ($wp_rp["wp_rp_except"]){
				$wp_rp_except_number = trim($wp_rp["wp_rp_except_number"]);
				if(!$wp_rp_except_number) $wp_rp_except_number = 200;
				if($related_post->post_excerpt){
					$output .= '<br /><small>'.(mb_substr(strip_tags($related_post->post_excerpt),0,$wp_rp_except_number)).'...</small>';
				}else{
					$output .= '<br /><small>'.(mb_substr(strip_tags($related_post->post_content),0,$wp_rp_except_number)).'...</small>';
				}
			}	
		}
		$output .=  '</li>';
	}
	
	$output = '<ul class="related_post">' . $output . '</ul>';
		
	$wp_rp_title_tag = $wp_rp["wp_rp_title_tag"];
	if($before_title){
		if($wp_rp_title != '') $output = $before_title.$wp_rp_title .$after_title. $output;
	}else{
		if(!$wp_rp_title_tag) $wp_rp_title_tag ='h3';
		if($wp_rp_title != '') $output =  '<'.$wp_rp_title_tag.'  class="related_post_title">'.$wp_rp_title .'</'.$wp_rp_title_tag.'>'. $output;
	}
	
	return $output;
}

function wp_related_posts(){
	
	$output = wp_get_related_posts() ;

	echo $output;
}

function wp23_related_posts() {
	wp_related_posts();
}

function wp_related_posts_auto($content){
	$wp_rp = get_option("wp_rp");
	if ((is_single() && $wp_rp["wp_rp_auto"])||(is_feed() && $wp_rp["wp_rp_rss"])) {
		$output = wp_get_related_posts();
		$content = $content . $output;
	}
	
	return $content;
}

add_filter('the_content', 'wp_related_posts_auto',99);

function wp_get_random_posts ($limitclause="") {
    global $wpdb, $post;
		
	$q = "SELECT ID, post_title, post_content,post_excerpt, post_date, comment_count FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND ID != $post->ID ORDER BY RAND() $limitclause";
    return $wpdb->get_results($q);
}

function wp_random_posts ($number = 10){
	$limitclause="LIMIT " . $number;
	$random_posts = wp_get_random_posts ($limitclause);
	
	foreach ($random_posts as $random_post ){
		$output .= '<li>';
		
		$output .=  '<a href="'.get_permalink($random_post->ID).'" title="'.wptexturize($random_post->post_title).'">'.wptexturize($random_post->post_title).'</a></li>';
	}
	
	$output = '<ul class="randome_post">' . $output . '</ul>';
	
	echo $output;
}

function wp_get_most_commented_posts($limitclause="") {
	global $wpdb; 
	$q = "SELECT ID, post_title, post_content, post_excerpt, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC $limitclause"; 
    return $wpdb->get_results($q);
} 

function wp_most_commented_posts ($number = 10){
	$limitclause="LIMIT " . $number;
	$most_commented_posts = wp_get_most_commented_posts ($limitclause);
	
	foreach ($most_commented_posts as $most_commented_post ){
		$output .= '<li>';
		
		$output .=  '<a href="'.get_permalink($most_commented_post->ID).'" title="'.wptexturize($most_commented_post->post_title).'">'.wptexturize($most_commented_post->post_title).'</a></li>';
	}
	
	$output = '<ul class="most_commented_post">' . $output . '</ul>';
	
	echo $output;
}

function wp_get_most_popular_posts ($limitclause="") {
    global $wpdb, $table_prefix;
		
	$q = $sql = "SELECT p.ID, p.post_title, p.post_content,p.post_excerpt, p.post_date, p.comment_count FROM ". $table_prefix ."ak_popularity as akpc,".$table_prefix ."posts as p WHERE p.ID = akpc.post_id ORDER BY akpc.total DESC $limitclause";;
    return $wpdb->get_results($q);
}

function wp_most_popular_posts ($number = 10){
	$limitclause="LIMIT " . $number;
	$most_popular_posts = wp_get_most_popular_posts ($limitclause);
	
	foreach ($most_popular_posts as $most_popular_post ){
		$output .= '<li>';
		
		$output .=  '<a href="'.get_permalink($most_popular_post->ID).'" title="'.wptexturize($most_popular_post->post_title).'">'.wptexturize($most_popular_post->post_title).'</a></li>';
	}
	
	$output = '<ul class="most_popular_post">' . $output . '</ul>';
	
	echo $output;
}

add_action('plugins_loaded', 'widget_sidebar_wp_related_posts');
function widget_sidebar_wp_related_posts() {
	function widget_wp_related_posts($args) {
	    extract($args);
		if(!is_single()) return;
		echo $before_widget;
		
		//echo $before_title . $wp_rp["wp_rp_title"] . $after_title;
		$output = wp_get_related_posts($before_title,$after_title);
		echo $output;
		echo $after_widget;
	}
	register_sidebar_widget('Related Posts', 'widget_wp_related_posts');
}

add_action('admin_menu', 'wp_add_related_posts_options_page');

function wp_add_related_posts_options_page() {
	if (function_exists('add_options_page')) {
		add_options_page( __('Related Posts','wp_related_posts'), __('Related Posts','wp_related_posts'), 8, basename(__FILE__), 'wp_related_posts_options_subpanel');
	}
}

function wp_related_posts_options_subpanel() {
	if($_POST["wp_rp_Submit"]){
		$message = __("WordPress Related Posts Setting Updated",'wp_related_posts');
	
		$wp_rp_saved = get_option("wp_rp");
	
		$wp_rp = array (
			"wp_rp_title" 			=> trim($_POST['wp_rp_title_option']),
			"wp_rp_title_tag"		=> trim($_POST['wp_rp_title_tag_option']),
			"wp_no_rp"				=> trim($_POST['wp_no_rp_option']),
			"wp_no_rp_text"			=> trim($_POST['wp_no_rp_text_option']),
			"wp_rp_except"			=> trim($_POST['wp_rp_except_option']),
			"wp_rp_except_number"	=> trim($_POST['wp_rp_except_number_option']),
			"wp_rp_limit"			=> trim($_POST['wp_rp_limit_option']),
			'wp_rp_exclude'			=> trim($_POST['wp_rp_exclude_option']),
			'wp_rp_auto'			=> trim($_POST['wp_rp_auto_option']),
			'wp_rp_rss'				=> trim($_POST['wp_rp_rss_option']),
			'wp_rp_comments'		=> trim($_POST['wp_rp_comments_option']),
			'wp_rp_date'			=> trim($_POST['wp_rp_date_option']),
			'wp_rp_thumbnail'		=> trim($_POST['wp_rp_thumbnail_option']),
			'wp_rp_thumbnail_text'	=> trim($_POST['wp_rp_thumbnail_text_option']),
			'wp_rp_thumbnail_post_meta'	=> trim($_POST['wp_rp_thumbnail_post_meta_option'])
		);
		
		if ($wp_rp_saved != $wp_rp)
			if(!update_option("wp_rp",$wp_rp))
				$message = "Update Failed";
		
		echo '<div id="message" class="updated fade"><p>'.$message.'.</p></div>';
	}
	
	$wp_rp = get_option("wp_rp");
?>
    <div class="wrap">
	<?php 
		$wp_no_rp = $wp_rp["wp_no_rp"];
		$wp_rp_title_tag = $wp_rp["wp_rp_title_tag"];
	?>
		<script type='text/javascript'>
		function wp_no_rp_onchange(){
			var wp_no_rp = document.getElementById('wp_no_rp');
			var wp_no_rp_title = document.getElementById('wp_no_rp_title');
			var wp_no_rp_text = document.getElementById('wp_no_rp_text');
			switch(wp_no_rp.value){
			case 'text':
				wp_no_rp_title.innerHTML = '<?php _e("No Related Posts Text:",'wp_related_posts'); ?>';
				wp_no_rp_text.value = '<?php _e("No Related Posts",'wp_related_posts'); ?>';
				break;
			case 'random':
				wp_no_rp_title.innerHTML = '<?php _e("Random Posts Title:",'wp_related_posts'); ?>';
				wp_no_rp_text.value = '<?php _e("Random Posts",'wp_related_posts'); ?>';
				break;
			case 'commented':
				wp_no_rp_title.innerHTML = '<?php _e("Most Commented Posts Title:",'wp_related_posts'); ?>';
				wp_no_rp_text.value = '<?php _e("Most Commented Posts",'wp_related_posts'); ?>';
				break;
			case 'popularity':
				wp_no_rp_title.innerHTML = '<?php _e("Most Popular Posts Title:",'wp_related_posts'); ?>';
				wp_no_rp_text.value = '<?php _e("Most Popular Posts",'wp_related_posts'); ?>';
				break;
			default:
				wp_no_rp_title.innerHTML = '';
			}
			if(wp_no_rp.value == '<?php echo $wp_no_rp;?>'){
				wp_no_rp_text.value = '<?php echo $wp_rp["wp_no_rp_text"];?>';
			}
		}
		function wp_rp_except_onclick(){
			var wp_rp_except = document.getElementById('wp_rp_except');
			var wp_rp_except_number_label = document.getElementById('wp_rp_except_number_label');
			if(wp_rp_except.checked){
				wp_rp_except_number_label.style.display = '';
			} else {
				wp_rp_except_number_label.style.display = 'none';
			}
		}
		function wp_rp_thumbnail_onclick(){
			var wp_rp_thumbnail = document.getElementById('wp_rp_thumbnail');
			var wp_rp_thumbnail_span = document.getElementById('wp_rp_thumbnail_span');
			if(wp_rp_thumbnail.checked){
				wp_rp_thumbnail_span.style.display = '';
			} else {
				wp_rp_thumbnail_span.style.display = 'none';
			}
		}
		</script>
		
		<h2><?php _e("Related Posts Settings",'wp_related_posts');?></h2>
		<p><?php _e("<a href=\"http://fairyfish.net/2007/09/12/wordpress-23-related-posts-plugin/\">WordPress Related Posts </a>Plugin can generate a related posts list via WordPress tags, and add the related posts to feed.",'wp_related_posts');?> </p> 
		<?php _e("Any problem or need help, please contact ",'wp_related_posts');?><a href="mailto:denishua@hotmail.com">denishua</a>.</p>
		
		<div>
		<span style="font-size:16px; height:30px; line-height:30px; padding:0 10px;"> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8490579"><?php _e("Do you like this Plugin? Consider to donate!",'wp_related_posts');?></a></span> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8490579"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" align="left" /></a>
		</div>
		
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo basename(__FILE__); ?>">
		<h3><?php _e("Basic Setting",'wp_related_posts');?></h3>
        <table class="form-table">
          <tr valign="top">
			<th scope="row"><label for="wp_rp_title"><?php _e("Related Posts Title:",'wp_related_posts'); ?></label></th>
            <td>
              <input name="wp_rp_title_option" type="text" id="wp_rp_title"  value="<?php echo $wp_rp["wp_rp_title"]; ?>" class="regular-text" />
            </td>
          </tr>
		  <tr valign="top">
			<th scope="row"><label for="wp_rp_title_tag"><?php _e("Related Posts Title Tag:",'wp_related_posts'); ?></label></th>
            <td>
				<select name="wp_rp_title_tag_option" id="wp_rp_title_tag" class="postform">
				<?php
				$wp_rp_title_tag_array = array('h2','h3','h4','p','div');
				foreach ($wp_rp_title_tag_array as $wp_rp_title_tag_a){
				?>
					<option value="<?php echo $wp_rp_title_tag_a; ?>" <?php if($wp_rp_title_tag == $wp_rp_title_tag_a) echo 'selected' ?> >&lt;<?php echo $wp_rp_title_tag_a; ?>&gt;</option>
				<?php 
				}
				?>
				</select>
            </td>
          </tr>
		  <tr valign="top">
			<th scope="row"><label for="wp_rp_limit"><?php _e("Maximum Number:",'wp_related_posts');?></label></th>
            <td>
              <input name="wp_rp_limit_option" type="text" id="wp_rp_limit" value="<?php echo $wp_rp["wp_rp_limit"]; ?>" />
            </td>
          </tr>
		  <tr valign="top">
            <th scope="row"><label for="wp_rp_exclude"><?php _e("Exclude(category IDs):",'wp_related_posts');?></label></th>
            <td>
              <input name="wp_rp_exclude_option" type="text" id="wp_rp_exclude" value="<?php echo $wp_rp["wp_rp_exclude"]; ?>" /> <span class="description"><?php _e('Enter category IDs of the posts which you don\'t want to display related posts for them. ','wp_related_posts'); ?></span>
            </td>
          </tr>
		  <tr valign="top">
			<th scope="row"><?php _e("Other Setting:",'wp_related_posts'); ?></th>
			<td>
				<label>
				<input name="wp_rp_comments_option" type="checkbox" id="wp_rp_comments" value="yes"  <?php echo ($wp_rp["wp_rp_comments"] == 'yes') ? 'checked' : ''; ?>>
				<?php _e("Display Comments Count?",'wp_related_posts');?>
				</label>
				<br /> 
				<label>
				<input name="wp_rp_date_option" type="checkbox" id="wp_rp_date" value="yes"  <?php echo ($wp_rp["wp_rp_date"] == 'yes') ? 'checked' : ''; ?>>
				<?php _e("Display Pubilsh Date?",'wp_related_posts');?>
				</label>
				<br />
				<label>
				<input name="wp_rp_auto_option" type="checkbox" id="wp_rp_auto" value="yes"  <?php echo ($wp_rp["wp_rp_auto"] == 'yes') ? 'checked' : ''; ?>>
				<?php _e("Auto Insert Related Posts?",'wp_related_posts');?>
				</label>
				<br />
				<label>
				<input name="wp_rp_rss_option" type="checkbox" id="wp_rp_rss" value="yes"  <?php echo ($wp_rp["wp_rp_rss"] == 'yes') ? 'checked' : ''; ?>>
				<?php _e("Display Related Posts on Feed?",'wp_related_posts');?>
				</label>
            </td>
          </tr>
		  <tr valign="top">
			<th scope="row"><label for="wp_rp_except"><?php _e("Except Setting:",'wp_related_posts'); ?></label></th>
			<td>
				<label>
				<input name="wp_rp_except_option" type="checkbox" id="wp_rp_except" value="yes" <?php echo ($wp_rp["wp_rp_except"] == 'yes') ? 'checked' : ''; ?> onclick="wp_rp_except_onclick();" >
				<?php _e("Display Post Except?",'wp_related_posts');?>
				</label>
				<br />
				<label id="wp_rp_except_number_label" style="<?php echo ($wp_rp["wp_rp_except"] == 'yes') ? '' : 'display:none;'; ?>">
				<input name="wp_rp_except_number_option" type="text" id="wp_rp_except_number" value="<?php echo ($wp_rp["wp_rp_except_number"]); ?> "  /> <span class="description"><?php _e('Maximum Charaters of Except.','wp_related_posts'); ?></span>
				</label>
            </td>
          </tr>
		  </table>
		  <h3><?php _e("No Related Post Setting",'wp_related_posts');?></h3>
		  <table class="form-table">
          <tr valign="top">
            <th scope="row"><label for="wp_no_rp"><?php _e("Display:",'wp_related_posts'); ?></label></th>
            <td>
				<select name="wp_no_rp_option" id="wp_no_rp" onchange="wp_no_rp_onchange();"  class="postform">
					<option value="text" <?php if($wp_no_rp == 'text') echo 'selected' ?> ><?php _e("Text: 'No Related Posts'",'wp_related_posts'); ?></option>
					<option value="random" <?php if($wp_no_rp == 'random') echo 'selected' ?>><?php _e("Random Posts",'wp_related_posts'); ?></option>
					<option value="commented" <?php if($wp_no_rp == 'commented') echo 'selected' ?>><?php _e("Most Commented Posts",'wp_related_posts'); ?></option>
					<?php if (function_exists('akpc_most_popular')){ ?>
					<option value="popularity" <?php if($wp_no_rp == 'popularity') echo 'selected' ?>><?php _e("Most Popular Posts",'wp_related_posts'); ?></option>
					<?php } ?> 
				</select>
            </td>
          </tr>
          <tr valign="top" scope="row">
			<th id="wp_no_rp_title" scope="row"><label for="wp_no_rp_text">
			<?php 
			switch ($wp_no_rp){
				case 'text':
					_e("No Related Posts Text:",'wp_related_posts'); 
					break;
				case 'random':
					_e("Random Posts Title:",'wp_related_posts'); 
					break;
				case 'commented':
					_e("Most Commented Posts Title:",'wp_related_posts'); 
					break;
				case 'popularity':
					_e("Most Popular Posts Title:",'wp_related_posts'); 
					break;
			}
			?>
			</label></th>
            <td>
              <input name="wp_no_rp_text_option" type="text" id="wp_no_rp_text" value="<?php echo $wp_rp["wp_no_rp_text"]; ?>" class="regular-text" />
            </td>	
          </tr>
        </table>
		<h3><?php _e("Related Posts with Thumbnail",'wp_related_posts');?></h3>
		  <table class="form-table">
		  <tr valign="top">
			<th colspan="2">
				<?php _e("Befor usting Related Posts with Thumbnail, you must set thumbnail image for your every post.",'wp_related_posts'); ?>
			</th>
		  </tr>
          <tr valign="top">
            <th scope="row"><label for="wp_rp_thumbnail"><?php _e("Thumbnail Setting:",'wp_related_posts'); ?></label></th>
			<td>
				<input name="wp_rp_thumbnail_option" type="checkbox" id="wp_rp_thumbnail" value="yes" <?php echo ($wp_rp["wp_rp_thumbnail"] == 'yes') ? 'checked' : ''; ?> onclick="wp_rp_thumbnail_onclick();" >
				<?php _e("Display Thumbnails For Related Posts?",'wp_related_posts');?>
				<br />
				<span id="wp_rp_thumbnail_span" style="<?php echo ($wp_rp["wp_rp_thumbnail"] == 'yes') ? '' : 'display:none;'; ?>">
				<input name="wp_rp_thumbnail_text_option" type="checkbox" id="wp_rp_thumbnail_text" value="yes" <?php echo ($wp_rp["wp_rp_thumbnail_text"] == 'yes') ? 'checked' : ''; ?>>
				<?php _e("Do you still want to display text when display thumbnails for related posts?",'wp_related_posts');?>
				<br />
				<?php _e("Which custom field is used for thumbnail?",'wp_related_posts');?>
				<select name="wp_rp_thumbnail_post_meta_option" id="wp_rp_thumbnail_post_meta"  class="postform">
				<?php
				global $wpdb;
				$post_metas = $wpdb->get_col( "SELECT meta_key FROM $wpdb->postmeta GROUP BY meta_key HAVING meta_key NOT LIKE '\_%' ORDER BY LOWER(meta_key)" );

				foreach ( $post_metas as $post_meta ) {
					$post_meta = esc_attr( $post_meta );
				?>
					<option value="<?php echo $post_meta; ?>" <?php if($wp_rp["wp_rp_thumbnail_post_meta"] == $post_meta) echo 'selected' ?>><?php echo $post_meta;?> </option>;
				<?php
				}
				?>
				</select>
				</span>
            </td>
          </tr>
        </table>		
		<p class="submit"><input type="submit" value="<?php _e("Save changes",'wp_related_posts');?>" name="wp_rp_Submit" class="button-primary" /></p>
      </form>     
	</div>
<?php }?>