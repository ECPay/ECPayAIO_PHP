<?php

namespace ECPay;

class FundingReconDetail extends Aio
{
    static function CheckOut($target = '_self',$arParameters = [],$HashKey='',$HashIV='',$ServiceURL=''){
        //產生檢查碼
        $EncryptType = $arParameters['EncryptType'];
        unset($arParameters['EncryptType']);

        $szCheckMacValue = CheckMacValue::generate($arParameters,$HashKey,$HashIV,$EncryptType);

        //生成表單，自動送出
        $szHtml = parent::HtmlEncode($target, $arParameters, $ServiceURL, $szCheckMacValue, '') ;
        echo $szHtml ;
        exit;
    }
}
