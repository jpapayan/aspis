<?php

/**
* nggRewrite - First version of Rewrite Rules
*
* sorry wp-guys I didn't understand this at all. 
* I tried it a couple of hours : this is the only pooooor result
*
* @package NextGEN Gallery
* @author Alex Rabe
* @copyright 2008
*/
class nggRewrite {

	// default value
	var $slug = 'nggallery';	

	/**
	* Constructor
	*/
	function nggRewrite() {
		
		// read the option setting
		$this->options = get_option('ngg_options');
		
		// get later from the options
		$this->slug = 'nggallery';

		/*WARNING: Do nothook rewrite rule regentation on the init hook for anything other than dev. */
		//add_action('init',array(&$this, 'flush'));
		
		add_filter('query_vars', array(&$this, 'add_queryvars') );
		add_filter('wp_title' , array(&$this, 'rewrite_title') );
		
        //DD32 recommend : http://groups.google.com/group/wp-hackers/browse_thread/thread/50ac0d07e30765e9
        //add_filter('rewrite_rules_array', array($this, 'RewriteRules')); 
        	
		if ($this->options['usePermalinks'])
			add_action('generate_rewrite_rules', array(&$this, 'RewriteRules'));
		
		
	} // end of initialization

	/**
	* Get the permalink to a picture/album/gallery given its ID/name/...
	*/
	function get_permalink( $args ) {
		global $wp_rewrite, $wp_query;

		//TODO: Watch out for ticket http://trac.wordpress.org/ticket/6627
		if ($wp_rewrite->using_permalinks() && $this->options['usePermalinks'] ) {
			$post = &get_post(get_the_ID());

			// $_GET from wp_query
			$album = get_query_var('album');
			if ( !empty( $album ) )
				$args ['album'] = $album;
			
			$gallery = get_query_var('gallery');
			if ( !empty( $gallery ) )
				$args ['gallery'] = $gallery;
			
			$gallerytag = get_query_var('gallerytag');
			if ( !empty( $gallerytag ) )
				$args ['gallerytag'] = $gallerytag;
			
			/** urlconstructor =  slug | type | tags | [nav] | [show]
				type : 	page | post
				tags : 	album, gallery 	-> /album-([0-9]+)/gallery-([0-9]+)/
						pid 			-> /image/([0-9]+)/
						gallerytag		-> /tags/([^/]+)/
				nav	 : 	nggpage			-> /page-([0-9]+)/
				show : 	show=slide		-> /slideshow/
						show=gallery	-> /images/	
			**/

			// 1. Blog url + main slug
			$url = get_option('home') . '/' . $this->slug;
			
			// 2. Post or page ?
			if ( $post->post_type == 'page' )
				$url .= '/page-' . $post->ID; // Pagnename is nicer but how to handle /parent/pagename ? Confused...
			else
				$url .= '/post/' . $post->post_name;
			
			// 3. Album, pid or tags
				
			if (isset ($args['album']) && ($args['gallery'] == false) )
				$url .= '/album-' . $args['album'];
			elseif  (isset ($args['album']) && isset ($args['gallery']) )
				$url .= '/album-' . $args['album'] . '/gallery-' . $args['gallery'];
				
			if  (isset ($args['gallerytag']))
				$url .= '/tags/' . $args['gallerytag'];
				
			if  (isset ($args['pid']))
				$url .= '/image/' . $args['pid'];			
			
			// 4. Navigation
			if  (isset ($args['nggpage']) && ($args['nggpage']) )
				$url .= '/page-' . $args['nggpage'];
			
			// 5. Show images or Slideshow
			if  (isset ($args['show']))
				$url .= ( $args['show'] == 'slide' ) ? '/slideshow' : '/images';

			return $url;
			
		} else {			
			// we need to add the page/post id at the start_page otherwise we don't know which gallery is clicked
			if (is_home())
				$args['pageid'] = get_the_ID();
			
			// taken from is_frontpage plugin, required for static homepage
			$show_on_front = get_option('show_on_front');
			$page_on_front = get_option('page_on_front');
			
			if (($show_on_front == 'page') && ($page_on_front == get_the_ID()))
				$args['page_id'] = get_the_ID();
			
			if ( !is_singular() )
				$query = htmlspecialchars( add_query_arg($args, get_permalink( get_the_ID() )) );
			else
				$query = htmlspecialchars( add_query_arg( $args ) );
			
			return $query;
		}
	}

	/**
	* The permalinks needs to be flushed after activation
	*/
	function flush() { 
		global $wp_rewrite;
		
		$this->options = get_option('ngg_options');
		
		if ($this->options['usePermalinks'])
			add_action('generate_rewrite_rules', array(&$this, 'RewriteRules'));
			
		$wp_rewrite->flush_rules();
	}

	/**
	* add some more vars to the big wp_query
	*/
	function add_queryvars( $query_vars ){
		
		$query_vars[] = 'pid';
		$query_vars[] = 'pageid';
		$query_vars[] = 'nggpage';
		$query_vars[] = 'gallery';
		$query_vars[] = 'album';
		$query_vars[] = 'gallerytag';
		$query_vars[] = 'show';
        $query_vars[] = 'callback';

		return $query_vars;
	}
	
	/**
	* rewrite the blog title if the gallery is used
	*/	
	function rewrite_title($title) {
		
		$new_title = '';
		// the separataor
		$sep = ' &laquo; ';
		
		// $_GET from wp_query
		$pid     = get_query_var('pid');
		$pageid  = get_query_var('pageid');
		$nggpage = get_query_var('nggpage');
		$gallery = get_query_var('gallery');
		$album   = get_query_var('album');
		$tag  	 = get_query_var('gallerytag');
		$show    = get_query_var('show');

		//TODO:: I could parse for the Picture name , gallery etc, but this increase the queries
		//TODO:: Class nggdb need to cache the query for the nggfunctions.php

		if ( $show == 'slide' )
			$new_title .= __('Slideshow', 'nggallery') . $sep ;
		elseif ( $show == 'show' )
			$new_title .= __('Gallery', 'nggallery') . $sep ;	

		if ( !empty($pid) )
			$new_title .= __('Picture', 'nggallery') . ' ' . intval($pid) . $sep ;

		if ( !empty($album) )
			$new_title .= __('Album', 'nggallery') . ' ' . intval($album) . $sep ;

		if ( !empty($gallery) )
			$new_title .= __('Gallery', 'nggallery') . ' ' . intval($gallery) . $sep ;
			
		if ( !empty($nggpage) )
			$new_title .= __('Page', 'nggallery') . ' ' . intval($nggpage) . $sep ;
		
		//esc_attr should avoid XSS like http://domain/?gallerytag=%3C/title%3E%3Cscript%3Ealert(document.cookie)%3C/script%3E
		if ( !empty($tag) )
			$new_title .= esc_attr($tag) . $sep;
		
		//prepend the data
		$title = $new_title . $title;
		
		return $title;
	}
	
	/**
	 * Canonical support for a better SEO (Dupilcat content), not longer nedded for Wp 2.9
	 * See : http://googlewebmastercentral.blogspot.com/2009/02/specify-your-canonical.html
	 * 
	 * @deprecated
	 * @return string $meta 
	 */
	function add_canonical_meta()
    {
            // create the meta link
 			$meta  = "\n<link rel='canonical' href='" . get_permalink() ."' />";
 			// add a filter for SEO plugins, so they can remove it
 			echo apply_filters('ngg_add_canonical_meta', $meta);
  			
        return; 
    }
		
	/**
	* The actual rewrite rules
	*/
	function RewriteRules($wp_rewrite) {		
		$rewrite_rules = array (
            // XML request
            $this->slug.'/slideshow/([0-9]+)/?$' => 'index.php?imagerotator=true&gid=$matches[1]',
            
			// rewrite rules for pages
			$this->slug.'/page-([0-9]+)/?$' => 'index.php?page_id=$matches[1]',
			$this->slug.'/page-([0-9]+)/page-([0-9]+)/?$' => 'index.php?page_id=$matches[1]&nggpage=$matches[2]',
			$this->slug.'/page-([0-9]+)/image/([0-9]+)/?$' => 'index.php?page_id=$matches[1]&pid=$matches[2]',
			$this->slug.'/page-([0-9]+)/image/([0-9]+)/page-([0-9]+)/?$' => 'index.php?page_id=$matches[1]&pid=$matches[2]&nggpage=$matches[3]',
			$this->slug.'/page-([0-9]+)/slideshow/?$' => 'index.php?page_id=$matches[1]&show=slide',
			$this->slug.'/page-([0-9]+)/images/?$' => 'index.php?page_id=$matches[1]&show=gallery',
			$this->slug.'/page-([0-9]+)/tags/([^/]+)/?$' => 'index.php?page_id=$matches[1]&gallerytag=$matches[2]',
			$this->slug.'/page-([0-9]+)/tags/([^/]+)/page-([0-9]+)/?$' => 'index.php?page_id=$matches[1]&gallerytag=$matches[2]&nggpage=$matches[3]',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/page-([0-9]+)/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&nggpage=$matches[3]',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/gallery-([0-9]+)/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&gallery=$matches[3]',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/gallery-([0-9]+)/slideshow/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&gallery=$matches[3]&show=slide',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/gallery-([0-9]+)/images/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&gallery=$matches[3]&show=gallery',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/gallery-([0-9]+)/page/([0-9]+)/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&gallery=$matches[3]&pid=$matches[4]',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/gallery-([0-9]+)/page-([0-9]+)/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&gallery=$matches[3]&nggpage=$matches[4]',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/gallery-([0-9]+)/page-([0-9]+)/slideshow/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&gallery=$matches[3]&nggpage=$matches[4]&show=slide',
			$this->slug.'/page-([0-9]+)/album-([^/]+)/gallery-([0-9]+)/page-([0-9]+)/images/?$' => 'index.php?page_id=$matches[1]&album=$matches[2]&gallery=$matches[3]&nggpage=$matches[4]&show=gallery',
			
			// rewrite rules for posts
			$this->slug.'/post/([^/]+)/?$' => 'index.php?name=$matches[1]',
			$this->slug.'/post/([^/]+)/page-([0-9]+)/?$' => 'index.php?name=$matches[1]&nggpage=$matches[2]',
			$this->slug.'/post/([^/]+)/image/([0-9]+)/?$' => 'index.php?name=$matches[1]&pid=$matches[2]',
			$this->slug.'/post/([^/]+)/image/([0-9]+)/page-([0-9]+)/?$' => 'index.php?name=$matches[1]&pid=$matches[2]&nggpage=$matches[3]',
			$this->slug.'/post/([^/]+)/slideshow/?$' => 'index.php?name=$matches[1]&show=slide',
			$this->slug.'/post/([^/]+)/images/?$' => 'index.php?name=$matches[1]&show=gallery',
			$this->slug.'/post/([^/]+)/tags/([^/]+)/?$' => 'index.php?name=$matches[1]&gallerytag=$matches[2]',
			$this->slug.'/post/([^/]+)/tags/([^/]+)/page-([0-9]+)/?$' => 'index.php?name=$matches[1]&gallerytag=$matches[2]&nggpage=$matches[3]',
			$this->slug.'/post/([^/]+)/album-([^/]+)/?$' => 'index.php?name=$matches[1]&album=$matches[2]',
			$this->slug.'/post/([^/]+)/album-([^/]+)/page-([0-9]+)/?$' => 'index.php?name=$matches[1]&album=$matches[2]&nggpage=$matches[3]',
			$this->slug.'/post/([^/]+)/album-([^/]+)/gallery-([0-9]+)/?$' => 'index.php?name=$matches[1]&album=$matches[2]&gallery=$matches[3]',
			$this->slug.'/post/([^/]+)/album-([^/]+)/gallery-([0-9]+)/slideshow/?$' => 'index.php?name=$matches[1]&album=$matches[2]&gallery=$matches[3]&show=slide',
			$this->slug.'/post/([^/]+)/album-([^/]+)/gallery-([0-9]+)/images/?$' => 'index.php?name=$matches[1]&album=$matches[2]&gallery=$matches[3]&show=gallery',
			$this->slug.'/post/([^/]+)/album-([^/]+)/gallery-([0-9]+)/page/([0-9]+)/?$' => 'index.php?name=$matches[1]&album=$matches[2]&gallery=$matches[3]&pid=$matches[4]',
			$this->slug.'/post/([^/]+)/album-([^/]+)/gallery-([0-9]+)/page-([0-9]+)/?$' => 'index.php?name=$matches[1]&album=$matches[2]&gallery=$matches[3]&nggpage=$matches[4]',
			$this->slug.'/post/([^/]+)/album-([^/]+)/gallery-([0-9]+)/page-([0-9]+)/slideshow/?$' => 'index.php?name=$matches[1]&album=$matches[2]&gallery=$matches[3]&nggpage=$matches[4]&show=slide',
			$this->slug.'/post/([^/]+)/album-([^/]+)/gallery-([0-9]+)/page-([0-9]+)/images/?$' => 'index.php?name=$matches[1]&album=$matches[2]&gallery=$matches[3]&nggpage=$matches[4]&show=gallery',
		);
		
		$wp_rewrite->rules = array_merge($rewrite_rules, $wp_rewrite->rules);		
	}
	
}  // of nggRewrite CLASS

?>
