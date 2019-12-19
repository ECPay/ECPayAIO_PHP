<?php
/*
Apple Pay SDK
版本:V1.1.190626
@author Wesley
*/

/**
 * 付款方式。
 */
abstract class ECPay_ApplePay_PaymentMethod {

    /**
     * 信用卡付費。
     */
    const Credit = 'Credit';

}

/**
 * 信用卡訂單處理動作資訊。
 */
abstract class ECPay_ApplePay_ActionType {

    /**
     * 關帳
     */
    const C = 'C';

    /**
     * 退刷
     */
    const R = 'R';

    /**
     * 取消
     */
    const E = 'E';

    /**
     * 放棄
     */
    const N = 'N';

}

/**
 * 交易來源。
 */
abstract class ECPay_TradeType {

    /**
     * In App
     */
    const APP = 1;

    /**
     * On the Web
     */
    const WEB = 2;

}





class Ecpay_ApplePay
{
    /**
     * 版本
     */
    const VERSION = '1.1.190626';

    public $MerchantID  = '';
    public $HashKey     = '';
    public $HashIV      = '';
    public $ServiceURL  = 'ServiceURL';     // 執行網址

    public $Send        = '';
    public $Query       = '';
    public $Action      = '';
    public $Trade       = '';
    public $Funding     = '';
    public $Applepay_Button = '';
    public $Verify_Vendor   = '';

    function __construct(){
                
        $this->Send = [
            'MerchantTradeNo'       => '',
            'MerchantTradeDate'     => date('Y/m/d H:i:s'),
            'TotalAmount'           => 0,
            'CurrencyCode'          => 'TWD',
            'ItemName'          => '',
            'PlatformID'            => '',
            'TradeDesc'             => '',
            'TradeType'             => 2,
            'CheckMacValue'         => '',
            'PaymentToken'      => ''
        ];

            // 訂單查詢
        $this->Query = [
                'MerchantTradeNo'   => '',
                'TimeStamp'         => ''
        ];

            // 信用卡關帳/退刷/取消/放棄的方法
        $this->Action = [
            'MerchantTradeNo'   => '',
            'TradeNo'       => '',
            'Action'        => ECPay_ApplePay_ActionType::C,
            'TotalAmount'       => 0
        ];

            // 訂單查詢作業
        $this->Trade = [
            'CreditRefundId'    => '',
            'CreditAmount'      => '',
            'CreditCheckCode'   => ''
        ];

            // 下載信用卡撥款對帳資料檔
        $this->Funding = [
            'PayDateType'       => '',
            'StartDate'         => '',
            'EndDate'       => ''
            ];

            // applepay button
            $this->Applepay_Button = [
            'merchantIdentifier'    => '',
            'lable'         => '',
            'amount'        => '',
            'step1_url'     => '',
            'step2_url'     => '',
            'debug_mode'        => 'yes',
            'server_https'      => $_SERVER['HTTPS'],
            'success_site_url'  => '',
            'order_id'      => ''
            ];

            // 廠商憑證驗證
            $this->Verify_Vendor = [
            'displayName'       => '',
            'crt_path'      => '',
            'key_path'      => '',
            'key_password'      => ''
            ];
    }  

        // 產生訂單
    public function Check_Out() {
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID] ,$this->Send);
        return $arFeedback = ECPay_ApplePay_Send::CheckOut($arParameters, $this->HashKey, $this->HashIV, ECPay_ApplePay_PaymentMethod::Credit, $this->ServiceURL);
    }

     /**
    * 產生訂單 APP串接用
    * 傳入    $arPostData             檢查參數
    * 傳出    $sReturn_Msg | true     錯誤回傳 json格式 | 判斷正常
    */
    public function CheckOut_App($arPostData){
        
        //整理參數
        $this->Send['MerchantTradeNo']      = isset($arPostData['MerchantTradeNo'])     ? $arPostData['MerchantTradeNo']    : '';
        $this->Send['MerchantTradeDate']    = isset($arPostData['MerchantTradeDate'])   ? $arPostData['MerchantTradeDate']  : '';
        $this->Send['TotalAmount']          = isset($arPostData['TotalAmount'])     ? $arPostData['TotalAmount']        : '';
        $this->Send['CurrencyCode']         = isset($arPostData['CurrencyCode'])    ? $arPostData['CurrencyCode']       : '';
        $this->Send['ItemName']             = isset($arPostData['ItemName'])        ? $arPostData['ItemName']       : '';
        $this->Send['PlatformID']           = isset($arPostData['PlatformID'])      ? $arPostData['PlatformID']         : '';
        $this->Send['TradeDesc']            = isset($arPostData['TradeDesc'])       ? $arPostData['TradeDesc']      : '';
        $this->Send['PaymentToken']         = isset($arPostData['PaymentToken'])    ? $arPostData['PaymentToken']       : '';
        $this->Send['TradeType']            = 1;

        $arParameters = array_merge( ['MerchantID' => $this->MerchantID] ,$this->Send);
        $arFeedback = ECPay_ApplePay_Send::CheckOut($arParameters, $this->HashKey, $this->HashIV, ECPay_ApplePay_PaymentMethod::Credit, $this->ServiceURL);

        return json_encode($arFeedback) ;
    }

    //訂單查詢作業
    public function QueryTradeInfo() {
        return $arFeedback = ECPay_ApplePay_QueryTradeInfo::CheckOut(array_merge($this->Query, ['MerchantID' => $this->MerchantID]), $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    //信用卡關帳/退刷/取消/放棄的方法
    public function DoAction() {
        return $arFeedback = ECPay_ApplePay_DoAction::CheckOut(array_merge($this->Action, ['MerchantID' => $this->MerchantID]), $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    //查詢信用卡單筆明細紀錄
    public function QueryTrade(){
        return $arFeedback = ECPay_ApplePay_QueryTrade::CheckOut(array_merge($this->Trade, ['MerchantID' => $this->MerchantID]), $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    //下載信用卡撥款對帳資料檔
    public function FundingReconDetail($target = '_self'){
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID] ,$this->Funding);
        ECPay_ApplePay_FundingReconDetail::CheckOut($target, $arParameters, $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    // 產生applepay 按鈕
    public function applepay_button(){
        ECPay_Apple_Button::generate($this->Applepay_Button);
    }

    // 驗證憑證
    public function Verify_Vendor(){
        return $arFeedback = ECPay_Verify_Vendor::verify_vendor($this->Verify_Vendor, $this->ServiceURL);
    }


    // 測試驗證憑證
    public function Verify_Vendor_Test(){
        return $arFeedback = ECPay_Verify_Vendor::verify_vendor($this->Verify_Vendor, $this->ServiceURL, true);
    }
}


abstract class ECPay_ApplePay_IO
{   
    protected static function ServerPost($parameters ,$ServiceURL){

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

    protected static function VerifyVendor($parameters, $ServiceURL, $debug_mode = false){

        $Return_Msg = '';

            $sMerchantIdentifier =  openssl_x509_parse( file_get_contents( $parameters['crt_path'] ))['subject']['UID'] ;

        // create a new cURL resource
        $ch = curl_init();

        $data = '{"merchantIdentifier":"'.$sMerchantIdentifier.'", "domainName":"'.$_SERVER['SERVER_NAME'].'", "displayName":"'.$parameters['displayName'].'"}';

        curl_setopt($ch, CURLOPT_URL, $ServiceURL);
        curl_setopt($ch, CURLOPT_SSLCERT, $parameters['crt_path']);
        curl_setopt($ch, CURLOPT_SSLKEY, $parameters['key_path']);
        curl_setopt($ch, CURLOPT_SSLKEYPASSWD, $parameters['key_password']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($debug_mode)
        {
            //debug options
            //curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
        }

        $result = curl_exec($ch);

        if($debug_mode)
        {
            if( $result === false)
            {
                $Return_Msg .= curl_errno($ch) . ' - ' . curl_error($ch);   
            }
            else
            {    
                $Return_Msg .= 'applePay server response ' . $result ;
            }

            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);

            $Return_Msg .= htmlspecialchars($verboseLog);
        }
        else
        {
            $Return_Msg = $result ;  
        }

        curl_close($ch);
        return $Return_Msg; 
    }
}

/**
*  送出資訊
*/
class ECPay_ApplePay_Send extends ECPay_ApplePay_IO
{

    public static $PaymentObj ;
    public static $PaymentObj_Return ;

    // 資料檢查與過濾(送出)
    protected static function process_send($arParameters = [], $HashKey = '', $HashIV = '', $Payment_Method = '', $ServiceURL = ''){

        //宣告物件
        $PaymentMethod    = 'ECPay_ApplePay_'.$Payment_Method;
        self::$PaymentObj = new $PaymentMethod;

        // 1寫入參數
        $arParameters = self::$PaymentObj->insert_string($arParameters);

        // 2-1檢查共用參數
        self::$PaymentObj->check_string($arParameters['MerchantID'], $HashKey, $HashIV, $Payment_Method, $ServiceURL);

        // 2-2檢查各別參數
        $arParameters = self::$PaymentObj->check_extend_string($arParameters);

        // 3處理需要轉換為urlencode的參數
        //$arParameters = self::$PaymentObj->urlencode_process($arParameters);
        
        // 4欄位例外處理方式(送壓碼前)
        $arException = $arParameters ;
        //$arException = self::$PaymentObj->check_exception($arParameters);

        // 5產生壓碼
        $arParameters['CheckMacValue'] = self::$PaymentObj->generate_checkmacvalue($arException, $HashKey, $HashIV);

        // 6產生Paymenttoken加密
        $arParameters['PaymentToken'] = self::$PaymentObj->generate_encrypt_data($arParameters['PaymentToken'], $HashKey, $HashIV);

        return $arParameters ;
    }

    /**
    * 資料檢查與過濾(回傳)
    */
    protected static function process_return($sParameters = '', $HashKey = '', $HashIV = '', $Payment_Method = ''){

        //宣告物件
        $PaymentMethod    = 'ECPay_ApplePay_'.$Payment_Method;
        self::$PaymentObj_Return = new $PaymentMethod;

        // 7json轉陣列
        $arParameters = json_decode($sParameters, true);

        // 8欄位例外處理方式(送壓碼前)
        $arException = $arParameters ;
        //$arException = self::$PaymentObj_Return->check_exception($arParameters);

        // 9產生壓碼(壓碼檢查)
        if(isset($arParameters['CheckMacValue'])){
            $CheckMacValue = self::$PaymentObj_Return->generate_checkmacvalue($arException, $HashKey, $HashIV);
            
            if($CheckMacValue != $arParameters['CheckMacValue']){
                throw new Exception('注意：壓碼錯誤'); 
            }
        }

        // 10處理需要urldecode的參數
        $arParameters = self::$PaymentObj_Return->urldecode_process($arParameters);

        return $arParameters ;
    }

    /**
    * 背景送出資料
    */
    static function CheckOut($arParameters = [], $HashKey='', $HashIV='', $Payment_Method = '', $ServiceURL=''){
        
        // 發送資訊處理
        $arParameters = self::process_send($arParameters, $HashKey, $HashIV, $Payment_Method, $ServiceURL);

        $szResult = parent::ServerPost($arParameters, $ServiceURL);

        // 回傳資訊處理
        $arParameters_Return = self::process_return($szResult, $HashKey, $HashIV, $Payment_Method);

        return $arParameters_Return ;
    }
}

/**
* 產生訂單 APP串接用
* 傳入    $arPostData             檢查參數
* 傳出    $sReturn_Msg | true     錯誤回傳 json格式 | 判斷正常
*/
function CheckOut_App($arPostData){
    
    //整理參數
    $this->Send['MerchantTradeNo']      = isset($arPostData['MerchantTradeNo'])     ? $arPostData['MerchantTradeNo']    : '';
    $this->Send['MerchantTradeDate']    = isset($arPostData['MerchantTradeDate'])   ? $arPostData['MerchantTradeDate']  : '';
    $this->Send['TotalAmount']          = isset($arPostData['TotalAmount'])     ? $arPostData['TotalAmount']        : '';
    $this->Send['CurrencyCode']         = isset($arPostData['CurrencyCode'])    ? $arPostData['CurrencyCode']       : '';
    $this->Send['ItemName']             = isset($arPostData['ItemName'])        ? $arPostData['ItemName']       : '';
    $this->Send['PlatformID']           = isset($arPostData['PlatformID'])      ? $arPostData['PlatformID']         : '';
    $this->Send['TradeDesc']            = isset($arPostData['TradeDesc'])       ? $arPostData['TradeDesc']      : '';
    $this->Send['PaymentToken']         = isset($arPostData['PaymentToken'])    ? $arPostData['PaymentToken']       : '';
    $this->Send['TradeType']            = 1;

    $arParameters = array_merge( ['MerchantID' => $this->MerchantID] ,$this->Send);
    $arFeedback = ECPay_ApplePay_Send::CheckOut($arParameters, $this->HashKey, $this->HashIV, ECPay_ApplePay_PaymentMethod::Credit, $this->ServiceURL);

    return json_encode($arFeedback) ;
}

// 訂單資料查詢
class ECPay_ApplePay_QueryTradeInfo extends ECPay_ApplePay_IO
{
    static function CheckOut($arParameters = [], $HashKey ='', $HashIV ='', $ServiceURL = ''){
       
        $arErrors = [];
        $arParameters['TimeStamp'] = time();
        $arFeedback = [];
        $arConfirmArgs = [];

        // 呼叫查詢。
        if (sizeof($arErrors) == 0)
        {
            $arParameters['CheckMacValue'] = ECPay_ApplePay_CheckMacValue::generate($arParameters, $HashKey, $HashIV);
            
            // 送出查詢並取回結果。
            $szResult = parent::ServerPost($arParameters, $ServiceURL);
            $szResult = str_replace(' ', '%20', $szResult);
            $szResult = str_replace('+', '%2B', $szResult);

            // 轉結果為陣列。
            parse_str($szResult, $arResult);
            
            // 重新整理回傳參數。
            foreach ($arResult as $keys => $value) {
                if ($keys == 'CheckMacValue') {
                    $szCheckMacValue = $value;
                } else {
                    $arFeedback[$keys] = $value;
                    $arConfirmArgs[$keys] = $value;
                }
            }

            // 驗證檢查碼。
            if (sizeof($arFeedback) > 0)
            {
                $szConfirmMacValue = ECPay_ApplePay_CheckMacValue::generate($arConfirmArgs, $HashKey, $HashIV);
                
                if ($szCheckMacValue != $szConfirmMacValue)
                {
                    array_push($arErrors, 'CheckMacValue verify fail.');
                }
            }
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback ;

    }    
}

// 信用卡關帳/退刷/取消/放棄
class ECPay_ApplePay_DoAction extends ECPay_ApplePay_IO
{
    static function CheckOut($arParameters = [], $HashKey ='', $HashIV ='', $ServiceURL = ''){
    
        // 變數宣告。
        $arErrors = [];
        $arFeedback = [];

        //產生驗證碼
        $szCheckMacValue = ECPay_ApplePay_CheckMacValue::generate($arParameters,$HashKey,$HashIV);
        $arParameters['CheckMacValue'] = $szCheckMacValue;
      
        // 送出查詢並取回結果。
        $szResult = self::ServerPost($arParameters,$ServiceURL);
        
        // 轉結果為陣列。
        parse_str($szResult, $arResult);
        // 重新整理回傳參數。
        foreach ($arResult as $keys => $value) {
            if ($keys == 'CheckMacValue') {
                $szCheckMacValue = $value;
            } else {
                $arFeedback[$keys] = $value;
            }
        }

        if (array_key_exists('RtnCode', $arFeedback) && $arFeedback['RtnCode'] != '1') {
            array_push($arErrors, vsprintf('#%s: %s', [$arFeedback['RtnCode'], $arFeedback['RtnMsg']]));
        }
        
        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback ;

    }
}

// 查詢信用卡單筆明細記錄
class ECPay_ApplePay_QueryTrade extends ECPay_ApplePay_IO
{
    static function CheckOut($arParameters = [], $HashKey ='', $HashIV ='', $ServiceURL = ''){
        $arErrors = [];
        $arFeedback = [];
        $arConfirmArgs = [];

        // 呼叫查詢。
        if (sizeof($arErrors) == 0) {
            $arParameters['CheckMacValue'] = ECPay_ApplePay_CheckMacValue::generate($arParameters, $HashKey, $HashIV);
            // 送出查詢並取回結果。
            $szResult = parent::ServerPost($arParameters,$ServiceURL);
            
            // 轉結果為陣列。
            $arResult = json_decode($szResult,true);
            
            // 重新整理回傳參數。
            foreach ($arResult as $keys => $value) {
                $arFeedback[$keys] = $value;
            }
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback ;
    }
}

// 下載信用卡撥款對帳資料檔
class ECPay_ApplePay_FundingReconDetail extends ECPay_ApplePay_IO
{
    static function CheckOut($target = '_self', $arParameters = [], $HashKey='', $HashIV='', $ServiceURL=''){
        //產生檢查碼

        $szCheckMacValue = ECPay_ApplePay_CheckMacValue::generate($arParameters, $HashKey, $HashIV);
       
        //生成表單，自動送出
        $szHtml =  '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .=     '<head>';
        $szHtml .=         '<meta charset="utf-8">';
        $szHtml .=     '</head>';
        $szHtml .=     '<body>';
        $szHtml .=         "<form id=\"__ecpayForm\" method=\"post\" target=\"{$target}\" action=\"{$ServiceURL}\">";
        
        foreach ($arParameters as $keys => $value) {
            $szHtml .=         "<input type=\"hidden\" name=\"{$keys}\" value='{$value}' />";
        }

        $szHtml .=             "<input type=\"hidden\" name=\"CheckMacValue\" value=\"{$szCheckMacValue}\" />";
        $szHtml .=         '</form>';
        $szHtml .=         '<script type="text/javascript">document.getElementById("__ecpayForm").submit();</script>';
        $szHtml .=     '</body>';
        $szHtml .= '</html>';

        echo $szHtml ;
        exit;
    }
}

// 驗證廠商憑證
class ECPay_Verify_Vendor extends ECPay_ApplePay_IO
{
    public function verify_vendor($arParameters = [], $ServiceURL='', $debug_mode = false){

        $arErrors = [];

        if( parse_url($ServiceURL, PHP_URL_SCHEME ) != 'https' )
        {
            array_push($arErrors, 'ServiceURL verify fail.');
        }

        if( substr( parse_url($ServiceURL, PHP_URL_HOST), -10 )  != '.apple.com')
        {
            array_push($arErrors, 'ServiceURL verify fail.');
        }

        if(!is_file($arParameters['crt_path']))
        {
            array_push($arErrors, 'crt path verify fail.');
        }

        if(!is_file($arParameters['key_path']))
        {
            array_push($arErrors, 'key path verify fail.');
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
            }

        $Return_Info = parent::VerifyVendor($arParameters, $ServiceURL, $debug_mode);
        return $Return_Info ;

        
    }
}

// 產生apple pay buttom
class ECPay_Apple_Button extends ECPay_ApplePay_IO{

    public function generate($aApplepay_button = []){

        // 載入CSS
        echo '<link rel="stylesheet" type="text/css" media="screen" href="applepay_button.css">' ;

        // 載入javascript
        echo '<script src="jquery-1.11.1.js" type="text/javascript"></script>' ;

        // 傳送變數到javascript
        echo '<script type="text/javascript">' ;
        echo '/*' . '<![CDATA[ */';
        echo 'var apple_pay_params = ' . json_encode($aApplepay_button);
        echo '/*'.' ]]> */';
        echo '</script>';

        echo '<script src="applepay_button.js" type="text/javascript"></script>';
    }
}

Abstract class ECPay_ApplePay_Verification
{
    // 所需參數
        public $parameters = [];

        // 需要做urlencode的參數
        public $urlencode_field = [];

        // 不需要送壓碼的欄位
        public $none_verification = [];
    
    /**
    * 檢查各別參數
    */
    abstract function check_extend_string($arParameters = []);

    /**
    * 檢查各別參數
    */
    abstract function check_exception($arParameters = []);


        /**
    * 檢查共同參數
    */
    public function check_string($MerchantID = '', $HashKey = '', $HashIV = '', $Payment_Method = '', $ServiceURL = ''){
        
        $arErrors = [];
        
        // 檢查是否傳入動作方式
            if($Payment_Method == '')
            {
            array_push($arErrors, 'Payment_Method is required.');   
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

        if(sizeof($arErrors)>0) throw new Exception(join('- ', $arErrors)); 
    }

    /**
    * 處理需要轉換為urlencode的參數
    */
        function urlencode_process($arParameters = []){

            foreach($arParameters as $key => $value)
            {
                if(isset($this->urlencode_field[$key]))
                {
                    $arParameters[$key] = urlencode($value);
                    $arParameters[$key] = ECPay_ApplePay_CheckMacValue::Replace_Symbol($arParameters[$key]);
                }
            }

            return $arParameters ;
        }

    /**
    * 產生壓碼
    */
    function generate_checkmacvalue($arParameters = [], $HashKey = '', $HashIV = ''){
        
        $sCheck_MacValue = '';

        // 過濾不需要壓碼的參數
        foreach($this->none_verification as $key => $value)
        {
            if(isset($arParameters[$key]))
            {
                unset($arParameters[$key]) ;
            }
        }

        $sCheck_MacValue = ECPay_ApplePay_CheckMacValue::generate($arParameters, $HashKey, $HashIV);

        return $sCheck_MacValue ;
    }

        function generate_encrypt_data($sPaymentToken, $HashKey, $HashIV){
            return ECPay_ApplePay_CheckMacValue::encrypt_data($sPaymentToken, $HashKey, $HashIV);
        }

        /**
    * 處理urldecode的參數
    */
        function urldecode_process($arParameters = []){

            foreach($arParameters as $key => $value)
            {
                if(isset($this->urlencode_field[$key]))
                {
                    $arParameters[$key] = ECPay_ApplePay_CheckMacValue::Replace_Symbol_Decode($arParameters[$key]);
                    $arParameters[$key] = urldecode($value);
                }
            }

            return $arParameters ;
        }
}


/**
*  信用卡
*/
class ECPay_ApplePay_Credit extends ECPay_ApplePay_Verification
{
        // 所需參數
        public $parameters = [
        'MerchantID'        =>'',
        'MerchantTradeNo'   =>'',
        'MerchantTradeDate' =>'',
        'TotalAmount'       =>'',
        'CurrencyCode'      =>'',
        'ItemName'      =>'',
        'PlatformID'        =>'',
        'TradeDesc'         =>'',
        'TradeType'             => 2,
        'CheckMacValue'     =>'',
        'PaymentToken'      =>''
            ];

        // 需要做urlencode的參數
        public $urlencode_field = [
            ];

        // 不需要送壓碼的欄位
        public $none_verification = [
            'PaymentToken'      =>'',
            'CheckMacValue'     =>''
            ]; 

        /**
    * 寫入參數
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
    * 驗證參數格式
    */
        function check_extend_string($arParameters = []){
        
            $arErrors = [];

            // *預設不可為空值
            if(strlen($arParameters['MerchantID']) == 0)
            {
                array_push($arErrors, 'MerchantID is required.');
            }

            // *預設不可為空值
            if(strlen($arParameters['MerchantTradeNo']) == 0)
            {
                array_push($arErrors, 'MerchantTradeNo is required.');
            }

            // *預設最大長度為20碼
            if(strlen($arParameters['MerchantTradeNo']) > 20)
            {
                array_push($arErrors, 'MerchantTradeNo max langth as 20.');
            }

            // *合作廠商交易時間
            if(strlen($arParameters['MerchantTradeDate']) > 0)
            {
                if( !preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1]) (0[0-9]|[1][0-9]|2[0-3]):(0[0-9]|[1][0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]):(0[0-9]|[1][0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])$/", $arParameters['MerchantTradeDate']) )
                {

                    array_push($arErrors, 'Invalid MerchantTradeDate.');
                }
            }

            // *交易金額
            if(strlen($arParameters['TotalAmount']) == 0)
            {
                array_push($arErrors, 'TotalAmount is required.');
            }
            else
            {
                if( !preg_match('/^[0-9]*$/', $arParameters['TotalAmount']) )
                {
                    array_push($arErrors, 'Invalid TotalAmount.');
                }
            }

            // *預設TWD
            if( $arParameters['CurrencyCode'] != 'TWD')
            {
                array_push($arErrors, 'Invalid CurrencyCode.');
            }

            // *交易金額
            if(strlen($arParameters['ItemName']) == 0)
            {
                array_push($arErrors, 'ItemName is required.');
            }
            else
            {
                if( mb_strlen($arParameters['ItemName'], 'UTF-8') > 200)
            {
                array_push($arErrors, 'ItemName max length as 200.');
            }
            }

            // 特約合作
            if(strlen($arParameters['PlatformID']) != 0)
            {
                if( $arParameters['PlatformID'] != $arParameters['MerchantID'])
            {
                array_push($arErrors, 'Invalid PlatformID.');
            }
            }
            
            // *交易來源
            if(strlen($arParameters['TradeType']) == 0)
            {
                array_push($arErrors, 'TradeType is required.');
            }
            else
            {
                if( $arParameters['TradeType'] != ECPay_TradeType::APP && $arParameters['TradeType'] != ECPay_TradeType::WEB )
            {
                array_push($arErrors, 'Invalid TradeType.');
            }
            }

            // *付款資料物件
            if(strlen($arParameters['PaymentToken']) == 0)
            {
                array_push($arErrors, 'PaymentToken is required.');
            }

            if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

            return $arParameters ;
        }

        /**
    * 欄位例外處理方式(送壓碼前)
    */
        function check_exception($arParameters = []){

        return $arParameters ;
        }   
}

/**
*  檢查碼 
*  注意:壓碼使用sha256
*/
class ECPay_ApplePay_CheckMacValue
{
    /**
    * 產生檢查碼
    */
    static function generate($arParameters = [], $HashKey = '', $HashIV = ''){

        $sMacValue = '' ;

        if(isset($arParameters)){   
            
            uksort($arParameters, ['ECPay_ApplePay_CheckMacValue','merchantSort']);

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
            $sMacValue = ECPay_ApplePay_CheckMacValue::Replace_Symbol($sMacValue);

            // 編碼
            $sMacValue = hash('sha256', $sMacValue, false);

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
    * 傳入    $sParameters    參數
    * 傳出    $sParameters    回傳取代後變數
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
    * 傳入    $sParameters    參數
    * 傳出    $sParameters    回傳取代後變數
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

    /**
    * 資料傳輸加密
    * @param        string  $sPost_Data     DATA
    * @param        string  $sKey           KEY
    * @param        string  $sIv            IV
    */
    static function encrypt_data($sPost_Data = '', $sKey = '', $sIv = '')
    {
        $encrypted = openssl_encrypt($sPost_Data, 'AES-128-CBC',$sKey, OPENSSL_RAW_DATA, $sIv);

        $encrypted = base64_encode($encrypted);                             //Base64編碼
        $encrypted = urlencode($encrypted);                                 // urlencode

        // 取代為與 dotNet 相符的字元
        $encrypted = str_replace('%2B', '%2b', $encrypted);
        $encrypted = str_replace('%2F', '%2f', $encrypted);
        $encrypted = str_replace('%3D', '%3d', $encrypted);

        return $encrypted;
    }

    /**
    * 資料傳輸解密
    * @param        string  $sPost_Data     DATA
    * @param        string  $sKey           KEY
    * @param        string  $sIv            IV
    */
    static function decrypt_data($sPost_Data = '', $sKey = '', $sIv = '')
    {
        // 取代為與 dotNet 相符的字元
        $sPost_Data = str_replace('%2b', '%2B', $sPost_Data);
        $sPost_Data = str_replace('%2f', '%2F', $sPost_Data);
        $sPost_Data = str_replace('%3d', '%3D', $sPost_Data);

        $sPost_Data = urldecode($sPost_Data);                               // urldecode
        $sPost_Data = base64_decode($sPost_Data);                           //Base64解碼

        $decrypted = openssl_decrypt($sPost_Data, 'AES-128-CBC', $sKey, OPENSSL_RAW_DATA, $sIv);

        return $decrypted ;
    }
}
