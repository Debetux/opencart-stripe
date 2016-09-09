<?php
class ModelExtensionPaymentStripe extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/stripe');

		$status = true;

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'stripe',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('stripe_sort_order')
			);
		}

		return $method_data;
	}

	public function addOrder($order_info, $stripe_charge_id, $environment = 'test') {

		$this->db->query("INSERT INTO `" . DB_PREFIX . "stripe_order` SET `order_id` = '" . (int)$order_info['order_id'] . "', `stripe_order_id` = '" . $stripe_charge_id . "', `environment` = '" . $environment . "'");

		return $this->db->getLastId();
	}
}
