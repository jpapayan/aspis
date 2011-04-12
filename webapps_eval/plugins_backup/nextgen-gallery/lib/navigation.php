<?php
/**
 * nggNavigation - PHP class for the pagination
 * 
 * @package NextGEN Gallery
 * @author Alex Rabe 
 * @copyright 2009
 * @version 1.0.0
 * @access public
 */
class nggNavigation {

	/**
	 * Return the navigation output
	 *
	 * @access public
	 * @var string
	 */
	var $output = false;

	/**
	 * Link to previous page
	 *
	 * @access public
	 * @var string
	 */
	var $prev = false;

	/**
	 * Link to next page
	 *
	 * @access public
	 * @var string
	 */
	var $next = false;

	/**
	 * PHP4 compatibility layer for calling the PHP5 constructor.
	 * 
	 */
	function nggNavigation() {
		return $this->__construct();
	}

	/**
	 * Main constructor - Does nothing.
	 * Call create_navigation() method when you need a navigation.
	 * 
	 */	
	function __construct() {
		return;		
	}

	/**
	 * nggNavigation::create_navigation()
	 * 
	 * @param mixed $page
	 * @param integer $totalElement 
	 * @param integer $maxElement
	 * @return string pagination content
	 */
	function create_navigation($page, $totalElement, $maxElement = 0) {
		global $nggRewrite;
		
		if ($maxElement > 0) {
			$total = $totalElement;
			
			// create navigation	
			if ( $total > $maxElement ) {
				$total_pages = ceil( $total / $maxElement );
				$r = '';
				if ( 1 < $page ) {
					$args['nggpage'] = ( 1 == $page - 1 ) ? FALSE : $page - 1;
					$previous = $args['nggpage'];
					if (FALSE == $args['nggpage']) {
						$previous = 1; 
					}
					$this->prev = $nggRewrite->get_permalink ( $args );
					$r .=  '<a class="prev" id="ngg-prev-' . $previous . '" href="' . $this->prev . '">&#9668;</a>';
				}
				
				$total_pages = ceil( $total / $maxElement );
				
				if ( $total_pages > 1 ) {
					for ( $page_num = 1; $page_num <= $total_pages; $page_num++ ) {
						if ( $page == $page_num ) {
							$r .=  '<span>' . $page_num . '</span>';
						} else {
							$p = false;
							if ( $page_num < 3 || ( $page_num >= $page - 3 && $page_num <= $page + 3 ) || $page_num > $total_pages - 3 ) {
								$args['nggpage'] = ( 1 == $page_num ) ? FALSE : $page_num;
								$r .= '<a class="page-numbers" href="' . $nggRewrite->get_permalink( $args ) . '">' . ( $page_num ) . '</a>';
								$in = true;
							} elseif ( $in == true ) {
								$r .= '<span>...</span>';
								$in = false;
							}
						}
					}
				}
				
				if ( ( $page ) * $maxElement < $total || -1 == $total ) {
					$args['nggpage'] = $page + 1;
					$this->next = $nggRewrite->get_permalink ( $args );
					$r .=  '<a class="next" id="ngg-next-' . $args['nggpage'] . '" href="' . $this->next . '">&#9658;</a>';
				}
				
				$this->output = "<div class='ngg-navigation'>$r</div>";
			} else {
				$this->output = "<div class='ngg-clear'></div>"."\n";
			}
		}
		
		return $this->output;
	}
}
?>