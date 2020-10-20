<?php
//dashboar wizard refreshPublic.php
session_start();
require('/var/www/html/dashboard/checkSessionPost.php');  //conf, db, obj, email, and datetime is included here already.  Also checks authorization and exits if not
require_once('/var/www/gapic/vendor/autoload.php');

$access_token = '';
$expires = '';
$refresh_token = '';
$scope = '';

	$query = "SELECT access_token, expires, refresh_token, scope
           	  FROM tokens WHERE email = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($tokendb, $expiresdb, $refreshdb, $scopedb);
	if (mysqli_connect_errno()) {$obj->error = 'Error: Could not connect to database.  ';
                             	    if($debugging){
                                    echo '<p>'.json_encode($obj).'</p>';
                                    }
                                 echo 'Could not connect to database.  ';
                             	 exit;
 	}
 	else{
     	if($stmt->num_rows == 1) {
          	while($stmt->fetch()){
             	$access_token = $tokendb;
                $expires = $expiresdb;
                $refresh_token = $refreshdb;
                $scope = $scopedb;
          	}
   	    }elseif($stmt->num_rows == 0) {
         	 $obj->message=$obj->message.'No token found for this email.  ';
                    if($debugging){
                    echo '<p>'.json_encode($obj).'</p>';
                    }
                    exit;
    	}else{
         	 $obj->error = 'Database Error: Sessions not 1 or 0.  ';
      	            if($debugging){
                    echo '<p>'.json_encode($obj).'</p>';
                    }
       	     exit;
    	}
    }


if($datetime>$expires){
    $grant_type = 'refresh_token';
    $url = 'https://oauth2.googleapis.com/token';
    $data = array('refresh_token' => $refresh_token, 'client_id' => $client_id, 'client_secret' => $client_secret, 'redirect_uri' => $redirect_uri, 'grant_type' => $grant_type, 'scope' => $scope );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $strjson = file_get_contents($url, false, $context);

    if ($strjson === FALSE) { echo 'Failed to get contents.  '; }
    else 
    {

    $jsonobject = json_decode($strjson);
    $access_token=$jsonobject->access_token;
    $expires_in=$jsonobject->expires_in;
    $expires = $datetime + $expires_in;
    $token_type=$jsonobject->token_type;

        $query = "UPDATE tokens SET access_token = ?, expires_in = ?, expires = ?, token_type = ?  WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssss', $access_token, $expires_in, $expires, $token_type, $email);
        $stmt->execute();
        if($db ->affected_rows == 1){
                                $obj->message = $obj->message."UPDATE tokens: 1 row affected. Refreshed token.  ";
                                }else{
                                $obj->message = $obj->message."Failed to insert.  ";
                                }
    }
}else{
    $obj->message=$obj->message.'Token is current. Refresh not required.  ';
}

//-------------- Get Calendar ID and DISPLAY NAME---------------------------

$availableid = '';
$bookingsid = '';
$publicid = '';

	$query = "SELECT available, bookings, public        
           	  FROM calendars WHERE email = ?";
	$stmt = $db->prepare($query);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($availabledb, $bookingsdb, $publicdb);
	if (mysqli_connect_errno()) {$obj->error = 'Error: Could not connect to database.  ';
                             	    if($debugging){
                                    echo '<p>'.json_encode($obj).'</p>';
                                    }
                             	 exit;
 	}
 	else{
     	if($stmt->num_rows == 1) {
          	while($stmt->fetch()){
             	$availableid = $availabledb;
                $bookingsid = $bookingsdb;
                $publicid = $publicdb;
          	}
   	    }elseif($stmt->num_rows == 0) {
         	 $obj->message=$obj->message.'No calendars in database found for this email.  ';
                    if($debugging){
                    echo '<p>'.json_encode($obj).'</p>';
                    }
		     exit;
    	}else{
         	 $obj->error = 'Database Error: Sessions not 1 or 0.  ';
      	            if($debugging){
                    echo '<p>'.json_encode($obj).'</p>';
                    }
       	     exit;
    	}
    }


//---------------------------READ AVAILABLE CALENDAR------------------------------------------------
    
    $client = new Google_Client();
    $client->setApplicationName('GCBookings');
    $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
    $client->setAccessType('offline');
    $client->setClientId($client_id);
    $client->setClientSecret($client_secret);
    $client->setAccessToken($access_token);
    $service = new Google_Service_Calendar($client);

    $optParams = array(
      'maxResults' => 15,                                                                  //Add functionality
      'orderBy' => 'startTime',
      'singleEvents' => true,
      'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($availableid, $optParams);
    $events = $results->getItems();
    $arrayAvailable = [];
if (!empty($events)) {
    $j=0;
    foreach ($events as $event) {
        $allday=false;
        $summary = $event->summary;
        $description = $event->description;
        $start = $event->start->dateTime;
        $end = $event->end->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
            $allday=true;
        }
        //echo '<p>'.$summary.': '.$start.'  '.$end.'  '.$description.'</p>';
        //echo '<p>';
        $description = substr($description, 1);
        $arrayDescription = explode('~', $description);
        //var_dump($arrayDescription);
        $eventArray=[];
        $eventArray['calendar']='available';
        $eventArray['summary']=$summary;
        $eventArray['start'] = date('U', strtotime($start));
        $eventArray['end'] = date('U', strtotime($end));
        $count=count($arrayDescription);
        for ($i=4; $i<($count+4); $i++){                                                        //make this for each.  Right now it's 4 only
        $element = $arrayDescription[$i-4];
        $arrayElement = explode('=', $element);
        $key = $arrayElement[0];
        $value = $arrayElement[1];
        $eventArray[$key]=$value;
        //echo '<br>'.$tag.': '.$value;
        }
        //var_dump($eventArray);
        //echo '</p>';
        $arrayAvailable[$j]=$eventArray;
        $j+=1;
    }
}else{echo 'No events found.';exit;}                                                                                       //Add functionality, clear Public


//--------------------READ BOOKINGS CALENDAR-----------------------------

    $optParams2 = array(
      'maxResults' => 5,                                                                                         //Add functionality
      'orderBy' => 'startTime',
      'singleEvents' => true,
      'timeMin' => date('c'),
    );

    $results2 = $service->events->listEvents($bookingsid, $optParams2);
    $events2 = $results2->getItems();
    $arrayBookings = [];
if (!empty($events2)) {
    $j=0;
    foreach ($events2 as $event) {
        $allday=false;
        $summary = $event->summary;
        $description = $event->description;
        $start = $event->start->dateTime;
        $end = $event->end->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
            $allday=true;
        }
        //echo '<p>'.$summary.': '.$start.'  '.$end.'  '.$description.'</p>';
        //echo '<p>';
        $description = substr($description, 1);
        $arrayDescription = explode('~', $description);
        //var_dump($arrayDescription);
        $eventArray=[];
        $eventArray['calendar']='bookings';
        $eventArray['summary']=$summary;
        $eventArray['start'] = date('U', strtotime($start));
        $eventArray['end'] = date('U', strtotime($end));
        $count=count($arrayDescription);
        for ($i=4; $i<($count+4); $i++){                                                                          //change to for each
        $element = $arrayDescription[$i-4];
        $arrayElement = explode('=', $element);
        $key = $arrayElement[0];
        $value = $arrayElement[1];
        $eventArray[$key]=$value;
        //echo '<br>'.$tag.': '.$value;
        }
        //var_dump($eventArray);
        //echo '</p>';
        $arrayBookings[$j]=$eventArray;
        $j+=1;
    }
}
    //echo '<p>';
    //var_dump($arrayBookings);
    //echo '</p>';

    $arraysMerged = array_merge($arrayAvailable, $arrayBookings);
    //echo '<p>';
    //var_dump($arraysMerged);
    //echo '</p>';
    $resources=[];
    foreach($arraysMerged as $event){
    $resources[] = $event['Resource'];
    $resources = array_unique($resources);
    }
    //echo '<p>';
    //var_dump($resources);
    //echo '</p>';

    $arrayPublic = [];
    foreach($resources as $resource){
    $$resource = [];
        foreach($arraysMerged as $event){
            if($event['Resource']==$resource){
            $$resource[] = $event;
            }
        }
    array_multisort(array_column($$resource, 'start'), SORT_ASC, $$resource);
    echo '<p>';
        do{
        $deleted=0;
        for ($j=0; $j<(count($$resource)-1); $j++){
            if($$resource[$j]['calendar']!=$$resource[$j+1]['calendar']){
                if($$resource[$j]['start']==$$resource[$j+1]['start']){
                    if($$resource[$j]['calendar']=='available'){
                        unset($$resource[$j]);
                        $$resource=array_values($$resource);
                        $deleted++;
                        //echo 'Deleted ';
                    }else{
                        unset($$resource[$j+1]);
                        $$resource=array_values($$resource);
                        $deleted++;
                        //echo 'Deleted ';
                    }
                }else{}
            }else{}
        }
        }while($deleted>0);
        
        do{
        $deleted=0;
        for ($j=0; $j<(count($$resource)-1); $j++){
            if($$resource[$j]['calendar']!=$$resource[$j+1]['calendar']){
                if(($$resource[$j]['end']>$$resource[$j+1]['start']) && ($$resource[$j]['calendar']=='bookings')){
                    unset($$resource[$j+1]);
                    $$resource=array_values($$resource);
                    $deleted++;
                    //echo 'Deleted ';
                }elseif(($$resource[$j]['end']>$$resource[$j+1]['start']) && ($$resource[$j+1]['calendar']=='bookings')){
                    unset($$resource[$j]);
                    $$resource=array_values($$resource);
                    $deleted++;
                    //echo 'Deleted ';
                }else{}
            }else{}
        }
        $$resource=array_values($$resource);
        }while($deleted>0);
    $arrayPublic = array_merge($arrayPublic, $$resource);
    }
    echo '</p>';
    //echo '<p>';
    //var_dump($arrayPublic);    
    //echo '</p>';

    $j=0;
    $todelete = [];
    foreach($arrayPublic as $calType){
        if($calType['calendar']=='bookings'){
        $todelete[]=$j;
            //echo '.';
        }
    $j++;
    }

    //echo '<p>';
    //var_dump($todelete);    
    //echo '</p>';

    foreach($todelete as $key){
    unset($arrayPublic[$key]);
    }
    $arrayPublic = array_values($arrayPublic);
    //echo '<p>';
    //var_dump($arrayPublic);    
    //echo '</p>';

//--------------------Create Events ----------------------------------

    $service->calendars->clear('primary');                                                                        //make this better
    //$service->calendars->clear('primary');
    //$service->calendars->clear('primary');

    $query = "DELETE FROM checkout WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();

$event = 'initialized';
$isInserted = FALSE;
    foreach($arrayPublic as $bookable){
        
        $summary = $bookable['summary'];
        $start = $bookable['start'];
        $end = $bookable['end'];
        $resource = $bookable['Resource'];
        $price = $bookable['Price'];
        $description = $bookable['Description'];
        
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
          'location' => 'Add variable here',                                                                  //add variable here
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

        $calendarId = $publicid;
        $event = $service->events->insert($calendarId, $event);   //other options here?
        
        $query = "INSERT INTO checkout VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssssss', $productcode, $email, $summary, $startDateTime, $endDateTime, $price);
        $isInserted=$stmt->execute();

    }

if(isset($event->htmlLink) && $isInserted){
    
    $active = 'yes';
    $query = "UPDATE calendars SET active = ?  WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $active, $email);
        $stmt->execute();

    echo 'Successfully updated Public calendar.&nbsp;&nbsp;&nbsp;&nbsp;';
    $obj->message=$obj->message.'Successfully updated Public calendar.  ';
}else{
    echo 'Failed:  There was a problem.  Please contact support.  Thank you.';
    $obj->error=$obj->error.'Event not set OR not inserted.  ';
    if($debugging){
        echo '<p>'.json_encode($obj).'</p>';    
    }  
}

?>

