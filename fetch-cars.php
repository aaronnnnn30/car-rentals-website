<?php

require_once './src/Database.php';

// Assuming you have a database connection established
$brand = $_POST['brand'];

//print_r($start);die;
// Fetch available cars data
$sql = "SELECT *
        FROM cars 
        WHERE brand =  '$brand'";

       

$result = $db->query($sql);

$cars = [];
while ($row = $result->fetch_object()) {
    $cars[] = $row;
    //print_r($cars);
}


// Return JSON response
header('Content-Type: application/json');
echo json_encode($cars);


