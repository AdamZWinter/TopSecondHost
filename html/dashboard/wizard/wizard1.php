<?php
//dashboard/settings.php
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
  <img class="wizardScreenShot bigScreen" src="images/wizard1.png">
  </div>

  <div class="col-6 indexRight">
  <p class="indented">
  Choose a new Gmail address.  Do not use your current email address instead.
  </p>
  <p class="indented">
  Continue through the process of creating a new account by verifying your phone number.  Skip the additional options, and agree to the terms of service.
  </p>
  <br>
  <br>
  <p>
  Enter the new email address you just created here:
  <br>
  <input type="text" name="public" id="public" style="width:60%;" value="<?php echo $publicEst; ?>" placeholder="GCBookingsExampleAccount"/>@gmail.com
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
  var publiccal = encodeURIComponent(document.getElementById("public").value);
  if (!publiccal || 0 === publiccal.length){
     document.getElementById("result").innerHTML = 'Nothing entered.  Please, enter the new Gmail address.';
  }else{
    storePublic();
  }
}

function storePublic() {
      var publiccal = encodeURIComponent(document.getElementById("public").value);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      
      if (this.responseText == "Updated"){
          window.location.href = "wizardOauth01.php";
      }else{
          document.getElementById("result").innerHTML = this.responseText;
      }  

    }else{
      window.setTimeout(failed, 3000);
    }
  };
  xhttp.open("POST", "storePublic.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("public="+publiccal+"@gmail.com");
}

function failed(){
      document.getElementById("result").innerHTML = 'Connection Failed.';
}

function skip(){
        window.location.href = "wizardOauth01.php";
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

