<?php
function send($fields,$url){ //send function
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);             
    curl_close($ch);  //web service  connection codes
    return json_decode($response); //return value
}

function delete($token,$delete,$url){ //delete function
    $url = "http://stajoguzcan.eticaret.in/rest1/product/deleteProducts"; //between the quotes enter your web service deleteProducts url
    $fields = array( 'token' => $token,
        'data' => json_encode($delete)); //We sent the values token and data
    return send($fields,$url); //return function value
}

define('total',1000); //total value
define('buffer',100); //buffer value

$url = "http://stajoguzcan.eticaret.in/rest1/auth/login/"; //between the quotes enter your web service login url
$username="username"; //between the quotes enter your web service username
$password="password"; //between the quotes enter your web service password

$url.=$username; //url for username we combine
$fields = array( 'pass' => $password); //password to array
$token = send($fields,$url)->{'data'}[0]->{'token'}; //the token we shot


$url = "http://stajoguzcan.eticaret.in/rest1/product/getProducts"; //between the quotes enter your web service getProducts url
$fields = array( 'token' => $token,
'limit' => buffer); //We sent the values token and limit


$j=0; //total counter
$k=0; //buffer counter

$delete_array=array(); //null array create
$time_start = microtime(true); //time start

$line = send($fields,$url); //invoke a function line
while($j<total){
    $transfer_array=array(
        "ProductCode" => $line->{'data'}[$k]->{'ProductCode'} //receive product codes
    );

    $j++; //plus total counter
    $k++; //plus buffer counter

    if($j%buffer==0 || $j==total){ //if your buffer==zero of if the value reaches
        array_push($delete_array, $transfer_array); //combine sequences
        $result = delete($token,$delete_array,$url); //invoke a function delete
        echo $result->{'message'}[0]->{'text'}[0]." Ürün -".$j."<hr>"; //get feedback
        unset($delete_array); //delete
        $delete_array=array(); //null array create
        $line = send($fields,$url); //invoke a function line
        $k=0;   //to reset buffer counter
    }
    else{
        array_push($delete_array, $transfer_array); //combine sequences
    }
}
$time_stop = microtime(true); //time stop
$time = $time_stop - $time_start; //Elapsed time
echo "Standby time:".$time."second"; //Elapsed time print on screen
?>