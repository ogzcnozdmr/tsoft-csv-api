<?php
function array_to_csv_function($array, $filename = "export.csv", $delimiter=";") {  //array_to_csv function
	 $f = fopen('php://memory', 'w'); 
	 foreach ($array as $line) { //With a foreach loop
	 	fputcsv($f, $line, $delimiter);
	 }
	 fseek($f, 0);
	 header('Content-Type: application/csv'); //content type
	 header('Content-Disposition: attachment; filename="'.$filename.'";'); //content disposition
	 fpassthru($f); 
}

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

define('total',50); //total value

$url = "http://stajoguzcan.eticaret.in/rest1/auth/login/"; //between the quotes enter your web service login url
$username="username"; //between the quotes enter your web service username
$password="password"; //between the quotes enter your web service password

$url.=$username; //url for username we combine
$fields = array( 'pass' => $password); //password to array
$token = send($fields,$url)->{'data'}[0]->{'token'}; //the token we shot

$url = "http://stajoguzcan.eticaret.in/rest1/product/getProducts"; //between the quotes enter your web service getProducts url
$fields = array( 'token' => $token,
'limit' => total); //We sent the values token and limit

$j=0; //total counter
$transfer_array=array(array( //sequence map create head
	"ProductCode","ProductName","DefaultCategoryCode","SupplierProductCode","Barcode","Stock","StockUnit","IsActive",
	"Vat","Currency","BuyingPrice","SellingPrice","SearchKeywords",
	"IsNewProduct","OnSale","ImageUrl","IsDisplayProduct","VendorDisplayOnly","DisplayWithVat"
	,"Brand","Model","HasSubProducts","Supplier","CustomerGroupDisplay","Additional1","Additional2","Additional3",
	"RelatedProductsBlock1","RelatedProductsBlock2","RelatedProductsBlock3","Magnifier","MemberMinOrder",
	"MemberMaxOrder","VendorMinOrder","VendorMaxOrder","FreeDeliveryMember","FreeDeliveryVendor",
	"ShortDescription","Details","Width","Height","Depth","Weight","CBM","Document","Warehouse","WarrantyInfo",
	"DeliveryInfo","DeliveryTime","ProductNote","SeoSettingsId","SeoTitle","SeoKeywords","SeoDescription",
	"ListNo","Label1","Label2","Label3","Label4","Label5","Label6","Label7","Label8","Label9","Label10"
));

$line = send($fields,$url); //invoke a function line
while($j<total){
    array_push($transfer_array,array( //sequence map create body
    	$line->{'data'}[$j]->{'ProductCode'},
    	$line->{'data'}[$j]->{'ProductName'},
    	$line->{'data'}[$j]->{'DefaultCategoryCode'},
    	$line->{'data'}[$j]->{'SupplierProductCode'},
    	$line->{'data'}[$j]->{'Barcode'},
    	$line->{'data'}[$j]->{'Stock'},
    	$line->{'data'}[$j]->{'StockUnit'},
    	$line->{'data'}[$j]->{'IsActive'},
    	$line->{'data'}[$j]->{'Vat'},
    	$line->{'data'}[$j]->{'Currency'},
    	$line->{'data'}[$j]->{'BuyingPrice'},
    	$line->{'data'}[$j]->{'SellingPrice'},
    	$line->{'data'}[$j]->{'SearchKeywords'},
    	$line->{'data'}[$j]->{'IsNewProduct'},
    	$line->{'data'}[$j]->{'OnSale'},
    	$line->{'data'}[$j]->{'ImageUrl'},
    	$line->{'data'}[$j]->{'IsDisplayProduct'},
    	$line->{'data'}[$j]->{'VendorDisplayOnly'},
    	$line->{'data'}[$j]->{'DisplayWithVat'},
    	$line->{'data'}[$j]->{'Brand'},
    	$line->{'data'}[$j]->{'Model'},
    	$line->{'data'}[$j]->{'HasSubProducts'},
    	$line->{'data'}[$j]->{'Supplier'},
    	$line->{'data'}[$j]->{'CustomerGroupDisplay'},
    	$line->{'data'}[$j]->{'Additional1'},
    	$line->{'data'}[$j]->{'Additional2'},
    	$line->{'data'}[$j]->{'Additional3'},
    	$line->{'data'}[$j]->{'RelatedProductsBlock1'},
    	$line->{'data'}[$j]->{'RelatedProductsBlock2'},
    	$line->{'data'}[$j]->{'RelatedProductsBlock3'},
    	$line->{'data'}[$j]->{'Magnifier'},
    	$line->{'data'}[$j]->{'MemberMinOrder'},
    	$line->{'data'}[$j]->{'MemberMaxOrder'},
    	$line->{'data'}[$j]->{'VendorMinOrder'},
    	$line->{'data'}[$j]->{'VendorMaxOrder'},
    	$line->{'data'}[$j]->{'FreeDeliveryMember'},
    	$line->{'data'}[$j]->{'FreeDeliveryVendor'},
    	$line->{'data'}[$j]->{'ShortDescription'},
    	$line->{'data'}[$j]->{'Details'},
    	$line->{'data'}[$j]->{'Width'},
    	$line->{'data'}[$j]->{'Height'},
    	$line->{'data'}[$j]->{'Depth'},
    	$line->{'data'}[$j]->{'Weight'},
    	$line->{'data'}[$j]->{'CBM'},
    	$line->{'data'}[$j]->{'Document'},
    	$line->{'data'}[$j]->{'Warehouse'},
    	$line->{'data'}[$j]->{'WarrantyInfo'},
    	$line->{'data'}[$j]->{'DeliveryInfo'},
    	$line->{'data'}[$j]->{'DeliveryTime'},
    	$line->{'data'}[$j]->{'ProductNote'},
    	$line->{'data'}[$j]->{'SeoSettingsId'},
    	$line->{'data'}[$j]->{'SeoTitle'},
    	$line->{'data'}[$j]->{'SeoKeywords'},
    	$line->{'data'}[$j]->{'SeoDescription'},
    	$line->{'data'}[$j]->{'ListNo'},
    	$line->{'data'}[$j]->{'Label1'}->{'Value'},
    	$line->{'data'}[$j]->{'Label2'}->{'Value'},
    	$line->{'data'}[$j]->{'Label3'}->{'Value'},
    	$line->{'data'}[$j]->{'Label4'}->{'Value'},
    	$line->{'data'}[$j]->{'Label5'}->{'Value'},
    	$line->{'data'}[$j]->{'Label6'}->{'Value'},
    	$line->{'data'}[$j]->{'Label7'}->{'Value'},
    	$line->{'data'}[$j]->{'Label8'}->{'Value'},
    	$line->{'data'}[$j]->{'Label9'}->{'Value'},
    	$line->{'data'}[$j]->{'Label10'}->{'Value'}
    ));
    $j++;
}
array_to_csv_function($transfer_array, "export.csv"); //call function
?>