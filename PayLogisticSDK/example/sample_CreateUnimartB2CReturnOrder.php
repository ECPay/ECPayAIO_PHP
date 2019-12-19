<?php
    // 超商取貨逆物流訂單(統一超商B2C)
    define('HOME_URL', 'http://www.sample.com.tw/logistics_dev');
    
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = '5294y06JbISpM5x9';
        $AL->HashIV = 'v77hoKGq4kWxNNIS';
        $AL->Send = array(
            'MerchantID' => '2000132',
            'AllPayLogisticsID' => '15624',
            'ServerReplyURL' => HOME_URL . '/ServerReplyURL.php',
            'GoodsName' => '測試商品A#測試商品B',
            'GoodsAmount' => 1500,
            'SenderName' => '測試寄件者',
            'SenderPhone' => '0226550115',
            'Remark' => '測試備註',
            'Quantity' => '1#2',
            'Cost' => '100#700',
            'PlatformID' => '',
        );
        // CreateUnimartB2CReturnOrder()
        $Result = $AL->CreateUnimartB2CReturnOrder();
        echo '<pre>' . print_r($Result, true) . '</pre>';
    } catch(Exception $e) {
        echo $e->getMessage();
    }
