<?php

include("db.php");
session_start();

$query = "SELECT user_session_id FROM users WHERE id = '".$_SESSION['user_id']."'";


$result = $connection->query($query);
foreach($result as $row){
    if($_SESSION['user_session_id'] != $row['user_session_id']){
        $data['output']='logout';
    }else{
        $data['output']='login';
    }
}
echo json_encode($data);

?>