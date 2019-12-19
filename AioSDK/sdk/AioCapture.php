<?php

namespace ECPay;

use Exception;

class AioCapture extends Aio
{
    static function Capture($arParameters=[],$HashKey='',$HashIV='',$ServiceURL=''){

        $arErrors   = [];
        $arFeedback = [];

        $EncryptType = $arParameters['EncryptType'];
        unset($arParameters['EncryptType']);

        $szCheckMacValue = CheckMacValue::generate($arParameters,$HashKey,$HashIV,$EncryptType);
        $arParameters['CheckMacValue'] = $szCheckMacValue;

        // 送出查詢並取回結果。
        $szResult = static::ServerPost($arParameters,$ServiceURL);

        // 轉結果為陣列。
        parse_str($szResult, $arResult);

        // 重新整理回傳參數。
        foreach ($arResult as $keys => $value) {
            $arFeedback[$keys] = $value;
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback;

    }
}
