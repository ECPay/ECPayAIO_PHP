<?php
/*
* 測試憑證是否正確與apple連線
*/

include_once('config.php') ;
include_once('ECPay.Payment.Applepay.php') ;
$ecpay_applepay = new Ecpay_ApplePay ;

$ecpay_applepay->ServiceURL 				= 'https://apple-pay-gateway-cert.apple.com/paymentservices/startSession' ; 	// 串傳送位置

$ecpay_applepay->Verify_Vendor['displayName'] 		= APPLEPAY_DISPLAY_NAME;
$ecpay_applepay->Verify_Vendor['crt_path'] 		= APPLEPAY_CRT_PATH; 	// 憑證檔案絕對路徑
$ecpay_applepay->Verify_Vendor['key_path'] 		= APPLEPAY_KEY_PATH; 	// 憑證檔案絕對路徑
$ecpay_applepay->Verify_Vendor['key_password'] 		= APPLE_PASSWORD;

$aMsg_Return = $ecpay_applepay->Verify_Vendor_Test();

echo $aMsg_Return;
