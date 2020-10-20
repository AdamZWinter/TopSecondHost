
<?php
//dashboard/session.php
require('/var/www/html/authorizedHeader.php');
?>

<div class="row">
<div class="sectionleft col-1 row_height">
<p></p>
</div>


<div class="col-10 row_height content">
<!-- MENU -->
<div class="row authorized" id="divMenu">

<?php
require('/var/www/html/dashboard/menu.php');
?>

</div>

<!-- Row 1 -->
<div class="row">
  <div class="col-1 mainGridBox bigScreen">
  </div>
  <div class="col-10 mainGridBox bigScreen">
  </div>
  <div class="col-1 mainGridBox bigScreen">
  </div>
</div>

<!-- Row 2 -->
<div class="row">
  <div class="col-1 mainGridBox bigScreen">
  </div>
  <div class="col-10 mainGridBox">

<?php

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<div id="divActive" class="row">
    
    <div class="col-6 indexRight">
        <p>
        Welcome.
        </p>
    </div>
    
  <div class="col-6 indexRight">
      <p class="adTitle">TopSecondHost</p>
      <div class="row">
          <p>
          host.second.top
          </p>
      </div>
      <div class="row">
          <p>
          </p>
      </div>
      <div class="row">
          <p>
          </p>
      </div>
      <div class="row">
          <p>
          </p>
      </div>
      <div class="row">
          <p>
          </p>
      </div>
      <div class="row">
          <p>
          </p>
      </div>
      <br>
  </div>
    
</div>


     


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/footer.php');
?>



