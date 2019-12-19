<?php

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
