<?php require_once('AspisMain.php'); ?><?php
if ( (!(class_exists(('SimplePie')))))
 require_once (deconcat2(concat12(ABSPATH,WPINC),'/class-simplepie.php'));
class WP_Feed_Cache extends SimplePie_Cache{function WP_Feed_Cache (  ) {
{trigger_error('Please call SimplePie_Cache::create() instead of the constructor',E_USER_ERROR);
} }
function create ( $location,$filename,$extension ) {
{return array(new WP_Feed_Cache_Transient($location,$filename,$extension),false);
} }
}class WP_Feed_Cache_Transient{var $name;
var $mod_name;
var $lifetime = array(43200,false);
function WP_Feed_Cache_Transient ( $location,$filename,$extension ) {
{$this->name = concat1('feed_',$filename);
$this->mod_name = concat1('feed_mod_',$filename);
$this->lifetime = apply_filters(array('wp_feed_cache_transient_lifetime',false),$this->lifetime,$filename);
} }
function save ( $data ) {
{if ( is_a(deAspisRC($data),('SimplePie')))
 $data = $data[0]->data;
set_transient($this->name,$data,$this->lifetime);
set_transient($this->mod_name,attAspis(time()),$this->lifetime);
return array(true,false);
} }
function load (  ) {
{return get_transient($this->name);
} }
function mtime (  ) {
{return get_transient($this->mod_name);
} }
function touch (  ) {
{return set_transient($this->mod_name,attAspis(time()),$this->lifetime);
} }
function unlink (  ) {
{delete_transient($this->name);
delete_transient($this->mod_name);
return array(true,false);
} }
}class WP_SimplePie_File extends SimplePie_File{function WP_SimplePie_File ( $url,$timeout = array(10,false),$redirects = array(5,false),$headers = array(null,false),$useragent = array(null,false),$force_fsockopen = array(false,false) ) {
{$this->url = $url;
$this->timeout = $timeout;
$this->redirects = $redirects;
$this->headers = $headers;
$this->useragent = $useragent;
$this->method = array(SIMPLEPIE_FILE_SOURCE_REMOTE,false);
if ( deAspis(Aspis_preg_match(array('/^http(s)?:\/\//i',false),$url)))
 {$args = array(array(deregisterTaint(array('timeout',false)) => addTaint($this->timeout),deregisterTaint(array('redirection',false)) => addTaint($this->redirects)),false);
if ( (!((empty($this->headers) || Aspis_empty( $this ->headers )))))
 arrayAssign($args[0],deAspis(registerTaint(array('headers',false))),addTaint($this->headers));
if ( (SIMPLEPIE_USERAGENT != $this->useragent[0]))
 arrayAssign($args[0],deAspis(registerTaint(array('user-agent',false))),addTaint($this->useragent));
$res = wp_remote_request($url,$args);
if ( deAspis(is_wp_error($res)))
 {$this->error = concat1('WP HTTP Error: ',$res[0]->get_error_message());
$this->success = array(false,false);
}else 
{{$this->headers = $res[0]['headers'];
$this->body = $res[0]['body'];
$this->status_code = $res[0][('response')][0]['code'];
}}}else 
{{if ( (denot_boolean($this->body = attAspis(file_get_contents($url[0])))))
 {$this->error = array('file_get_contents could not read the file',false);
$this->success = array(false,false);
}}}} }
}