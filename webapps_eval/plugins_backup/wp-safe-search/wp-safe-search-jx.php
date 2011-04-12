<?php
require_once 'wp-safe-search.inc.php'; // cookies related shared functions
/*
if (wpss_getcookie('wpss_safesearch'))
{
	if ($safesearch=='false')
	{
		wpss_setcookie('wpss_safesearch', false, $expire, '/', str_replace('www','',$_SERVER['SERVER_NAME']));
		$safesearch = 0;
	}
	else
	{
		$safesearch = 1;
	}
}
else
{
	if ($safesearch=='true')
	{
		wpss_setcookie('wpss_safesearch', true, $expire, '/', str_replace('www','',$_SERVER['SERVER_NAME']));
		$safesearch = 1;
	}
	else
	{
		$safesearch = 0;
	}
	
}
*/
$expire = time()+3600*24*1000;
$path = $_GET['v0'];
$label_enable = $_GET['v1'];
$label_enabled = $_GET['v2'];
$label_disable = $_GET['v3'];
$label_disabled = $_GET['v4'];
$set = $_GET['set'];

if ($set == 0)
{
// just checking
	if (wpss_getcookie('wpss_safesearch'))
	{
			$wpss_txt1 = $label_enabled;
			$wpss_txt2 = $label_disable;
	}
	else
	{
			$wpss_txt1 = $label_disabled;
			$wpss_txt2 = $label_enable;
	}
}
else
{
// set cookie to new value
	if (wpss_getcookie('wpss_safesearch'))
	{
			$wpss_txt1 = $label_disabled;
			$wpss_txt2 = $label_enable;
			wpss_setcookie('wpss_safesearch', false, $expire, '/', str_replace('www','',$_SERVER['SERVER_NAME']));
	}
	else
	{
			$wpss_txt1 = $label_disabled;
			$wpss_txt2 = $label_enable;
			wpss_setcookie('wpss_safesearch', true, $expire, '/', str_replace('www','',$_SERVER['SERVER_NAME']));
	}
}

$safesearch = '<div class="alignleft">' . $wpss_txt1 . '</div><div class="alignright"><a href="javascript:void(0);" title="' . $wpss_txt2 . '" onClick="switchCookie(\'' . $path . '\',\'' . $label_enable . '\',\'' . $label_enabled . '\',\'' . $label_disable . '\',\'' . $label_disabled . '\');">' . $wpss_txt2 . '</a></div>';
echo $safesearch;
?>
