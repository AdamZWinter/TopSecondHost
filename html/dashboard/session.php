
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
        <p class="adTitle">
        Welcome!
        </p>
	<br>
	<p>
        To the right, you will find utilities that you'll want to become familiar with, before you delete those links from this page.
        </p>
	 <p>
	These utilities can be dangerous, as they have access to your file system.  You will need to enable permission to use these in your permissions table.  You will also need to add your password hash to the conf.php file, as a second-factor authentication.
         </p>
         <p>
	Obviously, you should not use these tools or phpMyAdmin without SSL/HTTPS enabled.
         </p>



    </div>
    
  <div class="col-6 indexRight">
      <p class="adTitle">Utilities</p>
      <div class="row">
          <p>
          <a href="../utilities/fileExplorer.php">File Explorer</a>
          </p>
          <p>
          <a href="../utilities/editor.php">Code Editor</a>
          </p>
          <p>
          <a href="../utilities/uploadEditor.php">File Uploads</a>
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



