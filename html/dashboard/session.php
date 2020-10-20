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

<div id="divWizard" class="row">
<p>
You must complete the activation wizard before proceeding any further.
</p>
<a style="float: none; align-content: center;" class="buttonHome" href="wizard/wizardStart.php">Start Wizard</a>
</div>

<div id="divActive" class="row">
    
    <div class="col-6 indexRight">
        <p>
        Choose from the menu above.
        </p>
    </div>
    
  <div class="col-6 indexRight">
      <p class="adTitle">Add Available Calendar Entry</p>
      <div class="row">
          <p>
          <label for="title">Resource</label>
          <input type="text" name="resource" id="resource" style="width:67%; float:right;" placeholder="My Time"/>
          </p>
      </div>
      <div class="row">
          <p>
          <label for="title">Title</label>
          <input type="text" name="title" id="title" style="width:67%; float:right;" placeholder="My Service"/>
          </p>
      </div>
      <div class="row">
          <p>
          <label for="location">Location</label>
          <input type="text" name="location" id="location" style="width:67%; float:right;" placeholder="Location"/>
          </p>
      </div>
      <div class="row">
          <p>
          <label for="price">Price</label>
          <input type="text" name="price" id="price" style="width:67%; float:right;" placeholder="129.99"/>
          </p>
      </div>
      <div class="row">
          <p>
          <label for="tax">Tax (%)</label>
          <input type="text" name="tax" id="tax" style="width:67%; float:right;" placeholder="9.8"/>
          </p>
      </div>
      <div class="row">
          <p>
          <label for="description">Description </label>
          <textarea id="description" rows="4" style="width:67%; float:right;"></textarea>
          </p>
      </div>
      <br>
      <button onclick="calendarEntry()" class="navButtonNext"> Add </button>
      <a id="result"></a>
  </div>
    
</div>


      <script>    
function calendarEntry(){
  var title = encodeURIComponent(document.getElementById("title").value);
  var location = encodeURIComponent(document.getElementById("location").value);
  var price = encodeURIComponent(document.getElementById("price").value);
  var tax = encodeURIComponent(document.getElementById("tax").value);
  var description = encodeURIComponent(document.getElementById("description").value);

  if (!title || 0 === title.length || !price || 0 === price.length || !location || 0 === location.length || !tax || 0 === tax.length || !description || 0 === description.length){
     document.getElementById("result").innerHTML = 'Error:  Each field is required.  Enter 0 for Price and Tax if none.';
  }else{
    createEvent();
  }
}

function createEvent() {
  var updated = false;
  var resource = encodeURIComponent(document.getElementById("resource").value);
  var title = encodeURIComponent(document.getElementById("title").value);
  var location = encodeURIComponent(document.getElementById("location").value);
  var price = encodeURIComponent(document.getElementById("price").value);
  var tax = encodeURIComponent(document.getElementById("tax").value);
  var description = encodeURIComponent(document.getElementById("description").value);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        var myResponse = JSON.parse(this.responseText);
        if(myResponse.hasOwnProperty('error')){
            document.getElementById("result").innerHTML = myResponse.error;
        }else if(myResponse.success){
            document.getElementById("result").innerHTML = "Successfully added calendar entry.";
            window.setTimeout(function(){document.getElementById("result").innerHTML = "...";}, 6000);
            var updated = true;
        }else{
            document.getElementById("result").innerHTML = "Failed to insert calendar entry."+this.responseText;
      	}
    }else{
        window.setTimeout(failed(updated), 6000);
        document.getElementById("result").innerHTML = "Processing....";
    }
  };
  xhttp.open("POST", "createEvent.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("resource="+resource+"&title="+title+"&location="+location+"&price="+price+"&tax="+tax+"&description="+description);
}

function failed(updated){
		if(!updated){
      document.getElementById("result").innerHTML = 'Connection Failed.';
      }
}

</script>



<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

$active = FALSE;
$checkActive = '';
 $query = "SELECT active
           FROM calendars
           WHERE email = ?";
 $stmt = $db->prepare($query);
 $stmt->bind_param('s', $email);
 $stmt->execute();
 $stmt->store_result();
 $stmt->bind_result($activedb);
 if (mysqli_connect_errno()) {$obj->error = 'Error: Could not connect to database.  ';
                             echo json_encode($obj);
                             exit;
 }
 else{
     if($stmt->num_rows == 1) {
          while($stmt->fetch()){
             $checkActive = $activedb;
          }
                  if(strcmp($checkActive, 'yes')==0){
                               $active=TRUE;
                               $obj->message=$obj->message.'Active.  ';
                   }
     } elseif($stmt->num_rows == 0) {
          $obj->message=$obj->message.'Email not found, no match.  ';
     } else {
          $obj->error = 'Database Error: Sessions not 1 or 0.  ';
         echo json_encode($obj);
         exit;
    }
}

//This has to come after
if($active){
echo '
<script>
document.getElementById("divWizard").style.display = "none";
</script>
';
}else{
echo '
<script>
document.getElementById("divMenu").style.display = "none";
document.getElementById("divActive").style.display = "none";
</script>
';
}

require('/var/www/html/dashboard/footer.php');
?>



