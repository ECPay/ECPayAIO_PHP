<?php

namespace ECPay\ApplePay;

use Exception;

class QueryTradeInfo extends IO
{
    static function CheckOut($arParameters = [], $HashKey ='', $HashIV ='', $ServiceURL = ''){

        $arErrors = [];
        $arParameters['TimeStamp'] = time();
        $arFeedback = [];
        $arConfirmArgs = [];

        // 呼叫查詢。
        if (sizeof($arErrors) == 0)
        {
            $arParameters['CheckMacValue'] = CheckMacValue::generate($arParameters, $HashKey, $HashIV);

            // 送出查詢並取回結果。
            $szResult = parent::ServerPost($arParameters, $ServiceURL);
            $szResult = str_replace(' ', '%20', $szResult);
            $szResult = str_replace('+', '%2B', $szResult);

            // 轉結果為陣列。
            parse_str($szResult, $arResult);

            // 重新整理回傳參數。
            foreach ($arResult as $keys => $value) {
                if ($keys == 'CheckMacValue') {
                    $szCheckMacValue = $value;
                } else {
                    $arFeedback[$keys] = $value;
                    $arConfirmArgs[$keys] = $value;
                }
            }

            // 驗證檢查碼。
            if (sizeof($arFeedback) > 0)
            {
                $szConfirmMacValue = CheckMacValue::generate($arConfirmArgs, $HashKey, $HashIV);

                if ($szCheckMacValue != $szConfirmMacValue)
                {
                    array_push($arErrors, 'CheckMacValue verify fail.');
                }
            }
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback ;

    }
}
