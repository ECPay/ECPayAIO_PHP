<?php

class ECPay_CVS extends ECPay_Verification
{
    public  $arPayMentExtend = [
        'Desc_1'           =>'',
        'Desc_2'           =>'',
        'Desc_3'           =>'',
        'Desc_4'           =>'',
        'PaymentInfoURL'   =>'',
        'ClientRedirectURL'=>'',
        'StoreExpireDate'  =>''
    ];

    // 過濾多餘參數
    function filter_string($arExtend = [],$InvoiceMark = ''){
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend ;
    }
}
