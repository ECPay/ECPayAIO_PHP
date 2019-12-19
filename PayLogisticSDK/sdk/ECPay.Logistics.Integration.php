<?php
/**
 * 綠界物流相容性 SDK
 * @author https://www.ecpay.com.tw
 */

 include_once('Ecpay.Logistic.Integration.php');

/**
 *  物流類型
 */
if (!class_exists('LogisticsType', false)) {
    abstract class LogisticsType extends EcpayLogisticsType {}
}

/**
 *  物流子類型
 */
if (!class_exists('LogisticsSubType', false)) {
    
    abstract class LogisticsSubType extends EcpayLogisticsSubType {}
}
/**
 *  是否代收貨款
 *
 */
if (!class_exists('IsCollection', false)) {
    abstract class IsCollection extends EcpayIsCollection {}
}

/**
 *  使用設備
 */
if (!class_exists('Device', false)) {
    abstract class Device extends EcpayDevice {}
}

/**
 *  測試廠商編號
 */
if (!class_exists('ECPayTestMerchantID', false)) {
    abstract class ECPayTestMerchantID extends EcpayTestMerchantId {}
}

/**
 *  正式環境網址
 */
if (!class_exists('ECPayURL', false)) {
    abstract class ECPayURL extends EcpayUrl {}
}

/**
 *  測試環境網址
 */
if (!class_exists('ECPayTestURL', false)) {
    abstract class ECPayTestURL extends EcpayTestUrl {}
}

/**
 *  溫層
 */
if (!class_exists('Temperature', false)) {
    abstract class Temperature extends EcpayTemperature {}
}

/**
 *  距離
 */
if (!class_exists('Distance', false)) {
    abstract class Distance extends EcpayDistance {}
}

/**
 *  規格
 *
 */
if (!class_exists('Specification', false)) {
    abstract class Specification extends EcpaySpecification {}
}

/**
 *  預計取件時段
 */
if (!class_exists('ScheduledPickupTime', false)) {
    abstract class ScheduledPickupTime extends EcpayScheduledPickupTime {}
}

/**
 *  預定送達時段
 */
if (!class_exists('ScheduledDeliveryTime', false)) {
    abstract class ScheduledDeliveryTime extends EcpayScheduledDeliveryTime {}
}

/**
 *  門市類型
 */
if (!class_exists('StoreType', false)) {
    abstract class StoreType extends EcpayStoreType {}
}


if (!class_exists('ECPayLogistics', false)) {
    class ECPayLogistics extends EcpayLogistics {}
}


if (!class_exists('ECPay_CheckMacValue', true)) {
	class ECPay_CheckMacValue extends EcpayCheckMacValue {}
}


if (!class_exists('ECPay_IO', true)) {
	class ECPay_IO extends EcpayIo {}
}
