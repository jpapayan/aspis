<?php
/*
Plugin Name: Register Plus
Plugin URI: http://skullbit.com/wordpress-plugin/register-plus/
Description: <strong>WordPress 2.5+ ONLY.</strong> Enhance your Registration Page.  Add Custom Logo, Password Field, Invitation Codes, Disclaimer, Captcha Validation, Email Validation, User Moderation, Profile Fields and more.
Author: Skullbit
Version: 3.5.1
Author URI: http://www.skullbit.com

LOCALIZATION
Place your language file within this plugin directory and name it "regplus-{language}.mo" replace {language} with your language value from wp-config.php
				
CHANGELOG
See readme.txt
*/

$rp = get_option( 'register_plus' ); //load options
if( $rp['dash_widget'] ) //if dashboard widget is enabled
	include_once('dash_widget.php'); //add the dashboard widget
	
if( !class_exists('RegisterPlusPlugin') ){  
	class RegisterPlusPlugin{
		function RegisterPlusPlugin() { //constructor
			global $wp_version;
			//ACTIONS
				#Add Settings Panel
				add_action( 'admin_menu', array($this, 'AddPanel') );
				#Update Settings on Save
				if( $_POST['action'] == 'reg_plus_update' )
					add_action( 'init', array($this,'SaveSettings') );
				#Enable jQuery on Settings panel
				if( $_GET['page'] == 'register-plus' ){
					wp_enqueue_script('jquery');
					add_action( 'admin_head', array($this, 'SettingsHead') );
				}
				#Add Register Form Fields
				add_action( 'register_form', array($this, 'RegForm') );	
				#Add Register Page Javascript & CSS
				if($_GET['action'] == 'register')
					add_action( 'login_head', array($this, 'PassHead') );
				#Add Custom Logo CSS to Login Page
					add_action( 'login_head', array($this, 'LogoHead') );
				#Hide initial login fields when email verification is enabled
					add_action( 'login_head', array($this, 'HideLogin') );
				#Save Default Settings
					add_action( 'init', array($this, 'DefaultSettings') );
				#Profile 
					add_action( 'show_user_profile', array($this, 'Add2Profile') );
					add_action( 'edit_user_profile', array($this, 'Add2Profile') );
					add_action( 'profile_update', array($this, 'SaveProfile') );
				#Validate User
					add_action( 'login_form', array($this, 'ValidateUser') );
				#Delete Invalid Users
					add_action( 'init', array($this, 'DeleteInvalidUsers') );
				#Unverified Users Head Scripts
					add_action( 'admin_head', array($this, 'UnverifiedHead') );
				#Admin Validate Users
					if( $_POST['verifyit'] )
						add_action( 'init', array($this, 'AdminValidate') );
				#Admin Resend VerificatioN Email
					if( $_POST['emailverifyit'] )
						add_action( 'init', array($this, 'AdminEmailValidate') );
				#Admin Delete Unverified User
					if( $_POST['vdeleteit'] )
						add_action( 'init', array($this, 'AdminDeleteUnvalidated') );
						
			//FILTERS
				#Check Register Form for Errors
				add_filter( 'registration_errors', array($this, 'RegErrors') );	
				
			//LOCALIZATION
				#Place your language file in the plugin folder and name it "regplus-{language}.mo"
				#replace {language} with your language value from wp-config.php
				load_plugin_textdomain( 'regplus', '/wp-content/plugins/register-plus' );
				
			//VERSION CONTROL
				if( $wp_version < 2.5 )
					add_action('admin_notices', array($this, 'version_warning'));
				
		}
		function version_warning(){ //Show warning if plugin is installed on a WordPress lower than 2.5
			global $wp_version;
			echo "<div id='regplus-warning' class='updated fade-ff0000'><p><strong>".__('Register Plus is only compatible with WordPress v2.5 and up.  You are currently using WordPress v.', 'regplus').$wp_version."</strong> </p></div>
		";
		}
		function AddPanel(){ //Add the Settings and User Panels
			add_options_page( 'Register Plus', 'Register Plus', 10, 'register-plus', array($this, 'RegPlusSettings') );
			$regplus = get_option('register_plus');
			if( $regplus['email_verify'] || $regplus['admin_verify'] )
				add_users_page( 'Unverified Users', 'Unverified Users', 10, 'unverified-users', array($this, 'Unverified') );
		}
		function DefaultSettings () { 
			$default = array( 
								'password' 				=> '0',
								'password_meter'		=> '0',
								'short'					=> 'Too Short',
								'bad'					=> 'Bad Password',
								'good'					=> 'Good Password',
								'strong'				=> 'Strong Password',
								'code' 					=> '0', 
								'codepass' 				=> array('0'),
								'captcha' 				=> '0',
								'disclaimer'			=> '0',
								'disclaimer_title'		=> 'Disclaimer',
								'disclaimer_content'	=> '',
								'disclaimer_agree'		=> 'Accept the Disclaimer',
								'license'				=> '0',
								'license_title'			=> 'License Agreement',
								'license_content'		=> '',
								'license_agree'			=> 'Accept the License Agreement',
								'privacy'				=> '0',
								'privacy_title'			=> 'Privacy Policy',
								'privacy_content'		=> '',
								'privacy_agree'			=> 'Accept the Privacy Policy',
								'email_exists'			=> '0',
								'firstname'				=> '0',
								'lastname'				=> '0',
								'website'				=> '0',
								'aim'					=> '0',
								'yahoo'					=> '0',
								'jabber'				=> '0',
								'about'					=> '0',
								'profile_req'			=> array('0'),
								'require_style'			=> 'border:solid 1px #E6DB55;background-color:#FFFFE0;',
								'dash_widget'			=> '0',
								'email_verify'			=> '0',
								'admin_verify'			=> '0',
								'email_delete_grace'	=> '7',
								'html'					=> '0',
								'adminhtml'				=> '0',
								'from'					=> get_option('admin_email'),
								'fromname'				=> get_option('blogname'),
								'subject'				=> sprintf(__('[%s] Your username and password', 'regplus'), get_option('blogname')),
								'custom_msg'			=> '0',
								'user_nl2br'			=> '0',
								'msg'					=> " %blogname% Registration \r\n --------------------------- \r\n\r\n Here are your credentials: \r\n Username: %user_login% \r\n Password: %user_pass% \r\n Confirm Registration: %siteurl% \r\n\r\n Thank you for registering with %blogname%!  \r\n",
								'disable_admin'			=> '0',
								'adminfrom'				=> get_option('admin_email'),
								'adminfromname'			=> get_option('blogname'),
								'adminsubject'			=> sprintf(__('[%s] New User Register', 'regplus'), get_option('blogname')),
								'custom_adminmsg'		=> '0',
								'admin_nl2br'			=> '0',
								'adminmsg'				=> " New %blogname% Registration \r\n --------------------------- \r\n\r\n Username: %user_login% \r\n E-Mail: %user_email% \r\n",
								'logo'					=> '',
								'login_redirect'		=> get_option('siteurl'),
								'register_css'			=> '',
								'login_css'				=> '',
								'firstday'				=> 6,
								'dateformat'			=> 'mm/dd/yyyy',
								'startdate'				=> '',
								'calyear'				=> '',
								'calmonth'				=> 'cur'
							);
			# Get Previously Saved Items and put into new Settings
			if( get_option("regplus_password") )
			  	$default['password'] = get_option("regplus_password");
			if( get_option("regplus_code") )
			  	$default['code'] = get_option("regplus_code");
			if( get_option("regplus_codepass") )
			  	$default['codepass'] = get_option("regplus_codepass");
			if( get_option("regplus_captcha") )
			  	$default['captcha'] = get_option("regplus_captcha");
			#Delete Previous Saved Items
			delete_option('regplus_password');
			delete_option('regplus_code');
			delete_option('regplus_codepass');
			delete_option('regplus_captcha');
			#Set Default Settings
			if( !get_option('register_plus') ){ #Set Defaults if no values exist
				add_option( 'register_plus', $default );
			}else{ #Set Defaults if new value does not exist
				$regplus = get_option( 'register_plus' );
				foreach( $default as $key => $val ){
					if( !$regplus[$key] ){
						$regplus[$key] = $val;
						$new = true;
					}
				}
				if( $new )
					update_option( 'register_plus', $regplus );
			}
		}
		function SaveSettings(){
			check_admin_referer('regplus-update-options');
			$update = get_option( 'register_plus' );
			$update["password"] = $_POST['regplus_password'];
			$update["password_meter"] = $_POST['regplus_password_meter'];
			$update["short"] = $_POST['regplus_short'];
			$update["bad"] = $_POST['regplus_bad'];
			$update["good"] = $_POST['regplus_good'];
			$update["strong"] = $_POST['regplus_strong'];
			$update["code"] = $_POST['regplus_code'];
			if( $_POST['regplus_code'] ) {
				$update["codepass"] = $_POST['regplus_codepass'];
				foreach( $update["codepass"] as $k=>$v ){
					$update["codepass"][$k] = strtolower($v);
				}
				$update["code_req"] = $_POST['regplus_code_req'];
			}
			$update["captcha"] = $_POST['regplus_captcha'];
			$update["disclaimer"] = $_POST['regplus_disclaimer'];
			$update["disclaimer_title"] = $_POST['regplus_disclaimer_title'];
			$update["disclaimer_content"] = $_POST['regplus_disclaimer_content'];
			$update["disclaimer_agree"] = $_POST['regplus_disclaimer_agree'];
			$update["license"] = $_POST['regplus_license'];
			$update["license_title"] = $_POST['regplus_license_title'];
			$update["license_content"] = $_POST['regplus_license_content'];
			$update["license_agree"] = $_POST['regplus_license_agree'];
			$update["privacy"] = $_POST['regplus_privacy'];
			$update["privacy_title"] = $_POST['regplus_privacy_title'];
			$update["privacy_content"] = $_POST['regplus_privacy_content'];
			$update["privacy_agree"] = $_POST['regplus_privacy_agree'];
			$update["email_exists"] = $_POST['regplus_email_exists'];
			$update["firstname"] = $_POST['regplus_firstname'];
			$update["lastname"] = $_POST['regplus_lastname'];
			$update["website"] = $_POST['regplus_website'];
			$update["aim"] = $_POST['regplus_aim'];
			$update["yahoo"] = $_POST['regplus_yahoo'];
			$update["jabber"] = $_POST['regplus_jabber'];
			$update["about"] = $_POST['regplus_about'];
			$update["profile_req"] = $_POST['regplus_profile_req'];
			$update["require_style"] = $_POST['regplus_require_style'];
			$update["dash_widget"] = $_POST['regplus_dash_widget'];
			$update["admin_verify"] = $_POST['regplus_admin_verify'];
			$update["email_verify"] = $_POST['regplus_email_verify'];
			$update["email_verify_date"] = $_POST['regplus_email_verify_date'];
			$update["email_delete_grace"] = $_POST['regplus_email_delete_grace'];
			$update["reCAP_public_key"] = $_POST['regplus_reCAP_public_key'];
			$update["reCAP_private_key"] = $_POST['regplus_reCAP_private_key'];
			$update['html'] = $_POST['regplus_html'];
			$update['from'] = $_POST['regplus_from'];
			$update['fromname'] = $_POST['regplus_fromname'];
			$update['subject'] = $_POST['regplus_subject'];
			$update['custom_msg'] = $_POST['regplus_custom_msg'];
			$update['user_nl2br'] = $_POST['regplus_user_nl2br'];
			$update['msg'] = $_POST['regplus_msg'];
			$update['disable_admin'] = $_POST['regplus_disable_admin'];
			$update['adminhtml'] = $_POST['regplus_adminhtml'];
			$update['adminfrom'] = $_POST['regplus_adminfrom'];
			$update['adminfromname'] = $_POST['regplus_adminfromname'];
			$update['adminsubject'] = $_POST['regplus_adminsubject'];
			$update['custom_adminmsg'] = $_POST['regplus_custom_adminmsg'];
			$update['admin_nl2br'] = $_POST['regplus_admin_nl2br'];
			$update['adminmsg'] = $_POST['regplus_adminmsg'];
			$update['login_redirect'] = $_POST['regplus_login_redirect'];
			$update['register_css'] = $_POST['regplus_register_css'];
			$update['login_css'] = $_POST['regplus_login_css'];
			$update['firstday'] = $_POST['regplus_firstday'];
			$update['dateformat'] = $_POST['regplus_dateformat'];
			$update['startdate'] = $_POST['regplus_startdate'];
			$update['calyear'] = $_POST['regplus_calyear'];
			$update['calmonth'] = $_POST['regplus_calmonth'];
			if( $_FILES['regplus_logo']['name'] ) $update['logo'] = $this->UploadLogo();
			else if( $_POST['remove_logo'] ) $update['logo'] = '';

			if( $_POST['label'] ){
				foreach( $_POST['label'] as $k => $field ){
					if( $field )
					$custom[$k] = array( 'label' => $field, 'profile' => $_POST['profile'][$k], 'reg' => $_POST['reg'][$k], 'required' => $_POST['required'][$k], 'fieldtype' => $_POST['fieldtype'][$k], 'extraoptions' => $_POST['extraoptions'][$k] );
				}
			}			
			
			update_option( 'register_plus_custom', $custom );
			update_option( 'register_plus', $update );
			$_POST['notice'] = __('Settings Saved', 'regplus');
		}
		
		function UploadLogo(){
		 	$upload_dir = ABSPATH . get_option('upload_path');
			$upload_file = trailingslashit($upload_dir) . basename($_FILES['regplus_logo']['name']);
			//echo $upload_file;
			if( !is_dir($upload_dir) )
				wp_upload_dir();
			if( move_uploaded_file($_FILES['regplus_logo']['tmp_name'], $upload_file) ){
				chmod($upload_file, 0777);				
				$logo = $_FILES['regplus_logo']['name'];			
				return trailingslashit( get_option('siteurl') ) . 'wp-content/uploads/' . $logo;
			}else{
				return false;
			}		 
		}
		
		function SettingsHead(){
			$regplus = get_option( 'register_plus' );
			?>
<script type="text/javascript">

function set_add_del_code(){
	jQuery('.remove_code').show();
	jQuery('.add_code').hide();
	jQuery('.add_code:last').show();
	jQuery(".code_block:only-child > .remove_code").hide();
}
function selremcode(clickety){
	jQuery(clickety).parent().remove(); 
	set_add_del_code(); 
	return false;
}
function seladdcode(clickety){
	jQuery('.code_block:last').after(
    	jQuery('.code_block:last').clone());
	jQuery('.code_block:last input').attr('value', '');

	set_add_del_code(); 
	return false;
}
function set_add_del(){
	jQuery('.remove_row').show();
	jQuery('.add_row').hide();
	jQuery('.add_row:last').show();
	jQuery(".row_block:only-child > .remove_row").hide();
}
function selrem(clickety){
	jQuery(clickety).parent().parent().remove(); 
	set_add_del(); 
	return false;
}
function seladd(clickety){
	jQuery('.row_block:last').after(
    	jQuery('.row_block:last').clone());
	jQuery('.row_block:last input.custom').attr('value', '');
	jQuery('.row_block:last input.extraops').attr('value', '');
	var custom = jQuery('.row_block:last input.custom').attr('name');
	var reg = jQuery('.row_block:last input.reg').attr('name');
	var profile = jQuery('.row_block:last input.profile').attr('name');
	var req = jQuery('.row_block:last input.required').attr('name');
	var fieldtype = jQuery('.row_block:last select.fieldtype').attr('name');
	var extraops = jQuery('.row_block:last input.extraops').attr('name');
	var c_split = custom.split("[");
	var r_split = reg.split("[");
	var p_split = profile.split("[");
	var q_split = req.split("[");
	var f_split = fieldtype.split("[");
	var e_split = extraops.split("[");
	var split2 = c_split[1].split("]");
	var index = parseInt(split2[0]) + 1;
	var c_name = c_split[0] + '[' + index + ']';
	var r_name = r_split[0] + '[' + index + ']';
	var p_name = p_split[0] + '[' + index + ']';
	var q_name = q_split[0] + '[' + index + ']';
	var f_name = f_split[0] + '[' + index + ']';
	var e_name = e_split[0] + '[' + index + ']';
	jQuery('.row_block:last input.custom').attr('name', c_name);
	jQuery('.row_block:last input.reg').attr('name', r_name);
	jQuery('.row_block:last input.profile').attr('name', p_name);
	jQuery('.row_block:last input.required').attr('name', q_name);
	jQuery('.row_block:last select.fieldtype').attr('name', f_name);
	jQuery('.row_block:last input.extraops').attr('name', e_name);
	set_add_del(); 
	return false;
}

jQuery(document).ready(function() {
	<?php if( !$regplus['code'] ){ ?>
	jQuery('#codepass').hide();
	<?php } ?>
	<?php if( !$regplus['password_meter'] ){ ?>
	jQuery('#meter').hide();
	<?php } ?>
	<?php if( !$regplus['disclaimer'] ){ ?>
	jQuery('#disclaim_content').hide();
	<?php } ?>
	<?php if( !$regplus['license'] ){ ?>
	jQuery('#lic_content').hide();
	<?php } ?>
	<?php if( !$regplus['privacy'] ){ ?>
	jQuery('#priv_content').hide();
	<?php } ?>
	<?php if( !$regplus['email_verify'] ){ ?>
	jQuery('#grace').hide();
	<?php } ?>
	<?php if( $regplus['captcha'] != 2 ){ ?>
	jQuery('#reCAPops').hide();
	<?php } ?>
	<?php if( $regplus['captcha'] != 1 ){ ?>
	jQuery('#SimpleDetails').hide();
	<?php } ?>
	<?php if( !$regplus['custom_msg'] ){ ?>
	jQuery('#enabled_msg').hide();
	<?php } ?>
	<?php if( !$regplus['custom_adminmsg'] ){ ?>
	jQuery('#enabled_adminmsg').hide();
	<?php } ?>
	jQuery('#email_verify').change(function() {
		if(jQuery('#email_verify').attr('checked'))
			jQuery('#grace').show();
		else
			jQuery('#grace').hide();
		return true;
	});
	jQuery('#code').change(function() {		
		if (jQuery('#code').attr('checked'))
			jQuery('#codepass').show();
		else
			jQuery('#codepass').hide();
		return true;
	});
	jQuery('#pwm').change(function() {		
		if (jQuery('#pwm').attr('checked'))
			jQuery('#meter').show();
		else
			jQuery('#meter').hide();
		return true;
	});
	jQuery('#disclaimer').change(function() {		
		if (jQuery('#disclaimer').attr('checked'))
			jQuery('#disclaim_content').show();
		else
			jQuery('#disclaim_content').hide();
		return true;
	});
	jQuery('#license').change(function() {		
		if (jQuery('#license').attr('checked'))
			jQuery('#lic_content').show();
		else
			jQuery('#lic_content').hide();
		return true;
	});
	jQuery('#privacy').change(function() {		
		if (jQuery('#privacy').attr('checked'))
			jQuery('#priv_content').show();
		else
			jQuery('#priv_content').hide();
		return true;
	});
	jQuery('#captcha').change(function() {
		if(jQuery('#captcha').attr('checked'))
			jQuery('#SimpleDetails').show();
		else
			jQuery('#SimpleDetails').hide();
		return true;
	});
	jQuery('#recaptcha').change(function() {
		if(jQuery('#recaptcha').attr('checked'))
			jQuery('#reCAPops').show();
		else
			jQuery('#reCAPops').hide();
		return true;
	});
	jQuery('#custom_msg').change(function() {
		if(jQuery('#custom_msg').attr('checked'))
			jQuery('#enabled_msg').show();
		else
			jQuery('#enabled_msg').hide();
		return true;
	});
	jQuery('#custom_adminmsg').change(function() {
		if(jQuery('#custom_adminmsg').attr('checked'))
			jQuery('#enabled_adminmsg').show();
		else
			jQuery('#enabled_adminmsg').hide();
		return true;
	});
	set_add_del_code();
	set_add_del();
});

</script>
            <?php
		}
		function UnverifiedHead(){
			if( $_GET['page'] == 'unverified-users')
				echo "<script type='text/javascript' src='".get_option('siteurl')."/wp-admin/js/forms.js?ver=20080317'></script>";
		}
		function AdminValidate(){
			global $wpdb;
			$regplus = get_option('register_plus');
			check_admin_referer('regplus-unverified');
			$valid = $_POST['vusers'];
			foreach( $valid as $user_id ){
				if ( $user_id ) {
					if( $regplus['email_verify'] ){
						$login = get_usermeta($user_id, 'email_verify_user');
						$wpdb->query( "UPDATE $wpdb->users SET user_login = '$login' WHERE ID = '$user_id'" );
						delete_usermeta($user_id, 'email_verify_user');
						delete_usermeta($user_id, 'email_verify');
						delete_usermeta($user_id, 'email_verify_date');
					}else if( $regplus['admin_verify'] ){
						$login = get_usermeta($user_id, 'admin_verify_user');
						$wpdb->query( "UPDATE $wpdb->users SET user_login = '$login' WHERE ID = '$user_id'" );
						delete_usermeta($user_id, 'admin_verify_user');
					}
					$this->VerifyNotification($user_id);
				}
			}
			$_POST['notice'] = __("Users Verified","regplus");
		}
		function AdminDeleteUnvalidated() {
			global $wpdb;
			$regplus = get_option('register_plus');
			check_admin_referer('regplus-unverified');
			$delete = $_POST['vusers'];
			include_once( ABSPATH . 'wp-admin/includes/user.php' );
			foreach( $delete as $user_id ){
				if ( $user_id ) {	
					wp_delete_user($user_id);
				}
			}
			$_POST['notice'] = __("Users Deleted","regplus");
		}
		function AdminEmailValidate(){
			global $wpdb;
			check_admin_referer('regplus-unverified');
			$valid = $_POST['vusers'];
			if( is_array($valid) ):
			foreach( $valid as $user_id ){
				$code = get_usermeta($user_id, 'email_verify');
				$user_login = get_usermeta($user_id, 'email_verify_user');
				$user_email = $wpdb->get_var("SELECT user_email FROM $wpdb->users WHERE ID='$user_id'");
				$email_code = '?regplus_verification=' . $code;
				$prelink = __('Verification URL: ', 'regplus');		
				$message  = sprintf(__('Username: %s', 'regplus'), $user_login) . "\r\n";
				//$message .= sprintf(__('Password: %s', 'regplus'), $plaintext_pass) . "\r\n";
				$message .= $prelink . get_option('siteurl') . "/wp-login.php" . $email_code . "\r\n"; 
				$message .= $notice; 
				add_filter('wp_mail_from', array($this, 'userfrom'));
				add_filter('wp_mail_from_name', array($this, 'userfromname'));
				wp_mail($user_email, sprintf(__('[%s] Verify Account Link', 'regplus'), get_option('blogname')), $message);
						
			}
			$_POST['notice'] = __("Verification Emails have been re-sent", "regplus");
			else:
			$_POST['notice'] = __("<strong>Error:</strong> Please select a user to send emails to.", "regplus");
			endif;
		}
		function VerifyNotification($user_id){
			global $wpdb;
			$regplus = get_option('register_plus');
			$user = $wpdb->get_row("SELECT user_login, user_email FROM $wpdb->users WHERE ID='$user_id'");
			$message = __('Your account has now been activated by an administrator.') . "\r\n";
			$message .= sprintf(__('Username: %s', 'regplus'), $user->user_login) . "\r\n";
			$message .= $prelink . get_option('siteurl') . "/wp-login.php" . $email_code . "\r\n"; 
			add_filter('wp_mail_from', array($this, 'userfrom'));
			add_filter('wp_mail_from_name', array($this, 'userfromname'));
			wp_mail($user->user_email, sprintf(__('[%s] User Account Activated', 'regplus'), get_option('blogname')), $message);
		}
		function Unverified(){
			global $wpdb;
			if( $_POST['notice'] )
				echo '<div id="message" class="updated fade"><p><strong>' . $_POST['notice'] . '.</strong></p></div>';
				
			$unverified = $wpdb->get_results("SELECT * FROM $wpdb->users WHERE user_login LIKE '%unverified__%'");
			$regplus = get_option('register_plus');
			?>
			<div class="wrap">
            	<h2><?php _e('Unverified Users', 'regplus')?></h2>
                <form id="verify-filter" method="post" action="">
                	<?php if( function_exists( 'wp_nonce_field' )) wp_nonce_field( 'regplus-unverified'); ?>
                    <div class="tablenav">
                    <div class="alignleft">
                    <input value="<?php _e('Verify Checked Users','regplus');?>" name="verifyit" class="button-secondary" type="submit">  &nbsp; <?php if( $regplus['email_verify'] ){ ?>
                    <input value="<?php _e('Resend Verification E-mail','regplus');?>" name="emailverifyit" class="button-secondary" type="submit"> <?php } ?> &nbsp; <input value="<?php _e('Delete','regplus');?>" name="vdeleteit" class="button-secondary delete" type="submit">
                    </div> 
                    <br class="clear">
                    </div>
                    
                    <br class="clear">

                    <table class="widefat">
                        <thead>
                        	<tr class="thead">
                            	<th scope="col" class="check-column"><input onclick="checkAll(document.getElementById('verify-filter'));" type="checkbox"> </th>
                                <th><?php _e('Unverified ID','regplus');?></th>
                                <th><?php _e('User Name','regplus');?></th>
                                <th><?php _e('E-mail','regplus');?></th>
                                <th><?php _e('Role','regplus');?></th>
                            </tr>
                            </thead>
                            <tbody id="users" class="list:user user-list">
                            <?php 
								foreach( $unverified as $un) {
								if( $alt ) $alt = ''; else $alt = "alternate";
								$user_object = new WP_User($un->ID);
								$roles = $user_object->roles;
								$role = array_shift($roles);
								if( $regplus['email_verify'] )
									$user_login = get_usermeta($un->ID, 'email_verify_user');
								else if( $regplus['admin_verify'] )
									$user_login = get_usermeta($un->ID, 'admin_verify_user');
							?>
                                <tr id="user-1" class="<?php echo $alt;?>">
                                    <th scope="row" class="check-column"><input name="vusers[]" id="user_<?php echo $un->ID;?>" class="administrator" value="<?php echo $un->ID;?>" type="checkbox"></th>
                                    <td><strong><?php echo $un->user_login;?></strong></td>
                                    <td><strong><?php echo $user_login;?></strong></td>
                            
                                    <td><a href="mailto:<?php echo $un->user_email;?>" title="<?php _e('e-mail: ', 'regplus'); echo $un->user_email;?>"><?php echo $un->user_email;?></a></td>
                                    <td><?php echo ucwords($role);?></td>
                                </tr>
                             <?php } ?>
                             </tbody>
                          </table>
                      </form>
                 </div>
                 

           <?php
		}
		
		function RegPlusSettings(){
			$regplus = get_option( 'register_plus' );
			$regplus_custom = get_option( 'register_plus_custom' );
			$plugin_url = trailingslashit(get_option('siteurl')) . 'wp-content/plugins/' . basename(dirname(__FILE__)) .'/';
			if( $_POST['notice'] )
				echo '<div id="message" class="updated fade"><p><strong>' . $_POST['notice'] . '.</strong></p></div>';
			if( !is_array($regplus['profile_req']) )
				$regplus['profile_req'] = array();
			if( is_array($regplus['codepass']) ){
				foreach( $regplus['codepass'] as $code ){
					$codes .= '<div class="code_block">
                                    <input type="text" name="regplus_codepass[]"  value="' . $code . '" /> &nbsp;
                                    <a href="#" onClick="return selremcode(this);" class="remove_code"><img src="' . $plugin_url . 'removeBtn.gif" alt="' . __("Remove Code","regplus") . '" title="' .  __("Remove Code","regplus") . '" /></a>
						<a href="#" onClick="return seladdcode(this);" class="add_code"><img src="' . $plugin_url . 'addBtn.gif" alt="' . __("Add Code","regplus") . '" title="' . __("Add Code","regplus") . '" /></a>
                                    </div>';
				}
			}
			$types = '<option value="text">Text Field</option><option value="date">Date Field</option><option value="select">Select Field</option><option value="checkbox">Checkbox</option><option value="radio">Radio Box</option><option value="textarea">Text Area</option><option value="hidden">Hidden Field</option>';
			$extras = '<div class="extraoptions" style="float:left"><label>Extra Options: <input type="text" class="extraops" name="extraoptions[0]" value="" /></label></div>';
			if( is_array($regplus_custom) ){
				foreach( $regplus_custom as $k => $v ) {
					$types = '<option value="text"';
					if( $v['fieldtype'] == 'text' ) $types .= ' selected="selected"';
					$types .='>Text Field</option><option value="date"';
					if( $v['fieldtype'] == 'date' ) $types .= ' selected="selected"';
					$types .='>Date Field</option><option value="select"';
					if( $v['fieldtype'] == 'select' ) $types .= ' selected="selected"';
					$types .= '>Select Field</option><option value="checkbox"';
					if( $v['fieldtype'] == 'checkbox' ) $types .= ' selected="selected"';
					$types .= '>Checkbox</option><option value="radio"';
					if( $v['fieldtype'] == 'radio' ) $types .= ' selected="selected"';
					$types .= '>Radio Box</option><option value="textarea"';
					if( $v['fieldtype'] == 'textarea' ) $types .= ' selected="selected"';
					$types .= '>Text Area</option><option value="hidden"';
					if( $v['fieldtype'] == 'hidden' ) $types .= ' selected="selected"';
					$types .= '>Hidden Field</option>';
					
					$extras = '<div class="extraoptions" style="float:left;"><label>Extra Options: <input type="text" name="extraoptions['.$k.']" class="extraops" value="' . $v['extraoptions'] . '" /></label></div>';

					
					$rows .= '<tr valign="top" class="row_block">
                       			 <th scope="row"><label for="custom">' . __('Custom Field', 'regplus') . '</label></th>
                        		<td><input type="text" name="label['.$k.']" class="custom" style="font-size:16px;padding:2px; width:150px;" value="' . $v['label'] . '" /> &nbsp; ';
					$rows .= '<select name="fieldtype['.$k.']" class="fieldtype">'.$types.'</select> '.$extras.' &nbsp; ';
					$rows .= '<label><input type="checkbox" name="reg['.$k.']" class="reg" value="1"';
					if( $v['reg'] ) $rows .= ' checked="checked"';
					$rows .= ' /> ' .  __('Add Registration Field', 'regplus') . '</label> &nbsp; <label><input type="checkbox" name="profile['.$k.']" class="profile" value="1"';
					if( $v['profile'] ) $rows .= ' checked="checked"';
					$rows .= ' /> ' . __('Add Profile Field', 'regplus') . '</label> &nbsp; <label><input type="checkbox" name="required['.$k.']" class="required" value="1"';
					if( $v['required'] ) $rows .= ' checked="checked"';
					$rows .= ' /> ' . __('Required', 'regplus') . '</label> &nbsp; 
                                
                                <a href="#" onClick="return selrem(this);" class="remove_row"><img src="' . $plugin_url . 'removeBtn.gif" alt="' . __("Remove Row","regplus") . '" title="' . __("Remove Row","regplus") . '" /></a>
						<a href="#" onClick="return seladd(this);" class="add_row"><img src="' . $plugin_url . 'addBtn.gif" alt="' . __("Add Row","regplus") . '" title="' . __("Add Row","regplus") . '" /></a></td>
                        	</tr>';
				}
			}
			?>
            <div class="wrap">
            	<h2><?php _e('Register Plus Settings', 'regplus')?></h2>
                <form method="post" action="" enctype="multipart/form-data">
                	<?php if( function_exists( 'wp_nonce_field' )) wp_nonce_field( 'regplus-update-options'); ?>
                    <p class="submit"><input name="Submit" value="<?php _e('Save Changes','regplus');?>" type="submit" />
                    <table class="form-table">
                        <tbody>
                        	<tr valign="top">
                       			 <th scope="row"><label for="password"><?php _e('Password', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_password" id="password" value="1" <?php if( $regplus['password'] ) echo 'checked="checked"';?> /> <?php _e('Allow New Registrations to set their own Password', 'regplus');?></label><br />
                                <label><input type="checkbox" name="regplus_password_meter" id="pwm" value="1" <?php if( $regplus['password_meter'] ) echo 'checked="checked"';?> /> <?php _e('Enable Password Strength Meter','regplus');?></label>
                                <div id="meter" style="margin-left:20px;">
                                	<label><?php _e('Short', 'regplus');?> <input type="text" name="regplus_short" value="<?php echo $regplus['short'];?>" /></label><br />
                                    <label><?php _e('Bad', 'regplus');?> <input type="text" name="regplus_bad" value="<?php echo $regplus['bad'];?>" /></label><br />
                                    <label><?php _e('Good', 'regplus');?> <input type="text" name="regplus_good" value="<?php echo $regplus['good'];?>" /></label><br />
                                    <label><?php _e('Strong', 'regplus');?> <input type="text" name="regplus_strong" value="<?php echo $regplus['strong'];?>" /></label><br />
                                </div>
                                </td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="logo"><?php _e('Custom Logo', 'regplus');?></label></th>
                        		<td><input type="file" name="regplus_logo" id="logo" value="1" /> &nbsp; <small><?php _e("Recommended Logo width is 292px, but any height should work.", "regplus");?></small><br /> <img src="<?php echo $regplus['logo'];?>" alt="" />
                                <?php if ( $regplus['logo'] ) {?>
                                <br /><label><input type="checkbox" name="remove_logo" value="1" /> <?php _e('Delete Logo', 'regplus');?></label>
                                <?php } else { ?>
                                <p><small><strong><?php _e('Having troubles uploading?','regplus');?></strong>  <?php _e('Uncheck "Organize my uploads into month- and year-based folders" in','regplus');?> <a href="<?php echo get_option('siteurl');?>/wp-admin/options-misc.php"><?php _e('Miscellaneous Settings', 'regplus');?></a>. <?php _e('(You can recheck this option after your logo has uploaded.)','regplus');?></small></p>
                                <?php } ?>
                                 </td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="email_verify"><?php _e('Email Verification', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_email_verify" id="email_verify" value="1" <?php if( $regplus['email_verify'] ) echo 'checked="checked"';?> /> <?php _e('Prevent fake email address registrations.', 'regplus');?></label><br />
                                <?php _e('Requires new registrations to click a link in the notification email to enable their account.', 'regplus');?>
                                <div id="grace"><label for="email_delete_grace"><strong><?php _e('Grace Period (days)', 'regplus');?></strong>: </label><input type="text" name="regplus_email_delete_grace" id="email_delete_grace" style="width:50px;" value="<?php echo $regplus['email_delete_grace'];?>" /><br />
                                <?php _e('Unverified Users will be automatically deleted after grace period expires', 'regplus');?></div>
</td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="admin_verify"><?php _e('Admin Verification', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_admin_verify" id="admin_verify" value="1" <?php if( $regplus['admin_verify'] ) echo 'checked="checked"';?> /> <?php _e('Moderate all user registrations to require admin approval. NOTE: Email Verification must be DISABLED to use this feature.', 'regplus');?></label></td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="code"><?php _e('Invitation Code', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_code" id="code" value="1" <?php if( $regplus['code'] ) echo 'checked="checked"';?> /> <?php _e('Enable Invitation Code(s)', 'regplus');?></label>
                                    <div id="codepass">
                                    <label><input type="checkbox" name="regplus_dash_widget" value="1" <?php if( $regplus['dash_widget'] ) echo 'checked="checked"'; ?>  /> <?php _e('Enable Invitation Tracking Dashboard Widget', 'regplus');?></label><br />
                                    <label><input type="checkbox" name="regplus_code_req" id="code_req" value="1" <?php if( $regplus['code_req'] ) echo 'checked="checked"';?> /> <?php _e('Require Invitation Code to Register', 'regplus');?></label>
                              <?php if( $codes ){ echo $codes; } else { ?>
                                    <div class="code_block">
                                    <input type="text" name="regplus_codepass[]"  value="<?php echo $regplus['codepass'];?>" /> &nbsp;
                                    <a href="#" onClick="return selremcode(this);" class="remove_code"><img src="<?php echo $plugin_url; ?>removeBtn.gif" alt="<?php _e("Remove Code","regplus")?>" title="<?php _e("Remove Code","regplus")?>" /></a>
						<a href="#" onClick="return seladdcode(this);" class="add_code"><img src="<?php echo $plugin_url; ?>addBtn.gif" alt="<?php _e("Add Code","regplus")?>" title="<?php _e("Add Code","regplus")?>" /></a>
                                    </div>
                               <?php } ?>
                                    <small><?php _e('One of these codes will be required for users to register.', 'regplus');?></small></div>
                                    </td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="captcha"><?php _e('CAPTCHA', 'regplus');?></label></th>
                        		<td><label><input type="radio" name="regplus_captcha" id="none" value="0" <?php if( $regplus['captcha'] == 0 ) echo 'checked="checked"';?> /> <?php _e('None', 'regplus');?></label> <input type="radio" name="regplus_captcha" id="captcha" value="1" <?php if( $regplus['captcha'] == 1 ) echo 'checked="checked"';?> /> <?php _e('Simple CAPTCHA', 'regplus');?></label> <label><input type="radio" name="regplus_captcha" id="recaptcha" value="2" <?php if( $regplus['captcha'] == 2 ) echo 'checked="checked"';?> /> <a href="http://recaptcha.net/"><?php _e('reCAPTCHA','regplus');?></a></label>
                                <div id="SimpleDetails">
                                <p><?php _e('You may need to add the code <code>&lt;?php session_start(); ?></code> to the top line of the wp_login.php file to enable Simple CAPTCHA to work correctly.', 'regplus');?></p>
                                </div>
                                <div id="reCAPops">
                                <label for="public_key"><?php _e('reCAPTCHA Public Key:','regplus');?></label> <input type="text" style="width:500px;" name="regplus_reCAP_public_key" id="public_key" value="<?php echo $regplus['reCAP_public_key'];?>" /> <a href="<?php require_once ("recaptchalib.php"); echo rp_recaptcha_get_signup_url('skullbit.com','register_plus');?>" target="_blank"><?php _e('Sign up &raquo;','regplus');?></a><br />
								<label for="private_key"><?php _e('reCAPTCHA Private Key:','regplus');?></label> <input type="text" style="width:500px;" id="private_key" name="regplus_reCAP_private_key" value="<?php echo $regplus['reCAP_private_key'];?>" />
                                </div>
                                
                                </td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="disclaimer"><?php _e('Disclaimer', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_disclaimer" id="disclaimer" value="1" <?php if($regplus['disclaimer']) echo 'checked="checked"';?> /> <?php _e('Enable Disclaimer','regplus');?></label>
                                <div id="disclaim_content">
                                <label for="disclaimer_title"><?php _e('Disclaimer Title','regplus');?></label> <input type="text" name="regplus_disclaimer_title" id="disclaimer_title" value="<?php echo $regplus['disclaimer_title'];?>" /> <br />
                                <label for="disclaimer_content"><?php _e('Disclaimer Content','regplus');?></label><br />
                                <textarea name="regplus_disclaimer_content" id="disclaimer_content" cols="25" rows="10" style="width:80%;height:300px;display:block;"><?php echo stripslashes($regplus['disclaimer_content']);?></textarea><br />
                                <label for="disclaimer_agree"><?php _e('Agreement Text','regplus');?></label> <input type="text" name="regplus_disclaimer_agree" id="disclaimer_agree" value="<?php echo $regplus['disclaimer_agree'];?>" />
                                </div></td>
                        	</tr>
                            
                            <tr valign="top">
                       			 <th scope="row"><label for="license"><?php _e('License Agreement', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_license" id="license" value="1" <?php if($regplus['license']) echo 'checked="checked"';?> /> <?php _e('Enable License Agreement','regplus');?></label>
                                <div id="lic_content">
                                <label for="license_title"><?php _e('License Title','regplus');?></label> <input type="text" name="regplus_license_title" id="license_title" value="<?php echo $regplus['license_title'];?>" /> <br />
                                <label for="license_content"><?php _e('License Content','regplus');?></label><br />
                                <textarea name="regplus_license_content" id="license_content" cols="25" rows="10" style="width:80%;height:300px;display:block;"><?php echo stripslashes($regplus['license_content']);?></textarea><br />
                                <label for="license_agree"><?php _e('Agreement Text','regplus');?></label> <input type="text" name="regplus_license_agree" id="license_agree" value="<?php echo $regplus['license_agree'];?>" />
                                </div></td>
                        	</tr>
                            
                            <tr valign="top">
                       			 <th scope="row"><label for="privacy"><?php _e('Privacy Policy', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_privacy" id="privacy" value="1" <?php if($regplus['privacy']) echo 'checked="checked"';?> /> <?php _e('Enable Privacy Policy','regplus');?></label>
                                <div id="priv_content">
                                <label for="privacy_title"><?php _e('Privacy Policy Title','regplus');?></label> <input type="text" name="regplus_privacy_title" id="privacy_title" value="<?php echo $regplus['privacy_title'];?>" /> <br />
                                <label for="privacy_content"><?php _e('Privacy Policy Content','regplus');?></label><br />
                                <textarea name="regplus_privacy_content" id="privacy_content" cols="25" rows="10" style="width:80%;height:300px;display:block;"><?php echo stripslashes($regplus['privacy_content']);?></textarea><br />
                                <label for="privacy_agree"><?php _e('Agreement Text','regplus');?></label> <input type="text" name="regplus_privacy_agree" id="privacy_agree" value="<?php echo $regplus['privacy_agree'];?>" />
                                </div></td>
                        	</tr>
                            
                            <tr valign="top">
                       			 <th scope="row"><label for="email_exists"><?php _e('Allow Existing Email', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_email_exists" id="email_exists" value="1" <?php if( $regplus['email_exists'] ) echo 'checked="checked""';?> /> <?php _e('Allow new registrations to use an email address that has been previously registered', 'regplus');?></label></td>
                        	</tr>
                         </tbody>
                 	</table>
                    <h3><?php _e('Additional Profile Fields', 'regplus');?></h3>
                    <p><?php _e('Check the fields you would like to appear on the Registration Page.', 'regplus');?></p>
                    <table class="form-table">
                        <tbody>
                        	<tr valign="top">
                       			 <th scope="row"><label for="name"><?php _e('Name', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_firstname" id="name" value="1" <?php if( $regplus['firstname'] ) echo 'checked="checked"';?> /> <?php _e('First Name', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_lastname" value="1" <?php if( $regplus['lastname'] ) echo 'checked="checked"';?> /> <?php _e('Last Name', 'regplus');?></label></td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="contact"><?php _e('Contact Info', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_website" id="contact" value="1" <?php if( $regplus['website'] ) echo 'checked="checked"';?> /> <?php _e('Website', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_aim" value="1" <?php if( $regplus['aim'] ) echo 'checked="checked"';?> /> <?php _e('AIM', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_yahoo" value="1" <?php if( $regplus['yahoo'] ) echo 'checked="checked"';?> /> <?php _e('Yahoo IM', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_jabber" value="1" <?php if( $regplus['jabber'] ) echo 'checked="checked"';?> /> <?php _e('Jabber / Google Talk', 'regplus');?></label></td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="about"><?php _e('About Yourself', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_about" id="name" value="1" <?php if( $regplus['about'] ) echo 'checked="checked"';?> /> <?php _e('About Yourself', 'regplus');?></label></td>
                        	</tr>
                            <tr valign="top">
                       			 <th scope="row"><label for="req"><?php _e('Required Profile Fields', 'regplus');?></label></th>
                        		<td><label><input type="checkbox" name="regplus_profile_req[]" value="firstname" <?php if( in_array('firstname', $regplus['profile_req']) ) echo 'checked="checked"';?> /> <?php _e('First Name', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_profile_req[]" value="lastname" <?php if( in_array('lastname', $regplus['profile_req']) ) echo 'checked="checked"';?> /> <?php _e('Last Name', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_profile_req[]" value="website" <?php if( in_array('website', $regplus['profile_req']) ) echo 'checked="checked"';?> /> <?php _e('Website', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_profile_req[]" value="aim" <?php if( in_array('aim', $regplus['profile_req']) ) echo 'checked="checked"';?> /> <?php _e('AIM', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_profile_req[]" value="yahoo" <?php if( in_array('yahoo', $regplus['profile_req']) ) echo 'checked="checked"';?> /> <?php _e('Yahoo IM', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_profile_req[]" value="jabber" <?php if( in_array('jabber', $regplus['profile_req']) ) echo 'checked="checked"';?> /> <?php _e('Jabber / Google Talk', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_profile_req[]" value="about" <?php if( in_array('about', $regplus['profile_req']) ) echo 'checked="checked"';?> /> <?php _e('About Yourself', 'regplus');?></label></td>
                        	</tr>
                            <tr valign="top">
                            	<th scope="row"><label for="require_style"><?php _e('Required Field Style Rules', 'regplus');?></label></th>
                                <td><input type="text" name="regplus_require_style" id="require_style" value="<?php echo $regplus['require_style'];?>" style="width: 350px;" /></td>
                            </tr>
                            
                         </tbody>
                     </table>
                     <h3><?php _e('User Defined Fields', 'regplus');?></h3>
                    <p><?php _e('Enter the custom fields you would like to appear on the Registration Page.', 'regplus');?></p>
                    <p><small><?php _e('Enter Extra Options for Select, Checkboxes and Radio Fields as comma seperated values. For example, if you chose a select box for a custom field of "Gender", your extra options would be "Male,Female".','regplus');?></small></p>
                    <table class="form-table">
                        <tbody>
                        <?php if( $rows ){ echo $rows; }else{ ?>
                        	<tr valign="top" class="row_block">
                       			 <th scope="row"><label for="custom"><?php _e('Custom Field', 'regplus');?></label></th>
                        		<td><input type="text" name="label[0]" class="custom" style="font-size:16px;padding:2px; width:150px;" value="" /> &nbsp; <select class="fieldtype" name="fieldtype[0]"><?php echo $types; ?></select> <?php echo $extras;?> &nbsp; <label><input type="checkbox" name="reg[0]" class="reg" value="1" />  <?php _e('Add Registration Field', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="profile[0]"  class="profile" value="1" /> <?php _e('Add Profile Field', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="required[0]" class="required" value="1" /> <?php _e('Required', 'regplus');?></label> &nbsp; 
                                
                                <a href="#" onClick="return selrem(this);" class="remove_row"><img src="<?php echo $plugin_url; ?>removeBtn.gif" alt="<?php _e("Remove Row","regplus")?>" title="<?php _e("Remove Row","regplus")?>" /></a>
						<a href="#" onClick="return seladd(this);" class="add_row"><img src="<?php echo $plugin_url; ?>addBtn.gif" alt="<?php _e("Add Row","regplus")?>" title="<?php _e("Add Row","regplus")?>" /></a></td>
                        	</tr>
                          <?php } ?>
                          	</tbody>
                       </table>
                       <table class="form-table">
                        <tbody>
                            <tr valign="top">
                       			 <th scope="row"><label for="date"><?php _e('Date Field Settings', 'regplus');?></label></th>
                        		<td><label><?php _e('First Day of the Week','regplus');?>: <select type="select" name="regplus_firstday">
                                		<option value="7" <?php if( $regplus['firstday'] == '7' ) echo 'selected="selected"';?>><?php _e('Monday','regplus');?></option>
                                        <option value="1" <?php if( $regplus['firstday'] == '1' ) echo 'selected="selected"';?>><?php _e('Tuesday','regplus');?></option>
                                        <option value="2" <?php if( $regplus['firstday'] == '2' ) echo 'selected="selected"';?>><?php _e('Wednesday','regplus');?></option>
                                        <option value="3" <?php if( $regplus['firstday'] == '3' ) echo 'selected="selected"';?>><?php _e('Thursday','regplus');?></option>
                                        <option value="4" <?php if( $regplus['firstday'] == '4' ) echo 'selected="selected"';?>><?php _e('Friday','regplus');?></option>
                                        <option value="5" <?php if( $regplus['firstday'] == '5' ) echo 'selected="selected"';?>><?php _e('Saturday','regplus');?></option>
                                        <option value="6" <?php if( $regplus['firstday'] == '6' ) echo 'selected="selected"';?>><?php _e('Sunday','regplus');?></option>
                                        </select>
                                    </label> &nbsp; 
                                     <label for="dateformat"><?php _e('Date Format','regplus');?>:</label> <input type="text" name="regplus_dateformat" id="dateformat" value="<?php echo $regplus['dateformat'];?>" style="width:100px;" /> &nbsp; 
                                      <label for="startdate"><?php _e('First Selectable Date','regplus');?>:</label> <input type="text" name="regplus_startdate" id="startdate" value="<?php echo $regplus['startdate'];?>"  style="width:100px;" /> <br />
                                       <label for="calyear"><?php _e('Default Year','regplus');?>:</label> <input type="text" name="regplus_calyear" id="calyear" value="<?php echo $regplus['calyear'];?>" style="width:40px;" /> &nbsp;
                                       <label for="calmonth"><?php _e('Default Month','regplus');?>:</label> <select name="regplus_calmonth" id="calmonth">
                                       		<option value="cur" <?php if( $regplus['calmonth'] === 'cur' ) echo 'selected="selected"';?>><?php _e('Current Month','regplus');?></option>
                                            <option value="0" <?php if( $regplus['calmonth'] == '0' ) echo 'selected="selected"';?>><?php _e('Jan','regplus');?></option>
                                            <option value="1" <?php if( $regplus['calmonth'] == '1' ) echo 'selected="selected"';?>><?php _e('Feb','regplus');?></option>
                                            <option value="2" <?php if( $regplus['calmonth'] == '2' ) echo 'selected="selected"';?>><?php _e('Mar','regplus');?></option>
                                            <option value="3" <?php if( $regplus['calmonth'] == '3' ) echo 'selected="selected"';?>><?php _e('Apr','regplus');?></option>
                                            <option value="4" <?php if( $regplus['calmonth'] == '4' ) echo 'selected="selected"';?>><?php _e('May','regplus');?></option>
                                            <option value="5" <?php if( $regplus['calmonth'] == '5' ) echo 'selected="selected"';?>><?php _e('Jun','regplus');?></option>
                                            <option value="6" <?php if( $regplus['calmonth'] == '6' ) echo 'selected="selected"';?>><?php _e('Jul','regplus');?></option>
                                            <option value="7" <?php if( $regplus['calmonth'] == '7' ) echo 'selected="selected"';?>><?php _e('Aug','regplus');?></option>
                                            <option value="8" <?php if( $regplus['calmonth'] == '8' ) echo 'selected="selected"';?>><?php _e('Sep','regplus');?></option>
                                            <option value="9" <?php if( $regplus['calmonth'] == '9' ) echo 'selected="selected"';?>><?php _e('Oct','regplus');?></option>
                                            <option value="10" <?php if( $regplus['calmonth'] == '10' ) echo 'selected="selected"';?>><?php _e('Nov','regplus');?></option>
                                            <option value="11" <?php if( $regplus['calmonth'] == '11' ) echo 'selected="selected"';?>><?php _e('Dec','regplus');?></option>
                                       </select>
                                     
                                    </td>
                            </tr>
                        </tbody>
                     </table>
                     
                     <h3><?php _e('Auto-Complete Queries', 'regplus');?></h3>
                     <p><?php _e('You can now link to the registration page with queries to autocomplete specific fields for the user.  I have included the query keys below and an example of a query URL.', 'regplus');?></p>
                                <code>user_login &nbsp; user_email &nbsp; firstname &nbsp; lastname &nbsp; website  &nbsp; aim &nbsp; yahoo &nbsp; jabber &nbsp; about &nbsp; code</code>
                               <p><?php _e('For any custom fields, use your custom field label with the text all lowercase, using underscores instead of spaces. For example if your custom field was "Middle Name" your query key would be <code>middle_name</code>', 'regplus');?></p>
                               <p><strong><?php _e('Example Query URL', 'regplus');?></strong></p>
                                <code>http://www.skullbit.com/wp-login.php?action=register&user_login=skullbit&user_email=info@skullbit.com&firstname=Skull&lastname=Bit&website=www.skullbit.com&aim=skullaim&yahoo=skullhoo&jabber=skulltalk&about=I+am+a+WordPress+Plugin+developer.&code=invitation&middle_name=Danger </code>
                     
                     <h3><?php _e('Customize User Notification Email', 'regplus');?></h3>
                    <table class="form-table"> 
                        <tbody>
                        <tr valign="top">
                       		<th scope="row"><label><?php _e('Custom User Email Notification', 'regplus');?></label></th>
                        	<td><label><input type="checkbox" name="regplus_custom_msg" id="custom_msg" value="1" <?php if( $regplus['custom_msg'] ) echo 'checked="checked"';?> /> <?php _e('Enable', 'regplus');?></label></td>
                       	</tr>
                   		</tbody>
                    </table>
                    <div id="enabled_msg">
                    <table class="form-table">
                        <tbody>
                        <tr valign="top">
                       		<th scope="row"><label for="from"><?php _e('From Email', 'regplus');?></label></th>
                        	<td><input type="text" name="regplus_from" id="from" style="width:250px;" value="<?php echo $regplus['from'];?>" /></td>
                         </tr>
                         <tr valign="top">
                            <th scope="row"><label for="fromname"><?php _e('From Name', 'regplus');?></label></th>
                        	<td><input type="text" name="regplus_fromname" id="fromname" style="width:250px;" value="<?php echo $regplus['fromname'];?>" /></td>
                       	</tr>
                        <tr valign="top">
                       		<th scope="row"><label for="subject"><?php _e('Subject', 'regplus');?></label></th>
                        	<td><input type="text" name="regplus_subject" id="subject" style="width:350px;" value="<?php echo $regplus['subject'];?>" /></td>
                       	</tr>
                        <tr valign="top">
                       		<th scope="row"><label for="msg"><?php _e('User Message', 'regplus');?></label></th>
                        	<td>
                            <?php
							if( $regplus['firstname'] ) $custom_keys .= ' &nbsp; %firstname%';
							if( $regplus['lastname'] ) $custom_keys .= ' &nbsp; %lastname%';
							if( $regplus['website'] ) $custom_keys .= ' &nbsp; %website%';
							if( $regplus['aim'] ) $custom_keys .= ' &nbsp; %aim%';
							if( $regplus['yahoo'] ) $custom_keys .= ' &nbsp; %yahoo%';
							if( $regplus['jabber'] ) $custom_keys .= ' &nbsp; %jabber%';
							if( $regplus['about'] ) $custom_keys .= ' &nbsp; %about%';
							if( $regplus['code'] ) $custom_keys .= ' &nbsp; %invitecode%';

							if( is_array($regplus_custom) ){
								foreach( $regplus_custom as $k=>$v ){
									$meta = $this->Label_ID($v['label']);
									$value = get_usermeta( $user_id, $meta );
									$custom_keys .= ' &nbsp; %'.$meta.'%';
								}
							}
							?>
                            <p><strong><?php _e('Replacement Keys', 'regplus');?>:</strong> &nbsp; %user_login%  &nbsp; %user_pass% &nbsp; %user_email% &nbsp; %blogname% &nbsp; %siteurl% <?php echo $custom_keys; ?>&nbsp; %user_ip% &nbsp; %user_ref% &nbsp; %user_host% &nbsp; %user_agent% </p>
                            <textarea name="regplus_msg" id="msg" rows="10" cols="25" style="width:80%;height:300px;"><?php echo $regplus['msg'];?></textarea><br /><label><input type="checkbox" name="regplus_html" id="html" value="1" <?php if( $regplus['html'] ) echo 'checked="checked"';?> /> <?php _e('Send as HTML', 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_user_nl2br" id="html" value="1" <?php if( $regplus['user_nl2br'] ) echo 'checked="checked"';?> /> <?php _e('Convert new lines to &lt;br/> tags (HTML only)' , 'regplus');?></label></td>
                       	</tr>
                        <tr valign="top">
                       		<th scope="row"><label for="login_redirect"><?php _e('Login Redirect URL', 'regplus');?></label></th>
                        	<td><input type="text" name="regplus_login_redirect" id="login_redirect" style="width:250px;" value="<?php echo $regplus['login_redirect'];?>" /> <small><?php _e('This will redirect the users login after registration.', 'regplus');?></small></td>
                       	</tr>
                        </tbody>
                     </table>
                     </div>
                     
                     <h3><?php _e('Customize Admin Notification Email', 'regplus');?></h3>
                    <table class="form-table"> 
                        <tbody>
                        <tr valign="top">
                       		<th scope="row"><label for="disable_admin"><?php _e('Admin Email Notification', 'regplus');?></label></th>
                        	<td><label><input type="checkbox" name="regplus_disable_admin" id="disable_admin" value="1" <?php if( $regplus['disable_admin'] ) echo 'checked="checked"';?> /> <?php _e('Disable', 'regplus');?></label></td>
                       	</tr>
                        <tr valign="top">
                       		<th scope="row"><label><?php _e('Custom Admin Email Notification', 'regplus');?></label></th>
                        	<td><label><input type="checkbox" name="regplus_custom_adminmsg" id="custom_adminmsg" value="1" <?php if( $regplus['custom_adminmsg'] ) echo 'checked="checked"';?> /> <?php _e('Enable', 'regplus');?></label></td>
                       	</tr>
                   		</tbody>
                    </table>
                    <div id="enabled_adminmsg">
                    <table class="form-table">
                        <tbody>
                        <tr valign="top">
                       		<th scope="row"><label for="adminfrom"><?php _e('From Email', 'regplus');?></label></th>
                        	<td><input type="text" name="regplus_adminfrom" id="adminfrom" style="width:250px;" value="<?php echo $regplus['adminfrom'];?>" /></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="adminfromname"><?php _e('From Name', 'regplus');?></label></th>
                        	<td><input type="text" name="regplus_adminfromname" id="adminfromname" style="width:250px;" value="<?php echo $regplus['adminfromname'];?>" /></td>
                       	</tr>
                        <tr valign="top">
                       		<th scope="row"><label for="adminsubject"><?php _e('Subject', 'regplus');?></label></th>
                        	<td><input type="text" name="regplus_adminsubject" id="adminsubject" style="width:350px;" value="<?php echo $regplus['adminsubject'];?>" /></td>
                       	</tr>
                        <tr valign="top">
                       		<th scope="row"><label for="adminmsg"><?php _e('Admin Message', 'regplus');?></label></th>
                        	<td>
                            <p><strong><?php _e('Replacement Keys', 'regplus');?>:</strong> &nbsp; %user_login%  &nbsp; %user_email% &nbsp; %blogname% &nbsp; %siteurl%  <?php echo $custom_keys; ?>&nbsp; %user_ip% &nbsp; %user_ref% &nbsp; %user_host% &nbsp; %user_agent%</p><textarea name="regplus_adminmsg" id="adminmsg" rows="10" cols="25" style="width:80%;height:300px;"><?php echo $regplus['adminmsg'];?></textarea><br /><label><input type="checkbox" name="regplus_adminhtml" id="adminhtml" value="1" <?php if( $regplus['adminhtml'] ) echo 'checked="checked"';?> /> <?php _e('Send as HTML' , 'regplus');?></label> &nbsp; <label><input type="checkbox" name="regplus_admin_nl2br" id="html" value="1" <?php if( $regplus['admin_nl2br'] ) echo 'checked="checked"';?> /> <?php _e('Convert new lines to &lt;br/> tags (HTML only)' , 'regplus');?></label></td>
                       	</tr>
                        </tbody>
                     </table>
                     </div><br />
                     <h3><?php _e('Custom CSS for Register & Login Pages', 'regplus');?></h3>
                     <p><?php _e('CSS Rule Example:', 'regplus');?>
<code>
#user_login{
	font-size: 20px;	
	width: 97%;
	padding: 3px;
	margin-right: 6px;
}</code>
                     <table class="form-table">
                        <tbody>
                        <tr valign="top">
                       		<th scope="row"><label for="register_css"><?php _e('Custom Register CSS', 'regplus');?></label></th>
                        	<td><textarea name="regplus_register_css" id="register_css" rows="20" cols="40" style="width:80%; height:200px;"><?php echo $regplus['register_css'];?></textarea></td>
                        </tr>
                        <tr valign="top">
                       		<th scope="row"><label for="login_css"><?php _e('Custom Login CSS', 'regplus');?></label></th>
                        	<td><textarea name="regplus_login_css" id="login_css" rows="20" cols="40" style="width:80%; height:200px;"><?php echo $regplus['login_css'];?></textarea></td>
                        </tr>
                        </tbody>
                     </table>
                     
                    <p class="submit"><input name="Submit" value="<?php _e('Save Changes','regplus');?>" type="submit" />
                    <input name="action" value="reg_plus_update" type="hidden" />
                </form>
              	<?php $this->donate();?>
            </div>
           <?php
		}
		
		# Check Required Fields
		function RegErrors($errors){	
			$regplus = get_option( 'register_plus' );
			$regplus_custom = get_option( 'register_plus_custom' );
			if( !is_array( $regplus_custom ) ) $regplus_custom = array();
			
			if( $regplus['email_exists'] ){
				if ( $errors->errors['email_exists'] ){
					unset($errors->errors['email_exists']);
				}
			}
			
			if( $regplus['firstname'] && in_array('firstname', $regplus['profile_req']) ){
				if(empty($_POST['firstname']) || $_POST['firstname'] == ''){
					$errors->add('empty_firstname', __('<strong>ERROR</strong>: Please enter your First Name.', 'regplus'));
				}
			}
			if( $regplus['lastname'] && in_array('lastname', $regplus['profile_req']) ){
				if(empty($_POST['lastname']) || $_POST['lastname'] == ''){
					$errors->add('empty_lastname', __('<strong>ERROR</strong>: Please enter your Last Name.', 'regplus'));
				}
			}
			if( $regplus['website'] && in_array('website', $regplus['profile_req']) ){
				if(empty($_POST['website']) || $_POST['website'] == ''){
					$errors->add('empty_website', __('<strong>ERROR</strong>: Please enter your Website URL.', 'regplus'));
				}
			}
			if( $regplus['aim'] && in_array('aim', $regplus['profile_req']) ){
				if(empty($_POST['aim']) || $_POST['aim'] == ''){
					$errors->add('empty_aim', __('<strong>ERROR</strong>: Please enter your AIM username.', 'regplus'));
				}
			}
			if( $regplus['yahoo'] && in_array('yahoo', $regplus['profile_req']) ){
				if(empty($_POST['yahoo']) || $_POST['yahoo'] == ''){
					$errors->add('empty_yahoo', __('<strong>ERROR</strong>: Please enter your Yahoo IM username.', 'regplus'));
				}
			}
			if( $regplus['jabber'] && in_array('jabber', $regplus['profile_req']) ){
				if(empty($_POST['jabber']) || $_POST['jabber'] == ''){
					$errors->add('empty_jabber', __('<strong>ERROR</strong>: Please enter your Jabber / Google Talk username.', 'regplus'));
				}
			}
			if( $regplus['about'] && in_array('about', $regplus['profile_req']) ){
				if(empty($_POST['about']) || $_POST['about'] == ''){
					$errors->add('empty_about', __('<strong>ERROR</strong>: Please enter some information About Yourself.', 'regplus'));
				}
			}
			if (!empty($regplus_custom)) {
				foreach( $regplus_custom as $k=>$v ){
					if( $v['required'] && $v['reg'] ){
						$id = $this->Label_ID($v['label']);
						if(empty($_POST[$id]) || $_POST[$id] == ''){
							$errors->add('empty_' . $id, __('<strong>ERROR</strong>: Please enter your ' . $v['label'] . '.', 'regplus'));
						}
					}
				}
			}
					
			if ( $regplus['password'] ){
				if(empty($_POST['pass1']) || $_POST['pass1'] == '' || empty($_POST['pass2']) || $_POST['pass2'] == ''){
					$errors->add('empty_password', __('<strong>ERROR</strong>: Please enter a Password.', 'regplus'));
				}elseif($_POST['pass1'] !== $_POST['pass2']){
					$errors->add('password_mismatch', __('<strong>ERROR</strong>: Your Password does not match.', 'regplus'));
				}elseif(strlen($_POST['pass1'])<6){
					$errors->add('password_length', __('<strong>ERROR</strong>: Your Password must be at least 6 characters in length.', 'regplus'));
				}else{
					$_POST['user_pw'] = $_POST['pass1'];
				}
			}
			if ( $regplus['code'] && $regplus['code_req'] ){
				if(empty($_POST['regcode']) || $_POST['regcode'] == ''){
					$errors->add('empty_regcode', __('<strong>ERROR</strong>: Please enter the Invitation Code.', 'regplus'));
				}elseif( !in_array(strtolower($_POST['regcode']), $regplus['codepass']) ){
					$errors->add('regcode_mismatch', __('<strong>ERROR</strong>: Your Invitation Code is incorrect.', 'regplus'));
				}
			}
			
			if ( $regplus['captcha'] == 1 ){
				
				$key = $_SESSION['1k2j48djh'];
				$number = md5($_POST['captcha']);
				if($number!=$key){
				  	$errors->add('captcha_mismatch', __("<strong>ERROR</strong>: Image Validation does not match.", 'regplus'));
					unset($_SESSION['1k2j48djh']);
				}	
			} else if ( $regplus['captcha'] == 2){
				require_once('recaptchalib.php');
				$privatekey = $regplus['reCAP_private_key'];
				$resp = rp_recaptcha_check_answer ($privatekey,

												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);
				
				if (!$resp->is_valid) {
				  $errors->add('recaptcha_mismatch', __("<strong>ERROR:</strong> The reCAPTCHA wasn't entered correctly.", 'regplus'));
				  //$errors->add('recaptcha_error', "(" . __("reCAPTCHA said: ", 'regplus') . $resp->error . ")");
				}
			}
			
			if ( $regplus['disclaimer'] ){
				if(!$_POST['disclaimer']){
				  	$errors->add('disclaimer', __('<strong>ERROR</strong>: Please accept the ', 'regplus') . stripslashes( $regplus['disclaimer_title'] ) . '.');
				}	
			}
			if ( $regplus['license'] ){
				if(!$_POST['license']){
				  	$errors->add('license', __('<strong>ERROR</strong>: Please accept the ', 'regplus') . stripslashes( $regplus['license_title'] ) . '.');
				}	
			}
			if ( $regplus['privacy'] ){
				if(!$_POST['privacy']){
				  	$errors->add('privacy', __('<strong>ERROR</strong>: Please accept the ', 'regplus') . stripslashes( $regplus['privacy_title'] ) . '.');
				}	
			}
			
			return $errors;
		}	
		
		function RegMsg($errors){
			$regplus = get_option( 'register_plus' );
			session_start();
			if ( $errors->errors['registered'] ){
				//unset($errors->errors['registered']);
			}
			if	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )	$errors->add('registeredit', __('Please check your e-mail and click the verification link to activate your account and complete your registration.'), 'message');
			return $errors;
		}
		
		# Add Fields to Register Form
		function RegForm(){
			$regplus = get_option( 'register_plus' );
			$regplus_custom = get_option( 'register_plus_custom' );
			if( !is_array( $regplus_custom ) ) $regplus_custom = array();
			
			if ( $regplus['firstname'] ){	
				if( isset( $_GET['firstname'] ) ) $_POST['firstname'] = $_GET['firstname'];
			?>
   		<p><label><?php _e('First Name:', 'regplus');?> <br />
		<input autocomplete="off" name="firstname" id="firstname" size="25" value="<?php echo $_POST['firstname'];?>" type="text" tabindex="30" /></label><br />
        </p>
            <?php
			}
			if ( $regplus['lastname'] ){
				if( isset( $_GET['lastname'] ) ) $_POST['lastname'] = $_GET['lastname'];
			?>
   		<p><label><?php _e('Last Name:', 'regplus');?> <br />
		<input autocomplete="off" name="lastname" id="lastname" size="25" value="<?php echo $_POST['lastname'];?>" type="text" tabindex="31" /></label><br />
        </p>
            <?php
			}
			if ( $regplus['website'] ){
				if( isset( $_GET['website'] ) ) $_POST['website'] = $_GET['website'];
			?>
   		<p><label><?php _e('Website:', 'regplus');?> <br />
		<input autocomplete="off" name="website" id="website" size="25" value="<?php echo $_POST['website'];?>" type="text" tabindex="32" /></label><br />
        </p>
            <?php
			}
			if ( $regplus['aim'] ){
				if( isset( $_GET['aim'] ) ) $_POST['aim'] = $_GET['aim'];
			?>
   		<p><label><?php _e('AIM:', 'regplus');?> <br />
		<input autocomplete="off" name="aim" id="aim" size="25" value="<?php echo $_POST['aim'];?>" type="text" tabindex="32" /></label><br />
        </p>
            <?php
			}
			if ( $regplus['yahoo'] ){
				if( isset( $_GET['yahoo'] ) ) $_POST['yahoo'] = $_GET['yahoo'];
			?>
   		<p><label><?php _e('Yahoo IM:', 'regplus');?> <br />
		<input autocomplete="off" name="yahoo" id="yahoo" size="25" value="<?php echo $_POST['yahoo'];?>" type="text" tabindex="33" /></label><br />
        </p>
            <?php
			}
			if ( $regplus['jabber'] ){
				if( isset( $_GET['jabber'] ) ) $_POST['jabber'] = $_GET['jabber'];
			?>
   		<p><label><?php _e('Jabber / Google Talk:', 'regplus');?> <br />
		<input autocomplete="off" name="jabber" id="jabber" size="25" value="<?php echo $_POST['jabber'];?>" type="text" tabindex="34" /></label><br />
        </p>
            <?php
			}
			if ( $regplus['about'] ){
				if( isset( $_GET['about'] ) ) $_POST['about'] = $_GET['about'];
			?>
   		<p><label><?php _e('About Yourself:', 'regplus');?> <br />
		<textarea autocomplete="off" name="about" id="about" cols="25" rows="5" tabindex="35"><?php echo stripslashes($_POST['about']);?></textarea></label><br />
        <small><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.', 'regplus');?></small>
        </p>
            <?php
			}
			
			foreach( $regplus_custom as $k=>$v){
				if( $v['reg'] ){
				$id = $this->Label_ID($v['label']);
				if( isset( $_GET[$id] ) ) $_POST[$id] = $_GET[$id];
			 ?>
		
       
        <?php if( $v['fieldtype'] == 'text' ){ ?>
        <p><label><?php echo $v['label'];?>: <br />
		<input autocomplete="off" class="custom_field" tabindex="36" name="<?php echo $id;?>" id="<?php echo $id;?>" size="25" value="<?php echo $_POST[$id];?>" type="text" /></label><br /></p>
        
        <?php } else if( $v['fieldtype'] == 'date' ){ ?>
        <p><label><?php echo $v['label'];?>: <br />
		<input autocomplete="off" class="custom_field date-pick" tabindex="36" name="<?php echo $id;?>" id="<?php echo $id;?>" size="25" value="<?php echo $_POST[$id];?>" type="text" /></label><br /></p>
        
		<?php } else if( $v['fieldtype'] == 'select' ){ 
			$ops = explode(',',$v['extraoptions']);
				$options='';
			foreach( $ops as $op ){
				$options .= '<option value="'.$op.'" ';
				if( $_POST[$id] == $op ) $options .= 'selected="selected"';
				$options .= '>' . $op . '</option>';
			}
		?>
        <p><label><?php echo $v['label'];?>: <br />
        <select class="custom_select" tabindex="36" name="<?php echo $id;?>" id="<?php echo $id;?>">
        	<?php echo $options;?>
        </select></label><br /></p>
      
        <?php } else if( $v['fieldtype'] == 'checkbox' ){ 
				$ops = explode(',',$v['extraoptions']);
				$check='';
				foreach( $ops as $op ){
					$check .= '<label><input type="checkbox" class="custom_checkbox" tabindex="36" name="'.$id.'[]" id="'.$id.'" ';
					//if( in_array($op, $_POST[$id]) ) $check .= 'checked="checked" ';
					$check .= 'value="'.$op.'" /> '.$op.'</label> ';
				}
				?>
                <p><label><?php echo $v['label'];?>:</label> <br /><?php
				echo $check . '<br /></p>';
			
			} else if( $v['fieldtype'] == 'radio' ){
				$ops = explode(',',$v['extraoptions']);
				$radio = '';
				foreach( $ops as $op ){
					$radio .= '<label><input type="radio" class="custom_radio" tabindex="36" name="'.$id.'" id="'.$id.'" ';
					//if( in_array($op, $_POST[$id]) ) $radio .= 'checked="checked" ';
					$radio .= 'value="'.$op.'" /> '.$op.'</label> ';
				}
				?>
                <p><label><?php echo $v['label'];?>:</label> <br /><?php
				echo $radio . '<br /></p>';
				
			} else if( $v['fieldtype'] == 'textarea' ){ ?>
            <p><label><?php echo $v['label'];?>: <br />
		<textarea tabindex="36" name="<?php echo $id;?>" cols="25" rows="5" id="<?php echo $id;?>" class="custom_textarea"><?php echo $_POST[$id];?></textarea></label><br /></p>
		
		<?php } else if( $v['fieldtype'] == 'hidden' ){ ?>
		<input class="custom_field" tabindex="36" name="<?php echo $id;?>" value="<?php echo $_POST[$id];?>" type="hidden" />  	        	
        <?php } ?>		
				
		<?php	}
        	}			
			
			
			if ( $regplus['password'] ){
			?>
        <p><label><?php _e('Password:', 'regplus');?> <br />
		<input autocomplete="off" name="pass1" id="pass1" size="25" value="<?php echo $_POST['pass1'];?>" type="password" tabindex="40" /></label><br />
        <label><?php _e('Confirm Password:', 'regplus');?> <br />
        <input autocomplete="off" name="pass2" id="pass2" size="25" value="<?php echo $_POST['pass2'];?>" type="password" tabindex="41" /></label>
        <?php if( $regplus['password_meter'] ){ ?><br />
        <span id="pass-strength-result"><?php echo $regplus['short'];?></span>
		<small><?php _e('Hint: Use upper and lower case characters, numbers and symbols like !"?$%^&amp;( in your password.', 'regplus'); ?> </small><?php } ?></p>
            <?php
			}
			if ( $regplus['code'] ){
				if( isset( $_GET['regcode'] ) ) $_POST['regcode'] = $_GET['regcode'];
			?>
        <p><label><?php _e('Invitation Code:', 'regplus');?> <br />
		<input name="regcode" id="regcode" size="25" value="<?php echo $_POST['regcode'];?>" type="text" tabindex="45" /></label><br />
        <?php if ($regplus['code_req']) {?>
		<small><?php _e('This website is currently closed to public registrations.  You will need an invitation code to register.', 'regplus');?></small>
        <?php }else{ ?>
        <small><?php _e('Have an invitation code? Enter it here. (This is not required)', 'regplus');?></small>
        <?php } ?>
        </p>
            <?php
			}
			
			if ( $regplus['disclaimer'] ){
			?>
   		<p><label><?php echo stripslashes( $regplus['disclaimer_title'] );?> <br />
        <span id="disclaimer"><?php echo stripslashes($regplus['disclaimer_content']); ?></span>
		<input name="disclaimer" value="1" type="checkbox" tabindex="50"<?php if($_POST['disclaimer']) echo ' checked="checked"';?> /> <?php echo $regplus['disclaimer_agree'];?></label></p>
            <?php
			}
			if ( $regplus['license'] ){
			?>
   		<p><label><?php echo stripslashes( $regplus['license_title'] );?> <br />
        <span id="license"><?php echo stripslashes($regplus['license_content']); ?></span>
		<input name="license" value="1" type="checkbox" tabindex="50"<?php if($_POST['license']) echo ' checked="checked"';?> /> <?php echo $regplus['license_agree'];?></label></p>
            <?php
			}
			if ( $regplus['privacy'] ){
			?>
   		<p><label><?php echo stripslashes( $regplus['privacy_title'] );?> <br />
        <span id="privacy"><?php echo stripslashes($regplus['privacy_content']); ?></span>
		<input name="privacy" value="1" type="checkbox" tabindex="50"<?php if($_POST['privacy']) echo ' checked="checked"';?> /> <?php echo $regplus['privacy_agree'];?></label></p>
            <?php
			}
			
			if ( $regplus['captcha'] == 1 ){
				$plugin_url = trailingslashit(get_option('siteurl')) . 'wp-content/plugins/' . basename(dirname(__FILE__)) .'/';
				$_SESSION['OK'] = 1;
				if( !isset( $_SESSION['OK'] ) )
					session_start(); 
				?>
                <p><label><?php _e('Validation Image:', 'regplus');?> <br />
                <img src="<?php echo $plugin_url;?>captcha.php" id="captchaimg" alt="" />
                <input type="text" name="captcha" id="captcha" size="25" value="" tabindex="55" /></label><br />
                <small><?php _e('Enter the text from the image.', 'regplus');?></small>
                </p>
                <?php
				//}
			} else if ( $regplus['captcha'] == 2 && $regplus['reCAP_public_key'] && $regplus['reCAP_private_key'] ){
				require_once('recaptchalib.php');
				$publickey = $regplus['reCAP_public_key'];
				echo '<div id="reCAPTCHA">';
				echo rp_recaptcha_get_html($publickey);
				echo '</div>&nbsp;<br />';
			}
			
		}
		
		function Label_ID($label){
			$id = str_replace(' ', '_', $label);
			$id = strtolower($id);
			$id = sanitize_user($id, true);
			return $id;
		}
		# Add Javascript & CSS needed
		function PassHead(){
			$regplus = get_option( 'register_plus' );
			if( isset( $_GET['user_login'] ) ) $user_login = $_GET['user_login'];
			if( isset( $_GET['user_email'] ) ) $user_email = $_GET['user_email'];
			if ( $regplus['password'] ){
?>
<script type='text/javascript' src='<?php trailingslashit(get_option('siteurl'));?>wp-includes/js/jquery/jquery.js?ver=1.2.3'></script>

<script type='text/javascript' src='<?php trailingslashit(get_option('siteurl'));?>wp-admin/js/common.js?ver=20080318'></script>
<script type='text/javascript' src='<?php trailingslashit(get_option('siteurl'));?>wp-includes/js/jquery/jquery.color.js?ver=2.0-4561'></script>
<script type='text/javascript'>
/* <![CDATA[ */
	pwsL10n = {
		short: "<?php echo $regplus['short'];?>",
		bad: "<?php echo $regplus['bad'];?>",
		good: "<?php echo $regplus['good'];?>",
		strong: "<?php echo $regplus['strong'];?>"
	}
/* ]]> */
</script>
<script type='text/javascript' src='<?php trailingslashit(get_option('siteurl'));?>wp-admin/js/password-strength-meter.js?ver=20070405'></script>
<script type="text/javascript">
	function check_pass_strength ( ) {

		var pass = jQuery('#pass1').val();
		var user = jQuery('#user_login').val();

		// get the result as an object, i'm tired of typing it
		var res = jQuery('#pass-strength-result');

		var strength = passwordStrength(pass, user);

		jQuery(res).removeClass('short bad good strong');

		if ( strength == pwsL10n.bad ) {
			jQuery(res).addClass('bad');
			jQuery(res).html( pwsL10n.bad );
		}
		else if ( strength == pwsL10n.good ) {
			jQuery(res).addClass('good');
			jQuery(res).html( pwsL10n.good );
		}
		else if ( strength == pwsL10n.strong ) {
			jQuery(res).addClass('strong');
			jQuery(res).html( pwsL10n.strong );
		}
		else {
			// this catches 'Too short' and the off chance anything else comes along
			jQuery(res).addClass('short');
			jQuery(res).html( pwsL10n.short );
		}

	}
	

	jQuery(function($) { 
		$('#pass1').keyup( check_pass_strength ) 
		$('.color-palette').click(function(){$(this).siblings('input[name=admin_color]').attr('checked', 'checked')});
	} );
	
	jQuery(document).ready( function() {
		jQuery('#pass1,#pass2').attr('autocomplete','off');
		jQuery('#user_login').val('<?php echo $user_login; ?>');
		jQuery('#user_email').val('<?php echo $user_email; ?>');
    });
</script>
<?php } ?>

<?php $plugin_url = trailingslashit(get_option('siteurl')) . 'wp-content/plugins/' . basename(dirname(__FILE__)) .'/'; ?>
<!-- required plugins -->
<script type="text/javascript" src="<?php echo $plugin_url;?>datepicker/date.js"></script>
<!--[if IE]><script type="text/javascript" src="<?php echo $plugin_url;?>datepicker/jquery.bgiframe.js"></script><![endif]-->

<!-- jquery.datePicker.js -->
<script type="text/javascript" src="<?php echo $plugin_url;?>datepicker/jquery.datePicker.js"></script>
<link href="<?php echo $plugin_url;?>datepicker/datePicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
jQuery.dpText = {
	TEXT_PREV_YEAR		:	'<?php _e('Previous year','regplus');?>',
	TEXT_PREV_MONTH		:	'<?php _e('Previous month','regplus');?>',
	TEXT_NEXT_YEAR		:	'<?php _e('Next year','regplus');?>',
	TEXT_NEXT_MONTH		:	'<?php _e('Next Month','regplus');?>',
	TEXT_CLOSE			:	'<?php _e('Close','regplus');?>',
	TEXT_CHOOSE_DATE	:	'<?php _e('Choose Date','regplus');?>'
}

Date.dayNames = ['<?php _e('Monday','regplus');?>', '<?php _e('Tuesday','regplus');?>', '<?php _e('Wednesday','regplus');?>', '<?php _e('Thursday','regplus');?>', '<?php _e('Friday','regplus');?>', '<?php _e('Saturday','regplus');?>', '<?php _e('Sunday','regplus');?>'];
Date.abbrDayNames = ['<?php _e('Mon','regplus');?>', '<?php _e('Tue','regplus');?>', '<?php _e('Wed','regplus');?>', '<?php _e('Thu','regplus');?>', '<?php _e('Fri','regplus');?>', '<?php _e('Sat','regplus');?>', '<?php _e('Sun','regplus');?>'];
Date.monthNames = ['<?php _e('January','regplus');?>', '<?php _e('February','regplus');?>', '<?php _e('March','regplus');?>', '<?php _e('April','regplus');?>', '<?php _e('May','regplus');?>', '<?php _e('June','regplus');?>', '<?php _e('July','regplus');?>', '<?php _e('August','regplus');?>', '<?php _e('September','regplus');?>', '<?php _e('October','regplus');?>', '<?php _e('November','regplus');?>', '<?php _e('December','regplus');?>'];
Date.abbrMonthNames = ['<?php _e('Jan','regplus');?>', '<?php _e('Feb','regplus');?>', '<?php _e('Mar','regplus');?>', '<?php _e('Apr','regplus');?>', '<?php _e('May','regplus');?>', '<?php _e('Jun','regplus');?>', '<?php _e('Jul','regplus');?>', '<?php _e('Aug','regplus');?>', '<?php _e('Sep','regplus');?>', '<?php _e('Oct','regplus');?>', '<?php _e('Nov','regplus');?>', '<?php _e('Dec','regplus');?>'];
Date.firstDayOfWeek = <?php echo $regplus['firstday'];?>; 
Date.format = '<?php echo $regplus['dateformat'];?>'; 
jQuery(function() { 
	jQuery('.date-pick').datePicker({
		clickInput:true,
		startDate:'<?php echo $regplus['startdate'];?>',
		year:<?php echo $regplus['calyear'];?>,
		month:<?php if( $regplus['calmonth'] != 'cur' ) echo $regplus['calmonth']; else echo date('n')-1;?>
	}) 
});
</script>
<style type="text/css">
a.dp-choose-date { float: left; width: 16px; height: 16px; padding: 0; margin: 5px 3px 0; display: block; text-indent: -2000px; overflow: hidden; background: url(<?php echo $plugin_url;?>datepicker/calendar.png) no-repeat; } a.dp-choose-date.dp-disabled { background-position: 0 -20px; cursor: default; } /* makes the input field shorter once the date picker code * has run (to allow space for the calendar icon */ input.dp-applied { width: 140px; float: left; }
																																																																																				
#pass1, #pass2, #regcode, #captcha, #firstname, #lastname, #website, #aim, #yahoo, #jabber, #about, .custom_field{
	font-size: 20px;	
	width: 97%;
	padding: 3px;
	margin-right: 6px;
}
.custom_select, .custom_textarea{	
	width: 97%;
	padding: 3px;
	margin-right: 6px;
}
#about, .custom_textarea{
	height: 60px;
}
#disclaimer, #license, #privacy{
	display:block;
	width: 97%;
	padding: 3px;
	background-color:#fff;
	border:solid 1px #A7A6AA;
	font-weight:normal;
}
<?php 
$regplus_custom = get_option( 'register_plus_custom' );
$custom = array();
if (!empty($regplus_custom)) {
	foreach( $regplus_custom as $k=>$v ){
		if( $v['required'] && $v['reg'] ){
			$custom[] = ', #' . $this->Label_ID($v['label']);		
		}		
	}
}

if( $regplus['profile_req'][0] ) $profile_req = ', #' . implode(', #', $regplus['profile_req']);
if( $custom[0] )$profile_req .= implode('', $custom);
?>
#user_login, #user_email, #pass1, #pass2 <?php echo $profile_req;?>{

	<?php echo $regplus['require_style'];?>
	
}
<?php if( strlen($regplus['disclaimer_content']) > 525){ ?>
#disclaimer{
	height: 200px;
	overflow:scroll;
}
<?php } ?>
<?php  if( strlen($regplus['license_content']) > 525){ ?>
#license{
	height: 200px;
	overflow:scroll;
}
<?php } ?>
<?php if( strlen($regplus['privacy_content']) > 525){ ?>
#privacy{
	height: 200px;
	overflow:scroll;
}
<?php } ?>
#captcha {
	width: 156px;
}
#captchaimg{
	float:left;
}
#reg_passmail{
	display:none;
}
small{
	font-weight:normal;
}
#pass-strength-result{
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	padding-left: 5px;
	margin-top: 3px;
	text-align: center;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	display:block;
}
#reCAPTCHA{
	position:relative;
	margin-left:-32px;
}


</style>
		<?php
		}
		
		function HideLogin(){
			$regplus = get_option( 'register_plus' );
			if( ($regplus['admin_verify'] || $regplus['email_verify'] ) && $_GET['checkemail'] == 'registered' ){
			?>
<style type="text/css">
label, #user_login, #user_pass, .forgetmenot, #wp-submit, .message {
	display:none;
}
</style>
		<?php
			}
			
		}
		
		function LogoHead(){
			$regplus = get_option( 'register_plus' );
			if( $regplus['logo'] ){ 
				$logo = str_replace( trailingslashit( get_option('siteurl') ), ABSPATH, $regplus['logo'] );
				list($width, $height, $type, $attr) = getimagesize($logo);
				?>
                <?php if( $_GET['action'] != 'register' ) : ?>
                <script type='text/javascript' src='<?php trailingslashit(get_option('siteurl'));?>wp-includes/js/jquery/jquery.js?ver=1.2.3'></script>
                <?php endif; ?>
<script type="text/javascript">
	jQuery(document).ready( function() {
		jQuery('#login h1 a').attr('href', '<?php echo get_option('home'); ?>');
		jQuery('#login h1 a').attr('title', '<?php echo get_option('blogname') . ' - ' . get_option('blogdescription'); ?>');
    });
</script>
<style type="text/css">
#login h1 a {
	background-image: url(<?php echo $regplus['logo'];?>);
	background-position:center top;
	width: <?php echo $width; ?>px;
	min-width:292px;
	height: <?php echo $height; ?>px;
}
<?php if( $regplus['register_css'] &&  $_GET['action'] == 'register') echo $regplus['register_css']; 
else if( $regplus['login_css'] ) echo $regplus['login_css']; ?>
</style>
		<?php } 
		
		}
		
		function Add2Profile() {
			global $user_ID;
			get_currentuserinfo();
			if( $_GET['user_id'] ) $user_ID = $_GET['user_id'];
			$regplus_custom = get_option( 'register_plus_custom' );
			if( !is_array( $regplus_custom ) ) $regplus_custom = array();
			if( count($regplus_custom) > 0){
				$top = '<h3>' . __('Additional Information', 'regplus') . '</h3><table class="form-table"><tbody>';
				$bottom = '</tbody></table>';
			}
			echo $top;
			if (!empty($regplus_custom)) {
				foreach( $regplus_custom as $k=>$v ){
					if( $v['profile'] ){
						$id = $this->Label_ID($v['label']);
						$value = get_usermeta( $user_ID, $id );
						$extraops = explode(',', $v['extraoptions']);
						switch( $v['fieldtype'] ){
							case "text" :
								$outfield = '<input type="text" name="' . $id . '" id="' . $id . '" value="' . $value . '"  />';
								break;
							case "hidden" :
								$outfield = '<input type="text" disabled="disabled" name="' . $id . '" id="' . $id . '" value="' . $value . '"  />';
								break;
							case "select" :
								$outfield = '<select name="' . $id . '" id="' . $id . '">';
								foreach( $extraops as $op ){
									$outfield .= '<option value="' . $op . '"';
									if( $value == $op ) $outfield .= ' selected="selected"';
									$outfield .= '>' . $op . '</option>';
								}
								$outfield .= '</select>';
								break;
							case "textarea" :
								$outfield = '<textarea name="' . $id . '" id="' . $id . '" cols="25" rows="10">' . stripslashes($value) . '</textarea>';
								break;
							case "checkbox" :
								$outfield = '';
								$valarr = explode(', ', $value);
								foreach( $extraops as $op ){
									$outfield .= '<label><input type="checkbox" name="' . $id . '[]" value="' . $op . '"';
									if( in_array($op, $valarr) ) $outfield .= ' checked="checked"';
									$outfield .= ' /> ' . $op . '</label> &nbsp; ';
								}
								break;
							case "radio" :
								$outfield = '';
								foreach( $extraops as $op ){
									$outfield .= '<label><input type="radio" name="' . $id . '" value="' . $op . '"';
									if( $value == $op ) $outfield .= ' checked="checked"';
									$outfield .= ' /> ' . $op . '</label> &nbsp; ';
								}
								break;
						}
						?>		
						<tr>
							<th><label for="<?php echo $id;?>"><?php echo $v['label'];?>:</label></th>
							<td><?php echo $outfield; ?></td>
						</tr>      
					<?php 
					
					}		
				}
			}
			echo $bottom;
		}
		function SaveProfile(){
			global $wpdb, $user_ID;
			get_currentuserinfo();
			if( $_GET['user_id'] ) $user_ID = $_GET['user_id'];
			$regplus_custom = get_option( 'register_plus_custom' );
			if( !is_array( $regplus_custom ) ) $regplus_custom = array();
			if (!empty($regplus_custom)) {
				foreach( $regplus_custom as $k=>$v ){
					if( $v['profile'] ){
						$key = $this->Label_ID($v['label']);
						if( is_array($_POST[$key]) ) $_POST[$key] = implode(', ', $_POST[$key]);
						$value = $wpdb->prepare($_POST[$key]);
						update_usermeta($user_ID ,$key ,$value);
					}
				}
			}
		}
		function RanPass($len=7) {
			$chars = "0123456789abcdefghijkl0123456789mnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQ0123456789RSTUVWXYZ0123456789";
			srand((double)microtime()*1000000);
			$i = 0;		
			$pass = '' ;		
			while ($i <= $len) {
				$num = rand() % 33;
				$tmp = substr($chars, $num, 1);	
				$pass = $pass . $tmp;		
				$i++;
			}
			return $pass;
		}
		
		function ValidateUser(){
			global $wpdb;
			$regplus = get_option( 'register_plus' );
			if( $regplus['admin_verify'] && isset( $_GET['checkemail'] ) ){
				echo '<p style="text-align:center;">' . __('Your account will be reviewed by an administrator and you will be notified when it is activated.', 'regplus') . '</p>';
			}else if( $regplus['email_verify'] && isset( $_GET['checkemail'] ) ){
				echo '<p style="text-align:center;">' . __('Please activate your account using the verification link sent to your email address.', 'regplus') . '</p>';
			}
			if( $regplus['email_verify'] && isset( $_GET['regplus_verification'] ) ){
				$regplus = get_option( 'register_plus' );
				$verify_key = $_GET['regplus_verification'];
				$user_id = $wpdb->get_var( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'email_verify' AND meta_value='$verify_key'");
				if ( $user_id ) {
					$login = get_usermeta($user_id, 'email_verify_user');
					$wpdb->query( "UPDATE $wpdb->users SET user_login = '$login' WHERE ID = '$user_id'" );
					delete_usermeta($user_id, 'email_verify_user');
					delete_usermeta($user_id, 'email_verify');
					delete_usermeta($user_id, 'email_verify_date');
					
					$msg = '<p>' . sprintf(__('Thank you %s, your account has been verified, please login.', 'regplus'), $login ) . '</p>';
					echo $msg;
				}
			}
		}
		
		function adminfrom(){
			$regplus = get_option( 'register_plus' );
			return $regplus['adminfrom'];
		}
		
		function userfrom(){
			$regplus = get_option( 'register_plus' );
			return $regplus['from'];
		}
		
		function adminfromname(){
			$regplus = get_option( 'register_plus' );
			return $regplus['adminfromname'];
		}
		
		function userfromname(){
			$regplus = get_option( 'register_plus' );
			return $regplus['fromname'];
		}
		
		function DeleteInvalidUsers(){
			global $wpdb;
			$regplus = get_option( 'register_plus' );
			$grace = $regplus['email_delete_grace'];
			$unverified = $wpdb->get_results( "SELECT user_id, meta_value FROM $wpdb->usermeta WHERE meta_key='email_verify_date'" );
			$grace_date = date('Ymd', strtotime("-7 days"));
			if( $unverified ){
				foreach( $unverified as $bad ){
					if( $grace_date > $bad->meta_value ){
						include_once( ABSPATH . 'wp-admin/includes/user.php' );
						wp_delete_user($bad->user_id);
					}
				}
			}
		}
		
		function override_warning(){
			if( current_user_can(10) &&  $_GET['page'] == 'register-plus' )
			echo "<div id='regplus-warning' class='updated fade-ff0000'><p><strong>".__('You have another plugin installed that is conflicting with Register Plus.  This other plugin is overriding the user notification emails.  Please see <a href="http://skullbit.com/news/register-plus-conflicts/">Register Plus Conflicts</a> for more information.', 'regplus') . "</strong></p></div>";
		}
		
		function donate(){
			echo '<p><strong>' . __('If you find this plugin useful, please consider ', 'regplus') . '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40skullbit%2ecom&item_name=Skullbit%2ecom%20Plugin%20Development&no_shipping=0&no_note=1&tax=0&currency_code=CAD&lc=CA&bn=PP%2dDonationsBF&charset=UTF%2d8">'  . __('donating', 'regplus') . '</a></strong></p>';
		}
	}
}# END Class RegisterPlusPlugin

# Run The Plugin!
if( class_exists('RegisterPlusPlugin') ){
	$register_plus = new RegisterPlusPlugin();
}
if ( function_exists('wp_new_user_notification') )
	add_action('admin_notices', array($register_plus, 'override_warning'));
	
# Override set user password and send email to User #
if ( !function_exists('wp_new_user_notification') ) :
function wp_new_user_notification($user_id, $plaintext_pass = '') {
	$user = new WP_User($user_id);	
	
	#-- REGPLUS --#
	global $wpdb, $register_plus;
	$regplus = get_option( 'register_plus' );
	$regplus_custom = get_option( 'register_plus_custom' );
	$ref = explode( '?', $_SERVER['HTTP_REFERER']);
	$ref = $ref[0];
	$admin = trailingslashit( get_option('siteurl') ) . 'wp-admin/users.php';
	if( !is_array( $regplus_custom ) ) $regplus_custom = array();
	if( $regplus['password'] && $_POST['user_pw'] )
		$plaintext_pass = $wpdb->prepare($_POST['user_pw']);
	else if( $ref == $admin && $_POST['pass1'] == $_POST['pass2'] )
		$plaintext_pass = $wpdb->prepare($_POST['pass1']);
	else
		$plaintext_pass = $register_plus->RanPass(6);
	if( $regplus['firstname'] && $_POST['firstname'] )	
		update_usermeta( $user_id, 'first_name', $wpdb->prepare($_POST['firstname']));
	if( $regplus['lastname'] && $_POST['lastname'] )	
		update_usermeta( $user_id, 'last_name', $wpdb->prepare($_POST['lastname']));
	if( $regplus['website'] && $_POST['website'] )	
		update_usermeta( $user_id, 'user_url', $wpdb->prepare($_POST['website']));
	if( $regplus['aim'] && $_POST['aim'] )	
		update_usermeta( $user_id, 'aim', $wpdb->prepare($_POST['aim']));
	if( $regplus['yahoo'] && $_POST['yahoo'] )	
		update_usermeta( $user_id, 'yim', $wpdb->prepare($_POST['yahoo']));
	if( $regplus['jabber'] && $_POST['jabber'] )	
		update_usermeta( $user_id, 'jabber', $wpdb->prepare($_POST['jabber']));
	if( $regplus['about'] && $_POST['about'] )	
		update_usermeta( $user_id, 'description', $wpdb->prepare($_POST['about']));
	if( $regplus['code'] && $_POST['regcode'] )	
		update_usermeta( $user_id, 'invite_code', $wpdb->prepare($_POST['regcode']));
	if( $ref != $admin && $regplus['admin_verify'] ){
		update_usermeta( $user_id, 'admin_verify_user', $user->user_login );
		$temp_id = 'unverified__' . $register_plus->RanPass(7);
		$notice = __('Your account requires activation by an administrator before you will be able to login.', 'regplus') . "\r\n";
	}else if( $ref != $admin && $regplus['email_verify'] ){
		$code = $register_plus->RanPass(25);
		update_usermeta( $user_id, 'email_verify', $code );
		update_usermeta( $user_id, 'email_verify_date', date('Ymd') );
		update_usermeta( $user_id, 'email_verify_user', $user->user_login );
		$email_code = '?regplus_verification=' . $code;
		$prelink = __('Verification URL: ', 'regplus');
		$notice = __('Please use the link above to verify and activate your account', 'regplus') . "\r\n";
		$temp_id = 'unverified__' . $register_plus->RanPass(7);
	}
	if (!empty($regplus_custom)) {
		foreach( $regplus_custom as $k=>$v ){
			$id = $register_plus->Label_ID($v['label']);
			if( $v['reg'] && $_POST[$id] ){
				if( is_array( $_POST[$id] ) ) $_POST[$id] = implode(', ', $_POST[$id]);
				update_usermeta( $user_id, $id, $wpdb->prepare($_POST[$id]));
			}
		}
	}
	#-- END REGPLUS --#
	
	wp_set_password($plaintext_pass, $user_id);
	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	#-- REGPLUS --#
	if( !$regplus['custom_adminmsg'] && !$regplus['disable_admin'] ){
	#-- END REGPLUS --#
	
	$message  = sprintf(__('New user Register on your blog %s:', 'regplus'), get_option('blogname')) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s', 'regplus'), $user_login) . "\r\n\r\n";
	$message .= sprintf(__('E-mail: %s', 'regplus'), $user_email) . "\r\n";

	@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Register', 'regplus'), get_option('blogname')), $message);
	
	#-- REGPLUS --#
	}else if( !$regplus['disable_admin'] ){		
		if( $regplus['adminhtml'] ){
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		//$headers .= 'From: ' . $regplus['adminfrom'] . "\r\n" . 'Reply-To: ' . $regplus['adminfrom'] . "\r\n";
		add_filter('wp_mail_from', array($register_plus, 'adminfrom'));
		add_filter('wp_mail_from_name', array($register_plus, 'adminfromname'));
		$subject = $regplus['adminsubject'];
		$message = str_replace('%user_login%', $user_login, $regplus['adminmsg']);
		$message = str_replace('%user_email%', $user_email, $message);
		$message = str_replace('%blogname%', get_option('blogname'), $message);
		$message = str_replace('%user_ip%', $_SERVER['REMOTE_ADDR'], $message);
		$message = str_replace('%user_host%', gethostbyaddr($_SERVER['REMOTE_ADDR']), $message);
		$message = str_replace('%user_ref%', $_SERVER['HTTP_REFERER'], $message);
		$message = str_replace('%user_agent%', $_SERVER['HTTP_USER_AGENT'], $message);
		if( $regplus['firstname'] ) $message = str_replace('%firstname%', $_POST['firstname'], $message);
		if( $regplus['lastname'] ) $message = str_replace('%lastname%', $_POST['lastname'], $message);
		if( $regplus['website'] ) $message = str_replace('%website%', $_POST['website'], $message);
		if( $regplus['aim'] ) $message = str_replace('%aim%', $_POST['aim'], $message);
		if( $regplus['yahoo'] ) $message = str_replace('%yahoo%', $_POST['yahoo'], $message);
		if( $regplus['jabber'] ) $message = str_replace('%jabber%', $_POST['jabber'], $message);
		if( $regplus['about'] ) $message = str_replace('%about%', $_POST['about'], $message);
		if( $regplus['code'] ) $message = str_replace('%invitecode%', $_POST['code'], $message);
		
		if( !is_array( $regplus_custom ) ) $regplus_custom = array();
		if (!empty($regplus_custom)) {
			foreach( $regplus_custom as $k=>$v ){
				$meta = $register_plus->Label_ID($v['label']);
				$value = get_usermeta( $user_id, $meta );
				$message = str_replace('%'.$meta.'%', $value, $message);
			}
		}
		$siteurl = get_option('siteurl');
		$message = str_replace('%siteurl%', $siteurl, $message);
		
		if( $regplus['adminhtml'] && $regplus['admin_nl2br'] )
			$message = nl2br($message);
		
		wp_mail(get_option('admin_email'), $subject, $message, $headers); 
	}
	#-- END REGPLUS --#
	
	if ( empty($plaintext_pass) )
		return;
		
	#-- REGPLUS --#
	if( !$regplus['custom_msg'] ){
	#-- END REGPLUS --#
	
		$message  = sprintf(__('Username: %s', 'regplus'), $user_login) . "\r\n";
		$message .= sprintf(__('Password: %s', 'regplus'), $plaintext_pass) . "\r\n";
		//$message .= get_option('siteurl') . "/wp-login.php";
	
	#-- REGPLUS --#
		$message .= $prelink . get_option('siteurl') . "/wp-login.php" . $email_code . "\r\n"; 
		$message .= $notice; 
	#-- END REGPLUS --#
	
		wp_mail($user_email, sprintf(__('[%s] Your username and password', 'regplus'), get_option('blogname')), $message);
	
	#-- REGPLUS --#
	}else{
		if( $regplus['html'] ){
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		//$headers .= 'From: ' . $regplus['from'] . "\r\n" . 'Reply-To: ' . $regplus['from'] . "\r\n";
		add_filter('wp_mail_from', array($register_plus, 'userfrom'));
		add_filter('wp_mail_from_name', array($register_plus, 'userfromname'));
		$subject = $regplus['subject'];
		$message = str_replace('%user_pass%', $plaintext_pass, $regplus['msg']);
		$message = str_replace('%user_login%', $user_login, $message);
		$message = str_replace('%user_email%', $user_email, $message);
		$message = str_replace('%blogname%', get_option('blogname'), $message);
		$message = str_replace('%user_ip%', $_SERVER['REMOTE_ADDR'], $message);
		$message = str_replace('%user_host%', gethostbyaddr($_SERVER['REMOTE_ADDR']), $message);
		$message = str_replace('%user_ref%', $_SERVER['HTTP_REFERER'], $message);
		$message = str_replace('%user_agent%', $_SERVER['HTTP_USER_AGENT'], $message);
		if( $regplus['firstname'] ) $message = str_replace('%firstname%', $_POST['firstname'], $message);
		if( $regplus['lastname'] ) $message = str_replace('%lastname%', $_POST['lastname'], $message);
		if( $regplus['website'] ) $message = str_replace('%website%', $_POST['website'], $message);
		if( $regplus['aim'] ) $message = str_replace('%aim%', $_POST['aim'], $message);
		if( $regplus['yahoo'] ) $message = str_replace('%yahoo%', $_POST['yahoo'], $message);
		if( $regplus['jabber'] ) $message = str_replace('%jabber%', $_POST['jabber'], $message);
		if( $regplus['about'] ) $message = str_replace('%about%', $_POST['about'], $message);
		if( $regplus['code'] ) $message = str_replace('%invitecode%', $_POST['code'], $message);
		
		if( !is_array( $regplus_custom ) ) $regplus_custom = array();
		if (!empty($regplus_custom)) {
			foreach( $regplus_custom as $k=>$v ){
				$meta = $register_plus->Label_ID($v['label']);
				$value = get_usermeta( $user_id, $meta );
				$message = str_replace('%'.$meta.'%', $value, $message);
			}
		}
		
		$redirect = 'redirect_to=' . $regplus['login_redirect'];
		if( $regplus['email_verify'] )
			$siteurl = get_option('siteurl') . "/wp-login.php" . $email_code . '&' . $redirect;
		else
			$siteurl = get_option('siteurl') . "/wp-login.php?" . $redirect;
		$message = str_replace('%siteurl%', $siteurl, $message);
		
		if( $regplus['html'] && $regplus['user_nl2br'] )
			$message = nl2br($message);
		
		wp_mail($user_email, $subject, $message, $headers); 
	}
	if( $ref != $admin && ( $regplus['email_verify'] || $regplus['admin_verify'] ) ) 
			$temp_user = $wpdb->query( "UPDATE $wpdb->users SET user_login = '$temp_id' WHERE ID = '$user_id'" ); 
	#-- END REGPLUS --#
}
endif;
?>