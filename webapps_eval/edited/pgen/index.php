<?php require_once('AspisMain.php'); ?><?php
$time = attAspis(round(deAspis(attAspisRC(microtime(true))),(6)));
$n = array(2000,false);
if ( ((isset($_GET[0][('n')]) && Aspis_isset( $_GET [0][('n')]))))
 $n = int_cast($_GET[0]['n']);
if ( (($n[0] < (1)) || ($n[0] > (2000))))
 Aspis_exit(array("Cannot use the n number you selected, please try another one",false));
$results = array(array(),false);
for ( $c = array(1,false) ; ($c[0] < $n[0]) ; postincr($c) )
{$is_prime = array(true,false);
for ( $i = array(2,false) ; ($i[0] <= ($c[0] / (2))) ; postincr($i) )
{if ( (($c[0] % $i[0]) == (0)))
 {$is_prime = array(false,false);
break ;
}}if ( $is_prime[0])
 arrayAssignAdd($results[0][],addTaint($c));
}echo AspisCheckPrint(array("The primes generated are: <br>\n",false));
foreach ( $results[0] as $res  )
echo AspisCheckPrint(concat2($res,"<br>\n"));
echo AspisCheckPrint(array("please try again, byebye!<br>\n",false));
$time2 = attAspis(round(deAspis(attAspisRC(microtime(true))),(6)));
$generation = attAspis(round((($time2[0] - $time[0]) * (1000)),(3)));
$f = @attAspis(file_get_contents(("stats.txt")));
if ( ($f[0] == false))
 $all_results = array(array(),false);
else 
{$all_results = Aspis_unserialize($f);
}arrayAssignAdd($all_results[0][],addTaint($generation));
file_put_contents("stats.txt",deAspisRC(Aspis_serialize($all_results)));
echo AspisCheckPrint(concat2(concat1("This page took ",$generation)," ms to render"));
;
?>
<?php 