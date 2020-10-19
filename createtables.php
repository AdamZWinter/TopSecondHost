<?php

$date = date('U');

echo '\nThis is the date: '.$date;

require('/var/www/secrets/conf.php');

echo 'Trying database';
$db = new mysqli('localhost', $dbuser, $userpw, $database);
if (mysqli_connect_errno()) {
                             echo '\nError: Could not connect to database.';
                             exit;
                             }else{
                             echo '\nSuccessfully connected to database.';
                             }

$query= "CREATE TABLE users (
email VARCHAR(64) NOT NULL PRIMARY KEY,
verified VARCHAR(8) NOT NULL,
pwhash VARCHAR(64) NOT NULL,
regdate INT(64) NOT NULL,
displayname VARCHAR(64) NOT NULL,
dateread VARCHAR(64) NOT NULL
)";
$stmt = $db->prepare($query);
$stmt->execute();

$query= "CREATE TABLE sessions (
email VARCHAR(64) NOT NULL PRIMARY KEY,
sessionid VARCHAR(256) NOT NULL,
datetime INT(32) NOT NULL
)";
$stmt = $db->prepare($query);
$stmt->execute();

$query= "CREATE TABLE privileges (
email VARCHAR(64) NOT NULL PRIMARY KEY,
utilities TINYINT(1) NOT NULL
)";
$stmt = $db->prepare($query);
$stmt->execute();

$query= "CREATE TABLE codes (
email VARCHAR(64) NOT NULL,
code VARCHAR(64) NOT NULL PRIMARY KEY,
initialize VARCHAR(8) NOT NULL
)";
$stmt = $db->prepare($query);
$stmt->execute();


$db->close();



echo '\nTables created?  Check on phpMyAdmin.';

?>
