<?php
class ControllerExtensionPaymentStellarNet extends Controller {
	public function index() {
        $this->load->language('extension/payment/stellar_net');
        //$this->document->addScript('catalog/view/javascript/qrcode/qrcode.js');
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
        $data['text_testmode'] = $this->language->get('text_testmode');

		$data['continue'] = $this->url->link('checkout/success');

        $this->load->model('checkout/order');
        $data['testmode'] = $this->config->get('stellar_net_testnet_mode');
        $data['asset_code'] = $this->config->get('stellar_net_asset_code');
        $data['issuer'] = $this->config->get('stellar_net_issuer');
        

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $data['stellar_net_publicid'] = $this->config->get('stellar_net_publicid');
        $data['callback_url'] = $this->config->get('stellar_net_tx_callback_url');

        $data['order_id'] = $this->session->data['order_id'];
        $data['currency_code'] = $order_info['currency_code'];
        $data['currency_value'] = $order_info['currency_value'];
        $data['total_currency'] =  $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['total'] = $order_info['total'];
        $data['qrcode_json'] = '%7B%22destination%22:%22' . $data['stellar_net_publicid'] . '%22,%22amount%22:%22' . $data['total'] . '%22,%22asset%22:%22' . $data['asset_code'] . '%22,%22issuer%22:%22' . $data['issuer'] . '%22,%22memo%22:%22' . $data['order_id'] . '%22%7D';
        $data['wallet_url'] = 'https://wallet.funtracker.site';
        $data['qrcode_url'] = $data['wallet_url'] . '/?json=' . $data['qrcode_json'];
        $data['qrcode_link'] = '<a href="' . $data['qrcode_url'] . '" target="_blank"> Pay with My_wallet</a>';
        $data['qrcode_v2'] = '%7B%22tx_tag%22:%22' . $data['order_id'] . '%22,%22callback%22:%22' . $data['callback_url'] . '%22,%22ver%22:%222.0%22%7D';
		return $this->load->view('extension/payment/stellar_net', $data);
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'stellar_net') {
			$this->load->model('checkout/order');

			//$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('stellar_net_order_status_id'));
		}
	}
   


   public function updateOrderStatus($order_id, $status_id, $comment = '') {
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order_history` (`order_id`, `order_status_id`, `notify`, `comment`, `date_added`) VALUES (" . (int)$order_id . ", " . (int)$status_id . ", 0, '". $comment ."' , NOW())");

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET `order_status_id` = " . (int)$status_id . " WHERE `order_id` = " . (int)$order_id);
	}

   public function get_tx() {
     // http://b.funtracker.site/store/?route=extension/payment/stellar_net/get_tx&tx_tag=1
     // returns: %7B%22destination%22:%22GDUPQLNDVSUKJ4XKQQDITC7RFYCJTROCR6AMUBAMPGBIZXQU4UTAGX7C%22,%22amount%22:%2285.0000%22,%22asset%22:%22USD%22,%22issuer%22:%22GCEZWKCA5VLDNRLN3RPRJMRZOX3Z6G5CHCGSNFHEYVXM3XOJMDS674JZ%22,%22memo%22:%221%22%7D
     $this->load->model('checkout/order');
     if (isset($this->request->get['tx_tag'])) {
       //tx_tag in this case is the order_id
       $data['order_id'] = $this->request->get['tx_tag'];
     } else {
       echo "bad tx_tag";
       return;
     }
     $order_info = $this->model_checkout_order->getOrder($data['order_id']);
     $data['stellar_net_publicid'] = $this->config->get('stellar_net_publicid');
     $data['asset_code'] = $this->config->get('stellar_net_asset_code');
     $data['issuer'] = $this->config->get('stellar_net_issuer');
     $data['total'] = $order_info['total'];
     $data['qrcode_json'] = '%7B%22destination%22:%22' . $data['stellar_net_publicid'] . '%22,%22amount%22:%22' . $data['total'] . '%22,%22asset%22:%22' . $data['asset_code'] . '%22,%22issuer%22:%22' . $data['issuer'] . '%22,%22memo%22:%22' . $data['order_id'] . '%22%7D';
     echo $data['qrcode_json'];
   }

   public function callback() {
     // for test you can enter memo and amount and token with get
     //http://b.funtracker.site/store/?route=extension/payment/stellar_net/callback&memo=1&amount=85&token=123
     // when stellar bridge is used you just need add the token at the end for the bridge callback config
     // http://b.funtracker.site/store/?route=extension/payment/stellar_net/callback&token=123
     //echo "callback detected </br>";
     $this->load->model('checkout/order');
     if (isset($this->request->get['token'])) {
       $token = $this->request->get['token'];
       if ($token != $this->config->get('stellar_net_tx_callback_token')) {
          echo "bad token </br>";
          return;
       }
     } else {
       echo "no token </br>";
       return;
     }

     if (isset($this->request->post['memo'])){
       $order_id = $this->request->post['memo'];
     } else { 
       //return;
     }

     if (isset($this->request->get['memo'])) {
        $order_id = $this->request->get['memo'];
     }

     if (isset($this->request->post['amount'])){
        $total_rec = $this->request->post['amount'];
     } else {
       $total_rec = 0;
     }

     if (isset($this->request->get['amount'])) {
        $total_rec = $this->request->get['amount'];
     } 

     if (isset($this->request->post['from'])){
        $from = $this->request->post['from'];
     } else {
       $from = '';
     }

     if (isset($this->request->post['asset_code'])){
        $asset_code = $this->request->post['asset_code'];
     } else {
       $asset_code = '';
     }

     if (isset($this->request->post['route'])){
        $route = $this->request->post['route'];
     } else {
       $route = '';
     }

     if (isset($this->request->post['id'])){
        $id = $this->request->post['id'];
     } else {
       $id = '';
     }

     if (isset($this->request->post['memo_type'])){
        $memo_type = $this->request->post['memo_type'];
     } else {
        $memo_type = '';
     }

     //echo "order_id: " . $order_id . "</br>";
     
     $order_info = $this->model_checkout_order->getOrder(intval($order_id));
     $total_currency =  $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
     $total = $order_info['total'];
     //echo "Total: " . $total . "</br>"; 
     if ($total_rec > 0){
        $comment = "order_id: " . $order_id . " , Order_total: " . $total . " , Amount rec: " . $total_rec . ", From: " . $from . ", Asset_code: " . $asset_code . ", Route: " . $route . ", Id: " . $id . " Memo_type: " . $memo_type . ", Total_currency: " . $total_currency . ", currency_code: " . $order_info['currency_code'] . ", currency_value: " . $order_info['currency_value'] ;
       if ($total_rec == $total) {
         $status_id = 15; // processed
         //$status_id = 5; // complete 
       }else {
         $status_id = 10; // failed
       }
     } else {
        header("HTTP/1.0 404 Not Found");
        $comment = "order_id: " . $order_id . " , order_total: " . $total . " Total_rec = 0, 404 error sent";
        $status_id = 10; // failed
        //return;
     }
        
     $this->updateOrderStatus($order_id, $status_id, $comment);

     //echo "test: " . $this->url->link('extension/payment/stellar_net/callback');
     // test: http://b.funtracker.site/store/index.php?route=extension/payment/stellar_net/callback
     //echo "OK: "; 
   }
}
