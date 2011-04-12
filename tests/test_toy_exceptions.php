<?php
define("me",3);
echo me."\n" ;

try {
    //TODO: new must be rewritten to give arrays
    //TODO: arguments to builtin fuctions must be dereferenced
   throw new Exception("Fake Exception");
}
catch (Exception $e) {
    echo "Cought Exception:\n";
}
catch (Exception2 $e) {
    echo "Cought Exception2:\n";
}

?>