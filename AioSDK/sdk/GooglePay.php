<?php

namespace ECPay;

class GooglePay extends Verification
{
    public $arPayMentExtend = [];

    function filter_string($arExtend = [], $InvoiceMark = ''){
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend ;
    }
}