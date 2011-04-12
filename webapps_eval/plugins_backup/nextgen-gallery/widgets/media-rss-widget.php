<?php
/*
* Widget to show Media RSS icons and links
* 
* @author Vincent Prat
*/

// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 	die('You are not allowed to call this page directly.'); }

class nggMediaRssWidget extends WP_Widget {

	var $options;
    
	/**
	* Constructor
	*/
   	function nggMediaRssWidget() {
		$widget_ops = array('classname' => 'ngg_mrssw', 'description' => __( 'Widget that displays Media RSS links for NextGEN Gallery.', 'nggallery') );
		$this->WP_Widget('ngg-mrssw', __('NextGEN Media RSS', 'nggallery'), $widget_ops);
	}    

	function widget( $args, $instance ) {
		extract( $args );
        
		$ngg_options = nggGallery::get_option('ngg_options');
		
        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title'], $instance, $this->id_base);

		$show_global_mrss 	= $instance['show_global_mrss'];
		$show_icon		 	= $instance['show_icon'];
		$mrss_text			= stripslashes($instance['mrss_text']);
		$mrss_title			= strip_tags(stripslashes($instance['mrss_title']));

		echo $before_widget; 
			echo $before_title . $title . $after_title;
			echo "<ul class='ngg-media-rss-widget'>\n";
			if ($show_global_mrss) {
				echo "  <li>";
				echo $this->get_mrss_link(nggMediaRss::get_mrss_url(), $show_icon, 
								stripslashes($mrss_title), stripslashes($mrss_text), 
								$ngg_options['usePicLens']);
				echo "</li>\n";
			}
			echo "</ul>\n";
		echo $after_widget;
 
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']	= strip_tags($new_instance['title']);
		$instance['show_global_mrss'] = $new_instance['show_global_mrss'];
		$instance['show_icon']	= $new_instance['show_icon'];        
		$instance['mrss_text']	= $new_instance['mrss_text'];
		$instance['mrss_title'] = $new_instance['mrss_title'];

		return $instance;
	}

	function form( $instance ) {
		
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 
            'title' => 'Media RSS', 
            'show_global_mrss' => true,
            'mrss_text'  => __('Media RSS', 'nggallery'),
            'mrss_title' => __('Link to the main image feed', 'nggallery'), 
            'show_icon' => true ) );
            
		$title      = esc_attr( $instance['title'] );
        $mrss_text  = esc_attr( $instance['mrss_text'] );
        $mrss_title = esc_attr( $instance['mrss_title'] );
            
		// The widget form
        ?>
        <p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :','nggallery'); ?><br />
        		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $title; ?>" />
        	</label>
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('show_icon'); ?>">
        		<input id="<?php echo $this->get_field_id('show_icon'); ?>" name="<?php echo $this->get_field_name('show_icon'); ?>" type="checkbox" value="1" <?php checked(true , $instance['show_icon']); ?> />
        		<?php _e('Show Media RSS icon', 'nggallery'); ?>
        	</label>
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('show_global_mrss'); ?>">
        		<input id="<?php echo $this->get_field_id('show_global_mrss'); ?>" name="<?php echo $this->get_field_name('show_global_mrss'); ?>" type="checkbox" value="1" <?php checked(true , $instance['show_global_mrss']); ?> /> <?php _e('Show the Media RSS link', 'nggallery'); ?>
        	</label>
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('mrss_text'); ?>"><?php _e('Text for Media RSS link:', 'nggallery'); ?><br />
        		<input class="widefat" id="<?php echo $this->get_field_id('mrss_text'); ?>" name="<?php echo $this->get_field_name('mrss_text'); ?>" type="text" value="<?php echo $mrss_text; ?>" /></label>
        	</label>
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id('mrss_title'); ?>"><?php _e('Tooltip text for Media RSS link:', 'nggallery'); ?><br />
        		<input class="widefat" id="<?php echo $this->get_field_id('mrss_title'); ?>" name="<?php echo $this->get_field_name('mrss_title'); ?>" type="text" value="<?php echo $mrss_title; ?>" /></label>
        	</label>
        </p>
        
        <?php

    }
	
    /**
	 * Get a link to a Media RSS
	 */
	function get_mrss_link($mrss_url, $show_icon = true, $title, $text, $use_piclens) {
		$out  = '';
		
		if ($show_icon) {
			$icon_url = NGGALLERY_URLPATH . 'images/mrss-icon.gif';
			$out .= "<a href='$mrss_url' title='$title' class='ngg-media-rss-link'" . ($use_piclens ? ' onclick="PicLensLite.start({feedUrl:\'' . $mrss_url . '\'}); return false;"' : "") . " >";
			$out .= "<img src='$icon_url' alt='MediaRSS Icon' title='" . (!$use_piclens ? $title : __('[View with PicLens]','nggallery')). "' class='ngg-media-rss-icon' />";
			$out .=  "</a> ";
		}
		
		if ($text != '') {
			$out .= "<a href='$mrss_url' title='$title' class='ngg-media-rss-link'>";
			$out .= $text;
			$out .=  "</a>";
		}
				
		return $out;
	}
	
} // class nggMediaRssWidget

// let's start it
add_action('widgets_init', create_function('', 'return register_widget("nggMediaRssWidget");'));

?>