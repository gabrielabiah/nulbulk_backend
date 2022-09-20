<?php
    require 'connect.php';
    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){

        $getdata = json_decode($postdata);

        //Sanitize.k
         //Sanitize.       
         $trackno = mysqli_real_escape_string($con, trim($getdata->tracking_number));
         $package = mysqli_real_escape_string($con, trim($getdata->tracking_package));
         $status = mysqli_real_escape_string($con, trim($getdata->tracking_status));

         $sender_fname = mysqli_real_escape_string($con, trim($getdata->sender_fname));
         $sender_lname = mysqli_real_escape_string($con, trim($getdata->sender_lname));
         $sender_oname = mysqli_real_escape_string($con, trim($getdata->sender_oname));
         $sender_name = $sender_fname. " ".$sender_lname." ".$sender_oname;
         $sender_phone = mysqli_real_escape_string($con, trim($getdata->sender_phone));
         $sender_email = mysqli_real_escape_string($con, trim($getdata->sender_email));
         $sender_city = mysqli_real_escape_string($con, trim($getdata->sender_city));
         $sender_country = mysqli_real_escape_string($con, trim($getdata->sender_country));
         $sender_zipcode = mysqli_real_escape_string($con, trim($getdata->sender_zipcode));
         $sender_address = mysqli_real_escape_string($con, trim($getdata->sender_address));

         $recipient_fname = mysqli_real_escape_string($con, trim($getdata->recipient_fname));
         $recipient_lname = mysqli_real_escape_string($con, trim($getdata->recipient_lname));
         $recipient_oname = mysqli_real_escape_string($con, trim($getdata->recipient_oname));
         $recipient_name = $recipient_fname. " ".$recipient_lname." ".$recipient_oname;
         $recipient_email = mysqli_real_escape_string($con, trim($getdata->recipient_email));
         $recipient_phone = mysqli_real_escape_string($con, trim($getdata->recipient_phone));
         $recipient_city = mysqli_real_escape_string($con, trim($getdata->recipient_city));
         $recipient_country = mysqli_real_escape_string($con, trim($getdata->recipient_country));
         $recipient_zipcode = mysqli_real_escape_string($con, trim($getdata->recipient_zipcode));
         $recipient_address = mysqli_real_escape_string($con, trim($getdata->recipient_address));

         $date = date('Y-m-d');

        
         $sql = "INSERT INTO tracking(tracking_number, package, sender_name, sender_telephone,sender_email, sender_city,
            sender_country, sender_zipcode, sender_address, recipient_name, recipient_telephone,recipient_email, recipient_city,
            recipient_country, recipient_zipcode, recipient_address, delivery_status, tracking_date, user_id) 
         VALUES ('$trackno','$package', '$sender_name', '$sender_phone','$sender_email', '$sender_city', 
            '$sender_country', '$sender_zipcode', '$sender_address', '$recipient_name', '$recipient_phone','$recipient_email',
            '$recipient_city', 
            '$recipient_country', '$recipient_zipcode', '$recipient_address', '$status', '$date', 1)";
    
          if($result = mysqli_query($con,$sql))
          {                 
           /*  while($row = mysqli_fetch_array($result)){
                $userInfo['role'] = $row['role_name'];
            } */

            echo "inserted successfully";
            http_response_code(204);
          }else{
          die("QUERY FAILED ". $con);
          }

    /*    $sql = "INSERT INTO tracking(tracking_number,package,sender) VALUES($msg)";
   
        $result = mysqli_query($con,$sql);
    if($result)
    {
      echo "inserted successfully";
      http_response_code(204);
    }
    else{
      return  http_response_code(422);
    } */
}
?>