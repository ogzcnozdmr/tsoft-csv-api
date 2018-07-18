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

function connections($token,$transfer,$url){ //connections function
    $fields = array( 'token' => $token,
        'data' => json_encode($transfer)); //We sent the values token and data
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
$url = "http://stajoguzcan.eticaret.in/rest1/product/createProducts"; //between the quotes enter your web service getProducts url
        
$transfer_array=array(); //null array create
$j=0; //total counter

$file = fopen('csvname.csv', 'r');  //enter to csvname
$time_start = microtime(true); //time start

$col = fgetcsv($file,2000,";"); //first read the lead -- for example 18 colums
while (($line = fgetcsv($file,2000,";")) !== FALSE) {
    if($j==(total)) break; //if total reaches the value, stops
    $main_array=array( //sequence map create -- You can edit this area by yourself in According to the exit Csv
        $col[0] => $line[0],
        $col[1] => $line[1],
        $col[2] => $line[2],
        $col[3] => $line[3],
        $col[4] => $line[4],
        $col[5] => $line[5],
        $col[6] => $line[6],
        $col[7] => $line[7],
        $col[8] => $line[8],
        $col[9] => $line[9],
        $col[10] => $line[10],
        $col[11] => $line[11],
        $col[12] => $line[12],
        $col[13] => $line[13],
        $col[14] => $line[14],
        $col[15] => $line[15],
        $col[16] => $line[16],
        $col[17] => $line[17]
    ); //Your csv file column by create

    $j++;
    if($j%buffer==0 || $j==total){ //if your buffer==zero of if the value reaches
        array_push($transfer_array, $main_array); //combine sequences
        $result = connections($token,$transfer_array,$url); //result connection
        echo $result->{'message'}[0]->{'id'}." web servis your coded product = "; //get feedback
        echo $result->{'message'}[0]->{'text'}[0]." Product -".$j."<hr>"; //get feedback
        unset($transfer_array); //delete array
        $transfer_array=array(); //null array create
    }
    else{
        array_push($transfer_array, $main_array); //combine sequences
    }
}
$time_stop = microtime(true); //time stop
$time = $time_stop - $time_start; //Elapsed time
echo "Standby time:".$time."second"; //Elapsed time print on screen
fclose($file); //close to file
?>