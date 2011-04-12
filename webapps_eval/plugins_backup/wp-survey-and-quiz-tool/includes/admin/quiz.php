<?php
/**
 * Contains all the function logic required
 * 
 * @author Iain Cambridge
 */


/**
 * Shows form to allow user to create a new quiz or
 * just edit an old one. Does simple validation to 
 * ensure required fields are provided and if are 
 * select input area ensure that they are the correct
 * value.
 * 
 * @param boolean $edit Tells us if it's an quiz being edited or created.
 * 
 * @uses pages/admin/quiz/create.php
 * @uses wpdb
 * 
 * @since 1.0
 */
function wpsqt_admin_quiz_form($edit = false){
	
	global $wpdb;	
		
	$errorArray = array();	
	
	if ( !empty($_POST) ){
		
		// Check quiz name
		if ( !isset($_POST['quiz_name']) || empty($_POST['quiz_name']) ){
			$errorArray[] = 'Quiz name can\'t be empty.';		
		}
		
		// Check status
		if ( !isset($_POST['status']) || empty($_POST['status']) ){
			$errorArray[] = 'Status can\'t be empty';
		}
		elseif ( $_POST['status'] != 'enabled' && $_POST['status'] != 'disabled'){
			$errorArray = 'Status isn\'t an acceptable value';
		}
		
		// Check notification type
		if ( !isset($_POST['notification_type']) || empty($_POST['notification_type']) ){
			$errorArray[] = 'Notification type can\'t be empty';
		}
		elseif ( $_POST['notification_type'] != 'none' &&  $_POST['notification_type'] != 'instant' 
			 &&  $_POST['notification_type'] != 'instant-100' &&  $_POST['notification_type'] != 'instant-75'  
			 &&  $_POST['notification_type'] != 'instant-50'
			 &&  $_POST['notification_type'] != 'daily' &&  $_POST['notification_type'] != 'hourly' ){
			$errorArray[] = 'Notification type isn\'t an acceptable value';
		}
				
		// Check display result
		if ( !isset($_POST['display_result']) || empty($_POST['display_result']) ){
			$errorArray[] = 'Display result on completetion can\'t be empty';
		}
		elseif ( $_POST['display_result'] != 'yes' && $_POST['display_result'] != 'no' ){
			$errorArray[] = 'Display result isn\'t an acceptable value';
		}
	
		// Check display result
		if ( !isset($_POST['take_details']) || empty($_POST['take_details']) ){
			$errorArray[] = 'Take details can\'t be empty';
		}
		elseif ( $_POST['take_details'] != 'yes' && $_POST['take_details'] != 'no' ){
			$errorArray[] = 'Take details isn\'t an acceptable value';
		}
		
		// Check display result
		if ( !isset($_POST['use_wp_user']) || empty($_POST['use_wp_user']) ){
			$errorArray[] = 'Use Wordpress User Details can\'t be empty';
		}
		elseif ( $_POST['use_wp_user'] != 'yes' && $_POST['use_wp_user'] != 'no' ){
			$errorArray[] = 'Use Wordpress User Details isn\'t an acceptable value';
		}
				
	}
	
	if ( !empty($_POST) && empty($errorArray) ){
		if ( $edit == false ){			
			$wpdb->query( $wpdb->prepare('INSERT INTO '.WPSQT_QUIZ_TABLE.' (name,display_result,status,notification_type,take_details,use_wp_user)  VALUES (%s,%s,%s,%s,%s,%s)',
									  array($_POST['quiz_name'],$_POST['display_result'],$_POST['status'],$_POST['notification_type'],$_POST['take_details'],$_POST['use_wp_user']) ) );
			$successMessage = 'Quiz inserted';
		}
		else{
			$wpdb->query( $wpdb->prepare('UPDATE '.WPSQT_QUIZ_TABLE.' SET name=%s,display_result=%s,status=%s,notification_type=%s,take_details=%s,use_wp_user=%s WHERE id = %d',
									  array($_POST['quiz_name'] , $_POST['display_result'] , $_POST['status'] , $_POST['notification_type'] , $_POST['take_details'] , $_POST['use_wp_user'] , $_GET['quizid'] )) );
			$successMessage = 'Quiz updated';
		}
		
		if ( $_POST['notification_type'] != 'instant' ){			
			$functionName = ( $_POST['notification_type'] == 'hourly' ) ? 'hourly_mail' : 'daily_mail' ;			
			wp_schedule_event(time(), $_POST['notification_type'] , $functionName);
		}
	}	
	
	if ( $edit == true && ctype_digit($_GET['quizid']) ){
		$quizId = (int) $_GET['quizid'];
		$quizDetails = $wpdb->get_row('SELECT name,display_result,status,notification_type,take_details,use_wp_user FROM '.WPSQT_QUIZ_TABLE.' WHERE id = '.$quizId, ARRAY_A);
	}

	require_once wpsqt_page_display('admin/quiz/create.php');
	return;								  
}

/**
 * Displays a list of quiz/survey's in the system.
 * With links to configure, edit questions and 
 * delete. Display's the quiz/survey's status and
 * type (if it's a quiz or a survey).
 * 
 * @uses pages/admin/quiz/index.php
 * @uses includes/functions.php
 * 
 * @since 1.0
 */

function wpsqt_admin_quiz_list(){
	
	global $wpdb;
	
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$itemsPerPage = get_option('wpsqt_number_of_items');
	$currentPage = wpsqt_functions_pagenation_pagenumber();	
	$startNumber = ( ($currentPage - 1) * $itemsPerPage );	
	
	$rawQuizList = $wpdb->get_results( 'SELECT id,name,status FROM '.WPSQT_QUIZ_TABLE.' ORDER BY id' , ARRAY_A );
	$quizList = array_slice($rawQuizList , $startNumber , $itemsPerPage );
	$numberOfItems = sizeof($rawQuizList);
	$numberOfPages = wpsqt_functions_pagenation_pagecount($numberOfItems, $itemsPerPage);

	require_once wpsqt_page_display('admin/quiz/index.php');
}

/**
 * Shows form to allow users to create and manage sections.
 * Requires $_GET['quizid'] if not present or valid datatype
 * redirects to quiz list. Also processes data ensuring valid
 * and correct datatype. On inserting to the database, it 1st
 * deletes all previous entries and then inserts all the new 
 * ones. (Proably a better way of doing that)
 * 
 * @uses wpdb
 * @uses pages/admin/quiz/sections.php
 * @uses includes/functions.php
 * 
 * @since 1.0
 */

function wpsqt_admin_quiz_sections(){
	
	global $wpdb;
	
	// Ensure we have a quiz id otherwise return to quiz list.
	if ( !isset($_GET['quizid']) || !ctype_digit($_GET['quizid']) ){	
		require_once WPSQT_DIR.'/includes/functions.php';
		$redirectUrl = wpsqt_functions_generate_uri( array('page','action') );
		$redirectUrl .= '&page='.WPSQT_PAGE_QUIZ; 
	}
	else {		
		if ( !empty($_POST) ){			
			$validData = array();
		    
			for ( $i = 0; $i < sizeof($_POST['section_name']); $i++ ){
				// Check and make sure all data required is given
				// aswell as ensuring data is correct type. If not
				// we'll just skip to the next one.
				// Here comes a massive if statement...
		    	if (
		    	  // Make sure we have all the data required. 
		    		( !isset($_POST['section_name'][$i]) || empty($_POST['section_name'][$i])
		    	   || !isset($_POST['difficulty'][$i]) || empty($_POST['difficulty'][$i])
		    	   || !isset($_POST['number'][$i]) || empty($_POST['number'][$i])
		    	   || !isset($_POST['type'][$i]) || empty($_POST['type'][$i]) 	
		    	   || !isset($_POST['order'][$i]) || empty($_POST['order'][$i]) ) 		
		    	       	  	 
		    	   // Section difficulty can only be easy, medium, mixed or hard.
				   || ( $_POST['difficulty'][$i] != 'easy' && $_POST['difficulty'][$i] != 'mixed'
		    	   && $_POST['difficulty'][$i] != 'medium' && $_POST['difficulty'][$i] != 'hard' )
		    	   
		    	   // Check that question order is a valid 
				   || ( $_POST['order'][$i] != 'random' && $_POST['order'][$i] != 'asc'
				   	 && $_POST['order'][$i] != 'desc' )
		    	   
                   // Number of questions has to be an integer.
		    	   || ( !ctype_digit($_POST['number'][$i])  )
		    	   
		    	   // Section type can only be multiple or textarea.
		    	   || ( $_POST['type'][$i] != 'multiple' && $_POST['type'][$i] != 'textarea' )
		    	 ){
		    	  	$status = 'delete';
		    	 } else {
		    	 	$status = 'input';
		    	 }
		    	 
		    	 $sectionId = (isset($_POST['sectionid'][$i])) ? intval($_POST['sectionid'][$i]) : NULL;
		    	 // All that, just for this...
		    	 $validData[] = array( 'name'       => $_POST['section_name'][$i],
		    	 					   'difficulty' => $_POST['difficulty'][$i],
		    	 					   'number'     => $_POST['number'][$i],
		    	 					   'type'       => $_POST['type'][$i],
		    	 					   'order'      => $_POST['order'][$i],
		    						   'id'         => $sectionId,
		    	 					   'status'     => $status );
		    }
		    
			if ( !empty($validData) ){
				
		    	// Generate SQL query
			    $insertSql = 'INSERT INTO `'.WPSQT_SECTION_TABLE.'` (`quizid`,`name`,`type`,`number`,`difficulty`,`orderby`) VALUES ';
			    $insertSqlParts = array();
			    $insert = false;	
			    
				foreach ($validData as $key => $data) {
					
				    if ( $data['status'] == 'input' ){
				    	// OMG so hacky! :'(
				    	
				    	if ( isset($data['id']) && !empty($data['id']) ){
				    		// Updates as is a current secton
				    		$wpdb->query( $wpdb->prepare('UPDATE '.WPSQT_SECTION_TABLE.'
				    									  SET name=%s,
				    									  type=%s,
				    									  number=%d,
				    									  difficulty=%s,
				    									  orderby=%s 
				    									  WHERE id = %d',
				    		array($data['name'],$data['type'],$data['number'],$data['difficulty'],$data['order'],$data['id'])) );
				    		continue;
				    	} 
				    	// New section therefore insert
				    	// turns the insert flag to true.
				    	$insert = true;	
					    $insertSqlParts[] = "(". $wpdb->escape($_GET['quizid']) .",'".
					    						 $wpdb->escape($data['name']) ."','".
					    					     $wpdb->escape($data['type']) ."','".
					    					     $wpdb->escape($data['number']) ."','".
					    					     $wpdb->escape($data['difficulty']) ."','".
					    					     $wpdb->escape($data['order']) ."')";
				    } else {
				    	// Delete it and questions related to it.
				    	if ( isset($data['id']) ){			    		
				    		$wpdb->query('DELETE FROM '.WPSQT_SECTION_TABLE.' WHERE id = '.$data['id']);
				    		$wpdb->query('DELETE FROM '.WPSQT_QUESTION_TABLE.' WHERE sectionid = '.$data['id']);			    		
				    	}
			   		}						
			    } 
			
			    if ( $insert == true ){
			    	$insertSql .= implode(',',$insertSqlParts);
			    	$wpdb->query($insertSql);
			    }

			    $successMessage = 'Sections updated!';
		    }
		    	    
		}	
			
		$validData = $wpdb->get_results('SELECT id,name,type,number,difficulty,orderby
										 FROM '.WPSQT_SECTION_TABLE.'
										 WHERE quizid = '.$wpdb->escape($_GET['quizid'])
										 , ARRAY_A );
			
	}

	require_once wpsqt_page_display('admin/quiz/sections.php');
	
}


/**
 * Deletes a quiz from the database, including
 * all related sections and questions. 
 * 
 * @uses pages/admin/quiz/delete.php
 * @uses pages/general/message.php
 * @uses pages/general/error.php
 * @uses wpdb
 * 
 * @since 1.0
 */

function wpsqt_admin_quiz_delete(){
	
	global $wpdb;

	if ( !isset($_GET['quizid']) || !ctype_digit($_GET['quizid']) ){
		require_once wpsqt_page_display('general/error.php');
		return;
	}
	$quizId = (int) $_GET['quizid'];
	
	if ( empty($_POST) ){
		// Make sure they mean it.
		$quizName = $wpdb->get_var('SELECT name FROM '.WPSQT_QUIZ_TABLE.' WHERE id = '.$quizId);
		require_once wpsqt_page_display('admin/quiz/delete.php');
		return;	
	}
	elseif ( isset($_POST['confirm']) && $_POST['confirm'] == 'Yes' ){
		
		$wpdb->query('DELETE FROM '.WPSQT_QUIZ_TABLE.' WHERE id = '.$quizId);
		$wpdb->query('DELETE FROM '.WPSQT_QUESTION_TABLE.' WHERE quizid = '.$quizId);
		$wpdb->query('DELETE FROM '.WPSQT_SECTION_TABLE.' WHERE quizid = '.$quizId);
		
		$message = 'Quiz deleted successfully!';
		require_once wpsqt_page_display('general/message.php');
	}
	else {		
		require_once wpsqt_page_display('general/error.php');
	}
	
}

?>