<?php

namespace ECPay\Invoice;

use Exception;

/**
 *  G查詢作廢發票
 */
class VoidSearch
{
    // 所需參數
    public $parameters = [
        'TimeStamp' => '',
        'MerchantID' => '',
        'RelateNumber' => '',
        'CheckMacValue' => ''
    ];

    // 需要做urlencode的參數
    public $urlencode_field = [
        'Reason' => ''
    ];

    // 不需要送壓碼的欄位
    public $none_verification = [
        'Reason' => '',
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

        // 4.廠商自訂編號

        // *預設不可為空值
        if (strlen($arParameters['RelateNumber']) == 0) {
            array_push($arErrors, '4:RelateNumber is required.');
        }
        // *預設最大長度為30碼
        if (strlen($arParameters['RelateNumber']) > 30) {
            array_push($arErrors, '4:RelateNumber max langth as 30.');
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