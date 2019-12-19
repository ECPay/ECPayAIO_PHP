<?php

/**
 *  檢查碼
 */
class ECPay_Invoice_CheckMacValue
{
    /**
     * 產生檢查碼
     */
    static function generate($arParameters = [], $HashKey = '', $HashIV = '', $encType = 0)
    {

        $sMacValue = '';

        if (isset($arParameters)) {

            unset($arParameters['CheckMacValue']);
            uksort($arParameters, ['ECPay_Invoice_CheckMacValue', 'merchantSort']);

            // 組合字串
            $sMacValue = 'HashKey=' . $HashKey;
            foreach ($arParameters as $key => $value) {
                $sMacValue .= '&' . $key . '=' . $value;
            }

            $sMacValue .= '&HashIV=' . $HashIV;

            // URL Encode編碼     
            $sMacValue = urlencode($sMacValue);

            // 轉成小寫
            $sMacValue = strtolower($sMacValue);

            // 取代為與 dotNet 相符的字元
            $sMacValue = ECPay_Invoice_CheckMacValue::Replace_Symbol($sMacValue);

            // 編碼
            switch ($encType) {
                case ECPay_EncryptType::ENC_SHA256:
                    $sMacValue = hash('sha256', $sMacValue);    // SHA256 編碼
                    break;

                case ECPay_EncryptType::ENC_MD5:
                default:

                    $sMacValue = md5($sMacValue);    // MD5 編碼
            }

            $sMacValue = strtoupper($sMacValue);
        }

        return $sMacValue;
    }

    /**
     * 自訂排序使用
     */
    private static function merchantSort($a, $b)
    {
        return strcasecmp($a, $b);
    }

    /**
     * 參數內特殊字元取代
     * 傳入    $sParameters    參數
     * 傳出    $sParameters    回傳取代後變數
     */
    static function Replace_Symbol($sParameters)
    {
        if (!empty($sParameters)) {

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

        return $sParameters;
    }

    /**
     * 參數內特殊字元還原
     * 傳入    $sParameters    參數
     * 傳出    $sParameters    回傳取代後變數
     */
    static function Replace_Symbol_Decode($sParameters)
    {
        if (!empty($sParameters)) {

            $sParameters = str_replace('-', '%2d', $sParameters);
            $sParameters = str_replace('_', '%5f', $sParameters);
            $sParameters = str_replace('.', '%2e', $sParameters);
            $sParameters = str_replace('!', '%21', $sParameters);
            $sParameters = str_replace('*', '%2a', $sParameters);
            $sParameters = str_replace('(', '%28', $sParameters);
            $sParameters = str_replace(')', '%29', $sParameters);
            $sParameters = str_replace('+', '%20', $sParameters);
        }

        return $sParameters;
    }
}