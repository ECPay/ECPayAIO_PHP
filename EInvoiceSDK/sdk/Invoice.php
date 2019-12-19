<?php

namespace ECPay\Invoice;

class Invoice
{
    /**
     * 版本
     */
    const VERSION = '1.0.190805';

    public $TimeStamp = '';
    public $MerchantID = '';
    public $HashKey = '';
    public $HashIV = '';
    public $Send = 'Send';
    public $Invoice_Method = 'INVOICE';        // 電子發票執行項目
    public $Invoice_Url = 'Invoice_Url';    // 電子發票執行網址

    function __construct()
    {

        $this->Send = [
            'RelateNumber' => '',
            'CustomerID' => '',
            'CustomerIdentifier' => '',
            'CustomerName' => '',
            'CustomerAddr' => '',
            'CustomerPhone' => '',
            'CustomerEmail' => '',
            'ClearanceMark' => '',
            'Print' => PrintMark::No,
            'Donation' => Donation::No,
            'LoveCode' => '',
            'CarruerType' => CarruerType::None,
            'CarruerNum' => '',
            'TaxType' => '',
            'SalesAmount' => '',
            'InvoiceRemark' => '',
            'Items' => [],
            'InvType' => '',
            'vat' => VatType::Yes,
            'DelayFlag' => '',
            'DelayDay' => 0,
            'Tsr' => '',
            'PayType' => '',
            'PayAct' => '',
            'NotifyURL' => '',
            'InvoiceNo' => '',
            'AllowanceNotify' => '',
            'NotifyMail' => '',
            'NotifyPhone' => '',
            'AllowanceAmount' => '',
            'InvoiceNumber' => '',
            'Reason' => '',
            'AllowanceNo' => '',
            'Phone' => '',
            'Notify' => '',
            'InvoiceTag' => '',
            'Notified' => '',
            'BarCode' => '',
            'OnLine' => true
        ];

        $this->TimeStamp = time();
    }

    function Check_Out()
    {
        $arParameters = array_merge(['MerchantID' => $this->MerchantID], ['TimeStamp' => $this->TimeStamp], $this->Send);
        return Send::CheckOut($arParameters, $this->HashKey, $this->HashIV, $this->Invoice_Method, $this->Invoice_Url);
    }
}