<?php
	/**
	 * ECPay 物流 SDK
	 *
	 * @author		https://www.ecpay.com.tw
	 * @version		1.0.1012
	 */


	/**
	 *  物流類型
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class LogisticsType {
		const CVS = 'CVS';// 超商取貨
		const HOME = 'Home';// 宅配
	}

	/**
	 *  物流子類型
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class LogisticsSubType {
		const TCAT = 'TCAT';// 黑貓(宅配)
		const FAMILY = 'FAMI';// 全家
		const UNIMART = 'UNIMART';// 統一超商
		const FAMILY_C2C = 'FAMIC2C';// 全家店到店
		const UNIMART_C2C = 'UNIMARTC2C';// 統一超商寄貨便
		const HILIFE_C2C = 'HILIFEC2C';
	}

	/**
	 *  是否代收貨款
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class IsCollection {
		const YES = 'Y';// 貨到付款
		const NO = 'N';// 僅配送
	}

	/**
	 *  使用設備
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class Device {
		const PC = 0;// PC
		const MOBILE = 1;// 行動裝置
	}

	/**
	 *  測試廠商編號
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class ECPayTestMerchantID {
		const B2C = '2000132';// B2C
		const C2C = '2000933';// C2C
	}

	/**
	 *  正式環境網址
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class ECPayURL {
		const CVS_MAP = 'https://logistics.ecpay.com.tw/Express/map';// 電子地圖
		const SHIPPING_ORDER = 'https://logistics.ecpay.com.tw/Express/Create';// 物流訂單建立
		const HOME_RETURN_ORDER = 'https://logistics.ecpay.com.tw/Express/ReturnHome';// 宅配逆物流訂單
		const FAMILY_RETURN_ORDER = 'https://logistics.ecpay.com.tw/express/ReturnCVS';// 超商取貨逆物流訂單(全家超商B2C)
		const FAMILY_RETURN_CHECK = 'https://logistics.ecpay.com.tw/Helper/LogisticsCheckAccoounts';// 全家逆物流核帳(全家超商B2C)
		const UNIMART_UPDATE_LOGISTICS_INFO = 'https://logistics.ecpay.com.tw/Helper/UpdateShipmentInfo';// 統一修改物流資訊(全家超商B2C)
		const UNIMART_UPDATE_STORE_INFO = 'https://logistics.ecpay.com.tw/Express/UpdateStoreInfo';// 更新門市(統一超商C2C)
		const UNIMART_CANCEL_LOGISTICS_ORDER = 'https://logistics.ecpay.com.tw/Express/CancelC2COrder';// 取消訂單(統一超商C2C)
		const QUERY_LOGISTICS_INFO = 'https://logistics.ecpay.com.tw/Helper/QueryLogisticsTradeInfo';// 物流訂單查詢
		const PRINT_TRADE_DOC = 'https://logistics.ecpay.com.tw/helper/printTradeDocument';// 產生托運單(宅配)/一段標(超商取貨)
		const PRINT_UNIMART_C2C_BILL = 'https://logistics.ecpay.com.tw/Express/PrintUniMartC2COrderInfo';// 列印繳款單(統一超商C2C)
		const PRINT_FAMILY_C2C_BILL = 'https://logistics.ecpay.com.tw/Express/PrintFAMIC2COrderInfo';// 全家列印小白單(全家超商C2C)
		const PRINT_HILIFE_C2C_BILL = 'https://logistics.ecpay.com.tw/Express/PrintHILIFEC2COrderInfo';// 萊爾富列印小白單(萊爾富超商C2C)
	}

	/**
	 *  正式測試環境網址
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class ECPayTestURL {
        const CVS_MAP = 'https://logistics.ecpay.com.tw/Express/map';// 電子地圖(測試環境有問題，直接使用正式環境URL)
		const SHIPPING_ORDER = 'https://logistics-stage.ecpay.com.tw/Express/Create';// 物流訂單建立
		const HOME_RETURN_ORDER = 'https://logistics-stage.ecpay.com.tw/Express/ReturnHome';// 宅配逆物流訂單
		const FAMILY_RETURN_ORDER = 'https://logistics-stage.ecpay.com.tw/express/ReturnCVS';// 超商取貨逆物流訂單(全家超商B2C)
		const FAMILY_RETURN_CHECK = 'https://logistics-stage.ecpay.com.tw/Helper/LogisticsCheckAccoounts';// 全家逆物流核帳(全家超商B2C)
		const UNIMART_UPDATE_LOGISTICS_INFO = 'https://logistics-stage.ecpay.com.tw/Helper/UpdateShipmentInfo';// 統一修改物流資訊(全家超商B2C)
		const UNIMART_UPDATE_STORE_INFO = 'https://logistics-stage.ecpay.com.tw/Express/UpdateStoreInfo';// 更新門市(統一超商C2C)
		const UNIMART_CANCEL_LOGISTICS_ORDER = 'https://logistics-stage.ecpay.com.tw/Express/CancelC2COrder';// 取消訂單(統一超商C2C)
		const QUERY_LOGISTICS_INFO = 'https://logistics-stage.ecpay.com.tw/Helper/QueryLogisticsTradeInfo';// 物流訂單查詢
		const PRINT_TRADE_DOC = 'https://logistics-stage.ecpay.com.tw/helper/printTradeDocument';// 產生托運單(宅配)/一段標(超商取貨)
		const PRINT_UNIMART_C2C_BILL = 'https://logistics-stage.ecpay.com.tw/Express/PrintUniMartC2COrderInfo';// 列印繳款單(統一超商C2C)
		const PRINT_FAMILY_C2C_BILL = 'https://logistics-stage.ecpay.com.tw/Express/PrintFAMIC2COrderInfo';// 全家列印小白單(全家超商C2C)
		const PRINT_HILIFE_C2C_BILL = 'https://logistics-stage.ecpay.com.tw/Express/PrintHILIFEC2COrderInfo';// 萊爾富列印小白單(萊爾富超商C2C)
	}

	/**
	 *  溫層
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class Temperature {
		const ROOM = '0001';// 常溫
		const REFRIGERATION = '0002';// 冷藏
		const FREEZE = '0003';// 冷凍
	}

	/**
	 *  距離
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class Distance {
		const SAME = '00';// 同縣市
		const OTHER = '01';// 外縣市
		const ISLAND = '02';// 離島
	}

	/**
	 *  規格
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class Specification {
		const CM_60 = '0001';// 60cm
		const CM_90 = '0002';// 90cm
		const CM_120 = '0003';// 120cm
		const CM_150 = '0004';// 150cm
	}

	/**
	 *  預計取件時段
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class ScheduledPickupTime {
		const TIME_9_12 = '1';// 9~12時
		const TIME_12_17 = '2';// 12~17時
		const TIME_17_20 = '3';// 17~20時
		const UNLIMITED = '4';// 不限時
	}

	/**
	 *  預定送達時段
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class ScheduledDeliveryTime {
		const TIME_9_12 = '1';// 9~12時
		const TIME_12_17 = '2';// 12~17時
		const TIME_17_20 = '3';// 17~20時
		const UNLIMITED = '4';// 不限時
		const TIME_20_21 = '5';// 20~21時(需限定區域)
	}

	/**
	 *  門市類型
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	abstract class StoreType {
		const RECIVE_STORE = '01';// 取件門市
		const RETURN_STORE = '02';// 退件門市
	}



	/**
	 *  物流 SDK
	 *
	 * @author		https://www.ecpay.com.tw
	 * @category	Options
	 * @version		1.0.1012
	 */
	class ECPayLogistics {
		public $ServiceURL = '';
		public $HashKey = '';
		public $HashIV = '';
		public $Send = array();
		public $SendExtend = '';
		public $PostParams = array();
		public $Encode = 'UTF-8';

		public function __construct() {}

		/**
		 *  電子地圖
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @param		String $ButtonDesc 按鈕顯示名稱
		 * @param		String $Target 表單 action 目標
		 * @return		String
		 * @version		1.0.1012
		 */
		public function CvsMap($ButtonDesc = '電子地圖', $Target = '_self') {
			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'MerchantTradeNo' => '',
				'LogisticsSubType' => '',
				'IsCollection' => '',
				'ServerReplyURL' => '',
				'ExtraData' => '',
				'Device' => Device::PC
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);
			$this->PostParams['LogisticsType'] = LogisticsType::CVS;

			// 參數檢查
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('CVS_MAP');
			$this->ValidateMerchantTradeNo();
			$this->ValidateLogisticsSubType();
			$this->ValidateIsCollection();
			$this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
			$this->ValidateString('ExtraData', $this->PostParams['ExtraData'], 20, true);
			$this->ValidateDevice(true);

			return $this->GenPostHTML($ButtonDesc, $Target);
		}

		/**
		 *  物流訂單建立
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @param		String $ButtonDesc 按鈕顯示名稱
		 * @param		String $Target 表單 action 目標
		 * @return		String
		 * @version		1.0.1012
		 */
		public function CreateShippingOrder($ButtonDesc = '物流訂單建立', $Target = '_self') {
			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'MerchantTradeNo' => '',
				'MerchantTradeDate' => '',
				'LogisticsType' => '',
				'LogisticsSubType' => '',
				'GoodsAmount' => 0,
				'CollectionAmount' => 0,
				'IsCollection' => IsCollection::NO,
				'GoodsName' => '',
				'SenderName' => '',
				'SenderPhone' => '',
				'SenderCellPhone' => '',
				'ReceiverName' => '',
				'ReceiverPhone' => '',
				'ReceiverCellPhone' => '',
				'ReceiverEmail' => '',
				'TradeDesc' => '',
				'ServerReplyURL' => '',
				'ClientReplyURL' => '',
				'LogisticsC2CReplyURL' => '',
				'Remark' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);
			$MinAmount = 1; // 金額下限
			$MaxAmount = 20000; // 金額上限

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('SHIPPING_ORDER');
			$this->ValidateMerchantTradeNo();
			$this->ValidateMerchantTradeDate();
			$this->ValidateLogisticsType();
			$this->ValidateLogisticsSubType();

			// 依不同的物流類型(LogisticsType)設定專屬參數並檢查
			switch ($this->PostParams['LogisticsType']) {
				case LogisticsType::CVS:
					$CvsParamList = array(
						'ReceiverStoreID' => '',
						'ReturnStoreID' => ''
					);
					$this->PostParams = $this->GetPostParams($this->SendExtend, $CvsParamList, $this->PostParams);

					$this->ValidateStoreID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6);
					$this->ValidateStoreID('ReturnStoreID', $this->PostParams['ReturnStoreID'], 6, true);
					// 物流子類型(LogisticsSubType)為全家店到店(FAMIC2C)/統一超商交貨便(UNIMARTC2C)，退貨門市代號(ReturnStoreID)不可為空
					break;
				case LogisticsType::HOME:
					$HomeParamList = array(
						'SenderZipCode' => '',
						'SenderAddress' => '',
						'ReceiverZipCode' => '',
						'ReceiverAddress' => '',
						'Temperature' => Temperature::ROOM,
						'Distance' => Distance::SAME,
						'Specification' => Specification::CM_60,
						'ScheduledDeliveryTime' => ''
					);
					$this->PostParams = $this->GetPostParams($this->SendExtend, $HomeParamList, $this->PostParams);
					$this->PostParams['ScheduledPickupTime'] = ScheduledPickupTime::UNLIMITED;

					$this->ValidateZipCode('SenderZipCode', $this->PostParams['SenderZipCode']);
					$this->ValidateString('SenderAddress', $this->PostParams['SenderAddress'], 200);
					$this->ValidateZipCode('ReceiverZipCode', $this->PostParams['ReceiverZipCode']);
					$this->ValidateString('ReceiverAddress', $this->PostParams['ReceiverAddress'], 200);
					$this->ValidateTemperature();
					$this->ValidateDistance();
					$this->ValidateSpecification();
					$this->ValidateScheduledDeliveryTime(true);
					break;
				default:
			}

			$this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
			if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，商品金額範圍為1~19,999元
				$MaxAmount = 19999;
			}
			if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
				throw new Exception('Invalid GoodsAmount.');
			}

			$this->ValidateIsCollection(true);
			if ($this->PostParams['IsCollection'] == IsCollection::NO) {
				// 若設定為僅配送，清除代收金額
				unset($this->PostParams['CollectionAmount']);
			} else {
				$this->ValidateAmount('CollectionAmount', $this->PostParams['CollectionAmount']);
				if ($this->PostParams['CollectionAmount'] < $MinAmount or $this->PostParams['CollectionAmount'] > $MaxAmount){
					throw new Exception('Invalid CollectionAmount.');
				}
			}

			if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::FAMILY_C2C or $this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為全家店到店(FAMIC2C)、 統一超商交貨便(UNIMARTC2C)時，不可為空
				$this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60);
			} else {
				$this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
			}

			$this->ValidateString('SenderName', $this->PostParams['SenderName'], 10);
			$this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
			$this->ValidatePhoneNumber('SenderCellPhone', $this->PostParams['SenderCellPhone'], true);
			if ($this->PostParams['LogisticsType'] == LogisticsType::HOME) {
				// 物流類型(LogisticsType)為宅配(Home)時，寄件人電話(SenderPhone)或寄件人手機(SenderCellPhone)不可為空
				if (empty($this->PostParams['SenderPhone']) and empty($this->PostParams['SenderCellPhone'])) {
					throw new Exception('SenderPhone or SenderCellPhone is required when LogisticsType is Home.');
				}
			} else if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，寄件人手機(SenderCellPhone)不可為空
				if (empty($this->PostParams['SenderCellPhone'])) {
					throw new Exception('SenderCellPhone is required when LogisticsSubType is UNIMARTC2C.');
				}
			}

			$this->ValidateString('ReceiverName', $this->PostParams['ReceiverName'], 10);
			$this->ValidatePhoneNumber('ReceiverPhone', $this->PostParams['ReceiverPhone'], true);
			$this->ValidatePhoneNumber('ReceiverCellPhone', $this->PostParams['ReceiverCellPhone'], true);
			if ($this->PostParams['LogisticsType'] == LogisticsType::HOME) {
				// 物流類型(LogisticsType)為宅配(Home)時，收件人電話(ReceiverPhone)或收件人手機(ReceiverCellPhone)不可為空
				if (empty($this->PostParams['ReceiverPhone']) and empty($this->PostParams['ReceiverCellPhone'])) {
					throw new Exception('ReceiverPhone or ReceiverCellPhone is required when LogisticsType is Home.');
				}
			} else if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，收件人手機(ReceiverCellPhone)不可為空
				if (empty($this->PostParams['ReceiverCellPhone'])) {
					throw new Exception('ReceiverCellPhone is required when LogisticsSubType is UNIMARTC2C.');
				}
			}

			$this->ValidateEmail('ReceiverEmail', $this->PostParams['ReceiverEmail'], 100, true);
			$this->ValidateString('TradeDesc', $this->PostParams['TradeDesc'], 200, true);
			$this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
			$this->ValidateURL('ClientReplyURL', $this->PostParams['ClientReplyURL'], 200, true);

			if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，此欄位不可為空
				$this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL']);
			} else {
				$this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL'], 200, true);
			}

			$this->ValidateString('Remark', $this->PostParams['Remark'], 200, true);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 物流類型(LogisticsType)為宅配(Home)且溫層(Temperature)為冷凍(0003)時，規格(Specification)不可為 150cm(0004)
			if ($this->PostParams['LogisticsType'] == LogisticsType::HOME and $this->PostParams['Temperature'] == Temperature::FREEZE) {
				if ($this->PostParams['Specification'] == Specification::CM_150) {
					throw new Exception('Specification could not be 150cm(0004) when LogisticsType is Home and Temperature is FREEZE(0003).');
				}
			}

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			return $this->GenPostHTML($ButtonDesc, $Target);
		}

		/**
		 *  幕後物流訂單建立
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function BGCreateShippingOrder() {
			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'MerchantTradeNo' => '',
				'MerchantTradeDate' => '',
				'LogisticsType' => '',
				'LogisticsSubType' => '',
				'GoodsAmount' => 0,
				'CollectionAmount' => 0,
				'IsCollection' => IsCollection::NO,
				'GoodsName' => '',
				'SenderName' => '',
				'SenderPhone' => '',
				'SenderCellPhone' => '',
				'ReceiverName' => '',
				'ReceiverPhone' => '',
				'ReceiverCellPhone' => '',
				'ReceiverEmail' => '',
				'TradeDesc' => '',
				'ServerReplyURL' => '',
				'LogisticsC2CReplyURL' => '',
				'Remark' => '',
				'PlatformID' => ''
			);

            // 幕後物流訂單建立不可設定Client端回覆網址(ClientReplyURL)
            if (!empty($this->Send['ClientReplyURL'])) {
                throw new Exception('ClientReplyURL should be null.');
            }

			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);
			$MinAmount = 1; // 金額下限
			$MaxAmount = 20000; // 金額上限

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('SHIPPING_ORDER');
			$this->ValidateMerchantTradeNo();
			$this->ValidateMerchantTradeDate();
			$this->ValidateLogisticsType();
			$this->ValidateLogisticsSubType();

			// 依不同的物流類型(LogisticsType)設定專屬參數並檢查
			switch ($this->PostParams['LogisticsType']) {
				case LogisticsType::CVS:
					$CvsParamList = array(
						'ReceiverStoreID' => '',
						'ReturnStoreID' => ''
					);
					$this->PostParams = $this->GetPostParams($this->SendExtend, $CvsParamList, $this->PostParams);

					$this->ValidateStoreID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6);
					$this->ValidateStoreID('ReturnStoreID', $this->PostParams['ReturnStoreID'], 6, true);
					// 物流子類型(LogisticsSubType)為全家店到店(FAMIC2C)/統一超商交貨便(UNIMARTC2C)，退貨門市代號(ReturnStoreID)不可為空
					break;
				case LogisticsType::HOME:
					$HomeParamList = array(
						'SenderZipCode' => '',
						'SenderAddress' => '',
						'ReceiverZipCode' => '',
						'ReceiverAddress' => '',
						'Temperature' => Temperature::ROOM,
						'Distance' => Distance::SAME,
						'Specification' => Specification::CM_60,
						'ScheduledDeliveryTime' => ''
					);
					$this->PostParams = $this->GetPostParams($this->SendExtend, $HomeParamList, $this->PostParams);
					$this->PostParams['ScheduledPickupTime'] = ScheduledPickupTime::UNLIMITED;

					$this->ValidateZipCode('SenderZipCode', $this->PostParams['SenderZipCode']);
					$this->ValidateString('SenderAddress', $this->PostParams['SenderAddress'], 200);
					$this->ValidateZipCode('ReceiverZipCode', $this->PostParams['ReceiverZipCode']);
					$this->ValidateString('ReceiverAddress', $this->PostParams['ReceiverAddress'], 200);
					$this->ValidateTemperature();
					$this->ValidateDistance();
					$this->ValidateSpecification();
					$this->ValidateScheduledDeliveryTime(true);
					break;
				default:
			}

			$this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
			if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，商品金額範圍為1~19,999元
				$MaxAmount = 19999;
			}
			if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
				throw new Exception('Invalid GoodsAmount.');
			}

			$this->ValidateIsCollection(true);
			if ($this->PostParams['IsCollection'] == IsCollection::NO) {
				// 若設定為僅配送，清除代收金額
				unset($this->PostParams['CollectionAmount']);
			} else {
				$this->ValidateAmount('CollectionAmount', $this->PostParams['CollectionAmount']);
				if ($this->PostParams['CollectionAmount'] < $MinAmount or $this->PostParams['CollectionAmount'] > $MaxAmount){
					throw new Exception('Invalid CollectionAmount.');
				}
			}

			if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::FAMILY_C2C or $this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為全家店到店(FAMIC2C)、 統一超商交貨便(UNIMARTC2C)時，不可為空
				$this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60);
			} else {
				$this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
			}

			$this->ValidateString('SenderName', $this->PostParams['SenderName'], 10);
			$this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
			$this->ValidatePhoneNumber('SenderCellPhone', $this->PostParams['SenderCellPhone'], true);
			if ($this->PostParams['LogisticsType'] == LogisticsType::HOME) {
				// 物流類型(LogisticsType)為宅配(Home)時，寄件人電話(SenderPhone)或寄件人手機(SenderCellPhone)不可為空
				if (empty($this->PostParams['SenderPhone']) and empty($this->PostParams['SenderCellPhone'])) {
					throw new Exception('SenderPhone or SenderCellPhone is required when LogisticsType is Home.');
				}
			} else if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，寄件人手機(SenderCellPhone)不可為空
				if (empty($this->PostParams['SenderCellPhone'])) {
					throw new Exception('SenderCellPhone is required when LogisticsSubType is UNIMARTC2C.');
				}
			}

			$this->ValidateString('ReceiverName', $this->PostParams['ReceiverName'], 10);
			$this->ValidatePhoneNumber('ReceiverPhone', $this->PostParams['ReceiverPhone'], true);
			$this->ValidatePhoneNumber('ReceiverCellPhone', $this->PostParams['ReceiverCellPhone'], true);
			if ($this->PostParams['LogisticsType'] == LogisticsType::HOME) {
				// 物流類型(LogisticsType)為宅配(Home)時，收件人電話(ReceiverPhone)或收件人手機(ReceiverCellPhone)不可為空
				if (empty($this->PostParams['ReceiverPhone']) and empty($this->PostParams['ReceiverCellPhone'])) {
					throw new Exception('ReceiverPhone or ReceiverCellPhone is required when LogisticsType is Home.');
				}
			} else if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，收件人手機(ReceiverCellPhone)不可為空
				if (empty($this->PostParams['ReceiverCellPhone'])) {
					throw new Exception('ReceiverCellPhone is required when LogisticsSubType is UNIMARTC2C.');
				}
			}

			$this->ValidateEmail('ReceiverEmail', $this->PostParams['ReceiverEmail'], 100, true);
			$this->ValidateString('TradeDesc', $this->PostParams['TradeDesc'], 200, true);
			$this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);

			if ($this->PostParams['LogisticsSubType'] == LogisticsSubType::UNIMART_C2C) {
				// 物流子類型(LogisticsSubType)為統一超商交貨便(UNIMARTC2C)時，此欄位不可為空
				$this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL']);
			} else {
				$this->ValidateURL('LogisticsC2CReplyURL', $this->PostParams['LogisticsC2CReplyURL'], 200, true);
			}

			$this->ValidateString('Remark', $this->PostParams['Remark'], 200, true);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 物流類型(LogisticsType)為宅配(Home)且溫層(Temperature)為冷凍(0003)時，規格(Specification)不可為 150cm(0004)
			if ($this->PostParams['LogisticsType'] == LogisticsType::HOME and $this->PostParams['Temperature'] == Temperature::FREEZE) {
				if ($this->PostParams['Specification'] == Specification::CM_150) {
					throw new Exception('Specification could not be 0004 when LogisticsType is Home and Temperature is 0003.');
				}
			}

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

            // 解析回傳結果
            // 正確：1|MerchantID=XXX&MerchantTradeNo=XXX&RtnCode=XXX&RtnMsg=XXX&AllPayLogisticsID=XXX&LogisticsType=XXX&LogisticsSubType=XXX&GoodsAmount=XXX&UpdateStatusDate=XXX&ReceiverName=XXX&ReceiverPhone=XXX&ReceiverCellPhone=XXX&ReceiverEmail=XXX&ReceiverAddress=XXX&CVSPaymentNo=XXX&CVSValidationNo=XXX &CheckMacValue=XXX
            // 錯誤：0|ErrorMessage
            $Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
            $Pieces = explode('|', $Feedback);
            $Result = array();
            $Result['ResCode'] = $Pieces[0];
            if ($Result['ResCode']) {
                $RtnCont = array();
                parse_str($Pieces[1], $RtnCont);
                $Result = array_merge($Result, $RtnCont);
            } else {
                $Result['ErrorMessage'] = $Pieces[1];
            }

            return $Result;
		}

		/**
		 *  回傳 CheckMacValue 檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @param		Array $Feedback ECPay 回傳資料
		 * @version		1.0.1012
		 */
		public function CheckOutFeedback($Feedback = array()) {

            $this->ValidateHashKey();
            $this->ValidateHashIV();

			if (empty($Feedback)) {
				throw new Exception('Feedback is required.');
			}

			if (!isset($Feedback['CheckMacValue'])) {
				throw new Exception('Feedback CheckMacValue is required.');
			} else {
				$FeedbackCheckMacValue = $Feedback['CheckMacValue'];
				unset($Feedback['CheckMacValue']);
				unset($Feedback['ResCode']);
				unset($Feedback['ErrorMessage']);
				$CheckMacValue = $this->GenCheckMacValue($Feedback, $this->HashKey, $this->HashIV);
				if ($CheckMacValue != $FeedbackCheckMacValue) {
					throw new Exception('CheckMacValue verify fail.');
				}
			}
		}

		/**
		 *  宅配逆物流訂單產生
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function CreateHomeReturnOrder() {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'LogisticsSubType' => '',
				'ServerReplyURL' => '',
				'SenderName' => '',
				'SenderPhone' => '',
				'SenderCellPhone' => '',
				'SenderZipCode' => '',
				'SenderAddress' => '',
				'ReceiverName' => '',
				'ReceiverPhone' => '',
				'ReceiverCellPhone' => '',
				'ReceiverZipCode' => '',
				'ReceiverAddress' => '',
				'GoodsAmount' => '',
				'GoodsName' => '',
				'Temperature' => Temperature::ROOM,
				'Distance' => Distance::SAME,
				'Specification' => Specification::CM_60,
				'ScheduledPickupTime' => ScheduledPickupTime::UNLIMITED,
				'ScheduledDeliveryTime' => '',
				'Remark' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);
			$this->PostParams['ScheduledPickupTime'] = ScheduledPickupTime::UNLIMITED; // 預定取件時段(ScheduledPickupTime)固定為不限時
			$this->PostParams['LogisticsType'] = LogisticsType::HOME; // 物流類型固定為宅配(HOME)
			$IsAllpayLogisticsIdEmpty = false; // 物流交易編號(AllPayLogisticsID)是否為空
			$IsAllowEmpty = false;
			$MinAmount = 1; // 金額下限
			$MaxAmount = 20000; // 金額上限

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('HOME_RETURN_ORDER');

			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20, true);
			$this->ValidateLogisticsSubType(false);
			// 物流交易編號(AllPayLogisticsID)與物流子類型(LogisticsSubType)擇一不可為空
			if (empty($this->PostParams['AllPayLogisticsID'])) {
				$IsAllpayLogisticsIdEmpty = true;
			}
			if ($IsAllpayLogisticsIdEmpty === true and empty($this->PostParams['LogisticsSubType'])) {
				throw new Exception('One of AllPayLogisticsID and LogisticsSubType is required.');
			}

			$this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);

			// 物流交易編號(AllPayLogisticsID)為空值時，退貨人姓名(SenderName)不可為空。
			if ($IsAllpayLogisticsIdEmpty) {
				$IsAllowEmpty = false;
			}
			$this->ValidateString('SenderName', $this->PostParams['SenderName'], 60, $IsAllowEmpty);

			$this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
			$this->ValidatePhoneNumber('SenderCellPhone', $this->PostParams['SenderCellPhone'], true);
			// 物流交易編號(AllPayLogisticsID)為空值時，退貨人電話(SenderPhone)與退貨人手機(SenderCellPhone)擇一不可為空。
			if ($IsAllpayLogisticsIdEmpty) {
				if (empty($this->PostParams['SenderPhone']) and empty($this->PostParams['SenderCellPhone'])) {
					throw new Exception('One of SenderPhone and SenderCellPhone is required.');
				}
			}

			// 物流交易編號(AllPayLogisticsID)為空值時，退貨人郵遞區號(SenderZipCode)不可為空。
			$this->ValidateZipCode('SenderZipCode', $this->PostParams['SenderZipCode'], $IsAllowEmpty);

			// 物流交易編號(AllPayLogisticsID)為空值時，SenderAddress(SenderAddress)不可為空。
			$this->ValidateString('SenderAddress', $this->PostParams['SenderAddress'], 200, $IsAllowEmpty);

			// 若物流交易編號(AllPayLogisticsID)為空值時，收件人姓名(ReceiverName)不可為空。
			$this->ValidateString('ReceiverName', $this->PostParams['ReceiverName'], 10, $IsAllowEmpty);

			$this->ValidatePhoneNumber('ReceiverPhone', $this->PostParams['ReceiverPhone'], 20, true);
			$this->ValidatePhoneNumber('ReceiverCellPhone', $this->PostParams['ReceiverCellPhone'], 20, true);
			// 物流交易編號(AllPayLogisticsID)為空值時，收件人電話(ReceiverPhone)與收件人手機(ReceiverCellPhone)擇一不可為空。
			if ($IsAllpayLogisticsIdEmpty) {
				if (empty($this->PostParams['ReceiverPhone']) and empty($this->PostParams['ReceiverCellPhone'])) {
					throw new Exception('One of ReceiverPhone and ReceiverCellPhone is required.');
				}
			}

			// 若物流交易編號(AllPayLogisticsID)為空值時，收件人郵遞區號(ReceiverZipCode)不可為空。
            $this->ValidateZipCode('ReceiverZipCode', $this->PostParams['ReceiverZipCode'], $IsAllowEmpty);

			// 若物流交易編號(AllPayLogisticsID)為空值時，收件人地址(ReceiverAddress)不可為空。
			$this->ValidateString('ReceiverAddress', $this->PostParams['ReceiverAddress'], 200, $IsAllowEmpty);

			$this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
			if ($this->PostParams['GoodsAmount'] < $MinAmount or $this->PostParams['GoodsAmount'] > $MaxAmount){
				throw new Exception('Invalid GoodsAmount.');
			}
			$this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 60, true);
			$this->ValidateTemperature();
			$this->ValidateDistance();
			$this->ValidateSpecification();
			$this->ValidateScheduledDeliveryTime(true);
			$this->ValidateString('Remark', $this->PostParams['Remark'], 200, true);

			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			// 解析回傳結果
            // 正確：1|OK
            // 錯誤：0|ErrorMessage
			$Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
			$Result = $this->ParseFeedback($Feedback);

			return $Result;
		}

		/**
		 *  超商取貨逆物流訂單(全家超商B2C)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function CreateFamilyB2CReturnOrder() {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'ServerReplyURL' => '',
				'GoodsName' => '',
				'GoodsAmount' => 0,
				'SenderName' => '',
				'SenderPhone' => '',
				'Remark' => '',
				'Quantity' => '',
				'Cost' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);
			$this->PostParams['CollectionAmount'] = 0;
			$this->PostParams['ServiceType'] = 4;// 退貨不付款

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('FAMILY_RETURN_ORDER');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20, true);
			$this->ValidateURL('ServerReplyURL', $this->PostParams['ServerReplyURL']);
			$this->ValidateString('GoodsName', $this->PostParams['GoodsName'], 50, true);
			$this->ValidateAmount('GoodsAmount', $this->PostParams['GoodsAmount']);
			$this->ValidateString('SenderName', $this->PostParams['SenderName'], 50);
			$this->ValidatePhoneNumber('SenderPhone', $this->PostParams['SenderPhone'], true);
			$this->ValidateString('Remark', $this->PostParams['Remark'], 20, true);
			$this->ValidateString('Quantity', $this->PostParams['Quantity'], 50, true);
			$this->ValidateString('Cost', $this->PostParams['Cost'], 50, true);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 檢查商品名稱, 數量 與 成本
			$GoodsNameNumber = count(explode('#', $this->PostParams['GoodsName']));
			$QuantityNumber = count(explode('#', $this->PostParams['Quantity']));
			$CostNumber = count(explode('#', $this->PostParams['Cost']));

			if (!empty($this->PostParams['GoodsName']) and !empty($this->PostParams['Quantity'])) {
				if ($GoodsNameNumber != $QuantityNumber) {
					throw new Exception('GoodsName number and Quantity number do not match.');
				}
			}

			if (!empty($this->PostParams['Quantity']) and !empty($this->PostParams['Cost'])) {
				if ($GoodsNameNumber != $CostNumber) {
					throw new Exception('Quantity number and Cost number do not match.');
				}
			}

			if (!empty($this->PostParams['Cost']) and !empty($this->PostParams['GoodsName'])) {
				if ($GoodsNameNumber != $CostNumber) {
					throw new Exception('Cost number and GoodsName number do not match.');
				}
			}

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			// 解析回傳結果
            // 正確：RtnMerchantTradeNo | RtnOrderNo
            // 錯誤：|ErrorMessage
			$Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
			$Pieces = explode('|', $Feedback);
			$Result = array('RtnMerchantTradeNo' => '', 'RtnOrderNo' => '');
			if (empty($Pieces[0])) {
				$Result = array('ErrorMessage' => $Pieces[1]);
			} else {
				$Result['RtnMerchantTradeNo'] = $Pieces[0];
				$Result['RtnOrderNo'] = $Pieces[1];
			}

			return $Result;
		}

		/**
		 *  全家逆物流核帳(全家超商B2C)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function CheckFamilyB2CLogistics() {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'RtnMerchantTradeNo' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('FAMILY_RETURN_CHECK');
			$this->ValidateID('RtnMerchantTradeNo', $this->PostParams['RtnMerchantTradeNo'], 13);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			// 解析回傳結果
            // 正確：1|OK
            // 錯誤：0|ErrorMessage
			$Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
			$Result = $this->ParseFeedback($Feedback);

			return $Result;
		}

		/**
		 *  廠商修改出貨日期、取貨門市(統一超商B2C)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function UpdateUnimartLogisticsInfo() {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'ShipmentDate' => '',
				'ReceiverStoreID' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('UNIMART_UPDATE_LOGISTICS_INFO');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);

			$this->ValidateShipmentDate(true);
			$this->ValidateStoreID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6, true);
			if (empty($this->PostParams['ShipmentDate']) and empty($this->PostParams['ReceiverStoreID'])) {
				throw new Exception('ShipmentDate or ReceiverStoreID is required.');
			}

			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			// 解析回傳結果
            // 正確：1|OK
            // 錯誤：0|ErrorMessage
			$Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
			$Result = $this->ParseFeedback($Feedback);

			return $Result;
		}

		/**
		 *  更新門市(統一超商C2C)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function UpdateUnimartStore() {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'CVSPaymentNo' => '',
				'CVSValidationNo' => '',
				'StoreType' => '',
				'ReceiverStoreID' => '',
				'ReturnStoreID' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('UNIMART_UPDATE_STORE_INFO');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
			$this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
			$this->ValidateID('CVSValidationNo', $this->PostParams['CVSValidationNo'], 10);
			$this->ValidateStoreType();

			if ($this->PostParams['StoreType'] == StoreType::RECIVE_STORE) {
				$this->ValidateStoreID('ReceiverStoreID', $this->PostParams['ReceiverStoreID'], 6);
			} else {
				unset($this->PostParams['ReceiverStoreID']);
			}

			if ($this->PostParams['StoreType'] == StoreType::RETURN_STORE) {
				$this->ValidateStoreID('ReturnStoreID', $this->PostParams['ReturnStoreID'], 6);
			} else {
				unset($this->PostParams['ReturnStoreID']);
			}

			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			// 解析回傳結果
            // 正確：1|OK
            // 錯誤：0|ErrorMessage
			$Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
			$Result = $this->ParseFeedback($Feedback);

			return $Result;
		}

		/**
		 *  取消訂單(統一超商C2C)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function CancelUnimartLogisticsOrder() {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'CVSPaymentNo' => '',
				'CVSValidationNo' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('UNIMART_CANCEL_LOGISTICS_ORDER');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
			$this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
			$this->ValidateID('CVSValidationNo', $this->PostParams['CVSValidationNo'], 10);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			// 解析回傳結果
            // 正確：1|OK
            // 錯誤：0|ErrorMessage
			$Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
			$Result = $this->ParseFeedback($Feedback);

			return $Result;
		}

		/**
		 *  物流訂單查詢
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @return		Array
		 * @version		1.0.1012
		 */
		public function QueryLogisticsInfo() {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);
			$this->PostParams['TimeStamp'] = strtotime('now');

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('QUERY_LOGISTICS_INFO');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			// 解析回傳結果
            // 回應訊息：MerchantID=XXX&MerchantTradeNo=XXX&AllPayLogisticsID=XXX&GoodsAmount=XXX&LogisticsType=XXX&HandlingCharge=XXX&TradeDate=XXX&LogisticsStatus=XXX&GoodsName=XXX &CheckMacValue=XXX
			$Result = array();
			$Feedback = $this->ServerPost($this->PostParams, $this->ServiceURL);
			parse_str($Feedback, $Result);

			return $Result;
		}

		/**
		 *  產生托運單(宅配)/一段標(超商取貨)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @param		String $ButtonDesc 按鈕顯示名稱
		 * @param		String $Target 表單 action 目標
		 * @return		String
		 * @version		1.0.1012
		 */
		public function PrintTradeDoc($ButtonDesc = '產生托運單/一段標', $Target = '_blank') {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('PRINT_TRADE_DOC');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			return $this->GenPostHTML($ButtonDesc, $Target);
		}

		/**
		 *  列印繳款單(統一超商C2C)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @param		String $ButtonDesc 按鈕顯示名稱
		 * @param		String $Target 表單 action 目標
		 * @return		String
		 * @version		1.0.1012
		 */
		public function PrintUnimartC2CBill($ButtonDesc = '列印繳款單(統一超商C2C)', $Target = '_blank') {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'CVSPaymentNo' => '',
				'CVSValidationNo' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('PRINT_UNIMART_C2C_BILL');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
			$this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
			$this->ValidateID('CVSValidationNo', $this->PostParams['CVSValidationNo'], 10);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			return $this->GenPostHTML($ButtonDesc, $Target);
		}

		/**
		 *  全家列印小白單(全家超商C2C)
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK
		 * @param		String $ButtonDesc 按鈕顯示名稱
		 * @param		String $Target 表單 action 目標
		 * @return		String
		 * @version		1.0.1012
		 */
		public function PrintFamilyC2CBill($ButtonDesc = '全家列印小白單(全家超商C2C)', $Target = '_blank') {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'CVSPaymentNo' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('PRINT_FAMILY_C2C_BILL');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
			$this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			return $this->GenPostHTML($ButtonDesc, $Target);
		}

		/**
		 *  全家列印小白單(全家超商C2C)
		 *
		 * @author		https://www.farwin.com.tw
		 * @category	SDK
		 * @param		String $ButtonDesc 按鈕顯示名稱
		 * @param		String $Target 表單 action 目標
		 * @return		String
		 * @version		??
		 */
		public function PrintHifleC2CBill($ButtonDesc = '萊爾富列印小白單(萊爾富超商C2C)', $Target = '_blank') {

			// 參數初始化
			$ParamList = array(
				'MerchantID' => '',
				'AllPayLogisticsID' => '',
				'CVSPaymentNo' => '',
				'PlatformID' => ''
			);
			$this->PostParams = $this->GetPostParams($this->Send, $ParamList);

			// 參數檢查
            $this->ValidateHashKey();
            $this->ValidateHashIV();
			$this->ValidateID('MerchantID', $this->PostParams['MerchantID'], 10);
			$this->ServiceURL = $this->GetURL('PRINT_HILIFE_C2C_BILL');
			$this->ValidateID('AllPayLogisticsID', $this->PostParams['AllPayLogisticsID'], 20);
			$this->ValidateMixTypeID('CVSPaymentNo', $this->PostParams['CVSPaymentNo'], 15);
			$this->ValidateID('PlatformID', $this->PostParams['PlatformID'], 10, true);

			// 產生 CheckMacValue
			$this->PostParams['CheckMacValue'] = $this->GenCheckMacValue($this->PostParams, $this->HashKey, $this->HashIV);

			return $this->GenPostHTML($ButtonDesc, $Target);
		}



		/**
		 *  Hash Key 檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
        private function ValidateHashKey(){
			$Name = 'HashKey'; // 參數名稱
			$Value = $this->HashKey; // 參數內容
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			}
        }

		/**
		 *  Hash IV 檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
        private function ValidateHashIV(){
			$Name = 'HashIV'; // 參數名稱
			$Value = $this->HashKey; // 參數內容
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			}
        }

		/**
		 *  ID 檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Integer	$MaxLength	參數最大長度
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateID($Name, $Value, $MaxLength = 1, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 格式檢查
				$this->IsValidFormat($Name, '/^\d{1,' . $MaxLength . '}$/', $Value);
			}
		}

		/**
		 *  StoreID 檢查
		 *
		 * @author		https://www.farwin.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Integer	$MaxLength	參數最大長度
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		??
		 */
		private function ValidateStoreID($Name, $Value, $MaxLength = 1, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 格式檢查[A-Za-z0-9]
				$this->IsValidFormat($Name, '/^[A-Za-z0-9]{1,' . $MaxLength . '}$/', $Value);
			}
		}

		/**
		 *  URL 檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Integer	$MaxLength	參數最大長度
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateURL($Name, $Value, $MaxLength = 200, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 格式檢查
				$this->IsValidFormat($Name, '/^(http|https):\/\/+/', $Value);

				// 長度檢查
				$this->IsOverLength($Name, $this->StringLength($Value, $this->Encode), $MaxLength);
			}
		}

		/**
		 *  字串檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Integer	$MaxLength	參數最大長度
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateString($Name, $Value, $MaxLength = 1, $AllowEmpty = false) {

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 長度檢查
				$this->IsOverLength($Name, $this->StringLength($Value, $this->Encode), $MaxLength);
			}
		}

		/**
		 *  金額檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Integer	$MaxLength	參數最大長度
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateAmount($Name, $Value, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 資料型態檢查
				$this->IsInteger($Name, $Value);

				// 格式檢查
				$this->IsValidFormat($Name, '/^\d+$/', $Value);
			}
		}

		/**
		 *  電話號碼檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidatePhoneNumber($Name, $Value, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 格式檢查
				$this->IsValidFormat($Name, '/^\d{7,20}$/', $Value);
			}
		}

		/**
		 *  電子郵件檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Integer	$MaxLength	參數最大長度
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateEmail($Name, $Value, $MaxLength = 100, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 長度檢查
				$this->IsOverLength($Name, $this->StringLength($Value, $this->Encode), $MaxLength);

				// 格式檢查
				$this->IsValidFormat($Name, '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9]{2,4}$/', $Value);
			}
		}

		/**
		 *  郵遞區號檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateZipCode($Name, $Value, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 格式檢查
				$this->IsValidFormat($Name, '/^\d{3,5}$/', $Value);
			}
		}

		/**
		 *  混合型態 ID 檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateMixTypeID($Name, $Value, $MaxLength = 1, $AllowEmpty = false) {
			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 格式檢查
				$this->IsValidFormat($Name, '/^[0-9a-zA-Z]{1,' . $MaxLength . '}$/', $Value);
			}
		}



		/**
		 *  門市類型檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
		private function ValidateStoreType() {
			$Name = 'StoreType'; // 參數名稱
			$Value = $this->PostParams['StoreType']; // 參數內容
			$ClassName = 'StoreType'; // 合法資料 Class 名稱
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  廠商交易編號檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
		private function ValidateMerchantTradeNo() {
			$Name = 'MerchantTradeNo'; // 參數名稱
			$Value = $this->PostParams['MerchantTradeNo']; // 參數內容
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 格式檢查
				$this->IsValidFormat($Name, '/^[a-zA-Z0-9]{1,20}$/', $Value);
			}
		}

		/**
		 *  物流類型檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
		private function ValidateLogisticsType() {
			$Name = 'LogisticsType'; // 參數名稱
			$Value = $this->PostParams['LogisticsType']; // 參數內容
			$ClassName = 'LogisticsType'; // 合法資料 Class 名稱
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  物流子類型檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateLogisticsSubType($AllowEmpty = false) {
			$Name = 'LogisticsSubType'; // 參數名稱
			$Value = $this->PostParams['LogisticsSubType']; // 參數內容
			$ClassName = 'LogisticsSubType'; // 合法資料 Class 名稱

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				if (isset($this->PostParams['LogisticsType'])) {
					$LogisticsType = $this->PostParams['LogisticsType'];
					// 宅配物流子類型檢查
					if ($LogisticsType === LogisticsType::HOME) {
						if ($Value != LogisticsSubType::TCAT) {
							throw new Exception('Invalid home delivery ' . $Name . '.');
						}
					}

					// 超商取貨物流子類型檢查
					if ($LogisticsType === LogisticsType::CVS) {
						if (
							$Value != LogisticsSubType::FAMILY and
							$Value != LogisticsSubType::UNIMART and
							$Value != LogisticsSubType::FAMILY_C2C and
							$Value != LogisticsSubType::UNIMART_C2C and
							$Value != LogisticsSubType::HILIFE_C2C
						) {
							throw new Exception('Invalid CVS pickup ' . $Name . '.');
						}
					}
				}

				// 物流類型無設定時的內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  是否代收貨款檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateIsCollection($AllowEmpty = false) {
			$Name = 'IsCollection'; // 參數名稱
			$Value = $this->PostParams['IsCollection']; // 參數內容
			$ClassName = 'IsCollection'; // 合法資料 Class 名稱

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);

				// 目前物流類型(LogisticsType)宅配(Home)不支援代收貨款(IsCollection = Y)
				if ($this->PostParams['LogisticsType'] == LogisticsType::HOME and $Value == IsCollection::YES) {
					throw new Exception($Name . ' could not be Y, when LogisticsType is Home.');
				}
			}
		}

		/**
		 *  使用設備檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateDevice($AllowEmpty = false) {
			$Name = 'Device'; // 參數名稱
			$Value = $this->PostParams['Device']; // 參數內容
			$ClassName = 'Device'; // 合法資料 Class 名稱

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 資料型態檢查
				$this->IsInteger($Name, $Value);

				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  廠商交易時間檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
		private function ValidateMerchantTradeDate() {
			$Name = 'MerchantTradeDate'; // 參數名稱
			$Value = $this->PostParams['MerchantTradeDate']; // 參數內容
			$ClassName = 'MerchantTradeDate'; // 合法資料 Class 名稱
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 日期檢查
				$this->IsDate($Name, 'Y/m/d H:i:s', $Value);
			}
		}

		/**
		 *  溫層檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
		private function ValidateTemperature() {
			$Name = 'Temperature'; // 參數名稱
			$Value = $this->PostParams['Temperature']; // 參數內容
			$ClassName = 'Temperature'; // 合法資料 Class 名稱
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  距離檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
		private function ValidateDistance() {
			$Name = 'Distance'; // 參數名稱
			$Value = $this->PostParams['Distance']; // 參數內容
			$ClassName = 'Distance'; // 合法資料 Class 名稱
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  規格檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @version		1.0.1012
		 */
		private function ValidateSpecification() {
			$Name = 'Specification'; // 參數名稱
			$Value = $this->PostParams['Specification']; // 參數內容
			$ClassName = 'Specification'; // 合法資料 Class 名稱
			$AllowEmpty = false; // 是否允許空值

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  預定送達時段檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateScheduledDeliveryTime($AllowEmpty = false) {
			$Name = 'ScheduledDeliveryTime'; // 參數名稱
			$Value = $this->PostParams['ScheduledDeliveryTime']; // 參數內容
			$ClassName = 'ScheduledDeliveryTime'; // 合法資料 Class 名稱

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 內容檢查
				$this->IsLegalValue($Name, $ClassName, $Value);
			}
		}

		/**
		 *  物流訂單出貨日期檢查
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function ValidateShipmentDate($AllowEmpty = false) {
			$Name = 'ShipmentDate'; // 參數名稱
			$Value = $this->PostParams['ShipmentDate']; // 參數內容
			$ClassName = 'ShipmentDate'; // 合法資料 Class 名稱

			if (empty($Value)) {
				// 是否允許空值
				$this->IsAllowEmpty($Name, $AllowEmpty);
			} else {
				// 日期檢查
				$this->IsDate($Name, 'Y/m/d', $Value);
			}
		}

		/**
		 *  是否允許空值
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		boolean	$AllowEmpty	是否允許空值
		 * @return		boolean
		 * @version		1.0.1012
		 */
		private function IsAllowEmpty($Name, $AllowEmpty){
			if (!$AllowEmpty) {
				throw new Exception($Name . ' is required.');
			}
		}

		/**
		 *  是否超過長度限制
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name			參數名稱
		 * @param		Integer	$MaxLength		參數內容
		 * @param		Boolean	$AllowEmpty	是否允許空值
		 * @version		1.0.1012
		 */
		private function IsOverLength($Name, $Length, $MaxLength) {
			if ($Length > $MaxLength) {
				throw new Exception($Name . ' max length is ' . $MaxLength . '.');
			}
		}

		/**
		 *  是否為指定格式
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Pattern	格式檢查用正規表示法
		 * @param		String	$Value		參數內容
		 * @version		1.0.1012
		 */
		private function IsValidFormat($Name, $Pattern, $Value) {
			if (!empty($Value)) {
				if (!preg_match($Pattern, $Value)) {
					throw new Exception('Invalid ' . $Name . '.');
				}
			}
		}

		/**
		 *  是否為數值
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name		參數名稱
		 * @param		String	$Value		參數內容
		 * @version		1.0.1012
		 */
		private function IsInteger($Name, $Value) {
			if (!is_int($Value)) {
				throw new Exception($Name . ' type should be integer.');
			}
		}

		/**
		 *  是否為數值
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name			參數名稱
		 * @param		String	$ClassName		合法資料 Class 名稱
		 * @param		String	$Value			參數內容
		 * @version		1.0.1012
		 */
		private function IsLegalValue($Name, $ClassName, $Value) {
			// 取得合法資料內容
			$ReflectionObject = new ReflectionClass($ClassName);
			$ContentList = $ReflectionObject->getConstants();
			unset($ReflectionObject);

			// 檢查是否為合法資料
			if (!in_array($Value, $ContentList)) {
				throw new Exception('Illegal ' . $Name . '.');
			}
		}

		/**
		 *  是否為正確日期
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Validate
		 * @param		String	$Name			參數名稱
		 * @param		String	$Format			日期格式
		 * @param		String	$Value			參數內容
		 * @version		1.0.1012
		 */
		private function IsDate($Name, $Format, $Value) {
			if (date($Format, strtotime($Value)) != $Value){
				throw new Exception('Invalid ' . $Name . '.');
			}
		}

		/**
		 *  取得並過濾 $_POST 參數
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK_Misc
		 * @param		Array	$Source			$_POST 參數來源
		 * @param		Array	$ParamList		合法參數與預設值
		 * @param		Array	$MergeParams	其他待合併參數
		 * @return		Array
		 * @version		1.0.1012
		 */
		private function GetPostParams($Source, $ParamList, $MergeParams = array()) {
			// 過濾非法參數
			$PostParams = array();
			foreach ($ParamList as $Name => $Value) {
				if (isset($Source[$Name])) {
					$PostParams[$Name] = $Source[$Name];
				} else {
					// 若未設定則帶預設值
					$PostParams[$Name] = $Value;
				}
			}
			return array_merge($MergeParams, $PostParams);
		}

		/**
		 *  取得 ECPay URL
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK_Misc
		 * @param		String	$FunctionType	功能名稱
		 * @return		String
		 * @version		1.0.1012
		 */
		private function GetURL($FunctionType) {
			$MerchantID = $this->PostParams['MerchantID'];
			$UrlList = array();
			if ($MerchantID == ECPayTestMerchantID::B2C or $MerchantID == ECPayTestMerchantID::C2C) {
				// 測試環境
				$UrlList = array(
					'CVS_MAP' => ECPayTestURL::CVS_MAP,
					'SHIPPING_ORDER' => ECPayTestURL::SHIPPING_ORDER,
					'HOME_RETURN_ORDER' => ECPayTestURL::HOME_RETURN_ORDER,
					'FAMILY_RETURN_ORDER' => ECPayTestURL::FAMILY_RETURN_ORDER,
					'FAMILY_RETURN_CHECK' => ECPayTestURL::FAMILY_RETURN_CHECK,
					'UNIMART_UPDATE_LOGISTICS_INFO' => ECPayTestURL::UNIMART_UPDATE_LOGISTICS_INFO,
					'UNIMART_UPDATE_STORE_INFO' => ECPayTestURL::UNIMART_UPDATE_STORE_INFO,
					'UNIMART_CANCEL_LOGISTICS_ORDER' => ECPayTestURL::UNIMART_CANCEL_LOGISTICS_ORDER,
					'QUERY_LOGISTICS_INFO' => ECPayTestURL::QUERY_LOGISTICS_INFO,
					'PRINT_TRADE_DOC' => ECPayTestURL::PRINT_TRADE_DOC,
					'PRINT_UNIMART_C2C_BILL' => ECPayTestURL::PRINT_UNIMART_C2C_BILL,
					'PRINT_FAMILY_C2C_BILL' => ECPayTestURL::PRINT_FAMILY_C2C_BILL,
					'PRINT_HILIFE_C2C_BILL' => ECPayTestURL::PRINT_HILIFE_C2C_BILL,
				);
			} else {
				// 正式環境
				$UrlList = array(
					'CVS_MAP' => ECPayURL::CVS_MAP,
					'SHIPPING_ORDER' => ECPayURL::SHIPPING_ORDER,
					'HOME_RETURN_ORDER' => ECPayURL::HOME_RETURN_ORDER,
					'FAMILY_RETURN_ORDER' => ECPayURL::FAMILY_RETURN_ORDER,
					'FAMILY_RETURN_CHECK' => ECPayURL::FAMILY_RETURN_CHECK,
					'UNIMART_UPDATE_LOGISTICS_INFO' => ECPayURL::UNIMART_UPDATE_LOGISTICS_INFO,
					'UNIMART_UPDATE_STORE_INFO' => ECPayURL::UNIMART_UPDATE_STORE_INFO,
					'UNIMART_CANCEL_LOGISTICS_ORDER' => ECPayURL::UNIMART_CANCEL_LOGISTICS_ORDER,
					'QUERY_LOGISTICS_INFO' => ECPayURL::QUERY_LOGISTICS_INFO,
					'PRINT_TRADE_DOC' => ECPayURL::PRINT_TRADE_DOC,
					'PRINT_UNIMART_C2C_BILL' => ECPayURL::PRINT_UNIMART_C2C_BILL,
					'PRINT_FAMILY_C2C_BILL' => ECPayURL::PRINT_FAMILY_C2C_BILL,
					'PRINT_HILIFE_C2C_BILL' => ECPayURL::PRINT_HILIFE_C2C_BILL,
				);
			}

			return $UrlList[$FunctionType];
		}

		/**
		 *  加入換行字元
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Misc
		 * @param		String	$Content	內容
		 * @return		String
		 * @version		1.0.1012
		 */
		private function AddNextLine($Content) {
			return $Content . PHP_EOL;
		}

		/**
		 *  產生自動/手動 POST 提交表單
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK_Misc
		 * @param		String	$ButtonDesc	按鈕顯示名稱
		 * @param		String	$Target		表單 action 目標
		 * @return		String
		 * @version		1.0.1012
		 */
		private function GenPostHTML($ButtonDesc = '', $Target = '_self') {
			$PostHTML = $this->AddNextLine('<div style="text-align:center;">');
			$PostHTML .= $this->AddNextLine('  <form id="ECPayForm" method="POST" action="' . $this->ServiceURL . '" target="' . $Target . '">');
			foreach ($this->PostParams as $Name => $Value) {
				$PostHTML .= $this->AddNextLine('    <input type="hidden" name="' . $Name . '" value="' . $Value . '" />');
			}
			if (!empty($ButtonDesc)) {
				// 手動
				$PostHTML .= $this->AddNextLine('    <input type="submit" id="__paymentButton" value="' . $ButtonDesc . '" />');
			} else {
				// 自動
				$PostHTML .= $this->AddNextLine('    <script>document.getElementById("ECPayForm").submit();</script>');
			}
			$PostHTML .= $this->AddNextLine('  </form>');
			$PostHTML .= $this->AddNextLine('</div>');

			return $PostHTML;
		}

		/**
		 *  依編碼方式取得字串長度
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	Misc
		 * @param		String	$RetriveString	字串內容
		 * @param		String	$Encode 		字串編碼
		 * @return		Integer
		 * @version		1.0.1012
		 */
		private function StringLength($RetriveString, $Encode) {
			return mb_strwidth($RetriveString, $Encode);
		}

		/**
		 *  產生 CheckMacValue
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK_Misc
		 * @param		Array	$ParamList	參數內容
		 * @param		String	$HashKey	HashKey
		 * @param		String	$HashIV 	HashIV
		 * @return		String
		 * @version		1.0.1012
		 */
		private function GenCheckMacValue($ParamList, $HashKey, $HashIV) {
			// 依自定義 Function 按 Key 值排序
            uksort($ParamList, array('ECPayLogistics','MerchantSort'));

			// 組成 HTTP Query String
			$CheckMacValue = 'HashKey=' . $HashKey;
			foreach ($ParamList as $ParamName => $ParamValue) {
				$CheckMacValue .= '&' . $ParamName . '=' . $ParamValue;
			}
			$CheckMacValue .= '&HashIV=' . $HashIV;
			$CheckMacValue = strtolower(urlencode($CheckMacValue));

			// 取代特殊字元使其與 dotNet 相符
			$CheckMacValue = str_replace('%2d', '-', $CheckMacValue);
			$CheckMacValue = str_replace('%5f', '_', $CheckMacValue);
			$CheckMacValue = str_replace('%2e', '.', $CheckMacValue);
			$CheckMacValue = str_replace('%21', '!', $CheckMacValue);
			$CheckMacValue = str_replace('%2a', '*', $CheckMacValue);
			$CheckMacValue = str_replace('%28', '(', $CheckMacValue);
			$CheckMacValue = str_replace('%29', ')', $CheckMacValue);

			// MD5 編碼
			$CheckMacValue = strtoupper(md5($CheckMacValue));

			return $CheckMacValue;
		}

		/**
		 *  自定義排序方式
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK_Misc
		 * @param		String	$Value01	值1
		 * @param		String	$Value02	值2
		 * @return		Integer
		 * @version		1.0.1012
		 */
        private static function MerchantSort($Value01, $Value02) {
            return strcasecmp($Value01, $Value02);
        }

		/**
		 *  幕後提交
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK_Misc
		 * @param		Array	$ParamList	參數內容
		 * @param		String	$URL		提交 URL
		 * @return		Mixed
		 * @version		1.0.1012
		 */
		private function ServerPost($ParamList, $URL) {
			$Curl = curl_init();
			curl_setopt($Curl, CURLOPT_URL, $URL);
			curl_setopt($Curl, CURLOPT_HEADER, FALSE);
			curl_setopt($Curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($Curl, CURLOPT_SSL_VERIFYPEER, TRUE);
			curl_setopt($Curl, CURLOPT_POST, TRUE);
			curl_setopt($Curl, CURLOPT_POSTFIELDS, http_build_query($ParamList));
			$Result = curl_exec($Curl);
			curl_close($Curl);

			return $Result;
        }

		/**
		 *  解析 ECPay 回傳結果
		 *
		 * @author		https://www.ecpay.com.tw
		 * @category	SDK_Misc
		 * @param		String	$Feedback		回傳結果
		 * @param		Array	$FeedbackList	合法回傳參數
		 * @param		String	$Separator		分隔符號
		 * @return		Array
		 * @version		1.0.1012
		 */
		private function ParseFeedback($Feedback, $FeedbackList = array('RtnCode', 'RtnMsg'), $Separator = '|') {
			$Pieces = explode($Separator, $Feedback);
			$Feedback = array();
			// 回傳參數檢查
			if (count($Pieces) == count($FeedbackList)) {
				foreach ($FeedbackList as $Idx => $Name) {
					$Feedback[$Name] = $Pieces[$Idx];
				}
			} else {
				$Feedback['ParseMsg'] = 'Unknown feedback : ' . $Feedback;
			}
			return $Feedback;
		}
}
?>
