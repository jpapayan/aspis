<?php require_once('AspisMain.php'); ?><?php
$time = attAspis(round(deAspis(attAspisRC(microtime(true))),(6)));
header((deconcat1('Expires: ',attAspis(gmdate(('D, d M Y H:i:s \G\M\T'),(time() - (3600)))))));
require ("credentials.php");
$username = array("root",false);
$password = array("pass2rule@ll8",false);
$database = array("tuberun",false);
$query = array("SELECT updated, 
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
WHERE updated=(SELECT MAX(updated) FROM tuberun.statuses_now)",false);
echo AspisCheckPrint(array("This is the Tube status on:\n",false));
mysql_connect(("localhost"),$username[0],$password[0]);
mysql_select_db($database[0]) or deAspis(Aspis_exit(array("Unable to select database",false)));
$result = attAspis(mysql_query($query[0]));
$row = attAspisRC(mysql_fetch_assoc($result[0]));
echo AspisCheckPrint(concat2($row[0]["updated"],"<br>"));
$lines = array(array(array("bakerloo",false),array("central",false),array("circle",false),array("district",false),array("hammersmithandcity",false),array("jubilee",false),array("metropolitan",false),array("northern",false),array("piccadilly",false),array("victoria",false),array("waterlooandcity",false),array("dlr",false),array("overground",false)),false);
echo AspisCheckPrint(attAspis(count($lines[0])));
foreach ( $lines[0] as $line  )
{echo AspisCheckPrint(concat1('<br>',$line));
echo AspisCheckPrint(concat2(concat1("<br><h3 class=\"",$line)," ltn-name\">"));
if ( (deAspis(attachAspis($row,(deconcat2($line,"_short")))) === ("Good service")))
 {echo AspisCheckPrint(array("<div class=\"status\">Good service</div></li>",false));
}else 
{{echo AspisCheckPrint(concat2(concat(concat2(concat1('<div class="status problem"> 
		<h4 class="ltn-title">',attachAspis($row,(deconcat2($line,'_short')))),'</h4> 
        <div class="message">'),attachAspis($row,(deconcat2($line,'_long')))),'<Astupid ></div> </div></li>'));
}}}$time2 = attAspis(round(deAspis(attAspisRC(microtime(true))),(6)));
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