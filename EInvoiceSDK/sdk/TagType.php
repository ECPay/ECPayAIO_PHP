<?php

namespace ECPay\Invoice;

abstract class TagType
{
    // 發票開立
    const Invoice = 'I';

    // 發票作廢
    const Invoice_Void = 'II';

    // 折讓開立
    const Allowance = 'A';

    // 折讓作廢
    const Allowance_Void = 'AI';

    // 發票中獎
    const Invoice_Winning = 'AW';
}