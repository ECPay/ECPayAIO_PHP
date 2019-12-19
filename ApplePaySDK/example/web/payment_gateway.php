<?php

/*
* step2 送出交易資訊到綠界
*/

$sPayment	= isset($_POST['payment'])	? $_POST['payment']	: '123456789abcdefgABCDEFG!@#$%^&*()' ;
$nOrder_Id	= isset($_POST['order_id'])	? $_POST['order_id']	: 0 ;

// 依照訂單編號$nOrder_Id找出訂單資訊
if(true)
{
	$TotalAmount 	= 5 ; 			// 訂單金額
	$ItemName 	= '手機20元X2#隨身碟60元X1' ; 	// 商品名稱
}

include_once('ECPay.Payment.Applepay.php') ;
$ecpay_applepay = new Ecpay_ApplePay ;

// 蒐集參數
$ecpay_applepay->ServiceURL 			= 'https://payment-stage.ecpay.com.tw/ApplePay/CreateServerOrder/V2' ;
$ecpay_applepay->MerchantID 			= '2000132' ;
$ecpay_applepay->HashKey 			= '5294y06JbISpM5x9' ;
$ecpay_applepay->HashIV 			= 'v77hoKGq4kWxNNIS' ;

$ecpay_applepay->Send['MerchantTradeNo'] 	= $nOrder_Id;
$ecpay_applepay->Send['MerchantTradeDate'] 	= date('Y/m/d H:i:s');
$ecpay_applepay->Send['CurrencyCode'] 		= 'TWD' ;
$ecpay_applepay->Send['TradeDesc'] 		= 'ecpay商城購物' ;
$ecpay_applepay->Send['PlatformID'] 		= '' ;
$ecpay_applepay->Send['TradeType'] 		= 2;
$ecpay_applepay->Send['PaymentToken'] 		= $sPayment;

$ecpay_applepay->Send['TotalAmount'] 		= $TotalAmount;
$ecpay_applepay->Send['ItemName'] 		= $ItemName;

//ServerPost 回傳是json格式
$aMsg_Return = $ecpay_applepay->Check_Out();

// 執行訂單相關程序
if(true)
{
	// 廠商自行撰寫
}

echo json_encode($aMsg_Return);
