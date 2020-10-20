<?php
//dashboard/wizard25.php
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

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<div class="row">

  <div class="col-6 bigScreen indexLeft">
  <img class="wizardScreenShot bigScreen" src="images/checkeredFlag.jpg">
  </div>

  <div class="col-6 indexRight">
  <p>
  Last step!  Clicking "Finish" will activate your calendar service.  Once you do, any changes you make to your Availability or Bookings calendars will automatically show up on your Public calendar (usually in 30 seconds or less).  
<br>
<br>
Remember to only make changes to your Availability and Booking calendars, NOT your Public calendar.  Changes made to your Public calendar will not be recognized by the GCBookings.com service, and then overwritten/undone the next time it updates your calendars. 
  </p>
<br>
<br>
  <p id="result" style="float: right;"></p>
  </div>

</div>

<div class="row">
<button onclick="refreshPublic()" class="navButtonNext">Finish</button>
<a class="bigScreen" style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<a class="bigScreen" style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<a class="bigScreen" style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<a class="navButtonBack" onclick="history.back()">Back</a>
</div>

<script>  
var fail = true;
function refreshPublic(){
  document.getElementById("result").innerHTML = "Processing...&nbsp;&nbsp;&nbsp;&nbsp;";
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
         // document.getElementById("result").innerHTML = this.responseText;
        var success = JSON.parse(this.responseText);
        if(success){window.location.href = "../session.php";}
        else{document.getElementById("result").innerHTML = this.responseText + 'Failed to activate. Please check your entries.  Contact support if problem persists.';}
          fail = false;
    }else{
      window.setTimeout(failed, 10000);
      }
  };
  xhttp.open("POST", "activate.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("email=useSession");
}

function failed(){
      if(fail){document.getElementById("result").innerHTML = 'Connection Failed.';}
}
  
function validateEntry(){
        window.location.href = "../session.php";
}


</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

