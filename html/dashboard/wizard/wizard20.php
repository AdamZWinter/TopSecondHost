<?php
//dashboard/wizard20.php
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
  <img class="wizardScreenShot bigScreen" src="images/wizard20.png">
  </div>

  <div class="col-6 indexRight">
  <p>
  Through your Google account, you can now click and drag the entries to the times that you want.
  <br>
  <br>
  Notice the "~Resource:::Myself" in the entry.  There are three important things to know here:
  <br>
  <br>
  1) The value of Resource ("Myself") is how GCBookings keeps you from getting double-booked.  So, if your customers are only booking your personal time, then every Availability calendar entry should have "~Resource:::Myself".  This way no two customers can book you at the same time.  However, if you have multiple resources, like StudioA and StudioB (for example), and each having its own price and availability, then you will need separate calendar entries, each with their own Resource value ("~Resource:::StudioA" and "~Resource:::StudioB").  
  <br>
  <br>
  2) The squiggly line "~" is called a Tilde and located in the top left of your keyboard under the Esc button.  As shown, each of the values (Resource, Price, Tax, and Description) need to be bulletined with the tilde.  This way, GCBookings can interpret/understand the entry, and you can make new services, resources, and prices all from your Google calendar without having to log into GCBookings.com.
  <br>
  <br>
  3) The triple colon ":::" is used to pair a label with its value.  You must use exactly three colons between the label and its value.
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
        window.location.href = "wizard21.php";
}

function skip(){
        window.location.href = "wizard21.php";
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

