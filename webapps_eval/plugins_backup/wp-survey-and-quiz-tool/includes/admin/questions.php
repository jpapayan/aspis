<?php

/**
 * Handles creating, editing and listing questions.
 * 
 * @author Iain Cambridge
 */

/**
 * Handles the adding of new questions. If post is not empty it 
 * sanatizes the question text and answer texts if the question
 * is not a textarea question. Checks to see if it has the correct
 * number of questions are inputted. 
 * 
 * @uses pages/admin/questions/form.php
 * @uses wpdb
 * 
 * @since 1.0
 */

function wpsqt_admin_questions_addnew(){
	
	global $wpdb;
	
	if ( !isset($_GET['quizid']) || !ctype_digit($_GET['quizid']) ){
		$message = 'No quizid provided.';
		require_once wpsqt_page_display('general/message.php');
		return;
	}
	
	//
	$questionText  = '';
	$questionHint  = '';
	$questionValue = 1;
	$questionAdditional = '';
	$questionDifficulty = 'medium';
	$quizId = (int) $_GET['quizid'];
	
	$sections = $wpdb->get_results('SELECT id,name FROM '.WPSQT_SECTION_TABLE.' WHERE quizid = '.$quizId,ARRAY_A);
		
	if ( !empty($_POST) ){ // Get request so no processing required.	
		
		$questionText       = htmlentities( trim($_POST['question']) );
		$questionType       = trim( $_POST['type'] );
		$questionAdditional = trim( $_POST['additional']) ;
		$questionHint       = trim( $_POST['hint'] );
		$questionDifficulty = trim( $_POST['difficulty'] );
		$questionValue      = (int) $_POST['points'];
		$quizId             = (int) $_GET['quizid'];
		$sectionId          = (isset($_POST['section'])) ? intval($_POST['section']) : 0;
		$errrorArray = array();
		
		if ( empty($questionText) ){
			$errorArray[] = 'Need a question to ask';
		}	
			
		if ( empty($sectionId) || $sectionId == 0 ){				
			$errorArray[] = 'A question has to be assigned to a section!';			
		}
		
		$correctCount = 0;
		$sectionType = 'textarea';
		// Run though multiple choice answers
		if ($questionType == "single" || $questionType == "multiple"){	
			$answers = array();
			$sectionType = 'multiple';
			
			if ( sizeof($_POST['answer']) == 0){
				$errorArray[] = 'Need at least one answer';
			}
			else{
				// Actual answers to process
				for ( $i = 0; $i < sizeof($_POST['answer']); $i++){	
					$answerText = trim($_POST['answer'][$i]);	
					$answerCorrect = trim($_POST['correct'][$i]);					
					if ( !empty($answerText) && !empty($answerCorrect) ){
						$answers[] = array('text'    => $answerText,
											'correct' => $answerCorrect );
						if ($_POST['correct'][$i] == 'yes'){
							$correctCount++;
						}	
					}
				}
			}
			
			if ( $questionValue < 1 || $questionValue > 5 ){
				$errorArray[] = 'Question value is incorrect';				
			}
		
			if ( $correctCount == 0 ){
				$errorArray[] = 'Need at least one correct answer';
			}
			
			if ( $correctCount > 1 && $questionType == "single"){
				$errorArray[] = 'Can only have one valid answer for this type of question';
			}

		}
		
		if ( empty($errorArray) ){			
			
			if ($_REQUEST['action'] == 'addnew'){
				$wpdb->query( $wpdb->prepare('INSERT INTO '.WPSQT_QUESTION_TABLE.' (text,type,additional,value,quizid,hint,difficulty,section_type,sectionid) VALUES (%s, %s, %s,%d,%d,%s,%s,%s,%d)', 
											 array($questionText,$questionType,$questionAdditional,$questionValue,$quizId,$questionHint,$questionDifficulty,$sectionType,$sectionId)) );
				$questionId = $wpdb->insert_id;				
				$successMessage = 'Successfully added question';		
			}
			elseif ( $_REQUEST['action'] == 'edit' ) {
				// To get here it must have been called via fptest_questions_edit() 
				// where a check on $_GET['id'] would have been done already.
				$questionId = (int) $_GET['id'];	
				
			 	$wpdb->query( $wpdb->prepare('UPDATE '.WPSQT_QUESTION_TABLE.' SET text=%s,type=%s,value=%d,hint=%s,difficulty=%s,sectionid=%d WHERE id = %d',
			 								 array($questionText,$questionType,$questionValue,$questionHint,$questionDifficulty,$sectionId,$questionId) ) );
				$wpdb->query( 'DELETE FROM '.WPSQT_ANSWER_TABLE.' WHERE questionid = '.$questionId );
				
			 	$successMessage = 'Successfully edited question';
			}	
			// use post type since for new questions $questionType is unset already.
			if ($_POST['type'] == "single" || $_POST['type'] == "multiple"){
				// Both add and edit use this.			
				$insertAnswersSql = 'INSERT INTO '.WPSQT_ANSWER_TABLE.' (questionid,text,correct) VALUES ';
				if ( $correctCount != 0){
					$escapedQueries = array();		
					foreach ($answers as $answer){			
						$escapedQueries[] = "(".$questionId.",'".$wpdb->escape($answer['text'])."','".$wpdb->escape($answer['correct'])."')";			
					}		
				}			
				$insertAnswersSql .= implode(',',$escapedQueries);
				
				$wpdb->query($insertAnswersSql);
			}
			// Clean out the variables if it's a new question
			if ($_REQUEST['action'] == 'addnew'){
				$questionText = '';
				$questionType = '';
				unset($answers);
			}
		}
		
	}
	
	
	require_once wpsqt_page_display('admin/questions/form.php');
	return;	
}

/**
 * Lists out the questions that are in the database. With links
 * to edit and delete questions.
 * 
 * @uses pages/admin/questions/index.php
 * @uses includes/functions.php
 * 
 * @since 1.0
 */
function wpsqt_admin_questions_show_list(){
	
	global $wpdb;
	
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$itemsPerPage = get_option('wpsqt_number_of_items');
	$currentPage = wpsqt_functions_pagenation_pagenumber();	
	$startNumber = ( ($currentPage - 1) * $itemsPerPage );	
	if ( !isset($_GET['quizid']) || !ctype_digit($_GET['quizid']) ){
		$rawQuestions = $wpdb->get_results('SELECT id,text,type,quizid FROM '.WPSQT_QUESTION_TABLE.' ORDER BY id ASC', ARRAY_A);
	} else {
		$rawQuestions = $wpdb->get_results('SELECT id,text,type,quizid FROM '.WPSQT_QUESTION_TABLE.' WHERE quizid = '.$wpdb->escape($_GET['quizid']).' ORDER BY id ASC', ARRAY_A);
	}
	$questions = array_slice($rawQuestions , $startNumber , $itemsPerPage );
	$numberOfItems = sizeof($rawQuestions);
	$numberOfPages = wpsqt_functions_pagenation_pagecount($numberOfItems, $itemsPerPage);

	require_once wpsqt_page_display('admin/questions/index.php');
	return;	
	
}

/**
 * Handles the editing of questions. Offloads the processing
 * of form data to fptest_questions_addnew().
 * 
 * @uses pages/admin/questions/form.php
 * @uses wpdb
 * 
 * @since 1.0
 */

function wpsqt_admin_questions_edit(){
	
	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
		require_once wpsqt_page_display('general/error.php');
		return;
	}
	
	// A bit redunant but worth it incase ctype_digit gives a false postive.
	$questionId = (int) $_GET['id'];	
		
	if ( !empty ($_POST) ){
		// Code reuse.
		wpsqt_admin_questions_addnew();
		return;
	}
	else {
		
		list($questionText,$questionType,$questionHint,$questionDifficulty,$questionValue,$quizId,$sectionId,$questionAdditional) = $wpdb->get_row('SELECT text,type,hint,difficulty,value,quizid,sectionid,additional FROM '.WPSQT_QUESTION_TABLE.' WHERE id = '.$questionId, ARRAY_N);
		
		// $quizId comes from the database field which is a integer so no need to prepare a statement
		$sections = $wpdb->get_results('SELECT id,name FROM '.WPSQT_SECTION_TABLE.' WHERE quizid = '.$quizId,ARRAY_A);
		
		if ($questionType != 'textarea'){	
			$answers = $wpdb->get_results('SELECT text,correct FROM '.WPSQT_ANSWER_TABLE.' WHERE questionid = '.$questionId, ARRAY_A);
			$rowCount = sizeof($answers);
		}
		else{ 
			$rowCount = 1;
		}
	
	}

	require_once wpsqt_page_display('admin/questions/form.php');
	return;	
}

/** 
 * Handles the deleting of questions. Shows simple confirm
 * page and then a success page if confirmed or returns to
 * list if not confirmed.
 * 
 * @uses pages/admin/questions/delete.php
 * @uses pages/general/message.php
 * @uses pages/general/error.php
 * @uses wpdb
 * 
 * @since 1.0
 */

function wpsqt_admin_questions_delete(){

	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
		require_once wpsqt_page_display('general/error.php');
		return;
	}
	
	$questionId = (int) $_GET['id'];
	
	if ( empty($_POST) ){
		// Make sure they mean it.
		$questionText = $wpdb->get_var('SELECT text FROM '.WPSQT_QUESTION_TABLE.' WHERE id = '.$questionId);
		require_once wpsqt_page_display('admin/questions/delete.php');
		return;	
	}
	elseif ( $_POST['confirm'] == 'No' ){
		$message = 'Question not deleted';
		require_once wpsqt_page_display('general/message.php');
	}
	elseif ( $_POST['confirm'] == 'Yes' ){		
		$wpdb->query('DELETE FROM '.WPSQT_QUESTION_TABLE.' WHERE id = '.$questionId);
		$wpdb->query('DELETE FROM '.WPSQT_ANSWER_TABLE.' WHERE questionid = '.$questionId);
		$message = 'Question succesfully deleted';
		require_once wpsqt_page_display('general/message.php');
		return;	
	}
}

?>