<?php

namespace ECPay;

use Exception;

abstract class Verification
{
    // 電子發票延伸參數。
    public $arInvoice = [
        'RelateNumber',
        'CustomerIdentifier',
        'CarruerType' ,
        'CustomerID' ,
        'Donation' ,
        'Print' ,
        'TaxType',
        'CustomerName' ,
        'CustomerAddr' ,
        'CustomerPhone' ,
        'CustomerEmail' ,
        'ClearanceMark' ,
        'CarruerNum' ,
        'LoveCode' ,
        'InvoiceRemark' ,
        'DelayDay',
        'InvoiceItemName',
        'InvoiceItemCount',
        'InvoiceItemWord',
        'InvoiceItemPrice',
        'InvoiceItemTaxType',
        'InvType'
    ];

    // 付款方式延伸參數
    public $arPayMentExtend = [];

    //檢查共同參數
    public function check_string($arParameters = []){

        $arErrors = [];
        if (strlen($arParameters['MerchantID']) == 0) {
            array_push($arErrors, 'MerchantID is required.');
        }
        if (strlen($arParameters['MerchantID']) > 10) {
            array_push($arErrors, 'MerchantID max langth as 10.');
        }

        if (strlen($arParameters['ReturnURL']) == 0) {
            array_push($arErrors, 'ReturnURL is required.');
        }
        if (strlen($arParameters['ClientBackURL']) > 200) {
            array_push($arErrors, 'ClientBackURL max langth as 200.');
        }
        if (strlen($arParameters['OrderResultURL']) > 200) {
            array_push($arErrors, 'OrderResultURL max langth as 200.');
        }

        if (strlen($arParameters['MerchantTradeNo']) == 0) {
            array_push($arErrors, 'MerchantTradeNo is required.');
        }
        if (strlen($arParameters['MerchantTradeNo']) > 20) {
            array_push($arErrors, 'MerchantTradeNo max langth as 20.');
        }
        if (strlen($arParameters['MerchantTradeDate']) == 0) {
            array_push($arErrors, 'MerchantTradeDate is required.');
        }
        if (strlen($arParameters['TotalAmount']) == 0) {
            array_push($arErrors, 'TotalAmount is required.');
        }
        if (strlen($arParameters['TradeDesc']) == 0) {
            array_push($arErrors, 'TradeDesc is required.');
        }
        if (strlen($arParameters['TradeDesc']) > 200) {
            array_push($arErrors, 'TradeDesc max langth as 200.');
        }
        if (strlen($arParameters['ChoosePayment']) == 0) {
            array_push($arErrors, 'ChoosePayment is required.');
        }
        if (strlen($arParameters['NeedExtraPaidInfo']) == 0) {
            array_push($arErrors, 'NeedExtraPaidInfo is required.');
        }
        if (sizeof($arParameters['Items']) == 0) {
            array_push($arErrors, 'Items is required.');
        }

        // 檢查CheckMacValue加密方式
        if (strlen($arParameters['EncryptType']) > 1) {
            array_push($arErrors, 'EncryptType max langth as 1.');
        }

        if (sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        if (!$arParameters['PlatformID']) {
            unset($arParameters['PlatformID']);
        }

        // 檢查是否支援 IgnorePayment 參數，不支援則移除此參數
        if ($this->support_ignore_payment($arParameters) === false) {
            unset($arParameters['IgnorePayment']);
        }

        return $arParameters ;
    }

    //檢查延伸參數
    public function check_extend_string($arExtend = [],$InvoiceMark = ''){
        //沒設定參數的話，就給預設參數
        foreach ($this->arPayMentExtend as $key => $value) {
            if(!isset($arExtend[$key])) $arExtend[$key] = $value;
        }

        //若有開發票，檢查一下發票參數
        if ($InvoiceMark == 'Y') $arExtend = $this->check_invoiceString($arExtend);

        return $arExtend ;
    }

    //檢查商品
    public function check_goods($arParameters = []){
        // 檢查產品名稱。
        $szItemName = '';
        $arErrors   = [];
        if (sizeof($arParameters['Items']) > 0) {
            foreach ($arParameters['Items'] as $keys => $value) {
                $szItemName .= vsprintf('#%s %d %s x %u', $arParameters['Items'][$keys]);
                if (!array_key_exists('ItemURL', $arParameters)) {
                    if(array_key_exists('URL', $arParameters['Items'][$keys])) {
                        $arParameters['ItemURL'] = $arParameters['Items'][$keys]['URL'];
                    }
                }
            }

            if (strlen($szItemName) > 0) {
                $szItemName = mb_substr($szItemName, 1, 200);
                $arParameters['ItemName'] = $szItemName ;
            }
        } else {
            array_push($arErrors, 'Goods information not found.');
        }

        if(sizeof($arErrors)>0) throw new Exception(join('<br>', $arErrors));

        unset($arParameters['Items']);
        return $arParameters ;
    }

    //過濾多餘參數
    public function filter_string($arExtend = [],$InvoiceMark = ''){
        $arPayMentExtend = array_merge(array_keys($this->arPayMentExtend), ($InvoiceMark == '') ? [] : $this->arInvoice);
        foreach ($arExtend as $key => $value) {
            if (!in_array($key,$arPayMentExtend )) {
                unset($arExtend[$key]);
            }
        }

        return $arExtend ;
    }

    //檢查電子發票參數
    public function check_invoiceString($arExtend = []){
        $arErrors = [];

        // 廠商自訂編號RelateNumber(不可為空)
        if(!array_key_exists('RelateNumber', $arExtend)){
            array_push($arErrors, 'RelateNumber is required.');
        }else{
            if (strlen($arExtend['RelateNumber']) > 30) {
                array_push($arErrors, 'RelateNumber max length as 30.');
            }
        }

        // 統一編號CustomerIdentifier(預設為空字串)
        if(!array_key_exists('CustomerIdentifier', $arExtend)){
            $arExtend['CustomerIdentifier'] = '';
        }else{

            if( strlen( $arExtend['CustomerIdentifier'] ) > 0  )
            {
                if( !preg_match('/^[0-9]{8}$/', $arExtend['CustomerIdentifier']) )
                {
                    array_push($arErrors, '6:CustomerIdentifier length should be 8.');
                }
            }
        }

        // 載具類別CarruerType(預設為None)
        if(!array_key_exists('CarruerType', $arExtend)){
            $arExtend['CarruerType'] = CarruerType::None ;
        }else{
            //有設定統一編號的話，載具類別不可為合作特店載具或自然人憑證載具。
            $notPrint = [CarruerType::Member, CarruerType::Citizen];
            if(strlen($arExtend['CustomerIdentifier']) > 0 && in_array($arExtend['CarruerType'], $notPrint)){
                array_push($arErrors, 'CarruerType should NOT be Member or Citizen.');
            }
        }

        // 客戶代號CustomerID(預設為空字串)
        if(!array_key_exists('CustomerID', $arExtend)) {
            $arExtend['CustomerID'] = '';
        }
        // 捐贈註記 Donation(預設為No)
        if(!array_key_exists('Donation', $arExtend)){
            $arExtend['Donation'] = Donation::No ;
        }else{
            //若有帶統一編號，不可捐贈
            if(strlen($arExtend['CustomerIdentifier']) > 0 && $arExtend['Donation'] != Donation::No){
                array_push($arErrors, 'Donation should be No.');
            }
        }

        // 列印註記Print(預設為No)
        if(!array_key_exists('Print', $arExtend)){
            $arExtend['Print'] = PrintMark::No;
        }else{
            //捐贈註記為捐贈(Yes)時，請設定不列印(No)
            if($arExtend['Donation'] == Donation::Yes && $arExtend['Print'] != PrintMark::No){
                array_push($arErrors, 'Print should be No.');
            }
            // 統一編號不為空字串時，請設定列印(Yes)
            if(strlen($arExtend['CustomerIdentifier']) > 0 && $arExtend['Print'] != PrintMark::Yes){
                array_push($arErrors, 'Print should be Yes.');
            }
        }
        // 客戶名稱CustomerName(UrlEncode, 預設為空字串)
        if(!array_key_exists('CustomerName', $arExtend)){
            $arExtend['CustomerName'] = '';
        }else{
            if (mb_strlen($arExtend['CustomerName'], 'UTF-8') > 20) {
                array_push($arErrors, 'CustomerName max length as 20.');
            }
            // 列印註記為列印(Yes)時，此參數不可為空字串
            if($arExtend['Print'] == PrintMark::Yes && strlen($arExtend['CustomerName']) == 0){
                array_push($arErrors, 'CustomerName is required.');
            }
        }

        // 客戶地址CustomerAddr(UrlEncode, 預設為空字串)
        if(!array_key_exists('CustomerAddr', $arExtend)){
            $arExtend['CustomerAddr'] = '';
        }else{
            if (mb_strlen($arExtend['CustomerAddr'], 'UTF-8') > 200) {
                array_push($arErrors, 'CustomerAddr max length as 200.');
            }
            // 列印註記為列印(Yes)時，此參數不可為空字串
            if($arExtend['Print'] == PrintMark::Yes && strlen($arExtend['CustomerAddr']) == 0){
                array_push($arErrors, 'CustomerAddr is required.');
            }
        }
        // 客戶電話CustomerPhone
        if(!array_key_exists('CustomerPhone', $arExtend)){
            $arExtend['CustomerPhone'] = '';
        }else{
            if (strlen($arExtend['CustomerPhone']) > 20) array_push($arErrors, 'CustomerPhone max length as 20.');
        }

        // 客戶信箱CustomerEmail
        if(!array_key_exists('CustomerEmail', $arExtend)){
            $arExtend['CustomerEmail'] = '';
        }else{
            if (strlen($arExtend['CustomerEmail']) > 200) array_push($arErrors, 'CustomerEmail max length as 200.');
        }

        //(CustomerEmail與CustomerPhone擇一不可為空)
        if (strlen($arExtend['CustomerPhone']) == 0 and strlen($arExtend['CustomerEmail']) == 0) array_push($arErrors, 'CustomerPhone or CustomerEmail is required.');

        //課稅類別 TaxType(不可為空)
        if (strlen($arExtend['TaxType']) == 0) array_push($arErrors, 'TaxType is required.');

        //通關方式 ClearanceMark(預設為空字串)
        if(!array_key_exists('ClearanceMark', $arExtend)) {
            $arExtend['ClearanceMark'] = '';
        }else{
            //課稅類別為零稅率(Zero)時，ClearanceMark不可為空字串
            if($arExtend['TaxType'] == TaxType::Zero && ($arExtend['ClearanceMark'] != ClearanceMark::Yes || $arExtend['ClearanceMark'] != ClearanceMark::No)) {
                array_push($arErrors, 'ClearanceMark is required.');
            }
            if (strlen($arExtend['ClearanceMark']) > 0 && $arExtend['TaxType'] != TaxType::Zero) {
                array_push($arErrors, 'Please remove ClearanceMark.');
            }
        }

        // CarruerNum(預設為空字串)
        if (!array_key_exists('CarruerNum', $arExtend)) {
            $arExtend['CarruerNum'] = '';
        } else {
            switch ($arExtend['CarruerType']) {
                // 載具類別為無載具(None)或會員載具(Member)時，系統自動忽略載具編號
                case CarruerType::None:
                case CarruerType::Member:
                    break;
                // 載具類別為買受人自然人憑證(Citizen)時，請設定自然人憑證號碼，前2碼為大小寫英文，後14碼為數字
                case CarruerType::Citizen:
                    if (!preg_match('/^[a-zA-Z]{2}\d{14}$/', $arExtend['CarruerNum'])){
                        array_push($arErrors, 'Invalid CarruerNum.');
                    }
                    break;
                // 載具類別為買受人手機條碼(Cellphone)時，請設定手機條碼，第1碼為「/」，後7碼為大小寫英文、數字、「+」、「-」或「.」
                case CarruerType::Cellphone:
                    if (!preg_match('/^\/{1}[0-9a-zA-Z+-.]{7}$/', $arExtend['CarruerNum'])) {
                        array_push($arErrors, 'Invalid CarruerNum.');
                    }
                    break;

                default:
                    array_push($arErrors, 'Please remove CarruerNum.');
            }
        }

        // 愛心碼 LoveCode(預設為空字串)
        if(!array_key_exists('LoveCode', $arExtend)) $arExtend['LoveCode'] = '';
        // 捐贈註記為捐贈(Yes)時，參數長度固定3~7碼，請設定全數字或第1碼大小寫「X」，後2~6碼全數字
        if ($arExtend['Donation'] == Donation::Yes) {
            if (!preg_match('/^([xX]{1}[0-9]{2,6}|[0-9]{3,7})$/', $arExtend['LoveCode'])) {
                array_push($arErrors, 'Invalid LoveCode.');
            }
        }

        //備註 InvoiceRemark(UrlEncode, 預設為空字串)
        if(!array_key_exists('InvoiceRemark', $arExtend)) $arExtend['InvoiceRemark'] = '';

        // 延遲天數 DelayDay(不可為空, 預設為0) 延遲天數，範圍0~15，設定為0時，付款完成後立即開立發票
        if(!array_key_exists('DelayDay', $arExtend)) $arExtend['DelayDay'] = 0 ;
        if ($arExtend['DelayDay'] < 0 or $arExtend['DelayDay'] > 15) array_push($arErrors, 'DelayDay should be 0 ~ 15.');


        // 字軌類別 InvType(不可為空)
        if (!array_key_exists('InvType', $arExtend)) array_push($arErrors, 'InvType is required.');

        //商品相關整理
        if(!array_key_exists('InvoiceItems', $arExtend)){
            array_push($arErrors, 'Invoice Goods information not found.');
        }else{
            $InvSptr = '|';
            $tmpItemName = [];
            $tmpItemCount = [];
            $tmpItemWord = [];
            $tmpItemPrice = [];
            $tmpItemTaxType = [];
            foreach ($arExtend['InvoiceItems'] as $tmpItemInfo) {
                if (mb_strlen($tmpItemInfo['Name'], 'UTF-8') > 0) {
                    array_push($tmpItemName, $tmpItemInfo['Name']);
                }
                if (strlen($tmpItemInfo['Count']) > 0) {
                    array_push($tmpItemCount, $tmpItemInfo['Count']);
                }
                if (mb_strlen($tmpItemInfo['Word'], 'UTF-8') > 0) {
                    array_push($tmpItemWord, $tmpItemInfo['Word']);
                }
                if (strlen($tmpItemInfo['Price']) > 0) {
                    array_push($tmpItemPrice, $tmpItemInfo['Price']);
                }
                if (strlen($tmpItemInfo['TaxType']) > 0) {
                    array_push($tmpItemTaxType, $tmpItemInfo['TaxType']);
                }
            }

            if ($arExtend['TaxType'] == TaxType::Mix) {
                if (in_array(TaxType::Dutiable, $tmpItemTaxType) and in_array(TaxType::Free, $tmpItemTaxType)) {
                    // Do nothing
                }  else {
                    $tmpItemTaxType = [];
                }
            }
            if ((count($tmpItemName) + count($tmpItemCount) + count($tmpItemWord) + count($tmpItemPrice) + count($tmpItemTaxType)) == (count($tmpItemName) * 5)) {
                $arExtend['InvoiceItemName']    = implode($InvSptr, $tmpItemName);
                $arExtend['InvoiceItemCount']   = implode($InvSptr, $tmpItemCount);
                $arExtend['InvoiceItemWord']    = implode($InvSptr, $tmpItemWord);
                $arExtend['InvoiceItemPrice']   = implode($InvSptr, $tmpItemPrice);
                $arExtend['InvoiceItemTaxType'] = implode($InvSptr, $tmpItemTaxType);
            }

            unset($arExtend['InvoiceItems']);
        }

        $encode_fields = [
            'CustomerName',
            'CustomerAddr',
            'CustomerEmail',
            'InvoiceItemName',
            'InvoiceItemWord',
            'InvoiceRemark'
        ];
        foreach ($encode_fields as $tmp_field) {
            $arExtend[$tmp_field] = static::ecpay_urlencode($arExtend[$tmp_field]);
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('<br>', $arErrors));
        }

        return $arExtend ;
    }

    /**
     * URL Encode編碼，特殊字元取代
     *
     * @param  string $sParameters
     * @return string $sParameters
     */
    public static function ecpay_urlencode($sParameters) {

        // URL Encode編碼
        $sParameters = urlencode($sParameters);

        // 轉成小寫
        $sParameters = strtolower($sParameters);

        // 參數內特殊字元取代
        $sParameters = CheckMacValue::Replace_Symbol($sParameters);

        return $sParameters;
    }

    // 是否支援 IgnorePayment 參數
    private function support_ignore_payment($arParameters = []){
        $arSupportPayments = [
            PaymentMethod::ALL,
            PaymentMethod::Credit,
        ];
        return (in_array($arParameters['ChoosePayment'], $arSupportPayments) === true);
    }
}
