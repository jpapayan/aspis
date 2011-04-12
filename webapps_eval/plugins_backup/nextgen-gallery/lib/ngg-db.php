<?php
if ( !class_exists('nggdb') ) :
/**
 * NextGEN Gallery Database Class
 * 
 * @author Alex Rabe, Vincent Prat
 * @copyright 2008-2009
 * @since 1.0.0
 */
class nggdb {
    
    /**
     * Holds the list of all galleries
     *
     * @since 1.1.0
     * @access public
     * @var object|array
     */
    var $galleries = false;

    /**
     * Holds the list of all images
     *
     * @since 1.3.0
     * @access public
     * @var object|array
     */
    var $images = false;

    /**
     * Holds the list of all albums
     *
     * @since 1.3.0
     * @access public
     * @var object|array
     */
    var $albums = false;
    
    /**
     * The array for the pagination
     *
     * @since 1.1.0
     * @access public
     * @var array
     */
    var $paged = false;
    
    /**
     * PHP4 compatibility layer for calling the PHP5 constructor.
     * 
     */
    function nggdb() {
        return $this->__construct();
    }

    /**
     * Init the Database Abstraction layer for NextGEN Gallery
     * 
     */ 
    function __construct() {
        global $wpdb;
        
        $this->galleries = array();
        $this->images    = array();
        $this->albums    = array();
        $this->paged     = array();
        
        register_shutdown_function(array(&$this, '__destruct'));
        
    }
    
    /**
     * PHP5 style destructor and will run when database object is destroyed.
     *
     * @return bool Always true
     */
    function __destruct() {
        return true;
    }   

    /**
     * Get all the album nad unserialize the content
     * 
     * @since 1.3.0
     * @param string $order_by
     * @param string $order_dir
     * @return array $album
     */
    function find_all_album( $order_by = 'id', $order_dir = 'ASC') {    
        global $wpdb; 
        
        $order_dir = ( $order_dir == 'DESC') ? 'DESC' : 'ASC';
        $this->albums = $wpdb->get_results("SELECT * FROM $wpdb->nggalbum ORDER BY {$order_by} {$order_dir}" , OBJECT_K );
        
        if ( !$this->albums )
            return array();
        
        foreach ($this->albums as $key => $value) {
            $this->albums[$key]->galleries = empty ($this->albums[$key]->sortorder) ? array() : (array) unserialize($this->albums[$key]->sortorder)  ;
            $this->albums[$key]->name = stripslashes( $this->albums[$key]->name ); 
            $this->albums[$key]->albumdesc = stripslashes( $this->albums[$key]->albumdesc );
            wp_cache_add($key, $this->albums[$key], 'ngg_album'); 
        }
        
        return $this->albums;
    }

    /**
     * Get all the galleries
     * 
     * @param string $order_by
     * @param string $order_dir
     * @param bool $counter (optional) Select true  when you need to count the images
     * @param int $limit number of paged galleries, 0 shows all galleries
     * @param int $start the start index for paged galleries
     * @param bool $exclude
     * @return array $galleries
     */
    function find_all_galleries($order_by = 'gid', $order_dir = 'ASC', $counter = false, $limit = 0, $start = 0, $exclude = true) {      
        global $wpdb; 
        
        // Check for the exclude setting
        $exclude_clause = ($exclude) ? ' AND exclude<>1 ' : '';
        $order_dir = ( $order_dir == 'DESC') ? 'DESC' : 'ASC';
        $limit_by  = ( $limit > 0 ) ? 'LIMIT ' . intval($start) . ',' . intval($limit) : '';
        $this->galleries = $wpdb->get_results( "SELECT SQL_CALC_FOUND_ROWS * FROM $wpdb->nggallery ORDER BY {$order_by} {$order_dir} {$limit_by}", OBJECT_K );
        
        // Count the number of galleries and calculate the pagination
        if ($limit > 0) {
            $this->paged['total_objects'] = intval ( $wpdb->get_var( "SELECT FOUND_ROWS()" ) );
            $this->paged['objects_per_page'] = count( $this->galleries );
            $this->paged['max_objects_per_page'] = ( $limit > 0 ) ? ceil( $this->paged['total_objects'] / intval($limit)) : 1;
        }
        
        if ( !$this->galleries )
            return array();
        
        // get the galleries information    
        foreach ($this->galleries as $key => $value) {
            $galleriesID[] = $key;
            // init the counter values
            $this->galleries[$key]->counter = 0;
            $this->galleries[$key]->title = stripslashes($this->galleries[$key]->title);
            $this->galleries[$key]->galdesc  = stripslashes($this->galleries[$key]->galdesc);
            wp_cache_add($key, $this->galleries[$key], 'ngg_gallery');      
        }

        // if we didn't need to count the images then stop here
        if ( !$counter )
            return $this->galleries;
        
        // get the counter values   
        $picturesCounter = $wpdb->get_results('SELECT galleryid, COUNT(*) as counter FROM '.$wpdb->nggpictures.' WHERE galleryid IN (\''.implode('\',\'', $galleriesID).'\') ' . $exclude_clause . ' GROUP BY galleryid', OBJECT_K);

        if ( !$picturesCounter )
            return $this->galleries;
        
        // add the counter to the gallery objekt    
        foreach ($picturesCounter as $key => $value) {
            $this->galleries[$value->galleryid]->counter = $value->counter;
            wp_cache_add($value->galleryid, $this->galleries[$value->galleryid], 'ngg_gallery');
        }
        
        return $this->galleries;
    }
    
    /**
     * Get a gallery given its ID
     * 
     * @param int|string $id or $name
     * @return A nggGallery object (null if not found)
     */
    function find_gallery( $id ) {      
        global $wpdb;
        
        if( is_numeric($id) ) {
            
            if ( $gallery = wp_cache_get($id, 'ngg_gallery') )
                return $gallery;
            
            $gallery = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->nggallery WHERE gid = %d", $id ) );

        } else
            $gallery = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->nggallery WHERE name = %s", $id ) );
        
        // Build the object from the query result
        if ($gallery) {
            // it was a bad idea to use a object, stripslashes_deep() could not used here, learn from it
            $gallery->title = stripslashes($gallery->title);
            $gallery->galdesc  = stripslashes($gallery->galdesc);
            
            $gallery->abspath = WINABSPATH . $gallery->path;
            //TODO:Possible failure , $id could be a number or name
            wp_cache_add($id, $gallery, 'ngg_gallery');
            
            return $gallery;            
        } else 
            return false;
    }
    
    /**
     * This function return all information about the gallery and the images inside
     * 
     * @param int|string $id or $name
     * @param string $order_by 
     * @param string $order_dir (ASC |DESC)
     * @param bool $exclude
     * @param int $limit number of paged galleries, 0 shows all galleries
     * @param int $start the start index for paged galleries
     * @return An array containing the nggImage objects representing the images in the gallery.
     */
    function get_gallery($id, $order_by = 'sortorder', $order_dir = 'ASC', $exclude = true, $limit = 0, $start = 0) {

        global $wpdb;

        // init the gallery as empty array
        $gallery = array();
        
        // Check for the exclude setting
        $exclude_clause = ($exclude) ? ' AND tt.exclude<>1 ' : '';
        
        // Say no to any other value
        $order_dir = ( $order_dir == 'DESC') ? 'DESC' : 'ASC';
        $order_by  = ( empty($order_by) ) ? 'sortorder' : $order_by;
        
        // Should we limit this query ?
        $limit_by  = ( $limit > 0 ) ? 'LIMIT ' . intval($start) . ',' . intval($limit) : '';
        
        // Query database
        if( is_numeric($id) )
            $result = $wpdb->get_results( $wpdb->prepare( "SELECT SQL_CALC_FOUND_ROWS tt.*, t.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = %d {$exclude_clause} ORDER BY tt.{$order_by} {$order_dir} {$limit_by}", $id ), OBJECT_K );
        else
            $result = $wpdb->get_results( $wpdb->prepare( "SELECT SQL_CALC_FOUND_ROWS tt.*, t.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.name = %s {$exclude_clause} ORDER BY tt.{$order_by} {$order_dir} {$limit_by}", $id ), OBJECT_K );

        // Count the number of images and calculate the pagination
        if ($limit > 0) {
            $this->paged['total_objects'] = intval ( $wpdb->get_var( "SELECT FOUND_ROWS()" ) );
            $this->paged['objects_per_page'] = max ( count( $result ), $limit );
            $this->paged['max_objects_per_page'] = ( $limit > 0 ) ? ceil( $this->paged['total_objects'] / intval($limit)) : 1;
        }
        
        // Build the object
        if ($result) {
                
            // Now added all image data
            foreach ($result as $key => $value)
                $gallery[$key] = new nggImage( $value );
        }
        
        // Could not add to cache, the structure is different to find_gallery() cache_add, need rework
        //wp_cache_add($id, $gallery, 'ngg_gallery');

        return $gallery;        
    }
    
    /**
     * This function return all information about the gallery and the images inside
     * 
     * @param int|string $id or $name
     * @param string $orderby 
     * @param string $order (ASC |DESC)
     * @param bool $exclude
     * @return An array containing the nggImage objects representing the images in the gallery.
     */
    function get_ids_from_gallery($id, $order_by = 'sortorder', $order_dir = 'ASC', $exclude = true) {

        global $wpdb;
        
        // Check for the exclude setting
        $exclude_clause = ($exclude) ? ' AND tt.exclude<>1 ' : '';
        
        // Say no to any other value
        $order_dir = ( $order_dir == 'DESC') ? 'DESC' : 'ASC';      
        $order_by  = ( empty($order_by) ) ? 'sortorder' : $order_by;
                
        // Query database
        if( is_numeric($id) )
            $result = $wpdb->get_col( $wpdb->prepare( "SELECT tt.pid FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = %d $exclude_clause ORDER BY tt.{$order_by} $order_dir", $id ) );
        else
            $result = $wpdb->get_col( $wpdb->prepare( "SELECT tt.pid FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.name = %s $exclude_clause ORDER BY tt.{$order_by} $order_dir", $id ) );

        return $result;     
    }   
    
    /**
     * Delete a gallery AND all the pictures associated to this gallery!
     * 
     * @id The gallery ID
     */
    function delete_gallery( $id ) {        
        global $wpdb;
                
        $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->nggpictures WHERE galleryid = %d", $id) );
        $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->nggallery WHERE gid = %d", $id) );
        
        wp_cache_delete($id, 'ngg_gallery');
        
        //TODO:Remove all tag relationship
        return true;
    }

    /**
     * Get an album given its ID
     * 
     * @id The album ID or name
     * @return A nggGallery object (false if not found)
     */
    function find_album( $id ) {        
        global $wpdb;
        
        if ( $album = wp_cache_get($id, 'ngg_album') )
            return $album;
        
        // Query database
        if ( is_numeric($id) && $id != 0 ) {
            $album = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->nggalbum WHERE id = %d", $id) );
        } elseif ( $id == 'all' || (is_numeric($id) && $id == 0) ) {
            // init the object and fill it
            $album = new stdClass();
            $album->id = 'all';
            $album->name = __('Album overview','nggallery');
            $album->albumdesc  = __('Album overview','nggallery');
            $album->previewpic = 0;
            $album->sortorder  =  serialize( $wpdb->get_col("SELECT gid FROM $wpdb->nggallery") );
        } else {
            $album = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->nggalbum WHERE name = '%s'", $id) );
        }
        
        // Unserialize the galleries inside the album
        if ( $album ) {
            if ( !empty( $album->sortorder ) ) 
                $album->gallery_ids = unserialize( $album->sortorder );
            
            // it was a bad idea to use a object, stripslashes_deep() could not used here, learn from it
            $album->albumdesc  = stripslashes($album->albumdesc);
            $album->name       = stripslashes($album->name);
            
            wp_cache_add($id, $album, 'ngg_album');     
            return $album;
        } 
        
        return false;
    }
    
    /**
     * Delete an album
     * 
     * @id The album ID
     */
    function delete_album( $id ) {      
        global $wpdb;
                
        $result = $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->nggalbum WHERE id = %d", $id) );
        wp_cache_delete($id, 'ngg_album');
        
        return $result;
    }

    /**
     * Insert an image in the database
     * 
     * @return the ID of the inserted image
     */
    function insert_image($gid, $filename, $alttext, $desc, $exclude) {
        global $wpdb;
        
        $result = $wpdb->query(
              "INSERT INTO $wpdb->nggpictures (galleryid, filename, description, alttext, exclude) VALUES "
            . "('$gid', '$filename', '$desc', '$alttext', '$exclude');");
        $pid = (int) $wpdb->insert_id;
        wp_cache_delete($gid, 'ngg_gallery');
        
        return $pid;
    }

    /**
     * nggdb::update_image() - Insert an image in the database
     * 
     * @param int $pid   id of the image
     * @param (optional) string|int $galleryid
     * @param (optional) string $filename
     * @param (optional) string $description
     * @param (optional) string $alttext
     * @param (optional) int $exclude (0 or 1)
     * @param (optional) int $sortorder
     * @return bool result of the ID of the inserted image
     */
    function update_image($pid, $galleryid = false, $filename = false, $description = false, $alttext = false, $exclude = false, $sortorder = false) {

        global $wpdb;
        
        $sql = array();
        $pid = (int) $pid;
        
        $update = array(
            'galleryid'   => $galleryid,
            'filename'    => $filename,
            'description' => $description,
            'alttext'     => $alttext,
            'exclude'     => $exclude,
            'sortorder'   => $sortorder);
        
        // create the sql parameter "name = value"
        foreach ($update as $key => $value)
            if ($value)
                $sql[] = $key . " = '" . $value . "'";
        
        // create the final string
        $sql = implode(', ', $sql);
        
        if ( !empty($sql) && $pid != 0)
            $result = $wpdb->query( "UPDATE $wpdb->nggpictures SET $sql WHERE pid = $pid" );
        
        wp_cache_delete($pid, 'ngg_image'); 

        return $result;
    }
    
    /**
     * Get an image given its ID
     * 
     * @param int $id The image ID
     * @return object A nggImage object representing the image (false if not found)
     */
    function find_image( $id ) {
        global $wpdb;
        
        if ( $image = wp_cache_get($id, 'ngg_image') )
            return $image;
        
        $result = $wpdb->get_row( $wpdb->prepare( "SELECT tt.*, t.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.pid = %d ", $id ) );
        
        // Build the object from the query result
        if ($result) {
            $image = new nggImage($result);
            return $image;
        } 
                
        return false;
    }
    
    /**
     * Get images given a list of IDs 
     * 
     * @param $pids array of picture_ids
     * @return An array of nggImage objects representing the images
     */
    function find_images_in_list( $pids, $exclude = false, $order = 'ASC' ) {
        global $wpdb;
    
        $result = array();
        
        // Check for the exclude setting
        $exclude_clause = ($exclude) ? ' AND t.exclude <> 1 ' : '';

        // Check for the exclude setting
        $order_clause = ($order == 'RAND') ? 'ORDER BY rand() ' : ' ORDER BY t.pid ASC' ;
        
        if ( is_array($pids) ) {
            $id_list = "'" . implode("', '", $pids) . "'";
            
            // Save Query database
            $images = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggpictures AS t INNER JOIN $wpdb->nggallery AS tt ON t.galleryid = tt.gid WHERE t.pid IN ($id_list) $exclude_clause $order_clause", OBJECT_K);
    
            // Build the image objects from the query result
            if ($images) {  
                foreach ($images as $key => $image) 
                    $result[$key] = new nggImage( $image );
            } 
        }
        return $result;
    }

    /**
    * Add an image to the database
    * 
	* @since V1.4.0
	* @param int $pid   id of the gallery
    * @param (optional) string|int $galleryid
    * @param (optional) string $filename
    * @param (optional) string $description
    * @param (optional) string $alttext
    * @param (optional) array $meta data
    * @param (optional) int $post_id (required for sync with WP media lib)
    * @param (optional) string $imagedate
    * @param (optional) int $exclude (0 or 1)
    * @param (optional) int $sortorder
    * @return bool result of the ID of the inserted image
    */
    function add_image( $id = false, $filename = false, $description = '', $alttext = '', $meta_data = false, $post_id = 0, $imagedate = '0000-00-00 00:00:00', $exclude = 0, $sortorder = 0  ) {
        global $wpdb;
                
		if ( is_array($meta_data) )
			$meta_data = serialize($meta_data);
			
		// Add the image
		if ( false === $wpdb->query( $wpdb->prepare("INSERT INTO $wpdb->nggpictures (galleryid, filename, description, alttext, meta_data, post_id, imagedate, exclude, sortorder) 
													 VALUES (%d, %s, %s, %s, %s, %d, %s, %d, %d)", $id, $filename, $description, $alttext, $meta_data, $post_id, $imagedate, $exclude, $sortorder ) ) ) {
			return false;
		}
		
		$imageID = (int) $wpdb->insert_id;
			
		// Remove from cache the galley, needs to be rebuild now
	    wp_cache_delete( $id, 'ngg_gallery'); 
		//and give me the new id
		
		return $imageID;
    }
    
    /**
    * Delete an image entry from the database
    * @param integer $id is the Image ID
    */
    function delete_image( $id ) {
        global $wpdb;
        
        // Delete the image
        $result = $wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->nggpictures WHERE pid = %d", $id) );
        
        // Delete tag references
        wp_delete_object_term_relationships( $id, 'ngg_tag');
        
        // Remove from cache
        wp_cache_delete( $id, 'ngg_image'); 
        
        return $result;
    }
    
    /**
     * Get the last images registered in the database with a maximum number of $limit results
     * 
     * @param integer $page
     * @param integer $limit
     * @param bool $use_exclude
     * @param int $galleryId Only look for images with this gallery id, or in all galleries if id is 0
     * @param string $orderby is one of "id" (default, order by pid), "date" (order by exif date), sort (order by user sort order)
     * @return
     */
    function find_last_images($page = 0, $limit = 30, $exclude = true, $galleryId = 0, $orderby = "id") {
        global $wpdb;
        
        // Check for the exclude setting
        $exclude_clause = ($exclude) ? ' AND exclude<>1 ' : '';
        
        $offset = (int) $page * $limit;
        
        $galleryId = (int) $galleryId;
        $gallery_clause = ($galleryId === 0) ? '' : ' AND galleryid = ' . $galleryId . ' ';

        // default order by pid
        $order = 'pid DESC';
        switch ($orderby) {
            case 'date':
                $order = 'imagedate DESC';
                break;
            case 'sort':
                $order = 'sortorder ASC';
                break;
        }
        
        $result = array();
        $gallery_cache = array();
        
        // Query database
        $images = $wpdb->get_results("SELECT * FROM $wpdb->nggpictures WHERE 1=1 $exclude_clause $gallery_clause ORDER BY $order LIMIT $offset, $limit");
        
        // Build the object from the query result
        if ($images) {  
            foreach ($images as $key => $image) {
                
                // cache a gallery , so we didn't need to lookup twice
                if (!array_key_exists($image->galleryid, $gallery_cache))
                    $gallery_cache[$image->galleryid] = nggdb::find_gallery($image->galleryid);
                
                // Join gallery information with picture information    
                foreach ($gallery_cache[$image->galleryid] as $index => $value)
                    $image->$index = $value;
                
                // Now get the complete image data
                $result[$key] = new nggImage( $image );
            }
        }
        
        return $result;
    }
    
    /**
     * nggdb::get_random_images() - Get an random image from one ore more gally
     * 
     * @param integer $number of images
     * @param integer $galleryID optional a Gallery
     * @return A nggImage object representing the image (null if not found)
     */
    function get_random_images($number = 1, $galleryID = 0) {
        global $wpdb;
        
        $number = (int) $number;
        $galleryID = (int) $galleryID;
        $images = array();
        
        // Query database
        if ($galleryID == 0)
            $result = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.exclude != 1 ORDER by rand() limit $number");
        else
            $result = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE t.gid = $galleryID AND tt.exclude != 1 ORDER by rand() limit {$number}");
        
        // Return the object from the query result
        if ($result) {
            foreach ($result as $image) {
                $images[] = new nggImage( $image );
            }
            return $images;
        } 
            
        return null;
    }

    /**
     * Get all the images from a given album
     * 
     * @param object|int $album The album object or the id  
     * @param string $order_by
     * @param string $order_dir
     * @param bool $exclude
     * @return An array containing the nggImage objects representing the images in the album.
     */
    function find_images_in_album($album, $order_by = 'galleryid', $order_dir = 'ASC', $exclude = true) {        
        global $wpdb;
        
        if ( !is_object($album) )
            $album = nggdb::find_album( $album );

        // Get gallery list      
        $gallery_list = implode(',', $album->gallery_ids);       
        // Check for the exclude setting
        $exclude_clause = ($exclude) ? ' AND tt.exclude<>1 ' : '';

        // Say no to any other value
        $order_dir = ( $order_dir == 'DESC') ? 'DESC' : 'ASC';      
        $order_by  = ( empty($order_by) ) ? 'galleryid' : $order_by;
        
        $result = $wpdb->get_results("SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.galleryid IN ($gallery_list) $exclude_clause ORDER BY tt.$order_by $order_dir");      
        // Return the object from the query result
        if ($result) {
            foreach ($result as $image) {
                $images[] = new nggImage( $image );
            }
            return $images;
        } 

        return null;     
    }

    /**
     * search for images and return the result
     * 
     * @since 1.3.0
     * @param string $request
     * @return Array Result of the request
     */
    function search_for_images( $request ) {
        global $wpdb;
        
        // If a search pattern is specified, load the posts that match
        if ( !empty($request) ) {
            // added slashes screw with quote grouping when done early, so done later
            $request = stripslashes($request);
            
            // split the words it a array if seperated by a space or comma
            preg_match_all('/".*?("|$)|((?<=[\\s",+])|^)[^\\s",+]+/', $request, $matches);
            $search_terms = array_map(create_function('$a', 'return trim($a, "\\"\'\\n\\r ");'), $matches[0]);
            
            $n = '%';
            $searchand = '';
            $search = '';
            
            foreach( (array) $search_terms as $term) {
                $term = addslashes_gpc($term);
                $search .= "{$searchand}((tt.description LIKE '{$n}{$term}{$n}') OR (tt.alttext LIKE '{$n}{$term}{$n}') OR (tt.filename LIKE '{$n}{$term}{$n}'))";
                $searchand = ' AND ';
            }
            
            $term = $wpdb->escape($request);
            if (count($search_terms) > 1 && $search_terms[0] != $request )
                $search .= " OR (tt.description LIKE '{$n}{$term}{$n}') OR (tt.alttext LIKE '{$n}{$term}{$n}') OR (tt.filename LIKE '{$n}{$term}{$n}')";

            if ( !empty($search) )
                $search = " AND ({$search}) ";
        }
        
        // build the final query
        $query = "SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE 1=1 $search ORDER BY tt.pid ASC ";
        $result = $wpdb->get_results($query);

        // Return the object from the query result
        if ($result) {
            foreach ($result as $image) {
                $images[] = new nggImage( $image );
            }
            return $images;
        } 

        return null;
    }

    /**
     * search for a filename
     * 
     * @since 1.4.0
     * @param string $filename
     * @param int (optional) $galleryID
     * @return Array Result of the request
     */
    function search_for_file( $filename, $galleryID = false ) {
        global $wpdb;
        
        // If a search pattern is specified, load the posts that match
        if ( !empty($filename) ) {
            // added slashes screw with quote grouping when done early, so done later
            $term = $wpdb->escape($filename);
            
           	$where_clause = '';
            if ( is_numeric($galleryID) ) {
            	$id = (int) $galleryID;
            	$where_clause = " AND tt.galleryid = {$id}";
            }
        }
        
        // build the final query
        $query = "SELECT t.*, tt.* FROM $wpdb->nggallery AS t INNER JOIN $wpdb->nggpictures AS tt ON t.gid = tt.galleryid WHERE tt.filename = '{$term}' {$where_clause} ORDER BY tt.pid ASC ";
		$result = $wpdb->get_row($query);

        // Return the object from the query result
        if ($result) {
        	$image = new nggImage( $result );
            return $image;
        } 

        return null;
    }

    
    /**
     * Update or add meta data for an image
     * 
     * @since 1.4.0
     * @param int $id The image ID
     * @param array $values An array with existing or new values
     * @return bool result of query
     */ 
    function update_image_meta( $id, $new_values ) {
        global $wpdb;
        
        // Query database for existing values
        // Use cache object
        $old_values = $wpdb->get_var( $wpdb->prepare( "SELECT meta_data FROM $wpdb->nggpictures WHERE pid = %d ", $id ) );
        $old_values = unserialize( $old_values );

        $meta = array_merge( (array)$old_values, (array)$new_values );
		
        $result = $wpdb->query( $wpdb->prepare("UPDATE $wpdb->nggpictures SET meta_data = %s WHERE pid = %d", serialize($meta), $id) );
        
        wp_cache_delete($id, 'ngg_image');
        
        return $result;
    }

}
endif;

if ( ! isset($GLOBALS['nggdb']) ) {
    /**
     * Initate the NextGEN Gallery Database Object, for later cache reasons
     * @global object $nggdb Creates a new nggdb object
     * @since 1.1.0
     */
    unset($GLOBALS['nggdb']);
    $GLOBALS['nggdb'] = new nggdb() ;
}
?>