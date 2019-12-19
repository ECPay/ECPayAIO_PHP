<?php
    // 萊爾富列印小白單(萊爾富超商C2C)
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = 'XBERn1YOvpM9nfZc';
        $AL->HashIV = 'h1ONHk4P4yqbl5LK';
        $AL->Send = [
            'MerchantID' => '2000933',
            'AllPayLogisticsID' => '45936',
            'CVSPaymentNo' => '01600045936',
            'PlatformID' => ''
        ];
        // PrintHiLifeC2CBill(Button名稱, Form target)
        $html = $AL->PrintHiLifeC2CBill('萊爾富列印小白單(萊爾富超商C2C)');
        echo $html;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
