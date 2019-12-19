<?php
    // 取消訂單(統一超商C2C)
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = '5294y06JbISpM5x9';
        $AL->HashIV = 'v77hoKGq4kWxNNIS';
        $AL->Send = [
            'MerchantID' => '2000132',
            'AllPayLogisticsID' => '15474',
            'CVSPaymentNo' => 'F0015091',
            'CVSValidationNo' => '3207',
            'PlatformID' => ''
        ];
        // CancelUnimartLogisticsOrder()
        $Result = $AL->CancelUnimartLogisticsOrder();
        echo '<pre>' . print_r($Result, true) . '</pre>';
    } catch(Exception $e) {
        echo $e->getMessage();
    }
