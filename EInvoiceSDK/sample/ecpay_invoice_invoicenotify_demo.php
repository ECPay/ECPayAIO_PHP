<?php
try
{
	$sMsg = '' ;
// 1.載入SDK程式
	include_once('Ecpay_Invoice.php') ;
	$ecpay_invoice = new EcpayInvoice ;
// 2.寫入基本介接參數
	$ecpay_invoice->Invoice_Method 		= 'INVOICE_NOTIFY';
	$ecpay_invoice->Invoice_Url 		= 'https://einvoice-stage.ecpay.com.tw/Notify/InvoiceNotify' ;
	$ecpay_invoice->MerchantID 		= '2000132' ;
	$ecpay_invoice->HashKey 		= 'ejCk326UnaZWKisg' ;
	$ecpay_invoice->HashIV 			= 'q9jcZX8Ib9LM8wYk' ; 
// 3.寫入發票相關資訊
	$ecpay_invoice->Send['InvoiceNo'] 	= 'AL00001934'; 				// 發票號碼
	$ecpay_invoice->Send['NotifyMail'] 	= 'test@localhost.com'; 			// 發送電子信箱
	$ecpay_invoice->Send ['Notify'] 	= 'E'; 			 			// 發送方式
	$ecpay_invoice->Send['InvoiceTag'] 	= 'I'; 					 	// 發送內容類型
	$ecpay_invoice->Send ['Notified'] 	= 'C'; 					 	// 發送對象
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
