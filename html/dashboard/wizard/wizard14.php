<?php
//dashboard/wizard14.php
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

$availableEmail = '';
$availableEst = '';
$query = "SELECT available
           FROM calendars WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($availabledb);
 if (mysqli_connect_errno()) {$obj->error = $obj->error.'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $availableEmail = $availabledb;
          }
          if(strcmp($availableEmail, 'placeholder')!=0){
            $availableEst = $availableEmail;
            $availableEst = str_replace("@gmail.com", "", $availableEst);
          }
     }
 }

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<div class="row">

  <div class="col-6 bigScreen indexLeft">
  <img class="wizardScreenShot bigScreen" src="images/wizard14.png">
  </div>

  <div class="col-6 indexRight">
  <p class="indented">
  <br>
  <br>
  You may need to refresh your browser page for the new calendar to show up in the side bar.
  <br>
  <br>
  Choose the Availability calendar in Settings.  Scroll down to "Integrate Calendar".
  <br>
  <br>
  Highlight the Calendar ID, copy, and paste it into the box below:
  <br>
  <input type="text" name="available" id="available" style="width:100%;" value="<?php echo $availableEst; ?>" placeholder="lettersandnumbers@include.this.part.yes"/>
  <input type="text" style="display: none;" name="current" id="current" style="width:100%;" value="<?php echo $availableEst; ?>" />
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
  document.getElementById("result").innerHTML = "Loading....";
  var availablecal = encodeURIComponent(document.getElementById("available").value);
  var current = encodeURIComponent(document.getElementById("current").value);
  if (!availablecal || 0 === availablecal.length){
     document.getElementById("result").innerHTML = 'Nothing entered.  Please, enter the new Calendar ID';
  }else if(availablecal == current && 0 != availablecal.length){
     document.getElementById("result").innerHTML = 'No change.  Choose "Skip" to keep the current value.';
  }
  else{
    storeAvailable();
  }
}

function storeAvailable() {
      var fail = true;
      var availablecal = encodeURIComponent(document.getElementById("available").value);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var fail = false;
      if (this.responseText == "Updated"){
          window.location.href = "wizard15.php";
      }else{
          document.getElementById("result").innerHTML = this.responseText;
          //document.getElementById("result").innerHTML = "Test not updated";
      }  

    }else{
      window.setTimeout(failed(fail), 6000);
    }
  };
  xhttp.open("POST", "storeAvailable.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("available="+availablecal);
}

function failed(fail){
      if(fail){
          document.getElementById("result").innerHTML = 'Connection Failed.';
      }
}

function skip(){
        window.location.href = "wizard15.php";
}

</script>

<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

