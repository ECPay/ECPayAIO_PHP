<?php

namespace ECPay\ApplePay;

use Exception;

class Credit extends Verification
{
    // 所需參數
    public $parameters = [
        'MerchantID'        =>'',
        'MerchantTradeNo'   =>'',
        'MerchantTradeDate' =>'',
        'TotalAmount'       =>'',
        'CurrencyCode'      =>'',
        'ItemName'      =>'',
        'PlatformID'        =>'',
        'TradeDesc'         =>'',
        'TradeType'             => 2,
        'CheckMacValue'     =>'',
        'PaymentToken'      =>''
    ];

    // 需要做urlencode的參數
    public $urlencode_field = [
    ];

    // 不需要送壓碼的欄位
    public $none_verification = [
        'PaymentToken'      =>'',
        'CheckMacValue'     =>''
    ];

    /**
     * 寫入參數
     */
    function insert_string($arParameters = []){

        foreach ($this->parameters as $key => $value)
        {
            if(isset($arParameters[$key]))
            {
                $this->parameters[$key] = $arParameters[$key];
            }
        }

        return $this->parameters ;
    }

    /**
     * 驗證參數格式
     */
    function check_extend_string($arParameters = []){

        $arErrors = [];

        // *預設不可為空值
        if(strlen($arParameters['MerchantID']) == 0)
        {
            array_push($arErrors, 'MerchantID is required.');
        }

        // *預設不可為空值
        if(strlen($arParameters['MerchantTradeNo']) == 0)
        {
            array_push($arErrors, 'MerchantTradeNo is required.');
        }

        // *預設最大長度為20碼
        if(strlen($arParameters['MerchantTradeNo']) > 20)
        {
            array_push($arErrors, 'MerchantTradeNo max langth as 20.');
        }

        // *合作廠商交易時間
        if(strlen($arParameters['MerchantTradeDate']) > 0)
        {
            if( !preg_match("/^[0-9]{4}\/(0[1-9]|1[0-2])\/(0[1-9]|[1-2][0-9]|3[0-1]) (0[0-9]|[1][0-9]|2[0-3]):(0[0-9]|[1][0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]):(0[0-9]|[1][0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])$/", $arParameters['MerchantTradeDate']) )
            {

                array_push($arErrors, 'Invalid MerchantTradeDate.');
            }
        }

        // *交易金額
        if(strlen($arParameters['TotalAmount']) == 0)
        {
            array_push($arErrors, 'TotalAmount is required.');
        }
        else
        {
            if( !preg_match('/^[0-9]*$/', $arParameters['TotalAmount']) )
            {
                array_push($arErrors, 'Invalid TotalAmount.');
            }
        }

        // *預設TWD
        if( $arParameters['CurrencyCode'] != 'TWD')
        {
            array_push($arErrors, 'Invalid CurrencyCode.');
        }

        // *交易金額
        if(strlen($arParameters['ItemName']) == 0)
        {
            array_push($arErrors, 'ItemName is required.');
        }
        else
        {
            if( mb_strlen($arParameters['ItemName'], 'UTF-8') > 200)
            {
                array_push($arErrors, 'ItemName max length as 200.');
            }
        }

        // 特約合作
        if(strlen($arParameters['PlatformID']) != 0)
        {
            if( $arParameters['PlatformID'] != $arParameters['MerchantID'])
            {
                array_push($arErrors, 'Invalid PlatformID.');
            }
        }

        // *交易來源
        if(strlen($arParameters['TradeType']) == 0)
        {
            array_push($arErrors, 'TradeType is required.');
        }
        else
        {
            if( $arParameters['TradeType'] != TradeType::APP && $arParameters['TradeType'] != TradeType::WEB )
            {
                array_push($arErrors, 'Invalid TradeType.');
            }
        }

        // *付款資料物件
        if(strlen($arParameters['PaymentToken']) == 0)
        {
            array_push($arErrors, 'PaymentToken is required.');
        }

        if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        return $arParameters ;
    }

    /**
     * 欄位例外處理方式(送壓碼前)
     */
    function check_exception($arParameters = []){

        return $arParameters ;
    }
}
