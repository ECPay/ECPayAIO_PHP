<?php
    // 全家列印小白單(全家超商C2C)
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = 'XBERn1YOvpM9nfZc';
        $AL->HashIV = 'h1ONHk4P4yqbl5LK';
        $AL->Send = array(
            'MerchantID' => '2000933',
            'AllPayLogisticsID' => '11810',
            'CVSPaymentNo' => '05902347158',
            'PlatformID' => ''
        );
        // PrintFamilyC2CBill(Button名稱, Form target)
        $html = $AL->PrintFamilyC2CBill('全家列印小白單(全家超商C2C)');
        echo $html;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
