
<?php
//signAction.php
//signin.php points at this page

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
require '/var/www/vendor/autoload.php';
require('/var/www/html/header.php');  //already requires conf
?>

<?php

//@ operator suppresses error messages so they are not shown
if(!($email=@$_POST["email"])){$obj->error = 'No email included.';echo json_encode($obj);exit;}
else {$email=$_POST["email"];}

if(!($password=@$_POST["password"])){$obj->message = 'No password included. ';}
else {$password=$_POST["password"];}

require('/var/www/html/classlib/pwhash.php');
$pwhash=pwhash::get64char($password);

//check email and password
$pwhashcheck = bin2hex(random_bytes(64));   //initialized
$pwmatches=FALSE;
$exists=FALSE;
$doemail=FALSE;
$verified=FALSE;

$query = "SELECT email, verified, pwhash
          FROM users WHERE email = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($emaildb, $verifieddb, $pwhashdb);
if (mysqli_connect_errno()) {$obj->error = 'Error: Could not SELECT';
                            echo json_encode($obj);
                            exit;}
else{
    if($stmt->num_rows == 1) {
        $exists=true;
         while($stmt->fetch()){
            $email = $emaildb;
            $pwhashcheck = $pwhashdb;
            $strv = $verifieddb;
            if(strcmp($strv, 'yes')==0){$verified=TRUE;}
         }
    } elseif($stmt->num_rows == 0) {
         $exists = FALSE;       
    } else {$obj->error = 'Database Error';}
}

if(strcmp($pwhash, $pwhashcheck)==0){
$pwmatches=TRUE;
$obj->pwmatches="true";
}

$initialize='no';
$code = bin2hex(random_bytes(16));   //initialized

require('/var/www/html/classlib/Code.php');
if (($exists && !$pwmatches) || ($exists && !$verified)){
    $code = Code::get16chars();
    $obj->code = $code;

    $doemail=TRUE;
    $query = "INSERT INTO codes VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $email, $code, $initialize);
    $stmt->execute();
    if($db ->affected_rows == 1){
                            $obj->message = $obj->message."Codes: 1 row affected.  ";
                            $doemail=true;
                            }else{
                            $obj->message = $obj->message."Failed to store code.  ";
                            $doemail=false;
                            }

 $query = 'DELETE FROM sessions WHERE email = ?';
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    if($db->affected_rows != 0){
                            $obj->message = $obj->message.'Session deleted.  ';
                            }else{
                            $obj->message = $obj->message.'Failed to log out.  You may not have been logged in.  ';
                            }
$_SESSION = array();
session_destroy();
}


if ($pwmatches && $verified){ 
    
    $query = 'DELETE FROM sessions WHERE email = ?';
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    if($db->affected_rows != 0){
                            $obj->message = $obj->message.'Session deleted.  ';
                            }else{
                            $obj->message = $obj->message.'Failed to log out.  You may not have been logged in.  ';
                            }
    
    $query = 'INSERT INTO sessions VALUES (?, ?, ?)';
    $stmt = $db->prepare($query);
    $stmt->bind_param('ssi', $email, $session, $datetime);
    $stmt->execute();
    if($db ->affected_rows == 1){
                            $obj->message = $obj->message."Sessions: 1 row affected.  ";
                            $authorized=true;
                            $_SESSION['sessionID']=$session;
                            }else{
                            $obj->message = $obj->message."Failed to store session.  ";
                            }

    $query = 'DELETE FROM codes WHERE email = ?';
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    if($db->affected_rows == 1){
                            $obj->message = $obj->message.'Codes: deleted.  ';
                            }else{
                            $obj->message = $obj->message.'Zero codes deleted  .  ';
                            }
 }

$msgout = 'Error---initializer value---';

if($doemail){

//No Reply address and name are configured in conf.php

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
$recipient = $email;
$link = $webRoot.'/verify.php?code='.$code;

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.us-west-2.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = 'SiteName Login';

// The plain-text body of the email
$bodyText =  'An attempt was made to sign into your account.  To sign in, please follow this link (or paste into address bar): '.$link. '  This link is one-time-use only.  No need to keep this email.';

// The HTML-formatted body of the email
$bodyHtml = '<h1>Sign In Here</h1>
    <p>An attempt was made to sign into your account.  To sign in, please follow this link (or paste into address bar): <a href="'.$link. '">'.$link. '</a>  This link is one-time-use only.  No need to keep this email.</p>';

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($noreply, $noreplyName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();
    echo "Email sent!" , PHP_EOL;
} catch (phpmailerException $e) {
    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
} catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}
}//end if doemail
  
/*
$link = 'https://gcbookings.com/verify.php?code='.$code;
$subject = 'Google Calendar Bookings at GCBookings.com';
$message = 'To sign in, please follow this link (or paste into address bar): '.$link. '  This link is one-time-use only.  No need to keep this email.';
$from="noreply@gcbookings.com";
$headers = 'From:'.$from;
mail($email,$subject,$message,$headers);
*/
    

$msgout='Credentials did not match records.  If the email address is in our records, a sign-in code was sent to your email address.  Please check your spam box.  Thank you.  ';     

if(!$exists){
$msgout='Credentials did not match records.  If the email address is in our records, a sign-in code was sent to your email address.  Please check your spam box.  Thank you.  ';     
}

if(!$authorized){echo $return2Login; require('/var/www/html/footer.php'); exit;}

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

    <script type="text/javascript">
    window.location.replace("/dashboard/session");
    </script>

<p>
<br>
<br>
</p>

<?php
require('footer.php');
?>

