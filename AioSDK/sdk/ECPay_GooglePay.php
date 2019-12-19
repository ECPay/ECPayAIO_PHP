<?php

class ECPay_GooglePay extends ECPay_Verification
{
    public $arPayMentExtend = [];

    function filter_string($arExtend = [], $InvoiceMark = ''){
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend ;
    }
}