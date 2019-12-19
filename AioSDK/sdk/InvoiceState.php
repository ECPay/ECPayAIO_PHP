<?php

namespace ECPay;

abstract class InvoiceState {
    /**
     * 需要開立電子發票。
     */
    const Yes = 'Y';

    /**
     * 不需要開立電子發票。
     */
    const No = '';
}
