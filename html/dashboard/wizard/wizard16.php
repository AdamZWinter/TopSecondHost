<?php
//dashboard/wizard16.php
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

$bookingsEmail = '';
$bookingsEst = '';
$query = "SELECT bookings
           FROM calendars WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($bookingsdb);
 if (mysqli_connect_errno()) {$obj->error = $obj->error.'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $bookingsEmail = $bookingsdb;
          }
          if(strcmp($bookingsEmail, 'placeholder')!=0){
            $bookingsEst = $bookingsEmail;
          }
     }
 }

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<div class="row">

  <div class="col-6 bigScreen indexLeft">
  <img class="wizardScreenShot bigScreen" src="images/wizard6.png">
  </div>

  <div class="col-6 indexRight">
  <p class="indented">
  <br>
  <br>
  Repeat the previous steps to create the final calendar.  Name it "Bookings".
  <br>
  <br>
  Paste the Calendar ID for your Bookings calendar here:
  <br>
  <input type="text" name="bookings" id="bookings" style="width:100%;" value="<?php echo $bookingsEst; ?>" placeholder="lettersandnumbers@include.this.part.yes"/>
  <input type="text" style="display: none;" name="current" id="current" style="width:100%;" value="<?php echo $bookingsEst; ?>" />
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
  var bookingscal = encodeURIComponent(document.getElementById("bookings").value);
  var current = encodeURIComponent(document.getElementById("current").value);
  if (!bookingscal || 0 === bookingscal.length){
     document.getElementById("result").innerHTML = 'Nothing entered.  Please, enter the new Calendar ID';
  }else if(bookingscal == current && 0 != bookingscal.length){
     document.getElementById("result").innerHTML = 'No change.  Choose "Skip" to keep the current value.';
  }
  else{
    storeBookings();
  }
}

function storeBookings() {
      var fail = true;
      var bookingscal = encodeURIComponent(document.getElementById("bookings").value);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var fail = false;
      if (this.responseText == "Updated"){
          window.location.href = "wizard17.php";
      }else{
          document.getElementById("result").innerHTML = this.responseText;
      }  

    }else{
      window.setTimeout(failed(fail), 5000);
    }
  };
  xhttp.open("POST", "storeBookings.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("bookings="+bookingscal);
}

function failed(fail){
      if(fail){
          document.getElementById("result").innerHTML = 'Connection Failed.';
      }
}

function skip(){
        window.location.href = "wizard17.php";
}

</script>



<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

