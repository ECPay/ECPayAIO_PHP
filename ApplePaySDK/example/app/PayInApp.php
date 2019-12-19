<?php

$sLog_Path 	= '/var/tmp/applog_test.txt' ; // LOG路徑

$MerchantID 	= '3002739' ;
$HashKey 	= 'EXBteYAL70Kb4wvc' ;
$HashIV 	= '7Tv7WNVeUTj2giXi' ;
$ServiceURL 	= 'https://payment-stage.ecpay.com.tw/ApplePay/CreateServerOrder/V2';


$sLog = '傳入參數+++++++++++++++++++++++++++++++++++++++ ' . date('Y-m-d H:i:s') . ' ++++++++++++++++++++++++++++++++++++++++++++' . "\n";
$fp=fopen($sLog_Path, 'a+');
fputs($fp, $sLog);
fclose($fp);

$test = print_r($_POST, true);
$fp=fopen($sLog_Path, 'a+');
fputs($fp, $test);
fclose($fp);


include('ECPay.Payment.Applepay.php');
$aMsg_Return = array();
$sReturn_Msg = '' ;

if (isset($_POST['PaymentToken']))
{
	$_POST['PaymentToken'] = json_encode($_POST['PaymentToken']);
	//$_POST['PaymentToken'] = str_replace(' ', '+', $_POST['PaymentToken']);
}


$sLog = "\n" . 'json encode --------------------------------------------------------------------------------------------------------------------'. "\n";
$fp=fopen($sLog_Path, 'a+');
fputs($fp, $sLog);
fclose($fp);

$test = print_r($_POST, true);
$fp=fopen($sLog_Path, 'a+');
fputs($fp, $test);
fclose($fp);

$ecpay_apple_pay = new Ecpay_ApplePay ;
$ecpay_apple_pay->MerchantID 	= $MerchantID ;
$ecpay_apple_pay->HashKey 	= $HashKey ;
$ecpay_apple_pay->HashIV 	= $HashIV ;
$ecpay_apple_pay->ServiceURL 	= $ServiceURL;

// 送出資料
$sReturn_Msg =  $ecpay_apple_pay->CheckOut_App($_POST) ;
echo $sReturn_Msg ;

$sLog = "\n" . 'return ------------------------------------------------------------------------------------------------------------------------------'. "\n";
$fp=fopen($sLog_Path, 'a+');
fputs($fp, $sLog);
fclose($fp);

$test = $sReturn_Msg;
$fp=fopen($sLog_Path, 'a+');
fputs($fp, $test);
fclose($fp);

$sLog = "\n" . '++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++'. "\n";
$fp=fopen($sLog_Path, 'a+');
fputs($fp, $sLog);
fclose($fp);