<?php


abstract class ECPay_ApplePay_Verification
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
