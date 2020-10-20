<?php
//dashboard/wizard/createEvent.php

require('/var/www/html/dashboard/authorizePost.php');  // start session, conf obj db and email are included here already  
require_once('/var/www/gapic/vendor/autoload.php');

if(!isset($_POST["resource"])){
    $obj->error = 'No resource.';
    echo json_encode($obj);
    exit;
}else {
    $resource=$_POST["resource"];
    }

if(!isset($_POST["title"])){
    $obj->error = 'No title.';
    echo json_encode($obj);
    exit;
}else {
    $title=$_POST["title"];
    }

if(!isset($_POST["price"])){
    $obj->error = 'No price.';
    echo json_encode($obj);
    exit;
}else {
    $price=$_POST["price"];
    }

if(!isset($_POST["tax"])){
    $obj->error = 'No tax.';
    echo json_encode($obj);
    exit;
}else {
    $tax=$_POST["tax"];
    }

if(!isset($_POST["description"])){
    $obj->error = 'No Description.';
    echo json_encode($obj);
    exit;
}else {
    $description=$_POST["description"];
    }

if(!isset($_POST["location"])){
    $obj->error = 'No Location.';
    echo json_encode($obj);
    exit;
}else {
    $location=$_POST["location"];
    }

if($resource[0]=='~'){
    $resource = str_replace('~', '', $resource);
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

$description = '~Resource:::'.$resource.'<br>~Price:::$'.$price.'<br>~Tax:::'.$tax.'%<br>~Description:::'.$description;
        
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
    $obj->success = TRUE;
    echo json_encode($obj);
    exit;
}else{
    $obj->error = 'Failed to insert to calendar';
    echo json_encode($obj);
    exit;
}

?>


