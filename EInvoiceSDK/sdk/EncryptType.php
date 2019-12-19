<?php

namespace ECPay\Invoice;

abstract class EncryptType
{
    // MD5(預設)
    const ENC_MD5 = 0;

    // SHA256
    const ENC_SHA256 = 1;
}