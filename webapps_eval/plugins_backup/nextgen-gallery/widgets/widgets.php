<?php
/*
* NextGEN Gallery Widget
*/

// Adding Media RSS Widget as well
require_once(dirname (__FILE__) . '/media-rss-widget.php');

/**
 * nggSlideshowWidget - The slideshow widget control for NextGEN Gallery ( require WP2.8 or higher)
 *
 * @package NextGEN Gallery
 * @author Alex Rabe
 * @copyright 2008 - 2009
 * @version 2.00
 * @since 1.3.2
 * @access public
 */
class nggSlideshowWidget extends WP_Widget {

	function nggSlideshowWidget() {
		$widget_ops = array('classname' => 'widget_slideshow', 'description' => __( 'Show a NextGEN Gallery Slideshow', 'nggallery') );
		$this->WP_Widget('slideshow', __('NextGEN Slideshow', 'nggallery'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		// If the Imagerotator didn't exist, skip the output
		if ( NGGALLERY_IREXIST == false ) 	 
			return;
			
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Slideshow', 'nggallery') : $instance['title'], $instance, $this->id_base);

		$out = $this->render_slideshow($instance['galleryid'] , $instance['width'] , $instance['height']);

		if ( !empty( $out ) ) {
			echo $before_widget;
			if ( $title)
				echo $before_title . $title . $after_title;
		?>
		<div class="ngg_slideshow widget">
			<?php echo $out; ?>
		</div>
		<?php
			echo $after_widget;
		}
  
	}

	function render_slideshow($galleryID, $irWidth = '', $irHeight = '') {
		
		require_once ( dirname (__FILE__) . '/../lib/swfobject.php' );
		
		global $wpdb;
	
		$ngg_options = get_option('ngg_options');
	
		if (empty($irWidth) ) $irWidth = (int) $ngg_options['irWidth'];
		if (empty($irHeight)) $irHeight = (int) $ngg_options['irHeight'];
	
		// init the flash output
		$swfobject = new swfobject( $ngg_options['irURL'], 'sbsl' . $galleryID, $irWidth, $irHeight, '7.0.0', 'false');
		
		$swfobject->classname = 'ngg-widget-slideshow';
		$swfobject->message =  __('<a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see the slideshow.', 'nggallery');
		$swfobject->add_params('wmode', 'opaque');
		$swfobject->add_params('bgcolor', $ngg_options['irScreencolor'], 'FFFFFF', 'string', '#');
		$swfobject->add_attributes('styleclass', 'slideshow-widget');
	
		// adding the flash parameter	
		$swfobject->add_flashvars( 'file', urlencode( get_option ('siteurl') . '/' . 'index.php?callback=imagerotator&gid=' . $galleryID ) );
		$swfobject->add_flashvars( 'shownavigation', 'false', 'true', 'bool');
		$swfobject->add_flashvars( 'shuffle', $ngg_options['irShuffle'], 'true', 'bool');
		$swfobject->add_flashvars( 'showicons', $ngg_options['irShowicons'], 'true', 'bool');
		$swfobject->add_flashvars( 'overstretch', $ngg_options['irOverstretch'], 'false', 'string');
		$swfobject->add_flashvars( 'rotatetime', $ngg_options['irRotatetime'], 5, 'int');
		$swfobject->add_flashvars( 'transition', $ngg_options['irTransition'], 'random', 'string');
		$swfobject->add_flashvars( 'backcolor', $ngg_options['irBackcolor'], 'FFFFFF', 'string', '0x');
		$swfobject->add_flashvars( 'frontcolor', $ngg_options['irFrontcolor'], '000000', 'string', '0x');
		$swfobject->add_flashvars( 'lightcolor', $ngg_options['irLightcolor'], '000000', 'string', '0x');
		$swfobject->add_flashvars( 'screencolor', $ngg_options['irScreencolor'], '000000', 'string', '0x');
		$swfobject->add_flashvars( 'width', $irWidth, '260');
		$swfobject->add_flashvars( 'height', $irHeight, '320');	
		// create the output
		$out  = $swfobject->output();
		// add now the script code
	    $out .= "\n".'<script type="text/javascript" defer="defer">';
		$out .= "\n".'<!--';
		$out .= "\n".'//<![CDATA[';
		$out .= $swfobject->javascript();
		$out .= "\n".'//]]>';
		$out .= "\n".'-->';
		$out .= "\n".'</script>';
				
		return $out;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['galleryid'] = (int) $new_instance['galleryid'];
		$instance['height'] = (int) $new_instance['height'];
		$instance['width'] = (int) $new_instance['width'];

		return $instance;
	}

	function form( $instance ) {
		
		global $wpdb;

		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Slideshow', 'galleryid' => '0', 'height' => '120', 'width' => '160') );
		$title  = esc_attr( $instance['title'] );
		$height = esc_attr( $instance['height'] );
		$width  = esc_attr( $instance['width'] );
		$tables = $wpdb->get_results("SELECT * FROM $wpdb->nggallery ORDER BY 'name' ASC ");
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id('galleryid'); ?>"><?php _e('Select Gallery:', 'nggallery'); ?></label>
				<select size="1" name="<?php echo $this->get_field_name('galleryid'); ?>" id="<?php echo $this->get_field_id('galleryid'); ?>" class="widefat">
					<option value="0" <?php if (0 == $instance['galleryid']) echo "selected='selected' "; ?> ><?php _e('All images', 'nggallery'); ?></option>
<?php
				if($tables) {
					foreach($tables as $table) {
					echo '<option value="'.$table->gid.'" ';
					if ($table->gid == $instance['galleryid']) echo "selected='selected' ";
					echo '>'.$table->name.'</option>'."\n\t"; 
					}
				}
?>
				</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:', 'nggallery'); ?></label> <input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" style="padding: 3px; width: 45px;" value="<?php echo $height; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:', 'nggallery'); ?></label> <input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" style="padding: 3px; width: 45px;" value="<?php echo $width; ?>" /></p>
<?php	
	}

}

// register it
add_action('widgets_init', create_function('', 'return register_widget("nggSlideshowWidget");'));

/**
 * nggWidget - The widget control for NextGEN Gallery ( require WP2.7 or higher)
 *
 * @package NextGEN Gallery
 * @author Alex Rabe
 * @copyright 2009
 * @version 2.00
 * @since 1.4.4
 * @access public
 */
class nggWidget extends WP_Widget {
    
   	function nggWidget() {
		$widget_ops = array('classname' => 'ngg_images', 'description' => __( 'Add recent or random images from the galleries', 'nggallery') );
		$this->WP_Widget('ngg-images', __('NextGEN Widget', 'nggallery'), $widget_ops);
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']	= strip_tags($new_instance['title']);
		$instance['items']	= (int) $new_instance['items'];
		$instance['type']	= $new_instance['type'];
		$instance['show']	= $new_instance['show'];
		$instance['width']	= (int) $new_instance['width'];
		$instance['height']	= (int) $new_instance['height'];
		$instance['exclude'] = $new_instance['exclude'];
		$instance['list']	 = $new_instance['list'];
		$instance['webslice']= (bool) $new_instance['webslice'];

		return $instance;
	}

	function form( $instance ) {
		
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 
            'title' => 'Gallery', 
            'items' => '4',
            'type'  => 'random',
            'show'  => 'thumbnail', 
            'height' => '50', 
            'width' => '75',
            'exclude' => 'all',
            'list'  =>  '',
            'webslice'  => true ) );
		$title  = esc_attr( $instance['title'] );
		$height = esc_attr( $instance['height'] );
		$width  = esc_attr( $instance['width'] );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :','nggallery'); ?>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" type="text" class="widefat" value="<?php echo $title; ?>" />
			</label>
		</p>
			
		<p>
			<?php _e('Show :','nggallery'); ?><br />
			<select id="<?php echo $this->get_field_id('items'); ?>" name="<?php echo $this->get_field_name('items'); ?>">
				<?php for ( $i = 1; $i <= 10; ++$i ) echo "<option value='$i' ".($instance['items']==$i ? "selected='selected'" : '').">$i</option>"; ?>
			</select>
			<select id="<?php echo $this->get_field_id('show'); ?>" name="<?php echo $this->get_field_name('show'); ?>" >
				<option <?php selected("thumbnail" , $instance['show']); ?> value="thumbnail"><?php _e('Thumbnails','nggallery'); ?></option>
				<option <?php selected("original" , $instance['show']); ?> value="original"><?php _e('Original images','nggallery'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>_random">
			<input id="<?php echo $this->get_field_id('type'); ?>_random" name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="random" <?php checked("random" , $instance['type']); ?> /> <?php _e('random','nggallery'); ?>
			</label>
            <label for="<?php echo $this->get_field_id('type'); ?>_recent">
            <input id="<?php echo $this->get_field_id('type'); ?>_recent" name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="recent" <?php checked("recent" , $instance['type']); ?> /> <?php _e('recent added ','nggallery'); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('webslice'); ?>">
			<input id="<?php echo $this->get_field_id('webslice'); ?>" name="<?php echo $this->get_field_name('webslice'); ?>" type="checkbox" value="1" <?php checked(true , $instance['webslice']); ?> /> <?php _e('Enable IE8 Web Slices','nggallery'); ?>
			</label>
		</p>

		<p>
			<?php _e('Width x Height :','nggallery'); ?><br />
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /> x
			<input style="width: 50px; padding:3px;" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /> (px)
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Select :','nggallery'); ?>
			<select id="<?php echo $this->get_field_id('exclude'); ?>" name="<?php echo $this->get_field_name('exclude'); ?>" class="widefat">
				<option <?php selected("all" , $instance['exclude']); ?>  value="all" ><?php _e('All galleries','nggallery'); ?></option>
				<option <?php selected("denied" , $instance['exclude']); ?> value="denied" ><?php _e('Only which are not listed','nggallery'); ?></option>
				<option <?php selected("allow" , $instance['exclude']); ?>  value="allow" ><?php _e('Only which are listed','nggallery'); ?></option>
			</select>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('list'); ?>"><?php _e('Gallery ID :','nggallery'); ?>
			<input id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>" type="text" class="widefat" value="<?php echo $instance['list']; ?>" />
			<br /><small><?php _e('Gallery IDs, separated by commas.','nggallery'); ?></small>
			</label>
		</p>
		
	<?php
	
	}

	function widget( $args, $instance ) {
		extract( $args );
        
        $title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title'], $instance, $this->id_base);

		global $wpdb;
				
		$items 	= $instance['items'];
		$exclude = $instance['exclude'];
		$list = $instance['list'];
		$webslice = $instance['webslice'];

		$count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->nggpictures WHERE exclude != 1 ");
		if ($count < $instance['items']) 
			$instance['items'] = $count;

		$exclude_list = '';

		// THX to Kay Germer for the idea & addon code
		if ( (!empty($list)) && ($exclude != 'all') ) {
			$list = explode(',',$list);
			// Prepare for SQL
			$list = "'" . implode("', '", $list ) . "'";
			
			if ($exclude == 'denied')	
				$exclude_list = "AND NOT (t.gid IN ($list))";

			if ($exclude == 'allow')	
				$exclude_list = "AND t.gid IN ($list)";
		}
		
		if ( $instance['type'] == 'random' ) 
			$imageList = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 $exclude_list ORDER by rand() limit {$items}");
		else
			$imageList = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 $exclude_list ORDER by pid DESC limit 0,$items");
		
        // IE8 webslice support if needed
		if ( $webslice ) {
			$before_widget .= "\n" . '<div class="hslice" id="ngg-webslice" >' . "\n";
            //the headline needs to have the class enty-title
            $before_title  = str_replace( 'class="' , 'class="entry-title ', $before_title);
			$after_widget  =  '</div>'."\n" . $after_widget;			
		}	
		                      
		echo $before_widget . $before_title . $title . $after_title;
		echo "\n" . '<div class="ngg-widget entry-content">'. "\n";
	
		if (is_array($imageList)){
			foreach($imageList as $image) {
				// get the URL constructor
				$image = new nggImage($image);

				// get the effect code
				$thumbcode = $image->get_thumbcode( $widget_id );
				
				// enable i18n support for alttext and description
				$alttext      =  htmlspecialchars( stripslashes( nggGallery::i18n($image->alttext) ));
				$description  =  htmlspecialchars( stripslashes( nggGallery::i18n($image->description) ));
				
				//TODO:For mixed portrait/landscape it's better to use only the height setting, if widht is 0 or vice versa
				$out = '<a href="' . $image->imageURL . '" title="' . $description . '" ' . $thumbcode .'>';
				// Typo fix for the next updates (happend until 1.0.2)
				$instance['show'] = ( $instance['show'] == 'orginal' ) ? 'original' : $instance['show'];
				
				if ( $instance['show'] == 'original' )
					$out .= '<img src="' . get_option ('siteurl') . '/' . 'index.php?callback=image&amp;pid='.$image->pid.'&amp;width='.$instance['width'].'&amp;height='.$instance['height']. '" title="'.$alttext.'" alt="'.$alttext.'" />';
				else	
					$out .= '<img src="'.$image->thumbURL.'" width="'.$instance['width'].'" height="'.$instance['height'].'" title="'.$alttext.'" alt="'.$alttext.'" />';			
				
				echo $out . '</a>'."\n";
				
			}
		}
		
		echo '</div>'."\n";
		echo $after_widget;
		
	}

}// end widget class

// register it
add_action('widgets_init', create_function('', 'return register_widget("nggWidget");'));

/**
 * nggSlideshowWidget($galleryID, $width, $height)
 * Function for templates without widget support
 * 
 * @param integer $galleryID 
 * @param string $width
 * @param string $height
 * @return echo the widget content
 */
function nggSlideshowWidget($galleryID, $width = '', $height = '') {

	echo nggSlideshowWidget::render_slideshow($galleryID, $width, $height);
	
}

/**
 * nggDisplayRandomImages($number,$width,$height,$exclude,$list,$show)
 * Function for templates without widget support
 *
 * @return echo the widget content
 */
function nggDisplayRandomImages($number, $width = '75', $height = '50', $exclude = 'all', $list = '', $show = 'thumbnail') {
	
	$options = array(   'title'    => false, 
						'items'    => $number,
						'show'     => $show ,
						'type'     => 'random',
						'width'    => $width, 
						'height'   => $height, 
						'exclude'  => $exclude,
						'list'     => $list,
                        'webslice' => false );
                        
	$ngg_widget = new nggWidget();
	$ngg_widget->widget($args = array( 'widget_id'=> 'sidebar_1' ), $options);
}

/**
 * nggDisplayRecentImages($number,$width,$height,$exclude,$list,$show)
 * Function for templates without widget support
 *
 * @return echo the widget content
 */
function nggDisplayRecentImages($number, $width = '75', $height = '50', $exclude = 'all', $list = '', $show = 'thumbnail') {

	$options = array(   'title'    => false, 
						'items'    => $number,
						'show'     => $show ,
						'type'     => 'recent',
						'width'    => $width, 
						'height'   => $height, 
						'exclude'  => $exclude,
						'list'     => $list,
                        'webslice' => false );
                        
	$ngg_widget = new nggWidget();
	$ngg_widget->widget($args = array( 'widget_id'=> 'sidebar_1' ), $options);
}

?>