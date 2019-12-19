<?php

namespace ECPay\ApplePay;

class CheckMacValue
{
    /**
     * 產生檢查碼
     */
    static function generate($arParameters = [], $HashKey = '', $HashIV = ''){

        $sMacValue = '' ;

        if(isset($arParameters)){

            uksort($arParameters, ['CheckMacValue','merchantSort']);

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
            $sMacValue = CheckMacValue::Replace_Symbol($sMacValue);

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
