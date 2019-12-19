<?php
    // 更新門市(統一超商C2C)
    require('Ecpay.Logistic.Integration.php');
    try {
        $AL = new EcpayLogistics();
        $AL->HashKey = 'XBERn1YOvpM9nfZc';
        $AL->HashIV = 'h1ONHk4P4yqbl5LK';
        $AL->Send = array(
            'MerchantID' => '2000933',
            'AllPayLogisticsID' => '11796',
            'CVSPaymentNo' => 'F0015091',
            'CVSValidationNo' => '3207',
            'StoreType' => EcpayStoreType::RECIVE_STORE,
            'ReceiverStoreID' => '991183',
            'PlatformID' => ''
        );
        // UpdateUnimartStore()
        $Result = $AL->UpdateUnimartStore();
        echo '<pre>' . print_r($Result, true) . '</pre>';
    } catch(Exception $e) {
        echo $e->getMessage();
    }
