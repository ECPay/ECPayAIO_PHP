<?php

class EcpayCheckMacValue
{
    /**
     * 產生檢查碼
     */
    public static function Generate($Params = [], $HashKey = '', $HashIV = '')
    {
        if (isset($Params) ){
            unset($Params['CheckMacValue']);
            uksort($Params, ['EcpayCheckMacValue','MerchantSort']);

            // 組合字串
            $MacValue = 'HashKey=' . $HashKey ;
            foreach($Params as $key => $Value) {
                $MacValue .= '&' . $key . '=' . $Value ;
            }
            $MacValue .= '&HashIV=' . $HashIV ;

            // URL Encode編碼
            $MacValue = urlencode($MacValue);

            // 轉成小寫
            $MacValue = strtolower($MacValue);

            // 取代為與 dotNet 相符的字元
            $MacValue = self::ReplaceSymbol($MacValue);

            // 編碼
            $MacValue = md5($MacValue);

            $MacValue = strtoupper($MacValue);
        }

        return $MacValue ;
    }

    /**
     * 自訂排序使用
     * @param     string   $Current    目前資料
     * @param     string   $Next       下一筆資料
     */
    private static function MerchantSort($Current, $Next)
    {
        return strcasecmp($Current, $Next);
    }

    /**
     * 參數內特殊字元取代
     * 傳入	$sParameters	參數
     * 傳出	$sParameters	回傳取代後變數
     */
    public static function ReplaceSymbol($sParameters){
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
    public static function ReplaceSymbolDecode($sParameters){
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
