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
        $data['text_for_escrow_select'] = $this->language->get('text_for_escrow_select');
        $data['text_escrow_signer_publicId'] = $this->language->get('text_escrow_signer_publicId');
        $data['text_escrow_agent_email'] = $this->language->get('text_escrow_agent_email');
        $data['text_escrow_fee'] =  $this->language->get('text_escrow_fee');
        $data['text_escrow_expires_on'] =  $this->language->get('text_escrow_expires_on');

		$data['continue'] = $this->url->link('checkout/success');

        $this->load->model('checkout/order');
        $data['testmode'] = $this->config->get('stellar_net_testnet_mode');
        $data['asset_code'] = $this->config->get('stellar_net_asset_code');
        $data['issuer'] = $this->config->get('stellar_net_issuer');
        
        

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $data['stellar_net_publicid'] = $this->config->get('stellar_net_publicid');
        $data['callback_url'] = $this->config->get('stellar_net_tx_callback_url');
        $data['base_url'] = $this->config->get('config_url');
        $data['callback_url'] = $data['base_url'] . '?route=extension/payment/stellar_net/get_tx&';

        $data['escrow_min_fee'] = 10;
        $data['escrow_pct_fee'] =1;
        $data['escrow_currency_value_mult'] = 500;
        $data['enable_escrow'] =$this->config->get('stellar_net_enable_escrow');
        $data['escrow_expire_hours'] = $this->config->get('stellar_net_escrow_expire_hours');
        $data['escrows_publicId'] = $this->config->get('stellar_net_escrows_publicId');
        $data['escrows_email'] = $this->config->get('stellar_net_escrows_email');
        $data['escrow_expires_ts'] = time() + ($data['escrow_expire_hours'] * 60 *60);
        $data['escrow_expires_dt'] = date('Y-m-d', $data['escrow_expires_ts']);
        $data['escrow_callback'] = $data['base_url'].'?route=extension/payment/stellar_net/submit_escrow&';  
        

        $data['order_id'] = $this->session->data['order_id'];
        $data['currency_code'] = $order_info['currency_code'];
        $data['currency_value'] = $order_info['currency_value'];
        $data['total_currency'] =  $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        $data['total'] = $order_info['total'];
        $data['escrow_fee_xlm'] = round($data['escrow_min_fee'] + ($data['escrow_pct_fee']*.01* $data['escrow_currency_value_mult']));
        
        $data['qrcode_v1'] = '%7B%22destination%22:%22' . $data['stellar_net_publicid'] . '%22,%22amount%22:%22' . $data['total'] . '%22,%22asset%22:%22' . $data['asset_code'] . '%22,%22issuer%22:%22' . $data['issuer'] . '%22,%22memo%22:%22' . $data['order_id'] . '%22%7D';
       
        $data['wallet_url'] = $this->config->get('stellar_net_wallet_url');
                   
        $data['qrcode_vx'] = '%7B%22tx_tag%22:%22' . $data['order_id'] . '%22,%22callback%22:%22' . $data['callback_url'] . '%22,%22ver%22:%22';     
        //$data['qrcode_v2'] = '%7B%22tx_tag%22:%22' . $data['order_id'] . '%22,%22callback%22:%22' . $data['callback_url'] . '%22,%22ver%22:%222.0%22%7D';
        //$data['qrcode_v2_1'] = '%7B%22tx_tag%22:%22' . $data['order_id'] . '%22,%22callback%22:%22' . $data['callback_url'] . '%22,%22ver%22:%222.1%22%7D';
        $data['qrcode_v2'] =   $data['qrcode_vx'] . '2.0%22%7D';
        $data['qrcode_v2_1'] = $data['qrcode_vx'] . '2.1%22%7D';
        $data['qrcode_v3_0'] = $data['qrcode_vx'] . '3.0%22%7D';
        $data['qrcode_url'] = $data['wallet_url'] . '/?json=' . $data['qrcode_v1'];		
        $data['qrcode_url_v2'] = $data['wallet_url'] . '/?json=' . $data['qrcode_v2'];
        $data['qrcode_url_v3'] = $data['wallet_url'] . '/?json=' . $data['qrcode_vx'] . '3.0%22%7D';
        $data['qrcode_link'] = '<a href="' . $data['qrcode_url'] . '" target="_blank"> Pay with My_wallet</a>';
        //$data['qrcode_link_v2'] = '<a href="' . $data['qrcode_url_v2'] . '" target="_blank"> Pay with My_wallet</a>';
        //$data['qrcode_link_v3'] = '<a href="' . $data['qrcode_url_v2x'] . '3.0%22%7D" target="_blank"> Pay with My_wallet</a>';
        $sg = new \stdClass();
        $sg->stellar = new \stdClass();
        $sg->stellar->payment = new \stdClass();
        $sg->stellar->payment->destination = $data['stellar_net_publicid'];
        if ($data['testmode']=="1"){
          $sg->stellar->payment->network = "cee0302d";
        } else {
          $sg->stellar->payment->network = "7ac33997";
        }
        $sg->stellar->payment->amount = $data['total'];
        $sg->stellar->payment->asset = new \stdClass();
        $sg->stellar->payment->asset->code = $data['asset_code'];
        $sg->stellar->payment->asset->issuer = $data['issuer'];
        $sg->stellar->payment->memo = new \stdClass();
        $sg->stellar->payment->memo->type = "text";
        $sg->stellar->payment->memo->value = $data['order_id'];
        //$sg->stellar->version = $data['version'];
        //$data['stargazer_qrcode_json'] = json_encode($sg);
        
        // v2.2 stargazer with added urlencoding
        $data['qrcode_v2_2'] = urlencode(json_encode($sg));
        // v2.3 should be compatible with stargazer wallet , can't use this causes problem in php code
        $data['qrcode_v2_3'] = json_encode($sg);
        $data['stargazer_qrcode_obj'] = $sg;
        
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

   public function getstellar_netOrder($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "stellar_net_order` WHERE `order_id` = '" . (int)$order_id . "'");

		return $query->row;
	}


   public function get_tx() {
     // http://b.funtracker.site/store/?route=extension/payment/stellar_net/get_tx&tx_tag=1&ver=2.1
     // returns: %7B%22destination%22:%22GDUPQLNDVSUKJ4XKQQDITC7RFYCJTROCR6AMUBAMPGBIZXQU4UTAGX7C%22,%22amount%22:%2285.0000%22,%22asset%22:%22USD%22,%22issuer%22:%22GCEZWKCA5VLDNRLN3RPRJMRZOX3Z6G5CHCGSNFHEYVXM3XOJMDS674JZ%22,%22memo%22:%221%22%7D
     // if ver >= "2.1" we output stargazer json format
     $this->load->model('checkout/order');
     //$data['base_url'] = $this->config->get('config_url');
     //echo "base URL: " . $data['base_url'];
     if (isset($this->request->get['tx_tag'])) {
       //tx_tag in this case is the order_id
       $data['order_id'] = $this->request->get['tx_tag'];
     } else {
       echo "bad tx_tag";
       return;
     }
     
     $data['base_url'] = $this->config->get('config_url');
     $order_info = $this->model_checkout_order->getOrder($data['order_id']);
     $data['order_status'] = $order_info['order_status'];

     $stellar_order_info = $this->getstellar_netOrder($data['order_id']);
     if (isset($stellar_order_info['capture_status'])){
       $data['stellar_order_status'] = $stellar_order_info['capture_status'];
     }else{
       $data['stellar_order_status'] = "0";
     }

     $data['testmode'] = $this->config->get('stellar_net_testnet_mode');
     $data['stellar_net_publicid'] = $this->config->get('stellar_net_publicid');
     $data['asset_code'] = $this->config->get('stellar_net_asset_code');
     $data['issuer'] = $this->config->get('stellar_net_issuer');

     $data['escrows_publicId'] = $this->config->get('stellar_net_escrows_publicId');
     $data['escrows_email'] = $this->config->get('stellar_net_escrows_email');
     $data['escrow_expire_hours'] = $this->config->get('stellar_net_escrow_expire_hours');
     $data['enable_escrow'] = $this->config->get('stellar_net_enable_escrow');
     $data['version'] = $this->request->get['ver'];
     $data['escrow_min_fee'] = 10;
     $data['escrow_pct_fee'] = 0.5;
     $data['escrow_currency_value_mult'] = 500;

     $data['escrow_expires_ts'] = time() + ($data['escrow_expire_hours'] * 60 *60);
     $data['escrow_expires_dt'] = date('Y-m-d', $data['escrow_expires_ts']);

     $data['total'] = $order_info['total'];
     $data['qrcode_json'] = '%7B%22destination%22:%22' . $data['stellar_net_publicid'] . '%22,%22amount%22:%22' . $data['total'] . '%22,%22asset%22:%22' . $data['asset_code'] . '%22,%22issuer%22:%22' . $data['issuer'] . '%22,%22memo%22:%22' . $data['order_id'] . '%22,%22ver%22:%22' . $data['version'] . '%22%7D';

     $data['escrow_fee'] = $data['escrow_min_fee'] + ($data['escrow_currency_value_mult'] * $data['escrow_pct_fee'] * 0.01 * $data['total']);
     $sg = new \stdClass();
        $sg->stellar = new \stdClass();
        $sg->stellar->payment = new \stdClass();
        $sg->stellar->payment->destination = $data['stellar_net_publicid'];
        if ($data['testmode'] == "1"){
          $sg->stellar->payment->network = "cee0302d";
        } else {
          $sg->stellar->payment->network = "7ac33997";
        }
        $sg->stellar->payment->amount = $data['total'];
        $sg->stellar->payment->asset = new \stdClass();
        $sg->stellar->payment->asset->code = $data['asset_code'];
        $sg->stellar->payment->asset->issuer = $data['issuer'];
        $sg->stellar->payment->memo = new \stdClass();
        $sg->stellar->payment->memo->type = "text";
        $sg->stellar->payment->memo->value = $data['order_id'];
        $sg->stellar->payment->order_status = $data['order_status'];
        if ($data['enable_escrow'] == "1"){
          $sg->stellar->payment->escrow = new \stdClass();
          $sg->stellar->payment->escrow->publicId = $data['escrows_publicId'];
          $sg->stellar->payment->escrow->email = $data['escrows_email'];
          $sg->stellar->payment->escrow->expire_ts = $data['escrow_expires_ts'];
          $sg->stellar->payment->escrow->expire_dt = $data['escrow_expires_dt']; 
          $sg->stellar->payment->escrow->status = $data['stellar_order_status'];
          $sg->stellar->payment->escrow->fee = $data['escrow_fee'];
          //$sg->stellar->payment->escrow->currency_value_mult = $data['escrow_currency_value_mult'];
          $sg->stellar->payment->escrow->callback = $data['base_url'].'?route=extension/payment/stellar_net/submit_escrow&';           
        }
        $sg->stellar->version = $data['version'];
        $data['stargazer_qrcode_json'] = json_encode($sg);
     if (isset($this->request->get['ver'])) {
       if (floatval($this->request->get['ver']) >= 2.1) {
         echo $data['stargazer_qrcode_json'];
       }else {
         echo $data['qrcode_json'];
       }
     }else {
       echo $data['qrcode_json'];
     }
     
   }
 
   public function addTransaction($order_id, $escrow_b64_tx, $escrow_publicId, $escrow_expire_ts, $total, $status = "0") {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "stellar_net_order` SET `order_id` = '" . (int)$order_id . "', `escrow_b64_tx` = '" . $escrow_b64_tx . "', `escrow_expire_ts` = FROM_UNIXTIME(" . (int)$escrow_expire_ts . "), `date_added` = now(), `escrow_publicId` = '" . $escrow_publicId . "', `capture_status` = '" . $status . "', `total` = '" . $total . "'");
   }

   public function add_stellar_net_order_Table(){
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
   }


   public function submit_escrow(){
     // http://b.funtracker.site/store/?route=extension/payment/stellar_net/submit_escrow&tx_tag=1&exp=49851234&escPID=GTYUE...&b64_tx=iewotu...

//var ss = remote_txData.escrow.callback + 'tx_tag=' + params['tx_tag'] + "&b64_tx=" + envelope_b64.value + "&exp=" + remote_txData.stellar.payment.escrow.expire_ts + "&escPID=" + remote_txData.keypair_escrow.publicKey();

     // this table add should have been done in install but didn't work for reasons unknow at this time
     // I guess doesn't hurt here for now. can be commented out after first transaction if you like.
     $this->add_stellar_net_order_Table();

     $this->load->model('checkout/order');
     //$data['base_url'] = $this->config->get('config_url');
     //echo "base URL: " . $data['base_url'];
     if (isset($this->request->get['tx_tag'])) {
       //tx_tag in this case is the order_id
       $data['order_id'] = $this->request->get['tx_tag'];
     } else {
       echo "bad_tx_tag";
       return;
     }
     
     $order_info = $this->model_checkout_order->getOrder($data['order_id']);
     $data['testmode'] = $this->config->get('stellar_net_testnet_mode');
     $data['asset_code'] = $this->config->get('stellar_net_asset_code');
     $data['issuer'] = $this->config->get('stellar_net_issuer');
     $data['total'] = $order_info['total'];

     //$data['escrows_publicId'] = $this->config->get('stellar_net_escrows_publicId');
     $data['escrows_email'] = $this->config->get('stellar_net_escrows_email');
     $data['escrow_expire_hours'] = $this->config->get('stellar_net_escrow_expire_hours');
     $data['enable_escrow'] = $this->config->get('stellar_net_enable_escrow');

     //$data['version'] = $this->request->get['ver'];
     $data['b64_timed_tx_env'] = $this->request->get['b64_tx'];
     $data['escrow_expire_timestamp'] = $this->request->get['exp'];
     $data['escrow_holding_publicId'] = $this->request->get['escPID'];
     //$data['escrow_min_fee'] = 10;
     //$data['escrow_pct_fee'] =1;
     //$data['escrow_currency_value_mult'] = 500;
     //$data['escrow_min_fee'] = config->get('stellar_net_escrow_min_fee');
     //$data['escrow_pct_fee'] = config->get('stellar_net_escrow_pct_fee');
     //$data['escrow_currency_value_mult'] = config->get('stellar_net_escrow_currency_value_mult');

//addTransaction($order_id, $escrow_b64_tx, $escrow_publicId, $escrow_expire_ts, $total, $status = "0") 

     $this->addTransaction($data['order_id'], $data['b64_timed_tx_env'], $data['escrow_holding_publicId'], $data['escrow_expire_timestamp'], $data['total'],"0");

     echo "escrow_submit_accepted";
     
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
