<?php

namespace ECPay\ApplePay;

class Button extends IO{

    public function generate($aApplepay_button = []){

        // 載入CSS
        echo '<link rel="stylesheet" type="text/css" media="screen" href="applepay_button.css">' ;

        // 載入javascript
        echo '<script src="jquery-1.11.1.js" type="text/javascript"></script>' ;

        // 傳送變數到javascript
        echo '<script type="text/javascript">' ;
        echo '/*' . '<![CDATA[ */';
        echo 'var apple_pay_params = ' . json_encode($aApplepay_button);
        echo '/*'.' ]]> */';
        echo '</script>';

        echo '<script src="applepay_button.js" type="text/javascript"></script>';
    }
}
