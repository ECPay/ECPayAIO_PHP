<?php
try
{
	$sMsg = '' ;
// 1.載入SDK程式
	include_once('Ecpay_Invoice.php') ;
	$ecpay_invoice = new EcpayInvoice ;
// 2.寫入基本介接參數
	$ecpay_invoice->Invoice_Method 		= 'INVOICE_SEARCH'; 		// 請見16.1操作發票功能類別
	$ecpay_invoice->Invoice_Url 		= 'https://einvoice-stage.ecpay.com.tw/Query/Issue' ;
	$ecpay_invoice->MerchantID 		= '2000132' ;
	$ecpay_invoice->HashKey 		= 'ejCk326UnaZWKisg' ;
	$ecpay_invoice->HashIV 			= 'q9jcZX8Ib9LM8wYk' ;
// 3.寫入發票傳送資訊
	$ecpay_invoice->Send['RelateNumber'] 	= 'ALLPAY201601112134252076398322'; // 廠商自訂編號
// 4.送出
	$aReturn_Info = $ecpay_invoice->Check_Out();


// 5.返回
	foreach($aReturn_Info as $key => $value)
	{
		$sMsg .=   $key . ' => ' . $value . '<br>' ;
	}
}
catch (Exception $e)
{
	// 例外錯誤處理。
	$sMsg = $e->getMessage();
}
echo $sMsg ;
