<?php
//dashboard/wizard/createEvent.php

require('/var/www/html/dashboard/authorizePost.php');  //session_start, conf obj db and email are included here already  
require_once('/var/www/gapic/vendor/autoload.php');

if(!($title=@$_POST["title"])){
    echo '<p>No Title was entered.</p>';
    $obj->error = $obj->error.'No Title.';
    echo json_encode($obj);
    exit;
}else {
    $title=$_POST["title"];
    }

if(!($price=@$_POST["price"])){
    echo '<p>No Price was entered.</p>';
    $obj->error = $obj->error.'No Price.';
    echo json_encode($obj);
    exit;
}else {
    $price=$_POST["price"];
    }

if(!($tax=@$_POST["tax"])){
    echo '<p>No Tax was entered.</p>';
    $obj->error = $obj->error.'No Tax.';
    echo json_encode($obj);
    exit;
}else {
    $tax=$_POST["tax"];
    }

if(!($description=@$_POST["description"])){
    echo '<p>No Description was entered.</p>';
    $obj->error = $obj->error.'No Description.';
    echo json_encode($obj);
    exit;
}else {
    $description=$_POST["description"];
    }

if(!($location=@$_POST["location"])){
    echo '<p>No Location was entered.</p>';
    $obj->error = $obj->error.'No Location.';
    echo json_encode($obj);
    exit;
}else {
    $location=$_POST["location"];
    }

require('/var/www/gcbookings/common/GapicToken.php');
$secureObj = GapicToken::getToken($obj, $db);   //obj must have email
        $access_token = $secureObj->access_token;
        $scope = $secureObj->scope;
        $obj = $secureObj->obj;

require('/var/www/gcbookings/common/Calendars.php');
$obj = Calendars::getCalendars($obj, $db, $email);
        $availableid = $obj->availableid;

    $client = new Google_Client();
    $client->setApplicationName('GCBookings');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAccessType('offline');
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setAccessToken($access_token);
    $service = new Google_Service_Calendar($client);

        $summary = $title;
        $start = ($datetime+3600)-(($datetime+3600)%1800);
        $end = ($datetime+7200)-(($datetime+7200)%1800);

        $description = '~Resource:::Myself<br>~Price:::$'.$price.'<br>~Tax:::'.$tax.'%<br>~Description:::'.$description;
        
        date_default_timezone_set('America/Los_Angeles');
        $startDateTime = date('c', $start);
        $endDateTime = date('c', $end);
        
       $event = new Google_Service_Calendar_Event(array(
          'summary' => $summary,
          'location' => $location,                                              
          'description' => $description,
          'start' => array(
              'dateTime' => $startDateTime,
              //'timeZone' => 'America/Los_Angeles',
              ),
          'end' => array(
                'dateTime' => $endDateTime,
                //'timeZone' => 'America/Los_Angeles',
                  ),
          'reminders' => array(
                'useDefault' => FALSE,
                ),
        ));

        $calendarId = $availableid;
        $event = $service->events->insert($calendarId, $event);   //other options here?

if(isset($event->created)){
  echo 'Updated'; exit;
}else{
  echo 'Failed'; exit;
}

?>
