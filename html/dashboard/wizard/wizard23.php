<?php
//dashboard/wizard23.php
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
  <img class="wizardScreenShot bigScreen" src="images/wizard23.png">
  </div>

  <div class="col-6 indexRight">
  <p>
  <br>
  <br>
  As you would expect, two entries with the same Resource during the same time, will both be available to your customers, until one of the two is booked.  Then the other will no longer be available.
  <br>
  <br>
  </p>
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
        window.location.href = "wizard24.php";
}

function skip(){
        window.location.href = "wizard24.php";
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

