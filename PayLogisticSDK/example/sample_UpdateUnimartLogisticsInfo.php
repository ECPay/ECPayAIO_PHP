<?php
    // 廠商修改物流資訊(統一超商B2C)
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = '5294y06JbISpM5x9';
        $AL->HashIV = 'v77hoKGq4kWxNNIS';
        $AL->Send = [
            'MerchantID' => '2000132',
            'AllPayLogisticsID' => '15627',
            'ShipmentDate' => date('Y/m/d', strtotime('+1 day')),
            'ReceiverStoreID' => '991182',
            'PlatformID' => ''
        ];
        // UpdateUnimartLogisticsInfo()
        $Result = $AL->UpdateUnimartLogisticsInfo();
        echo '<pre>' . print_r($Result, true) . '</pre>';
    } catch(Exception $e) {
        echo $e->getMessage();
    }
