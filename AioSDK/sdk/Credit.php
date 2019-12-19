<?php

namespace ECPay;

class Credit extends Verification
{
    public $arPayMentExtend = [
        'CreditInstallment' => '',
        'InstallmentAmount' => 0,
        'Redeem'            => FALSE,
        'UnionPay'          => FALSE,
        'Language'          => '',
        'BindingCard'       => '',
        'MerchantMemberID'  => '',
        'PeriodAmount'      => '',
        'PeriodType'        => '',
        'Frequency'         => '',
        'ExecTimes'         => '',
        'PeriodReturnURL'   => ''
    ];

    function filter_string($arExtend = [],$InvoiceMark = ''){
        $arExtend = parent::filter_string($arExtend, $InvoiceMark);
        return $arExtend ;
    }
}
