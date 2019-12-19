<?php

namespace ECPay\ApplePay;

abstract class ActionType {

    /**
     * 關帳
     */
    const C = 'C';

    /**
     * 退刷
     */
    const R = 'R';

    /**
     * 取消
     */
    const E = 'E';

    /**
     * 放棄
     */
    const N = 'N';

}
