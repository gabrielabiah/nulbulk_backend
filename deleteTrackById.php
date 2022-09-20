<?php
    require 'connect.php';
    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){

        $getdata = json_decode($postdata);

        //Sanitize.k
         //Sanitize.       
    echo     $track_id = mysqli_real_escape_string($con, trim($getdata->id));


         $date = date('Y-m-d');

        
      echo  $sql = "DELETE FROM tracking WHERE tracking_id = $track_id";
    
          if($result = mysqli_query($con,$sql))
          {                 
            echo "deleted successfully";
            http_response_code(204);
          }else{
          die("QUERY FAILED ". $con);
          }

    
}
?>