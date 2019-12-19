<?php
    // 物流訂單查詢
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = '5294y06JbISpM5x9';
        $AL->HashIV = 'v77hoKGq4kWxNNIS';
        $AL->Send = [
            'MerchantID' => '2000132',
            'AllPayLogisticsID' => '14559',
            'PlatformID' => ''
        ];
        // QueryLogisticsInfo()
        $Result = $AL->QueryLogisticsInfo();
        echo '<pre>' . print_r($Result, true) . '</pre>';
    } catch(Exception $e) {
        echo $e->getMessage();
    }
