<?php
    require 'connect.php';
    $postdata = file_get_contents("php://input");

    $currentDate = date('Y-m-d');

        //TESTING CURRENT DATE
  //  $currentDate = date('2020-06-12');

    $url = 'http://localhost/idalert/viewMembersDummy.php';
    $json = file_get_contents($url);
    $details = json_decode($json, TRUE);

    // var_export($details);
     
    foreach ($details as $k){
        $firstname = mysqli_real_escape_string($con, trim($k['firstname']));
        $lastname =  mysqli_real_escape_string($con, trim($k['lastname']));
        $othername = mysqli_real_escape_string($con, trim($k['othername']));
        $number =    mysqli_real_escape_string($con, trim($k['number']));
        //   $idnumber = 
        $idnumber = mysqli_real_escape_string($con, trim($k['member_id']));
        $dateIssued = mysqli_real_escape_string($con, trim($k['date_of_issue']));
        $renewedDate = mysqli_real_escape_string($con, trim($k['last_renewed_date'])); 
        $cardExpirydate = mysqli_real_escape_string($con, trim($k['expiry_date'])); 
        $status = mysqli_real_escape_string($con, trim($k['card_status'])); 
     echo "DAYS LEFT ".  $days = mysqli_real_escape_string($con, trim($k['days_left'])); 

     //   $currentDate = strtotime($currentDate); 
      //  $cardExpirydate = strtotime($cardExpirydate); 
        
        // Get the difference and divide into  
        // total no. seconds 60/60/24 to get  
        // number of days 
       //   $days = ($cardExpirydate - $currentDate) /60/60/24; 
        //echo "CHECKING DAYS BTN CURRENT DATE AND CARD EXPIRY DATE=". $days." ";

        if($days >0 && $days <=30){

            echo "days is less than 30 =". $days;

            $sql = "SELECT * FROM `sms_delivery_report` WHERE card_id = '{$idnumber}'";
            $find_query = mysqli_query($con, $sql);
            $count = mysqli_num_rows($find_query);
                //  echo "count ", $count;
    
                //IF NOT IN DATABASE
            if($count < 1){

                $sql = "SELECT * FROM `card` WHERE card_id = {$idnumber}";
                $find_query = mysqli_query($con, $sql);
                $count1 = mysqli_num_rows($find_query);
                 // echo " count1 ".$count1;
                //SAVE IN CARD DATABASE
                if($count1 < 1){
                    echo "checking saving ".$idnumber.' '.$count1.' ';
                    $sql1 ="INSERT INTO `card` (`card_id`,`card_issued_date`,`card_renewed_date`,`card_expiry_date`,`card_status`)
                    VALUES ({$idnumber},'{$dateIssued}','{$renewedDate}','{$cardExpirydate}','{$status}')";
                    $send_query = mysqli_query($con, $sql1);
    
                    if(!$send_query){
                        die("queryy failed ".mysqli_error($con));
                    }

                    if($days == 1){
                        smsapi($firstname,$number,$days,$idnumber,$currentDate," Your CARD expiration date is due.");
        
                    }
                    else{
                   
                        smsapi($firstname,$number,$days,$idnumber,$currentDate);
        
                        }
                }
                

                


        
            }
            else{
               // echo "data in database";
                //DATA IN DATABASE

                while($row = mysqli_fetch_array($find_query)){
                    $lastDeliveryReport= $row['report_delivery_date'];
                   // echo "last sent SMS ". $lastDeliveryReport ."<br>";
                }
            
                if(!$find_query){
                echo "queryy failed",mysqli_error($con);
                }

                $current_date = date('Y-m-d');
                $datetime1 = strtotime(date('Y-m-d', strtotime($current_date)));
                $datetime2 = strtotime(date('Y-m-d', strtotime($lastDeliveryReport)));

                $secs = $datetime1 - $datetime2;// == <seconds between the two times>
                $smsdays = $secs / 86400;


             
                  echo "smsdate gap ". $smsdays;

                 // IF LAST SENT SMS IS 10 DAYS FROM NOW.
                if($days ==10 && $smsdays >7){
                   echo "smsday diff is 10";
                   smsapi($firstname,$number,$days,$idnumber,$currentDate);

                
                }                    
                elseif ($days == 0 && $smsdays >1) { //IF LAST SENT SMS IS BTN 1 
                   echo "smsday diff is ".$smsdays;
                   smsapi($firstname,$number,$days,$idnumber,$currentDate," Your CARD expiration date is due.");
                }
            
            }

            
        }else if($days < 1){
           // echo "days is greater than 30 =". $days.' ';

            $sql = "SELECT * FROM `sms_delivery_report` WHERE card_id = '{$idnumber}'";
            $find_query = mysqli_query($con, $sql);
            $count = mysqli_num_rows($find_query);
                  echo "count ", $count;
    
                //IF NOT IN DATABASE
            if($count < 1){

                $sql = "SELECT * FROM `card` WHERE card_id = {$idnumber}";
                $find_query = mysqli_query($con, $sql);
                $count1 = mysqli_num_rows($find_query);
                  echo " count1 ".$count1;
                //SAVE IN CARD DATABASE
                if($count1 < 1){
                  //  echo "checking saving ".$idnumber.' '.$count1.' ';
                    $sql1 ="INSERT INTO `card` (`card_id`,`card_issued_date`,`card_renewed_date`,`card_expiry_date`,`card_status`)
                    VALUES ({$idnumber},'{$dateIssued}','{$renewedDate}','{$cardExpirydate}','{$status}')";
                    $send_query = mysqli_query($con, $sql1);
    
                    if(!$send_query){
                        die("queryy failed ".mysqli_error($con));
                    }

                    
                
                   
                       smsapi($firstname,$number,$days,$idnumber,$currentDate," Your CARD has expired.");
        
                        
                }
                

                


        
            }else{
                while($row = mysqli_fetch_array($find_query)){
                    $lastDeliveryReport= $row['report_delivery_date'];
                   // echo "last sent SMS ". $lastDeliveryReport ."<br>";
                }
            
                if(!$find_query){
                echo "queryy failed",mysqli_error($con);
                }

                    $current_date = date('Y-m-d');
                    $datetime1 = strtotime(date('Y-m-d', strtotime($current_date)));
                    $datetime2 = strtotime(date('Y-m-d', strtotime($lastDeliveryReport)));

                    $secs = $datetime1 - $datetime2;// == <seconds between the two times>
                    $smsdays = $secs / 86400;


             
                  echo "smsdate gap ". $smsdays;

                 // IF LAST SENT SMS IS 10 DAYS FROM NOW.
                if($days ==10 && $smsdays >1){
                   echo "smsday diff is 10";
                   smsapi($firstname,$number,$days,$idnumber,$currentDate);

                
                }                    
                elseif ($days == 0 && $smsdays >1) { //IF LAST SENT SMS IS BTN 1 
                   echo "smsday diff is ".$smsdays;
                   smsapi($firstname,$number,$days,$idnumber,$currentDate," Your CARD expiration date is due.");
                }
            }
            
        }


       
        

    

    

    
        
    
    }


           
        
        

function smsapi($fname,$number,$days,$idnumber,$currentDate,$message = null){
    global $con;
    $endPoint = 'https://api.mnotify.com/api/sms/quick';
    $apiKey ='0eHNm9PvaACqrbi3NpUqauH7DUukByLBMsp9CeFMPidht';
    $url = $endPoint . '?key=' . $apiKey;
    $smg =  ', You have '.$days.' days left for your card to expire.';
    $renewCode= '*929#';
   // var_dump(is_int($renewCode));
    if($message){
        $smg = $message;
    }
    $data = [
      'recipient' => [$number,'0208512258'],
      'sender' => 'PROJECT2020',
      'message' => 'Hi '.$fname . $smg . ' Kindly dial '.$renewCode.' to renew now',
      'is_schedule' => 'false',
      'schedule_date' => ''
    ];
   // print_r ($data);
    $ch = curl_init();
    $headers = array();
    $headers[] = "Content-Type: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
       // print_r($result);
    $result = json_decode($result);
     // echo $result;

     
   

    if($result){
        $sql2 ="INSERT INTO `sms_delivery_report` (`card_id`,`report_message`,`report_status`,`report_delivery_date`) 
        VALUES ('{$idnumber}','{$result->message}','{$result->status}','{$currentDate}')";
     // echo $sql2;
        $send_query2 = mysqli_query($con, $sql2);

       if(!$send_query2){
           echo "queryy failed",$con;
       }

       $sql_update = "UPDATE `card` SET  card_renewed_date = '$currentDate'";
       $update_query = mysqli_query($con,$sql_update);

       if(!$update_query){
         echo "queryy failed",mysqli_error($con);
        }
    }

    curl_close($ch);
}


function smsapi2(){

//Set Time Zone as this is very important to ensure your messages are delievered on time
date_default_timezone_set('Africa/Accra');
$clientId = '5e849cf358bec';
$applicationSecret = '268b35a88b8227606d9db1e8ff382611';
$url = 'https://app.helliomessaging.com/api/v2/sms';
$currentTime = date('YmdH');
$hashedAuthKey = sha1($clientId.$applicationSecret.$currentTime);
$senderId = 'ID Notifier';
$msisdn = '233540417843';
$message = 'Testing NHIS ID notifier';
$params = [
    'clientId' => $clientId,
    'authKey' => $hashedAuthKey,
    'senderId' => $senderId,
    'msisdn' => $msisdn,
    'message' => $message
];
$ch = curl_init($url);
$payload = json_encode($params);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($payload))
);
$result = curl_exec ($ch);
echo var_export($result, true);
curl_close ($ch);

}
