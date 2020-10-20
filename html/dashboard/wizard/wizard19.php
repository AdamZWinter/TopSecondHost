<?php
//dashboard/wizard19.php
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


<div class="row">

  <div class="col-6 indexRight">
  <p>
  <br>
  <br>
  Almost Done!
  <br>
  <br>
  Before we start editing your Availability calendar through Google.  Let's get one entry started here.
  <br>
  <br>
  Enter the details for one of the bookings you want to make available.
  <br>
  <br>
  You can add multiple services here, if you want.  Click "Add" for each one.  You'll adjust the starting and ending times later, through the Google calendar.
  
  </p>
  </div>

  <div class="col-6 indexRight">
  <p>
  <br>
  <label for="title">Title </label>
  <input type="text" name="title" id="title" style="width:80%;" placeholder="My Service"/>
  <br>
  <label for="location">Location </label>
  <input type="text" name="location" id="location" style="width:80%;" placeholder="Location"/>
  <br>
  <label for="price">Price $</label>
  <input type="text" name="price" id="price" style="width:40%;" placeholder="129.99"/>
  <br>
  <label for="tax">Tax (%) </label>
  <input type="text" name="tax" id="tax" style="width:40%;" placeholder="9.8"/>
  <br>
  <label for="description">Description </label>
  <textarea id="description" rows="4" cols="20"></textarea>
  <br>
  <br>
  <button onclick="calendarEntry()" class="navButtonNext"> Add </button>
  </p>
  </div>

</div>

<div class="row">
  <p id="result" style="float: right;"></p>
</div>

<div class="row">
  <br>
  <br>
  <br>
<button onclick="validateEntry()" class="navButtonNext">Next</button>
<a class="bigScreen" style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<a class="navButtonNext" onclick="skip()">Skip</a>
<a class="bigScreen" style="float: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<a class="navButtonBack" onclick="history.back()">Back</a>
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
  var title = encodeURIComponent(document.getElementById("title").value);
  var location = encodeURIComponent(document.getElementById("location").value);
  var price = encodeURIComponent(document.getElementById("price").value);
  var tax = encodeURIComponent(document.getElementById("tax").value);
  var description = encodeURIComponent(document.getElementById("description").value);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      	if (this.responseText == "Updated"){
          	document.getElementById("result").innerHTML = "Successfully added calendar entry to Availability.";
         	  var updated = true;
        }else{
            document.getElementById("result").innerHTML = "Failed to insert calendar entry.";
      	}  
    }else{
        window.setTimeout(failed(updated), 6000);
        document.getElementById("result").innerHTML = "Processing....";
    }
  };
  xhttp.open("POST", "createEvent.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("title="+title+"&location="+location+"&price="+price+"&tax="+tax+"&description="+description);
}

function failed(updated){
		if(!updated){
      document.getElementById("result").innerHTML = 'Connection Failed.';
      }
}

function validateEntry(){
        window.location.href = "wizard20.php";
}

function skip(){
        window.location.href = "wizard20.php";
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

