<?php
class ModelExtensionPaymentStellarNet extends Model {
	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "stellar_net_order` (
			  `stellar_net_order_id` int(11) NOT NULL AUTO_INCREMENT,
			  `order_id` int(11) NOT NULL,
			  `date_added` DATETIME NOT NULL,
			  `date_modified` DATETIME NOT NULL,
			  `capture_status` TEXT DEFAULT NULL,
			  `currency_code` CHAR(3) NOT NULL,
              `from_public_id` CHAR(60) NOT NULL,
              `to_public_id` CHAR(60) NOT NULL,
              `asset_code` CHAR(20) NOT NULL,
              `issuer` CHAR(60) NOT NULL,
              `memo` CHAR(60) NOT NULL,
              `escrow_b64_tx` TEXT NOT NULL,
              `escrow_publicId` TEXT NOT NULL,
              `escrow_expire_ts` DATETIME NOT NULL,
              `escrow_collected` INT(1) DEFAULT NULL,
			  `total` DECIMAL( 10, 2 ) NOT NULL,
			  PRIMARY KEY (`stellar_net_order_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci
		");

		

	public function uninstall() {		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "stellar_net_order`");
	}

	public function getstellar_netOrder($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "stellar_net_order` WHERE `order_id` = '" . (int)$order_id . "'");

		return $query->row;
	}

	public function editstellar_netOrderStatus($order_id, $capture_status) {
		$this->db->query("UPDATE `" . DB_PREFIX . "stellar_net_order` SET `capture_status` = '" . $this->db->escape($capture_status) . "', `date_modified` = NOW() WHERE `order_id` = '" . (int)$order_id . "'");
	}

	

	public function getCurrencies() {
		return array(
			'AUD',
			'BRL',
			'CAD',
			'CZK',
			'DKK',
			'EUR',
			'HKD',
			'HUF',
			'ILS',
			'JPY',
			'MYR',
			'MXN',
			'NOK',
			'NZD',
			'PHP',
			'PLN',
			'GBP',
			'SGD',
			'SEK',
			'CHF',
			'TWD',
			'THB',
			'TRY',
			'USD',
		);
	}

	

	public function log($data, $title = null) {
		if ($this->config->get('pp_express_debug')) {
			$this->log->write('stellar_net Express debug (' . $title . '): ' . json_encode($data));
		}
	}

	public function getOrder($order_id) {
		$qry = $this->db->query("SELECT * FROM `" . DB_PREFIX . "stellar_net_order` WHERE `order_id` = '" . (int)$order_id . "' LIMIT 1");

		if ($qry->num_rows) {
			$order = $qry->row;			
			return $order;
		} else {
			return false;
		}
	}

	

