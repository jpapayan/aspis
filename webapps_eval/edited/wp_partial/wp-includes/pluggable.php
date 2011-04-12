<?php require_once('AspisMain.php'); ?><?php
if ( !function_exists('set_current_user'))
 {function set_current_user ( $id,$name = '' ) {
{$AspisRetTemp = wp_set_current_user($id,$name);
return $AspisRetTemp;
} }
}if ( !function_exists('wp_set_current_user'))
 {function wp_set_current_user ( $id,$name = '' ) {
{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}if ( isset($current_user) && ($id == $current_user->ID))
 {$AspisRetTemp = $current_user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}$current_user = new WP_User($id,$name);
setup_userdata($current_user->ID);
do_action('set_current_user');
{$AspisRetTemp = $current_user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
 }
}if ( !function_exists('wp_get_current_user'))
 {function wp_get_current_user (  ) {
{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}get_currentuserinfo();
{$AspisRetTemp = $current_user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
 }
}if ( !function_exists('get_currentuserinfo'))
 {function get_currentuserinfo (  ) {
{global $current_user;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $current_user,"\$current_user",$AspisChangesCache);
}if ( defined('XMLRPC_REQUEST') && XMLRPC_REQUEST)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}if ( !empty($current_user))
 {AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return ;
}if ( !$user = wp_validate_auth_cookie())
 {if ( is_admin() || (empty($_COOKIE[0][LOGGED_IN_COOKIE]) || Aspis_empty($_COOKIE[0][LOGGED_IN_COOKIE])) || !$user = wp_validate_auth_cookie(deAspisWarningRC($_COOKIE[0][LOGGED_IN_COOKIE]),'logged_in'))
 {wp_set_current_user(0);
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
return $AspisRetTemp;
}}}wp_set_current_user($user);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$current_user",$AspisChangesCache);
 }
}if ( !function_exists('get_userdata'))
 {function get_userdata ( $user_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$user_id = absint($user_id);
if ( $user_id == 0)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$user = wp_cache_get($user_id,'users');
if ( $user)
 {$AspisRetTemp = $user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE ID = %d LIMIT 1",$user_id)))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}_fill_user($user);
{$AspisRetTemp = $user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}if ( !function_exists('get_user_by'))
 {function get_user_by ( $field,$value ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}switch ( $field ) {
case 'id':{$AspisRetTemp = get_userdata($value);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}break ;
case 'slug':$user_id = wp_cache_get($value,'userslugs');
$field = 'user_nicename';
break ;
case 'email':$user_id = wp_cache_get($value,'useremail');
$field = 'user_email';
break ;
case 'login':$value = sanitize_user($value);
$user_id = wp_cache_get($value,'userlogins');
$field = 'user_login';
break ;
default :{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
} }
if ( false !== $user_id)
 {$AspisRetTemp = get_userdata($user_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}if ( !$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE $field = %s",$value)))
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}_fill_user($user);
{$AspisRetTemp = $user;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}if ( !function_exists('get_userdatabylogin'))
 {function get_userdatabylogin ( $user_login ) {
{$AspisRetTemp = get_user_by('login',$user_login);
return $AspisRetTemp;
} }
}if ( !function_exists('get_user_by_email'))
 {function get_user_by_email ( $email ) {
{$AspisRetTemp = get_user_by('email',$email);
return $AspisRetTemp;
} }
}if ( !function_exists('wp_mail'))
 {function wp_mail ( $to,$subject,$message,$headers = '',$attachments = array() ) {
extract((apply_filters('wp_mail',compact('to','subject','message','headers','attachments'))));
if ( !is_array($attachments))
 $attachments = explode("\n",$attachments);
{global $phpmailer;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $phpmailer,"\$phpmailer",$AspisChangesCache);
}if ( !is_object($phpmailer) || !is_a($phpmailer,'PHPMailer'))
 {require_once ABSPATH . WPINC . '/class-phpmailer.php';
require_once ABSPATH . WPINC . '/class-smtp.php';
$phpmailer = new PHPMailer();
}if ( empty($headers))
 {$headers = array();
}else 
{{if ( !is_array($headers))
 {$tempheaders = (array)explode("\n",$headers);
}else 
{{$tempheaders = $headers;
}}$headers = array();
if ( !empty($tempheaders))
 {foreach ( (array)$tempheaders as $header  )
{if ( strpos($header,':') === false)
 {if ( false !== stripos($header,'boundary='))
 {$parts = preg_split('/boundary=/i',trim($header));
$boundary = trim(str_replace(array("'",'"'),'',$parts[1]));
}continue ;
}list($name,$content) = explode(':',trim($header),2);
$name = trim($name);
$content = trim($content);
if ( 'from' == strtolower($name))
 {if ( strpos($content,'<') !== false)
 {$from_name = substr($content,0,strpos($content,'<') - 1);
$from_name = str_replace('"','',$from_name);
$from_name = trim($from_name);
$from_email = substr($content,strpos($content,'<') + 1);
$from_email = str_replace('>','',$from_email);
$from_email = trim($from_email);
}else 
{{$from_email = trim($content);
}}}elseif ( 'content-type' == strtolower($name))
 {if ( strpos($content,';') !== false)
 {list($type,$charset) = explode(';',$content);
$content_type = trim($type);
if ( false !== stripos($charset,'charset='))
 {$charset = trim(str_replace(array('charset=','"'),'',$charset));
}elseif ( false !== stripos($charset,'boundary='))
 {$boundary = trim(str_replace(array('BOUNDARY=','boundary=','"'),'',$charset));
$charset = '';
}}else 
{{$content_type = trim($content);
}}}elseif ( 'cc' == strtolower($name))
 {$cc = explode(",",$content);
}elseif ( 'bcc' == strtolower($name))
 {$bcc = explode(",",$content);
}else 
{{$headers[trim($name)] = trim($content);
}}}}}}$phpmailer->ClearAddresses();
$phpmailer->ClearAllRecipients();
$phpmailer->ClearAttachments();
$phpmailer->ClearBCCs();
$phpmailer->ClearCCs();
$phpmailer->ClearCustomHeaders();
$phpmailer->ClearReplyTos();
if ( !isset($from_name))
 {$from_name = 'WordPress';
}if ( !isset($from_email))
 {$sitename = strtolower(deAspisWarningRC($_SERVER[0]['SERVER_NAME']));
if ( substr($sitename,0,4) == 'www.')
 {$sitename = substr($sitename,4);
}$from_email = 'wordpress@' . $sitename;
}$phpmailer->From = apply_filters('wp_mail_from',$from_email);
$phpmailer->FromName = apply_filters('wp_mail_from_name',$from_name);
$phpmailer->AddAddress($to);
$phpmailer->Subject = $subject;
$phpmailer->Body = $message;
if ( !empty($cc))
 {foreach ( (array)$cc as $recipient  )
{$phpmailer->AddCc(trim($recipient));
}}if ( !empty($bcc))
 {foreach ( (array)$bcc as $recipient  )
{$phpmailer->AddBcc(trim($recipient));
}}$phpmailer->IsMail();
if ( !isset($content_type))
 {$content_type = 'text/plain';
}$content_type = apply_filters('wp_mail_content_type',$content_type);
$phpmailer->ContentType = $content_type;
if ( $content_type == 'text/html')
 {$phpmailer->IsHTML(true);
}if ( !isset($charset))
 {$charset = get_bloginfo('charset');
}$phpmailer->CharSet = apply_filters('wp_mail_charset',$charset);
if ( !empty($headers))
 {foreach ( (array)$headers as $name =>$content )
{$phpmailer->AddCustomHeader(sprintf('%1$s: %2$s',$name,$content));
}if ( false !== stripos($content_type,'multipart') && !empty($boundary))
 {$phpmailer->AddCustomHeader(sprintf("Content-Type: %s;\n\t boundary=\"%s\"",$content_type,$boundary));
}}if ( !empty($attachments))
 {foreach ( $attachments as $attachment  )
{$phpmailer->AddAttachment($attachment);
}}do_action_ref_array('phpmailer_init',array($phpmailer));
$result = @$phpmailer->Send();
{$AspisRetTemp = $result;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$phpmailer",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$phpmailer",$AspisChangesCache);
 }
}if ( !function_exists('wp_authenticate'))
 {function wp_authenticate ( $username,$password ) {
$username = sanitize_user($username);
$password = trim($password);
$user = apply_filters('authenticate',null,$username,$password);
if ( $user == null)
 {$user = new WP_Error('authentication_failed',__('<strong>ERROR</strong>: Invalid username or incorrect password.'));
}$ignore_codes = array('empty_username','empty_password');
if ( is_wp_error($user) && !in_array($user->get_error_code(),$ignore_codes))
 {do_action('wp_login_failed',$username);
}{$AspisRetTemp = $user;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_logout'))
 {function wp_logout (  ) {
wp_clear_auth_cookie();
do_action('wp_logout');
 }
}if ( !function_exists('wp_validate_auth_cookie'))
 {function wp_validate_auth_cookie ( $cookie = '',$scheme = '' ) {
if ( !$cookie_elements = wp_parse_auth_cookie($cookie,$scheme))
 {do_action('auth_cookie_malformed',$cookie,$scheme);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}extract(($cookie_elements),EXTR_OVERWRITE);
$expired = $expiration;
if ( defined('DOING_AJAX') || 'POST' == deAspisWarningRC($_SERVER[0]['REQUEST_METHOD']))
 $expired += 3600;
if ( $expired < time())
 {do_action('auth_cookie_expired',$cookie_elements);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$user = get_userdatabylogin($username);
if ( !$user)
 {do_action('auth_cookie_bad_username',$cookie_elements);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}$pass_frag = substr($user->user_pass,8,4);
$key = wp_hash($username . $pass_frag . '|' . $expiration,$scheme);
$hash = hash_hmac('md5',$username . '|' . $expiration,$key);
if ( $hmac != $hash)
 {do_action('auth_cookie_bad_hash',$cookie_elements);
{$AspisRetTemp = false;
return $AspisRetTemp;
}}if ( $expiration < time())
 $GLOBALS[0]['login_grace_period'] = 1;
do_action('auth_cookie_valid',$cookie_elements,$user);
{$AspisRetTemp = $user->ID;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_generate_auth_cookie'))
 {function wp_generate_auth_cookie ( $user_id,$expiration,$scheme = 'auth' ) {
$user = get_userdata($user_id);
$pass_frag = substr($user->user_pass,8,4);
$key = wp_hash($user->user_login . $pass_frag . '|' . $expiration,$scheme);
$hash = hash_hmac('md5',$user->user_login . '|' . $expiration,$key);
$cookie = $user->user_login . '|' . $expiration . '|' . $hash;
{$AspisRetTemp = apply_filters('auth_cookie',$cookie,$user_id,$expiration,$scheme);
return $AspisRetTemp;
} }
}if ( !function_exists('wp_parse_auth_cookie'))
 {function wp_parse_auth_cookie ( $cookie = '',$scheme = '' ) {
if ( empty($cookie))
 {switch ( $scheme ) {
case 'auth':$cookie_name = AUTH_COOKIE;
break ;
case 'secure_auth':$cookie_name = SECURE_AUTH_COOKIE;
break ;
case "logged_in":$cookie_name = LOGGED_IN_COOKIE;
break ;
default :if ( is_ssl())
 {$cookie_name = SECURE_AUTH_COOKIE;
$scheme = 'secure_auth';
}else 
{{$cookie_name = AUTH_COOKIE;
$scheme = 'auth';
}} }
if ( (empty($_COOKIE[0][$cookie_name]) || Aspis_empty($_COOKIE[0][$cookie_name])))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$cookie = deAspisWarningRC($_COOKIE[0][$cookie_name]);
}$cookie_elements = explode('|',$cookie);
if ( count($cookie_elements) != 3)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}list($username,$expiration,$hmac) = $cookie_elements;
{$AspisRetTemp = compact('username','expiration','hmac','scheme');
return $AspisRetTemp;
} }
}if ( !function_exists('wp_set_auth_cookie'))
 {function wp_set_auth_cookie ( $user_id,$remember = false,$secure = '' ) {
if ( $remember)
 {$expiration = $expire = time() + apply_filters('auth_cookie_expiration',1209600,$user_id,$remember);
}else 
{{$expiration = time() + apply_filters('auth_cookie_expiration',172800,$user_id,$remember);
$expire = 0;
}}if ( '' === $secure)
 $secure = is_ssl() ? true : false;
if ( $secure)
 {$auth_cookie_name = SECURE_AUTH_COOKIE;
$scheme = 'secure_auth';
}else 
{{$auth_cookie_name = AUTH_COOKIE;
$scheme = 'auth';
}}$auth_cookie = wp_generate_auth_cookie($user_id,$expiration,$scheme);
$logged_in_cookie = wp_generate_auth_cookie($user_id,$expiration,'logged_in');
do_action('set_auth_cookie',$auth_cookie,$expire,$expiration,$user_id,$scheme);
do_action('set_logged_in_cookie',$logged_in_cookie,$expire,$expiration,$user_id,'logged_in');
if ( version_compare(phpversion(),'5.2.0','ge'))
 {setcookie($auth_cookie_name,$auth_cookie,$expire,PLUGINS_COOKIE_PATH,COOKIE_DOMAIN,$secure,true);
setcookie($auth_cookie_name,$auth_cookie,$expire,ADMIN_COOKIE_PATH,COOKIE_DOMAIN,$secure,true);
setcookie(LOGGED_IN_COOKIE,$logged_in_cookie,$expire,COOKIEPATH,COOKIE_DOMAIN,false,true);
if ( COOKIEPATH != SITECOOKIEPATH)
 setcookie(LOGGED_IN_COOKIE,$logged_in_cookie,$expire,SITECOOKIEPATH,COOKIE_DOMAIN,false,true);
}else 
{{$cookie_domain = COOKIE_DOMAIN;
if ( !empty($cookie_domain))
 $cookie_domain .= '; HttpOnly';
setcookie($auth_cookie_name,$auth_cookie,$expire,PLUGINS_COOKIE_PATH,$cookie_domain,$secure);
setcookie($auth_cookie_name,$auth_cookie,$expire,ADMIN_COOKIE_PATH,$cookie_domain,$secure);
setcookie(LOGGED_IN_COOKIE,$logged_in_cookie,$expire,COOKIEPATH,$cookie_domain);
if ( COOKIEPATH != SITECOOKIEPATH)
 setcookie(LOGGED_IN_COOKIE,$logged_in_cookie,$expire,SITECOOKIEPATH,$cookie_domain);
}} }
}if ( !function_exists('wp_clear_auth_cookie'))
 {function wp_clear_auth_cookie (  ) {
do_action('clear_auth_cookie');
setcookie(AUTH_COOKIE,' ',time() - 31536000,ADMIN_COOKIE_PATH,COOKIE_DOMAIN);
setcookie(SECURE_AUTH_COOKIE,' ',time() - 31536000,ADMIN_COOKIE_PATH,COOKIE_DOMAIN);
setcookie(AUTH_COOKIE,' ',time() - 31536000,PLUGINS_COOKIE_PATH,COOKIE_DOMAIN);
setcookie(SECURE_AUTH_COOKIE,' ',time() - 31536000,PLUGINS_COOKIE_PATH,COOKIE_DOMAIN);
setcookie(LOGGED_IN_COOKIE,' ',time() - 31536000,COOKIEPATH,COOKIE_DOMAIN);
setcookie(LOGGED_IN_COOKIE,' ',time() - 31536000,SITECOOKIEPATH,COOKIE_DOMAIN);
setcookie(AUTH_COOKIE,' ',time() - 31536000,COOKIEPATH,COOKIE_DOMAIN);
setcookie(AUTH_COOKIE,' ',time() - 31536000,SITECOOKIEPATH,COOKIE_DOMAIN);
setcookie(SECURE_AUTH_COOKIE,' ',time() - 31536000,COOKIEPATH,COOKIE_DOMAIN);
setcookie(SECURE_AUTH_COOKIE,' ',time() - 31536000,SITECOOKIEPATH,COOKIE_DOMAIN);
setcookie(USER_COOKIE,' ',time() - 31536000,COOKIEPATH,COOKIE_DOMAIN);
setcookie(PASS_COOKIE,' ',time() - 31536000,COOKIEPATH,COOKIE_DOMAIN);
setcookie(USER_COOKIE,' ',time() - 31536000,SITECOOKIEPATH,COOKIE_DOMAIN);
setcookie(PASS_COOKIE,' ',time() - 31536000,SITECOOKIEPATH,COOKIE_DOMAIN);
 }
}if ( !function_exists('is_user_logged_in'))
 {function is_user_logged_in (  ) {
$user = wp_get_current_user();
if ( $user->id == 0)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}{$AspisRetTemp = true;
return $AspisRetTemp;
} }
}if ( !function_exists('auth_redirect'))
 {function auth_redirect (  ) {
if ( is_ssl() || force_ssl_admin())
 $secure = true;
else 
{$secure = false;
}if ( $secure && !is_ssl() && false !== strpos(deAspisWarningRC($_SERVER[0]['REQUEST_URI']),'wp-admin'))
 {if ( 0 === strpos(deAspisWarningRC($_SERVER[0]['REQUEST_URI']),'http'))
 {wp_redirect(preg_replace('|^http://|','https://',deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
exit();
}else 
{{wp_redirect('https://' . deAspisWarningRC($_SERVER[0]['HTTP_HOST']) . deAspisWarningRC($_SERVER[0]['REQUEST_URI']));
exit();
}}}if ( $user_id = wp_validate_auth_cookie('',apply_filters('auth_redirect_scheme','')))
 {do_action('auth_redirect',$user_id);
if ( !$secure && get_user_option('use_ssl',$user_id) && false !== strpos(deAspisWarningRC($_SERVER[0]['REQUEST_URI']),'wp-admin'))
 {if ( 0 === strpos(deAspisWarningRC($_SERVER[0]['REQUEST_URI']),'http'))
 {wp_redirect(preg_replace('|^http://|','https://',deAspisWarningRC($_SERVER[0]['REQUEST_URI'])));
exit();
}else 
{{wp_redirect('https://' . deAspisWarningRC($_SERVER[0]['HTTP_HOST']) . deAspisWarningRC($_SERVER[0]['REQUEST_URI']));
exit();
}}}{return ;
}}nocache_headers();
if ( is_ssl())
 $proto = 'https://';
else 
{$proto = 'http://';
}$redirect = (strpos(deAspisWarningRC($_SERVER[0]['REQUEST_URI']),'/options.php') && wp_get_referer()) ? wp_get_referer() : $proto . deAspisWarningRC($_SERVER[0]['HTTP_HOST']) . deAspisWarningRC($_SERVER[0]['REQUEST_URI']);
$login_url = wp_login_url($redirect);
wp_redirect($login_url);
exit();
 }
}if ( !function_exists('check_admin_referer'))
 {function check_admin_referer ( $action = -1,$query_arg = '_wpnonce' ) {
$adminurl = strtolower(admin_url());
$referer = strtolower(wp_get_referer());
$result = (isset($_REQUEST[0][$query_arg]) && Aspis_isset($_REQUEST[0][$query_arg])) ? wp_verify_nonce(deAspisWarningRC($_REQUEST[0][$query_arg]),$action) : false;
if ( !$result && !(-1 == $action && strpos($referer,$adminurl) !== false))
 {wp_nonce_ays($action);
exit();
}do_action('check_admin_referer',$action,$result);
{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
}if ( !function_exists('check_ajax_referer'))
 {function check_ajax_referer ( $action = -1,$query_arg = false,$die = true ) {
if ( $query_arg)
 $nonce = deAspisWarningRC($_REQUEST[0][$query_arg]);
else 
{$nonce = (isset($_REQUEST[0]['_ajax_nonce']) && Aspis_isset($_REQUEST[0]['_ajax_nonce'])) ? deAspisWarningRC($_REQUEST[0]['_ajax_nonce']) : deAspisWarningRC($_REQUEST[0]['_wpnonce']);
}$result = wp_verify_nonce($nonce,$action);
if ( $die && false == $result)
 exit('-1');
do_action('check_ajax_referer',$action,$result);
{$AspisRetTemp = $result;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_redirect'))
 {function wp_redirect ( $location,$status = 302 ) {
{global $is_IIS;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $is_IIS,"\$is_IIS",$AspisChangesCache);
}$location = apply_filters('wp_redirect',$location,$status);
$status = apply_filters('wp_redirect_status',$status,$location);
if ( !$location)
 {$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_IIS",$AspisChangesCache);
return $AspisRetTemp;
}$location = wp_sanitize_redirect($location);
if ( $is_IIS)
 {header("Refresh: 0;
url=$location");
}else 
{{if ( php_sapi_name() != 'cgi-fcgi')
 status_header($status);
header("Location: $location",true,$status);
}}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$is_IIS",$AspisChangesCache);
 }
}if ( !function_exists('wp_sanitize_redirect'))
 {function wp_sanitize_redirect ( $location ) {
$location = preg_replace('|[^a-z0-9-~+_.?#=&;,/:%!]|i','',$location);
$location = wp_kses_no_null($location);
$strip = array('%0d','%0a','%0D','%0A');
$location = _deep_replace($strip,$location);
{$AspisRetTemp = $location;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_safe_redirect'))
 {function wp_safe_redirect ( $location,$status = 302 ) {
$location = wp_sanitize_redirect($location);
$location = wp_validate_redirect($location,admin_url());
wp_redirect($location,$status);
 }
}if ( !function_exists('wp_validate_redirect'))
 {function wp_validate_redirect ( $location,$default = '' ) {
if ( substr($location,0,2) == '//')
 $location = 'http:' . $location;
$test = ($cut = strpos($location,'?')) ? substr($location,0,$cut) : $location;
$lp = parse_url($test);
$wpp = parse_url(get_option('home'));
$allowed_hosts = (array)apply_filters('allowed_redirect_hosts',array($wpp['host']),isset($lp['host']) ? $lp['host'] : '');
if ( isset($lp['host']) && (!in_array($lp['host'],$allowed_hosts) && $lp['host'] != strtolower($wpp['host'])))
 $location = $default;
{$AspisRetTemp = $location;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_notify_postauthor'))
 {function wp_notify_postauthor ( $comment_id,$comment_type = '' ) {
$comment = get_comment($comment_id);
$post = get_post($comment->comment_post_ID);
$user = get_userdata($post->post_author);
$current_user = wp_get_current_user();
if ( $comment->user_id == $post->post_author)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( '' == $user->user_email)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}$comment_author_domain = @gethostbyaddr($comment->comment_author_IP);
$blogname = wp_specialchars_decode(get_option('blogname'),ENT_QUOTES);
if ( empty($comment_type))
 $comment_type = 'comment';
if ( 'comment' == $comment_type)
 {$notify_message = sprintf(__('New comment on your post #%1$s "%2$s"'),$comment->comment_post_ID,$post->post_title) . "\r\n";
$notify_message .= sprintf(__('Author : %1$s (IP: %2$s , %3$s)'),$comment->comment_author,$comment->comment_author_IP,$comment_author_domain) . "\r\n";
$notify_message .= sprintf(__('E-mail : %s'),$comment->comment_author_email) . "\r\n";
$notify_message .= sprintf(__('URL    : %s'),$comment->comment_author_url) . "\r\n";
$notify_message .= sprintf(__('Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=%s'),$comment->comment_author_IP) . "\r\n";
$notify_message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
$notify_message .= __('You can see all comments on this post here: ') . "\r\n";
$subject = sprintf(__('[%1$s] Comment: "%2$s"'),$blogname,$post->post_title);
}elseif ( 'trackback' == $comment_type)
 {$notify_message = sprintf(__('New trackback on your post #%1$s "%2$s"'),$comment->comment_post_ID,$post->post_title) . "\r\n";
$notify_message .= sprintf(__('Website: %1$s (IP: %2$s , %3$s)'),$comment->comment_author,$comment->comment_author_IP,$comment_author_domain) . "\r\n";
$notify_message .= sprintf(__('URL    : %s'),$comment->comment_author_url) . "\r\n";
$notify_message .= __('Excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
$notify_message .= __('You can see all trackbacks on this post here: ') . "\r\n";
$subject = sprintf(__('[%1$s] Trackback: "%2$s"'),$blogname,$post->post_title);
}elseif ( 'pingback' == $comment_type)
 {$notify_message = sprintf(__('New pingback on your post #%1$s "%2$s"'),$comment->comment_post_ID,$post->post_title) . "\r\n";
$notify_message .= sprintf(__('Website: %1$s (IP: %2$s , %3$s)'),$comment->comment_author,$comment->comment_author_IP,$comment_author_domain) . "\r\n";
$notify_message .= sprintf(__('URL    : %s'),$comment->comment_author_url) . "\r\n";
$notify_message .= __('Excerpt: ') . "\r\n" . sprintf('[...] %s [...]',$comment->comment_content) . "\r\n\r\n";
$notify_message .= __('You can see all pingbacks on this post here: ') . "\r\n";
$subject = sprintf(__('[%1$s] Pingback: "%2$s"'),$blogname,$post->post_title);
}$notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";
if ( EMPTY_TRASH_DAYS)
 $notify_message .= sprintf(__('Trash it: %s'),admin_url("comment.php?action=trash&c=$comment_id")) . "\r\n";
else 
{$notify_message .= sprintf(__('Delete it: %s'),admin_url("comment.php?action=delete&c=$comment_id")) . "\r\n";
}$notify_message .= sprintf(__('Spam it: %s'),admin_url("comment.php?action=spam&c=$comment_id")) . "\r\n";
$wp_email = 'wordpress@' . preg_replace('#^www\.#','',strtolower(deAspisWarningRC($_SERVER[0]['SERVER_NAME'])));
if ( '' == $comment->comment_author)
 {$from = "From: \"$blogname\" <$wp_email>";
if ( '' != $comment->comment_author_email)
 $reply_to = "Reply-To: $comment->comment_author_email";
}else 
{{$from = "From: \"$comment->comment_author\" <$wp_email>";
if ( '' != $comment->comment_author_email)
 $reply_to = "Reply-To: \"$comment->comment_author_email\" <$comment->comment_author_email>";
}}$message_headers = "$from\n" . "Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\n";
if ( isset($reply_to))
 $message_headers .= $reply_to . "\n";
$notify_message = apply_filters('comment_notification_text',$notify_message,$comment_id);
$subject = apply_filters('comment_notification_subject',$subject,$comment_id);
$message_headers = apply_filters('comment_notification_headers',$message_headers,$comment_id);
@wp_mail($user->user_email,$subject,$notify_message,$message_headers);
{$AspisRetTemp = true;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_notify_moderator'))
 {function wp_notify_moderator ( $comment_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}if ( get_option("moderation_notify") == 0)
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}$comment = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->comments WHERE comment_ID=%d LIMIT 1",$comment_id));
$post = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID=%d LIMIT 1",$comment->comment_post_ID));
$comment_author_domain = @gethostbyaddr($comment->comment_author_IP);
$comments_waiting = $wpdb->get_var("SELECT count(comment_ID) FROM $wpdb->comments WHERE comment_approved = '0'");
$blogname = wp_specialchars_decode(get_option('blogname'),ENT_QUOTES);
switch ( $comment->comment_type ) {
case 'trackback':$notify_message = sprintf(__('A new trackback on the post #%1$s "%2$s" is waiting for your approval'),$post->ID,$post->post_title) . "\r\n";
$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
$notify_message .= sprintf(__('Website : %1$s (IP: %2$s , %3$s)'),$comment->comment_author,$comment->comment_author_IP,$comment_author_domain) . "\r\n";
$notify_message .= sprintf(__('URL    : %s'),$comment->comment_author_url) . "\r\n";
$notify_message .= __('Trackback excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
break ;
case 'pingback':$notify_message = sprintf(__('A new pingback on the post #%1$s "%2$s" is waiting for your approval'),$post->ID,$post->post_title) . "\r\n";
$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
$notify_message .= sprintf(__('Website : %1$s (IP: %2$s , %3$s)'),$comment->comment_author,$comment->comment_author_IP,$comment_author_domain) . "\r\n";
$notify_message .= sprintf(__('URL    : %s'),$comment->comment_author_url) . "\r\n";
$notify_message .= __('Pingback excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
break ;
default :$notify_message = sprintf(__('A new comment on the post #%1$s "%2$s" is waiting for your approval'),$post->ID,$post->post_title) . "\r\n";
$notify_message .= get_permalink($comment->comment_post_ID) . "\r\n\r\n";
$notify_message .= sprintf(__('Author : %1$s (IP: %2$s , %3$s)'),$comment->comment_author,$comment->comment_author_IP,$comment_author_domain) . "\r\n";
$notify_message .= sprintf(__('E-mail : %s'),$comment->comment_author_email) . "\r\n";
$notify_message .= sprintf(__('URL    : %s'),$comment->comment_author_url) . "\r\n";
$notify_message .= sprintf(__('Whois  : http://ws.arin.net/cgi-bin/whois.pl?queryinput=%s'),$comment->comment_author_IP) . "\r\n";
$notify_message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
break ;
 }
$notify_message .= sprintf(__('Approve it: %s'),admin_url("comment.php?action=approve&c=$comment_id")) . "\r\n";
if ( EMPTY_TRASH_DAYS)
 $notify_message .= sprintf(__('Trash it: %s'),admin_url("comment.php?action=trash&c=$comment_id")) . "\r\n";
else 
{$notify_message .= sprintf(__('Delete it: %s'),admin_url("comment.php?action=delete&c=$comment_id")) . "\r\n";
}$notify_message .= sprintf(__('Spam it: %s'),admin_url("comment.php?action=spam&c=$comment_id")) . "\r\n";
$notify_message .= sprintf(_n('Currently %s comment is waiting for approval. Please visit the moderation panel:','Currently %s comments are waiting for approval. Please visit the moderation panel:',$comments_waiting),number_format_i18n($comments_waiting)) . "\r\n";
$notify_message .= admin_url("edit-comments.php?comment_status=moderated") . "\r\n";
$subject = sprintf(__('[%1$s] Please moderate: "%2$s"'),$blogname,$post->post_title);
$admin_email = get_option('admin_email');
$message_headers = '';
$notify_message = apply_filters('comment_moderation_text',$notify_message,$comment_id);
$subject = apply_filters('comment_moderation_subject',$subject,$comment_id);
$message_headers = apply_filters('comment_moderation_headers',$message_headers);
@wp_mail($admin_email,$subject,$notify_message,$message_headers);
{$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}if ( !function_exists('wp_password_change_notification'))
 {function wp_password_change_notification ( &$user ) {
if ( $user->user_email != get_option('admin_email'))
 {$message = sprintf(__('Password Lost and Changed for user: %s'),$user->user_login) . "\r\n";
$blogname = wp_specialchars_decode(get_option('blogname'),ENT_QUOTES);
wp_mail(get_option('admin_email'),sprintf(__('[%s] Password Lost/Changed'),$blogname),$message);
} }
}if ( !function_exists('wp_new_user_notification'))
 {function wp_new_user_notification ( $user_id,$plaintext_pass = '' ) {
$user = new WP_User($user_id);
$user_login = stripslashes($user->user_login);
$user_email = stripslashes($user->user_email);
$blogname = wp_specialchars_decode(get_option('blogname'),ENT_QUOTES);
$message = sprintf(__('New user registration on your blog %s:'),$blogname) . "\r\n\r\n";
$message .= sprintf(__('Username: %s'),$user_login) . "\r\n\r\n";
$message .= sprintf(__('E-mail: %s'),$user_email) . "\r\n";
@wp_mail(get_option('admin_email'),sprintf(__('[%s] New User Registration'),$blogname),$message);
if ( empty($plaintext_pass))
 {return ;
}$message = sprintf(__('Username: %s'),$user_login) . "\r\n";
$message .= sprintf(__('Password: %s'),$plaintext_pass) . "\r\n";
$message .= wp_login_url() . "\r\n";
wp_mail($user_email,sprintf(__('[%s] Your username and password'),$blogname),$message);
 }
}if ( !function_exists('wp_nonce_tick'))
 {function wp_nonce_tick (  ) {
$nonce_life = apply_filters('nonce_life',86400);
{$AspisRetTemp = ceil(time() / ($nonce_life / 2));
return $AspisRetTemp;
} }
}if ( !function_exists('wp_verify_nonce'))
 {function wp_verify_nonce ( $nonce,$action = -1 ) {
$user = wp_get_current_user();
$uid = (int)$user->id;
$i = wp_nonce_tick();
if ( substr(wp_hash($i . $action . $uid,'nonce'),-12,10) == $nonce)
 {$AspisRetTemp = 1;
return $AspisRetTemp;
}if ( substr(wp_hash(($i - 1) . $action . $uid,'nonce'),-12,10) == $nonce)
 {$AspisRetTemp = 2;
return $AspisRetTemp;
}{$AspisRetTemp = false;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_create_nonce'))
 {function wp_create_nonce ( $action = -1 ) {
$user = wp_get_current_user();
$uid = (int)$user->id;
$i = wp_nonce_tick();
{$AspisRetTemp = substr(wp_hash($i . $action . $uid,'nonce'),-12,10);
return $AspisRetTemp;
} }
}if ( !function_exists('wp_salt'))
 {function wp_salt ( $scheme = 'auth' ) {
{global $wp_default_secret_key;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_default_secret_key,"\$wp_default_secret_key",$AspisChangesCache);
}$secret_key = '';
if ( defined('SECRET_KEY') && ('' != SECRET_KEY) && ($wp_default_secret_key != SECRET_KEY))
 $secret_key = SECRET_KEY;
if ( 'auth' == $scheme)
 {if ( defined('AUTH_KEY') && ('' != AUTH_KEY) && ($wp_default_secret_key != AUTH_KEY))
 $secret_key = AUTH_KEY;
if ( defined('AUTH_SALT'))
 {$salt = AUTH_SALT;
}elseif ( defined('SECRET_SALT'))
 {$salt = SECRET_SALT;
}else 
{{$salt = get_option('auth_salt');
if ( empty($salt))
 {$salt = wp_generate_password(64);
update_option('auth_salt',$salt);
}}}}elseif ( 'secure_auth' == $scheme)
 {if ( defined('SECURE_AUTH_KEY') && ('' != SECURE_AUTH_KEY) && ($wp_default_secret_key != SECURE_AUTH_KEY))
 $secret_key = SECURE_AUTH_KEY;
if ( defined('SECURE_AUTH_SALT'))
 {$salt = SECURE_AUTH_SALT;
}else 
{{$salt = get_option('secure_auth_salt');
if ( empty($salt))
 {$salt = wp_generate_password(64);
update_option('secure_auth_salt',$salt);
}}}}elseif ( 'logged_in' == $scheme)
 {if ( defined('LOGGED_IN_KEY') && ('' != LOGGED_IN_KEY) && ($wp_default_secret_key != LOGGED_IN_KEY))
 $secret_key = LOGGED_IN_KEY;
if ( defined('LOGGED_IN_SALT'))
 {$salt = LOGGED_IN_SALT;
}else 
{{$salt = get_option('logged_in_salt');
if ( empty($salt))
 {$salt = wp_generate_password(64);
update_option('logged_in_salt',$salt);
}}}}elseif ( 'nonce' == $scheme)
 {if ( defined('NONCE_KEY') && ('' != NONCE_KEY) && ($wp_default_secret_key != NONCE_KEY))
 $secret_key = NONCE_KEY;
if ( defined('NONCE_SALT'))
 {$salt = NONCE_SALT;
}else 
{{$salt = get_option('nonce_salt');
if ( empty($salt))
 {$salt = wp_generate_password(64);
update_option('nonce_salt',$salt);
}}}}else 
{{$salt = hash_hmac('md5',$scheme,$secret_key);
}}{$AspisRetTemp = apply_filters('salt',$secret_key . $salt,$scheme);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_default_secret_key",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_default_secret_key",$AspisChangesCache);
 }
}if ( !function_exists('wp_hash'))
 {function wp_hash ( $data,$scheme = 'auth' ) {
$salt = wp_salt($scheme);
{$AspisRetTemp = hash_hmac('md5',$data,$salt);
return $AspisRetTemp;
} }
}if ( !function_exists('wp_hash_password'))
 {function wp_hash_password ( $password ) {
{global $wp_hasher;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_hasher,"\$wp_hasher",$AspisChangesCache);
}if ( empty($wp_hasher))
 {require_once (ABSPATH . 'wp-includes/class-phpass.php');
$wp_hasher = new PasswordHash(8,TRUE);
}{$AspisRetTemp = $wp_hasher->HashPassword($password);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_hasher",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_hasher",$AspisChangesCache);
 }
}if ( !function_exists('wp_check_password'))
 {function wp_check_password ( $password,$hash,$user_id = '' ) {
{global $wp_hasher;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wp_hasher,"\$wp_hasher",$AspisChangesCache);
}if ( strlen($hash) <= 32)
 {$check = ($hash == md5($password));
if ( $check && $user_id)
 {wp_set_password($password,$user_id);
$hash = wp_hash_password($password);
}{$AspisRetTemp = apply_filters('check_password',$check,$password,$hash,$user_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_hasher",$AspisChangesCache);
return $AspisRetTemp;
}}if ( empty($wp_hasher))
 {require_once (ABSPATH . 'wp-includes/class-phpass.php');
$wp_hasher = new PasswordHash(8,TRUE);
}$check = $wp_hasher->CheckPassword($password,$hash);
{$AspisRetTemp = apply_filters('check_password',$check,$password,$hash,$user_id);
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_hasher",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wp_hasher",$AspisChangesCache);
 }
}if ( !function_exists('wp_generate_password'))
 {function wp_generate_password ( $length = 12,$special_chars = true ) {
$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
if ( $special_chars)
 $chars .= '!@#$%^&*()';
$password = '';
for ( $i = 0 ; $i < $length ; $i++ )
$password .= substr($chars,wp_rand(0,strlen($chars) - 1),1);
{$AspisRetTemp = $password;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_rand'))
 {function wp_rand ( $min = 0,$max = 0 ) {
{global $rnd_value;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $rnd_value,"\$rnd_value",$AspisChangesCache);
}$seed = get_transient('random_seed');
if ( strlen($rnd_value) < 8)
 {$rnd_value = md5(uniqid(microtime() . mt_rand(),true) . $seed);
$rnd_value .= sha1($rnd_value);
$rnd_value .= sha1($rnd_value . $seed);
$seed = md5($seed . $rnd_value);
set_transient('random_seed',$seed);
}$value = substr($rnd_value,0,8);
$rnd_value = substr($rnd_value,8);
$value = abs(hexdec($value));
if ( $max != 0)
 $value = $min + (($max - $min + 1) * ($value / (4294967295 + 1)));
{$AspisRetTemp = abs(intval($value));
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$rnd_value",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$rnd_value",$AspisChangesCache);
 }
}if ( !function_exists('wp_set_password'))
 {function wp_set_password ( $password,$user_id ) {
{global $wpdb;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $wpdb,"\$wpdb",$AspisChangesCache);
}$hash = wp_hash_password($password);
$wpdb->update($wpdb->users,array('user_pass' => $hash,'user_activation_key' => ''),array('ID' => $user_id));
wp_cache_delete($user_id,'users');
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$wpdb",$AspisChangesCache);
 }
}if ( !function_exists('get_avatar'))
 {function get_avatar ( $id_or_email,$size = '96',$default = '',$alt = false ) {
if ( !get_option('show_avatars'))
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( false === $alt)
 $safe_alt = '';
else 
{$safe_alt = esc_attr($alt);
}if ( !is_numeric($size))
 $size = '96';
$email = '';
if ( is_numeric($id_or_email))
 {$id = (int)$id_or_email;
$user = get_userdata($id);
if ( $user)
 $email = $user->user_email;
}elseif ( is_object($id_or_email))
 {if ( isset($id_or_email->comment_type) && '' != $id_or_email->comment_type && 'comment' != $id_or_email->comment_type)
 {$AspisRetTemp = false;
return $AspisRetTemp;
}if ( !empty($id_or_email->user_id))
 {$id = (int)$id_or_email->user_id;
$user = get_userdata($id);
if ( $user)
 $email = $user->user_email;
}elseif ( !empty($id_or_email->comment_author_email))
 {$email = $id_or_email->comment_author_email;
}}else 
{{$email = $id_or_email;
}}if ( empty($default))
 {$avatar_default = get_option('avatar_default');
if ( empty($avatar_default))
 $default = 'mystery';
else 
{$default = $avatar_default;
}}if ( is_ssl())
 $host = 'https://secure.gravatar.com';
else 
{$host = 'http://www.gravatar.com';
}if ( 'mystery' == $default)
 $default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}";
elseif ( 'blank' == $default)
 $default = includes_url('images/blank.gif');
elseif ( !empty($email) && 'gravatar_default' == $default)
 $default = '';
elseif ( 'gravatar_default' == $default)
 $default = "$host/avatar/s={$size}";
elseif ( empty($email))
 $default = "$host/avatar/?d=$default&amp;
s={$size}";
elseif ( strpos($default,'http://') === 0)
 $default = add_query_arg('s',$size,$default);
if ( !empty($email))
 {$out = "$host/avatar/";
$out .= md5(strtolower($email));
$out .= '?s=' . $size;
$out .= '&amp;d=' . urlencode($default);
$rating = get_option('avatar_rating');
if ( !empty($rating))
 $out .= "&amp;
r={$rating}";
$avatar = "<img alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
}else 
{{$avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' />";
}}{$AspisRetTemp = apply_filters('get_avatar',$avatar,$id_or_email,$size,$default,$alt);
return $AspisRetTemp;
} }
}if ( !function_exists('wp_setcookie'))
 {function wp_setcookie ( $username,$password = '',$already_md5 = false,$home = '',$siteurl = '',$remember = false ) {
_deprecated_function(__FUNCTION__,'2.5','wp_set_auth_cookie()');
$user = get_userdatabylogin($username);
wp_set_auth_cookie($user->ID,$remember);
 }
}if ( !function_exists('wp_clearcookie'))
 {function wp_clearcookie (  ) {
_deprecated_function(__FUNCTION__,'2.5','wp_clear_auth_cookie()');
wp_clear_auth_cookie();
 }
}if ( !function_exists('wp_get_cookie_login'))
 {function wp_get_cookie_login (  ) {
_deprecated_function(__FUNCTION__,'2.5','');
{$AspisRetTemp = false;
return $AspisRetTemp;
} }
}if ( !function_exists('wp_login'))
 {function wp_login ( $username,$password,$deprecated = '' ) {
{global $error;
$AspisVar0 = &AspisCleanTaintedGlobalUntainted( $error,"\$error",$AspisChangesCache);
}$user = wp_authenticate($username,$password);
if ( !is_wp_error($user))
 {$AspisRetTemp = true;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$error",$AspisChangesCache);
return $AspisRetTemp;
}$error = $user->get_error_message();
{$AspisRetTemp = false;
AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$error",$AspisChangesCache);
return $AspisRetTemp;
}AspisRestoreTaintedGlobalUntainted($AspisVar0,"\$error",$AspisChangesCache);
 }
}if ( !function_exists('wp_text_diff'))
 {function wp_text_diff ( $left_string,$right_string,$args = null ) {
$defaults = array('title' => '','title_left' => '','title_right' => '');
$args = wp_parse_args($args,$defaults);
if ( !class_exists('WP_Text_Diff_Renderer_Table'))
 require (ABSPATH . WPINC . '/wp-diff.php');
$left_string = normalize_whitespace($left_string);
$right_string = normalize_whitespace($right_string);
$left_lines = split("\n",$left_string);
$right_lines = split("\n",$right_string);
$text_diff = new Text_Diff($left_lines,$right_lines);
$renderer = new WP_Text_Diff_Renderer_Table();
$diff = $renderer->render($text_diff);
if ( !$diff)
 {$AspisRetTemp = '';
return $AspisRetTemp;
}$r = "<table class='diff'>\n";
$r .= "<col class='ltype' /><col class='content' /><col class='ltype' /><col class='content' />";
if ( $args['title'] || $args['title_left'] || $args['title_right'])
 $r .= "<thead>";
if ( $args['title'])
 $r .= "<tr class='diff-title'><th colspan='4'>$args[title]</th></tr>\n";
if ( $args['title_left'] || $args['title_right'])
 {$r .= "<tr class='diff-sub-title'>\n";
$r .= "\t<td></td><th>$args[title_left]</th>\n";
$r .= "\t<td></td><th>$args[title_right]</th>\n";
$r .= "</tr>\n";
}if ( $args['title'] || $args['title_left'] || $args['title_right'])
 $r .= "</thead>\n";
$r .= "<tbody>\n$diff\n</tbody>\n";
$r .= "</table>";
{$AspisRetTemp = $r;
return $AspisRetTemp;
} }
}