<?php
class ControllerExtensionPaymentStripe extends Controller {
	public function index() {
		$this->load->language('extension/payment/stripe');

		if($this->config->get('stripe_environment') == 'live') {
			$data['publishable_key'] = $this->config->get('stripe_live_publishable_key');
		} else {
			$data['publishable_key'] = $this->config->get('stripe_test_publishable_key');
		}

		$data['text_credit_card'] = $this->language->get('text_credit_card');
		$data['text_start_date'] = $this->language->get('text_start_date');
		$data['text_wait'] = $this->language->get('text_wait');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_cc_type'] = $this->language->get('entry_cc_type');
		$data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$data['entry_cc_start_date'] = $this->language->get('entry_cc_start_date');
		$data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
		$data['entry_cc_issue'] = $this->language->get('entry_cc_issue');

		$data['help_start_date'] = $this->language->get('help_start_date');
		$data['help_issue'] = $this->language->get('help_issue');

		$data['button_confirm'] = $this->language->get('button_confirm');

		return $this->load->view('extension/payment/stripe', $data);
	}

	public function send() {
		$json = array();

		$this->load->library('stripe');
		$this->load->model('checkout/order');
		$this->load->model('extension/payment/stripe');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);


		if($this->config->get('stripe_environment') == 'live') {
			$stripe_secret_key = $this->config->get('stripe_live_secret_key');
		} else {
			$stripe_secret_key = $this->config->get('stripe_test_secret_key');
		}

		\Stripe\Stripe::setApiKey($stripe_secret_key);
		

		$charge = \Stripe\Charge::create(
			array(
				'card' => $this->request->post['card'],
				'amount' => $order_info['total'] * 100,
				'currency' => $this->config->get('stripe_currency'),
				'metadata' => array(
					'orderId' => $this->session->data['order_id']
				)
			)
		);

		if(isset($charge['id'])) {
			$this->model_extension_payment_stripe->addOrder($order_info, $charge['id'], $this->config->get('stripe_environment'));
			$message = 'Charge ID: '.$charge['id'].' Status:'. $charge['status'];
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('stripe_order_status_id'), $message, false);
			$json['processed'] = true;
		}


		// addOrderHistory
		$json['success'] = $this->url->link('checkout/success');
		// $json['error'] = $response_info['L_LONGMESSAGE0'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
