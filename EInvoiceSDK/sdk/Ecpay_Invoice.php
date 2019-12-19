<?php
/*
電子發票SDK
@author Wesley
*/

// 執行發票作業項目。
abstract class EcpayInvoiceMethod
{
	// 一般開立發票。
    	const INVOICE = 'INVOICE';

	// 延遲或觸發開立發票。
    	const INVOICE_DELAY = 'INVOICE_DELAY';

	// 開立折讓。
    	const ALLOWANCE = 'ALLOWANCE';

	// 發票作廢。
    	const INVOICE_VOID = 'INVOICE_VOID';

	// 折讓作廢。
    	const ALLOWANCE_VOID = 'ALLOWANCE_VOID';
    
	// 查詢發票。
    	const INVOICE_SEARCH = 'INVOICE_SEARCH';
    
	// 查詢作廢發票。
    	const INVOICE_VOID_SEARCH = 'INVOICE_VOID_SEARCH';
    
	// 查詢折讓明細。
    	const ALLOWANCE_SEARCH = 'ALLOWANCE_SEARCH';
    
	// 查詢折讓作廢明細。
    	const ALLOWANCE_VOID_SEARCH = 'ALLOWANCE_VOID_SEARCH';
     
	// 發送通知。
	const INVOICE_NOTIFY = 'INVOICE_NOTIFY';
    
	// 付款完成觸發或延遲開立發票。
	const INVOICE_TRIGGER = 'INVOICE_TRIGGER';

	// 手機條碼驗證。
	const CHECK_MOBILE_BARCODE = 'CHECK_MOBILE_BARCODE';

	// 愛心碼驗證。
	const CHECK_LOVE_CODE = 'CHECK_LOVE_CODE';
}

// 電子發票載具類別
abstract class EcpayCarruerType
{
	// 無載具
	const None = '';
  
	// 會員載具
	const Member = '1';
  
	// 買受人自然人憑證
	const Citizen = '2';
  
	// 買受人手機條碼
	const Cellphone = '3';
}

// 電子發票列印註記
abstract class EcpayPrintMark
{
	// 不列印
	const No = '0';
  
	// 列印
	const Yes = '1';
}

// 電子發票捐贈註記
abstract class EcpayDonation
{
	// 捐贈
	const Yes = '1';
  
	// 不捐贈
	const No = '0';
}

// 通關方式
abstract class EcpayClearanceMark
{
	// 經海關出口
	const Yes = '1';
  
	// 非經海關出口
	const No = '2';
}

// 課稅類別
abstract class EcpayTaxType
{
	// 應稅
	const Dutiable = '1';
  
	// 零稅率
	const Zero = '2';
  
	// 免稅
	const Free = '3';
  
	// 應稅與免稅混合(限收銀機發票無法分辦時使用，且需通過申請核可)
	const Mix = '9';
}

// 字軌類別
abstract class EcpayInvType
{
	// 一般稅額
	const General = '07';
  
	// 特種稅額
	const Special = '08';
}

// 商品單價是否含稅
abstract class EcpayVatType
{
	// 商品單價含稅價
	const Yes = '1';
  
	// 商品單價未稅價
	const No = '0';
}

// 延遲註記
abstract class EcpayDelayFlagType
{
	// 延遲註記
	const Delay = '1';
  
	// 觸發註記
	const Trigger = '2';
}

// 交易類別
abstract class EcpayPayTypeCategory
{
	// ECPAY
	const Ecpay = '2';
}

// 通知類別 
abstract class EcpayAllowanceNotifyType
{
	// 簡訊通知
	const Sms = 'S';
  
	// 電子郵件通知
	const Email = 'E';
	
	// 皆通知
	const All = 'A';
	
	// 皆不通知
	const None = 'N';
}

// 發送方式
abstract class EcpayNotifyType
{
	// 簡訊通知
	const Sms = 'S';
  
	// 電子郵件通知
	const Email = 'E';
	
	// 皆通知
	const All = 'A';
}

// 發送內容類型
abstract class EcpayInvoiceTagType
{
	// 發票開立
	const Invoice = 'I';
  
	// 發票作廢
	const Invoice_Void = 'II';
	
	// 折讓開立
	const Allowance = 'A';
	
	// 折讓作廢
	const Allowance_Void = 'AI';
	
	// 發票中獎
	const Invoice_Winning = 'AW';
}

// 發送對象
abstract class EcpayNotifiedType
{
	// 通知客戶
	const Customer = 'C';
  
	// 通知廠商
	const vendor = 'M';
	
	// 皆發送
	const All = 'A';
}

if(!class_exists('ECPay_EncryptType'))
{
	abstract class ECPay_EncryptType
	{
		// MD5(預設)
		const ENC_MD5 = 0;

		// SHA256
		const ENC_SHA256 = 1;
	}
}

class EcpayInvoice
{
	/**
	 * 版本
	 */
	const VERSION = '1.0.190805';

	public $TimeStamp 	= '';
	public $MerchantID 	= '';
	public $HashKey 	= '';
	public $HashIV 		= '';
	public $Send 		= 'Send';
	public $Invoice_Method 	= 'INVOICE';		// 電子發票執行項目
	public $Invoice_Url 	= 'Invoice_Url';	// 電子發票執行網址

	function __construct(){
	        
	        $this->Send = [
			'RelateNumber' => '',
			'CustomerID' => '',
			'CustomerIdentifier' => '',
			'CustomerName' => '',
			'CustomerAddr' => '',
			'CustomerPhone' => '',
			'CustomerEmail' => '',
			'ClearanceMark' => '',
			'Print' => EcpayPrintMark::No,
			'Donation' => EcpayDonation::No,
			'LoveCode' => '',
			'CarruerType' => EcpayCarruerType::None,
			'CarruerNum' => '',
			'TaxType' => '',
			'SalesAmount' => '',
			'InvoiceRemark' => '',
			'Items' => [],
			'InvType' => '',
			'vat' => EcpayVatType::Yes,
			'DelayFlag' => '',
			'DelayDay' => 0,
			'Tsr' => '',
			'PayType' => '',
			'PayAct' => '',
			'NotifyURL' => '',
			'InvoiceNo' => '',
			'AllowanceNotify' => '',
			'NotifyMail' => '',
			'NotifyPhone' => '',
			'AllowanceAmount' => '',
			'InvoiceNumber'  => '',
			'Reason'  => '',
			'AllowanceNo' => '',
			'Phone' => '',
			'Notify' => '',
			'InvoiceTag' => '',
			'Notified' => '',
			'BarCode' => '',
			'OnLine' => true
        	];

        	$this->TimeStamp = time();
	}  

    	function Check_Out(){
        	$arParameters = array_merge( ['MerchantID' => $this->MerchantID] , ['TimeStamp' => $this->TimeStamp], $this->Send);
		return ECPay_Invoice_Send::CheckOut($arParameters, $this->HashKey, $this->HashIV, $this->Invoice_Method, $this->Invoice_Url);
    	}	
}



/**
*  送出資訊
*/
class ECPay_Invoice_Send
{ 	
	// 發票物件
	public static $InvoiceObj ;
	public static $InvoiceObj_Return ;

	/**
	* 背景送出資料
	*/
	static function CheckOut($arParameters = [], $HashKey='', $HashIV='', $Invoice_Method = '', $ServiceURL=''){
		
		// 發送資訊處理
		$arParameters = self::process_send($arParameters, $HashKey, $HashIV, $Invoice_Method, $ServiceURL);

		$szResult = ECPay_IO::ServerPost($arParameters, $ServiceURL);

		// 回傳資訊處理
		$arParameters_Return = self::process_return($szResult, $HashKey, $HashIV, $Invoice_Method);

		return $arParameters_Return ;
	}

	// 資料檢查與過濾(送出)
	protected static function process_send($arParameters = [], $HashKey = '', $HashIV = '', $Invoice_Method = '', $ServiceURL = ''){

		//宣告物件
		$InvoiceMethod    = 'ECPay_'.$Invoice_Method;
		self::$InvoiceObj = new $InvoiceMethod;


		// 1寫入參數
		$arParameters = self::$InvoiceObj->insert_string($arParameters);

		// 2檢查共用參數
		ECPay_Invoice_Send::check_string($arParameters['MerchantID'], $HashKey, $HashIV, $Invoice_Method, $ServiceURL);

		// 3檢查各別參數
		$arParameters = self::$InvoiceObj->check_extend_string($arParameters);

		// 4處理需要轉換為urlencode的參數
		$arParameters = ECPay_Invoice_Send::urlencode_process($arParameters, self::$InvoiceObj->urlencode_field);
		
		// 5欄位例外處理方式(送壓碼前)
		$arException = self::$InvoiceObj->check_exception($arParameters);

		// 6產生壓碼
		$arParameters['CheckMacValue'] = ECPay_Invoice_Send::generate_checkmacvalue($arException, self::$InvoiceObj->none_verification, $HashKey, $HashIV);

		return $arParameters ;
	}

	/**
	* 資料檢查與過濾(回傳)
	*/
	protected static function process_return($sParameters = '', $HashKey = '', $HashIV = '', $Invoice_Method = ''){

		//宣告物件
		$InvoiceMethod    = 'ECPay_'.$Invoice_Method;
		self::$InvoiceObj_Return = new $InvoiceMethod;

		// 7字串轉陣列
		$arParameters = ECPay_Invoice_Send::string_to_array($sParameters);

		// 8欄位例外處理方式(送壓碼前)
		$arException = self::$InvoiceObj_Return->check_exception($arParameters);

		// 9產生壓碼(壓碼檢查)
		if(isset($arParameters['CheckMacValue'])){
			$CheckMacValue = ECPay_Invoice_Send::generate_checkmacvalue($arException, self::$InvoiceObj_Return->none_verification, $HashKey, $HashIV);
			
			if($CheckMacValue != $arParameters['CheckMacValue']){
				throw new Exception('注意：壓碼錯誤'); 
			}
		}

		// 10處理需要urldecode的參數
		$arParameters = ECPay_Invoice_Send::urldecode_process($arParameters, self::$InvoiceObj_Return->urlencode_field);

		return $arParameters ;
	}

	
	/**
	* 2檢查共同參數
	*/
	protected static function check_string($MerchantID = '', $HashKey = '', $HashIV = '', $Invoice_Method = 'INVOICE', $ServiceURL = ''){
		
		$arErrors = [];
		
		// 檢查是否傳入動作方式
        	if($Invoice_Method == '' || $Invoice_Method == 'Invoice_Method')
        	{
			array_push($arErrors, 'Invoice_Method is required.');	
        	}
        	
        	// 檢查是否有傳入MerchantID
		if(strlen($MerchantID) == 0)
		{
			array_push($arErrors, 'MerchantID is required.');
		}
	        if(strlen($MerchantID) > 10)
	        {
			array_push($arErrors, 'MerchantID max langth as 10.');
	        }
	        
	        // 檢查是否有傳入HashKey
	        if(strlen($HashKey) == 0)
		{
			array_push($arErrors, 'HashKey is required.');
		}
		
		// 檢查是否有傳入HashIV
	        if(strlen($HashIV) == 0)
		{
			array_push($arErrors, 'HashIV is required.');
		}
		
		// 檢查是否有傳送網址
	        if(strlen($ServiceURL) == 0)
		{
			array_push($arErrors, 'Invoice_Url is required.');
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));	
	}

	/**
	* 4處理需要轉換為urlencode的參數
	*/
    	protected static function urlencode_process($arParameters = [], $urlencode_field = []){

    		foreach($arParameters as $key => $value)
    		{
    			if(isset($urlencode_field[$key]))
    			{
    				$arParameters[$key] = urlencode($value);
    				$arParameters[$key] = ECPay_Invoice_CheckMacValue::Replace_Symbol($arParameters[$key]);
    			}
    		}

    		return $arParameters ;
    	}

    	/**
	* 6,9產生壓碼
	*/
    	protected static function generate_checkmacvalue($arParameters = [], $none_verification = [], $HashKey = '', $HashIV = ''){
    		
    		$sCheck_MacValue = '';

    		// 過濾不需要壓碼的參數
    		foreach($none_verification as $key => $value)
    		{
    			if(isset($arParameters[$key]))
    			{
    				unset($arParameters[$key]) ;
    			}
    		}

    		$sCheck_MacValue = ECPay_Invoice_CheckMacValue::generate($arParameters, $HashKey, $HashIV, ECPay_EncryptType::ENC_MD5);

    		return $sCheck_MacValue ;
    	}

    	/**
	* 7 字串轉陣列
	*/
    	protected static function string_to_array($Parameters = ''){
    		
    		$aParameters 	 = [];
    		$aParameters_Tmp = [];

    		$aParameters_Tmp  = explode('&', $Parameters);

    		foreach($aParameters_Tmp as $part){
    			list($paramName, $paramValue) = explode('=', $part, 2);	
    			$aParameters[$paramName] = $paramValue ;
    		}

    		return $aParameters ;
    	}

    	/**
	* 10處理urldecode的參數
	*/
    	protected static function urldecode_process($arParameters = [], $urlencode_field = []){

    		foreach($arParameters as $key => $value)
    		{
    			if(isset($urlencode_field[$key]))
    			{
    				$arParameters[$key] = ECPay_Invoice_CheckMacValue::Replace_Symbol_Decode($arParameters[$key]);
    				$arParameters[$key] = urldecode($value);
    			}
    		}

    		return $arParameters ;
    	}
}

/**
*  A一般開立 
*/
class ECPay_INVOICE
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'RelateNumber'		=>'',
		'CustomerID'		=>'',
		'CustomerIdentifier'	=>'',
		'CustomerName'		=>'',
		'CustomerAddr'		=>'',
		'CustomerPhone'		=>'',
		'CustomerEmail'		=>'',
		'ClearanceMark'		=>'',
		'Print'			=>'',
		'Donation'		=>'',
		'LoveCode'		=>'',
		'CarruerType'		=>'',
		'CarruerNum'		=>'',
		'TaxType'		=>'',
		'SalesAmount'		=>'',
		'InvoiceRemark'		=>'',
		'Items'			=>[],
		'ItemName'		=>'',
		'ItemCount'		=>'',
		'ItemWord'		=>'',
		'ItemPrice'		=>'',
		'ItemTaxType'		=>'',
		'ItemAmount'		=>'',
		'ItemRemark'		=>'',
		'CheckMacValue'		=>'',
		'InvType'		=>'',
		'vat' 			=>'',
		'OnLine' 		=> true
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'CustomerName' 		=>'',
        	'CustomerAddr'		=>'',
        	'CustomerEmail'		=>'',
        	'InvoiceRemark'		=>'',
        	'ItemName' 		=>'',
        	'ItemWord'		=>'',
        	'ItemRemark' 		=>''
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
       		'InvoiceRemark' 	=>'',
       		'ItemName' 		=>'',
       		'ItemWord'		=>'',
       		'ItemRemark' 		=>'',
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
		$nItems_Count_Total = 0 ;
		$nItems_Foreach_Count = 1 ;
		$sItemName = '' ;
		$sItemCount = '' ;
		$sItemWord = '' ;
		$sItemPrice = '' ;
		$sItemTaxType = '' ;
		$sItemAmount = '' ;
		$sItemRemark = '' ;

	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        // 商品資訊組合
		$nItems_Count_Total = count($arParameters['Items']) ;	// 商品總筆數

		if($nItems_Count_Total != 0)
		{
			foreach($arParameters['Items'] as $key2 => $value2)
			{
				$sItemName 	.= (isset($value2['ItemName']))		? $value2['ItemName'] 		: '' ;
				$sItemCount 	.= (int) $value2['ItemCount'] ;
				$sItemWord 	.= (isset($value2['ItemWord'])) 	? $value2['ItemWord'] 		: '' ;
				$sItemPrice 	.= $value2['ItemPrice'] ;		
				$sItemTaxType 	.= (isset($value2['ItemTaxType'])) 	? $value2['ItemTaxType'] 	: '' ;
				$sItemAmount	.= $value2['ItemAmount'] ;
				$sItemRemark 	.= (isset($value2['ItemRemark'])) 	? $value2['ItemRemark'] 	: '' ;
				
				if( $nItems_Foreach_Count < $nItems_Count_Total )
				{
					$sItemName .= '|' ;
					$sItemCount .= '|' ;
					$sItemWord .= '|' ;
					$sItemPrice .= '|' ;
					$sItemTaxType .= '|' ;
					$sItemAmount .= '|' ;
					$sItemRemark .= '|' ;
				}

				$nItems_Foreach_Count++ ; 		
			}
		}

		$this->parameters['ItemName'] 		= $sItemName;		// 商品名稱
		$this->parameters['ItemCount'] 		= $sItemCount ;
		$this->parameters['ItemWord'] 		= $sItemWord;		// 商品單位
		$this->parameters['ItemPrice'] 		= $sItemPrice ;
		$this->parameters['ItemTaxType'] 	= $sItemTaxType ;
		$this->parameters['ItemAmount'] 	= $sItemAmount ;
		$this->parameters['ItemRemark'] 	= $sItemRemark ;	// 商品備註

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];
    		$nCheck_Amount = 0 ; 	// 驗證總金額

    		// 4.廠商自訂編號
	        	
        	// *預設不可為空值
        	if(strlen($arParameters['RelateNumber']) == 0)
        	{
        		array_push($arErrors, '4:RelateNumber is required.');
        	}
        	// *預設最大長度為30碼
        	if(strlen($arParameters['RelateNumber']) > 30)
        	{
        		array_push($arErrors, '4:RelateNumber max langth as 30.');
        	}

        	// 5.客戶編號 CustomerID
	        	
		// *預設最大長度為20碼
		if(strlen($arParameters['CustomerID']) > 20 )
        	{
        		array_push($arErrors, '5:CustomerID max langth as 20.');
        	}
        	// *比對客戶編號 只接受英、數字與下底線格式
        	if(strlen($arParameters['CustomerID']) > 0)
        	{
        		if( !preg_match('/^[a-zA-Z0-9_]+$/', $arParameters['CustomerID']) )
	        	{
	        		arRay_push($arErrors, '5:Invalid CustomerID.');
	        	}
        	}
        	
        	// 6.統一編號判斷 CustomerIdentifier
        	
        	// *若統一編號有值時，則固定長度為數字8碼
        	if( strlen( $arParameters['CustomerIdentifier'] ) > 0  )
        	{		        	
	        	if( !preg_match('/^[0-9]{8}$/', $arParameters['CustomerIdentifier']) ) 
	        	{	
	        		array_push($arErrors, '6:CustomerIdentifier length should be 8.');
	        	}
	        }

	        // 7.客戶名稱 CustomerName
        	// x僅能為中英數字格式
        	// *若列印註記 = '1' (列印)時，則客戶名稱須有值
        	if ($arParameters['Print'] == EcpayPrintMark::Yes)
		{
			if (mb_strlen($arParameters['CustomerName'], 'UTF-8') == 0 && $arParameters['OnLine'])
			{
				array_push($arErrors, '7:CustomerName is required.');
			}
		}
		// *預設最大長度為30碼
        	if( mb_strlen($arParameters['CustomerName'], 'UTF-8') > 30)
        	{
        		array_push($arErrors, '7:CustomerName max length as 30.');
        	}

		// 8.客戶地址 CustomerAddr(UrlEncode, 預設為空字串)
		
		// *若列印註記 = '1' (列印)時，則客戶地址須有值
		if ($arParameters['Print'] == EcpayPrintMark::Yes)
		{
			if (mb_strlen($arParameters['CustomerAddr'], 'UTF-8') == 0 && $arParameters['OnLine'])
			{
				array_push($arErrors, '8:CustomerAddr is required.');
			}
		}
		// *預設最大長度為100碼
		if (mb_strlen($arParameters['CustomerAddr'], 'UTF-8') > 100)
		{
			array_push($arErrors, '8:CustomerAddr max length as 100.');
		}

	        // 9.客戶手機號碼 CustomerPhone
	        
	        // *預設最小長度為1碼，最大長度為20碼
		if (strlen($arParameters['CustomerPhone']) > 20)
		{
			array_push($arErrors, '9:CustomerPhone max length as 20.');
		}
		// *預設格式為數字組成
		if (strlen($arParameters['CustomerPhone']) > 0)
		{
			if( !preg_match('/^[0-9]*$/', $arParameters['CustomerPhone']) )
	        	{
	        		array_push($arErrors, '9:Invalid CustomerPhone.');
	        	}
	        }
		
		// 10.客戶電子信箱 CustomerEmail(UrlEncode, 預設為空字串, 與CustomerPhone擇一不可為空)
		
		// *預設最大長度為80碼
		if (strlen($arParameters['CustomerEmail']) > 80)
		{
			array_push($arErrors, '10:CustomerEmail max length as 80.');
		}
		// *若客戶電子信箱有值時，則格式僅能為Email的標準格式
		if(strlen($arParameters['CustomerEmail']) > 0 )
        	{
        		if ( !preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is', $arParameters['CustomerEmail']) )
        		{
        			array_push($arErrors, '10:Invalid CustomerEmail Format.');
        		}
        	}

		// 9. 10. 
		
		// *若客戶手機號碼為空值時，則客戶電子信箱不可為空值 
		if (strlen($arParameters['CustomerPhone']) == 0 && strlen($arParameters['CustomerEmail']) == 0 && $arParameters['OnLine'])
		{
			array_push($arErrors, '9-10:CustomerPhone or CustomerEmail is required.');
		}	
        	
        	// 11.通關方式 ClearanceMark(預設為空字串)
        	
        	// *最多1字元
		if (strlen($arParameters['ClearanceMark']) > 1)
		{
          		array_push($arErrors, '11:ClearanceMark max length as 1.');
		}
		
		// *課稅類別為零稅率(Zero)或課稅類別為混合稅率(Mix)且商品課稅別存在零稅率時，此參數不可為空字串
		if ($arParameters['TaxType'] == EcpayTaxType::Zero || ($arParameters['TaxType'] == EcpayTaxType::Mix && strpos($arParameters['ItemTaxType'], EcpayTaxType::Zero) !== false))
		{
			if ( ( $arParameters['ClearanceMark'] != EcpayClearanceMark::Yes ) && ( $arParameters['ClearanceMark'] != EcpayClearanceMark::No ) )
			{
				array_push($arErrors, '11:ClearanceMark is required.');
			}
		}

        	// 12.列印註記 Print(預設為No)
        	
        	// *列印註記僅能為 0 或 1
		if ( ( $arParameters['Print'] != EcpayPrintMark::Yes ) && ( $arParameters['Print'] != EcpayPrintMark::No ) )
		{
			array_push($arErrors, '12:Invalid Print.');
		}
		// *若捐贈註記 = '1' (捐贈)時，則VAL = '0' (不列印)
		if ($arParameters['Donation'] == EcpayDonation::Yes)
		{
			if ($arParameters['Print'] != EcpayPrintMark::No)
			{
				array_push($arErrors, '12:Donation Print should be No.');
			}
		}
		// *若統一編號有值時，則VAL = '1' (列印)
		if (strlen($arParameters['CustomerIdentifier']) > 0)
		{
			if ($arParameters['Print'] != EcpayPrintMark::Yes)
			{
              			array_push($arErrors, '12:CustomerIdentifier Print should be Yes.');
			}
		}
		// 線下列印判斷
		// 1200079當線下廠商開立發票無載具且無統一編號時，必須列印。
		if($arParameters['OnLine'] === false)
		{
			if( ($arParameters['CarruerType'] == EcpayCarruerType::None ) && strlen($arParameters['CustomerIdentifier']) == 0 )
			{
				if ($arParameters['Print'] != EcpayPrintMark::Yes)
				{
	              			array_push($arErrors, '12:Offline Print should be Yes.');
				}
			}
		}
		
		// 13.捐贈註記 Donation
		
		// *固定給定下述預設值若為捐贈時，則VAL = '1'，若為不捐贈時，則VAL = '0'
		if ( ($arParameters['Donation'] != EcpayDonation::Yes ) && ( $arParameters['Donation'] != EcpayDonation::No ) )
		{
			array_push($arErrors, '13:Invalid Donation.');
		}
		// *若統一編號有值時，則VAL = '2' (不捐贈)
		if (strlen($arParameters['CustomerIdentifier']) > 0 && $arParameters['Donation'] == EcpayDonation::Yes )
		{
			array_push($arErrors, '13:CustomerIdentifier Donation should be No.');
		}
		
		
		// 14.愛心碼 LoveCode(預設為空字串)
		
		// *若捐贈註記 = '1' (捐贈)時，則須有值
		if ($arParameters['Donation'] == EcpayDonation::Yes)
		{
			if ( !preg_match('/^([xX]{1}[0-9]{2,6}|[0-9]{3,7})$/', $arParameters['LoveCode']) )
			{
              			array_push($arErrors, '14:Invalid LoveCode.');
			}
		}
		else
		{
			if (strlen($arParameters['LoveCode']) > 0)
			{
				array_push($arErrors, '14:Please remove LoveCode.');
			}
		}
		
		// 15.載具類別 CarruerType(預設為None)
		
		// *固定給定下述預設值None、Member、Cellphone
		if ( ( $arParameters['CarruerType'] != EcpayCarruerType::None ) && ( $arParameters['CarruerType'] != EcpayCarruerType::Member ) && ( $arParameters['CarruerType'] != EcpayCarruerType::Citizen ) && ( $arParameters['CarruerType'] != EcpayCarruerType::Cellphone ) )
		{
			array_push($arErrors, '15:Invalid CarruerType.');
		}
		else
		{
			// *統一編號不為空字串時，則載具類別不可為會載具或自然人憑證載具
			if (strlen($arParameters['CustomerIdentifier']) > 0)
			{
				if ($arParameters['CarruerType'] == EcpayCarruerType::Member || $arParameters['CarruerType'] == EcpayCarruerType::Citizen )
				{
                  			array_push($arErrors, '15:Invalid CarruerType.');
              			}		
			}
		}
      
		// 16.載具編號 CarruerNum(預設為空字串)
		switch ($arParameters['CarruerType'])
		{
      			// *載具類別為無載具(None)或會員載具(Member)時，請設定空字串
      			case EcpayCarruerType::None:
      			case EcpayCarruerType::Member:
				if (strlen($arParameters['CarruerNum']) > 0)
				{
              				array_push($arErrors, '16:Please remove CarruerNum.');
          			}
         		 break;
         		 
			// *載具類別為買受人自然人憑證(Citizen)時，請設定自然人憑證號碼，前2碼為大小寫英文，後14碼為數字
			case EcpayCarruerType::Citizen:
				if ( !preg_match('/^[a-zA-Z]{2}\d{14}$/', $arParameters['CarruerNum']) )
          			{
              				array_push($arErrors, '16:Invalid CarruerNum.');
                          	}
			break;
      
      			// *載具類別為買受人手機條碼(Cellphone)時，請設定手機條碼，第1碼為「/」，後7碼為大寫英文、數字、「+」、「-」或「.」
      			case EcpayCarruerType::Cellphone:
				if ( !preg_match('/^\/{1}[0-9A-Z+-.]{7}$/', $arParameters['CarruerNum']) )
				{
					array_push($arErrors, '16:Invalid CarruerNum.');
				}
			break;
			default:
				array_push($arErrors, '16:Please remove CarruerNum.');
		}
		
		// 17.課稅類別 TaxType(不可為空)
		
		// *不可為空
		if (strlen($arParameters['TaxType']) == 0)
		{
			array_push($arErrors, '17:TaxType is required.');
		}
		// *僅能為 1應稅 2零稅率 3免稅 9.應稅與免稅混合
		if ( ( $arParameters['TaxType'] != EcpayTaxType::Dutiable ) && ( $arParameters['TaxType'] != EcpayTaxType::Zero ) && ( $arParameters['TaxType'] != EcpayTaxType::Free ) && ( $arParameters['TaxType'] != EcpayTaxType::Mix ) )
		{
			array_push($arErrors, '17:Invalid TaxType.');
		}
		
		
		// 18.發票金額 SalesAmount
		
		// *不可為空
		if (strlen($arParameters['SalesAmount']) == 0)
		{
			array_push($arErrors, '18:SalesAmount is required.');
		}
		
		// 20.21.22.23.24.25. 商品資訊

		// *不可為空
		if (sizeof($arParameters['Items']) == 0)
		{
			array_push($arErrors, '20-25:Items is required.');
	        }
	        else
	        {
	        	// 檢查是否存在保留字元 '|'
			$bFind_Tag 		= true;
			$bError_Tag 		= false;

			foreach($arParameters['Items'] as $key => $value)
			{
				$bFind_Tag = strpos($value['ItemName'], '|') ;
				if($bFind_Tag != false || empty($value['ItemName']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '20:Invalid ItemName.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemCount'], '|') ;
				if($bFind_Tag != false || empty($value['ItemCount']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '21:Invalid ItemCount.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemWord'], '|') ;
				if($bFind_Tag != false || empty($value['ItemWord']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '22:Invalid ItemWord.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemPrice'], '|') ;
				if($bFind_Tag != false || $value['ItemPrice'] === '')
				{
					$bError_Tag = true ;
					array_push($arErrors, '23:Invalid ItemPrice.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemTaxType'], '|') ;
				if($bFind_Tag != false || empty($value['ItemTaxType']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '24:Invalid ItemTaxType.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemAmount'], '|') ;
				if($bFind_Tag != false || $value['ItemAmount'] === '' )
				{
					$bError_Tag = true ;
					array_push($arErrors, '25:Invalid ItemAmount.');
					break;	
				}
				
				// V1.0.3
				if(isset($value['ItemRemark']))
				{
		        		$bFind_Tag = strpos($value['ItemRemark'], '|') ;
		        		if($bFind_Tag != false || empty($value['ItemRemark']))
		        		{
		        			$bError_Tag = true ;
		        			array_push($arErrors, '143:Invalid ItemRemark.');
		        			break;	
		        		}
		        	}
			}

			// 檢查商品格式
	        	if(!$bError_Tag)
	        	{
	        		foreach($arParameters['Items'] as $key => $value)
	        		{
	        			// *ItemCount數字判斷
	        			if ( !preg_match('/^[0-9]*$/', $value['ItemCount']) )
	        			{
	        				array_push($arErrors, '21:Invalid ItemCount.');
	        			}
	        			
	        			// *ItemWord 預設最大長度為6碼
	        			if (strlen($value['ItemWord']) > 6 )
					{
						array_push($arErrors, '22:ItemWord max length as 6.');
					}
					
					// *ItemPrice數字判斷
	        			if ( !preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemPrice']) )
	        			{
	        				array_push($arErrors, '23:Invalid ItemPrice.');
	        			}
	        			
	        			// *ItemAmount數字判斷
	        			if ( !preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemAmount']) )
	        			{
	        				array_push($arErrors, '25:Invalid ItemAmount.');
	        			}
	        			else
	        			{
	        				$nCheck_Amount = $nCheck_Amount + $value['ItemAmount'] ;
	        			}	
	        			
	        			// V1.0.3
	        			// *ItemRemark 預設最大長度為40碼 如果有此欄位才判斷
	        			if(isset($value['ItemRemark']))
	        			{
		        			if (strlen($value['ItemRemark']) > 40 )
						{
							array_push($arErrors, '143:ItemRemark max length as 40.');
						}
					}
	        		}


	        		// *檢查商品總金額
					if ( $arParameters['SalesAmount'] != round($nCheck_Amount))
					{
						array_push($arErrors, '18.2:Invalid SalesAmount.');
					}

					// *檢查商品課稅別

					// 課稅類別為混合稅率時
					if ($arParameters['TaxType'] == EcpayTaxType::Mix)
					{
						$ItemTaxType = explode('|', $arParameters['ItemTaxType']);
						// 商品課稅別不可為空
						if(empty($arParameters['ItemTaxType']))
						{
							array_push($arErrors, '24:ItemTaxType is required.');
						}
						// 需含二筆或以上的商品課稅別
						if ( count($ItemTaxType) < 2)
						{
							array_push($arErrors, '24:ItemTaxType should be more than 2.');
						}

						// 免稅和零稅率發票不能同時開立
						// 只能有兩種情形 :
						// 1.應稅+免稅
						// 2.應稅+零稅率
						$items = array_unique($ItemTaxType);
						if ( count($items) != 2 || !in_array(1, $items))
						{
							array_push($arErrors, '24:ItemTaxType error.');
						}
					}
	        	}
	        }

	        // 27.字軌類別 
		
		// *InvType(不可為空) 僅能為 07 或 08 狀態
		if( ( $arParameters['InvType'] != EcpayInvType::General ) && ( $arParameters['InvType'] != EcpayInvType::Special ) )
		{
			array_push($arErrors, '27:Invalid InvType.');
		}

        	// 29.商品單價是否含稅(預設為含稅價)

		// *固定給定下述預設值 若為含稅價，則VAL = '1'
		if(!empty($arParameters['vat']))
		{
			if( ( $arParameters['vat'] != EcpayVatType::Yes ) && ( $arParameters['vat'] != EcpayVatType::No ) )
			{
				array_push($arErrors, '29:Invalid VatType.');
			}	
		}

        	if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	// 刪除items 
        	unset($arParameters['Items']);

        	// 刪除SDK自訂義參數
        	unset($arParameters['OnLine']);

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

    		if(isset($arParameters['CarruerNum']))
    		{
			// 載具編號內包含+號則改為空白
			$arParameters['CarruerNum'] = str_replace('+',' ',$arParameters['CarruerNum']);
    		}

		return $arParameters ;
    	}   
}

/**
*  B延遲開立 
*/
class ECPay_INVOICE_DELAY
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'RelateNumber'		=>'',
		'CustomerID'		=>'',
		'CustomerIdentifier'	=>'',
		'CustomerName'		=>'',
		'CustomerAddr'		=>'',
		'CustomerPhone'		=>'',
		'CustomerEmail'		=>'',
		'ClearanceMark'		=>'',
		'Print'			=>'',
		'Donation'		=>'',
		'LoveCode'		=>'',
		'CarruerType'		=>'',
		'CarruerNum'		=>'',
		'TaxType'		=>'',
		'SalesAmount'		=>'',
		'InvoiceRemark'		=>'',
		'Items'			=>[],
		'ItemName'		=>'',
		'ItemCount'		=>'',
		'ItemWord'		=>'',
		'ItemPrice'		=>'',
		'ItemTaxType'		=>'',
		'ItemAmount'		=>'',
		'CheckMacValue'		=>'',
		'InvType'		=>'',
		'DelayFlag' 		=>'',
		'DelayDay' 		=>'',
		'Tsr' 			=>'',
		'PayType' 		=>2,
		'PayAct' 		=>'ECPAY',
		'NotifyURL' 		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'CustomerName' 		=>'',
        	'CustomerAddr'		=>'',
        	'CustomerEmail'		=>'',
        	'InvoiceRemark'		=>'',
        	'ItemName' 		=>'',
        	'ItemWord'		=>''
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
       		'InvoiceRemark' 	=>'',
       		'ItemName' 		=>'',
       		'ItemWord'		=>'',
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
		$nItems_Count_Total = 0 ;
		$nItems_Foreach_Count = 1 ;
		$sItemName = '' ;
		$sItemCount = '' ;
		$sItemWord = '' ;
		$sItemPrice = '' ;
		$sItemTaxType = '' ;
		$sItemAmount = '' ;
		$sItemRemark = '' ;

	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        // 商品資訊組合
		$nItems_Count_Total = count($arParameters['Items']) ;	// 商品總筆數

		if($nItems_Count_Total != 0)
		{
			foreach($arParameters['Items'] as $key2 => $value2)
			{
				$sItemName 	.= (isset($value2['ItemName']))		? $value2['ItemName'] 		: '' ;
				$sItemCount 	.= (int) $value2['ItemCount'] ;
				$sItemWord 	.= (isset($value2['ItemWord'])) 	? $value2['ItemWord'] 		: '' ;
				$sItemPrice 	.= $value2['ItemPrice'] ;		
				$sItemTaxType 	.= (isset($value2['ItemTaxType'])) 	? $value2['ItemTaxType'] 	: '' ;
				$sItemAmount	.= $value2['ItemAmount'] ;
				
				if( $nItems_Foreach_Count < $nItems_Count_Total )
				{
					$sItemName .= '|' ;
					$sItemCount .= '|' ;
					$sItemWord .= '|' ;
					$sItemPrice .= '|' ;
					$sItemTaxType .= '|' ;
					$sItemAmount .= '|' ;
				}

				$nItems_Foreach_Count++ ; 		
			}
		}

		$this->parameters['ItemName'] 		= $sItemName;		// 商品名稱
		$this->parameters['ItemCount'] 		= $sItemCount ;
		$this->parameters['ItemWord'] 		= $sItemWord;		// 商品單位
		$this->parameters['ItemPrice'] 		= $sItemPrice ;
		$this->parameters['ItemTaxType'] 	= $sItemTaxType ;
		$this->parameters['ItemAmount'] 	= $sItemAmount ;

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];
    		$nCheck_Amount = 0 ; 	// 驗證總金額

    		// 4.廠商自訂編號
	        	
        	// *預設不可為空值
        	if(strlen($arParameters['RelateNumber']) == 0)
        	{
        		array_push($arErrors, '4:RelateNumber is required.');
        	}
        	// *預設最大長度為30碼
        	if(strlen($arParameters['RelateNumber']) > 30)
        	{
        		array_push($arErrors, '4:RelateNumber max langth as 30.');
        	}

        	// 5.客戶編號 CustomerID
	        	
		// *預設最大長度為20碼
		if(strlen($arParameters['CustomerID']) > 20 )
        	{
        		array_push($arErrors, '5:CustomerID max langth as 20.');
        	}
        	// *比對客戶編號 只接受英、數字與下底線格式
        	if(strlen($arParameters['CustomerID']) > 0)
        	{
        		if( !preg_match('/^[a-zA-Z0-9_]+$/', $arParameters['CustomerID']) )
	        	{
	        		arRay_push($arErrors, '5:Invalid CustomerID.');
	        	}
        	}
        	
        	// 6.統一編號判斷 CustomerIdentifier
        	
        	// *若統一編號有值時，則固定長度為數字8碼
        	if( strlen( $arParameters['CustomerIdentifier'] ) > 0  )
        	{		        	
	        	if( !preg_match('/^[0-9]{8}$/', $arParameters['CustomerIdentifier']) ) 
	        	{	
	        		array_push($arErrors, '6:CustomerIdentifier length should be 8.');
	        	}
	        }

	        // 7.客戶名稱 CustomerName
        	// x僅能為中英數字格式
        	// *若列印註記 = '1' (列印)時，則客戶名稱須有值
        	if ($arParameters['Print'] == EcpayPrintMark::Yes)
		{
			if (mb_strlen($arParameters['CustomerName'], 'UTF-8') == 0)
			{
				array_push($arErrors, '7:CustomerName is required.');
			}
		}
		// *預設最大長度為30碼
        	if( mb_strlen($arParameters['CustomerName'], 'UTF-8') > 30)
        	{
        		array_push($arErrors, '7:CustomerName max length as 30.');
        	}

		// 8.客戶地址 CustomerAddr(UrlEncode, 預設為空字串)
		
		// *若列印註記 = '1' (列印)時，則客戶地址須有值
		if ($arParameters['Print'] == EcpayPrintMark::Yes)
		{
			if (mb_strlen($arParameters['CustomerAddr'], 'UTF-8') == 0)
			{
				array_push($arErrors, '8:CustomerAddr is required.');
			}
		}
		// *預設最大長度為100碼
		if (mb_strlen($arParameters['CustomerAddr'], 'UTF-8') > 100)
		{
			array_push($arErrors, '8:CustomerAddr max length as 100.');
		}

	        // 9.客戶手機號碼 CustomerPhone
	        
	        // *預設最小長度為1碼，最大長度為20碼
		if (strlen($arParameters['CustomerPhone']) > 20)
		{
			array_push($arErrors, '9:CustomerPhone max length as 20.');
		}
		// *預設格式為數字組成
		if (strlen($arParameters['CustomerPhone']) > 0)
		{
			if( !preg_match('/^[0-9]*$/', $arParameters['CustomerPhone']) )
	        	{
	        		array_push($arErrors, '9:Invalid CustomerPhone.');
	        	}
	        }
		
		// 10.客戶電子信箱 CustomerEmail(UrlEncode, 預設為空字串, 與CustomerPhone擇一不可為空)
		
		// *預設最大長度為80碼
		if (strlen($arParameters['CustomerEmail']) > 80)
		{
			array_push($arErrors, '10:CustomerEmail max length as 80.');
		}
		// *若客戶電子信箱有值時，則格式僅能為Email的標準格式
		if(strlen($arParameters['CustomerEmail']) > 0 )
        	{
        		if ( !preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is', $arParameters['CustomerEmail']) )
        		{
        			array_push($arErrors, '10:Invalid CustomerEmail Format.');
        		}
        	}

		// 9. 10. 
		
		// *若客戶手機號碼為空值時，則客戶電子信箱不可為空值 
		if (strlen($arParameters['CustomerPhone']) == 0 && strlen($arParameters['CustomerEmail']) == 0)
		{
			array_push($arErrors, '9-10:CustomerPhone or CustomerEmail is required.');
		}	
        	
        	// 11.通關方式 ClearanceMark(預設為空字串)
        	
        	// *最多1字元
		if (strlen($arParameters['ClearanceMark']) > 1)
		{
          		array_push($arErrors, '11:ClearanceMark max length as 1.');
		}

		// *課稅類別為零稅率(Zero)或課稅類別為混合稅率(Mix)且商品課稅別存在零稅率時，此參數不可為空字串
		if ($arParameters['TaxType'] == EcpayTaxType::Zero || ($arParameters['TaxType'] == EcpayTaxType::Mix && strpos($arParameters['ItemTaxType'], EcpayTaxType::Zero) !== false))
		{
			if ( ( $arParameters['ClearanceMark'] != EcpayClearanceMark::Yes ) && ( $arParameters['ClearanceMark'] != EcpayClearanceMark::No ) )
			{
				array_push($arErrors, '11:ClearanceMark is required.');
			}
		}

        	// 12.列印註記 Print(預設為No)
        	
        	// *列印註記僅能為 0 或 1
		if ( ( $arParameters['Print'] != EcpayPrintMark::Yes ) && ( $arParameters['Print'] != EcpayPrintMark::No ) )
		{
			array_push($arErrors, '12:Invalid Print.');
		}
		// *若捐贈註記 = '1' (捐贈)時，則VAL = '0' (不列印)
		if ($arParameters['Donation'] == EcpayDonation::Yes)
		{
			if ($arParameters['Print'] != EcpayPrintMark::No)
			{
				array_push($arErrors, '12:Donation Print should be No.');
			}
		}
		// *若統一編號有值時，則VAL = '1' (列印)
		if (strlen($arParameters['CustomerIdentifier']) > 0)
		{
			if ($arParameters['Print'] != EcpayPrintMark::Yes)
			{
              			array_push($arErrors, '12:CustomerIdentifier Print should be Yes.');
			}
		}	
		
		// 13.捐贈註記 Donation
		
		// *固定給定下述預設值若為捐贈時，則VAL = '1'，若為不捐贈時，則VAL = '0'
		if ( ($arParameters['Donation'] != EcpayDonation::Yes ) && ( $arParameters['Donation'] != EcpayDonation::No ) )
		{
			array_push($arErrors, '13:Invalid Donation.');
		}
		// *若統一編號有值時，則VAL = '0' (不捐贈)
		if (strlen($arParameters['CustomerIdentifier']) > 0 && $arParameters['Donation'] == EcpayDonation::Yes )
		{
			array_push($arErrors, '13:CustomerIdentifier Donation should be No.');
		}
		
		
		// 14.愛心碼 LoveCode(預設為空字串)
		
		// *若捐贈註記 = '1' (捐贈)時，則須有值
		if ($arParameters['Donation'] == EcpayDonation::Yes)
		{
			if ( !preg_match('/^([xX]{1}[0-9]{2,6}|[0-9]{3,7})$/', $arParameters['LoveCode']) )
			{
              			array_push($arErrors, '14:Invalid LoveCode.');
			}
		}
		else
		{
			if (strlen($arParameters['LoveCode']) > 0)
			{
				array_push($arErrors, '14:Please remove LoveCode.');
			}
		}
		
		// 15.載具類別 CarruerType(預設為None)
		
		// *固定給定下述預設值None、Member、Cellphone
		if ( ( $arParameters['CarruerType'] != EcpayCarruerType::None ) && ( $arParameters['CarruerType'] != EcpayCarruerType::Member ) && ( $arParameters['CarruerType'] != EcpayCarruerType::Citizen ) && ( $arParameters['CarruerType'] != EcpayCarruerType::Cellphone ) )
		{
			array_push($arErrors, '15:Invalid CarruerType.');
		}
		else
		{
			// *統一編號不為空字串時，則載具類別不可為會載具或自然人憑證載具
			if (strlen($arParameters['CustomerIdentifier']) > 0)
			{
				if ($arParameters['CarruerType'] == EcpayCarruerType::Member || $arParameters['CarruerType'] == EcpayCarruerType::Citizen )
				{
                  			array_push($arErrors, '15:Invalid CarruerType.');
              			}		
			}
		}
      
		// 16.載具編號 CarruerNum(預設為空字串)
		switch ($arParameters['CarruerType'])
		{
      			// *載具類別為無載具(None)或會員載具(Member)時，請設定空字串
      			case EcpayCarruerType::None:
      			case EcpayCarruerType::Member:
				if (strlen($arParameters['CarruerNum']) > 0)
				{
              				array_push($arErrors, '16:Please remove CarruerNum.');
          			}
         		 break;
         		 
			// *載具類別為買受人自然人憑證(Citizen)時，請設定自然人憑證號碼，前2碼為大小寫英文，後14碼為數字
			case EcpayCarruerType::Citizen:
				if ( !preg_match('/^[a-zA-Z]{2}\d{14}$/', $arParameters['CarruerNum']) )
          			{
              				array_push($arErrors, '16:Invalid CarruerNum.');
                          	}
			break;
      
      			// *載具類別為買受人手機條碼(Cellphone)時，請設定手機條碼，第1碼為「/」，後7碼為大寫英文、數字、「+」、「-」或「.」
      			case EcpayCarruerType::Cellphone:
				if ( !preg_match('/^\/{1}[0-9A-Z+-.]{7}$/', $arParameters['CarruerNum']) )
				{
					array_push($arErrors, '16:Invalid CarruerNum.');
				}
			break;
			default:
				array_push($arErrors, '16:Please remove CarruerNum.');
		}
		
		// 17.課稅類別 TaxType(不可為空)
		
		// *不可為空
		if (strlen($arParameters['TaxType']) == 0)
		{
			array_push($arErrors, '17:TaxType is required.');
		}
		// *僅能為 1應稅 2零稅率 3免稅 9.應稅與免稅混合
		if ( ( $arParameters['TaxType'] != EcpayTaxType::Dutiable ) && ( $arParameters['TaxType'] != EcpayTaxType::Zero ) && ( $arParameters['TaxType'] != EcpayTaxType::Free ) && ( $arParameters['TaxType'] != EcpayTaxType::Mix ) )
		{
			array_push($arErrors, '17:Invalid TaxType.');
		}
		
		
		// 18.發票金額 SalesAmount
		
		// *不可為空
		if (strlen($arParameters['SalesAmount']) == 0)
		{
			array_push($arErrors, '18:SalesAmount is required.');
		}
		
		// 20.21.22.23.24.25. 商品資訊

		// *不可為空
		if (sizeof($arParameters['Items']) == 0)
		{
			array_push($arErrors, '20-25:Items is required.');
	        }
	        else
	        {
	        	// 檢查是否存在保留字元 '|'
			$bFind_Tag 		= true;
			$bError_Tag 		= false;
			
			foreach($arParameters['Items'] as $key => $value)
			{
				$bFind_Tag = strpos($value['ItemName'], '|') ;
				if($bFind_Tag != false || empty($value['ItemName']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '20:Invalid ItemName.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemCount'], '|') ;
				if($bFind_Tag != false || empty($value['ItemCount']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '21:Invalid ItemCount.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemWord'], '|') ;
				if($bFind_Tag != false || empty($value['ItemWord']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '22:Invalid ItemWord.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemPrice'], '|') ;
				if($bFind_Tag != false || $value['ItemPrice'] === '')
				{
					$bError_Tag = true ;
					array_push($arErrors, '23:Invalid ItemPrice.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemTaxType'], '|') ;
				if($bFind_Tag != false || empty($value['ItemTaxType']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '24:Invalid ItemTaxType.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemAmount'], '|') ;
				if($bFind_Tag != false || $value['ItemAmount'] === '' )
				{
					$bError_Tag = true ;
					array_push($arErrors, '25:Invalid ItemAmount.');
					break;	
				}
			}

			// 檢查商品格式
	        	if(!$bError_Tag)
	        	{
	        		foreach($arParameters['Items'] as $key => $value)
	        		{
	        			// *ItemCount數字判斷
	        			if ( !preg_match('/^[0-9]*$/', $value['ItemCount']) )
	        			{
	        				array_push($arErrors, '21:Invalid ItemCount.');
	        			}
	        			
	        			// *ItemWord 預設最大長度為6碼
	        			if (strlen($value['ItemWord']) > 6 )
					{
						array_push($arErrors, '22:ItemWord max length as 6.');
					}
					
					// *ItemPrice數字判斷
	        			if ( !preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemPrice']) )
	        			{
	        				array_push($arErrors, '23:Invalid ItemPrice.');
	        			}
	        			
	        			// *ItemAmount數字判斷
	        			if ( !preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemAmount']) )
	        			{
	        				array_push($arErrors, '25:Invalid ItemAmount.');
	        			}
	        			else
	        			{
	        				$nCheck_Amount = $nCheck_Amount + $value['ItemAmount'] ;
	        			}
	        		}

	        		// *檢查商品總金額
					if ( $arParameters['SalesAmount'] != round($nCheck_Amount))
					{
						array_push($arErrors, '18.2:Invalid SalesAmount.');
					}

					// *檢查商品課稅別
					// 課稅類別為混合稅率時
					if ($arParameters['TaxType'] == EcpayTaxType::Mix)
					{
						$ItemTaxType = explode('|', $arParameters['ItemTaxType']);

						// 商品課稅別不可為空
						if(empty($arParameters['ItemTaxType']))
						{
							array_push($arErrors, '24:ItemTaxType is required.');
						}
						// 需含二筆或以上的商品課稅別
						if ( count($ItemTaxType) < 2)
						{
							array_push($arErrors, '24:ItemTaxType should be more than 2.');
						}
						// 免稅和零稅率發票不能同時開立
						// 只能有兩種情形 :
						// 1.應稅+免稅
						// 2.應稅+零稅率
						$items = array_unique($ItemTaxType);
						if ( count($items) != 2 || !in_array(1, $items))
						{
							array_push($arErrors, '24:ItemTaxType error.');
						}
					}
	        	}
	        }

	        // 27.字軌類別 
		// *InvType(不可為空) 僅能為 07 或 08 狀態
		if( ( $arParameters['InvType'] != EcpayInvType::General ) && ( $arParameters['InvType'] != EcpayInvType::Special ) )
		{
			array_push($arErrors, '27:Invalid InvType.');
		}

		// 30.延遲註記 DelayFlag
		if( ( $arParameters['DelayFlag'] != EcpayDelayFlagType::Delay ) && ( $arParameters['DelayFlag'] != EcpayDelayFlagType::Trigger ) )
		{
			array_push($arErrors, '30:Invalid DelayFlagType.');
		}
		
		// 31.延遲天數 DelayDay
		// 延遲天數，範圍0~15，設定為0時，付款完成後立即開立發票
		
		// *DelayDay(不可為空, 預設為0)
		$arParameters['DelayDay'] = (int)$arParameters['DelayDay'];
		// *若為延遲開立時，延遲天數須介於1至15天內
		if ( $arParameters['DelayFlag'] == EcpayDelayFlagType::Delay )
		{
			if ($arParameters['DelayDay'] < 1 || $arParameters['DelayDay'] > 15)
			{
				array_push($arErrors, '31:DelayDay should be 1 ~ 15.');
			}
		}
		// *若為觸發開立時，延遲天數須介於0至15天內
		if ($arParameters['DelayFlag'] == EcpayDelayFlagType::Trigger)
		{
			if ($arParameters['DelayDay'] < 0 || $arParameters['DelayDay'] > 15)
			{
				array_push($arErrors, '31:DelayDay should be 0 ~ 15.');
			}
		}

		// 33.交易單號 Tsr	
		// *必填項目
		if(strlen($arParameters['Tsr']) == 0 )
        	{
        		array_push($arErrors, '33:Tsr is required.');
        	}
	        
	        // *判斷最大字元是否超過30字
		if (strlen($arParameters['Tsr']) > 30)
		{
				array_push($arErrors, '33:Tsr max length as 30.');
			}
		
		// 34.交易類別 PayType
		
		// *2016-10-4 修改為僅允許 2
		if( $arParameters['PayType'] != EcpayPayTypeCategory::Ecpay )
		{
			array_push($arErrors, '34:Invalid PayType.');
		}
		else
        	{
        		// *必填項目 交易類別名稱預設不能為空值 僅允許 ECPAY
        		$arParameters['PayAct'] = 'ECPAY' ;
        	}
		
        	if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	// 刪除items 
        	unset($arParameters['Items']);

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

    		if(isset($arParameters['CarruerNum']))
    		{
			// 載具編號內包含+號則改為空白
			$arParameters['CarruerNum'] = str_replace('+',' ',$arParameters['CarruerNum']);
		}

		return $arParameters ;
    	}   
}

/**
*  C開立折讓 
*/
class ECPay_ALLOWANCE
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CustomerName'		=>'',
		'Items'			=>[],
		'ItemName'		=>'',
		'ItemCount'		=>'',
		'ItemWord'		=>'',
		'ItemPrice'		=>'',
		'ItemTaxType'		=>'',
		'ItemAmount'		=>'',
		'CheckMacValue'		=>'',
		'InvoiceNo'		=>'',
		'AllowanceNotify' 	=>'',
		'NotifyMail' 		=>'',
		'NotifyPhone' 		=>'',
		'AllowanceAmount' 	=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'CustomerName' 		=>'',
        	'NotifyMail'		=>'',
        	'ItemName' 		=>'',
        	'ItemWord'		=>''
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
       		'ItemName' 		=>'',
       		'ItemWord'		=>'',
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
		$nItems_Count_Total = 0 ;
		$nItems_Foreach_Count = 1 ;
		$sItemName = '' ;
		$sItemCount = '' ;
		$sItemWord = '' ;
		$sItemPrice = '' ;
		$sItemTaxType = '' ;
		$sItemAmount = '' ;
		$sItemRemark = '' ;

	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        // 商品資訊組合
		$nItems_Count_Total = count($arParameters['Items']) ;	// 商品總筆數

		if($nItems_Count_Total != 0)
		{
			foreach($arParameters['Items'] as $key2 => $value2)
			{
				$sItemName 	.= (isset($value2['ItemName']))		? $value2['ItemName'] 		: '' ;
				$sItemCount 	.= (int) $value2['ItemCount'] ;
				$sItemWord 	.= (isset($value2['ItemWord'])) 	? $value2['ItemWord'] 		: '' ;
				$sItemPrice 	.= $value2['ItemPrice'] ;		
				$sItemTaxType 	.= (isset($value2['ItemTaxType'])) 	? $value2['ItemTaxType'] 	: '' ;
				$sItemAmount	.= $value2['ItemAmount'] ;
				
				if( $nItems_Foreach_Count < $nItems_Count_Total )
				{
					$sItemName .= '|' ;
					$sItemCount .= '|' ;
					$sItemWord .= '|' ;
					$sItemPrice .= '|' ;
					$sItemTaxType .= '|' ;
					$sItemAmount .= '|' ;
				}

				$nItems_Foreach_Count++ ; 		
			}
		}

		$this->parameters['ItemName'] 		= $sItemName;		// 商品名稱
		$this->parameters['ItemCount'] 		= $sItemCount ;
		$this->parameters['ItemWord'] 		= $sItemWord;		// 商品單位
		$this->parameters['ItemPrice'] 		= $sItemPrice ;
		$this->parameters['ItemTaxType'] 	= $sItemTaxType ;
		$this->parameters['ItemAmount'] 	= $sItemAmount ;

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];
    		$nCheck_Amount = 0 ; 	// 驗證總金額

		// 7.客戶名稱 CustomerName
		// x僅能為中英數字格式
		// *預設最大長度為30碼
		if( mb_strlen($arParameters['CustomerName'], 'UTF-8') > 30)
		{
			array_push($arErrors, '7:CustomerName max length as 30.');
		}

		// 20.21.22.23.24.25. 商品資訊

		// *不可為空
		if (sizeof($arParameters['Items']) == 0)
		{
			array_push($arErrors, '20-25:Items is required.');
		}
		else
		{
			// 檢查是否存在保留字元 '|'
			$bFind_Tag 		= true;
			$bError_Tag 		= false;

			foreach($arParameters['Items'] as $key => $value)
			{
				$bFind_Tag = strpos($value['ItemName'], '|') ;
				if($bFind_Tag != false || empty($value['ItemName']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '20:Invalid ItemName.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemCount'], '|') ;
				if($bFind_Tag != false || empty($value['ItemCount']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '21:Invalid ItemCount.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemWord'], '|') ;
				if($bFind_Tag != false || empty($value['ItemWord']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '22:Invalid ItemWord.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemPrice'], '|') ;
				if($bFind_Tag != false || empty($value['ItemPrice']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '23:Invalid ItemPrice.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemTaxType'], '|') ;
				if($bFind_Tag != false || empty($value['ItemTaxType']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '24:Invalid ItemTaxType.');
					break;	
				}
				
				$bFind_Tag = strpos($value['ItemAmount'], '|') ;
				if($bFind_Tag != false || empty($value['ItemAmount']))
				{
					$bError_Tag = true ;
					array_push($arErrors, '25:Invalid ItemAmount.');
					break;	
				}
			}
			
			// 檢查商品格式
			if(!$bError_Tag)
			{
				foreach($arParameters['Items'] as $key => $value)
				{
					// *ItemCount數字判斷
					if ( !preg_match('/^[0-9]*$/', $value['ItemCount']) )
					{
						array_push($arErrors, '21:Invalid ItemCount.');
					}
					
					// *ItemWord 預設最大長度為6碼
					if (strlen($value['ItemWord']) > 6 )
					{
						array_push($arErrors, '22:ItemWord max length as 6.');
					}
					
					// *ItemPrice數字判斷
					if ( !preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemPrice']) )
					{
						array_push($arErrors, '23:Invalid ItemPrice.');
					}
					
					// *ItemAmount數字判斷
					if ( !preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemAmount']) )
					{
						array_push($arErrors, '25:Invalid ItemAmount.');
					}
					else
	        			{
	        				$nCheck_Amount = $nCheck_Amount + $value['ItemAmount'] ;
	        			}
				}

				// *檢查商品總金額
				if ( $arParameters['AllowanceAmount'] != round($nCheck_Amount))
				{
					array_push($arErrors, '41:Invalid AllowanceAmount.');
				}	
			}
		}

		// 37.發票號碼 InvoiceNo
		        	
		// *必填項目
		if(strlen($arParameters['InvoiceNo']) == 0 )
		{
			array_push($arErrors, '37:InvoiceNo is required.');
		}
		// *預設長度固定10碼
		if (strlen($arParameters['InvoiceNo']) != 10)
		{
			array_push($arErrors, '37:InvoiceNo length as 10.');
		}

		// 38.通知類別 AllowanceNotify
		        	
		// *固定給定下述預設值
		if( ( $arParameters['AllowanceNotify'] != EcpayAllowanceNotifyType::Sms ) && ( $arParameters['AllowanceNotify'] != EcpayAllowanceNotifyType::Email ) && ( $arParameters['AllowanceNotify'] != EcpayAllowanceNotifyType::All ) && ( $arParameters['AllowanceNotify'] != EcpayAllowanceNotifyType::None ) )
		{
			array_push($arErrors, '38:Invalid AllowanceNotifyType.');
		}

		// 39.通知電子信箱 NotifyMail

		// *若客戶電子信箱有值時，則格式僅能為Email的標準格式
		if(strlen($arParameters['NotifyMail']) > 0 )
		{
			if ( !preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is', $arParameters['NotifyMail'] ) )
			{
				array_push($arErrors, '39:Invalid Email Format.');
			}
		}
		// *下述情況通知電子信箱不可為空值(通知類別為E-電子郵件)
		if($arParameters['AllowanceNotify'] == EcpayAllowanceNotifyType::Email && strlen($arParameters['NotifyMail']) == 0 )
		{
			array_push($arErrors, '39:NotifyMail is required.');
		}

		// 40.通知手機號碼 NotifyPhone
		// *若客戶手機號碼有值時，則預設格式為數字組成
		if(strlen($arParameters['NotifyPhone']) > 0 )
		{
			if ( !preg_match('/^[0-9]*$/', $arParameters['NotifyPhone']) )
			{
				array_push($arErrors, '40:Invalid NotifyPhone.');
			}
		}
		// * 最大20字元
		if (strlen($arParameters['NotifyPhone']) > 20)
		{
				array_push($arErrors, '40:NotifyPhone max length as 20.');
			}
		// *下述情況通知手機號碼不可為空值(通知類別為S-簡訊)
		if( $arParameters['AllowanceNotify'] == EcpayAllowanceNotifyType::Sms && strlen($arParameters['NotifyPhone']) == 0 )
		{
			array_push($arErrors, '40:NotifyPhone is required.');
		}

		// 39-40 通知電子信箱、通知手機號碼不能全為空值 (如果狀態為SMS 或 EMAIL)
		if(strlen($arParameters['NotifyPhone']) == 0 && strlen($arParameters['NotifyMail']) == 0 && ( $arParameters['AllowanceNotify'] == EcpayAllowanceNotifyType::Sms || $arParameters['AllowanceNotify'] == EcpayAllowanceNotifyType::Email ) )
		{
			array_push($arErrors, '39-40:NotifyMail or NotifyPhone is required.');
		}
		else
		{
			// *下述情況通知手機號碼與電子信箱不可為空值(通知類別為A-皆通知)
			if( $arParameters['AllowanceNotify'] == EcpayAllowanceNotifyType::All && ( strlen($arParameters['NotifyMail']) == 0 || strlen($arParameters['NotifyPhone']) == 0 ) )
			{
				array_push($arErrors, '39-40:NotifyMail And NotifyPhone is required.');
			}
			
			// *下述情況通知手機號碼與電子信箱為空值(通知類別為N-皆不通知)
			if($arParameters['AllowanceNotify'] == EcpayAllowanceNotifyType::None && ( strlen($arParameters['NotifyMail']) > 0 || strlen($arParameters['NotifyPhone']) > 0 ))
			{
				array_push($arErrors, '39-40:Please remove NotifyMail And NotifyPhone.');
			}
		}

		// 41.折讓單總金額 AllowanceAmount

		// *必填項目
		if(strlen($arParameters['AllowanceAmount']) == 0)
		{
			array_push($arErrors, '41:AllowanceAmount is required.');
		}
		else
		{
			// *含稅總金額
			$arParameters['AllowanceAmount'] = $arParameters['AllowanceAmount'] ;	
		}

        	if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	// 刪除items 
        	unset($arParameters['Items']);

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  D發票作廢 
*/
class ECPay_INVOICE_VOID
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CheckMacValue'		=>'',
		'InvoiceNumber'		=>'',
		'Reason' 		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'Reason' 		=>''
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
       		'Reason' 		=>'',
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

		// 42.發票號碼 InvoiceNumber 

		// *必填項目
		if(strlen($arParameters['InvoiceNumber']) == 0)
		{
			array_push($arErrors, '42:InvoiceNumber is required.');
		}
		// *預設長度固定10碼
		if(strlen($arParameters['InvoiceNumber']) != 10)
		{
			array_push($arErrors, '42:InvoiceNumber length as 10.');
		}

		// 43.作廢原因 Reason
		// *必填欄位
		if(strlen($arParameters['Reason']) == 0)
		{
			array_push($arErrors, '43:Reason is required.');
		}
		// *字數限制在20(含)個字以內
		if( mb_strlen($arParameters['Reason'], 'UTF-8') > 20)
		{
			//array_push($arErrors, "43:Reason max length as 20.");
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  E折讓作廢
*/
class ECPay_ALLOWANCE_VOID
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CheckMacValue'		=>'',
		'InvoiceNo'		=>'',
		'Reason' 		=>'',
		'AllowanceNo'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'Reason' 		=> ''
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
       		'Reason' 		=>'',
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

		// 37.發票號碼 InvoiceNo
		// *必填項目
		if(strlen($arParameters['InvoiceNo']) == 0 )
		{
			array_push($arErrors, '37:InvoiceNo is required.');
		}
		  // *預設長度固定10碼
		if (strlen($arParameters['InvoiceNo']) != 10)
		{
			array_push($arErrors, '37:InvoiceNo length as 10.');
		}

		// 43.作廢原因 Reason
		// *必填欄位
		if(strlen($arParameters['Reason']) == 0)
		{
			array_push($arErrors, '43:Reason is required.');
		}
		// *字數限制在20(含)個字以內
		if( mb_strlen($arParameters['Reason'], 'UTF-8') > 20)
		{
			array_push($arErrors, '43:Reason max length as 20.');
		}

		// 44.折讓編號 AllowanceNo
		if(strlen($arParameters['AllowanceNo']) == 0)
		{
			array_push($arErrors, '44:AllowanceNo is required.');
		}
		// *若有值長度固定16字元
		if(strlen($arParameters['AllowanceNo']) != 0 && strlen($arParameters['AllowanceNo']) != 16 )
		{
			array_push($arErrors, '44:AllowanceNo length as 16.');
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  F查詢發票
*/
class ECPay_INVOICE_SEARCH
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'RelateNumber'		=>'',
		'CheckMacValue'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'IIS_Customer_Name' 	=>'',
        	'IIS_Customer_Addr' 	=>'',
        	'ItemName' 		=>'',
        	'ItemWord' 		=>'',
        	'ItemRemark'		=>'',
        	'InvoiceRemark'		=>''
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
       		'ItemName' 		=>'',
       		'ItemWord' 		=>'',
       		'ItemRemark'		=>'',
       		'InvoiceRemark'		=>'',
       		'PosBarCode' 		=>'',
       		'QRCode_Left' 		=>'',
       		'QRCode_Right' 		=>'',
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

		// *預設不可為空值
		if(strlen($arParameters['RelateNumber']) == 0)
		{
			array_push($arErrors, '4:RelateNumber is required.');
		}
		// *預設最大長度為30碼
		if(strlen($arParameters['RelateNumber']) > 30)
		{
			array_push($arErrors, '4:RelateNumber max langth as 30.');
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		if(isset($arParameters['IIS_Customer_Email']))
		{
			$arParameters['IIS_Customer_Email'] = str_replace('+',' ',$arParameters['IIS_Customer_Email']);
		}

		if(isset($arParameters['IIS_Carruer_Num']))
		{
			$arParameters['IIS_Carruer_Num'] = str_replace('+',' ',$arParameters['IIS_Carruer_Num']);
		}

		return $arParameters ;
    	}   
}

/**
*  G查詢作廢發票
*/
class ECPay_INVOICE_VOID_SEARCH
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'RelateNumber'		=>'',
		'CheckMacValue'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'Reason' 		=>''
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
       		'Reason' 		=>'',
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

		// 4.廠商自訂編號

		// *預設不可為空值
		if(strlen($arParameters['RelateNumber']) == 0)
		{
			array_push($arErrors, '4:RelateNumber is required.');
		}
		// *預設最大長度為30碼
		if(strlen($arParameters['RelateNumber']) > 30)
		{
			array_push($arErrors, '4:RelateNumber max langth as 30.');
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  H查詢折讓明細
*/
class ECPay_ALLOWANCE_SEARCH
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CheckMacValue'		=>'',
		'InvoiceNo'		=>'',
		'AllowanceNo'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'ItemName' 		=>'',
        	'ItemWord' 		=>'',
        	'IIS_Customer_Name' 	=>''

        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
		'ItemName'		=>'',
		'ItemWord'		=>'',				
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

		// 37.發票號碼 InvoiceNo
		// *必填項目
		if(strlen($arParameters['InvoiceNo']) == 0 )
		{
			array_push($arErrors, '37:InvoiceNo is required.');
		}
		  // *預設長度固定10碼
		if (strlen($arParameters['InvoiceNo']) != 10)
		{
			array_push($arErrors, '37:InvoiceNo length as 10.');
		}
		
		// 44.折讓編號 AllowanceNo
		// *必填項目
		if(strlen($arParameters['AllowanceNo']) == 0)
		{
			array_push($arErrors, '44:AllowanceNo is required.');
		}
		// *若有值長度固定16字元
		if(strlen($arParameters['AllowanceNo']) != 0 && strlen($arParameters['AllowanceNo']) != 16 )
		{
			array_push($arErrors, '44:AllowanceNo length as 16.');
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  I查詢折讓作廢明細
*/
class ECPay_ALLOWANCE_VOID_SEARCH
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CheckMacValue'		=>'',
		'InvoiceNo'		=>'',
		'AllowanceNo'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'Reason' 		=>''

        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [
		'Reason'		=>'',				
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

		// 37.發票號碼 InvoiceNo
		// *必填項目
		if(strlen($arParameters['InvoiceNo']) == 0 )
		{
			array_push($arErrors, '37:InvoiceNo is required.');
		}
		  // *預設長度固定10碼
		if (strlen($arParameters['InvoiceNo']) != 10)
		{
			array_push($arErrors, '37:InvoiceNo length as 10.');
		}
		
		// 44.折讓編號 AllowanceNo
		// *必填項目
		if(strlen($arParameters['AllowanceNo']) == 0)
		{
			array_push($arErrors, '44:AllowanceNo is required.');
		}
		// *若有值長度固定16字元
		if(strlen($arParameters['AllowanceNo']) != 0 && strlen($arParameters['AllowanceNo']) != 16 )
		{
			array_push($arErrors, '44:AllowanceNo length as 16.');
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  J發送通知
*/
class ECPay_INVOICE_NOTIFY
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CheckMacValue'		=>'',
		'InvoiceNo'		=>'',
		'AllowanceNo'		=>'',
		'NotifyMail'		=>'',
		'Phone'			=>'',
		'Notify'		=>'',
		'InvoiceTag'		=>'',
		'Notified'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	'NotifyMail' 		=>''

        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [				
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

		// 37.發票號碼 InvoiceNo
		if( ( $arParameters['InvoiceTag'] == EcpayInvoiceTagType::Invoice ) || ( $arParameters['InvoiceTag'] == EcpayInvoiceTagType::Invoice_Void ) )
		{
			// *必填項目
			if(strlen($arParameters['InvoiceNo']) == 0 )
			{
				array_push($arErrors, '37:InvoiceNo is required.');
			}
			  // *預設長度固定10碼
			if (strlen($arParameters['InvoiceNo']) != 10)
			{
				array_push($arErrors, '37:InvoiceNo length as 10.');
			}
		}

		// 44.折讓編號 AllowanceNo
		if( ( $arParameters['InvoiceTag'] == EcpayInvoiceTagType::Allowance ) || ( $arParameters['InvoiceTag'] == EcpayInvoiceTagType::Allowance_Void ) )
		{	
			if(strlen($arParameters['AllowanceNo']) == 0)
			{
				array_push($arErrors, '44:AllowanceNo is required.');
			}

			// *若有值長度固定16字元
			if(strlen($arParameters['AllowanceNo']) != 0 && strlen($arParameters['AllowanceNo']) != 16 )
			{
				array_push($arErrors, '44:AllowanceNo length as 16.');
			}
		}	

		// 45.NotifyMail 發送電子信箱 

		// *若客戶電子信箱有值時，則格式僅能為Email的標準格式
		if(strlen($arParameters['NotifyMail']) > 0 )
		{
			if ( !preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is', $arParameters['NotifyMail']) )
			{
				array_push($arErrors, '45:Invalid Email Format.');
			}
		}
		// *下述情況通知電子信箱不可為空值(發送方式為E-電子郵件)
		if( $arParameters['Notify'] == EcpayNotifyType::Email && strlen($arParameters['NotifyMail']) == 0 )
		{
			array_push($arErrors, '39:NotifyMail is required.');
		}

		// 46.通知手機號碼 NotifyPhone
		// *若客戶手機號碼有值時，則預設格式為數字組成
		if(strlen($arParameters['Phone']) > 0 )
		{
			if ( !preg_match('/^[0-9]*$/', $arParameters['Phone']) )
			{
				array_push($arErrors, '46:Invalid Phone.');
			}
		}
		// *最大長度為20碼
		if(strlen($arParameters['Phone']) > 20 )
		{
			array_push($arErrors, '46:Phone max length as 20.');
		}
		// *下述情況通知手機號碼不可為空值(發送方式為S-簡訊)
		if( $arParameters['Notify'] == EcpayNotifyType::Sms && strlen($arParameters['Phone']) == 0 )
		{
			array_push($arErrors, '46:Phone is required.');
		}

		// 45-46 發送簡訊號碼、發送電子信箱不能全為空值
		if(strlen($arParameters['Phone']) == 0 && strlen($arParameters['NotifyMail']) == 0)
		{
			array_push($arErrors, '45-46:NotifyMail or Phone is required.');
		}
		else
		{
			if( $arParameters['Notify'] == EcpayNotifyType::All && ( strlen($arParameters['NotifyMail']) == 0 || strlen($arParameters['Phone']) == 0 ) )
			{
				array_push($arErrors, '45-46:NotifyMail and Phone is required.');
			}
		}
		// 47. 發送方式 Notify

		// *固定給定下述預設值
		if( ($arParameters['Notify'] != EcpayNotifyType::Sms ) && ( $arParameters['Notify'] != EcpayNotifyType::Email ) && ( $arParameters['Notify'] != EcpayNotifyType::All ) )
		{
			array_push($arErrors, '47:Notify is required.');
		}

		// 48.發送內容類型 InvoiceTag
		// *固定給定下述預設值
		if( ( $arParameters['InvoiceTag'] != EcpayInvoiceTagType::Invoice ) && ( $arParameters['InvoiceTag'] != EcpayInvoiceTagType::Invoice_Void ) && ( $arParameters['InvoiceTag'] != EcpayInvoiceTagType::Allowance ) && ( $arParameters['InvoiceTag'] != EcpayInvoiceTagType::Allowance_Void ) && ( $arParameters['InvoiceTag'] != EcpayInvoiceTagType::Invoice_Winning ) )
		{
			array_push($arErrors, '48:InvoiceTag is required.');
		}

		// 49.發送對象 Notified
		// *固定給定下述預設值
		if( ( $arParameters['Notified'] != EcpayNotifiedType::Customer ) && ( $arParameters['Notified'] != EcpayNotifiedType::vendor ) && ( $arParameters['Notified'] != EcpayNotifiedType::All ) )
		{
			array_push($arErrors, '49:Notified is required.');
		}

		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  K付款完成觸發或延遲開立發票
*/
class ECPay_INVOICE_TRIGGER
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CheckMacValue'		=>'',
		'Tsr'			=>'',
		'PayType'		=> 2
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [				
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

    		// 33.交易單號 Tsr
		// *必填項目
		if(strlen($arParameters['Tsr']) == 0 )
		{
			array_push($arErrors, '33:Tsr is required.');
		}

		// *判斷最大字元是否超過30字
		if (strlen($arParameters['Tsr']) > 30)
		{
			array_push($arErrors, '33:Tsr max length as 30.');
		}

		// 34.交易類別 PayType
		// *2016-10-4 修改為僅允許 2
		if( $arParameters['PayType'] != EcpayPayTypeCategory::Ecpay)
		{
			array_push($arErrors, '34:Invalid PayType.');
		}
		
		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}

/**
*  L手機條碼驗證
*/
class ECPay_CHECK_MOBILE_BARCODE
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'CheckMacValue'		=>'',
		'BarCode'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [				
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

    		// 50.BarCode 手機條碼 
		// *僅能為8碼且為必填
		if( strlen($arParameters['BarCode']) != 8 )
		{
			array_push($arErrors, '50:BarCode max length as 8.');
		}
		
		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

    		if(isset($arParameters['BarCode']))
    		{
			// 手機條碼 內包含+號則改為空白
			$arParameters['BarCode'] = str_replace('+',' ',$arParameters['BarCode']);
		}

		return $arParameters ;
    	}   
}

/**
*  M愛心碼驗證
*/
class ECPay_CHECK_LOVE_CODE
{
    	// 所需參數
    	public $parameters = [
            	'TimeStamp'		=>'',
		'MerchantID'		=>'',
		'LoveCode'		=>'',
		'CheckMacValue'		=>''
        	];

    	// 需要做urlencode的參數
       	public $urlencode_field = [
        	];

        // 不需要送壓碼的欄位
       	public $none_verification = [				
       		'CheckMacValue'		=>''
        	]; 

    	/**
	* 1寫入參數
	*/
    	function insert_string($arParameters = []){
	        
	        foreach ($this->parameters as $key => $value)
	        {
			if(isset($arParameters[$key]))
			{
	            		$this->parameters[$key] = $arParameters[$key];
	            	}
	        }

	        return $this->parameters ;
    	}

    	/**
	* 2-2 驗證參數格式
	*/
    	function check_extend_string($arParameters = []){
		
    		$arErrors = [];

    		// 51.LoveCode愛心碼
		// *必填 3-7碼
		if( strlen($arParameters['LoveCode']) > 7 )
		{
			array_push($arErrors, '51:LoveCode max length as 7.');
		}
		
		if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        	return $arParameters ;
    	}

    	/**
	* 4欄位例外處理方式(送壓碼前)
	*/
    	function check_exception($arParameters = []){

		return $arParameters ;
    	}   
}


if(!class_exists('ECPay_Invoice_CheckMacValue'))
{
	/**
	*  檢查碼
	*/
	class ECPay_Invoice_CheckMacValue
	{
		/**
		* 產生檢查碼
		*/
		static function generate($arParameters = [], $HashKey = '', $HashIV = '', $encType = 0){

			$sMacValue = '' ;

			if(isset($arParameters)){
				
                		unset($arParameters['CheckMacValue']);
				uksort($arParameters, ['ECPay_Invoice_CheckMacValue','merchantSort']);

				// 組合字串
				$sMacValue = 'HashKey=' . $HashKey ;
				foreach($arParameters as $key => $value)
				{
					$sMacValue .= '&' . $key . '=' . $value ;
				}

				$sMacValue .= '&HashIV=' . $HashIV ;

				// URL Encode編碼     
				$sMacValue = urlencode($sMacValue); 

				// 轉成小寫
				$sMacValue = strtolower($sMacValue);

				// 取代為與 dotNet 相符的字元
				$sMacValue = ECPay_Invoice_CheckMacValue::Replace_Symbol($sMacValue);

				// 編碼
				switch ($encType)
				{
					case ECPay_EncryptType::ENC_SHA256:
					    $sMacValue = hash('sha256', $sMacValue);	// SHA256 編碼
					break;

					case ECPay_EncryptType::ENC_MD5:
					default:
					
					$sMacValue = md5($sMacValue); 	// MD5 編碼
				}

				$sMacValue = strtoupper($sMacValue);
			}  

			return $sMacValue ;
		}

		/**
		* 自訂排序使用
		*/
		private static function merchantSort($a,$b){
			return strcasecmp($a, $b);
		}

    	/**
		* 參數內特殊字元取代
		* 傳入	$sParameters	參數
		* 傳出	$sParameters	回傳取代後變數
		*/
		static function Replace_Symbol($sParameters){
			if(!empty($sParameters)){
				
				$sParameters = str_replace('%2D', '-', $sParameters);
				$sParameters = str_replace('%2d', '-', $sParameters);
				$sParameters = str_replace('%5F', '_', $sParameters);
				$sParameters = str_replace('%5f', '_', $sParameters);
				$sParameters = str_replace('%2E', '.', $sParameters);
				$sParameters = str_replace('%2e', '.', $sParameters);
				$sParameters = str_replace('%21', '!', $sParameters);
				$sParameters = str_replace('%2A', '*', $sParameters);
				$sParameters = str_replace('%2a', '*', $sParameters);
				$sParameters = str_replace('%28', '(', $sParameters);
				$sParameters = str_replace('%29', ')', $sParameters);
			}

			return $sParameters ;
		}

		/**
		* 參數內特殊字元還原
		* 傳入	$sParameters	參數
		* 傳出	$sParameters	回傳取代後變數
		*/
		static function Replace_Symbol_Decode($sParameters){
			if(!empty($sParameters)){
				
				$sParameters = str_replace('-', '%2d', $sParameters);
				$sParameters = str_replace('_', '%5f', $sParameters);
				$sParameters = str_replace('.', '%2e', $sParameters);
				$sParameters = str_replace('!', '%21', $sParameters);
				$sParameters = str_replace('*', '%2a', $sParameters);
				$sParameters = str_replace('(', '%28', $sParameters);
				$sParameters = str_replace(')', '%29', $sParameters);
				$sParameters = str_replace('+', '%20', $sParameters);
			}

			return $sParameters ;
		}
	}
}

if(!class_exists('ECPay_IO'))
{
	class ECPay_IO
	{
		static function ServerPost($parameters ,$ServiceURL){

            $sSend_Info = '' ;

            // 組合字串
			foreach($parameters as $key => $value)
			{
				if( $sSend_Info == '')
				{
					$sSend_Info .= $key . '=' . $value ;
				}
				else
				{
					$sSend_Info .= '&' . $key . '=' . $value ;
				}
			}

            $ch = curl_init();

            if (FALSE === $ch) {
                throw new Exception('curl failed to initialize');
            }
            
            curl_setopt($ch, CURLOPT_URL, $ServiceURL);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $sSend_Info);
            $rs = curl_exec($ch);

            if (FALSE === $rs) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);

            return $rs;
		}
	}
}
