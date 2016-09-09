<?php
class ModelExtensionPaymentStripe extends Model {
	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "stripe_order` (
			`stripe_order_id` varchar(255) NOT NULL,
			`order_id` int(11) NOT NULL DEFAULT '0',
			`environment` varchar(5) NOT NULL DEFAULT 'test',
			PRIMARY KEY (`stripe_order_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "stripe_card` (
			  `card_id` INT(11) NOT NULL AUTO_INCREMENT,
			  `customer_id` INT(11) NOT NULL,
			  `token` VARCHAR(255) NOT NULL,
			  `digits` VARCHAR(4) NOT NULL,
			  `expiry` VARCHAR(5) NOT NULL,
			  `type` VARCHAR(50) NOT NULL,
			  `environment` varchar(5) NOT NULL DEFAULT 'test',
			  PRIMARY KEY (`card_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "stripe_order`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "stripe_card`");

		$this->disableStripeExtension();

		$this->log('Module uninstalled');
	}


	public function getOrder($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "stripe_order` WHERE `order_id` = '" . $order_id . "' LIMIT 1");

		if ($query->num_rows) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function log($data) {
		if ($this->config->has('stripe_logging') && $this->config->get('stripe_logging')) {
			$log = new Log('stripe.log');

			$log->write($data);
		}
	}
}
