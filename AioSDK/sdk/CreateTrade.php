<?php

namespace ECPay;

use Exception;

class CreateTrade extends Aio
{
    //付款方式物件
    public static $PaymentObj ;

    protected static function process($arParameters = [],$arExtend = [])
    {
        //宣告付款方式物件
        $PaymentMethod    = 'ECPay_'.$arParameters['ChoosePayment'];
        self::$PaymentObj = new $PaymentMethod;

        //檢查參數
        $arParameters = self::$PaymentObj->check_string($arParameters);

        //檢查商品
        $arParameters = self::$PaymentObj->check_goods($arParameters);

        //檢查各付款方式的額外參數&電子發票參數
        $arExtend = self::$PaymentObj->check_extend_string($arExtend,$arParameters['InvoiceMark']);

        //過濾
        $arExtend = self::$PaymentObj->filter_string($arExtend,$arParameters['InvoiceMark']);

        //合併共同參數及延伸參數
        return array_merge($arParameters,$arExtend) ;
    }

    static function CheckOut($arParameters = [],$arExtend = [],$HashKey='',$HashIV='',$ServiceURL=''){

        $arErrors   = [];
        $arFeedback = [];
        $szCheckMacValueReturn = '' ;

        $arParameters = self::process($arParameters,$arExtend);

        //產生檢查碼
        $szCheckMacValue = CheckMacValue::generate($arParameters,$HashKey,$HashIV,$arParameters['EncryptType']);
        $arParameters['CheckMacValue'] = $szCheckMacValue;

        // 送出查詢並取回結果。
        $szResult = static::ServerPost($arParameters,$ServiceURL);

        // 轉結果為陣列。
        $arResult = json_decode($szResult,true);

        // 重新整理回傳參數。
        foreach ($arResult as $keys => $value) {
            if ($keys == 'CheckMacValue') {
                $szCheckMacValueReturn = $value;
            } else {
                $arFeedback[$keys] = $value;
            }
        }

        if (array_key_exists('RtnCode', $arFeedback) && $arFeedback['RtnCode'] != '1') {
            array_push($arErrors, vsprintf('#%s: %s', [$arFeedback['RtnCode'], $arFeedback['RtnMsg']]));
        }
        else{
            // 參數取回壓碼驗證
            $szCheckMacValueReturnParameters = CheckMacValue::generate($arFeedback,$HashKey,$HashIV,$arParameters['EncryptType']);

            if($szCheckMacValueReturnParameters != $szCheckMacValueReturn){
                array_push($arErrors, 'CheckMacValue verify fail.');
            }
        }

        if (sizeof($arErrors) > 0) {
            throw new Exception(join('- ', $arErrors));
        }

        return $arFeedback ;
    }
}
