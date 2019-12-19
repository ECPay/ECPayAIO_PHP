<?php

namespace ECPay\ApplePay;

class DoAction extends IO
{
    static function CheckOut($arParameters = [], $HashKey ='', $HashIV ='', $ServiceURL = ''){

        // 變數宣告。
        $arErrors = [];
        $arFeedback = [];

        //產生驗證碼
        $szCheckMacValue = CheckMacValue::generate($arParameters,$HashKey,$HashIV);
        $arParameters['CheckMacValue'] = $szCheckMacValue;

        // 送出查詢並取回結果。
        $szResult = self::ServerPost($arParameters,$ServiceURL);

        // 轉結果為陣列。
        parse_str($szResult, $arResult);
        // 重新整理回傳參數。
        foreach ($arResult as $keys => $value) {
            if ($keys == 'CheckMacValue') {
                $szCheckMacValue = $value;
            } else {
                $arFeedback[$keys] = $value;
            }
        }

        if (array_key_exists('RtnCode', $arFeedback) && $arFeedback['RtnCode'] != '1') {
            array_push($arErrors, vsprintf('#%s: %s', [$arFeedback['RtnCode'], $arFeedback['RtnMsg']]));
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback ;

    }
}
