<?php
function wpss_getcookie($key) {
    echo "gettcoockie<br>";
    if (isset($_COOKIE["$key"])) return $_COOKIE["$key"];
    else return false;
}

function wpss_setcookie($key, $str, $expire) {
    return setcookie("$key", $str, $expire, '/', str_replace('www','',$_SERVER['SERVER_NAME']) );
}
function is_ajax() {
    return array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER);
}
?>
