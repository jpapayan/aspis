<?php require_once('AspisMain.php'); ?><?php
require_once ('../wp-load.php');
if ( (denot_boolean(get_option(array('use_linksupdate',false)))))
 wp_die(__(array('Feature disabled.',false)));
$link_uris = $wpdb[0]->get_col(concat1("SELECT link_url FROM ",$wpdb[0]->links));
if ( (denot_boolean($link_uris)))
 wp_die(__(array('No links',false)));
$link_uris = Aspis_urlencode(Aspis_join($link_uris,array("\n",false)));
$query_string = concat1("uris=",$link_uris);
$options = array(array(),false);
arrayAssign($options[0],deAspis(registerTaint(array('timeout',false))),addTaint(array(30,false)));
arrayAssign($options[0],deAspis(registerTaint(array('body',false))),addTaint($query_string));
arrayAssign($options[0],deAspis(registerTaint(array('headers',false))),addTaint(array(array(deregisterTaint(array('content-type',false)) => addTaint(concat1('application/x-www-form-urlencoded; charset=',get_option(array('blog_charset',false)))),deregisterTaint(array('content-length',false)) => addTaint(attAspis(strlen($query_string[0]))),),false)));
$response = wp_remote_get(array('http://api.pingomatic.com/updated-batch/',false),$options);
if ( deAspis(is_wp_error($response)))
 wp_die(__(array('Request Failed.',false)));
if ( (deAspis($response[0][('response')][0]['code']) != (200)))
 wp_die(__(array('Request Failed.',false)));
$body = Aspis_str_replace(array(array(array("\r\n",false),array("\r",false)),false),array("\n",false),$response[0]['body']);
$returns = Aspis_explode(array("\n",false),$body);
foreach ( $returns[0] as $return  )
{$time = Aspis_substr($return,array(0,false),array(19,false));
$uri = Aspis_preg_replace(array('/(.*?) | (.*?)/',false),array('$2',false),$return);
$wpdb[0]->update($wpdb[0]->links,array(array(deregisterTaint(array('link_updated',false)) => addTaint($time)),false),array(array(deregisterTaint(array('link_url',false)) => addTaint($uri)),false));
};
?>
<?php 