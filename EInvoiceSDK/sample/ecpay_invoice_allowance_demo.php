
<?php

try
{
	
	$sMsg = '' ;
	
	// 1.載入SDK
	include_once('Ecpay_Invoice.php') ;
	$ecpay_invoice = new EcpayInvoice ;
	
	// 2.寫入基本介接參數
	$ecpay_invoice->Invoice_Method 		= 'ALLOWANCE' ;
	$ecpay_invoice->Invoice_Url 		= 'https://einvoice-stage.ecpay.com.tw/Invoice/Allowance';
	$ecpay_invoice->MerchantID 		= '2000132';
	$ecpay_invoice->HashKey 		= 'ejCk326UnaZWKisg';
	$ecpay_invoice->HashIV 			= 'q9jcZX8Ib9LM8wYk';
	
	// 3.寫入發票相關資訊
	$aItems	= [];
	
	// 商品資訊
	array_push($ecpay_invoice->Send['Items'], ['ItemName' => '商品名稱一', 'ItemCount' => 1, 'ItemWord' => '批', 'ItemPrice' => 100.88, 'ItemTaxType' => 1, 'ItemAmount' => 100.88 ]);
	
	// 產生測試用自訂訂單編號
	$RelateNumber = 'ECPAY'. date('YmdHis') . rand(1000000000,2147483647);
	
	$ecpay_invoice->Send['CustomerName'] 		= '';
	$ecpay_invoice->Send['InvoiceNo'] 		= 'AL00001934';
	$ecpay_invoice->Send['AllowanceNotify'] 	= 'E';
	$ecpay_invoice->Send['NotifyMail'] 		= 'test@localhost.com';
	$ecpay_invoice->Send['NotifyPhone'] 		= '';
	$ecpay_invoice->Send['AllowanceAmount'] 	= 101;
	
	// 3.送出
	$aReturn_Info = $ecpay_invoice->Check_Out();
	
	// 4.返回
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

echo 'RelateNumber=>' . $RelateNumber.'<br>'.$sMsg ;
