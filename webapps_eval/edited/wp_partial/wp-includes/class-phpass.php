<?php require_once('AspisMain.php'); ?><?php
class PasswordHash{var $itoa64;
var $iteration_count_log2;
var $portable_hashes;
var $random_state;
function PasswordHash ( $iteration_count_log2,$portable_hashes ) {
{$this->itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
if ( $iteration_count_log2 < 4 || $iteration_count_log2 > 31)
 $iteration_count_log2 = 8;
$this->iteration_count_log2 = $iteration_count_log2;
$this->portable_hashes = $portable_hashes;
$this->random_state = microtime() . (function_exists('getmypid') ? getmypid() : '') . uniqid(rand(),TRUE);
} }
function get_random_bytes ( $count ) {
{$output = '';
if ( ($fh = @fopen('/dev/urandom','rb')))
 {$output = fread($fh,$count);
fclose($fh);
}if ( strlen($output) < $count)
 {$output = '';
for ( $i = 0 ; $i < $count ; $i += 16 )
{$this->random_state = md5(microtime() . $this->random_state);
$output .= pack('H*',md5($this->random_state));
}$output = substr($output,0,$count);
}{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function encode64 ( $input,$count ) {
{$output = '';
$i = 0;
do {$value = ord($input[$i++]);
$output .= $this->itoa64[$value & 0x3f];
if ( $i < $count)
 $value |= ord($input[$i]) << 8;
$output .= $this->itoa64[($value >> 6) & 0x3f];
if ( $i++ >= $count)
 break ;
if ( $i < $count)
 $value |= ord($input[$i]) << 16;
$output .= $this->itoa64[($value >> 12) & 0x3f];
if ( $i++ >= $count)
 break ;
$output .= $this->itoa64[($value >> 18) & 0x3f];
}while ($i < $count )
;
{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function gensalt_private ( $input ) {
{$output = '$P$';
$output .= $this->itoa64[min($this->iteration_count_log2 + ((PHP_VERSION >= '5') ? 5 : 3),30)];
$output .= $this->encode64($input,6);
{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function crypt_private ( $password,$setting ) {
{$output = '*0';
if ( substr($setting,0,2) == $output)
 $output = '*1';
if ( substr($setting,0,3) != '$P$')
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}$count_log2 = strpos($this->itoa64,$setting[3]);
if ( $count_log2 < 7 || $count_log2 > 30)
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}$count = 1 << $count_log2;
$salt = substr($setting,4,8);
if ( strlen($salt) != 8)
 {$AspisRetTemp = $output;
return $AspisRetTemp;
}if ( PHP_VERSION >= '5')
 {$hash = md5($salt . $password,TRUE);
do {$hash = md5($hash . $password,TRUE);
}while (--$count )
;
}else 
{{$hash = pack('H*',md5($salt . $password));
do {$hash = pack('H*',md5($hash . $password));
}while (--$count )
;
}}$output = substr($setting,0,12);
$output .= $this->encode64($hash,16);
{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function gensalt_extended ( $input ) {
{$count_log2 = min($this->iteration_count_log2 + 8,24);
$count = (1 << $count_log2) - 1;
$output = '_';
$output .= $this->itoa64[$count & 0x3f];
$output .= $this->itoa64[($count >> 6) & 0x3f];
$output .= $this->itoa64[($count >> 12) & 0x3f];
$output .= $this->itoa64[($count >> 18) & 0x3f];
$output .= $this->encode64($input,3);
{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function gensalt_blowfish ( $input ) {
{$itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$output = '$2a$';
$output .= chr(ord('0') + $this->iteration_count_log2 / 10);
$output .= chr(ord('0') + $this->iteration_count_log2 % 10);
$output .= '$';
$i = 0;
do {$c1 = ord($input[$i++]);
$output .= $itoa64[$c1 >> 2];
$c1 = ($c1 & 0x03) << 4;
if ( $i >= 16)
 {$output .= $itoa64[$c1];
break ;
}$c2 = ord($input[$i++]);
$c1 |= $c2 >> 4;
$output .= $itoa64[$c1];
$c1 = ($c2 & 0x0f) << 2;
$c2 = ord($input[$i++]);
$c1 |= $c2 >> 6;
$output .= $itoa64[$c1];
$output .= $itoa64[$c2 & 0x3f];
}while (1 )
;
{$AspisRetTemp = $output;
return $AspisRetTemp;
}} }
function HashPassword ( $password ) {
{$random = '';
if ( CRYPT_BLOWFISH == 1 && !$this->portable_hashes)
 {$random = $this->get_random_bytes(16);
$hash = crypt($password,$this->gensalt_blowfish($random));
if ( strlen($hash) == 60)
 {$AspisRetTemp = $hash;
return $AspisRetTemp;
}}if ( CRYPT_EXT_DES == 1 && !$this->portable_hashes)
 {if ( strlen($random) < 3)
 $random = $this->get_random_bytes(3);
$hash = crypt($password,$this->gensalt_extended($random));
if ( strlen($hash) == 20)
 {$AspisRetTemp = $hash;
return $AspisRetTemp;
}}if ( strlen($random) < 6)
 $random = $this->get_random_bytes(6);
$hash = $this->crypt_private($password,$this->gensalt_private($random));
if ( strlen($hash) == 34)
 {$AspisRetTemp = $hash;
return $AspisRetTemp;
}{$AspisRetTemp = '*';
return $AspisRetTemp;
}} }
function CheckPassword ( $password,$stored_hash ) {
{$hash = $this->crypt_private($password,$stored_hash);
if ( $hash[0] == '*')
 $hash = crypt($password,$stored_hash);
{$AspisRetTemp = $hash == $stored_hash;
return $AspisRetTemp;
}} }
};
?>
<?php 