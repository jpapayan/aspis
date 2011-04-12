 <?php
$d = dir("/etc/php5");
//echo "Handle: " . $d->handle . "\n";
echo "Path: " . $d->path . "\n";
echo $d->read()."\n";
while (false !== ($entry = $d->read())) {
   echo $entry."\n";
}
$d->close();
?>

