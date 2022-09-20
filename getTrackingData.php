<?php
    require 'connect.php';
    error_reporting(E_ERROR);
    $ship = [];

    $sql = "SELECT * FROM tracking";
    
    if($result = mysqli_query($con,$sql))
    {
        $cr = 0;
        while($row = mysqli_fetch_assoc($result)){
            $ship[$cr]['id'] = $row['tracking_id'];
            $ship[$cr]['tracking_number'] = $row['tracking_number'];
            $ship[$cr]['package'] = $row['package'];
            $ship[$cr]['sender_name'] = $row['sender_name'];
            $ship[$cr]['sender_phone'] = $row['sender_telephone'];
            $ship[$cr]['sender_city'] = $row['sender_city'];
            $ship[$cr]['sender_country'] = $row['sender_country'];
            $ship[$cr]['sender_zipcode'] = $row['sender_zipcode'];
            $ship[$cr]['sender_address'] = $row['sender_address'];
            $ship[$cr]['recipient_name'] = $row['recipient_name'];
            $ship[$cr]['recipient_phone'] = $row['recipient_telephone'];
            $ship[$cr]['recipient_city'] = $row['recipient_city'];
            $ship[$cr]['recipient_country'] = $row['recipient_country'];
            $ship[$cr]['recipient_zipcode'] = $row['recipient_zipcode'];
            $ship[$cr]['recipient_address'] = $row['recipient_address'];
            $ship[$cr]['tracking_status'] = $row['delivery_status'];
            $ship[$cr]['tracking_date'] = $row['tracking_date'];
            $ship[$cr]['user_id'] = $row['user_id'];
            $cr++;
        }
       // print_r($ship);
        echo json_encode($ship);
    }
    else{
       return http_response_code(404);
    }
?>
