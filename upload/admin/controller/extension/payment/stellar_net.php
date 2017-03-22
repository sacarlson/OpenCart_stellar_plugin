<?php
class ControllerExtensionPaymentStellarNet extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/payment/stellar_net');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('stellar_net', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

        $data['entry_publicid'] = $this->language->get('entry_publicid');
        $data['entry_asset_code'] = $this->language->get('entry_asset_code');
        $data['entry_issuer'] = $this->language->get('entry_issuer');
        $data['entry_wallet_url'] = $this->language->get('entry_wallet_url');
        $data['entry_tx_callback_token'] = $this->language->get('entry_tx_callback_token');
        $data['entry_testnet_mode'] = $this->language->get('entry_testnet_mode');

		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_escrows_publicId'] = $this->language->get('entry_escrows_publicId');
        $data['entry_escrows_email'] = $this->language->get('entry_escrows_email');
        $data['entry_enable_escrow'] = $this->language->get('entry_enable_escrow');
        $data['entry_escrow_expire_hours'] = $this->language->get('entry_escrow_expire_hours');

		$data['help_total'] = $this->language->get('help_total');
        $data['help_asset_code'] = $this->language->get('help_asset_code');
        $data['help_publicid'] = $this->language->get('help_publicid');
        $data['help_issuer'] = $this->language->get('help_issuer');
        $data['help_wallet_url'] = $this->language->get('help_wallet_url');
        $data['help_tx_callback_token'] = $this->language->get('help_tx_callback_token');
        $data['help_testnet_mode'] = $this->language->get('help_testnet_mode');
        $data['help_escrows_publicId'] = $this->language->get('help_escrows_publicId');
        $data['help_escrows_email'] = $this->language->get('help_escrows_email');
        $data['help_enable_escrow'] = $this->language->get('help_enable_escrow');
        $data['help_escrow_expire_hours'] = $this->language->get('help_escrow_expire_hours');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/stellar_net', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/stellar_net', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);
        if (isset($this->request->post['stellar_net_publicid'])) {
			$data['stellar_net_publicid'] = $this->request->post['stellar_net_publicid'];
		} else {
			$data['stellar_net_publicid'] = $this->config->get('stellar_net_publicid');
		}

        if (isset($this->request->post['stellar_net_asset_code'])) {
			$data['stellar_net_asset_code'] = $this->request->post['stellar_net_asset_code'];
		} else {
			$data['stellar_net_asset_code'] = $this->config->get('stellar_net_asset_code');
		}

        if (isset($this->request->post['stellar_net_issuer'])) {
			$data['stellar_net_issuer'] = $this->request->post['stellar_net_issuer'];
		} else {
			$data['stellar_net_issuer'] = $this->config->get('stellar_net_issuer');
		}

        if (isset($this->request->post['stellar_net_wallet_url'])) {
			$data['stellar_net_wallet_url'] = $this->request->post['stellar_net_wallet_url'];
		} else {
			$data['stellar_net_wallet_url'] = $this->config->get('stellar_net_wallet_url');
		}

        if (isset($this->request->post['stellar_net_tx_callback_token'])) {
			$data['stellar_net_tx_callback_token'] = $this->request->post['stellar_net_tx_callback_token'];
		} else {
			$data['stellar_net_tx_callback_token'] = $this->config->get('stellar_net_tx_callback_token');
		}

        if (isset($this->request->post['stellar_net_escrows_email'])) {
			$data['stellar_net_escrows_email'] = $this->request->post['stellar_net_escrows_email'];
		} else {
			$data['stellar_net_escrows_email'] = $this->config->get('stellar_net_escrows_email');
		}

        if (isset($this->request->post['stellar_net_escrows_publicId'])) {
			$data['stellar_net_escrows_publicId'] = $this->request->post['stellar_net_escrows_publicId'];
		} else {
			$data['stellar_net_escrows_publicId'] = $this->config->get('stellar_net_escrows_publicId');
		}
        if (isset($this->request->post['stellar_net_enable_escrow'])) {
			$data['stellar_net_enable_escrow'] = $this->request->post['stellar_net_enable_escrow'];
		} else {
			$data['stellar_net_enable_escrow'] = $this->config->get('stellar_net_enable_escrow');
		}
        if (isset($this->request->post['stellar_net_escrow_expire_hours'])) {
			$data['stellar_net_escrow_expire_hours'] = $this->request->post['stellar_net_escrow_expire_hours'];
		} else {
			$data['stellar_net_escrow_expire_hours'] = $this->config->get('stellar_net_escrow_expire_hours');
		}
        if (isset($this->request->post['stellar_net_testnet_mode'])) {
			$data['stellar_net_testnet_mode'] = $this->request->post['stellar_net_testnet_mode'];
		} else {
			$data['stellar_net_testnet_mode'] = $this->config->get('stellar_net_testnet_mode');
		}

		if (isset($this->request->post['stellar_net_total'])) {
			$data['stellar_net_total'] = $this->request->post['stellar_net_total'];
		} else {
			$data['stellar_net_total'] = $this->config->get('stellar_net_total');
		}

		if (isset($this->request->post['stellar_net_order_status_id'])) {
			$data['stellar_net_order_status_id'] = $this->request->post['stellar_net_order_status_id'];
		} else {
			$data['stellar_net_order_status_id'] = $this->config->get('stellar_net_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['stellar_net_geo_zone_id'])) {
			$data['stellar_net_geo_zone_id'] = $this->request->post['stellar_net_geo_zone_id'];
		} else {
			$data['stellar_net_geo_zone_id'] = $this->config->get('stellar_net_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['stellar_net_status'])) {
			$data['stellar_net_status'] = $this->request->post['stellar_net_status'];
		} else {
			$data['stellar_net_status'] = $this->config->get('stellar_net_status');
		}

		if (isset($this->request->post['stellar_net_sort_order'])) {
			$data['stellar_net_sort_order'] = $this->request->post['stellar_net_sort_order'];
		} else {
			$data['stellar_net_sort_order'] = $this->config->get('stellar_net_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/stellar_net', $data));
	}

    public function editOrderStatus($order_id,$order_status){
       $this->load->model('extension/payment/stellar_net');
       //$this->model_extension_payment_stellar_net->editstellar_netOrderStatus($order_id, 'Complete');
       $this->model_extension_payment_stellar_net->editstellar_netOrderStatus($order_id, $order_status);
    }

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/stellar_net')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
