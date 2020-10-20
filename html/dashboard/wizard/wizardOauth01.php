<?php
//dashboard/wizard/wizardOauth01.php
require('/var/www/html/authorizedHeader.php');
?>

<div class="row">
<div class="sectionleft col-1 row_height">
<p></p>
</div>


<div class="col-10 row_height content">
<!-- MENU -->
<div class="row authorized">
<?php
require('/var/www/html/dashboard/wizard/menu.php');
?>
</div>

<!-- Row 2 -->
<div class="row">
  <div class="col-1 mainGridBox bigScreen">
  </div>
  <div class="col-10 mainGridBox">

<?php
$publicEmail = '';
$publicEst = '';
$query = "SELECT public
           FROM calendars WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($publicdb);
 if (mysqli_connect_errno()) {$obj->error = $obj->error.'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $publicEmail = $publicdb;
          }
          if(strcmp($publicEmail, 'placeholder')!=0){
            $publicEst = $publicEmail;
            $publicEst = str_replace("@gmail.com", "", $publicEst);
            //$publicEst = 'TestingTesting';
          }
     }
 }

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<div class="row">

  <div class="col-6 bigScreen indexLeft">
  <img class="wizardScreenShot bigScreen" src="images/wizardOauth01.png">
  </div>

  <div class="col-6 indexRight">

  <p>

  Click this button to give GCBookings.com access to your new calendars:
  <br>
  <br>
  <a target="_blank" href="https://accounts.google.com/o/oauth2/v2/auth?access_type=offline&response_type=code&client_id=606034757588-osichf9dhmg6fnmhiiarjfsudlbi17a5.apps.googleusercontent.com&redirect_uri=https%3A//gcbookings.com/oauth/redirect.php&scope=https%3A//www.googleapis.com/auth/calendar">
  <img src="images/GoogleButton.png" />
  </a>
  <br>
  <br>
  Choose the new account you just created, and Allow the access that is requested.
  <br>
  <br>
  </p>
  <p id="result"></p>

  </div>

</div>

<div class="row">
<button onclick="validateEntry()" class="navButtonNext">Next</button>
<a class="bigScreen" style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<a class="navButtonNext" onclick="skip()">Skip</a>
<a class="bigScreen" style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<a class="navButtonBack" onclick="history.back()">Back</a>
</div>

<script>    
function validateEntry(){
        window.location.href = "wizardOauth02.php";
}

function skip(){
        window.location.href = "wizardOauth02b.php";
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

