<?php

class ECPay_WebATM extends ECPay_Verification
{
    public  $arPayMentExtend = [];

    //過濾多餘參數
    function filter_string($arExtend = [],$InvoiceMark = ''){
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend ;
    }
}
