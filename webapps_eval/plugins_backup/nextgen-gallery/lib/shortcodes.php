<?php
/**
 * @author Alex Rabe, Vincent Prat 
 * @copyright 2008 - 2009
 * @since 1.0.0
 * @description Use WordPress Shortcode API for more features
 * @Docs http://codex.wordpress.org/Shortcode_API
 */

class NextGEN_shortcodes {
    
    // register the new shortcodes
    function NextGEN_shortcodes() {
		
		//Long posts should require a higher limit, see http://core.trac.wordpress.org/ticket/8553
		@ini_set('pcre.backtrack_limit', 500000);
    
        // convert the old shortcode
        add_filter('the_content', array(&$this, 'convert_shortcode'));
        
        // do_shortcode on the_excerpt could causes several unwanted output. Uncomment it on your own risk
        // add_filter('the_excerpt', array(&$this, 'convert_shortcode'));
        // add_filter('the_excerpt', 'do_shortcode', 11);
        
        add_shortcode( 'singlepic', array(&$this, 'show_singlepic' ) );
        add_shortcode( 'album', array(&$this, 'show_album' ) );
        add_shortcode( 'nggallery', array(&$this, 'show_gallery') );
        add_shortcode( 'imagebrowser', array(&$this, 'show_imagebrowser' ) );
        add_shortcode( 'slideshow', array(&$this, 'show_slideshow' ) );
        add_shortcode( 'nggtags', array(&$this, 'show_tags' ) );
        add_shortcode( 'thumb', array(&$this, 'show_thumbs' ) );
        add_shortcode( 'random', array(&$this, 'show_random' ) );
        add_shortcode( 'recent', array(&$this, 'show_recent' ) );
        add_shortcode( 'tagcloud', array(&$this, 'show_tagcloud' ) );
    }

     /**
       * NextGEN_shortcodes::convert_shortcode()
       * convert old shortcodes to the new WordPress core style
       * [gallery=1]  ->> [nggallery id=1]
       * 
       * @param string $content Content to search for shortcodes
       * @return string Content with new shortcodes.
       */
    function convert_shortcode($content) {
        
        $ngg_options = nggGallery::get_option('ngg_options');
    
        if ( stristr( $content, '[singlepic' )) {
            $search = "@\[singlepic=(\d+)(|,\d+|,)(|,\d+|,)(|,watermark|,web20|,)(|,right|,center|,left|,)\]@i";
            if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    // remove the comma
                    $match[2] = ltrim($match[2], ',');
                    $match[3] = ltrim($match[3], ',');  
                    $match[4] = ltrim($match[4], ',');  
                    $match[5] = ltrim($match[5], ',');                      
                    $replace = "[singlepic id=\"{$match[1]}\" w=\"{$match[2]}\" h=\"{$match[3]}\" mode=\"{$match[4]}\" float=\"{$match[5]}\" ]";
                    $content = str_replace ($match[0], $replace, $content);
                }
            }
        }

        if ( stristr( $content, '[album' )) {
            $search = "@(?:<p>)*\s*\[album\s*=\s*(\w+|^\+)(|,extend|,compact)\]\s*(?:</p>)*@i"; 
            if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    // remove the comma
                    $match[2] = ltrim($match[2],',');
                    $replace = "[album id=\"{$match[1]}\" template=\"{$match[2]}\"]";
                    $content = str_replace ($match[0], $replace, $content);
                }
            }
        }       

        if ( stristr( $content, '[gallery' )) {
            $search = "@(?:<p>)*\s*\[gallery\s*=\s*(\w+|^\+)\]\s*(?:</p>)*@i";
            if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    $replace = "[nggallery id=\"{$match[1]}\"]";
                    $content = str_replace ($match[0], $replace, $content);
                }
            }
        }   

        if ( stristr( $content, '[imagebrowser' )) {
            $search = "@(?:<p>)*\s*\[imagebrowser\s*=\s*(\w+|^\+)\]\s*(?:</p>)*@i";
            if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    $replace = "[imagebrowser id=\"{$match[1]}\"]";
                    $content = str_replace ($match[0], $replace, $content);
                }
            }
        }

        if ( stristr( $content, '[slideshow' )) {
            $search = "@(?:<p>)*\s*\[slideshow\s*=\s*(\w+|^\+)(|,(\d+)|,)(|,(\d+))\]\s*(?:</p>)*@i";
            if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    // remove the comma
                    $match[3] = ltrim($match[3],',');
                    $match[5] = ltrim($match[5],',');   
                    $replace = "[slideshow id=\"{$match[1]}\" w=\"{$match[3]}\" h=\"{$match[5]}\"]";
                    $content = str_replace ($match[0], $replace, $content);
                }
            }
        }

        if ( stristr( $content, '[tags' )) {
            $search = "@(?:<p>)*\s*\[tags\s*=\s*(.*?)\s*\]\s*(?:</p>)*@i";
            if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    $replace = "[nggtags gallery=\"{$match[1]}\"]";
                    $content = str_replace ($match[0], $replace, $content);
                }
            }
        }
        
        if ( stristr( $content, '[albumtags' )) {
            $search = "@(?:<p>)*\s*\[albumtags\s*=\s*(.*?)\s*\]\s*(?:</p>)*@i";
            if (preg_match_all($search, $content, $matches, PREG_SET_ORDER)) {

                foreach ($matches as $match) {
                    $replace = "[nggtags album=\"{$match[1]}\"]";
                    $content = str_replace ($match[0], $replace, $content);
                }
            }
        }

        // attach related images based on category or tags
        if ($ngg_options['activateTags']) 
            $content .= nggShowRelatedImages();
        
        return $content;
    }
    
    /**
     * Function to show a single picture:
     * 
     *     [singlepic id="10" float="none|left|right" width="" height="" mode="none|watermark|web20" link="url" "template="filename" /]
     *
     * where
     *  - id is one picture id
     *  - float is the CSS float property to apply to the thumbnail
     *  - width is width of the single picture you want to show (original width if this parameter is missing)
     *  - height is height of the single picture you want to show (original height if this parameter is missing)
     *  - mode is one of none, watermark or web20 (transformation applied to the picture)
     *  - link is optional and could link to a other url instead the full image
     *  - template is a name for a gallery template, which is located in themefolder/nggallery or plugins/nextgen-gallery/view
     * 
     * If the tag contains some text, this will be inserted as an additional caption to the picture too. Example:
     *      [singlepic id="10"]This is an additional caption[/singlepic]
     * This tag will show a picture with under it two HTML span elements containing respectively the alttext of the picture 
     * and the additional caption specified in the tag. 
     * 
     * @param array $atts
     * @param string $caption text
     * @return the content
     */
    function show_singlepic( $atts, $content = '' ) {
    
        extract(shortcode_atts(array(
            'id'        => 0,
            'w'         => '',
            'h'         => '',
            'mode'      => '',
            'float'     => '',
            'link'      => '',
            'template'  => ''
        ), $atts ));
    
        $out = nggSinglePicture($id, $w, $h, $mode, $float, $template, $content, $link);
            
        return $out;
    }

    function show_album( $atts ) {
    
        extract(shortcode_atts(array(
            'id'        => 0,
            'template'  => 'extend' 
        ), $atts ));
        
        $out = nggShowAlbum($id, $template);
            
        return $out;
    }
    /**
     * Function to show a thumbnail or a set of thumbnails with shortcode of type:
     * 
     * [gallery id="1,2,4,5,..." template="filename" images="number of images per page" /]
     * where 
     * - id of a gallery
     * - images is the number of images per page (optional), 0 will show all images
     * - template is a name for a gallery template, which is located in themefolder/nggallery or plugins/nextgen-gallery/view
     * 
     * @param array $atts
     * @return the_content
     */
    function show_gallery( $atts ) {
    
        extract(shortcode_atts(array(
            'id'        => 0,
            'template'  => '',  
            'images'    => false
        ), $atts ));
        
        // backward compat for user which uses the name instead, still deprecated
        if( !is_numeric($id) )
            $id = $wpdb->get_var( $wpdb->prepare ("SELECT gid FROM $wpdb->nggallery WHERE name = '%s' "), $id );
            
        $out = nggShowGallery( $id, $template, $images );
            
        return $out;
    }

    function show_imagebrowser( $atts ) {
        
        global $wpdb;
    
        extract(shortcode_atts(array(
            'id'        => 0,
            'template'  => ''   
        ), $atts ));

        $out = nggShowImageBrowser($id, $template);
            
        return $out;
    }
    
    function show_slideshow( $atts ) {
        
        global $wpdb;
    
        extract(shortcode_atts(array(
            'id'        => 0,
            'w'         => '',
            'h'         => ''
        ), $atts ));
        
        if( !is_numeric($id) )
            $id = $wpdb->get_var( $wpdb->prepare ("SELECT gid FROM $wpdb->nggallery WHERE name = '%s' "), $id );

        if( !empty( $id ) )
            $out = nggShowSlideshow($id, $w, $h);
        else 
            $out = __('[Gallery not found]','nggallery');
            
        return $out;
    }
    
    function show_tags( $atts ) {
    
        extract(shortcode_atts(array(
            'gallery'       => '',
            'album'         => ''
        ), $atts ));
        
        if ( !empty($album) )
            $out = nggShowAlbumTags($album);
        else
            $out = nggShowGalleryTags($gallery);
        
        return $out;
    }

    /**
     * Function to show a thumbnail or a set of thumbnails with shortcode of type:
     * 
     * [thumb id="1,2,4,5,..." template="filename" /]
     * where 
     * - id is one or more picture ids
     * - template is a name for a gallery template, which is located in themefolder/nggallery or plugins/nextgen-gallery/view
     * 
     * @param array $atts
     * @return the_content
     */
    function show_thumbs( $atts ) {
    
        extract(shortcode_atts(array(
            'id'        => '',
            'template'  => ''
        ), $atts));
        
        // make an array out of the ids
        $pids = explode( ',', $id );
        
        // Some error checks
        if ( count($pids) == 0 )
            return __('[Pictures not found]','nggallery');
        
        $picturelist = nggdb::find_images_in_list( $pids );
        
        // show gallery
        if ( is_array($picturelist) )
            $out = nggCreateGallery($picturelist, false, $template);
        
        return $out;
    }

    /**
     * Function to show a gallery of random or the most recent images with shortcode of type:
     * 
     * [random max="7" template="filename" id="2" /]
     * [recent max="7" template="filename" id="3" mode="date" /]
     * where 
     * - max is the maximum number of random or recent images to show
     * - template is a name for a gallery template, which is located in themefolder/nggallery or plugins/nextgen-gallery/view
     * - id is the gallery id, if the recent/random pictures shall be taken from a specific gallery only
     * - mode is either "id" (which takes the latest additions to the databse, default) 
     *               or "date" (which takes the latest pictures by EXIF date) 
     *               or "sort" (which takes the pictures by user sort order)
     * 
     * @param array $atts
     * @return the_content
     */
    function show_random( $atts ) {
    
        extract(shortcode_atts(array(
            'max'       => '',
            'template'  => '',
            'id'        => 0
        ), $atts));
        
        $out = nggShowRandomRecent('random', $max, $template, $id);
        
        return $out;
    }

    function show_recent( $atts ) {
    
        extract(shortcode_atts(array(
            'max'       => '',
            'template'  => '',
            'id'        => 0,
            'mode'      => 'id'
        ), $atts));
        
        $out = nggShowRandomRecent($mode, $max, $template, $id);
        
        return $out;
    }

    /**
     * Shortcode for the Image tag cloud
     * Usage : [tagcloud template="filename" /]
     * 
     * @param array $atts
     * @return the content
     */
    function show_tagcloud( $atts ) {
    
        extract(shortcode_atts(array(
            'template'  => ''
        ), $atts));
        
        $out = nggTagCloud( '', $template );
        
        return $out;
    }

}

// let's use it
$nggShortcodes = new NextGEN_Shortcodes;    

?>