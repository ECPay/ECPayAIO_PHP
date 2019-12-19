<?php

class ECPay_CheckMacValue{

    public static function generate($arParameters = [],$HashKey = '' ,$HashIV = '',$encType = 0){
        $sMacValue = '' ;

        if(isset($arParameters))
        {
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, ['ECPay_CheckMacValue','merchantSort']);

            // 組合字串
            $sMacValue = 'HashKey=' . $HashKey ;
            foreach($arParameters as $key => $value)
            {
                $sMacValue .= '&' . $key . '=' . $value ;
            }

            $sMacValue .= '&HashIV=' . $HashIV ;

            // URL Encode編碼
            $sMacValue = static::ecpay_urlencode($sMacValue);

            // 編碼
            switch ($encType) {
                case ECPay_EncryptType::ENC_SHA256:
                    // SHA256 編碼
                    $sMacValue = hash('sha256', $sMacValue);
                    break;

                case ECPay_EncryptType::ENC_MD5:
                default:
                    // MD5 編碼
                    $sMacValue = md5($sMacValue);
            }

            $sMacValue = strtoupper($sMacValue);
        }

        return $sMacValue ;
    }

    /**
     * 自訂排序使用
     */
    private static function merchantSort($a,$b)
    {
        return strcasecmp($a, $b);
    }

    /**
     * URL Encode編碼，特殊字元取代
     *
     * @param  string $sParameters
     * @return string $sParameters
     */
    public static function ecpay_urlencode($sParameters) {

        // URL Encode編碼
        $sParameters = urlencode($sParameters);

        // 轉成小寫
        $sParameters = strtolower($sParameters);

        // 參數內特殊字元取代
        $sParameters = static::Replace_Symbol($sParameters);

        return $sParameters;
    }

    /**
     * 參數內特殊字元取代
     * 傳入    $sParameters    參數
     * 傳出    $sParameters    回傳取代後變數
     */
    public static function Replace_Symbol($sParameters){
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

}
