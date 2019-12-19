<?php

namespace ECPay\Invoice;

// 通知類別
abstract class AllowanceNotifyType
{
    // 簡訊通知
    const Sms = 'S';

    // 電子郵件通知
    const Email = 'E';

    // 皆通知
    const All = 'A';

    // 皆不通知
    const None = 'N';
}