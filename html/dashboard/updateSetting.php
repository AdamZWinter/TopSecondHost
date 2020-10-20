<?php
//dashboard/ updateSetting.php

require('/var/www/html/dashboard/checkSessionPost.php');

if(!($value=@$_POST["value"])){
    echo '<p>No value was entered.</p>';
    $obj->error = $obj->error.'No value.';
    echo json_encode($obj);
    exit;
}else {
    $value=$_POST["value"];
}

if(!($column=@$_POST["column"])){
    echo '<p>No column was entered.</p>';
    $obj->error = $obj->error.'No column.';
    echo json_encode($obj);
    exit;
}else {
    $column=$_POST["column"];
}

if(!($table=@$_POST["table"])){
    echo '<p>No table was entered.</p>';
    $obj->error = $obj->error.'No table.';
    echo json_encode($obj);
    exit;
}else {
    $table=$_POST["table"];
}

    $query = "UPDATE ".$table." SET ".$column." = ?  WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $value, $email);
        $stmt->execute();
        if($db ->affected_rows == 1){
                                    echo 'Updated';
        }else{
        echo 'No Change.';
        exit;
        }

?>

