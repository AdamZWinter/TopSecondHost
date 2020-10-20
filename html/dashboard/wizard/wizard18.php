<?php
//dashboard/wizard18.php
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

$paypalEmail = '';
$paypalEst = '';
$query = "SELECT paypal
           FROM users WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($paypaldb);
 if (mysqli_connect_errno()) {$obj->error = $obj->error.'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $paypalEmail = $paypaldb;
          }
          if(strcmp($paypalEmail, 'placeholder')!=0){
            $paypalEst = $paypalEmail;
          }
     }
 }

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<div class="row">

  <div class="col-6 bigScreen indexLeft">
  <img class="wizardScreenShot bigScreen" src="images/wizard18.png">
  </div>

  <div class="col-6 indexRight">
  <p class="indented">
  <br>
  <br>
  <br>
  <br>
  Enter the email address attached to your Paypal account here:
  <br>
  <br>
  <input type="text" name="paypal" id="paypal" style="width:100%;" value="<?php echo $paypalEst; ?>" placeholder="paypalEmail@example.com"/>
  </p>
  <br>
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
  var paypal = encodeURIComponent(document.getElementById("paypal").value);
  if (!paypal || 0 === paypal.length){
     document.getElementById("result").innerHTML = 'Nothing entered.  Please, enter your Paypal email address.';
  }else{
    storePaypal();
  }
}

function storePaypal() {
      var paypal = encodeURIComponent(document.getElementById("paypal").value);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      
      if (this.responseText == "Updated"){
          window.location.href = "wizard19.php";
      }else{
          document.getElementById("result").innerHTML = this.responseText;
      }  

    }else{
      window.setTimeout(failed, 3000);
    }
  };
  xhttp.open("POST", "storePaypal.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("paypal="+paypal);
}

function failed(){
      document.getElementById("result").innerHTML = 'Connection Failed.';
}

function skip(){
        window.location.href = "wizard19.php";
}

</script>



<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

