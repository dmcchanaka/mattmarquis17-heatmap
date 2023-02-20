<?php
    session_start();
    require_once './library/config.php';
    $connection = new createConnection();
    $connection->connectToDatabase();

    if(isset($_POST['importSubmit'])){
       
        $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

        if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $latitude   = $line[0];
                $longitude  = $line[1];
                $rssi  = $line[2];

                if($latitude != "" && $longitude != ""){
                    $ck_query_cus = "SELECT * FROM `heatmap_coordinates` WHERE latitude='$latitude' AND longitude='$longitude'";
                    $ck_result_cus = mysqli_query($connection->myconn, $ck_query_cus) or die(mysqli_error($connection->myconn));
                    if ($ck_result_cus->num_rows != 0) {
                        $row_stk = $ck_result_cus->fetch_assoc();

                        $query_stk_up = "UPDATE `heatmap_coordinates` SET `latitude`='$latitude',`longitude`= '$longitude',`rssi`='$rssi' WHERE id='".$row_stk['id']."'";
                        mysqli_query($connection->myconn, $query_stk_up) or die(mysqli_error($connection->myconn));
                    } else {
                        $query_insert = "INSERT INTO `heatmap_coordinates` (`latitude`, `longitude`, `rssi`) VALUES ('$latitude','$longitude','$rssi')";
                        mysqli_query($connection->myconn, $query_insert) or die(mysqli_error($connection->myconn));
                    }

                    $_SESSION['msg'] = "excel is uploaded !";
                    $_SESSION['status'] = 0;
                } else {
                    $_SESSION['msg'] = "excel is not uploaded !";
                    $_SESSION['status'] = 1;
                }
            }
        }

        header('Location: upload.php');
    }
