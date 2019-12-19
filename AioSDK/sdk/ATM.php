<?php

namespace ECPay;

class ATM extends Verification
{
    public  $arPayMentExtend = [
        'ExpireDate'       => 3,
        'PaymentInfoURL'   => '',
        'ClientRedirectURL'=> '',
    ];

    //過濾多餘參數
    function filter_string($arExtend = [],$InvoiceMark = ''){
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend ;
    }
}
