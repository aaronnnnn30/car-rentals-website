<?php

require_once './src/Database.php';

// Assuming you have a database connection established
$start = $_POST['start'];
$end = $_POST['end'];
//print_r($start);die;
// Fetch available cars data
/*$sql = "SELECT *
        FROM cars 
        WHERE id NOT IN (
            SELECT DISTINCT car 
            FROM booking
            WHERE (start_date <= '$start' AND end_date >= '$end')
            OR (start_date <= '$end' AND end_date >= '$end')
            OR (start_date >= '$start' AND end_date <= '$end')
        ) AND booking_status = 'completed'";*/


 $sql = "SELECT * FROM booking";  
 $res = $db->query($sql);
 $booking_details = $res->fetch_object();   
 //print_r($booking_details->booking_status);die;
 if($booking_details->booking_status == 'Booked'){
    $sql = "SELECT c.*
    FROM cars c
    LEFT JOIN booking b ON c.id = b.car
    WHERE (b.id IS NULL OR b.booking_status = 'Booked' OR b.booking_status = 'Live')
    AND NOT EXISTS (
        SELECT 1
        FROM booking
        WHERE car = c.id
        AND (
            (start_date <= '$start' AND end_date >= '$start')
            OR (start_date <= '$start' AND end_date >= '$end')
            OR (start_date >= '$start' AND end_date <= '$end')
            OR (start_date <= '$end' AND end_date >= '$end')
        )
    )";
   
 }else{
    $sql = "SELECT c.*
    FROM cars c
    LEFT JOIN booking b ON c.id = b.car
    WHERE (b.id IS NULL OR b.booking_status = 'Completed')
    AND NOT EXISTS (
        SELECT 1
        FROM booking
        WHERE car = c.id
        AND (
            (start_date <= '$start' AND end_date >= '$start')
            OR (start_date <= '$start' AND end_date >= '$end')
            OR (start_date >= '$start' AND end_date <= '$end')
            OR (start_date <= '$end' AND end_date >= '$end')
        )
    )";
   
 }



//echo $sql;die;

$result = $db->query($sql);

$cars = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
} else {
    echo "0 results";
}
$db->close();
//echo $cars;
// Return JSON response
header('Content-Type: application/json');
echo json_encode($cars);


