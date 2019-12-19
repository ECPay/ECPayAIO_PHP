<?php

/**
 *  M愛心碼驗證
 */
class ECPay_CHECK_LOVE_CODE
{
    // 所需參數
    public $parameters = [
        'TimeStamp' => '',
        'MerchantID' => '',
        'LoveCode' => '',
        'CheckMacValue' => ''
    ];

    // 需要做urlencode的參數
    public $urlencode_field = [
    ];

    // 不需要送壓碼的欄位
    public $none_verification = [
        'CheckMacValue' => ''
    ];

    /**
     * 1寫入參數
     */
    function insert_string($arParameters = [])
    {

        foreach ($this->parameters as $key => $value) {
            if (isset($arParameters[$key])) {
                $this->parameters[$key] = $arParameters[$key];
            }
        }

        return $this->parameters;
    }

    /**
     * 2-2 驗證參數格式
     */
    function check_extend_string($arParameters = [])
    {

        $arErrors = [];

        // 51.LoveCode愛心碼
        // *必填 3-7碼
        if (strlen($arParameters['LoveCode']) > 7) {
            array_push($arErrors, '51:LoveCode max length as 7.');
        }

        if (sizeof($arErrors) > 0) throw new Exception(join('<br>', $arErrors));

        return $arParameters;
    }

    /**
     * 4欄位例外處理方式(送壓碼前)
     */
    function check_exception($arParameters = [])
    {

        return $arParameters;
    }
}