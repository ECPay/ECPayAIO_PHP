<?php

namespace ECPay\Invoice;

abstract class Method
{
    // 一般開立發票。
    const INVOICE = 'INVOICE';

    // 延遲或觸發開立發票。
    const INVOICE_DELAY = 'INVOICE_DELAY';

    // 開立折讓。
    const ALLOWANCE = 'ALLOWANCE';

    // 發票作廢。
    const INVOICE_VOID = 'INVOICE_VOID';

    // 折讓作廢。
    const ALLOWANCE_VOID = 'ALLOWANCE_VOID';

    // 查詢發票。
    const INVOICE_SEARCH = 'INVOICE_SEARCH';

    // 查詢作廢發票。
    const INVOICE_VOID_SEARCH = 'INVOICE_VOID_SEARCH';

    // 查詢折讓明細。
    const ALLOWANCE_SEARCH = 'ALLOWANCE_SEARCH';

    // 查詢折讓作廢明細。
    const ALLOWANCE_VOID_SEARCH = 'ALLOWANCE_VOID_SEARCH';

    // 發送通知。
    const INVOICE_NOTIFY = 'INVOICE_NOTIFY';

    // 付款完成觸發或延遲開立發票。
    const INVOICE_TRIGGER = 'INVOICE_TRIGGER';

    // 手機條碼驗證。
    const CHECK_MOBILE_BARCODE = 'CHECK_MOBILE_BARCODE';

    // 愛心碼驗證。
    const CHECK_LOVE_CODE = 'CHECK_LOVE_CODE';
}
