<?php

namespace ECPay\Invoice;

abstract class NotifiedType
{
    // 通知客戶
    const Customer = 'C';

    // 通知廠商
    const vendor = 'M';

    // 皆發送
    const All = 'A';
}