<?php
//dashboard/wizard6.php
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
  <img class="wizardScreenShot bigScreen" src="images/wizard6.png">
  </div>

  <div class="col-6 indexRight">
  <p class="indented">
  <br>
  <br>
  Under "Share with specific people" choose "Add people" and add your own personal gmail address that you usually use on a daily basis.
  <br>
  <br>
  Change "Permissions" to "Make changes and manage sharing".
  <br>
  <br>
  Then, click "Send".
  </p>
  <br>
  <br>
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
        window.location.href = "wizard7.php";
}

function skip(){
        window.location.href = "wizard7.php";
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

