<?php

require '../db/credentials.php';    
$connection = new mysqli($MYSQL_CREDENTIALS["host"],
                         $MYSQL_CREDENTIALS["username"],
                         $MYSQL_CREDENTIALS["password"],
                         $MYSQL_CREDENTIALS["database"]);

$action = $_REQUEST['action'];


$sql = "INSERT INTO purchases
        SET media = ".$_REQUEST['mediaId'].",
            purchaser = '".$_REQUEST['user']."',
            price = ".$_REQUEST['price'].",
            license = '".$_REQUEST['license']."'";

$statement = $connection->prepare($sql);
$statement->execute();

echo json_encode(array('message' => 'Success'));

?>