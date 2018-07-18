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

define('total',2000); //total value
define('buffer',50); //buffer value

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

while (($line = fgetcsv($file,2000,";")) !== FALSE) {
    if($j==(total)) break; //if total reaches the value, stops
    $main_array=array( //sequence map create -- You can edit this area by yourself in According to the exit Csv
        "ProductCode" => $line[0],
        "ProductName" => $line[1],
        "DefaultCategoryCode" => $line[2],
        "SupplierProductCode" => $line[3],
        "Barcode" => $line[4],
        "Stock" => $line[5],
        "StockUnit" => $line[6],
        "IsActive" => $line[7],
        "Vat" => $line[8],
        "Currency" => $line[9],
        "BuyingPrice" => $line[10],
        "SellingPrice" => $line[11],
        "SearchKeywords" => $line[12],
        "IsNewProduct" => $line[13],
        "OnSale" => $line[14],
        "ImageUrl" => $line[15],
        "IsDisplayProduct" => $line[16],
        "VendorDisplayOnly" => $line[17],
        "DisplayWithVat" => $line[18],
        "Brand" => $line[19],
        "Model" => $line[20],
        "HasSubProducts" => $line[21],
        "Supplier" => $line[22],
        "CustomerGroupDisplay" => $line[23],
        "Additional1" => $line[24],
        "Additional2" => $line[25],
        "Additional3" => $line[26],
        "RelatedProductsBlock1" => $line[27],
        "RelatedProductsBlock2" => $line[28],
        "RelatedProductsBlock3" => $line[29],
        "Magnifier" => $line[30],
        "MemberMinOrder" => $line[31],
        "MemberMaxOrder" => $line[32],
        "VendorMinOrder" => $line[33],
        "VendorMaxOrder" => $line[34],
        "FreeDeliveryMember" => $line[35],
        "FreeDeliveryVendor" => $line[36],
        "ShortDescription" => $line[37],
        "Details" => $line[38],
        "Width" => $line[39],
        "Height" => $line[40],
        "Depth" => $line[41],
        "Weight" => $line[42],
        "CBM" => $line[43],
        "Document" => $line[44],
        "Warehouse" => $line[45],
        "WarrantyInfo" => $line[46],
        "DeliveryInfo" => $line[47],
        "DeliveryTime" => $line[48],
        "ProductNote" => $line[49],
        "SeoSettingsId" => $line[50],
        "SeoTitle" => $line[51],
        "SeoKeywords" => $line[52],
        "SeoDescription" => $line[53],
        "ListNo" => $line[53],
        "Label1" => array(
            "Value" => 1
        ),
        "Label2" => array(
            "Value" => 0
        ),
        "Label3" => 1,
        "Label4" => 0,
        "Label5" => 0,
        "Label6" => 0,
        "Label7" => 0,
        "Label8" => 0,
        "Label9" => 0,
        "Label10" => 0
    );

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