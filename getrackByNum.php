<?php
    require 'connect.php';
    error_reporting(E_ERROR);
    $ship = [];

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
     //   print_r($postdata);
        $getdata = json_decode($postdata);

        //Sanitize.k
         //Sanitize.       
         $trackno = mysqli_real_escape_string($con, trim($getdata->track));

    $sql = "SELECT * FROM tracking WHERE tracking_number = '$trackno' LIMIT 1";
    
    if($result = mysqli_query($con,$sql))
    {
        $cr = 0;
        while($row = mysqli_fetch_array($result)){
            $ship['id'] = $row['tracking_id'];
            $ship['tracking_number'] = $row['tracking_number'];
            $ship['package'] = $row['package'];
            $ship['sender_name'] = $row['sender_name'];
            $ship['sender_phone'] = $row['sender_telephone'];
            $ship['sender_email'] = $row['sender_email'];
            $ship['sender_city'] = $row['sender_city'];
            $ship['sender_country'] = $row['sender_country'];
            $ship['sender_zipcode'] = $row['sender_zipcode'];
            $ship['sender_address'] = $row['sender_address'];
            $ship['recipient_name'] = $row['recipient_name'];
            $ship['recipient_phone'] = $row['recipient_telephone'];
            $ship['recipient_email'] = $row['recipient_email'];
            $ship['recipient_city'] = $row['recipient_city'];
            $ship['recipient_country'] = $row['recipient_country'];
            $ship['recipient_zipcode'] = $row['recipient_zipcode'];
            $ship['recipient_address'] = $row['recipient_address'];
            $ship['tracking_status'] = $row['delivery_status'];
          //  $ship['tracking_date'] = $row['tracking_date'];
            $cr++;
        }
       // print_r($ship);
        echo json_encode($ship);
    }
    else{
        echo mysqli_error($con);
       return http_response_code(404);
    }
    }
?>
