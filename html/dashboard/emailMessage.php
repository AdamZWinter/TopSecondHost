<?php
//dashboard/emailMessage.php
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
document.getElementById("emailMessage").className = "dashboardMenu left current";
</script>

</div>

<!-- Row 1 -->
<div class="row">
  <div class="col-1 mainGridBox bigScreen">
  </div>
  <div class="col-10 mainGridBox">
  <p class="adTitle">Confirmation Emails</p>
  <p>Confirmations emails and reminders will automatically include the details of the booking.  Enter additional information that you want included in your confirmation emails and reminders.  You can use HTML for formatting.</p>
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

$emailMessage='';
$query = "SELECT emailMessage
           FROM blobs
           WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($emailMessagedb);
 if (mysqli_connect_errno()) {$obj->error = 'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $emailMessage = $emailMessagedb;
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
<?php echo $emailMessage; ?>    
</textarea>
<br>
<button onclick="update();" class="buttonSignIn">Update</button>
<a id="success">...</a>     
<script>

function update() {
  var emailMessage = encodeURIComponent(document.getElementById("editarea").value);

  var http = new XMLHttpRequest();
  http.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("success").innerHTML = this.responseText;
      setTimeout(function(){document.getElementById("success").innerHTML = "..";}, 5000);
    }
  };
  http.open("POST", "writeEmailMessage.php", true);
  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http.send("emailMessage="+emailMessage);
}

</script>



<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

