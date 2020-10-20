<?php
//dashboard/terms.php
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
<script>
document.getElementById("terms").className = "dashboardMenu left current";
</script>

</div>

<!-- Row 1 -->
<div class="row">
  <div class="col-1 mainGridBox bigScreen">
  </div>
  <div class="col-10 mainGridBox">
  <p class="adTitle">Terms and Conditions</p>
  <p>Enter the terms and conditions that your customers must agree to when making a booking.  You can use HTML for formatting.</p>
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

$terms='';
$query = "SELECT terms
           FROM blobs
           WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($termsdb);
 if (mysqli_connect_errno()) {$obj->error = 'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $terms = $termsdb;
          }
     } elseif($stmt->num_rows == 0) {
          $obj->message=$obj->message.'Not found, no match.  ';
     } else {
          $obj->error = 'Database Error: Sessions not 1 or 0.  ';
         echo json_encode($obj);
         exit;
    }
}

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<textarea id="editarea" style="width: 100%;" rows="30">
<?php echo $terms; ?>
</textarea>
<br>
<button onclick="update();" class="buttonSignIn">Update</button>
<a id="success">...</a>     
<script>

function update() {
  var terms = encodeURIComponent(document.getElementById("editarea").value);

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("success").innerHTML = this.responseText;
      setTimeout(function(){document.getElementById("success").innerHTML = "..";}, 5000);
    }
  };
  http.open("POST", "writeTerms.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send("terms="+terms);
}

</script>




<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

