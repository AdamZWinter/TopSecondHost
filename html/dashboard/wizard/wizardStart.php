<?php
//dashboard/wizard/wizardStart.php
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
<p class="indented">
Start by creating a separate Google account that GCBookings.com can make changes to, and that you can synchronize with your personal Google account.  This will create a firewall between GCBookings.com and your personal calendars.  This will also make it easier to share your booking calendar with others, while limiting what they have access to.
</p>
<p class="indented">
First, log out of Google if you are currently logged into the Google account that you usually use.
</p>
</div>

<div class="row">

  <div class="col-3 bigScreen indexLeft" style="margin: 10px;">
  <img class="wizardScreenShot bigScreen" src="images/signin.png">
  </div>

  <div class="col-3 bigScreen indexLeft" style="margin: 10px;">
  <img class="wizardScreenShot bigScreen" src="images/createAccount.png">
  </div>

  <div class="col-5 indexRight">
  <p>
  <br>  
  <br>
  In a separate browser tab from this one: 
  <br>  
  <br>
  Click the 'Sign in' button.
  <br>   
  <br>
  Then choose "Create account".
  </p>
  </div>

</div>

<div class="row">
  <a class="navButtonNext" href="wizard1.php">Next</a>
</div>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

