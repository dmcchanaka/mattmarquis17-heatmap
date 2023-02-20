<?php 
require_once './library/config.php';

$connection = new createConnection();
$connection->connectToDatabase();

if(isset($_REQUEST['type']) && $_REQUEST['type'] =='get_all_details'){
    
    $query = "SELECT * FROM `heatmap_coordinates` WHERE 1";
    $result = mysqli_query($connection->myconn, $query);
    $response = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($response,$row);
    }
    echo json_encode($response);
}