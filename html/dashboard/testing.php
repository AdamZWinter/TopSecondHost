<?php

if(!($code=@$_GET["code"])){echo 'code was not accessible in GET';exit;}
else {$code=$_GET["code"];}

echo 'Success, code is: '.$code;

?>