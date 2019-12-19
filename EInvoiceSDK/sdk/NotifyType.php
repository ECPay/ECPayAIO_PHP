<?php

namespace ECPay\Invoice;

// 發送方式
abstract class NotifyType
{
    // 簡訊通知
    const Sms = 'S';

    // 電子郵件通知
    const Email = 'E';

    // 皆通知
    const All = 'A';
}
