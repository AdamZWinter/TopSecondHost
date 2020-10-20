<?php
// dashboard / writeTerms.php

require('/var/www/html/dashboard/checkSessionPost.php');

if(!($terms=@$_POST["terms"])){
    echo '<p>No Content included</p>';
    $obj->error = $obj->error.'No Content.';
    echo json_encode($obj);
    exit;
}else {
    $terms=$_POST["terms"];
    $query = "UPDATE blobs SET terms = ? WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $terms, $email);
        $stmt->execute();
        if($db ->affected_rows == 1){
            echo 'Updated';
        }else{
        echo 'No Change.';
        exit;
        }
}

?>
