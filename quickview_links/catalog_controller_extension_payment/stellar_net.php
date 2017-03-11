<?php
class ControllerExtensionPaymentStellarNet extends Controller {
	public function index() {
        $this->load->language('extension/payment/stellar_net');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_title'] = $this->language->get('text_title');
        $data['text_click_link'] = $this->language->get('text_click_link');
        $data['text_click_link'] = $this->language->get('text_click_link');
        $data['text_or_send'] = $this->language->get('text_or_send');
        $data['text_or_scan'] = $this->language->get('text_or_scan');
        $data['text_amount'] = $this->language->get('text_amount');
        $data['text_asset_code'] = $this->language->get('text_asset_code');
        $data['text_issuer'] = $this->language->get('text_issuer');
        $data['text_to_PublicId'] = $this->language->get('text_to_PublicId');
        $data['text_memo'] = $this->language->get('text_memo');

		$data['continue'] = $this->url->link('checkout/success');

        $this->load->model('checkout/order');
        $data['testmode'] = $this->config->get('stellar_net_test');
        $data['asset_code'] = $this->config->get('stellar_net_asset_code');
        $data['issuer'] = $this->config->get('stellar_net_issuer');
        

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $data['stellar_net_publicid'] = $this->config->get('stellar_net_publicid');

        $data['order_id'] = $this->session->data['order_id'];
        $data['currency_code'] = $order_info['currency_code'];
        $data['currency_value'] = $order_info['currency_value'];
        $data['total_currency'] =  $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['total'] = $order_info['total'];


		return $this->load->view('extension/payment/stellar_net', $data);
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'stellar_net') {
			$this->load->model('checkout/order');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('stellar_net_order_status_id'));
		}
	}
}
