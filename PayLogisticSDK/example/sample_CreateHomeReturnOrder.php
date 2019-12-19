<?php
    // 宅配逆物流訂單建立
    define('HOME_URL', 'http://www.sample.com.tw/logistics_dev');
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = '5294y06JbISpM5x9';
        $AL->HashIV = 'v77hoKGq4kWxNNIS';
        $AL->Send = [
            'MerchantID' => '2000132',
            'AllPayLogisticsID' => '15609',
			'LogisticsSubType' => EcpayLogisticsSubType::TCAT,
            'SenderName' => '測試寄件者',
            'SenderPhone' => '0226550115',
            'SenderCellPhone' => '0933222111',
            'SenderZipCode' => '11560',
            'SenderAddress' => '台北市南港區三重路19-2號5樓D棟',
            'ReceiverName' => '測試收件者',
            'ReceiverPhone' => '0226550116',
            'ReceiverCellPhone' => '0911222333',
            'ReceiverEmail' => 'test_emjhdAJr@test.com.tw',
            'ReceiverZipCode' => '11560',
            'ReceiverAddress' => '台北市南港區三重路19-2號5樓D棟',
            'ServerReplyURL' => HOME_URL . '/ServerReplyURL.php',
			'GoodsAmount' => 1,
            'PlatformID' => '',
        ];
        // CreateHomeReturnOrder()
        $Result = $AL->CreateHomeReturnOrder();
        echo '<pre>' . print_r($Result, true) . '</pre>';
    } catch(Exception $e) {
        echo $e->getMessage();
    }
