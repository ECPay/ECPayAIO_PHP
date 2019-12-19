<?php

/**
 *  送出資訊
 */
class ECPay_Invoice_Send
{
    // 發票物件
    public static $InvoiceObj;
    public static $InvoiceObj_Return;

    /**
     * 背景送出資料
     */
    static function CheckOut($arParameters = [], $HashKey = '', $HashIV = '', $Invoice_Method = '', $ServiceURL = '')
    {

        // 發送資訊處理
        $arParameters = self::process_send($arParameters, $HashKey, $HashIV, $Invoice_Method, $ServiceURL);

        $szResult = ECPay_IO::ServerPost($arParameters, $ServiceURL);

        // 回傳資訊處理
        $arParameters_Return = self::process_return($szResult, $HashKey, $HashIV, $Invoice_Method);

        return $arParameters_Return;
    }

    // 資料檢查與過濾(送出)
    protected static function process_send($arParameters = [], $HashKey = '', $HashIV = '', $Invoice_Method = '', $ServiceURL = '')
    {

        //宣告物件
        $InvoiceMethod = 'ECPay_' . $Invoice_Method;
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

        return $arParameters;
    }

    /**
     * 資料檢查與過濾(回傳)
     */
    protected static function process_return($sParameters = '', $HashKey = '', $HashIV = '', $Invoice_Method = '')
    {

        //宣告物件
        $InvoiceMethod = 'ECPay_' . $Invoice_Method;
        self::$InvoiceObj_Return = new $InvoiceMethod;

        // 7字串轉陣列
        $arParameters = ECPay_Invoice_Send::string_to_array($sParameters);

        // 8欄位例外處理方式(送壓碼前)
        $arException = self::$InvoiceObj_Return->check_exception($arParameters);

        // 9產生壓碼(壓碼檢查)
        if (isset($arParameters['CheckMacValue'])) {
            $CheckMacValue = ECPay_Invoice_Send::generate_checkmacvalue($arException, self::$InvoiceObj_Return->none_verification, $HashKey, $HashIV);

            if ($CheckMacValue != $arParameters['CheckMacValue']) {
                throw new Exception('注意：壓碼錯誤');
            }
        }

        // 10處理需要urldecode的參數
        $arParameters = ECPay_Invoice_Send::urldecode_process($arParameters, self::$InvoiceObj_Return->urlencode_field);

        return $arParameters;
    }


    /**
     * 2檢查共同參數
     */
    protected static function check_string($MerchantID = '', $HashKey = '', $HashIV = '', $Invoice_Method = 'INVOICE', $ServiceURL = '')
    {

        $arErrors = [];

        // 檢查是否傳入動作方式
        if ($Invoice_Method == '' || $Invoice_Method == 'Invoice_Method') {
            array_push($arErrors, 'Invoice_Method is required.');
        }

        // 檢查是否有傳入MerchantID
        if (strlen($MerchantID) == 0) {
            array_push($arErrors, 'MerchantID is required.');
        }
        if (strlen($MerchantID) > 10) {
            array_push($arErrors, 'MerchantID max langth as 10.');
        }

        // 檢查是否有傳入HashKey
        if (strlen($HashKey) == 0) {
            array_push($arErrors, 'HashKey is required.');
        }

        // 檢查是否有傳入HashIV
        if (strlen($HashIV) == 0) {
            array_push($arErrors, 'HashIV is required.');
        }

        // 檢查是否有傳送網址
        if (strlen($ServiceURL) == 0) {
            array_push($arErrors, 'Invoice_Url is required.');
        }

        if (sizeof($arErrors) > 0) throw new Exception(join('<br>', $arErrors));
    }

    /**
     * 4處理需要轉換為urlencode的參數
     */
    protected static function urlencode_process($arParameters = [], $urlencode_field = [])
    {

        foreach ($arParameters as $key => $value) {
            if (isset($urlencode_field[$key])) {
                $arParameters[$key] = urlencode($value);
                $arParameters[$key] = ECPay_Invoice_CheckMacValue::Replace_Symbol($arParameters[$key]);
            }
        }

        return $arParameters;
    }

    /**
     * 6,9產生壓碼
     */
    protected static function generate_checkmacvalue($arParameters = [], $none_verification = [], $HashKey = '', $HashIV = '')
    {

        $sCheck_MacValue = '';

        // 過濾不需要壓碼的參數
        foreach ($none_verification as $key => $value) {
            if (isset($arParameters[$key])) {
                unset($arParameters[$key]);
            }
        }

        $sCheck_MacValue = ECPay_Invoice_CheckMacValue::generate($arParameters, $HashKey, $HashIV, ECPay_EncryptType::ENC_MD5);

        return $sCheck_MacValue;
    }

    /**
     * 7 字串轉陣列
     */
    protected static function string_to_array($Parameters = '')
    {

        $aParameters = [];
        $aParameters_Tmp = [];

        $aParameters_Tmp = explode('&', $Parameters);

        foreach ($aParameters_Tmp as $part) {
            list($paramName, $paramValue) = explode('=', $part, 2);
            $aParameters[$paramName] = $paramValue;
        }

        return $aParameters;
    }

    /**
     * 10處理urldecode的參數
     */
    protected static function urldecode_process($arParameters = [], $urlencode_field = [])
    {

        foreach ($arParameters as $key => $value) {
            if (isset($urlencode_field[$key])) {
                $arParameters[$key] = ECPay_Invoice_CheckMacValue::Replace_Symbol_Decode($arParameters[$key]);
                $arParameters[$key] = urldecode($value);
            }
        }

        return $arParameters;
    }
}