<?php
//dashboard/manualBooking.php
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
document.getElementById("manualBooking").className = "dashboardMenu left current";
</script>

</div>

<!-- Row 1 -->
<div class="row">
  <div class="col-1 mainGridBox bigScreen">
  </div>
  <div class="col-10 mainGridBox">
  <p class="adTitle">Manually Enter Bookings</p>
  <p>Use this form to manually add bookings to your Bookings calendar.  Adjust the booking to the correct time on the calendar.</p>
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
    
      <div class="row">
          <p>
          <label for="title">Resource</label>
          <input type="text" name="resource" id="resource" style="width:67%; float:right;" placeholder="~Tilde added automatically: do not include"/>
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


      <script>    
function calendarEntry(){
  var resource = encodeURIComponent(document.getElementById("resource").value);
  var title = encodeURIComponent(document.getElementById("title").value);
  var location = encodeURIComponent(document.getElementById("location").value);
  var price = encodeURIComponent(document.getElementById("price").value);
  var tax = encodeURIComponent(document.getElementById("tax").value);
  var description = encodeURIComponent(document.getElementById("description").value);

  if (!resource || 0 === resource.length || !title || 0 === title.length){
     document.getElementById("result").innerHTML = 'Resource and Title are required at minimum.';
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
            document.getElementById("result").innerHTML = "Successfully added calendar entry to Availability.";
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
  xhttp.open("POST", "createBooking.php", true);
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

require('/var/www/html/dashboard/footer.php');
?>

