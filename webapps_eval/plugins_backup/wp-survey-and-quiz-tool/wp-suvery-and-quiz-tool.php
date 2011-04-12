<?php

/*
Plugin Name: WP Survey And Quiz Tool
Plugin URI: http://catn.com/2010/10/04/wp-survey-and-quiz-tool/
Description: A plugin to allow wordpress owners to create their own web based quizes.
Author: Fubra Limited
Author URI: http://www.catn.com
Version: 1.2.1
*/

//TODO leverage media overlay for questions

/*
 * Copyright (C) 2010  Fubra Limited
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 */

// Global actions
global $wpdb;

// Define constants
define( 'WPSQT_QUIZ_TABLE'             , $wpdb->prefix.'wpsqt_quiz' );
define( 'WPSQT_SECTION_TABLE'          , $wpdb->prefix.'wpsqt_quiz_sections' );
define( 'WPSQT_QUESTION_TABLE'         , $wpdb->prefix.'wpsqt_questions' );
define( 'WPSQT_ANSWER_TABLE'           , $wpdb->prefix.'wpsqt_answer' );
define( 'WPSQT_FORM_TABLE'             , $wpdb->prefix.'wpsqt_forms' );
define( 'WPSQT_RESULTS_TABLE'          , $wpdb->prefix.'wpsqt_results' );
define( 'WPSQT_SURVEY_TABLE'           , $wpdb->prefix.'wpsqt_survey' );
define( 'WPSQT_SURVEY_SECTION_TABLE'   , $wpdb->prefix.'wpsqt_survey_sections' );
define( 'WPSQT_SURVEY_QUESTIONS_TABLE' , $wpdb->prefix.'wpsqt_survey_questions' );
define( 'WPSQT_SURVEY_ANSWERS_TABLE'   , $wpdb->prefix.'wpsqt_survey_questions_answers' );
define( 'WPSQT_SURVEY_RESULT_TABLE'    , $wpdb->prefix.'wpsqt_survey_results' );
define( 'WPSQT_SURVEY_SINGLE_TABLE'    , $wpdb->prefix.'wpsqt_survey_single_results');
// Page variable names.
// define as constants to allow for easy change of them.
define( 'WPSQT_PAGE_MAIN'            , 'wpsqt-menu' );
define( 'WPSQT_PAGE_QUIZ'            , 'wpsqt-menu-quiz' );
define( 'WPSQT_PAGE_QUESTIONS'       , 'wpsqt-menu-question' );
define( 'WPSQT_PAGE_QUIZ_RESULTS'    , 'wpsqt-menu-quiz-results' );
define( 'WPSQT_PAGE_OPTIONS'         , 'wpsqt-menu-options' ) ;
define( 'WPSQT_PAGE_CONTACT'         , 'wpsqt-menu-contact' );
define( 'WPSQT_PAGE_HELP'            , 'wpsqt-menu-help'    );
define( 'WPSQT_PAGE_SURVEY'          , 'wpsqt-menu-survey'  );
define( 'WPSQT_CONTACT_EMAIL'        , 'iain.cambridge@fubra.com' );
define( 'WPSQT_FROM_EMAIL'           , 'wpst-no-reply@fubra.com' );
define( 'WPSQT_VERSION'              , '1.2.1' );
define( 'WPSQT_DIR'                  , dirname(__FILE__) );

// start a session
if ( !session_id() )
	session_start();

// To anyone reading this, sorry for the terrible, terrible design.	
register_activation_hook(__FILE__, 'wpsqt_main_install'); 
/**
 * Installation function creates all the
 * tables required for the plugin. 
 * 
 * @uses wpdb
 */	
function wpsqt_main_install(){    
   
	global $wpdb;
	
	$oldVersion = get_option('wpsqt_version');
	
	update_option('wpsqt_version',WPSQT_VERSION);
	if ( !get_option('wpsqt_number_of_items') ){
		update_option('wpsqt_number_of_items',5);
	}
	// Simple way of checking if an it's an update or not.
	if ( !empty($oldVersion) && $oldVersion != WPSQT_VERSION ){
		wpsqt_main_db_upgrade();
	}
	
	// Results table
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_RESULTS_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `timetaken` int(11) NOT NULL,
				  `person` text,
				  `sections` text NOT NULL,
				  `status` varchar(255) NOT NULL DEFAULT 'Unviewed',
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  `quizid` int(11) NOT NULL,
				  `person_name` varchar(255) NOT NULL,
				  `ipaddress` varchar(255) NOT NULL,
				  `mark` int(11) NOT NULL DEFAULT '0',
				  `total` int(11) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SECTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `quizid` int(11) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `number` int(11) NOT NULL,
				  `difficulty` varchar(11) NOT NULL,
				  `orderby` varchar(255) NOT NULL DEFAULT 'random',
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_QUIZ_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `display_result` varchar(255) NOT NULL DEFAULT 'no',
				  `type` varchar(255) NOT NULL DEFAULT 'quiz',
				  `status` varchar(255) NOT NULL DEFAULT 'disabled',
				  `notification_type` varchar(255) NOT NULL DEFAULT 'none',
				  `take_details` varchar(3) NOT NULL DEFAULT 'no',
 				  `use_wp_user` varchar(3) NOT NULL DEFAULT 'no',
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_QUESTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `type` varchar(30) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `additional` text NOT NULL,
				  `value` int(11) NOT NULL DEFAULT '1',
				  `quizid` int(11) NOT NULL,
				  `hint` text NOT NULL,
				  `difficulty` varchar(255) NOT NULL,
				  `section_type` varchar(255) NOT NULL DEFAULT 'multiple',
				  `sectionid` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_ANSWER_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `questionid` int(11) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `correct` varchar(3) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `questionid` (`questionid`)
				  ) ENGINE=MyISAM");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `take_details` varchar(11) NOT NULL,
				  `status` varchar(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_QUESTIONS_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `sectionid` int(11) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `type` varchar(10) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_ANSWERS_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `questionid` int(11) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_RESULT_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `questionid` int(11) NOT NULL,
				  `answerid` int(11) DEFAULT NULL,
				  `other` text NOT NULL,
				  `type` varchar(10) DEFAULT 'multiple',
				  `value` int(11) DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `id` (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_SECTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(10) NOT NULL,
				  `number` int(11) NOT NULL,
				  `orderby` varchar(255) NOT NULL DEFAULT 'random',
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_SINGLE_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `person` text NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `results` text NOT NULL,
				  `ipaddress` varchar(255) NOT NULL,
				  `user_agent` varchar(255) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_FORM_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `required` varchar(255) NOT NULL,
				  `quizid` int(11) NOT NULL,
				  `surveyid` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	
}


/**
 * Adds a custom menus to the admin page.
 * Layout
 *   WP Survey And Quiz Tool
 *   -> Quiz/Surveys
 *   -> Questions
 *   -> Results
 *   -> Options
 */

function wpsqt_main_admin_menu(){
	
	wp_enqueue_script('jquery');
	add_menu_page('WP Survey And Quiz Tool', 'WP Survey And Quiz Tool', 'manage_options', WPSQT_PAGE_MAIN , 'wpsqt_main_admin_main_page') ;
	add_submenu_page( WPSQT_PAGE_MAIN , 'Quizzes', 'Quizzes', 'manage_options', WPSQT_PAGE_QUIZ , 'wpsqt_main_admin_quiz_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Surveys', 'Surveys', 'manage_options', WPSQT_PAGE_SURVEY , 'wpsqt_main_admin_survey_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Questions', 'Questions', 'manage_options', WPSQT_PAGE_QUESTIONS, 'wpsqt_main_admin_questions_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Quiz Results', 'Quiz Results', 'manage_options', WPSQT_PAGE_QUIZ_RESULTS , 'wpsqt_main_admin_quiz_results_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Options', 'Options', 'manage_options', WPSQT_PAGE_OPTIONS, 'wpsqt_main_admin_options_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Contact' , 'Contact' , 'manage_options' , WPSQT_PAGE_CONTACT , 'wpsqt_main_admin_contact_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Help' , 'Help' , 'manage_options' , WPSQT_PAGE_HELP, 'wpsqt_main_admin_help_page' );
	
}

/**
 * Main page for when people click on the WP Survey And Quiz Tool.
 * Simply selects the lastest quiz results and the lastest quizes.
 * 
 * @uses wpdb
 */
function wpsqt_main_admin_main_page(){
	
	global $wpdb;
	
	$results = $wpdb->get_results( 'SELECT r.id,r.timestamp,r.status,r.person_name,r.mark,r.ipaddress,q.name
									FROM '.WPSQT_RESULTS_TABLE.' AS r 
									INNER JOIN '.WPSQT_QUIZ_TABLE.' as q ON q.id = r.quizid 
									WHERE r.status = "Unviewed" 
									ORDER BY r.id ASC 
									LIMIT 0,10',ARRAY_A);
	$quizList = $wpdb->get_results( 'SELECT id,name,status,type 
									 FROM '.WPSQT_QUIZ_TABLE.' 
									 ORDER BY id DESC 
									 LIMIT 0,5' , ARRAY_A );
	require_once WPSQT_DIR.'/pages/admin/main/index.php';
	
}


/**
 * Handles requests for admin pages for the
 * quiz section. The page to be shown is 
 * dictated by the $_GET action variable with
 * the functions being held in a seperate file.
 * 
 * @uses includes/admin/quiz.php
 */

function wpsqt_main_admin_quiz_page(){
	
	require_once WPSQT_DIR.'/includes/admin/quiz.php';
	
	if ( !isset($_REQUEST['action']) || $_REQUEST['action'] == 'list' ){
		wpsqt_admin_quiz_list();
	} elseif ( $_REQUEST['action'] == 'create' ){
		wpsqt_admin_quiz_form();		
	} elseif ( $_REQUEST['action'] == 'sections' ){
		wpsqt_admin_quiz_sections();
	} elseif ( $_REQUEST['action'] == 'delete' ){
		wpsqt_admin_quiz_delete();
	} elseif ( $_REQUEST['action'] == 'forms' ){
		require_once WPSQT_DIR.'/includes/admin/shared.php';
		wpsqt_admin_shared_forms();
	} elseif ( $_REQUEST['action'] == 'configure' ){
		wpsqt_admin_quiz_form(true);
	} else {
		require_once WPSQT_DIR.'/pages/general/error.php';
	}	
	
}

/**
 * Handles requests for admin pages for the 
 * survey section. The page to be shown is
 * dictacted by the $_GET action variable with
 * the functions being held in a seperate file.
 * 
 * @uses includes/admin/survey.php
 */

function wpsqt_main_admin_survey_page(){
	
	require_once WPSQT_DIR.'/includes/admin/survey.php';
	if ( !isset($_REQUEST['action']) || $_REQUEST['action'] == 'list' ){
		wpsqt_admin_survey_list();
	} elseif ( $_REQUEST['action'] == 'create' ){
		wpsqt_admin_survey_create();		
	} elseif ( $_REQUEST['action']  == 'delete' ){
		wpsqt_admin_survey_delete();
	} elseif ( $_REQUEST['action'] == 'configure' ){
		wpsqt_admin_survey_create(true);
	} elseif ( $_REQUEST['action'] == 'sections' ){
		wpsqt_admin_survey_sections();
	} elseif ( $_REQUEST['action'] == 'questions' ){
		wpsqt_admin_survey_question_list();
	} elseif ( $_REQUEST['action'] == 'create-question' ){
		wpsqt_admin_survey_question_create();
	} elseif ( $_REQUEST['action'] == 'delete-question' ){
		wpsqt_admin_survey_question_delete();
	} elseif ( $_REQUEST['action'] == 'edit-question' ){
		wpsqt_admin_survey_question_create(true);
	} elseif ( $_REQUEST['action'] == 'list-results' ){
		wpsqt_admin_survey_result_list();
	} elseif ( $_REQUEST['action'] == 'view-result' ){
		wpsqt_admin_survey_result_single();
	} elseif ( $_REQUEST['action'] == 'view-total' ){
		wpsqt_admin_survey_result_total();
	} elseif ( $_REQUEST['action'] == 'forms' ){
		require_once WPSQT_DIR.'/includes/admin/shared.php';
		wpsqt_admin_shared_forms();
	}
	
}

/**
 * Handles requests for admin pages for the
 * question section. The page to be shown is 
 * dictated by the $_GET action variable with
 * the functions being held in a seperate file.
 * 
 * @uses includes/admin/questions.php
 */

function wpsqt_main_admin_questions_page(){	
	require_once WPSQT_DIR.'/includes/admin/questions.php';		
	if ( !isset($_REQUEST['action']) || $_REQUEST['action'] == 'list' ){
			wpsqt_admin_questions_show_list();
	} elseif ( $_REQUEST['action'] == 'addnew' ){
		wpsqt_admin_questions_addnew();		
	} elseif ( $_REQUEST['action'] == 'edit' ){
		wpsqt_admin_questions_edit();
	} elseif ( $_REQUEST['action'] == 'delete' ){
		wpsqt_admin_questions_delete();
	}
}


/**
 * Handles requests for admin pages for the
 * results section. The page to be shown is 
 * dictated by the $_GET action variable with
 * the functions being held in a seperate file.
 * 
 * @uses includes/admin/results.php
 */

function wpsqt_main_admin_quiz_results_page(){	
	require_once WPSQT_DIR.'/includes/admin/results.php';

	if ( !isset($_REQUEST['action'])  || $_REQUEST['action'] == 'list' ){
			wpsqt_admin_results_show_list();
	} elseif ( $_REQUEST['action'] == 'mark' ){
			wpsqt_admin_results_quiz_mark();
	} elseif ( $_REQUEST['action'] == 'delete' ){
			wpsqt_admin_results_delete_result();
	}
}

/**
 * Shows the option page which allows the
 * user to edit and save options which 
 * apply to the plugin.
 * 
 * @uses includes/admin/misc.php
 */
function wpsqt_main_admin_options_page(){	
	require_once WPSQT_DIR.'/includes/admin/misc.php';
	
	wpsqt_admin_options_main();
}

/**
 * Shows the contact page which allows 
 * the users to send emails the me. Hopefully
 * should increase bug reports.
 * 
 * @uses includes/admin/misc.php
 */
function wpsqt_main_admin_contact_page(){	
	require_once WPSQT_DIR.'/includes/admin/misc.php';
	
	wpsqt_admin_misc_contact_main();
}

add_action('admin_menu', 'wpsqt_main_admin_menu');



/**
 * Handles the displaying of quizes on pages.
 * All the hardwork is handled else where.
 * 
 * @uses pages/general/error.php
 * @uses includes/site/quiz.php
 */
function wpsqt_main_site_quiz_page($atts) {
	extract( shortcode_atts( array(
					'name' => false
	), $atts) );
	
	if ( !$name ){
		require_once WPSQT_DIR.'/pages/general/error.php';
	}
	
	require_once WPSQT_DIR.'/includes/site/quiz.php';
	wpsqt_site_quiz_show($name);
}

add_shortcode( 'wpsqt_page' , 'wpsqt_main_site_quiz_page' );// Deprecated and will be removed
add_shortcode( 'wpsqt_quiz' , 'wpsqt_main_site_quiz_page' );

/**
 * Handles the displaying of quizes on pages.
 * All the hardwork is handled else where.
 * 
 * @uses pages/general/error.php
 * @uses includes/site/quiz.php
 */
function wpsqt_main_site_survey_page($atts) {
	extract( shortcode_atts( array(
					'name' => false
	), $atts) );
	
	if ( !$name ){
		require_once WPSQT_DIR.'/pages/general/error.php';
	}
	
	require_once WPSQT_DIR.'/includes/site/survey.php';
	wpsqt_site_survey_show($name);
}

add_shortcode( 'wpsqt_survey' , 'wpsqt_main_site_survey_page' );

/**
 * Does a SQL query to select results from the last 24 hours.
 * 
 * @uses includes/functions.php
 */
function wpsqt_daily_mail() {
	
	global $wpdb;
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$results = $wpdb->get_result('SELECT * 
								  FROM `'.WPSQT_RESULTS_TABLE.'` 
								  WHERE timestamp >= TIMESTAMPADD(DAY,-1,NOW())',ARRAY_A);
	
	wpsqt_functions_send_mail($results);
	
}
add_action( 'daily_mail' , 'wpsqt_daily_mail' );

/**
 * Does a SQL query to select from the last hour.
 * 
 * @uses includes/functions.php
 */
function wpsqt_hourly_mail() {
	
	global $wpdb;
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$results = $wpdb->get_result(  'SELECT * 
									FROM `'.WPSQT_RESULTS_TABLE.'` 
									WHERE timestamp >= TIMESTAMPADD(HOUR,-1,NOW())',ARRAY_A);
	
	wpsqt_functions_send_mail($results);
}

add_action('hourly_mail', 'wpsqt_hourly_mail');


/**
 * Displays help nothing else nothing more.
 * 
 * @uses pages/admin/misc/help.php
 */
function wpsqt_main_admin_help_page(){
	
	require_once WPSQT_DIR.'/pages/admin/misc/help.php';
	
}

/**
 * Fall back function to check if the plugin 
 * was activated properly.
 * 
 * @uses wpdb
 * 
 * @since 1.0.2
 */
function wpsqt_check_tables(){
	
	global $wpdb;
	
	if ( !$wpdb->get_var("SHOW TABLES LIKE '".WPSQT_RESULTS_TABLE."'") 
	  || !$wpdb->get_var("SHOW TABLES LIKE '".WPSQT_SURVEY_TABLE."'")
	  || !$wpdb->get_var("SHOW TABLES LIKE '".WPSQT_FORM_TABLE."'") ){
		wpsqt_main_install();
		return;
	}
	
	$oldVersion = get_option('wpsqt_version');
	
	// Simple way of checking if an it's an update or not.
	if ( !empty($oldVersion) && $oldVersion != WPSQT_VERSION ){
		wpsqt_main_db_upgrade();
	}
	
}

add_action('plugins_loaded','wpsqt_check_tables');

/**
 * Allows users to use custom page views to change layouts and user interaction.
 * 
 * @param $file
 *  
 * @uses wpdb
 * 
 * @since 1.1.1
 */

function wpsqt_page_display($file){
	
	$quizPath = ( isset($_SESSION['wpsqt']['current_id'])
				 && ctype_digit($_SESSION['wpsqt']['current_id']) ) ?
				  $_SESSION['wpsqt']['current_type'].'-'.$_SESSION['wpsqt']['current_id'].'/' : '';
			
	if ( file_exists(WPSQT_DIR.'/pages/custom/'.$quizPath.$file) ){
		return WPSQT_DIR.'/pages/custom/'.$quizPath.$file;
	}
	return WPSQT_DIR.'/pages/'.$file;
	
}

/**
 * Adds the print.css to the admin section.
 * 
 * @since 1.1.4
 */

function wpsqt_admin_css() {
	$siteurl = get_option('siteurl');
	$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/print.css';
	echo "<link rel='stylesheet' type='text/css' media='print' href='$url' />\n";
}
add_action('admin_head', 'wpsqt_admin_css');

/**
 * Exports results to CSV 
 * 
 * @uses wpdb
 * 
 * @since 1.2.0
 */

function wpsqt_csv_export(){
	
	global $wpdb;
	
	
	if ( !isset($_GET['quiz_csv']) && !isset($_GET['survey_csv']) ){
		return;
	}
	
	if ( isset($_GET['quiz_csv']) ){
		$quizId = (int)$_GET['quizid'];	
		$results = $wpdb->get_results( 'SELECT * FROM '.WPSQT_RESULTS_TABLE.' WHERE quizid = '.$quizId , ARRAY_A );
	} else {
		$surveyId = (int)$_GET['surveyid'];
		$results = $wpdb->get_results( 'SELECT * FROM '.WPSQT_SURVEY_RESULT_TABLE.' WHERE surveyid = '.$surveyId, ARRAY_A );	
	}
	
	$csvFile = tmpfile();
	foreach ( $results as $result ){
		
		if ($_GET['people'] == 'yes'){
			// If just contact details
			$people = unserialize($result['person']);
			if (!empty($people)){
				fputcsv($csvFile, $people);
			}
			
		} else {
			fputcsv($csvFile,$result);				
		}	
	}
	fseek($csvFile ,0);
	// Print out the data
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	print stream_get_contents($csvFile);
	
	exit; // Because we don't want the rest to load.
	
}
add_action('init', 'wpsqt_csv_export');

/**
 * Function to comply with DRY for 
 * upgrading the mysql tables.
 * 
 * @uses wpdb
 * 
 * @since 1.2.1
 */

function wpsqt_main_db_upgrade(){
	
	global $wpdb;
		
	$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` ADD `use_wp_user` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
	$wpdb->query("ALTER TABLE `".WPSQT_SECTION_TABLE."` ADD `orderby` VARCHAR( 255 ) NOT NULL DEFAULT 'random'");
	$wpdb->query("ALTER TABLE `".WPSQT_SURVEY_SECTION_TABLE."` ADD `orderby` VARCHAR( 255 ) NOT NULL DEFAULT 'random'");
	$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` DROP `type` ");
	
	return;
}
?>