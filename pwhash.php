<?php


require('./html/classlib/pwhash.php');

$hash = pwhash::get64char($argv[1]);

echo $hash;


?>
