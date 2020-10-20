<?php
// dashboard / checkSessionPost.php

session_start();
if(!isset($_SESSION['sessionID'])) 
    { 
        echo 'No session is set.  Please log out and sign in again.';
        exit;
    }

require('/var/www/gcbookings/conf.php');
 $datetime = date("U");
 date_default_timezone_set('America/Los_Angeles');                              //TODO:  Customize variable
 $docroot = @$_SERVER['DOCUMENT_ROOT'];
 $email = bin2hex(random_bytes(64));   //initialized
 $session = bin2hex(random_bytes(64));   //initialized

if (isset($_SESSION['sessionID'])){
$session = @$_SESSION['sessionID'];
}

 $obj = new stdClass();
     $obj->datetime = $datetime;
     $obj->dateread = date("D M j G:i:s T Y");
     $obj->message = 'Start Message: ';
     $obj->error = '?';

 $db = new mysqli('localhost', $dbuser, $userpw, $database);
 if (mysqli_connect_errno()) {
                             $obj->error = 'Error: Could not open database.';
                             echo json_encode($obj);
                             exit;
                             }else{
                             $obj->message = $obj->message.'Successfully opened database.  ';
                             }

 //check session
 $authorized=FALSE;
 $checksession = bin2hex(random_bytes(64));   //initialized
 $query = "SELECT email, sessionid
           FROM sessions WHERE sessionid = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $session);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($emaildb, $sessiondb);
 if (mysqli_connect_errno()) {$obj->error = $obj->error.'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $email = $emaildb;
             $checksession = $sessiondb;
          }
                  if(strcmp($session, $checksession)==0){
                               $authorized=TRUE;
                               $obj->message=$obj->message.'Authorized!  ';
                               $obj->email = $email;
                   }
     } elseif($stmt->num_rows == 0) {
          $obj->message=$obj->message.'Session not found.  Please log in again.  ';
          echo json_encode($obj);
          exit;
     } else {
          $obj->error = 'Database Error: Sessions not 1 or 0.  Please log out and log in again.  If problem persists, please contact administration.';
         echo json_encode($obj);
         exit;
    }
}

$return2Login = '
<p>
Your session has expired.  Please <a href="https://gcbookings.com/signin.php">sign in </a>again.
</p>
';

if(!$authorized){echo $return2Login; require('/var/www/html/dashboard/footer.php'); exit;}
?>
