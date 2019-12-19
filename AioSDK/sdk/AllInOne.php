<?php

namespace ECPay;

class AllInOne {

    /**
     * @ SDK版本
     */
    const VERSION = '1.1.1910310';

    public $ServiceURL = 'ServiceURL';
    public $ServiceMethod = 'ServiceMethod';
    public $HashKey = 'HashKey';
    public $HashIV = 'HashIV';
    public $MerchantID = 'MerchantID';
    public $PaymentType = 'PaymentType';
    public $Send = 'Send';
    public $SendExtend = 'SendExtend';
    public $Query = 'Query';
    public $Action = 'Action';
    public $EncryptType = EncryptType::ENC_MD5;

    function __construct() {

        $this->PaymentType = 'aio';
        $this->Send = [
            'ReturnURL'         => '',
            'ClientBackURL'     => '',
            'OrderResultURL'    => '',
            'MerchantTradeNo'   => '',
            'MerchantTradeDate' => '',
            'PaymentType'       => 'aio',
            'TotalAmount'       => '',
            'TradeDesc'         => '',
            'ChoosePayment'     => PaymentMethod::ALL,
            'Remark'            => '',
            'ChooseSubPayment'  => PaymentMethodItem::None,
            'NeedExtraPaidInfo' => ExtraPaymentInfo::No,
            'DeviceSource'      => '',
            'IgnorePayment'     => '',
            'PlatformID'        => '',
            'InvoiceMark'       => InvoiceState::No,
            'Items'             => [],
            'StoreID'           => '',
            'CustomField1'      => '',
            'CustomField2'      => '',
            'CustomField3'      => '',
            'CustomField4'      => '',
            'HoldTradeAMT'      => 0
        ];

        $this->SendExtend = [];

        $this->Query = [
            'MerchantTradeNo' => '',
            'TimeStamp' => ''
        ];
        $this->Action = [
            'MerchantTradeNo' => '',
            'TradeNo' => '',
            'Action' => ActionType::C,
            'TotalAmount' => 0
        ];
        $this->Capture = [
            'MerchantTradeNo' => '',
            'CaptureAMT' => 0,
            'UserRefundAMT' => 0,
            'PlatformID' => ''
        ];

        $this->TradeNo = [
            'DateType' => '',
            'BeginDate' => '',
            'EndDate' => '',
            'MediaFormated' => ''
        ];

        $this->Trade = [
            'CreditRefundId' => '',
            'CreditAmount' => '',
            'CreditCheckCode' => ''
        ];

        $this->Funding = [
            'PayDateType' => '',
            'StartDate' => '',
            'EndDate' => ''
        ];

    }

    //產生訂單
    function CheckOut($target = '_self') {
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType] ,$this->Send);
        Send::CheckOut($target,$arParameters,$this->SendExtend,$this->HashKey,$this->HashIV,$this->ServiceURL);
    }

    //產生訂單html code
    function CheckOutString($paymentButton = 'Submit', $target = '_self') {
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType] ,$this->Send);
        return Send::CheckOutString($paymentButton,$target = '_self',$arParameters,$this->SendExtend,$this->HashKey,$this->HashIV,$this->ServiceURL);
    }

    //取得付款結果通知的方法
    function CheckOutFeedback() {
        return $arFeedback = CheckOutFeedback::CheckOut(array_merge($_POST, ['EncryptType' => $this->EncryptType]),$this->HashKey,$this->HashIV,0);
    }

    //訂單查詢作業
    function QueryTradeInfo() {
        return $arFeedback = QueryTradeInfo::CheckOut(array_merge($this->Query,['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType]) ,$this->HashKey ,$this->HashIV ,$this->ServiceURL) ;
    }

    //信用卡定期定額訂單查詢的方法
    function QueryPeriodCreditCardTradeInfo() {
        return $arFeedback = QueryPeriodCreditCardTradeInfo::CheckOut(array_merge($this->Query,['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType]) ,$this->HashKey ,$this->HashIV ,$this->ServiceURL);
    }

    //信用卡關帳/退刷/取消/放棄的方法
    function DoAction() {
        return $arFeedback = DoAction::CheckOut(array_merge($this->Action,['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType]) ,$this->HashKey ,$this->HashIV ,$this->ServiceURL);
    }

    //合作特店申請撥款
    function AioCapture(){
        return $arFeedback = AioCapture::Capture(array_merge($this->Capture,['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType]) ,$this->HashKey ,$this->HashIV ,$this->ServiceURL);
    }

    //下載會員對帳媒體檔
    function TradeNoAio($target = '_self'){
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType] ,$this->TradeNo);
        TradeNoAio::CheckOut($target,$arParameters,$this->HashKey,$this->HashIV,$this->ServiceURL);
    }

    //查詢信用卡單筆明細紀錄
    function QueryTrade(){
        return $arFeedback = QueryTrade::CheckOut(array_merge($this->Trade,['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType]) ,$this->HashKey ,$this->HashIV ,$this->ServiceURL);
    }

    //下載信用卡撥款對帳資料檔
    function FundingReconDetail($target = '_self'){
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType] ,$this->Funding);
        FundingReconDetail::CheckOut($target,$arParameters,$this->HashKey,$this->HashIV,$this->ServiceURL);
    }

    // 產生訂單(站內付) v1.0.11128 wesley
    function CreateTrade() {
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID, 'EncryptType' => $this->EncryptType] ,$this->Send);
        return $arFeedback = CreateTrade::CheckOut($arParameters,$this->SendExtend,$this->HashKey,$this->HashIV,$this->ServiceURL);
    }
}
