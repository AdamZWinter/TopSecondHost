<?php
//dashboard/wizard/storePublic.php

require('/var/www/html/dashboard/authorizePost.php');

if(!($public=@$_POST["public"])){
    echo '<p>No email address was entered.</p>';
    $obj->error = $obj->error.'No email.';
    echo json_encode($obj);
    exit;
}else {
    $public=$_POST["public"];
    $public=str_replace('@gmail.com', '', $public);
    $public=$public.'@gmail.com';
    $query = "UPDATE calendars SET public = ?  WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $public, $email);
        $stmt->execute();
        if(($db ->affected_rows == 1) || ($db ->affected_rows == 0)){
                                echo 'Updated';
                                }else{
                                echo 'Failed';
                                }
}

?>
