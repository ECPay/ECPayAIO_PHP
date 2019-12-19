<?php

try
{
	
	$sMsg = '' ;
	
	// 1.載入SDK
	include_once('Ecpay_Invoice.php') ;
	$ecpay_invoice = new EcpayInvoice ;
	
	// 2.寫入基本介接參數
	$ecpay_invoice->Invoice_Method 		= 'INVOICE_VOID' ;
	$ecpay_invoice->Invoice_Url 		= 'https://einvoice-stage.ecpay.com.tw/Invoice/IssueInvalid';
	$ecpay_invoice->MerchantID 		= '2000132';
	$ecpay_invoice->HashKey 		= 'ejCk326UnaZWKisg';
	$ecpay_invoice->HashIV 			= 'q9jcZX8Ib9LM8wYk';
	
	// 3.寫入發票相關資訊
	$ecpay_invoice->Send['InvoiceNumber'] 	= 'AL00001849';
	$ecpay_invoice->Send['Reason'] 		= 'ISSUE INVALID TEST';
	
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
