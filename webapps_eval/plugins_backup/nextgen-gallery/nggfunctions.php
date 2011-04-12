<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

/**
 * Return a script for the Imagerotator flash slideshow. Can be used in any tmeplate with <?php echo nggShowSlideshow($galleryID, $width, $height) ?>
 * Require the script swfobject.js in the header or footer
 * 
 * @access public 
 * @param integer $galleryID ID of the gallery
 * @param integer $irWidth Width of the flash container
 * @param integer $irHeight Height of the flash container
 * @return the content
 */
function nggShowSlideshow($galleryID, $width, $height) {
    
    require_once (dirname (__FILE__).'/lib/swfobject.php');

    $ngg_options = nggGallery::get_option('ngg_options');

    // remove media file from RSS feed
    if ( is_feed() ) {
        $out = '[' . nggGallery::i18n($ngg_options['galTextSlide']) . ']'; 
        return $out;
    }
    
    // If the Imagerotator didn't exist, skip the output
    if ( NGGALLERY_IREXIST == false ) 
        return; 
        
    if (empty($width) ) $width  = (int) $ngg_options['irWidth'];
    if (empty($height)) $height = (int) $ngg_options['irHeight'];

    // init the flash output
    $swfobject = new swfobject( $ngg_options['irURL'] , 'so' . $galleryID, $width, $height, '7.0.0', 'false');

    $swfobject->message = '<p>'. __('The <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> and <a href="http://www.mozilla.com/firefox/">a browser with Javascript support</a> are needed..', 'nggallery').'</p>';
    $swfobject->add_params('wmode', 'opaque');
    $swfobject->add_params('allowfullscreen', 'true');
    $swfobject->add_params('bgcolor', $ngg_options['irScreencolor'], 'FFFFFF', 'string', '#');
    $swfobject->add_attributes('styleclass', 'slideshow');
    $swfobject->add_attributes('name', 'so' . $galleryID);

    // adding the flash parameter   
    $swfobject->add_flashvars( 'file', urlencode (get_option ('siteurl') . '/' . 'index.php?callback=imagerotator&gid=' . $galleryID ) );
    $swfobject->add_flashvars( 'shuffle', $ngg_options['irShuffle'], 'true', 'bool');
    $swfobject->add_flashvars( 'linkfromdisplay', $ngg_options['irLinkfromdisplay'], 'false', 'bool');
    $swfobject->add_flashvars( 'shownavigation', $ngg_options['irShownavigation'], 'true', 'bool');
    $swfobject->add_flashvars( 'showicons', $ngg_options['irShowicons'], 'true', 'bool');
    $swfobject->add_flashvars( 'kenburns', $ngg_options['irKenburns'], 'false', 'bool');
    $swfobject->add_flashvars( 'overstretch', $ngg_options['irOverstretch'], 'false', 'string');
    $swfobject->add_flashvars( 'rotatetime', $ngg_options['irRotatetime'], 5, 'int');
    $swfobject->add_flashvars( 'transition', $ngg_options['irTransition'], 'random', 'string');
    $swfobject->add_flashvars( 'backcolor', $ngg_options['irBackcolor'], 'FFFFFF', 'string', '0x');
    $swfobject->add_flashvars( 'frontcolor', $ngg_options['irFrontcolor'], '000000', 'string', '0x');
    $swfobject->add_flashvars( 'lightcolor', $ngg_options['irLightcolor'], '000000', 'string', '0x');
    $swfobject->add_flashvars( 'screencolor', $ngg_options['irScreencolor'], '000000', 'string', '0x');
    if ($ngg_options['irWatermark'])
        $swfobject->add_flashvars( 'logo', $ngg_options['wmPath'], '', 'string'); 
    $swfobject->add_flashvars( 'audio', $ngg_options['irAudio'], '', 'string');
    $swfobject->add_flashvars( 'width', $width, '260');
    $swfobject->add_flashvars( 'height', $height, '320');   
    // create the output
    $out  = '<div class="slideshow">' . $swfobject->output() . '</div>';
    // add now the script code
    $out .= "\n".'<script type="text/javascript" defer="defer">';
    if ($ngg_options['irXHTMLvalid']) $out .= "\n".'<!--';
    if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//<![CDATA[';
    $out .= $swfobject->javascript();
    if ($ngg_options['irXHTMLvalid']) $out .= "\n".'//]]>';
    if ($ngg_options['irXHTMLvalid']) $out .= "\n".'-->';
    $out .= "\n".'</script>';

    $out = apply_filters('ngg_show_slideshow_content', $out);
            
    return $out;    
}

/**
 * nggShowGallery() - return a gallery  
 * 
 * @access public 
 * @param int $galleryID
 * @param string $template (optional) name for a template file, look for gallery-$template
 * @param int $images (optional) number of images per page
 * @return the content
 */
function nggShowGallery( $galleryID, $template = '', $images = false ) {
    
    global $nggRewrite;

    $ngg_options = nggGallery::get_option('ngg_options');
    $galleryID = (int) $galleryID;
    
    //Set sort order value, if not used (upgrade issue)
    $ngg_options['galSort'] = ($ngg_options['galSort']) ? $ngg_options['galSort'] : 'pid';
    $ngg_options['galSortDir'] = ($ngg_options['galSortDir'] == 'DESC') ? 'DESC' : 'ASC';
    
    // get gallery values
    $picturelist = nggdb::get_gallery($galleryID, $ngg_options['galSort'], $ngg_options['galSortDir']);

    if ( !$picturelist )
        return __('[Gallery not found]','nggallery');

    // $_GET from wp_query
    $show    = get_query_var('show');
    $pid     = get_query_var('pid');
    $pageid  = get_query_var('pageid');
    
    // set $show if slideshow first
    if ( empty( $show ) AND ($ngg_options['galShowOrder'] == 'slide')) {
        if ( is_home() ) 
            $pageid = get_the_ID();
        
        $show = 'slide';
    }

    // go on only on this page
    if ( !is_home() || $pageid == get_the_ID() ) { 
            
        // 1st look for ImageBrowser link
        if ( !empty($pid) && $ngg_options['galImgBrowser'] && ($template != 'carousel') )  {
            $out = nggShowImageBrowser( $galleryID, $template );
            return $out;
        }
        
        // 2nd look for slideshow
        if ( $show == 'slide' ) {
            $args['show'] = "gallery";
            $out  = '<div class="ngg-galleryoverview">';
            $out .= '<div class="slideshowlink"><a class="slideshowlink" href="' . $nggRewrite->get_permalink($args) . '">'.nggGallery::i18n($ngg_options['galTextGallery']).'</a></div>';
            $out .= nggShowSlideshow($galleryID, $ngg_options['irWidth'], $ngg_options['irHeight']);
            $out .= '</div>'."\n";
            $out .= '<div class="ngg-clear"></div>'."\n";
            return $out;
        }
    }

    // get all picture with this galleryid
    if ( is_array($picturelist) )
        $out = nggCreateGallery($picturelist, $galleryID, $template, $images);
    
    $out = apply_filters('ngg_show_gallery_content', $out, intval($galleryID));
    return $out;
}

/**
 * Build a gallery output
 * 
 * @access internal
 * @param array $picturelist
 * @param bool $galleryID, if you supply a gallery ID, you can add a slideshow link
 * @param string $template (optional) name for a template file, look for gallery-$template
 * @param int $images (optional) number of images per page
 * @return the content
 */
function nggCreateGallery($picturelist, $galleryID = false, $template = '', $images = false) {
    global $nggRewrite;

    $ngg_options = nggGallery::get_option('ngg_options');

    //the shortcode parameter will override global settings, TODO: rewrite this to a class
    $ngg_options['galImages'] = ( $images === false ) ? $ngg_options['galImages'] : (int) $images;  
    
    $current_pid = false;
        
    // $_GET from wp_query
    $nggpage  = get_query_var('nggpage');
    $pageid   = get_query_var('pageid');
    $pid      = get_query_var('pid');
    
    // we need to know the current page id
    $current_page = (get_the_ID() == false) ? 0 : get_the_ID();

    if ( !is_array($picturelist) )
        $picturelist = array($picturelist);
    
    // Populate galleries values from the first image           
    $first_image = current($picturelist);
    $gallery = new stdclass;
    $gallery->ID = (int) $galleryID;
    $gallery->show_slideshow = false;
    $gallery->name = stripslashes ( $first_image->name  );
    $gallery->title = stripslashes( $first_image->title );
    $gallery->description = html_entity_decode(stripslashes( $first_image->galdesc));
    $gallery->pageid = $first_image->pageid;
    $gallery->anchor = 'ngg-gallery-' . $galleryID . '-' . $current_page;
    reset($picturelist);

    $maxElement  = $ngg_options['galImages'];
    $thumbwidth  = $ngg_options['thumbwidth'];
    $thumbheight = $ngg_options['thumbheight'];     
    
    // fixed width if needed
    $gallery->columns    = intval($ngg_options['galColumns']);
    $gallery->imagewidth = ($gallery->columns > 0) ? 'style="width:' . floor(100/$gallery->columns) . '%;"' : '';
    
    // obsolete in V1.4.0, but kept for compat reason
	// pre set thumbnail size, from the option, later we look for meta data. 
    $thumbsize = ($ngg_options['thumbfix']) ? $thumbsize = 'width="' . $thumbwidth . '" height="'.$thumbheight . '"' : '';
    
    // show slideshow link
    if ($galleryID) {
        if (($ngg_options['galShowSlide']) AND (NGGALLERY_IREXIST)) {
            $gallery->show_slideshow = true;
            $gallery->slideshow_link = $nggRewrite->get_permalink(array ( 'show' => 'slide') );
            $gallery->slideshow_link_text = nggGallery::i18n($ngg_options['galTextSlide']);
        }
        
        if ($ngg_options['usePicLens']) {
            $gallery->show_piclens = true;
            $gallery->piclens_link = "javascript:PicLensLite.start({feedUrl:'" . htmlspecialchars( nggMediaRss::get_gallery_mrss_url($gallery->ID) ) . "'});";
        }
    }

    // check for page navigation
    if ($maxElement > 0) {
        
        if ( !is_home() || $pageid == $current_page )
            $page = ( !empty( $nggpage ) ) ? (int) $nggpage : 1;
        else 
            $page = 1;
         
        $start = $offset = ( $page - 1 ) * $maxElement;
        
        $total = count($picturelist);

		//we can work with display:hidden for some javascript effects
        if (!$ngg_options['galHiddenImg']){
	        // remove the element if we didn't start at the beginning
	        if ($start > 0 ) 
	            array_splice($picturelist, 0, $start);
	        
	        // return the list of images we need
	        array_splice($picturelist, $maxElement);
        }

        $nggNav = new nggNavigation;    
        $navigation = $nggNav->create_navigation($page, $total, $maxElement);
    } else {
        $navigation = '<div class="ngg-clear">&nbsp;</div>';
    } 
	  
    //we cannot use the key as index, cause it's filled with the pid
	$index = 0;
    foreach ($picturelist as $key => $picture) {

		//needed for hidden images (THX to Sweigold for the main idea at : http://wordpress.org/support/topic/228743/ )
		$picturelist[$key]->hidden = false;	
		$picturelist[$key]->style  = $gallery->imagewidth;
		
		if ($maxElement > 0 && $ngg_options['galHiddenImg']) {
	  		if ( ($index < $start) || ($index > ($start + $maxElement -1)) ){
				$picturelist[$key]->hidden = true;	
				$picturelist[$key]->style  = ($gallery->columns > 0) ? 'style="width:' . floor(100/$gallery->columns) . '%;display: none;"' : 'style="display: none;"';
			}
  			$index++;
		}
		
        // get the effect code
        if ($galleryID)
            $thumbcode = ($ngg_options['galImgBrowser']) ? '' : $picture->get_thumbcode('set_' . $galleryID);
        else
            $thumbcode = ($ngg_options['galImgBrowser']) ? '' : $picture->get_thumbcode(get_the_title());

        // create link for imagebrowser and other effects
        $args ['nggpage'] = empty($nggpage) ? false : $nggpage;
        $args ['pid']     = $picture->pid;
        $picturelist[$key]->pidlink = $nggRewrite->get_permalink( $args );
        
        // generate the thumbnail size if the meta data available
        if (is_array ($size = $picturelist[$key]->meta_data['thumbnail']) )
        	$thumbsize = 'width="' . $size['width'] . '" height="' . $size['height'] . '"';
        
        // choose link between imagebrowser or effect
        $link = ($ngg_options['galImgBrowser']) ? $picturelist[$key]->pidlink : $picture->imageURL; 
        // bad solution : for now we need the url always for the carousel, should be reworked in the future
        $picturelist[$key]->url = $picture->imageURL;
        // add a filter for the link
        $picturelist[$key]->imageURL = apply_filters('ngg_create_gallery_link', $link, $picture);
        $picturelist[$key]->thumbnailURL = $picture->thumbURL;
        $picturelist[$key]->size = $thumbsize;
        $picturelist[$key]->thumbcode = $thumbcode;
        $picturelist[$key]->caption = ( empty($picture->description) ) ? '&nbsp;' : html_entity_decode ( stripslashes(nggGallery::i18n($picture->description)) );
        $picturelist[$key]->description = ( empty($picture->description) ) ? ' ' : htmlspecialchars ( stripslashes(nggGallery::i18n($picture->description)) );
        $picturelist[$key]->alttext = ( empty($picture->alttext) ) ?  ' ' : htmlspecialchars ( stripslashes(nggGallery::i18n($picture->alttext)) );
        
        // filter to add custom content for the output
        $picturelist[$key] = apply_filters('ngg_image_object', $picturelist[$key], $picture->pid);

        //check if $pid is in the array
        if ($picture->pid == $pid) 
            $current_pid = $picturelist[$key];
    }
    reset($picturelist);

    //for paged galleries, take the first image in the array if it's not in the list
    $current_pid = ( empty($current_pid) ) ? current( $picturelist ) : $current_pid;
    
    // look for gallery-$template.php or pure gallery.php
    $filename = ( empty($template) ) ? 'gallery' : 'gallery-' . $template;
    
    //filter functions for custom addons
    $gallery     = apply_filters( 'ngg_gallery_object', $gallery, $galleryID );
    $picturelist = apply_filters( 'ngg_picturelist_object', $picturelist, $galleryID );
    
    //additional navigation links
    $next = ( empty($nggNav->next) ) ? false : $nggNav->next;
    $prev = ( empty($nggNav->prev) ) ? false : $nggNav->prev;

    // create the output
    $out = nggGallery::capture ( $filename, array ('gallery' => $gallery, 'images' => $picturelist, 'pagination' => $navigation, 'current' => $current_pid, 'next' => $next, 'prev' => $prev) );
    
    // apply a filter after the output
    $out = apply_filters('ngg_gallery_output', $out, $picturelist);
    
    return $out;
}

/**
 * nggShowAlbum() - return a album based on the id
 * 
 * @access public 
 * @param int | string $albumID
 * @param string (optional) $template
 * @return the content
 */
function nggShowAlbum($albumID, $template = 'extend') {
    
    // $_GET from wp_query
    $gallery  = get_query_var('gallery');
    $album    = get_query_var('album');

    // in the case somebody uses the '0', it should be 'all' to show all galleries
    $albumID  = ($albumID == 0) ? 'all' : $albumID;

    // first look for gallery variable 
    if (!empty( $gallery ))  {
        
        // subalbum support only one instance, you can't use more of them in one post
        if ( isset($GLOBALS['subalbum']) || isset($GLOBALS['nggShowGallery']) )
                return;
                
        // if gallery is is submit , then show the gallery instead 
        $out = nggShowGallery( intval($gallery) );
        $GLOBALS['nggShowGallery'] = true;
        
        return $out;
    }
    
    if ( (empty( $gallery )) && (isset($GLOBALS['subalbum'])) )
        return;

    //redirect to subalbum only one time        
    if (!empty( $album )) {
        $GLOBALS['subalbum'] = true;
        $albumID = $album;          
    }

    // lookup in the database
    $album = nggdb::find_album( $albumID );

    // still no success ? , die !
    if( !$album ) 
        return __('[Album not found]','nggallery');
    
    if ( is_array($album->gallery_ids) )
        $out = nggCreateAlbum( $album->gallery_ids, $template, $album );
    
    $out = apply_filters( 'ngg_show_album_content', $out, $album->id );

    return $out;
}

/**
 * create a gallery overview output
 * 
 * @access internal
 * @param array $galleriesID
 * @param string (optional) $template name for a template file, look for album-$template
 * @param object (optional) $album result from the db
 * @return the content
 */
function nggCreateAlbum( $galleriesID, $template = 'extend', $album = 0) {

    global $wpdb, $nggRewrite, $nggdb;
    
    // $_GET from wp_query
    $nggpage  = get_query_var('nggpage');   
    
    $ngg_options = nggGallery::get_option('ngg_options');
    
    //this option can currently only set via the custom fields
    $maxElement  = (int) $ngg_options['galPagedGalleries'];

    $sortorder = $galleriesID;
    $galleries = array();
    
    // get the galleries information    
    foreach ($galleriesID as $i => $value)
        $galleriesID[$i] = addslashes($value);

    $unsort_galleries = $wpdb->get_results('SELECT * FROM '.$wpdb->nggallery.' WHERE gid IN (\''.implode('\',\'', $galleriesID).'\')', OBJECT_K);

    //TODO: Check this, problem exist when previewpic = 0 
    //$galleries = $wpdb->get_results('SELECT t.*, tt.* FROM '.$wpdb->nggallery.' AS t INNER JOIN '.$wpdb->nggpictures.' AS tt ON t.previewpic = tt.pid WHERE t.gid IN (\''.implode('\',\'', $galleriesID).'\')', OBJECT_K);

    // get the counter values   
    $picturesCounter = $wpdb->get_results('SELECT galleryid, COUNT(*) as counter FROM '.$wpdb->nggpictures.' WHERE galleryid IN (\''.implode('\',\'', $galleriesID).'\') AND exclude != 1 GROUP BY galleryid', OBJECT_K);
    if ( is_array($picturesCounter) ) {
        foreach ($picturesCounter as $key => $value)
            $unsort_galleries[$key]->counter = $value->counter;
    }
    
    // get the id's of the preview images
    $imagesID = array();
    if ( is_array($unsort_galleries) ) {
        foreach ($unsort_galleries as $gallery_row)
            $imagesID[] = $gallery_row->previewpic;
    }   
    $albumPreview = $wpdb->get_results('SELECT pid, filename FROM '.$wpdb->nggpictures.' WHERE pid IN (\''.implode('\',\'', $imagesID).'\')', OBJECT_K);

    // re-order them and populate some 
    foreach ($sortorder as $key) {
		       
        //if we have a prefix 'a' then it's a subalbum, instead a gallery
        if (substr( $key, 0, 1) == 'a') { 
            // get the album content
             if ( !$subalbum = $nggdb->find_album(substr( $key, 1)) )
                continue;
            
            //populate the sub album values
            $galleries[$key]->counter = 0;
            if ($subalbum->previewpic > 0)
                $image = $nggdb->find_image( $subalbum->previewpic );
            $galleries[$key]->previewpic = $subalbum->previewpic;
            $galleries[$key]->previewurl = isset($image->thumbURL) ? $image->thumbURL : '';
            $galleries[$key]->previewname = $subalbum->name;
            
            //link to the subalbum
            $args['album'] = $subalbum->id;
            $args['gallery'] = false; 
            $args['nggpage'] = false;
            $pageid = (isset($subalbum->pageid) ? $subalbum->pageid : 0);
            if ($pageid > 0) {
                $galleries[$key]->pagelink = get_permalink($pageid);
            } else {
                $galleries[$key]->pagelink = $nggRewrite->get_permalink($args);
            }
            $galleries[$key]->galdesc = html_entity_decode ( nggGallery::i18n($subalbum->albumdesc) );
            $galleries[$key]->title = html_entity_decode ( nggGallery::i18n($subalbum->name) ); 
            
            // apply a filter on gallery object before the output
            $galleries[$key] = apply_filters('ngg_album_galleryobject', $galleries[$key]);
            
            continue;
        }
		
		// If a gallery is not found it should be ignored
        if (!$unsort_galleries[$key])
        	continue;
		
		// Add the counter value if avaible
        $galleries[$key] = $unsort_galleries[$key];
    	
        // add the file name and the link 
        if ($galleries[$key]->previewpic  != 0) {
            $galleries[$key]->previewname = $albumPreview[$galleries[$key]->previewpic]->filename;
            $galleries[$key]->previewurl  = get_option ('siteurl').'/' . $galleries[$key]->path . '/thumbs/thumbs_' . $albumPreview[$galleries[$key]->previewpic]->filename;
        } else {
            $first_image = $wpdb->get_row('SELECT * FROM '. $wpdb->nggpictures .' WHERE exclude != 1 AND galleryid = '. $key .' ORDER by pid DESC limit 0,1');
            $galleries[$key]->previewpic  = $first_image->pid;
            $galleries[$key]->previewname = $first_image->filename;
            $galleries[$key]->previewurl  = get_option ('siteurl') . '/' . $galleries[$key]->path . '/thumbs/thumbs_' . $first_image->filename;
        }

        // choose between variable and page link
        if ($ngg_options['galNoPages']) {
            $args['album'] = $album->id; 
            $args['gallery'] = $key;
            $args['nggpage'] = false;
            $galleries[$key]->pagelink = $nggRewrite->get_permalink($args);
            
        } else {
            $galleries[$key]->pagelink = get_permalink( $galleries[$key]->pageid );
        }
        
        // description can contain HTML tags
        $galleries[$key]->galdesc = html_entity_decode ( stripslashes($galleries[$key]->galdesc) ) ;

        // i18n
        $galleries[$key]->title = html_entity_decode ( nggGallery::i18n( stripslashes($galleries[$key]->title) ) ) ;
        
        // apply a filter on gallery object before the output
        $galleries[$key] = apply_filters('ngg_album_galleryobject', $galleries[$key]);
    }

    // check for page navigation
    if ($maxElement > 0) {
        if ( !is_home() || $pageid == get_the_ID() ) {
            $page = ( !empty( $nggpage ) ) ? (int) $nggpage : 1;
        }
        else $page = 1;
         
        $start = $offset = ( $page - 1 ) * $maxElement;
        
        $total = count($galleries);
        
        // remove the element if we didn't start at the beginning
        if ($start > 0 ) array_splice($galleries, 0, $start);
        
        // return the list of images we need
        array_splice($galleries, $maxElement);
        
        $nggNav = new nggNavigation;    
        $navigation = $nggNav->create_navigation($page, $total, $maxElement);
    } else {
        $navigation = '<div class="ngg-clear">&nbsp;</div>';
    }

    // apply a filter on $galleries before the output
    $galleries = apply_filters('ngg_album_galleries', $galleries);
    
    // if sombody didn't enter any template , take the extend version
    $filename = ( empty($template) ) ? 'album-extend' : 'album-' . $template ;

    // create the output
    $out = nggGallery::capture ( $filename, array ('album' => $album, 'galleries' => $galleries, 'pagination' => $navigation) );

    return $out;
    
}

/**
 * nggShowImageBrowser()
 * 
 * @access public 
 * @param int|string $galleryID or gallery name
 * @param string $template (optional) name for a template file, look for imagebrowser-$template
 * @return the content
 */
function nggShowImageBrowser($galleryID, $template = '') {
    
    global $wpdb;
    
    $ngg_options = nggGallery::get_option('ngg_options');
    
    //Set sort order value, if not used (upgrade issue)
    $ngg_options['galSort'] = ($ngg_options['galSort']) ? $ngg_options['galSort'] : 'pid';
    $ngg_options['galSortDir'] = ($ngg_options['galSortDir'] == 'DESC') ? 'DESC' : 'ASC';
    
    // get the pictures
    $picturelist = nggdb::get_ids_from_gallery($galleryID, $ngg_options['galSort'], $ngg_options['galSortDir']);
    
    if ( is_array($picturelist) )
        $out = nggCreateImageBrowser($picturelist, $template);
    else
        $out = __('[Gallery not found]','nggallery');
    
    $out = apply_filters('ngg_show_imagebrowser_content', $out, $galleryID);
    
    return $out;
    
}

/**
 * nggCreateImageBrowser()
 * 
 * @access internal
 * @param array $picarray with pid
 * @param string $template (optional) name for a template file, look for imagebrowser-$template
 * @return the content
 */
function nggCreateImageBrowser($picarray, $template = '') {

    global $nggRewrite;
    
    require_once( dirname (__FILE__) . '/lib/meta.php' );
    
    // $_GET from wp_query
    $pid  = get_query_var('pid');
    
    // we need to know the current page id
    $current_page = (get_the_ID() == false) ? 0 : get_the_ID();

    if ( !is_array($picarray) )
        $picarray = array($picarray);

    $total = count($picarray);

    // look for gallery variable 
    if ( !empty( $pid )) {
        $act_pid = (int) $pid;
    } else {
        reset($picarray);
        $act_pid = current($picarray);
    }
    
    // get ids for back/next
    $key = array_search($act_pid,$picarray);
    if (!$key) {
        $act_pid = reset($picarray);
        $key = key($picarray);
    }
    $back_pid = ( $key >= 1 ) ? $picarray[$key-1] : end($picarray) ;
    $next_pid = ( $key < ($total-1) ) ? $picarray[$key+1] : reset($picarray) ;
    
    // get the picture data
    $picture = nggdb::find_image($act_pid);
    
    // if we didn't get some data, exit now
    if ($picture == null)
        return;
        
    // add more variables for render output
    $picture->href_link = $picture->get_href_link();
    $picture->previous_image_link = $nggRewrite->get_permalink(array ('pid' => $back_pid));
    $picture->previous_pid = $back_pid;
    $picture->next_image_link  = $nggRewrite->get_permalink(array ('pid' => $next_pid));
    $picture->next_pid = $next_pid;
    $picture->number = $key + 1;
    $picture->total = $total;
    $picture->linktitle = htmlspecialchars( stripslashes($picture->description) );
    $picture->alttext = html_entity_decode( stripslashes($picture->alttext) );
    $picture->description = html_entity_decode( stripslashes($picture->description) );
    $picture->anchor = 'ngg-imagebrowser-' . $picture->galleryid . '-' . $current_page;
    
    // filter to add custom content for the output
    $picture = apply_filters('ngg_image_object', $picture, $act_pid);
    
    // let's get the meta data
    $meta = new nggMeta($act_pid);
    $exif = $meta->get_EXIF();
    $iptc = $meta->get_IPTC();
    $xmp  = $meta->get_XMP();
    $db   = $meta->get_saved_meta();
    
    //if we get no exif information we try the database 
    $exif = ($exif == false) ? $db : $exif;
        
    // look for imagebrowser-$template.php or pure imagebrowser.php
    $filename = ( empty($template) ) ? 'imagebrowser' : 'imagebrowser-' . $template;

    // create the output
    $out = nggGallery::capture ( $filename , array ('image' => $picture , 'meta' => $meta, 'exif' => $exif, 'iptc' => $iptc, 'xmp' => $xmp, 'db' => $db) );
    
    return $out;
    
}

/**
 * nggSinglePicture() - show a single picture based on the id
 * 
 * @access public 
 * @param int $imageID, db-ID of the image
 * @param int (optional) $width, width of the image
 * @param int (optional) $height, height of the image
 * @param string $mode (optional) could be none, watermark, web20
 * @param string $float (optional) could be none, left, right
 * @param string $template (optional) name for a template file, look for singlepic-$template
 * @param string $caption (optional) additional caption text
 * @param string $link (optional) link to a other url instead the full image
 * @return the content
 */
function nggSinglePicture($imageID, $width = 250, $height = 250, $mode = '', $float = '' , $template = '', $caption = '', $link = '') {
    global $post;
    
    $ngg_options = nggGallery::get_option('ngg_options');
    
    // get picturedata
    $picture = nggdb::find_image($imageID);
    
    // if we didn't get some data, exit now
    if ($picture == null)
        return __('[SinglePic not found]','nggallery');
            
    // add float to img
    switch ($float) {
        
        case 'left': 
            $float =' ngg-left';
        break;
        
        case 'right': 
            $float =' ngg-right';
        break;

        case 'center': 
            $float =' ngg-center';
        break;
        
        default: 
            $float ='';
        break;
    }
    
    // clean mode if needed 
    $mode = ( preg_match('/(web20|watermark)/i', $mode) ) ? $mode : '';
    
    //let's initiate the url
    $picture->thumbnailURL = false;

    // check fo cached picture
    if ( ($ngg_options['imgCacheSinglePic']) && ($post->post_status == 'publish') )
        $picture->thumbnailURL = $picture->cached_singlepic_file($width, $height, $mode );
    
    // if we didn't use a cached image then we take the on-the-fly mode 
    if (!$picture->thumbnailURL) 
        $picture->thumbnailURL = get_option ('siteurl') . '/' . 'index.php?callback=image&amp;pid=' . $imageID . '&amp;width=' . $width . '&amp;height=' . $height . '&amp;mode=' . $mode;

    // add more variables for render output
    $picture->imageURL = ( empty($link) ) ? $picture->imageURL : $link;
    $picture->href_link = $picture->get_href_link();
    $picture->alttext = html_entity_decode( stripslashes(nggGallery::i18n($picture->alttext)) );
    $picture->linktitle = htmlspecialchars( stripslashes(nggGallery::i18n($picture->description)) );
    $picture->description = html_entity_decode( stripslashes(nggGallery::i18n($picture->description)) );
    $picture->classname = 'ngg-singlepic'. $float;
    $picture->thumbcode = $picture->get_thumbcode( 'singlepic' . $imageID);
    $picture->height = (int) $height;
    $picture->width = (int) $width;
    $picture->caption = nggGallery::i18n($caption);

    // filter to add custom content for the output
    $picture = apply_filters('ngg_image_object', $picture, $imageID);

    // let's get the meta data
    $meta = new nggMeta($imageID);
    $exif = $meta->get_EXIF();
    $iptc = $meta->get_IPTC();
    $xmp  = $meta->get_XMP();
    $db   = $meta->get_saved_meta();
    
    //if we get no exif information we try the database 
    $exif = ($exif == false) ? $db : $exif;
	       
    // look for singlepic-$template.php or pure singlepic.php
    $filename = ( empty($template) ) ? 'singlepic' : 'singlepic-' . $template;

    // create the output
    $out = nggGallery::capture ( $filename, array ('image' => $picture , 'meta' => $meta, 'exif' => $exif, 'iptc' => $iptc, 'xmp' => $xmp, 'db' => $db) );

    $out = apply_filters('ngg_show_singlepic_content', $out, $picture );
    
    return $out;
}

/**
 * nggShowGalleryTags() - create a gallery based on the tags
 * 
 * @access public 
 * @param string $taglist list of tags as csv
 * @return the content
 */
function nggShowGalleryTags($taglist) { 

    // $_GET from wp_query
    $pid    = get_query_var('pid');
    $pageid = get_query_var('pageid');
    
    // get now the related images
    $picturelist = nggTags::find_images_for_tags($taglist , 'ASC');

    // look for ImageBrowser if we have a $_GET('pid')
    if ( $pageid == get_the_ID() || !is_home() )  
        if (!empty( $pid ))  {
            foreach ($picturelist as $picture) {
                $picarray[] = $picture->pid;
            }
            $out = nggCreateImageBrowser($picarray);
            return $out;
        }

    // go on if not empty
    if ( empty($picturelist) )
        return;
    
    // show gallery
    if ( is_array($picturelist) )
        $out = nggCreateGallery($picturelist, false);
    
    $out = apply_filters('ngg_show_gallery_tags_content', $out, $taglist);
    return $out;
}

/**
 * nggShowRelatedGallery() - create a gallery based on the tags
 * 
 * @access public 
 * @param string $taglist list of tags as csv
 * @param integer $maxImages (optional) limit the number of images to show
 * @return the content
 */ 
function nggShowRelatedGallery($taglist, $maxImages = 0) {
    
    $ngg_options = nggGallery::get_option('ngg_options');
    
    // get now the related images
    $picturelist = nggTags::find_images_for_tags($taglist, 'RAND');

    // go on if not empty
    if ( empty($picturelist) )
        return;
    
    // cut the list to maxImages
    if ( $maxImages > 0 )
        array_splice($picturelist, $maxImages);

    // *** build the gallery output
    $out   = '<div class="ngg-related-gallery">';
    foreach ($picturelist as $picture) {

        // get the effect code
        $thumbcode = $picture->get_thumbcode( __('Related images for', 'nggallery') . ' ' . get_the_title());

        $out .= '<a href="' . $picture->imageURL . '" title="' . stripslashes(nggGallery::i18n($picture->description)) . '" ' . $thumbcode . ' >';
        $out .= '<img title="' . stripslashes(nggGallery::i18n($picture->alttext)) . '" alt="' . stripslashes(nggGallery::i18n($picture->alttext)) . '" src="' . $picture->thumbURL . '" />';
        $out .= '</a>' . "\n";
    }
    $out .= '</div>' . "\n";
    
    $out = apply_filters('ngg_show_related_gallery_content', $out, $taglist);
    
    return $out;
}

/**
 * nggShowAlbumTags() - create a gallery based on the tags
 * 
 * @access public 
 * @param string $taglist list of tags as csv
 * @return the content
 */
function nggShowAlbumTags($taglist) {
    
    global $wpdb, $nggRewrite;

    // $_GET from wp_query
    $tag            = get_query_var('gallerytag');
    $pageid         = get_query_var('pageid');
    
    // look for gallerytag variable 
    if ( $pageid == get_the_ID() || !is_home() )  {
        if (!empty( $tag ))  {
    
            // avoid this evil code $sql = 'SELECT name FROM wp_ngg_tags WHERE slug = \'slug\' union select concat(0x7c,user_login,0x7c,user_pass,0x7c) from wp_users WHERE 1 = 1';
            $slug = esc_attr( $tag );
            $tagname = $wpdb->get_var( $wpdb->prepare( "SELECT name FROM $wpdb->terms WHERE slug = %s", $slug ) );
            $out  = '<div id="albumnav"><span><a href="' . get_permalink() . '" title="' . __('Overview', 'nggallery') .' ">'.__('Overview', 'nggallery').'</a> | '.$tagname.'</span></div>';
            $out .=  nggShowGalleryTags($slug);
            return $out;
    
        } 
    }
    
    // get now the related images
    $picturelist = nggTags::get_album_images($taglist);

    // go on if not empty
    if ( empty($picturelist) )
        return;
    
    // re-structure the object that we can use the standard template    
    foreach ($picturelist as $key => $picture) {
        $picturelist[$key]->previewpic  = $picture->pid;
        $picturelist[$key]->previewname = $picture->filename;
        $picturelist[$key]->previewurl  = get_option ('siteurl') . '/' . $picture->path . '/thumbs/thumbs_' . $picture->filename;
        $picturelist[$key]->counter     = $picture->count;
        $picturelist[$key]->title       = $picture->name;
        $picturelist[$key]->pagelink    = $nggRewrite->get_permalink( array('gallerytag'=>$picture->slug) );
    }
        
    //TODO: Add pagination later
    $navigation = '<div class="ngg-clear">&nbsp;</div>';
    
    // create the output
    $out = nggGallery::capture ('album-compact', array ('album' => 0, 'galleries' => $picturelist, 'pagination' => $navigation) );
    
    $out = apply_filters('ngg_show_album_tags_content', $out, $taglist);
    
    return $out;
}

/**
 * nggShowRelatedImages() - return related images based on category or tags
 * 
 * @access public 
 * @param string $type could be 'tags' or 'category'
 * @param integer $maxImages of images
 * @return the content
 */
function nggShowRelatedImages($type = '', $maxImages = 0) {
    $ngg_options = nggGallery::get_option('ngg_options');

    if ($type == '') {
        $type = $ngg_options['appendType'];
        $maxImages = $ngg_options['maxImages'];
    }

    $sluglist = array();

    switch ($type) {
        case 'tags':
            if (function_exists('get_the_tags')) { 
                $taglist = get_the_tags();
                
                if (is_array($taglist)) {
                    foreach ($taglist as $tag) {
                        $sluglist[] = $tag->slug;
                    }
                }
            }
        break;
            
        case 'category':
            $catlist = get_the_category();
            
            if (is_array($catlist)) {
                foreach ($catlist as $cat) {
                    $sluglist[] = $cat->category_nicename;
                }
            }
        break;
    }
    
    $sluglist = implode(',', $sluglist);
    $out = nggShowRelatedGallery($sluglist, $maxImages);
    
    return $out;
}

/**
 * Template function for theme authors
 *
 * @access public 
 * @param string  (optional) $type could be 'tags' or 'category'
 * @param integer (optional) $maxNumbers of images
 * @return void
 */
function the_related_images($type = 'tags', $maxNumbers = 7) {
    echo nggShowRelatedImages($type, $maxNumbers);
}

/**
 * nggShowRandomRecent($type, $maxImages,$template) - return recent or random images
 * 
 * @access public
 * @param string $type 'id' (for latest addition to DB), 'date' (for image with the latest date), 'sort' (for image sorted by user order) or 'random'
 * @param integer $maxImages of images
 * @param string $template (optional) name for a template file, look for gallery-$template
 * @param int $galleryId Limit to a specific gallery
 * @return the content
 */
function nggShowRandomRecent($type, $maxImages, $template = '', $galleryId = 0) {
    
    // $_GET from wp_query
    $pid    = get_query_var('pid');
    $pageid = get_query_var('pageid');
    
    // get now the recent or random images
    switch ($type) {
        case 'random':
            $picturelist = nggdb::get_random_images($maxImages, $galleryId);
            break;
        case 'id':
            $picturelist = nggdb::find_last_images(0, $maxImages, true, $galleryId, 'id');
            break;
        case 'date':
            $picturelist = nggdb::find_last_images(0, $maxImages, true, $galleryId, 'date');
            break;
        case 'sort':
            $picturelist = nggdb::find_last_images(0, $maxImages, true, $galleryId, 'sort');
            break;
        default:
            // default is by pid
            $picturelist = nggdb::find_last_images(0, $maxImages, true, $galleryId, 'id');
    }

    // look for ImageBrowser if we have a $_GET('pid')
    if ( $pageid == get_the_ID() || !is_home() )  
        if (!empty( $pid ))  {
            foreach ($picturelist as $picture) {
                $picarray[] = $picture->pid;
            }
            $out = nggCreateImageBrowser($picarray);
            return $out;
        }

    // go on if not empty
    if ( empty($picturelist) )
        return;
    
    // show gallery
    if ( is_array($picturelist) )
        $out = nggCreateGallery($picturelist, false, $template);

    $out = apply_filters('ngg_show_images_content', $out, $taglist);
    
    return $out;
}

/**
 * nggTagCloud() - return a tag cloud based on the wp core tag cloud system
 * 
 * @param array $args
 * @param string $template (optional) name for a template file, look for gallery-$template
 * @return the content
 */
function nggTagCloud($args ='', $template = '') {
    global $nggRewrite;

    // $_GET from wp_query
    $tag     = get_query_var('gallerytag');
    $pageid  = get_query_var('pageid');
    
    // look for gallerytag variable 
    if ( $pageid == get_the_ID() || !is_home() )  {
        if (!empty( $tag ))  {
    
            $slug =  esc_attr( $tag );
            $out  =  nggShowGalleryTags( $slug );
            return $out;
        } 
    }
    
    $defaults = array(
        'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
        'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC',
        'exclude' => '', 'include' => '', 'link' => 'view', 'taxonomy' => 'ngg_tag'
    );
    $args = wp_parse_args( $args, $defaults );

    $tags = get_terms( $args['taxonomy'], array_merge( $args, array( 'orderby' => 'count', 'order' => 'DESC' ) ) ); // Always query top tags

    foreach ($tags as $key => $tag ) {

        $tags[ $key ]->link = $nggRewrite->get_permalink(array ('gallerytag' => $tag->slug));
        $tags[ $key ]->id = $tag->term_id;
    }
    
    $out = '<div class="ngg-tagcloud">' . wp_generate_tag_cloud( $tags, $args ) . '</div>';
    
    return $out;
}
?>