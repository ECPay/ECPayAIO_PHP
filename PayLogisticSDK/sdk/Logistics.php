<?php

namespace ECPay\PayLogisticSDK;

use Exception;
use ReflectionClass;

class Logistics
{
    /**
     * 版本
     */
    const VERSION = '1.1.191014';

    public $ServiceURL = '';
    public $HashKey = '';
    public $HashIV = '';
    public $Send = [];
    public $SendExtend = '';
    public $PostParams = [];
    public $Encode = 'UTF-8';

    public function __construct() {}

    /**
     *  電子地圖
     *
     * @param     string    $ButtonDesc 按鈕顯示名稱
     * @param     string    $Target 表單 action 目標
     * @return    string
     */
    public function CvsMap($ButtonDesc = '電子地圖', $Target = '_self')
    {
        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'MerchantTradeNo' => '',
            'LogisticsSubType' => '',
            'IsCollection' => '',
            'ServerReplyURL' => '',
            'ExtraData' => '',
            'Device' => Device::PC
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $this->PostParams['LogisticsType'] = Type::CVS;

        // 參數檢查
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('CVS_MAP');
        $this->ValidateLogisticsSubType();
        $this->ValidateIsCollection();
        $this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
        $this->ValidateString('ExtraData', $this->PostParams['ExtraData'], 20, true);
        $this->ValidateDevice(true);

        return $this->GenPostHTML($ButtonDesc, $Target);
    }

    /**
     *  物流訂單建立
     *
     * @param     string    $ButtonDesc 按鈕顯示名稱
     * @param     string    $Target 表單 action 目標
     * @return    string
     */
    public function CreateShippingOrder($ButtonDesc = '物流訂單建立', $Target = '_self')
    {
        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'MerchantTradeNo' => '',
            'MerchantTradeDate' => '',
            'LogisticsType' => '',
            'LogisticsSubType' => '',
            'GoodsAmount' => 0,
            'CollectionAmount' => 0,
            'IsCollection' => IsCollection::NO,
            'GoodsName' => '',
            'SenderName' => '',
            'SenderPhone' => '',
            'SenderCellPhone' => '',
            'ReceiverName' => '',
            'ReceiverPhone' => '',
            'ReceiverCellPhone' => '',
            'ReceiverEmail' => '',
            'TradeDesc' => '',
            'ServerReplyURL' => '',
            'ClientReplyURL' => '',
            'LogisticsC2CReplyURL' => '',
            'Remark' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $MinAmount = 1; // 金額下限
        $MaxAmount = 20000; // 金額上限

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('SHIPPING_ORDER');
        $this->ValidateMerchantTradeDate();
        $this->ValidateLogisticsType();
        $this->ValidateLogisticsSubType();

        // 依不同的物流類型(LogisticsType)設定專屬參數並檢查
        switch ($this->PostParams['LogisticsType']) {
            case Type::CVS:
                $CvsParamList = [
                    'ReceiverStoreID' => '',
                    'ReturnStoreID' => ''
                ];
                $this->PostParams = $this->GetPostParams($this->SendExtend, $CvsParamList, $this->PostParams);

                $this->ValidateMixTypeID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6);
                $this->ValidateMixTypeID('ReturnStoreID', $this->PostParams['ReturnStoreID'], 6, true);
                break;
            case Type::HOME:
                $HomeParamList = [
                    'SenderZipCode' => '',
                    'SenderAddress' => '',
                    'ReceiverZipCode' => '',
                    'ReceiverAddress' => '',
                    'Temperature' => Temperature::ROOM,
                    'Distance' => Distance::SAME,
                    'Specification' => Specification::CM_60,
                    'ScheduledDeliveryTime' => '',
                    'ScheduledDeliveryDate' => '',
                    'PackageCount' => 0
                ];
                $this->PostParams = $this->GetPostParams($this->SendExtend, $HomeParamList, $this->PostParams);
                $this->PostParams['ScheduledPickupTime'] = ScheduledPickupTime::UNLIMITED;

                $this->ValidateZipCode('SenderZipCode', $this->PostParams['SenderZipCode']);
                $this->ValidateAddress('SenderAddress', $this->PostParams['SenderAddress'], 6, 60);
                $this->ValidateZipCode('ReceiverZipCode', $this->PostParams['ReceiverZipCode']);
                $this->ValidateAddress('ReceiverAddress', $this->PostParams['ReceiverAddress'], 6, 60);
                $this->ValidateTemperature();
                $this->ValidateDistance();
                $this->ValidateSpecification();
                $this->ValidateScheduledDeliveryTime(true);
                break;
            default:
        }

        $this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
        if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
            throw new Exception('Invalid GoodsAmount.');
        }

        $this->ValidateIsCollection(true);
        if ($this->PostParams['IsCollection'] == IsCollection::NO) {
            // 若設定為僅配送，清除代收金額
            unset($this->PostParams['CollectionAmount']);
        } else {
            $this->ValidateAmount('CollectionAmount', $this->PostParams['CollectionAmount']);
            if ($this->PostParams['CollectionAmount'] < $MinAmount or $this->PostParams['CollectionAmount'] > $MaxAmount){
                throw new Exception('Invalid CollectionAmount.');
            }
        }

        if ($this->PostParams['LogisticsSubType'] == SubType::HILIFE_C2C or $this->PostParams['LogisticsSubType'] == SubType::UNIMART_C2C) {
            // 物流子類型(LogisticsSubType)為萊爾富店到店(HILIFEC2C)、 統一超商交貨便(UNIMARTC2C)時，不可為空
            $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60);
        } else {
            $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
        }

        $this->ValidateGoodsName('GoodsName', $this->PostParams['GoodsName'], true);


        $this->ValidateString('SenderName', $this->PostParams['SenderName'], 10);
        $this->ValidateSenderName('SenderName', $this->PostParams['SenderName'], true);

        $this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
        $this->ValidateCellphoneNumber('SenderCellPhone', $this->PostParams['SenderCellPhone'], true);
        if ($this->PostParams['LogisticsType'] == Type::HOME) {
            // 物流類型(LogisticsType)為宅配(Home)時，寄件人電話(SenderPhone)或寄件人手機(SenderCellPhone)不可為空
            if (empty($this->PostParams['SenderPhone']) and empty($this->PostParams['SenderCellPhone'])) {
                throw new Exception('SenderPhone or SenderCellPhone is required when LogisticsType is Home.');
            }
        } else if ($this->PostParams['LogisticsSubType'] == SubType::HILIFE_C2C or $this->PostParams['LogisticsSubType'] == SubType::UNIMART_C2C) {
            // 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)、萊爾富店到店(HILIFEC2C)時，寄件人手機(SenderCellPhone)不可為空
            if (empty($this->PostParams['SenderCellPhone'])) {
                throw new Exception('SenderCellPhone is required when LogisticsSubType is UNIMARTC2C or HILIFEC2C.');
            }
        }

        $this->ValidateString('ReceiverName', $this->PostParams['ReceiverName'], 10);
        $this->ValidateReceiverName('ReceiverName', $this->PostParams['ReceiverName'], true);

        $this->ValidatePhoneNumber('ReceiverPhone', $this->PostParams['ReceiverPhone'], true);
        $this->ValidateCellphoneNumber('ReceiverCellPhone', $this->PostParams['ReceiverCellPhone'], true);
        if ($this->PostParams['LogisticsType'] == Type::HOME) {
            // 物流類型(LogisticsType)為宅配(Home)時，收件人電話(ReceiverPhone)或收件人手機(ReceiverCellPhone)不可為空
            if (empty($this->PostParams['ReceiverPhone']) and empty($this->PostParams['ReceiverCellPhone'])) {
                throw new Exception('ReceiverPhone or ReceiverCellPhone is required when LogisticsType is Home.');
            }
        } else {
            // 物流子類型(LogisticsSubType)為統一超商(UNIMART)、全家(FAMILY)、萊爾富(HILIFE)、統一超商交貨便(UNIMARTC2C)、全家超商店到店(FAMILYC2C)、萊爾富富店到店(HILIFEC2C)時，收件人手機(ReceiverCellPhone)不可為空
            if (empty($this->PostParams['ReceiverCellPhone'])) {
                throw new Exception('ReceiverCellPhone is required.');
            }
        }

        if ($this->PostParams['LogisticsSubType'] == SubType::ECAN and $this->PostParams['Temperature'] !== Temperature::ROOM) {
            // 物流子類型為宅配通(ECAN)時，溫層(Temperature)只能用常溫(ROOM)
            throw new Exception('Temperature should be ROOM when LogisticsSubType is ECAN.');
        }

        if ($this->PostParams['LogisticsSubType'] == SubType::ECAN and date('Ymd', strtotime($this->PostParams['ScheduledDeliveryDate'])) < date('Ymd', strtotime('+3 day'))) {
            // 指定送達日期為該訂單建立時間 + 3 天
            throw new Exception('ScheduledDeliveryDate should be the time that create order + 3 day.');
        }

        $this->ValidateEmail('ReceiverEmail', $this->PostParams['ReceiverEmail'], 50, true);
        $this->ValidateString('TradeDesc', $this->PostParams['TradeDesc'], 200, true);
        $this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
        $this->ValidateURL('ClientReplyURL', $this->PostParams['ClientReplyURL'], 200, true);

        if ($this->PostParams['LogisticsSubType'] == SubType::UNIMART_C2C) {
            // 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，此欄位不可為空
            $this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL']);
        } else {
            $this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL'], 200, true);
        }

        $this->ValidateString('Remark', $this->PostParams['Remark'], 200, true);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 物流類型(LogisticsType)為宅配(Home)且溫層(Temperature)為冷凍(0003)時，規格(Specification)不可為 150cm(0004)
        if ($this->PostParams['LogisticsType'] == Type::HOME and $this->PostParams['Temperature'] == Temperature::FREEZE) {
            if ($this->PostParams['Specification'] == Specification::CM_150) {
                throw new Exception('Specification could not be 150cm(0004) when LogisticsType is Home and Temperature is FREEZE(0003).');
            }
        }

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        return $this->GenPostHTML($ButtonDesc, $Target);
    }

    /**
     *  幕後物流訂單建立
     *
     * @return    array
     */
    public function BGCreateShippingOrder()
    {
        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'MerchantTradeNo' => '',
            'MerchantTradeDate' => '',
            'LogisticsType' => '',
            'LogisticsSubType' => '',
            'GoodsAmount' => 0,
            'CollectionAmount' => 0,
            'IsCollection' => IsCollection::NO,
            'GoodsName' => '',
            'SenderName' => '',
            'SenderPhone' => '',
            'SenderCellPhone' => '',
            'ReceiverName' => '',
            'ReceiverPhone' => '',
            'ReceiverCellPhone' => '',
            'ReceiverEmail' => '',
            'TradeDesc' => '',
            'ServerReplyURL' => '',
            'LogisticsC2CReplyURL' => '',
            'Remark' => '',
            'PlatformID' => ''
        ];

        // 幕後物流訂單建立不可設定Client端回覆網址(ClientReplyURL)
        if (!empty($this->Send['ClientReplyURL'])) {
            throw new Exception('ClientReplyURL should be null.');
        }

        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $MinAmount = 1; // 金額下限
        $MaxAmount = 20000; // 金額上限

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('SHIPPING_ORDER');
        $this->ValidateMerchantTradeDate();
        $this->ValidateLogisticsType();
        $this->ValidateLogisticsSubType();

        // 依不同的物流類型(LogisticsType)設定專屬參數並檢查
        switch ($this->PostParams['LogisticsType']) {
            case Type::CVS:
                $CvsParamList = [
                    'ReceiverStoreID' => '',
                    'ReturnStoreID' => ''
                ];
                $this->PostParams = $this->GetPostParams($this->SendExtend, $CvsParamList, $this->PostParams);

                $this->ValidateMixTypeID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6);
                $this->ValidateMixTypeID('ReturnStoreID', $this->PostParams['ReturnStoreID'], 6, true);
                break;
            case Type::HOME:
                $HomeParamList = [
                    'SenderZipCode' => '',
                    'SenderAddress' => '',
                    'ReceiverZipCode' => '',
                    'ReceiverAddress' => '',
                    'Temperature' => Temperature::ROOM,
                    'Distance' => Distance::SAME,
                    'Specification' => Specification::CM_60,
                    'ScheduledDeliveryTime' => '',
                    'ScheduledDeliveryDate' => '',
                    'PackageCount' => 0
                ];
                $this->PostParams = $this->GetPostParams($this->SendExtend, $HomeParamList, $this->PostParams);
                $this->PostParams['ScheduledPickupTime'] = ScheduledPickupTime::UNLIMITED;

                $this->ValidateZipCode('SenderZipCode', $this->PostParams['SenderZipCode']);
                $this->ValidateAddress('SenderAddress', $this->PostParams['SenderAddress'], 6, 60);
                $this->ValidateZipCode('ReceiverZipCode', $this->PostParams['ReceiverZipCode']);
                $this->ValidateAddress('ReceiverAddress', $this->PostParams['ReceiverAddress'], 6, 60);
                $this->ValidateTemperature();
                $this->ValidateDistance();
                $this->ValidateSpecification();
                $this->ValidateScheduledDeliveryTime(true);
                break;
            default:
        }

        $this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
        if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
            throw new Exception('Invalid GoodsAmount.');
        }

        $this->ValidateIsCollection(true);
        if ($this->PostParams['IsCollection'] == IsCollection::NO) {
            // 若設定為僅配送，清除代收金額
            unset($this->PostParams['CollectionAmount']);
        } else {
            $this->ValidateAmount('CollectionAmount', $this->PostParams['CollectionAmount']);
            if ($this->PostParams['CollectionAmount'] < $MinAmount or $this->PostParams['CollectionAmount'] > $MaxAmount){
                throw new Exception('Invalid CollectionAmount.');
            }
        }

        if ($this->PostParams['LogisticsSubType'] == SubType::HILIFE_C2C or $this->PostParams['LogisticsSubType'] == SubType::UNIMART_C2C) {
            // 物流子類型(LogisticsSubType)為萊爾富店到店(HILIFEC2C)、 統一超商交貨便(UNIMARTC2C)時，不可為空
            $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60);
        } else {
            $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
        }

        $this->ValidateGoodsName('GoodsName', $this->PostParams['GoodsName'], true);

        $this->ValidateString('SenderName', $this->PostParams['SenderName'], 10);
        $this->ValidateSenderName('SenderName', $this->PostParams['SenderName'], true);

        $this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
        $this->ValidateCellphoneNumber('SenderCellPhone', $this->PostParams['SenderCellPhone'], true);
        if ($this->PostParams['LogisticsType'] == Type::HOME) {
            // 物流類型(LogisticsType)為宅配(Home)時，寄件人電話(SenderPhone)或寄件人手機(SenderCellPhone)不可為空
            if (empty($this->PostParams['SenderPhone']) and empty($this->PostParams['SenderCellPhone'])) {
                throw new Exception('SenderPhone or SenderCellPhone is required when LogisticsType is Home.');
            }
        } else if ($this->PostParams['LogisticsSubType'] == SubType::HILIFE_C2C or $this->PostParams['LogisticsSubType'] == SubType::UNIMART_C2C) {
            // 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)、萊爾富店到店(HILIFEC2C)時，寄件人手機(SenderCellPhone)不可為空
            if (empty($this->PostParams['SenderCellPhone'])) {
                throw new Exception('SenderCellPhone is required when LogisticsSubType is UNIMARTC2C or HILIFEC2C.');
            }
        }

        $this->ValidateString('ReceiverName', $this->PostParams['ReceiverName'], 10);
        $this->ValidateReceiverName('ReceiverName', $this->PostParams['ReceiverName'], true);

        $this->ValidatePhoneNumber('ReceiverPhone', $this->PostParams['ReceiverPhone'], true);
        $this->ValidateCellphoneNumber('ReceiverCellPhone', $this->PostParams['ReceiverCellPhone'], true);
        if ($this->PostParams['LogisticsType'] == Type::HOME) {
            // 物流類型(LogisticsType)為宅配(Home)時，收件人電話(ReceiverPhone)或收件人手機(ReceiverCellPhone)不可為空
            if (empty($this->PostParams['ReceiverPhone']) and empty($this->PostParams['ReceiverCellPhone'])) {
                throw new Exception('ReceiverPhone or ReceiverCellPhone is required when LogisticsType is Home.');
            }
        } else {
            // 物流子類型(LogisticsSubType)為統一超商(UNIMART)、全家(FAMILY)、萊爾富(HILIFE)、統一超商交貨便(UNIMARTC2C)、全家超商店到店(FAMILYC2C)、萊爾富富店到店(HILIFEC2C)時，收件人手機(ReceiverCellPhone)不可為空
            if (empty($this->PostParams['ReceiverCellPhone'])) {
                throw new Exception('ReceiverCellPhone is required.');
            }
        }

        if ($this->PostParams['LogisticsSubType'] == SubType::ECAN and $this->PostParams['Temperature'] !== Temperature::ROOM) {
            // 物流子類型為宅配通(ECAN)時，溫層(Temperature)只能用常溫(ROOM)
            throw new Exception('Temperature should be ROOM when LogisticsSubType is ECAN.');
        }

        if ($this->PostParams['LogisticsSubType'] == SubType::ECAN and date('Ymd', strtotime($this->PostParams['ScheduledDeliveryDate'])) < date('Ymd', strtotime('+3 day'))) {
            // 指定送達日期為該訂單建立時間 + 3 天
            throw new Exception('ScheduledDeliveryDate should be the time that create order + 3 day.');
        }

        $this->ValidateEmail('ReceiverEmail', $this->PostParams['ReceiverEmail'], 50, true);
        $this->ValidateString('TradeDesc', $this->PostParams['TradeDesc'], 200, true);
        $this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);

        if ($this->PostParams['LogisticsSubType'] == SubType::UNIMART_C2C) {
            // 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，此欄位不可為空
            $this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL']);
        } else {
            $this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL'], 200, true);
        }

        $this->ValidateString('Remark', $this->PostParams['Remark'], 200, true);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 物流類型(LogisticsType)為宅配(Home)且溫層(Temperature)為冷凍(0003)時，規格(Specification)不可為 150cm(0004)
        if ($this->PostParams['LogisticsType'] == Type::HOME and $this->PostParams['Temperature'] == Temperature::FREEZE) {
            if ($this->PostParams['Specification'] == Specification::CM_150) {
                throw new Exception('Specification could not be 0004 when LogisticsType is Home and Temperature is 0003.');
            }
        }

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // urlencode
        foreach($this->PostParams as $key => $Value) {
            $this->PostParams[$key] = urlencode($Value);
        }

        // 解析回傳結果
        // 正確：1|MerchantID=XXX&MerchantTradeNo=XXX&RtnCode=XXX&RtnMsg=XXX&AllPayLogisticsID=XXX&LogisticsType=XXX&LogisticsSubType=XXX&GoodsAmount=XXX&UpdateStatusDate=XXX&ReceiverName=XXX&ReceiverPhone=XXX&ReceiverCellPhone=XXX&ReceiverEmail=XXX&ReceiverAddress=XXX&CVSPaymentNo=XXX&CVSValidationNo=XXX &CheckMacValue=XXX
        // 錯誤：0|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Pieces = explode('|', $Feedback);
        $Result = [];
        $Result['ResCode'] = $Pieces[0];
        if ($Result['ResCode']) {
            $RtnCont = [];
            parse_str($Pieces[1], $RtnCont);
            $Result = array_merge($Result, $RtnCont);
        } else {
            $Result['ErrorMessage'] = $Pieces[1];
        }

        return $Result;
    }

    /**
     *  回傳 CheckMacValue 檢查
     *
     * @param     array    $Feedback ECPay 回傳資料
     * @return    void
     */
    public function CheckOutFeedback($Feedback = [])
    {

        $this->ValidateHashKey();
        $this->ValidateHashIV();

        if (empty($Feedback)) {
            throw new Exception('Feedback is required.');
        }

        if (!isset($Feedback['CheckMacValue'])) {
            throw new Exception('Feedback CheckMacValue is required.');
        } else {
            $FeedbackCheckMacValue = $Feedback['CheckMacValue'];
            unset($Feedback['CheckMacValue']);
            unset($Feedback['ResCode']);
            unset($Feedback['ErrorMessage']);
            $CheckMacValue = CheckMacValue::Generate($Feedback, $this->HashKey, $this->HashIV);
            if ($CheckMacValue != $FeedbackCheckMacValue) {
                throw new Exception('CheckMacValue verify fail.');
            }
        }
    }

    /**
     *  宅配逆物流訂單產生
     *
     * @return    array
     */
    public function CreateHomeReturnOrder()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'LogisticsSubType' => '',
            'ServerReplyURL' => '',
            'SenderName' => '',
            'SenderPhone' => '',
            'SenderCellPhone' => '',
            'SenderZipCode' => '',
            'SenderAddress' => '',
            'ReceiverName' => '',
            'ReceiverPhone' => '',
            'ReceiverCellPhone' => '',
            'ReceiverZipCode' => '',
            'ReceiverAddress' => '',
            'GoodsAmount' => '',
            'GoodsName' => '',
            'Temperature' => Temperature::ROOM,
            'Distance' => Distance::SAME,
            'Specification' => Specification::CM_60,
            'ScheduledPickupTime' => ScheduledPickupTime::UNLIMITED,
            'ScheduledDeliveryTime' => '',
            'ScheduledDeliveryDate' => '',
            'PackageCount' => 0,
            'Remark' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $this->PostParams['ScheduledPickupTime'] = ScheduledPickupTime::UNLIMITED; // 預定取件時段(ScheduledPickupTime)固定為不限時
        $IsAllpayLogisticsIdEmpty = false; // 物流交易編號(AllPayLogisticsID)是否為空
        $IsAllowEmpty = true;
        $MinAmount = 1; // 金額下限
        $MaxAmount = 20000; // 金額上限

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('HOME_RETURN_ORDER');

        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20, true);

        $this->ValidateLogisticsSubType(true);

        // 物流交易編號(AllPayLogisticsID)與物流子類型(LogisticsSubType)擇一不可為空
        if (empty($this->PostParams['AllPayLogisticsID'])) {
            $IsAllpayLogisticsIdEmpty = true;
        }
        if ($IsAllpayLogisticsIdEmpty === true and empty($this->PostParams['LogisticsSubType'])) {
            throw new Exception('One of AllPayLogisticsID and LogisticsSubType is required.');
        }

        $this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);

        // 物流交易編號(AllPayLogisticsID)為空值時，退貨人姓名(SenderName)不可為空。
        if ($IsAllpayLogisticsIdEmpty) {
            $IsAllowEmpty = false;
        }
        $this->ValidateString('SenderName', $this->PostParams['SenderName'], 10, $IsAllowEmpty);

        $this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
        $this->ValidateCellphoneNumber('SenderCellPhone', $this->PostParams['SenderCellPhone'], true);
        // 物流交易編號(AllPayLogisticsID)為空值時，退貨人電話(SenderPhone)與退貨人手機(SenderCellPhone)擇一不可為空。
        if ($IsAllpayLogisticsIdEmpty) {
            if (empty($this->PostParams['SenderPhone']) and empty($this->PostParams['SenderCellPhone'])) {
                throw new Exception('One of SenderPhone and SenderCellPhone is required.');
            }
        }

        // 物流交易編號(AllPayLogisticsID)為空值時，退貨人郵遞區號(SenderZipCode)不可為空。
        $this->ValidateZipCode('SenderZipCode', $this->PostParams['SenderZipCode'], $IsAllowEmpty);

        // 物流交易編號(AllPayLogisticsID)為空值時，SenderAddress(SenderAddress)不可為空。
        $this->ValidateAddress('SenderAddress', $this->PostParams['SenderAddress'], 6, 60, $IsAllowEmpty);

        // 若物流交易編號(AllPayLogisticsID)為空值時，收件人姓名(ReceiverName)不可為空。
        $this->ValidateString('ReceiverName', $this->PostParams['ReceiverName'], 10, $IsAllowEmpty);

        $this->ValidatePhoneNumber('ReceiverPhone', $this->PostParams['ReceiverPhone'], 20, true);
        $this->ValidateCellphoneNumber('ReceiverCellPhone', $this->PostParams['ReceiverCellPhone'], 20, true);
        // 物流交易編號(AllPayLogisticsID)為空值時，收件人電話(ReceiverPhone)與收件人手機(ReceiverCellPhone)擇一不可為空。
        if ($IsAllpayLogisticsIdEmpty) {
            if (empty($this->PostParams['ReceiverPhone']) and empty($this->PostParams['ReceiverCellPhone'])) {
                throw new Exception('One of ReceiverPhone and ReceiverCellPhone is required.');
            }
        }

        // 若物流交易編號(AllPayLogisticsID)為空值時，收件人郵遞區號(ReceiverZipCode)不可為空。
        $this->ValidateZipCode('ReceiverZipCode', $this->PostParams['ReceiverZipCode'], $IsAllowEmpty);

        // 若物流交易編號(AllPayLogisticsID)為空值時，收件人地址(ReceiverAddress)不可為空。
        $this->ValidateAddress('ReceiverAddress', $this->PostParams['ReceiverAddress'], 6, 60, $IsAllowEmpty);

        if ($this->PostParams['LogisticsSubType'] == SubType::ECAN and $this->PostParams['Temperature'] !== Temperature::ROOM) {
            // 物流子類型為宅配通(ECAN)時，溫層(Temperature)只能用常溫(ROOM)
            throw new Exception('Temperature should be ROOM when LogisticsSubType is ECAN.');
        }

        if ($this->PostParams['LogisticsSubType'] == SubType::ECAN and date('Ymd', strtotime($this->PostParams['ScheduledDeliveryDate'])) < date('Ymd', strtotime('+3 day'))) {
            // 指定送達日期為該訂單建立時間 + 3 天
            throw new Exception('ScheduledDeliveryDate should be the time that create order + 3 day.');
        }

        $this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
        if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
            throw new Exception('Invalid GoodsAmount.');
        }
        $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
        $this->ValidateTemperature();
        $this->ValidateDistance();
        $this->ValidateSpecification();
        $this->ValidateScheduledDeliveryTime(true);
        $this->ValidateString('Remark', $this->PostParams['Remark'], 200, true);

        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：1|OK
        // 錯誤：0|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Result = $this->ParseFeedback($Feedback);

        return $Result;
    }

    /**
     *  超商取貨逆物流訂單(統一超商B2C)
     *
     * @return    array
     */
    public function CreateUnimartB2CReturnOrder()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'ServerReplyURL' => '',
            'GoodsName' => '',
            'GoodsAmount' => 0,
            'SenderName' => '',
            'SenderPhone' => '',
            'Remark' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $this->PostParams['CollectionAmount'] = 0;
        $this->PostParams['ServiceType'] = 4; // 退貨不付款

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('UNIMART_RETURN_ORDER');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20, true);
        $this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
        $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
        $this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);

        $this->ValidateString('SenderName', $this->PostParams['SenderName'], 50);
        $this->ValidateSenderName('SenderName', $this->PostParams['SenderName'], true);

        $this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
        $this->ValidateString('Remark', $this->PostParams['Remark'], 20, true);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        $MinAmount = 1; // 金額下限
        $MaxAmount = 20000; // 金額上限
        if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
            throw new Exception('Invalid GoodsAmount.');
        }

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：RtnMerchantTradeNo | RtnOrderNo
        // 錯誤：|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Pieces = explode('|', $Feedback);
        $Result = ['RtnMerchantTradeNo' => '', 'RtnOrderNo' => ''];
        if (empty($Pieces[0])) {
            $Result = ['ErrorMessage' => $Pieces[1]];
        } else {
            $Result['RtnMerchantTradeNo'] = $Pieces[0];
            $Result['RtnOrderNo'] = $Pieces[1];
        }

        return $Result;
    }

    /**
     *  超商取貨逆物流訂單(萊爾富超商B2C)
     *
     * @return    array
     */
    public function CreateHiLifeB2CReturnOrder()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'ServerReplyURL' => '',
            'GoodsName' => '',
            'GoodsAmount' => 0,
            'SenderName' => '',
            'SenderPhone' => '',
            'Remark' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $this->PostParams['CollectionAmount'] = 0;
        $this->PostParams['ServiceType'] = 4;// 退貨不付款

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('HILIFE_RETURN_ORDER');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20, true);
        $this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
        $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
        $this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
        $this->ValidateString('SenderName', $this->PostParams['SenderName'], 50);
        $this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
        $this->ValidateString('Remark', $this->PostParams['Remark'], 20, true);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        $MinAmount = 1; // 金額下限
        $MaxAmount = 20000; // 金額上限
        if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
            throw new Exception('Invalid GoodsAmount.');
        }

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：RtnMerchantTradeNo | RtnOrderNo
        // 錯誤：|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Pieces = explode('|', $Feedback);
        $Result = ['RtnMerchantTradeNo' => '', 'RtnOrderNo' => ''];
        if (empty($Pieces[0])) {
            $Result = ['ErrorMessage' => $Pieces[1]];
        } else {
            $Result['RtnMerchantTradeNo'] = $Pieces[0];
            $Result['RtnOrderNo'] = $Pieces[1];
        }

        return $Result;
    }

    /**
     *  超商取貨逆物流訂單(全家超商B2C)
     *
     * @return    array
     */
    public function CreateFamilyB2CReturnOrder()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'ServerReplyURL' => '',
            'GoodsName' => '',
            'GoodsAmount' => 0,
            'SenderName' => '',
            'SenderPhone' => '',
            'Remark' => '',
            'Quantity' => '',
            'Cost' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $this->PostParams['CollectionAmount'] = 0;
        $this->PostParams['ServiceType'] = 4;// 退貨不付款

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('FAMILY_RETURN_ORDER');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20, true);
        $this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
        $this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 50, true);
        $this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
        $this->ValidateString('SenderName', $this->PostParams['SenderName'], 50);
        $this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
        $this->ValidateString('Remark', $this->PostParams['Remark'], 20, true);
        $this->ValidateString('Quantity', $this->PostParams['Quantity'], 50, true);
        $this->ValidateString('Cost', $this->PostParams['Cost'], 50, true);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 檢查商品名稱, 數量 與 成本
        $GoodsNameNumber = count(explode('#', $this->PostParams['GoodsName']));
        $QuantityNumber = count(explode('#', $this->PostParams['Quantity']));
        $CostNumber = count(explode('#', $this->PostParams['Cost']));

        if (!empty($this->PostParams['GoodsName']) and !empty($this->PostParams['Quantity'])) {
            if ($GoodsNameNumber != $QuantityNumber) {
                throw new Exception('GoodsName number and Quantity number do not match.');
            }
        }

        if (!empty($this->PostParams['Quantity']) and !empty($this->PostParams['Cost'])) {
            if ($GoodsNameNumber != $CostNumber) {
                throw new Exception('Quantity number and Cost number do not match.');
            }
        }

        if (!empty($this->PostParams['Cost']) and !empty($this->PostParams['GoodsName'])) {
            if ($GoodsNameNumber != $CostNumber) {
                throw new Exception('Cost number and GoodsName number do not match.');
            }
        }

        $MinAmount = 1; // 金額下限
        $MaxAmount = 20000; // 金額上限
        if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
            throw new Exception('Invalid GoodsAmount.');
        }

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：RtnMerchantTradeNo | RtnOrderNo
        // 錯誤：|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Pieces = explode('|', $Feedback);
        $Result = ['RtnMerchantTradeNo' => '', 'RtnOrderNo' => ''];
        if (empty($Pieces[0])) {
            $Result = ['ErrorMessage' => $Pieces[1]];
        } else {
            $Result['RtnMerchantTradeNo'] = $Pieces[0];
            $Result['RtnOrderNo'] = $Pieces[1];
        }

        return $Result;
    }

    /**
     *  全家逆物流核帳(全家超商B2C)
     *
     * @return    array
     */
    public function CheckFamilyB2CLogistics()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'RtnMerchantTradeNo' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('FAMILY_RETURN_CHECK');
        $this->ValidateID('RtnMerchantTradeNo', $this->PostParams['RtnMerchantTradeNo'], 13);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：1|OK
        // 錯誤：0|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Result = $this->ParseFeedback($Feedback);

        return $Result;
    }

    /**
     *  廠商修改出貨日期、取貨門市(統一超商B2C)
     *
     * @return    array
     */
    public function UpdateUnimartLogisticsInfo()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'ShipmentDate' => '',
            'ReceiverStoreID' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('UNIMART_UPDATE_LOGISTICS_INFO');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);

        $this->ValidateShipmentDate(true);
        $this->ValidateMixTypeID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6, true);
        if (empty($this->PostParams['ShipmentDate']) and empty($this->PostParams['ReceiverStoreID'])) {
            throw new Exception('ShipmentDate or ReceiverStoreID is required.');
        }

        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：1|OK
        // 錯誤：0|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Result = $this->ParseFeedback($Feedback);

        return $Result;
    }

    /**
     *  更新門市(統一超商C2C)
     *
     * @return    array
     */
    public function UpdateUnimartStore()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'CVSPaymentNo' => '',
            'CVSValidationNo' => '',
            'StoreType' => '',
            'ReceiverStoreID' => '',
            'ReturnStoreID' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('UNIMART_UPDATE_STORE_INFO');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
        $this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
        $this->ValidateID('CVSValidationNo', $this->PostParams['CVSValidationNo'], 10);
        $this->ValidateStoreType();

        if ($this->PostParams['StoreType'] == EcpayStoreType::RECIVE_STORE) {
            $this->ValidateMixTypeID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6);
        } else {
            unset($this->PostParams['ReceiverStoreID']);
        }

        if ($this->PostParams['StoreType'] == EcpayStoreType::RETURN_STORE) {
            $this->ValidateMixTypeID('ReturnStoreID', $this->PostParams['ReturnStoreID'], 6);
        } else {
            unset($this->PostParams['ReturnStoreID']);
        }

        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：1|OK
        // 錯誤：0|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Result = $this->ParseFeedback($Feedback);

        return $Result;
    }

    /**
     *  取消訂單(統一超商C2C)
     *
     * @return    array
     */
    public function CancelUnimartLogisticsOrder()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'CVSPaymentNo' => '',
            'CVSValidationNo' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('UNIMART_CANCEL_LOGISTICS_ORDER');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
        $this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
        $this->ValidateID('CVSValidationNo', $this->PostParams['CVSValidationNo'], 10);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 正確：1|OK
        // 錯誤：0|ErrorMessage
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        $Result = $this->ParseFeedback($Feedback);

        return $Result;
    }

    /**
     *  物流訂單查詢
     *
     * @return    array
     */
    public function QueryLogisticsInfo()
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);
        $this->PostParams['TimeStamp'] = strtotime('now');

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('QUERY_LOGISTICS_INFO');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        // 解析回傳結果
        // 回應訊息：MerchantID=XXX&MerchantTradeNo=XXX&AllPayLogisticsID=XXX&GoodsAmount=XXX&LogisticsType=XXX&HandlingCharge=XXX&TradeDate=XXX&LogisticsStatus=XXX&GoodsName=XXX &CheckMacValue=XXX
        $Result = [];
        $Feedback = static::ServerPost($this->PostParams, $this->ServiceURL);
        parse_str($Feedback, $Result);

        return $Result;
    }

    /**
     *  產生托運單(宅配)/一段標(超商取貨)
     *
     * @param     string    $ButtonDesc 按鈕顯示名稱
     * @param     string    $Target 表單 action 目標
     * @return    string
     */
    public function PrintTradeDoc($ButtonDesc = '產生托運單/一段標', $Target = '_blank')
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('PRINT_TRADE_DOC');
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        return $this->GenPostHTML($ButtonDesc, $Target);
    }

    /**
     *  列印繳款單(統一超商C2C)
     *
     * @param     string    $ButtonDesc 按鈕顯示名稱
     * @param     string    $Target 表單 action 目標
     * @return    string
     */
    public function PrintUnimartC2CBill($ButtonDesc = '列印繳款單(統一超商C2C)', $Target = '_blank')
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'CVSPaymentNo' => '',
            'CVSValidationNo' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('PRINT_UNIMART_C2C_BILL');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
        $this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
        $this->ValidateID('CVSValidationNo', $this->PostParams['CVSValidationNo'], 10);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        return $this->GenPostHTML($ButtonDesc, $Target);
    }

    /**
     *  全家列印小白單(全家超商C2C)
     *
     * @param     string    $ButtonDesc 按鈕顯示名稱
     * @param     string    $Target 表單 action 目標
     * @return    string
     */
    public function PrintFamilyC2CBill($ButtonDesc = '全家列印小白單(全家超商C2C)', $Target = '_blank')
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'CVSPaymentNo' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('PRINT_FAMILY_C2C_BILL');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
        $this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        return $this->GenPostHTML($ButtonDesc, $Target);
    }

    /**
     *  萊爾富列印小白單(萊爾富超商C2C)
     *
     * @param     string    $ButtonDesc 按鈕顯示名稱
     * @param     string    $Target 表單 action 目標
     * @return    string
     */
    public function PrintHiLifeC2CBill($ButtonDesc = '萊爾富列印小白單(萊爾富超商C2C)', $Target = '_blank')
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'AllPayLogisticsID' => '',
            'CVSPaymentNo' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('Print_HILIFE_C2C_BILL');
        $this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
        $this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        return $this->GenPostHTML($ButtonDesc, $Target);
    }

    /**
     *  產生 B2C 測標資料
     *
     * @param     string    $ButtonDesc 按鈕顯示名稱
     * @param     string    $Target 表單 action 目標
     * @return    string
     */
    public function CreateTestData($ButtonDesc = '產生 B2C 測標資料', $Target = '_blank')
    {

        // 參數初始化
        $ParamList = [
            'MerchantID' => '',
            'ClientReplyURL' => '',
            'LogisticsSubType' => '',
            'PlatformID' => ''
        ];
        $this->PostParams = $this->GetPostParams($this->Send, $ParamList);

        // 參數檢查
        $this->ValidateHashKey();
        $this->ValidateHashIV();
        $this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
        $this->ServiceURL = $this->GetURL('CREATE_TEST_DATA');
        $this->ValidateLogisticsSubType();
        $this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

        // 產生 CheckMacValue
        $this->PostParams['CheckMacValue'] = CheckMacValue::Generate($this->PostParams, $this->HashKey, $this->HashIV);

        return $this->GenPostHTML($ButtonDesc, $Target);
    }

    /**
     *  Hash Key 檢查
     *
     * @return    void
     */
    public function ValidateHashKey()
    {
        $Name = 'HashKey'; // 參數名稱
        $Value = $this->HashKey; // 參數內容

        // 空值檢查
        $this->IsEmpty($Name, $Value);
    }

    /**
     *  Hash IV 檢查
     *
     * @return    void
     */
    public function ValidateHashIV()
    {
        $Name = 'HashIV'; // 參數名稱
        $Value = $this->HashKey; // 參數內容

        // 空值檢查
        $this->IsEmpty($Name, $Value);
    }

    /**
     *  ID 檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     integer    $MaxLength     參數最大長度
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateID($Name, $Value, $MaxLength = 1, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $this->IsValidFormat($Name, '/^\d{1,' . $MaxLength . '}$/', $Value);
    }

    /**
     *  URL 檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     integer    $MaxLength     參數最大長度
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateURL($Name, $Value, $MaxLength = 200, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $this->IsValidFormat($Name, '/^(http|https):\/\/+/', $Value);

        // 長度檢查
        $this->IsOverLength($Name, $this->StringLength($Value, $this->Encode), $MaxLength);
    }

    /**
     *  字串檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     integer    $MaxLength     參數最大長度
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateString($Name, $Value, $MaxLength = 1, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 長度檢查
        $this->IsOverLength($Name, $this->StringLength($Value, $this->Encode), $MaxLength);
    }

    /**
     *  金額檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateAmount($Name, $Value, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 資料型態檢查
        $this->IsInteger($Name, $Value);

        // 格式檢查
        $this->IsValidFormat($Name, '/^\d+$/', $Value);
    }

    /**
     *  電話號碼檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidatePhoneNumber($Name, $Value, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $this->IsValidFormat($Name, '/^[\d\#\(\)\-]+$/', $Value);
    }

    /**
     *  手機號碼檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateCellphoneNumber($Name, $Value, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }


        // 格式檢查
        $this->IsValidFormat($Name, '/^09\d{8}$/', $Value);
    }

    /**
     *  電子郵件檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     integer    $MaxLength     參數最大長度
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateEmail($Name, $Value, $MaxLength = 100, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }


        // 長度檢查
        $this->IsOverLength($Name, $this->StringLength($Value, $this->Encode), $MaxLength);

        // 格式檢查
        if (!empty($Value)) {
            if (!filter_var($Value, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid ' . $Name . '.');
            }
        }
    }

    /**
     *  郵遞區號檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateZipCode($Name, $Value, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $this->IsValidFormat($Name, '/^\d{3,5}$/', $Value);
    }

    /**
     *  地址檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     integer    $MinLength     參數最小限制長度
     * @param     integer    $MaxLength     參數最大限制長度
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateAddress($Name, $Value, $MinLength = 1, $MaxLength = 1, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 最小長度限制
        if ($MinLength) {
            $this->IsBelowLength($Name, $this->StringLength($Value, $this->Encode), $MinLength);
        }

        // 最大長度限制
        if ($MaxLength) {
            $this->IsOverLength($Name, $this->StringLength($Value, $this->Encode), $MaxLength);
        }
    }

    /**
     *  混合型態 ID 檢查
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateMixTypeID($Name, $Value, $MaxLength = 1, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $this->IsValidFormat($Name, '/^[0-9a-zA-Z]{1,' . $MaxLength . '}$/', $Value);
    }

    /**
     *  門市類型檢查
     *
     * @return void
     */
    public function ValidateStoreType()
    {
        $Name = 'StoreType'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        $this->IsEmpty($Name, $Value);

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  廠商交易編號檢查
     *
     * @return    void
     */
    public function ValidateMerchantTradeNo()
    {
        $Name = 'MerchantTradeNo'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        $this->IsEmpty($Name, $Value);

        // 格式檢查
        $this->IsValidFormat($Name, '/^[a-zA-Z0-9]{1,20}$/', $Value);
    }

    /**
     * 物流類型檢查
     *
     * @return    void
     */
    public function ValidateLogisticsType()
    {
        $Name = 'LogisticsType'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        $this->IsEmpty($Name, $Value);

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  物流子類型檢查
     * @param    bool       $AllowEmpty    是否允許空值
     * @return   void
     */
    public function ValidateLogisticsSubType($AllowEmpty = false)
    {
        $Name = 'LogisticsSubType'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  是否代收貨款檢查
     *
     * @param     bool    $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateIsCollection($AllowEmpty = false)
    {
        $Name = 'IsCollection'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        if (!$AllowEmpty) {
            $this->IsEmpty($Name, $Value);
        }

        // 目前物流類型(LogisticsType)宅配(Home)不支援代收貨款(IsCollection = Y)
        if (
            $this->PostParams['LogisticsType'] === Type::HOME &&
            $Value == IsCollection::YES
        ) {
            throw new Exception($Name . ' could not be Y, when LogisticsType is Home.');
        }

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  使用設備檢查
     *
     * @return    void
     */
    public function ValidateDevice($AllowEmpty = false)
    {
        $Name = 'Device'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 資料型態檢查
        $this->IsInteger($Name, $Value);

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  廠商交易時間檢查
     *
     * @return    void
     */
    public function ValidateMerchantTradeDate()
    {
        $Name = 'MerchantTradeDate'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        $this->IsEmpty($Name, $Value);

        // 日期檢查
        $this->IsDate($Name, 'Y/m/d H:i:s', $Value);
    }

    /**
     *  溫層檢查
     *
     * @return    void
     */
    public function ValidateTemperature()
    {
        $Name = 'Temperature'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  距離檢查
     *
     * @return    void
     */
    public function ValidateDistance()
    {
        $Name = 'Distance'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     * 規格檢查
     *
     * @return    void
     */
    public function ValidateSpecification()
    {
        $Name = 'Specification'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  預定送達時段檢查
     *
     * @param     bool    $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateScheduledDeliveryTime($AllowEmpty = false)
    {
        $Name = 'ScheduledDeliveryTime'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 內容檢查
        $this->IsLegal($Name, $Value);
    }

    /**
     *  物流訂單出貨日期檢查
     *
     * @param     bool    $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateShipmentDate($AllowEmpty = false)
    {
        $Name = 'ShipmentDate'; // 參數名稱
        $Value = $this->PostParams[$Name]; // 參數內容

        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 日期檢查
        $this->IsDate($Name, 'Y/m/d', $Value);
    }

    /**
     *  商品名稱
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateGoodsName($Name, $Value, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $this->IsValidFormat($Name, '/[\^\'`\!@#%&\*\+\\\"<>\|_\[\]]+/', $Value, true);
    }

    /**
     *  寄件人、退貨人姓名
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateSenderName($Name, $Value, $AllowEmpty = false)
    {
        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $Pattern = '/^([\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}]{2,5}|[a-zA-Z]{4,10})$/u';
        $this->IsValidFormat($Name, $Pattern, $Value, false);
    }

    /**
     *  收件人姓名
     *
     * @param     string     $Name          參數名稱
     * @param     string     $Value         參數內容
     * @param     bool       $AllowEmpty    是否允許空值
     * @return    void
     */
    public function ValidateReceiverName($Name, $Value, $AllowEmpty = false)
    {

        // 空值檢查
        if ($AllowEmpty === false) {
            $this->IsEmpty($Name, $Value);
        }

        // 格式檢查
        $Pattern = '/^([\x{4e00}-\x{9fff}\x{3400}-\x{4dbf}]{2,5}|[a-zA-Z]{4,10})$/u';
        $this->IsValidFormat($Name, $Pattern, $Value, false);
    }

    /**
     * 是否為空
     *
     * @param     string    $Name
     * @param     mixed     $Value
     * @return    bool
     */
    public function IsEmpty($Name, $Value)
    {
        if (empty($Value)) {
            throw new Exception($Name . ' is required.');
        }
    }

    /**
     *  是否超過長度限制
     *
     * @param     string     $Name         參數名稱
     * @param     integer    $Length       參數長度
     * @param     integer    $MaxLength    參數限制長度
     * @return    void
     */
    public function IsOverLength($Name, $Length, $MaxLength)
    {
        if ($Length > $MaxLength) {
            throw new Exception($Name . ' max length is ' . $MaxLength . '.');
        }
    }

    /**
     *  是否低於最小長度限制
     *
     * @param     string     $Name         參數名稱
     * @param     integer    $Length       參數長度
     * @param     integer    $MinLength    參數限制長度
     * @return    void
     */
    public function IsBelowLength($Name, $Length, $MinLength)
    {
        if ($Length < $MinLength) {
            throw new Exception($Name . ' min length is ' . $MinLength . '.');
        }
    }

    /**
     *  是否為指定格式
     *
     * @param     string    $Name            參數名稱
     * @param     string    $Pattern         格式檢查用正規表示法
     * @param     string    $Value           參數內容
     * @param     bool      $ThrowOnMatch    與格式相符
     * @return    void
     */
    public function IsValidFormat($Name, $Pattern, $Value, $ThrowOnMatch = false)
    {
        if (!empty($Value)) {
            if ($ThrowOnMatch === false) {
                if (!preg_match($Pattern, $Value)) {
                    throw new Exception('Invalid ' . $Name . '.');
                }
            } else {
                if (preg_match($Pattern, $Value)) {
                    throw new Exception('Invalid ' . $Name . '.');
                }
            }
        }
    }

    /**
     *  是否為數值
     *
     * @param     string    $Name     參數名稱
     * @param     string    $Value    參數內容
     * @return    void
     */
    public function IsInteger($Name, $Value)
    {
        if (!is_int($Value)) {
            throw new Exception($Name . ' type should be integer.');
        }
    }

    /**
     *  是否為合法數值
     *
     * @param     string    $Name     參數名稱
     * @param     string    $Value    參數內容
     * @return    void
     */
    public function IsLegal($Name, $Value)
    {
        // 取得合法資料內容
        $ClassName = 'Ecpay' . $Name;
        $ReflectionObject = new ReflectionClass($ClassName);
        $ContentList = $ReflectionObject->getConstants();
        unset($ReflectionObject);

        // 檢查是否為合法資料(含空值)
        if (!in_array($Value, $ContentList) && !empty($Value)) {
            throw new Exception('Illegal ' . $Name . '.');
        }
    }

    /**
     *  是否為正確日期
     *
     * @param     string    $Name      參數名稱
     * @param     string    $Format    日期格式
     * @param     string    $Value     參數內容
     * @return    void
     */
    public function IsDate($Name, $Format, $Value)
    {
        if (date($Format, strtotime($Value)) != $Value){
            throw new Exception('Invalid ' . $Name . '.');
        }
    }

    /**
     *  取得並過濾 $_POST 參數
     *
     * @param     array    $Source         來源參數
     * @param     array    $WhiteList      合法參數與預設值
     * @param     array    $MergeParams    其他待合併參數
     * @return    array
     */
    public function GetPostParams($Source, $WhiteList, $MergeParams = [])
    {
        // 過濾非法參數
        $Filtered = [];
        foreach ($WhiteList as $Name => $Value) {
            if (isset($Source[$Name])) {
                $Filtered[$Name] = $Source[$Name];
            } else {
                // 若未設定則帶預設值
                $Filtered[$Name] = $Value;
            }
        }
        return array_merge($MergeParams, $Filtered);
    }

    /**
     *  取得 ECPay URL
     *
     * @param     string    $FunctionType    功能名稱
     * @return    string
     */
    public function GetURL($FunctionType)
    {
        $MerchantID = $this->PostParams['MerchantID'];
        $UrlList = [];
        if ($MerchantID == TestMerchantID::B2C or $MerchantID == TestMerchantID::C2C) {
            // 測試環境
            $UrlList = [
                'CVS_MAP' => TestUrl::CVS_MAP,
                'SHIPPING_ORDER' => TestUrl::SHIPPING_ORDER,
                'HOME_RETURN_ORDER' => TestUrl::HOME_RETURN_ORDER,
                'UNIMART_RETURN_ORDER' => TestUrl::UNIMART_RETURN_ORDER,
                'HILIFE_RETURN_ORDER' => TestUrl::HILIFE_RETURN_ORDER,
                'FAMILY_RETURN_ORDER' => TestUrl::FAMILY_RETURN_ORDER,
                'FAMILY_RETURN_CHECK' => TestUrl::FAMILY_RETURN_CHECK,
                'UNIMART_UPDATE_LOGISTICS_INFO' => TestUrl::UNIMART_UPDATE_LOGISTICS_INFO,
                'UNIMART_UPDATE_STORE_INFO' => TestUrl::UNIMART_UPDATE_STORE_INFO,
                'UNIMART_CANCEL_LOGISTICS_ORDER' => TestUrl::UNIMART_CANCEL_LOGISTICS_ORDER,
                'QUERY_LOGISTICS_INFO' => TestUrl::QUERY_LOGISTICS_INFO,
                'PRINT_TRADE_DOC' => TestUrl::PRINT_TRADE_DOC,
                'PRINT_UNIMART_C2C_BILL' => TestUrl::PRINT_UNIMART_C2C_BILL,
                'PRINT_FAMILY_C2C_BILL' => TestUrl::PRINT_FAMILY_C2C_BILL,
                'Print_HILIFE_C2C_BILL' => TestUrl::Print_HILIFE_C2C_BILL,
                'CREATE_TEST_DATA' => TestUrl::CREATE_TEST_DATA,
            ];
        } else {
            // 正式環境
            $UrlList = [
                'CVS_MAP' => Url::CVS_MAP,
                'SHIPPING_ORDER' => Url::SHIPPING_ORDER,
                'HOME_RETURN_ORDER' => Url::HOME_RETURN_ORDER,
                'UNIMART_RETURN_ORDER' => Url::UNIMART_RETURN_ORDER,
                'HILIFE_RETURN_ORDER' => Url::HILIFE_RETURN_ORDER,
                'FAMILY_RETURN_ORDER' => Url::FAMILY_RETURN_ORDER,
                'FAMILY_RETURN_CHECK' => Url::FAMILY_RETURN_CHECK,
                'UNIMART_UPDATE_LOGISTICS_INFO' => Url::UNIMART_UPDATE_LOGISTICS_INFO,
                'UNIMART_UPDATE_STORE_INFO' => Url::UNIMART_UPDATE_STORE_INFO,
                'UNIMART_CANCEL_LOGISTICS_ORDER' => Url::UNIMART_CANCEL_LOGISTICS_ORDER,
                'QUERY_LOGISTICS_INFO' => Url::QUERY_LOGISTICS_INFO,
                'PRINT_TRADE_DOC' => Url::PRINT_TRADE_DOC,
                'PRINT_UNIMART_C2C_BILL' => Url::PRINT_UNIMART_C2C_BILL,
                'PRINT_FAMILY_C2C_BILL' => Url::PRINT_FAMILY_C2C_BILL,
                'Print_HILIFE_C2C_BILL' => Url::Print_HILIFE_C2C_BILL,
                'CREATE_TEST_DATA' => Url::CREATE_TEST_DATA,
            ];
        }

        return $UrlList[$FunctionType];
    }

    /**
     *  加入換行字元
     *
     * @param     string    $Content    內容
     * @return    string
     */
    public function AddNextLine($Content)
    {
        return $Content . PHP_EOL;
    }

    /**
     *  產生自動/手動 POST 提交表單
     *
     * @param     string    $ButtonDesc    按鈕顯示名稱
     * @param     string    $Target        表單 action 目標
     * @return    string
     */
    public function GenPostHTML($ButtonDesc = '', $Target = '_self')
    {
        $PostHTML = $this->AddNextLine('<div style="text-align:center;">');
        $PostHTML .= $this->AddNextLine('  <form id="ECPayForm" method="POST" action="' . $this->ServiceURL . '" target="' . $Target . '">');
        foreach ($this->PostParams as $Name => $Value) {
            $PostHTML .= $this->AddNextLine('    <input type="hidden" name="' . $Name . '" value="' . $Value . '" />');
        }
        if (!empty($ButtonDesc)) {
            // 手動
            $PostHTML .= $this->AddNextLine('    <input type="submit" id="__paymentButton" value="' . $ButtonDesc . '" />');
        } else {
            // 自動
            $PostHTML .= $this->AddNextLine('    <script>document.getElementById("ECPayForm").submit();</script>');
        }
        $PostHTML .= $this->AddNextLine('  </form>');
        $PostHTML .= $this->AddNextLine('</div>');

        return $PostHTML;
    }

    /**
     *  依編碼方式取得字串長度
     *
     * @param     string    $RetriveString    字串內容
     * @param     string    $Encode           字串編碼
     * @return    integer
     */
    public function StringLength($RetriveString, $Encode)
    {
        return mb_strlen($RetriveString, $Encode);
    }

    /**
     *  解析 ECPay 回傳結果
     *
     * @param     string    $Feedback        回傳結果
     * @param     array     $FeedbackList    合法回傳參數
     * @param     string    $Separator       分隔符號
     * @return    array
     */
    public function ParseFeedback($Feedback, $FeedbackList = ['RtnCode', 'RtnMsg'], $Separator = '|')
    {
        $Pieces = explode($Separator, $Feedback);
        $Parsed = [];
        // 回傳參數檢查
        if (count($Pieces) == count($FeedbackList)) {
            foreach ($FeedbackList as $Idx => $Name) {
                $Parsed[$Name] = $Pieces[$Idx];
            }
        } else {
            $Parsed['Error'] = 'Unknown feedback : ' . $Feedback;
        }
        return $Parsed;
    }

    /**
     * Server Post
     *
     * @param     array    $Params        Post 參數
     * @param     string   $ServiceURL    Post URL
     * @return    void
     */
    public static function ServerPost($Params ,$ServiceURL)
    {

        $SendInfo = '' ;

        // 組合字串
        foreach ($Params as $Key => $Value) {
            if ( $SendInfo == '') {
                $SendInfo .= $Key . '=' . $Value ;
            } else {
                $SendInfo .= '&' . $Key . '=' . $Value ;
            }
        }

        $Ch = curl_init();

        if (false === $Ch) {
            throw new Exception('curl failed to initialize');
        }

        curl_setopt($Ch, CURLOPT_URL, $ServiceURL);
        curl_setopt($Ch, CURLOPT_HEADER, false);
        curl_setopt($Ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($Ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($Ch, CURLOPT_POST, true);
        curl_setopt($Ch, CURLOPT_POSTFIELDS, $SendInfo);
        $Result = curl_exec($Ch);

        if (false === $Result) {
            throw new Exception(curl_error($Ch), curl_errno($Ch));
        }

        curl_close($Ch);

        return $Result;
    }

    /**
     * 產生檢查碼
     *
     * @param     array    $Params     產生檢查碼用參數
     * @param     string   $HashKey    HashKey
     * @param     string   $HashIV     HashIV
     * @return    string
     */
    public static function GenerateCheckMacValue($Params = [], $HashKey = '', $HashIV = '')
    {
        $MacValue = '' ;

        if(isset($Params)){

            unset($Params['CheckMacValue']);
            uksort($Params, ['self', 'self::MerchantSort']);

            // 組合字串
            $MacValue = 'HashKey=' . $HashKey ;
            foreach($Params as $key => $Value) {
                $MacValue .= '&' . $key . '=' . $Value ;
            }
            $MacValue .= '&HashIV=' . $HashIV ;

            // URL Encode編碼
            $MacValue = urlencode($MacValue);

            // 轉成小寫
            $MacValue = strtolower($MacValue);

            // 取代為與 dotNet 相符的字元
            $MacValue = self::ReplaceSymbol($MacValue);

            // 編碼
            $MacValue = md5($MacValue);

            $MacValue = strtoupper($MacValue);
        }

        return $MacValue ;
    }

    /**
     * 自訂排序使用
     * @param     string   $Current    目前資料
     * @param     string   $Next       下一筆資料
     */
    public static function MerchantSort($Current, $Next)
    {
        return strcasecmp($Current, $Next);
    }

    /**
     * 參數內特殊字元取代
     * @param     string   $Target    取代目標
     *  @return    string
     */
    public static function ReplaceSymbol($Target)
    {
        $Replaced = '';
        if(!empty($Target)) {
            $SearchList = ['%2d', '%5f', '%2e', '%21', '%2a', '%28', '%29'];
            $ReplaceList = ['-', '_', '.', '!', '*' , '(', ')'];
            $Replaced = str_replace($SearchList, $ReplaceList, $Target);
        }

        return $Replaced ;
    }
}
