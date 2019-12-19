<?php

namespace ECPay\ApplePay;

class FundingReconDetail extends IO
{
    static function CheckOut($target = '_self', $arParameters = [], $HashKey='', $HashIV='', $ServiceURL=''){
        //產生檢查碼

        $szCheckMacValue = CheckMacValue::generate($arParameters, $HashKey, $HashIV);

        //生成表單，自動送出
        $szHtml =  '<!DOCTYPE html>';
        $szHtml .= '<html>';
        $szHtml .=     '<head>';
        $szHtml .=         '<meta charset="utf-8">';
        $szHtml .=     '</head>';
        $szHtml .=     '<body>';
        $szHtml .=         "<form id=\"__ecpayForm\" method=\"post\" target=\"{$target}\" action=\"{$ServiceURL}\">";

        foreach ($arParameters as $keys => $value) {
            $szHtml .=         "<input type=\"hidden\" name=\"{$keys}\" value='{$value}' />";
        }

        $szHtml .=             "<input type=\"hidden\" name=\"CheckMacValue\" value=\"{$szCheckMacValue}\" />";
        $szHtml .=         '</form>';
        $szHtml .=         '<script type="text/javascript">document.getElementById("__ecpayForm").submit();</script>';
        $szHtml .=     '</body>';
        $szHtml .= '</html>';

        echo $szHtml ;
        exit;
    }
}
