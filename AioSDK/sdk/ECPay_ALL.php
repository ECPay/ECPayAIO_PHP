<?php

class ECPay_ALL extends ECPay_Verification
{
    public  $arPayMentExtend = [];

    function filter_string($arExtend = [],$InvoiceMark = ''){
        return $arExtend ;
    }
}
