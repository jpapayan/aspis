<?php

	/**
	 * Handles all survey and user inteactions.
	 * 
	 * @author Iain Cambridge
	 */

/**
 * Handles displaying the survey and all 
 * user interactions with it.
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses pages/site/survey/section.php
 * @uses includes/site/shared.php
 * 
 * @param string $surveyName
 */

function wpsqt_site_survey_show($surveyName){
	
	global $wpdb;
	
	if ( !isset($_SESSION['wpsqt'])  ){
		$_SESSION['wpsqt'] = array();
	}	
	
	$step = ( isset($_REQUEST['step']) && ctype_digit($_REQUEST['step']) ) ? intval($_REQUEST['step']) : 0;	

	if ( $step == 0 ){		
		$_SESSION['wpsqt'][$surveyName] = array();
		$_SESSION['wpsqt'][$surveyName]['start'] = microtime(true);
		$_SESSION['wpsqt'][$surveyName]['survey_details'] = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '.WPSQT_SURVEY_TABLE.' WHERE name like %s', array($surveyName) ), ARRAY_A );
		$_SESSION['wpsqt'][$surveyName]['survey_sections'] = $wpdb->get_results('SELECT * FROM '.WPSQT_SURVEY_SECTION_TABLE.' WHERE surveyid = '.$_SESSION['wpsqt'][$surveyName]['survey_details']['id'], ARRAY_A );	
		$_SESSION['wpsqt'][$surveyName]['person'] = array();
	}
		
	$_SESSION['wpsqt']['current_step'] = $step;
	$_SESSION['wpsqt']['current_name'] = $surveyName;
	$_SESSION['wpsqt']['current_id']   = $_SESSION['wpsqt'][$surveyName]['survey_details']['id'];
	$_SESSION['wpsqt']['current_type'] = 'survey';
	$sectionKey = ( $_SESSION['wpsqt'][$surveyName]['survey_details']['take_details'] == 'yes' ) ? $step - 1 : $step;
	$_SESSION['wpsqt']['section_key']  = $sectionKey;

	if ( $_SESSION['wpsqt'][$surveyName]['survey_details']['status'] != 'enabled' ){
		print 'Survey is not enabled';
		return;
	}

	if ( $_SESSION['wpsqt'][$surveyName]['survey_details']['take_details'] == 'yes' &&  $step <= 1){		
		require_once WPSQT_DIR.'/includes/site/shared.php';
		// Nasty and needs replaced with something unnasty..
		switch ($step){			
			case 1:
				 if ( !wpsqt_site_shared_take_details(true) ){
		 			return;
				 }	
				break;
			default:
				wpsqt_site_shared_take_details(false);
				return;
				break;		
		}		
	}
	
	$numberOfSectons = sizeof($_SESSION['wpsqt'][$surveyName]['survey_sections']);
	// Check to see if we have a step higher than is possible. 
	if ( $sectionKey > $numberOfSectons ){
		wpsqt_page_display('general/error.php');
		return;
	} else {
		
		if ( isset($_POST['answers']) ){		
			$insertResultsSql = 'INSERT INTO `'.WPSQT_SURVEY_RESULT_TABLE.'` (surveyid,questionid,answerid,other,type,value) VALUES ';
			$sqlParts = array();
			foreach ( $_POST['answers'] as $questionKey => $answer ){
				$_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey-1]['questions'][$questionKey]['answer'] = $answer;				
				$other = (isset($_POST['other'][$questionKey]) && !empty($_POST['other'][$questionKey])) ? $_POST['other'][$questionKey] : '';
				if ($answer == '0'  ){					
					$_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey-1]['questions'][$questionKey]['answer_other'] = $other;
				}
				$sqlParts[] = "(".$wpdb->escape($_SESSION['wpsqt'][$surveyName]['survey_details']['id']).","
								 .$wpdb->escape($_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey-1]['questions'][$questionKey]['id']).","
								 .$wpdb->escape($answer).","
								 ."'".$wpdb->escape($other)."',"
								 ."'".$wpdb->escape($_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey-1]['questions'][$questionKey]['type'])."',"
								 ."'".$wpdb->escape($answer)."')";
			}	
			$insertResultsSql .= implode(',',$sqlParts);
			$wpdb->query( $insertResultsSql );			
		}		
		
		if ( $sectionKey == $numberOfSectons ){
			wpsqt_site_survey_finish();
			return;
		} else {
			$_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey]['questions'] = wpsqt_site_survey_fetch_questions();
		}				
		
		require_once wpsqt_page_display('site/survey/section.php');
		
	}
	
	return;
	
}

/**
 * Handles the fetching of the questions for 
 * the current survey section.
 * 
 * @uses wpdb
 * 
 * @return array Questions for the current section.
 */

function wpsqt_site_survey_fetch_questions(){
	
	global $wpdb;
	
	// Set variables
	$surveyName    = $_SESSION['wpsqt']['current_name'];
	$sectionKey    = $_SESSION['wpsqt']['section_key'];
	$surveyId      = $_SESSION['wpsqt'][$surveyName]['survey_details']['id'];
	$section       = $_SESSION['wpsqt'][$surveyName]['survey_sections'][$sectionKey];
	$moreQuestions = 0;
		
	$questions = $wpdb->get_results( $wpdb->prepare('SELECT * FROM `'.WPSQT_SURVEY_QUESTIONS_TABLE.'` WHERE surveyid = %d AND type = %s ORDER BY id ASC LIMIT 0,%d',
													array($surveyId,$section['type'],$section['number'] )), ARRAY_A );
	
	if ( $section['type'] == 'multiple' ){		
		for ( $i = 0; $i < sizeof($questions); $i++){
			$questions[$i]['answers'] = $wpdb->get_results('SELECT * FROM `'.WPSQT_SURVEY_ANSWERS_TABLE.'` WHERE questionid = '. $questions[$i]['id'] , ARRAY_A );
		}		
	}												
													
	return $questions;
		
}

/**
 * Handles the clean up of the survey.
 *
 * @uses wpdb
 * @uses pages/site/survey/finish.php
 */
function wpsqt_site_survey_finish(){
	
	global $wpdb;
	
	$sectionKey = $_SESSION['wpsqt']['section_key'];
	$surveyName = $_SESSION['wpsqt']['current_name'];
	$surveyId   = $_SESSION['wpsqt'][$surveyName]['survey_details']['id'];
	$person =  ( isset($_SESSION['wpsqt'][$surveyName]['person']) ) ? $_SESSION['wpsqt'][$surveyName]['person'] : array('name'=>'anonymous');
		
	$wpdb->query(
		$wpdb->prepare(	'INSERT `'.WPSQT_SURVEY_SINGLE_TABLE.'` (surveyid,person,name,results,ipaddress,user_agent) VALUES (%d,%s,%s,%s,%s,%s)',
						array($surveyId,serialize($person),$person['user_name'],serialize($_SESSION['wpsqt'][$surveyName]['survey_sections']),$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT']) )
	);
	
	require_once wpsqt_page_display('site/survey/finish.php');
}