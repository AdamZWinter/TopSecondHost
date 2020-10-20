 <?php
//actionHeader.php
session_start();
if(!isset($_SESSION['sessionID'])) 
    { 
	session_destroy();
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.cookie_samesite', 'Strict');
        ini_set('session.use_trans_sid', 0);
        ini_set('session.hash_function', 'sha512');
        ini_set('session.sid_length', '64');
        session_start();

        $forhash=random_bytes(128);
        $hash = openssl_digest($forhash, "sha256");
        $sid = base64_encode($hash);
        $sid = str_replace('+', '', $sid);
        $sid = str_replace('/', '', $sid);
        $sid = substr($sid, 10, 64);
        $_SESSION['sessionID']=$sid;
        //session_id($sid);
    }

require('/var/www/secrets/conf.php');
 $datetime = date("U");

 date_default_timezone_set('America/Los_Angeles');   //TODO:  Customize variable

$session = bin2hex(random_bytes(16));   //initialized
$session = 'myInitializerErrorNoSession'.$session;

if (isset($_SESSION['sessionID'])){
$session = $_SESSION['sessionID'];
//$session = session_id();
}

 $obj = new stdClass();
     $obj->notice = 'This is not an error, we just have debugging enabled right now.  ';
     $obj->datetime = $datetime;
     $obj->dateread = date("D M j G:i:s T Y");
     $obj->message = 'Msg: ';
     $obj->error = 'none';
     $obj->displayname = 'initialized';

 $db = new mysqli('localhost', $dbuser, $userpw, $database);
 if (mysqli_connect_errno()) {
                             $obj->error = 'Error: Could not connect to database.';
                             echo json_encode($obj);
                             exit;
                             }else{
                             $obj->message = $obj->message.'Successfully connected to database.  ';
                             }

 //check session
 $email = bin2hex(random_bytes(64));   //initialized
 $authorized=FALSE;
 $checksession = bin2hex(random_bytes(64));   //initialized
 $displayname = 'initilaizer value';
 $query = "SELECT sessions.email, sessions.sessionid, users.displayname
           FROM sessions LEFT JOIN users
           USING (email)
           WHERE sessions.sessionid = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $session);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($emaildb, $sessiondb, $displaydb);
 if (mysqli_connect_errno()) {$obj->error = 'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $email = $emaildb;
             $checksession = $sessiondb; 
             $displayname = $displaydb; 
          }
                  if(strcmp($session, $checksession)==0){
                               $authorized=true;
                               $obj->message=$obj->message.'Authorized!  ';
                               $obj->email = $email;
                               $obj->displayname = $displayname;
                   }
     } elseif($stmt->num_rows == 0) {
          $obj->message=$obj->message.'Session not found.  ';
     } else {
          $obj->error = 'Database Error: Sessions not 1 or 0.  ';
         echo json_encode($obj);
         exit;
    }
}

?>



