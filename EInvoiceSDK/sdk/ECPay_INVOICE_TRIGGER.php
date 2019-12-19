<?php

/**
 *  K付款完成觸發或延遲開立發票
 */
class ECPay_INVOICE_TRIGGER
{
    // 所需參數
    public $parameters = [
        'TimeStamp' => '',
        'MerchantID' => '',
        'CheckMacValue' => '',
        'Tsr' => '',
        'PayType' => 2
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

        // 33.交易單號 Tsr
        // *必填項目
        if (strlen($arParameters['Tsr']) == 0) {
            array_push($arErrors, '33:Tsr is required.');
        }

        // *判斷最大字元是否超過30字
        if (strlen($arParameters['Tsr']) > 30) {
            array_push($arErrors, '33:Tsr max length as 30.');
        }

        // 34.交易類別 PayType
        // *2016-10-4 修改為僅允許 2
        if ($arParameters['PayType'] != EcpayPayTypeCategory::Ecpay) {
            array_push($arErrors, '34:Invalid PayType.');
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