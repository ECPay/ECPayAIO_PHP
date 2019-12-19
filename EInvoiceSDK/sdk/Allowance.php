<?php

namespace ECPay\Invoice;

use Exception;

/**
 *  C開立折讓
 */
class Allowance
{
    // 所需參數
    public $parameters = [
        'TimeStamp' => '',
        'MerchantID' => '',
        'CustomerName' => '',
        'Items' => [],
        'ItemName' => '',
        'ItemCount' => '',
        'ItemWord' => '',
        'ItemPrice' => '',
        'ItemTaxType' => '',
        'ItemAmount' => '',
        'CheckMacValue' => '',
        'InvoiceNo' => '',
        'AllowanceNotify' => '',
        'NotifyMail' => '',
        'NotifyPhone' => '',
        'AllowanceAmount' => ''
    ];

    // 需要做urlencode的參數
    public $urlencode_field = [
        'CustomerName' => '',
        'NotifyMail' => '',
        'ItemName' => '',
        'ItemWord' => ''
    ];

    // 不需要送壓碼的欄位
    public $none_verification = [
        'ItemName' => '',
        'ItemWord' => '',
        'CheckMacValue' => ''
    ];

    /**
     * 1寫入參數
     */
    function insert_string($arParameters = [])
    {

        $nItems_Count_Total = 0;
        $nItems_Foreach_Count = 1;
        $sItemName = '';
        $sItemCount = '';
        $sItemWord = '';
        $sItemPrice = '';
        $sItemTaxType = '';
        $sItemAmount = '';
        $sItemRemark = '';

        foreach ($this->parameters as $key => $value) {
            if (isset($arParameters[$key])) {
                $this->parameters[$key] = $arParameters[$key];
            }
        }

        // 商品資訊組合
        $nItems_Count_Total = count($arParameters['Items']);    // 商品總筆數

        if ($nItems_Count_Total != 0) {
            foreach ($arParameters['Items'] as $key2 => $value2) {
                $sItemName .= (isset($value2['ItemName'])) ? $value2['ItemName'] : '';
                $sItemCount .= (int)$value2['ItemCount'];
                $sItemWord .= (isset($value2['ItemWord'])) ? $value2['ItemWord'] : '';
                $sItemPrice .= $value2['ItemPrice'];
                $sItemTaxType .= (isset($value2['ItemTaxType'])) ? $value2['ItemTaxType'] : '';
                $sItemAmount .= $value2['ItemAmount'];

                if ($nItems_Foreach_Count < $nItems_Count_Total) {
                    $sItemName .= '|';
                    $sItemCount .= '|';
                    $sItemWord .= '|';
                    $sItemPrice .= '|';
                    $sItemTaxType .= '|';
                    $sItemAmount .= '|';
                }

                $nItems_Foreach_Count++;
            }
        }

        $this->parameters['ItemName'] = $sItemName;        // 商品名稱
        $this->parameters['ItemCount'] = $sItemCount;
        $this->parameters['ItemWord'] = $sItemWord;        // 商品單位
        $this->parameters['ItemPrice'] = $sItemPrice;
        $this->parameters['ItemTaxType'] = $sItemTaxType;
        $this->parameters['ItemAmount'] = $sItemAmount;

        return $this->parameters;
    }

    /**
     * 2-2 驗證參數格式
     */
    function check_extend_string($arParameters = [])
    {

        $arErrors = [];
        $nCheck_Amount = 0;    // 驗證總金額

        // 7.客戶名稱 CustomerName
        // x僅能為中英數字格式
        // *預設最大長度為30碼
        if (mb_strlen($arParameters['CustomerName'], 'UTF-8') > 30) {
            array_push($arErrors, '7:CustomerName max length as 30.');
        }

        // 20.21.22.23.24.25. 商品資訊

        // *不可為空
        if (sizeof($arParameters['Items']) == 0) {
            array_push($arErrors, '20-25:Items is required.');
        } else {
            // 檢查是否存在保留字元 '|'
            $bFind_Tag = true;
            $bError_Tag = false;

            foreach ($arParameters['Items'] as $key => $value) {
                $bFind_Tag = strpos($value['ItemName'], '|');
                if ($bFind_Tag != false || empty($value['ItemName'])) {
                    $bError_Tag = true;
                    array_push($arErrors, '20:Invalid ItemName.');
                    break;
                }

                $bFind_Tag = strpos($value['ItemCount'], '|');
                if ($bFind_Tag != false || empty($value['ItemCount'])) {
                    $bError_Tag = true;
                    array_push($arErrors, '21:Invalid ItemCount.');
                    break;
                }

                $bFind_Tag = strpos($value['ItemWord'], '|');
                if ($bFind_Tag != false || empty($value['ItemWord'])) {
                    $bError_Tag = true;
                    array_push($arErrors, '22:Invalid ItemWord.');
                    break;
                }

                $bFind_Tag = strpos($value['ItemPrice'], '|');
                if ($bFind_Tag != false || empty($value['ItemPrice'])) {
                    $bError_Tag = true;
                    array_push($arErrors, '23:Invalid ItemPrice.');
                    break;
                }

                $bFind_Tag = strpos($value['ItemTaxType'], '|');
                if ($bFind_Tag != false || empty($value['ItemTaxType'])) {
                    $bError_Tag = true;
                    array_push($arErrors, '24:Invalid ItemTaxType.');
                    break;
                }

                $bFind_Tag = strpos($value['ItemAmount'], '|');
                if ($bFind_Tag != false || empty($value['ItemAmount'])) {
                    $bError_Tag = true;
                    array_push($arErrors, '25:Invalid ItemAmount.');
                    break;
                }
            }

            // 檢查商品格式
            if (!$bError_Tag) {
                foreach ($arParameters['Items'] as $key => $value) {
                    // *ItemCount數字判斷
                    if (!preg_match('/^[0-9]*$/', $value['ItemCount'])) {
                        array_push($arErrors, '21:Invalid ItemCount.');
                    }

                    // *ItemWord 預設最大長度為6碼
                    if (strlen($value['ItemWord']) > 6) {
                        array_push($arErrors, '22:ItemWord max length as 6.');
                    }

                    // *ItemPrice數字判斷
                    if (!preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemPrice'])) {
                        array_push($arErrors, '23:Invalid ItemPrice.');
                    }

                    // *ItemAmount數字判斷
                    if (!preg_match('/(^[-0-9]*$)|([0-9]+\.[0-9]+)/', $value['ItemAmount'])) {
                        array_push($arErrors, '25:Invalid ItemAmount.');
                    } else {
                        $nCheck_Amount = $nCheck_Amount + $value['ItemAmount'];
                    }
                }

                // *檢查商品總金額
                if ($arParameters['AllowanceAmount'] != round($nCheck_Amount)) {
                    array_push($arErrors, '41:Invalid AllowanceAmount.');
                }
            }
        }

        // 37.發票號碼 InvoiceNo

        // *必填項目
        if (strlen($arParameters['InvoiceNo']) == 0) {
            array_push($arErrors, '37:InvoiceNo is required.');
        }
        // *預設長度固定10碼
        if (strlen($arParameters['InvoiceNo']) != 10) {
            array_push($arErrors, '37:InvoiceNo length as 10.');
        }

        // 38.通知類別 AllowanceNotify

        // *固定給定下述預設值
        if (($arParameters['AllowanceNotify'] != AllowanceNotifyType::Sms) && ($arParameters['AllowanceNotify'] != AllowanceNotifyType::Email) && ($arParameters['AllowanceNotify'] != AllowanceNotifyType::All) && ($arParameters['AllowanceNotify'] != AllowanceNotifyType::None)) {
            array_push($arErrors, '38:Invalid AllowanceNotifyType.');
        }

        // 39.通知電子信箱 NotifyMail

        // *若客戶電子信箱有值時，則格式僅能為Email的標準格式
        if (strlen($arParameters['NotifyMail']) > 0) {
            if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is', $arParameters['NotifyMail'])) {
                array_push($arErrors, '39:Invalid Email Format.');
            }
        }
        // *下述情況通知電子信箱不可為空值(通知類別為E-電子郵件)
        if ($arParameters['AllowanceNotify'] == AllowanceNotifyType::Email && strlen($arParameters['NotifyMail']) == 0) {
            array_push($arErrors, '39:NotifyMail is required.');
        }

        // 40.通知手機號碼 NotifyPhone
        // *若客戶手機號碼有值時，則預設格式為數字組成
        if (strlen($arParameters['NotifyPhone']) > 0) {
            if (!preg_match('/^[0-9]*$/', $arParameters['NotifyPhone'])) {
                array_push($arErrors, '40:Invalid NotifyPhone.');
            }
        }
        // * 最大20字元
        if (strlen($arParameters['NotifyPhone']) > 20) {
            array_push($arErrors, '40:NotifyPhone max length as 20.');
        }
        // *下述情況通知手機號碼不可為空值(通知類別為S-簡訊)
        if ($arParameters['AllowanceNotify'] == AllowanceNotifyType::Sms && strlen($arParameters['NotifyPhone']) == 0) {
            array_push($arErrors, '40:NotifyPhone is required.');
        }

        // 39-40 通知電子信箱、通知手機號碼不能全為空值 (如果狀態為SMS 或 EMAIL)
        if (strlen($arParameters['NotifyPhone']) == 0 && strlen($arParameters['NotifyMail']) == 0 && ($arParameters['AllowanceNotify'] == AllowanceNotifyType::Sms || $arParameters['AllowanceNotify'] == AllowanceNotifyType::Email)) {
            array_push($arErrors, '39-40:NotifyMail or NotifyPhone is required.');
        } else {
            // *下述情況通知手機號碼與電子信箱不可為空值(通知類別為A-皆通知)
            if ($arParameters['AllowanceNotify'] == AllowanceNotifyType::All && (strlen($arParameters['NotifyMail']) == 0 || strlen($arParameters['NotifyPhone']) == 0)) {
                array_push($arErrors, '39-40:NotifyMail And NotifyPhone is required.');
            }

            // *下述情況通知手機號碼與電子信箱為空值(通知類別為N-皆不通知)
            if ($arParameters['AllowanceNotify'] == AllowanceNotifyType::None && (strlen($arParameters['NotifyMail']) > 0 || strlen($arParameters['NotifyPhone']) > 0)) {
                array_push($arErrors, '39-40:Please remove NotifyMail And NotifyPhone.');
            }
        }

        // 41.折讓單總金額 AllowanceAmount

        // *必填項目
        if (strlen($arParameters['AllowanceAmount']) == 0) {
            array_push($arErrors, '41:AllowanceAmount is required.');
        } else {
            // *含稅總金額
            $arParameters['AllowanceAmount'] = $arParameters['AllowanceAmount'];
        }

        if (sizeof($arErrors) > 0) throw new Exception(join('<br>', $arErrors));

        // 刪除items 
        unset($arParameters['Items']);

        return $arParameters;
    }

    /**
     * 4欄位例外處理方式(送壓碼前)
     */
    function check_exception($arParameters = [])
    {

        return $arParameters;
    }
}