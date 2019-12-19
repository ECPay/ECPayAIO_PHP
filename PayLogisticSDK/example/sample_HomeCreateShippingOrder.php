<?php
    // 宅配物流訂單幕前建立
    define('HOME_URL', 'http://www.sample.com.tw/logistics_dev');
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = '5294y06JbISpM5x9';
        $AL->HashIV = 'v77hoKGq4kWxNNIS';
        $AL->Send = array(
            'MerchantID' => '2000132',
            'MerchantTradeNo' => 'no' . date('YmdHis'),
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'LogisticsType' => EcpayLogisticsType::HOME,
            'LogisticsSubType' => EcpayLogisticsSubType::TCAT,
            'GoodsAmount' => 1500,
            'CollectionAmount' => 10,
            'IsCollection' => EcpayIsCollection::NO,
            'GoodsName' => '測試商品',
            'SenderName' => '測試寄件者',
            'SenderPhone' => '0226550115',
            'SenderCellPhone' => '0911222333',
            'ReceiverName' => '測試收件者',
            'ReceiverPhone' => '0226550115',
            'ReceiverCellPhone' => '0933222111',
            'ReceiverEmail' => 'test_emjhdAJr@test.com.tw',
            'TradeDesc' => '測試交易敘述',
            'ServerReplyURL' => HOME_URL . '/ServerReplyURL.php',
            'ClientReplyURL' => HOME_URL . '/ClientReplyURL.php',
            'LogisticsC2CReplyURL' => HOME_URL . '/LogisticsC2CReplyURL.php',
            'Remark' => '測試備註',
            'PlatformID' => '',
        );

        $AL->SendExtend = array(
            'SenderZipCode' => '11560',
            'SenderAddress' => '台北市南港區三重路19-2號10樓D棟',
            'ReceiverZipCode' => '11560',
            'ReceiverAddress' => '台北市南港區三重路19-2號5樓D棟',
            'Temperature' => EcpayTemperature::FREEZE,
            'Distance' => EcpayDistance::SAME,
            'Specification' => EcpaySpecification::CM_120,
            'ScheduledDeliveryTime' => EcpayScheduledDeliveryTime::TIME_17_20
        );
        // CreateShippingOrder(Button名稱, Form target)
        $html = $AL->CreateShippingOrder('宅配物流訂單建立');
        echo $html;
    } catch(Exception $e) {
        echo $e->getMessage();
    }

