<?php require_once('AspisMain.php'); ?><?php
class PasswordHash{var $itoa64;
var $iteration_count_log2;
var $portable_hashes;
var $random_state;
function PasswordHash ( $iteration_count_log2,$portable_hashes ) {
{$this->itoa64 = array('./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',false);
if ( (($iteration_count_log2[0] < (4)) || ($iteration_count_log2[0] > (31))))
 $iteration_count_log2 = array(8,false);
$this->iteration_count_log2 = $iteration_count_log2;
$this->portable_hashes = $portable_hashes;
$this->random_state = concat(concat(attAspisRC(microtime()),(function_exists(('getmypid')) ? array(getmypid(),false) : array('',false))),attAspis(uniqid(deAspisRC(attAspis(rand())),TRUE)));
} }
function get_random_bytes ( $count ) {
{$output = array('',false);
if ( deAspis(($fh = @attAspis(fopen(('/dev/urandom'),('rb'))))))
 {$output = attAspis(fread($fh[0],$count[0]));
fclose($fh[0]);
}if ( (strlen($output[0]) < $count[0]))
 {$output = array('',false);
for ( $i = array(0,false) ; ($i[0] < $count[0]) ; $i = array((16) + $i[0],false) )
{$this->random_state = attAspis(md5((deconcat(attAspisRC(microtime()),$this->random_state))));
$output = concat($output,attAspis(pack(('H*'),deAspisRC(attAspis(md5($this->random_state[0]))))));
}$output = Aspis_substr($output,array(0,false),$count);
}return $output;
} }
function encode64 ( $input,$count ) {
{$output = array('',false);
$i = array(0,false);
do {$value = attAspis(ord(deAspis(attachAspis($input,deAspis(postincr($i))))));
$output = concat($output,$this->itoa64[0][($value[0] & (0x3f))]);
if ( ($i[0] < $count[0]))
 $value = array($value[0] | (ord(deAspis(attachAspis($input,$i[0]))) << (8)),false);
$output = concat($output,$this->itoa64[0][(($value[0] >> (6)) & (0x3f))]);
if ( (deAspis(postincr($i)) >= $count[0]))
 break ;
if ( ($i[0] < $count[0]))
 $value = array($value[0] | (ord(deAspis(attachAspis($input,$i[0]))) << (16)),false);
$output = concat($output,$this->itoa64[0][(($value[0] >> (12)) & (0x3f))]);
if ( (deAspis(postincr($i)) >= $count[0]))
 break ;
$output = concat($output,$this->itoa64[0][(($value[0] >> (18)) & (0x3f))]);
}while (($i[0] < $count[0]) )
;
return $output;
} }
function gensalt_private ( $input ) {
{$output = array('$P$',false);
$output = concat($output,$this->itoa64[0][deAspis(attAspisRC(min(deAspisRC(array($this->iteration_count_log2[0] + ((PHP_VERSION >= ('5')) ? (5) : (3)),false)),30)))]);
$output = concat($output,$this->encode64($input,array(6,false)));
return $output;
} }
function crypt_private ( $password,$setting ) {
{$output = array('*0',false);
if ( (deAspis(Aspis_substr($setting,array(0,false),array(2,false))) == $output[0]))
 $output = array('*1',false);
if ( (deAspis(Aspis_substr($setting,array(0,false),array(3,false))) != ('$P$')))
 return $output;
$count_log2 = attAspis(strpos($this->itoa64[0],deAspisRC(attachAspis($setting,(3)))));
if ( (($count_log2[0] < (7)) || ($count_log2[0] > (30))))
 return $output;
$count = array((1) << $count_log2[0],false);
$salt = Aspis_substr($setting,array(4,false),array(8,false));
if ( (strlen($salt[0]) != (8)))
 return $output;
if ( (PHP_VERSION >= ('5')))
 {$hash = attAspis(md5((deconcat($salt,$password)),TRUE));
do {$hash = attAspis(md5((deconcat($hash,$password)),TRUE));
}while (deAspis(predecr($count)) )
;
}else 
{{$hash = attAspis(pack(('H*'),deAspisRC(attAspis(md5((deconcat($salt,$password)))))));
do {$hash = attAspis(pack(('H*'),deAspisRC(attAspis(md5((deconcat($hash,$password)))))));
}while (deAspis(predecr($count)) )
;
}}$output = Aspis_substr($setting,array(0,false),array(12,false));
$output = concat($output,$this->encode64($hash,array(16,false)));
return $output;
} }
function gensalt_extended ( $input ) {
{$count_log2 = attAspisRC(min(deAspisRC(array($this->iteration_count_log2[0] + (8),false)),24));
$count = array(((1) << $count_log2[0]) - (1),false);
$output = array('_',false);
$output = concat($output,$this->itoa64[0][($count[0] & (0x3f))]);
$output = concat($output,$this->itoa64[0][(($count[0] >> (6)) & (0x3f))]);
$output = concat($output,$this->itoa64[0][(($count[0] >> (12)) & (0x3f))]);
$output = concat($output,$this->itoa64[0][(($count[0] >> (18)) & (0x3f))]);
$output = concat($output,$this->encode64($input,array(3,false)));
return $output;
} }
function gensalt_blowfish ( $input ) {
{$itoa64 = array('./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',false);
$output = array('$2a$',false);
$output = concat($output,attAspis(chr((ord(('0')) + ($this->iteration_count_log2[0] / (10))))));
$output = concat($output,attAspis(chr((ord(('0')) + ($this->iteration_count_log2[0] % (10))))));
$output = concat2($output,'$');
$i = array(0,false);
do {$c1 = attAspis(ord(deAspis(attachAspis($input,deAspis(postincr($i))))));
$output = concat($output,attachAspis($itoa64,($c1[0] >> (2))));
$c1 = array(($c1[0] & (0x03)) << (4),false);
if ( ($i[0] >= (16)))
 {$output = concat($output,attachAspis($itoa64,$c1[0]));
break ;
}$c2 = attAspis(ord(deAspis(attachAspis($input,deAspis(postincr($i))))));
$c1 = array($c1[0] | ($c2[0] >> (4)),false);
$output = concat($output,attachAspis($itoa64,$c1[0]));
$c1 = array(($c2[0] & (0x0f)) << (2),false);
$c2 = attAspis(ord(deAspis(attachAspis($input,deAspis(postincr($i))))));
$c1 = array($c1[0] | ($c2[0] >> (6)),false);
$output = concat($output,attachAspis($itoa64,$c1[0]));
$output = concat($output,attachAspis($itoa64,($c2[0] & (0x3f))));
}while ((1) )
;
return $output;
} }
function HashPassword ( $password ) {
{$random = array('',false);
if ( ((CRYPT_BLOWFISH == (1)) && (denot_boolean($this->portable_hashes))))
 {$random = $this->get_random_bytes(array(16,false));
$hash = Aspis_crypt($password,$this->gensalt_blowfish($random));
if ( (strlen($hash[0]) == (60)))
 return $hash;
}if ( ((CRYPT_EXT_DES == (1)) && (denot_boolean($this->portable_hashes))))
 {if ( (strlen($random[0]) < (3)))
 $random = $this->get_random_bytes(array(3,false));
$hash = Aspis_crypt($password,$this->gensalt_extended($random));
if ( (strlen($hash[0]) == (20)))
 return $hash;
}if ( (strlen($random[0]) < (6)))
 $random = $this->get_random_bytes(array(6,false));
$hash = $this->crypt_private($password,$this->gensalt_private($random));
if ( (strlen($hash[0]) == (34)))
 return $hash;
return array('*',false);
} }
function CheckPassword ( $password,$stored_hash ) {
{$hash = $this->crypt_private($password,$stored_hash);
if ( (deAspis(attachAspis($hash,(0))) == ('*')))
 $hash = Aspis_crypt($password,$stored_hash);
return array($hash[0] == $stored_hash[0],false);
} }
};
?>
<?php 