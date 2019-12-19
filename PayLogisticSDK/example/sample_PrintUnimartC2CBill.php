<?php
    // 列印繳款單(統一超商C2C)
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = 'XBERn1YOvpM9nfZc';
        $AL->HashIV = 'h1ONHk4P4yqbl5LK';
        $AL->Send = [
            'MerchantID' => '2000933',
            'AllPayLogisticsID' => '11808',
            'CVSPaymentNo' => 'F0015102',
            'CVSValidationNo' => '4130',
            'PlatformID' => ''
        ];
        // PrintUnimartC2CBill(Button名稱, Form target)
        $html = $AL->PrintUnimartC2CBill('列印繳款單(統一超商C2C)');
        echo $html;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
