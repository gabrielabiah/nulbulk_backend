<?php
    require 'connect.php';
    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
     //   print_r($postdata);
        $getdata = json_decode($postdata);

        //Sanitize.k
         //Sanitize.       
         $email = mysqli_real_escape_string($con, trim($getdata->email));
         $password = mysqli_real_escape_string($con, trim($getdata->password));
    
        $userInfo = [];

    $sql = "SELECT * FROM users WHERE user_email = '{$email}'";
    
        if($result = mysqli_query($con,$sql))
        {
            $count = mysqli_num_rows($result);
            if($count>0){
                while($row = mysqli_fetch_array($result)){
                    $userInfo['id'] = $row['user_id'];
                    $userInfo['username'] = $row['user_first_name'];
                    $userInfo['firstname'] = $row['user_last_name'];
                    $userInfo['lastname'] = $row['user_other_name'];
                    $userInfo['email'] = $row['user_email'];
                   // $userInfo['telephone'] = $row['user_telephone'];
                  //  $role= $row['role_id'];    
                    $db_user_password = $row['user_password'];   
                    
                    /* $sql = "SELECT * FROM `role` WHERE role_id = {$role}";
    
                    if($result = mysqli_query($con,$sql))
                    {                 
                            while($row = mysqli_fetch_array($result)){
                                $userInfo['role'] = $row['role_name'];
                            }
                        } */
                }
    
               
                if ($password === $db_user_password) {
                    /* $_SESSION['username'] = $db_username;
                    $_SESSION['firstname'] = $db_user_firstname;
                    $_SESSION['lastname'] = $db_user_lastname;
                    $_SESSION['user_role'] = $db_user_role; */
               // print_r($userInfo);
                echo json_encode($userInfo);
                }else{
                    echo json_encode("Invalid password");
                    return http_response_code(400);
                }
            }else{
                return http_response_code(403);
            }
           
        }
        else{
           return http_response_code(404);
        }
 
    }
?>