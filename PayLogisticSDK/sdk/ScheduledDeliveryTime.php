<?php

namespace ECPay\PayLogisticSDK;

abstract class ScheduledDeliveryTime {
    const TIME_9_12 = '1';// 9~12時
    const TIME_12_17 = '2';// 12~17時
    const TIME_17_20 = '3';// 17~20時
    const UNLIMITED = '4';// 不限時
    const TIME_20_21 = '5';// 20~21時(需限定區域)
    const TIME_9_17 = '12';// 早午 9~17
    const TIME_9_12_17_20 = '13';// 早晚 9~12 & 17~20
    const TIME_13_20 = '23';// 午晚 13~20
}
