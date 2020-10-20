<?php
//dashboard/wizard/wizardOauth02.php
require('/var/www/html/authorizedHeader.php');
require_once '/var/www/gapic/vendor/autoload.php';
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

        //-------------- Get Google API Token ---------------------------

        require('/var/www/gcbookings/common/GapicToken.php');
        $secureObj = GapicToken::getToken($obj, $db);          //obj must have email
        $access_token = $secureObj->access_token;
        $scope = $secureObj->scope;
        $obj = $secureObj->obj;


        //-------------- Get Calendar IDs ---------------------------


        require('/var/www/gcbookings/common/Calendars.php');
        $obj = Calendars::getCalendars($obj, $db, $email);
        //$availableid = $obj->availableid;
        //$bookingsid = $obj->bookingsid;
        $publicid = $obj->publicid;


//----------------Create Calendar Entry------------------------------

    $client = new Google_Client();
    $client->setApplicationName('GCBookings');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAccessType('offline');
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setAccessToken($access_token);
    $service = new Google_Service_Calendar($client);

        $summary = 'GCBookings Test';
        $start = $datetime+3600;
        $end = $datetime+7200;
        $resource = 'test';
        $price = '99.99';
        $description = 'This is just a test to verify access to your calendar.';
        
        $forhash = $summary.$start.$end.$resource.$price.$description;
        $productcode = openssl_digest($forhash, "sha256");
        $productcode = base64_encode($productcode);
        $productcode = str_replace('+', '', $productcode);
        $productcode = str_replace('/', '', $productcode);
        $productcode = substr($productcode, 10, 16);
        $link = 'https://gcbookings.com/booknow.php?item='.$productcode;                                 //Come back to regex*******************************************************************************
        $description = '<a href="'.$link.'">Click Here to Book Now</a><br><br>'.$description.'<br><br><br><br><br><br>Warning: "copy to my calendar" does not make booking.  Book with link above.';
        
        date_default_timezone_set('America/Los_Angeles');
        $startDateTime = date('c', $start);
        $endDateTime = date('c', $end);
        
        //echo '<p>';
        //echo $summary.'  '.$startDateTime.'  '.$endDateTime.'  '.$resource.'  '.$price.'  '.$description.'  '.$productcode;
        //echo '</p>';
        
       $event = new Google_Service_Calendar_Event(array(
          'summary' => $summary,
          'location' => 'TBD',                                                 //add variable here  *********************************************************
          'description' => $description,
          'start' => array(
              'dateTime' => $startDateTime,
              //'timeZone' => 'America/Los_Angeles',
              ),
          'end' => array(
                'dateTime' => $endDateTime,
                //'timeZone' => 'America/Los_Angeles',
                  ),
          'attachments' => array(
               array('fileUrl' => $link),
                  ),
          'source' => array(
                'title' => 'Click Here to Book Now',
                'url' => $link,
                  ),
          'reminders' => array(
                'useDefault' => FALSE,
                ),
        ));

        $calendarId = $publicid;
        //$calendarId = 'testbadfail';

        try{
            $event = $service->events->insert($calendarId, $event);   //other options here?
        }catch(exception $e){
            error_log($e);
        }
        
if(!isset($event->htmlLink)){
            echo '<p>Test of calendar access failed.  Please go back and check your entries.  Contact support if the problem persists.</p>';
            require('/var/www/html/dashboard/footer.php');
            exit;
}

//----------------------------------- Start Authorized Content ----------------------------------------------------
?>

<div class="row">

  <div class="col-6 bigScreen indexLeft">
  <img class="wizardScreenShot bigScreen" src="images/wizardOauth02.png">
  </div>

  <div class="col-6 indexRight">

  <p>
  Great!   That seemed to work.
  <br>
  <br>
  Open your new calendar and verify the event we just entered onto it as a test.
  <br>
  <br>
  </p>
  <p id="result"></p>

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
        window.location.href = "wizard2.php";
}

function skip(){
        window.location.href = "wizard2.php";
}

</script>


<?php
//---------------------------------- End Authorized Content --------------------------------------------------------

require('/var/www/html/dashboard/footer.php');
?>

