<?php
//dashboard/wizard/storePaypal.php

require('/var/www/html/dashboard/authorizePost.php');

if(!($paypal=@$_POST["paypal"])){
    echo '<p>No Paypal email was entered.</p>';
    $obj->error = $obj->error.'No Paypal email.';
    echo json_encode($obj);
    exit;
}else {
    $paypal=$_POST["paypal"];
    $query = "UPDATE users SET paypal = ?  WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $paypal, $email);
        $stmt->execute();
        if(($db ->affected_rows == 1) || ($db ->affected_rows == 0)){
                                echo 'Updated';
                                }else{
                                echo 'Failed';
                                }
}

?>
