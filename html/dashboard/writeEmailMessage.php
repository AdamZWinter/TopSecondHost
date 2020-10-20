<?php
// dashboard / writeEmailMessage.php

require('/var/www/html/dashboard/checkSessionPost.php');

if(!($emailMessage=@$_POST["emailMessage"])){
    echo '<p>No Content included</p>';
    $obj->error = $obj->error.'No Content.';
    echo json_encode($obj);
    exit;
}else {
    $emailMessage=$_POST["emailMessage"];
    $query = "UPDATE blobs SET emailMessage = ? WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $emailMessage, $email);
        $stmt->execute();
        if($db ->affected_rows == 1){
            echo 'Updated';
        }else{
        echo 'No Change.';
        exit;
        }
}

?>
