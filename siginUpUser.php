<?php
    require 'connect.php';
    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){

        $getdata = json_decode($postdata);

        //Sanitize.k
         //Sanitize.       
         $firstname = mysqli_real_escape_string($con, trim($getdata->fname));
         $lastname = mysqli_real_escape_string($con, trim($getdata->lname));
         $username = '';// mysqli_real_escape_string($con, trim($getdata->username));
         $email = mysqli_real_escape_string($con, trim($getdata->email));
         $password = mysqli_real_escape_string($con, trim($getdata->password));
         $role = mysqli_real_escape_string($con, trim($getdata->role));

        /* $password = password_hash($password,PASSWORD_BCRYPT,array('cost' => 12 )); */
/* 
         $query = "SELECT * FROM `role` WHERE role_name = '$role'";
         $select_user_query = mysqli_query($con, $query);
    
         if(!$select_user_query){
             die ('QUERY FAILED' . mysqli_error($con));
         }

         while ($row = mysqli_fetch_array($select_user_query)) {
           echo  $db_role_id = $row['role_id'];             
        }
 */
     echo  $sql = "INSERT INTO `users`(`user_first_name`,`user_last_name`,`user_email`,`user_password`,`user_role`)
              VALUES('$firstname','$lastname','$email','$password','$role')";
   
        $result = mysqli_query($con,$sql);
    if($result)
    {
      
      echo "inserted successfully";
      http_response_code(204);
    }
    else{
      die("QUERY FAILED". $con);
      /*   echo "insertion failed";
      return  http_response_code(422); */
    }
}
?>