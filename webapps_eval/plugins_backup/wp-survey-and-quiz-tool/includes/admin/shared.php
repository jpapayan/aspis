<?php 

/**
 * Handles the forms
 *
 * @uses wpdb
 *
 * @since 1.1.5
 */

function wpsqt_admin_shared_forms(){
	
	global $wpdb;
	
	if ( ( !isset($_GET['quizid']) || !ctype_digit($_GET['quizid']) )
	 && ( !isset($_GET['surveyid']) || !ctype_digit($_GET['surveyid']) ) ) {
		require_once wpsqt_page_display('general/error.php');
		return;
	}
	
	$quizId = (isset($_GET['quizid'])) ? $_GET['quizid'] : 0;
	$surveyId = (isset($_GET['surveyid'])) ? $_GET['surveyid'] : 0;
	
	if ( !empty($_POST) && ( isset($_POST['field_name']) && !empty($_POST['field_name']) ) ){
				
		$vaildFields = array();
		
		foreach ( $_POST['field_name'] as $key => $fieldName ){
						
			$fieldType = $_POST['field_type'][$key];
			$fieldRequired = $_POST['field_required'][$key];
			
			if ( empty($fieldName) || empty($fieldType) || empty($fieldRequired) ){
				continue;
			}
			
			$vaildFields[] = "('".$wpdb->escape($fieldName)."','".$wpdb->escape($fieldType)."','".$wpdb->escape($fieldRequired)."',".$quizId.",".$surveyId.")";
			
		}
		$insertSql = "INSERT INTO `".WPSQT_FORM_TABLE."` (name,type,required,quizid,surveyid) VALUES ".implode(",", $vaildFields);
		$wpdb->query("DELETE FROM `".WPSQT_FORM_TABLE."` WHERE quizid = ".$quizId."  AND surveyid = ".$surveyId);
		$wpdb->query($insertSql);
	}
	
	$fields = $wpdb->get_results('SELECT * FROM '.WPSQT_FORM_TABLE.' WHERE quizid = '.$quizId.' AND surveyid = '.$surveyId,ARRAY_A);
	
	if (empty($fields)){
		$fields = array(
					array('name' => '','type' => '','required' => '')
		);
	}
	
	require_once wpsqt_page_display('admin/shared/form.php');
}

?>