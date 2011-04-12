<?php

	/**
	 *  File containing functions used by both the quiz 
	 *  and survey sections. Created soley to comply 
	 *  with DRY.
	 * 
	 * @author Iain Cambridge
	 */


/**
 * Simply function to  display contact and to
 * take and check data to ensure it is provided.
 * 
 * @param boolean $collectDetails
 * 
 * @uses pages/site/quiz/contact.php
 * 
 * @return boolean True if collectDetails is true and there is no errors. Else returns false and displays the contact page.
 * 
 * @since 0.1
 */

function wpsqt_site_shared_take_details($collectDetails = true){
	
	global $wpdb;
	$quizName = $_SESSION['wpsqt']['current_name'];

	if ($_SESSION['wpsqt']['current_type'] == 'quiz'){			
		$quizId = $_SESSION['wpsqt'][$quizName]['quiz_details']['id'];
		$surveyId = 0;		
	} else {		
		$surveyId = $_SESSION['wpsqt'][$quizName]['survey_details']['id'];
		$quizId = 0;
	}
	
	$fields = $wpdb->get_results("SELECT * FROM `".WPSQT_FORM_TABLE."` WHERE quizid = ".$quizId."  AND surveyid = ".$surveyId, ARRAY_A);
	
	if ( !empty($fields) ){
		return wpsqt_site_shared_custom_form($fields);
	}
	
	if ($collectDetails == true ){

		$errors = array();
		if ( !isset($_POST['user_name']) || empty($_POST['user_name']) ){
			$errors[] = 'Name required';
		}	
		if ( !isset($_POST['email']) || !is_email($_POST['email']) ){
			$errors[] = 'Valid email required';
		}	
		if ( !isset($_POST['phone']) || empty($_POST['phone']) ){
			$errors[] = 'Phone required';
		}		
		if ( !isset($_POST['address']) || empty($_POST['address']) ){
			$errors[] = 'Address required';
		}
		if ( !isset($_POST['notes']) || empty($_POST['notes']) ){
			$errors[] = 'Experience required';
		}
			
		if ( empty($errors) ){
			$_SESSION['wpsqt'][$quizName]['person'] = $_POST;
			unset($_SESSION['wpsqt'][$quizName]['person']['step']);
			return true;
		}
	}
	
	require_once wpsqt_page_display('site/shared/contact.php');
	return false;
}


function wpsqt_site_shared_custom_form($fields){
	
	global $wpdb;
	$quizName = $_SESSION['wpsqt']['current_name'];
	
	foreach ( $fields as $field ){
		if ($field['required'] == 'yes'){
			if ( !isset($_POST[$field['name']]) || empty($_POST[$field['name']]) ){
				$errors[] = $field['name'].' is required';
			}
		}
	}
	$postDetails = $_POST;
	unset($postDetails['step']);
	if ( empty($errors) ){
		$_SESSION['wpsqt'][$quizName]['person'] = $postDetails;
		return true;
	}
	
	require_once wpsqt_page_display('site/shared/custom-form.php');
	return false;
}

?>