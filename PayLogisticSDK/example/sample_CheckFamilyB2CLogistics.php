<?php
    // 全家逆物流核帳(全家超商B2C)
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = '5294y06JbISpM5x9';
        $AL->HashIV = 'v77hoKGq4kWxNNIS';
        $AL->Send = array(
            'MerchantID' => '2000132',
            'RtnMerchantTradeNo' => '1601121637065',
            'PlatformID' => ''
        );
        // CheckFamilyB2CLogistics()
        $Result = $AL->CheckFamilyB2CLogistics();
        echo '<pre>' . print_r($Result, true) . '</pre>';
    } catch(Exception $e) {
        echo $e->getMessage();
    }
