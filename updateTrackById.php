<?php
    require 'connect.php';
    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){

        $getdata = json_decode($postdata);

        //Sanitize.k
         //Sanitize.       
         $track_id = mysqli_real_escape_string($con, trim($getdata->tracking_id));
         $trackno = mysqli_real_escape_string($con, trim($getdata->tracking_number));
         $package = mysqli_real_escape_string($con, trim($getdata->tracking_package));
         $status = mysqli_real_escape_string($con, trim($getdata->tracking_status));

         $sender_name = mysqli_real_escape_string($con, trim($getdata->sender_name));
         $sender_phone = mysqli_real_escape_string($con, trim($getdata->sender_phone));
         $sender_email = mysqli_real_escape_string($con, trim($getdata->sender_email));
         $sender_city = mysqli_real_escape_string($con, trim($getdata->sender_city));
         $sender_country = mysqli_real_escape_string($con, trim($getdata->sender_country));
         $sender_zipcode = mysqli_real_escape_string($con, trim($getdata->sender_zipcode));
         $sender_address = mysqli_real_escape_string($con, trim($getdata->sender_address));

         $recipient_name = mysqli_real_escape_string($con, trim($getdata->recipient_name));
         $recipient_email = mysqli_real_escape_string($con, trim($getdata->recipient_email));
         $recipient_phone = mysqli_real_escape_string($con, trim($getdata->recipient_phone));
         $recipient_city = mysqli_real_escape_string($con, trim($getdata->recipient_city));
         $recipient_country = mysqli_real_escape_string($con, trim($getdata->recipient_country));
         $recipient_zipcode = mysqli_real_escape_string($con, trim($getdata->recipient_zipcode));
         $recipient_address = mysqli_real_escape_string($con, trim($getdata->recipient_address));

         $date = date('Y-m-d');

        
        $sql = "UPDATE tracking SET 
                tracking_number = '$trackno', package = '$package', sender_name = '$sender_name', 
                sender_telephone = '$sender_phone', sender_email = '$sender_email', sender_city = '$sender_city',
                sender_country = '$sender_country', sender_zipcode = '$sender_zipcode', sender_address = '$sender_address', 
                recipient_name = '$recipient_name', recipient_telephone = '$recipient_phone',recipient_email = '$recipient_email', 
                recipient_city = '$recipient_city', recipient_country = '$recipient_country', recipient_zipcode = '$recipient_zipcode', 
                recipient_address = '$recipient_address', delivery_status = '$status', tracking_date = '$date', user_id = 1
                WHERE tracking_id = $track_id";
    
          if($result = mysqli_query($con,$sql))
          {                 
            echo "inserted successfully";
            http_response_code(204);
          }else{
          die("QUERY FAILED ". $con);
          }

    
}
?>