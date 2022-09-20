<?php
    require 'connect.php';
    error_reporting(E_ERROR);
    $users = [];

    $sql = "SELECT * FROM users";

    if($result = mysqli_query($con,$sql))
    {
        $cr = 0;
        while($row = mysqli_fetch_assoc($result)){      
            $users[$cr]['id'] = $row['user_id'];
            $users[$cr]['username'] = $row['username'];
            $users[$cr]['firstname'] = $row['user_firstname'];
            $users[$cr]['lastname'] = $row['user_lastname'];
            $users[$cr]['email'] = $row['user_email'];
            $users[$cr]['telephone'] = $row['user_telephone'];
            $role= $row['role_id']; 
           
            $sql1 = "SELECT * FROM `role` WHERE role_id = {$role}";
            if($result1 = mysqli_query($con,$sql1))
            {                 
                while($row = mysqli_fetch_array($result1)){
                    $users[$cr]['role'] = $row['role_name'];
                }
            }

            $cr++;
        }
        
       // print_r($users);
        echo json_encode($users);
    }
    else{
       return http_response_code(404);
    }
?>
