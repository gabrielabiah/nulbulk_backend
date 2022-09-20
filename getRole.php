<?php
    require 'connect.php';
    error_reporting(E_ERROR);
    $role = [];

    $sql = "SELECT * FROM `role`";
    
    if($result = mysqli_query($con,$sql))
    {
        $cr = 0;
        while($row = mysqli_fetch_array($result)){
            $role[$cr]['id'] = $row['role_id'];
            $role[$cr]['name'] = $row['role_name'];
            $cr++;
        }
       // print_r($role);
        echo json_encode($role);
    }
    else{
       return http_response_code(404);
    }
?>
