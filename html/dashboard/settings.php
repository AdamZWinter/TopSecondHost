<?php
//dashboard/settings.php
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
document.getElementById("settings").className = "dashboardMenu left current";
</script>

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

$query = "SELECT displayname, paypal, notify, available, bookings, public
           FROM users LEFT JOIN calendars
           USING (email)
           WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($displaynamedb, $paypaldb, $notifydb, $availabledb, $bookingsdb, $publicdb);
 if (mysqli_connect_errno()) {$obj->error = $obj->error.'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
              $obj->displayname = $displaynamedb;
              $obj->paypal = $paypaldb;
              $obj->notify = $notifydb;
              $obj->availableID = $availabledb;
              $obj->bookingsID = $bookingsdb;
              $obj->publicID = $publicdb;
          } //end while
     } //end if
 } //end else



//----------------------------------- Start Authorized Content ----------------------------------------------------
?>


<p>
    <div class="row">
    <label for="displayname">Display Name: </label>
    <a class="right" id="displaynameResult"></a>
    <button onclick="displaynameUpdate()" class="buttonSignIn right">Update</button>
    <input type="text" class="right" name="displayname" id="displayname" style="width:67%;" value="<?php echo $obj->displayname; ?>" />
    </div>
<br>
    <div class="row">
    <label for="paypal">Paypal Payment to: </label>
    <a class="right" id="paypalResult"></a>
    <button onclick="paypalUpdate()" class="buttonSignIn right">Update</button>
    <input type="text" class="right" name="paypal" id="paypal" style="width:67%;" value="<?php echo $obj->paypal; ?>" />
    </div>
<br>   
    <div class="row">
    <label for="notify">Booking Notifications to: </label>
    <a id="notifyResult"></a>
    <button onclick="notifyUpdate()" class="buttonSignIn right">Update</button>
    <input type="text" class="right" name="notify" id="notify" style="width:67%;" value="<?php echo $obj->notify; ?>" />
    </div>
<br>      
    <div class="row">
    <label for="available">Available Calender ID: </label>
    <a class="right" id="availableResult"></a>
    <button onclick="availableUpdate()" class="buttonSignIn right">Update</button>
    <input type="text" class="right" name="available" id="available" style="width:67%;" value="<?php echo $obj->availableID; ?>" />
    </div>      
<br>  
    <div class="row"> 
    <label for="bookings">Bookings Calender ID: </label>
    <a class="right" id="bookingsResult"></a>
    <button onclick="bookingsUpdate()" class="buttonSignIn right">Update</button>
    <input type="text" class="right" name="bookings" id="bookings" style="width:67%;" value="<?php echo $obj->bookingsID; ?>" />
    </div> 
<br>        
    <div class="row">         
    <label for="public">Public Calender ID: </label>
    <a class="right" id="publicResult"></a>
    <button onclick="publicUpdate()" class="buttonSignIn right">Update</button>
    <input type="text" class="right" name="public" id="public" style="width:67%;" value="<?php echo $obj->publicID; ?>" />
    </div> 
        
</p>
 
<script>    
function displaynameUpdate(){
  document.getElementById("displaynameResult").innerHTML = "Processing...";
  var displayname = encodeURIComponent(document.getElementById("displayname").value);
  if (!displayname || 0 === displayname.length){
      document.getElementById("displaynameResult").innerHTML = 'Error: Nothing entered.';
  }else{
    updateSetting(displayname, "displayname",  "users", "displaynameResult");
  }
}

function paypalUpdate(){
  document.getElementById("paypalResult").innerHTML = "Processing...";
  var paypal = encodeURIComponent(document.getElementById("paypal").value);
  if (!paypal || 0 === paypal.length){
      document.getElementById("paypalResult").innerHTML = 'Error: Nothing entered.';
  }else{
    updateSetting(paypal, "paypal",  "users", "paypalResult");
  }
}
    
    function notifyUpdate(){
  document.getElementById("notifyResult").innerHTML = "Processing...";
  var notify = encodeURIComponent(document.getElementById("notify").value);
  if (!notify || 0 === notify.length){
      document.getElementById("notifyResult").innerHTML = 'Error: Nothing entered.';
  }else{
    updateSetting(notify, "notify",  "users", "notifyResult");
  }
}
    
function availableUpdate(){
  document.getElementById("availableResult").innerHTML = "Processing...";
  var available = encodeURIComponent(document.getElementById("available").value);
  if (!available || 0 === available.length){
      document.getElementById("availableResult").innerHTML = 'Error: Nothing entered.';
  }else{
    updateSetting(available, "available",  "calendars", "availableResult");
  }
}
    
function bookingsUpdate(){
  document.getElementById("bookingsResult").innerHTML = "Processing...";
  var bookings = encodeURIComponent(document.getElementById("bookings").value);
  if (!bookings || 0 === bookings.length){
      document.getElementById("bookingsResult").innerHTML = 'Error: Nothing entered.';
  }else{
    updateSetting(bookings, "bookings",  "calendars", "bookingsResult");
  }
}
    
function publicUpdate(){
  document.getElementById("publicResult").innerHTML = "Processing...";
  var public = encodeURIComponent(document.getElementById("public").value);
  if (!public || 0 === public.length){
      document.getElementById("publicResult").innerHTML = 'Error: Nothing entered.';
  }else{
    updateSetting(public, "public",  "calendars", "publicResult");
  }
}

function updateSetting(value, column, table, result) {
      var fail = true;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var fail = false;
        document.getElementById(result).innerHTML = this.responseText;
    }else{
      window.setTimeout(failed(fail, result), 4000);
    }
  };
  xhttp.open("POST", "updateSetting.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("value="+value+"&column="+column+"&table="+table);
}

function failed(fail, result){
      if(fail){
          document.getElementById(result).innerHTML = 'Connection Failed.';
      }
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------




require('/var/www/html/dashboard/footer.php');
?>

