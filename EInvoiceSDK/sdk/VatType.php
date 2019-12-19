<?php

namespace ECPay\Invoice;

abstract class VatType
{
    // 商品單價含稅價
    const Yes = '1';

    // 商品單價未稅價
    const No = '0';
}
