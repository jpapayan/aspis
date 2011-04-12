<?php
$time = round(microtime(true), 6);

header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() - 3600));
require("credentials.php");

$username="root";
$password="pass2rule@ll8";
$database="tuberun";
$query="SELECT updated, 
bakerloo_short, bakerloo_long, 
central_short, central_long,
circle_short, circle_long,
district_short, district_long,
hammersmithandcity_short, hammersmithandcity_long,
jubilee_short, jubilee_long,
metropolitan_short, metropolitan_long,
northern_short, northern_long,
piccadilly_short, piccadilly_long,
victoria_short, victoria_long,
waterlooandcity_short, waterlooandcity_long,
dlr_short, dlr_long,
overground_short, overground_long
FROM tuberun.statuses_now
WHERE updated=(SELECT MAX(updated) FROM tuberun.statuses_now)";

echo "This is the Tube status on:\n";
mysql_connect("localhost",$username,$password);
mysql_select_db($database) or die( "Unable to select database");
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);
echo $row["updated"]."<br>";

$lines=array("bakerloo", "central", "circle", "district", "hammersmithandcity", "jubilee", "metropolitan", "northern", "piccadilly", "victoria", "waterlooandcity", "dlr", "overground");
echo count($lines);
foreach ($lines as $line) {
   echo '<br>'.$line;
   echo "<br><h3 class=\"".$line." ltn-name\">";
   if ($row[$line."_short"]==="Good service") {
      echo "<div class=\"status\">Good service</div></li>";
   }
   else {
        echo '<div class="status problem"> 
		<h4 class="ltn-title">'.$row[$line.'_short'].'</h4> 
        <div class="message">'.$row[$line.'_long'].'<Astupid ></div> </div></li>';    
   }
}

$time2 = round(microtime(true), 6);
$generation = round(($time2 - $time)*1000,3);
$f=@file_get_contents("stats.txt");
if ($f==false) $all_results=array();
else $all_results=unserialize($f);
$all_results[]=$generation;
file_put_contents("stats.txt",serialize($all_results));
echo "This page took $generation ms to render";



?>
