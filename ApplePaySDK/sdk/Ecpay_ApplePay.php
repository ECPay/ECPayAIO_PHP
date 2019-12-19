<?php

class Ecpay_ApplePay
{
    /**
     * 版本
     */
    const VERSION = '1.1.190626';

    public $MerchantID  = '';
    public $HashKey     = '';
    public $HashIV      = '';
    public $ServiceURL  = 'ServiceURL';     // 執行網址

    public $Send        = '';
    public $Query       = '';
    public $Action      = '';
    public $Trade       = '';
    public $Funding     = '';
    public $Applepay_Button = '';
    public $Verify_Vendor   = '';

    function __construct(){

        $this->Send = [
            'MerchantTradeNo'       => '',
            'MerchantTradeDate'     => date('Y/m/d H:i:s'),
            'TotalAmount'           => 0,
            'CurrencyCode'          => 'TWD',
            'ItemName'          => '',
            'PlatformID'            => '',
            'TradeDesc'             => '',
            'TradeType'             => 2,
            'CheckMacValue'         => '',
            'PaymentToken'      => ''
        ];

        // 訂單查詢
        $this->Query = [
            'MerchantTradeNo'   => '',
            'TimeStamp'         => ''
        ];

        // 信用卡關帳/退刷/取消/放棄的方法
        $this->Action = [
            'MerchantTradeNo'   => '',
            'TradeNo'       => '',
            'Action'        => ECPay_ApplePay_ActionType::C,
            'TotalAmount'       => 0
        ];

        // 訂單查詢作業
        $this->Trade = [
            'CreditRefundId'    => '',
            'CreditAmount'      => '',
            'CreditCheckCode'   => ''
        ];

        // 下載信用卡撥款對帳資料檔
        $this->Funding = [
            'PayDateType'       => '',
            'StartDate'         => '',
            'EndDate'       => ''
        ];

        // applepay button
        $this->Applepay_Button = [
            'merchantIdentifier'    => '',
            'lable'         => '',
            'amount'        => '',
            'step1_url'     => '',
            'step2_url'     => '',
            'debug_mode'        => 'yes',
            'server_https'      => $_SERVER['HTTPS'],
            'success_site_url'  => '',
            'order_id'      => ''
        ];

        // 廠商憑證驗證
        $this->Verify_Vendor = [
            'displayName'       => '',
            'crt_path'      => '',
            'key_path'      => '',
            'key_password'      => ''
        ];
    }

    // 產生訂單
    public function Check_Out() {
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID] ,$this->Send);
        return $arFeedback = ECPay_ApplePay_Send::CheckOut($arParameters, $this->HashKey, $this->HashIV, ECPay_ApplePay_PaymentMethod::Credit, $this->ServiceURL);
    }

    /**
     * 產生訂單 APP串接用
     * 傳入    $arPostData             檢查參數
     * 傳出    $sReturn_Msg | true     錯誤回傳 json格式 | 判斷正常
     */
    public function CheckOut_App($arPostData){

        //整理參數
        $this->Send['MerchantTradeNo']      = isset($arPostData['MerchantTradeNo'])     ? $arPostData['MerchantTradeNo']    : '';
        $this->Send['MerchantTradeDate']    = isset($arPostData['MerchantTradeDate'])   ? $arPostData['MerchantTradeDate']  : '';
        $this->Send['TotalAmount']          = isset($arPostData['TotalAmount'])     ? $arPostData['TotalAmount']        : '';
        $this->Send['CurrencyCode']         = isset($arPostData['CurrencyCode'])    ? $arPostData['CurrencyCode']       : '';
        $this->Send['ItemName']             = isset($arPostData['ItemName'])        ? $arPostData['ItemName']       : '';
        $this->Send['PlatformID']           = isset($arPostData['PlatformID'])      ? $arPostData['PlatformID']         : '';
        $this->Send['TradeDesc']            = isset($arPostData['TradeDesc'])       ? $arPostData['TradeDesc']      : '';
        $this->Send['PaymentToken']         = isset($arPostData['PaymentToken'])    ? $arPostData['PaymentToken']       : '';
        $this->Send['TradeType']            = 1;

        $arParameters = array_merge( ['MerchantID' => $this->MerchantID] ,$this->Send);
        $arFeedback = ECPay_ApplePay_Send::CheckOut($arParameters, $this->HashKey, $this->HashIV, ECPay_ApplePay_PaymentMethod::Credit, $this->ServiceURL);

        return json_encode($arFeedback) ;
    }

    //訂單查詢作業
    public function QueryTradeInfo() {
        return $arFeedback = ECPay_ApplePay_QueryTradeInfo::CheckOut(array_merge($this->Query, ['MerchantID' => $this->MerchantID]), $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    //信用卡關帳/退刷/取消/放棄的方法
    public function DoAction() {
        return $arFeedback = ECPay_ApplePay_DoAction::CheckOut(array_merge($this->Action, ['MerchantID' => $this->MerchantID]), $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    //查詢信用卡單筆明細紀錄
    public function QueryTrade(){
        return $arFeedback = ECPay_ApplePay_QueryTrade::CheckOut(array_merge($this->Trade, ['MerchantID' => $this->MerchantID]), $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    //下載信用卡撥款對帳資料檔
    public function FundingReconDetail($target = '_self'){
        $arParameters = array_merge( ['MerchantID' => $this->MerchantID] ,$this->Funding);
        ECPay_ApplePay_FundingReconDetail::CheckOut($target, $arParameters, $this->HashKey, $this->HashIV, $this->ServiceURL);
    }

    // 產生applepay 按鈕
    public function applepay_button(){
        ECPay_Apple_Button::generate($this->Applepay_Button);
    }

    // 驗證憑證
    public function Verify_Vendor(){
        return $arFeedback = ECPay_Verify_Vendor::verify_vendor($this->Verify_Vendor, $this->ServiceURL);
    }


    // 測試驗證憑證
    public function Verify_Vendor_Test(){
        return $arFeedback = ECPay_Verify_Vendor::verify_vendor($this->Verify_Vendor, $this->ServiceURL, true);
    }
}
