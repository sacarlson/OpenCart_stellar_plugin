<?php
// Heading
$_['heading_title']      = 'Stellar.org Network Payment';

// Text
$_['text_extension']     = 'Extensions';
$_['text_success']       = 'Success: You have modified Stellar.org Net payment module!';
$_['text_edit']          = 'Edit Stellar.org net Delivery';

// Entry
$_['entry_publicid']     = 'PublicId';
$_['entry_asset_code']   = 'Asset Code';
$_['entry_issuer']       = 'Issuer';
$_['entry_wallet_url']   = 'My_wallet URL';
$_['entry_tx_callback_token'] = 'Callback Security Token';
$_['entry_testnet_mode'] = 'TestNet Mode';
$_['entry_escrows_publicId'] = 'Escrow Services PublicId';
$_['entry_escrows_email'] = 'Escrow Services Email';
$_['entry_enable_escrow'] = 'Enable Escrow';
$_['entry_escrow_expire_hours'] = 'Escrow Expire hours';

$_['entry_total']        = 'Total';
$_['entry_order_status'] = 'Order Status';
$_['entry_geo_zone']     = 'Geo Zone';
$_['entry_status']       = 'Status';
$_['entry_sort_order']   = 'Sort Order';

// Help
$_['help_total']         = 'The checkout total the order must reach before this payment method becomes active.';
$_['help_asset_code']    = 'The asset_code accepted to be recieved on stellar.org net example USD, if XLM is used, issuer input is not needed';
$_['help_publicid']      = 'The stellar.org net PublicId that payment of purchases will be sent to, example GDUPQ...';
$_['help_issuer']        = 'The stellar.org net Issuer Address of the asset_code that will be used in payment , example GBUY...';
$_['help_wallet_url']    = 'URL address of the My_wallet web app that is an option to make payments';
$_['help_tx_callback_token'] = 'Security Token sent from Stellar bridge to prove that stellar bridge sent the payment update info';
$_['help_testnet_mode'] = 'Tell the customer that you are running in steller.org testnet mode (not real money), Yes for testnet, No for Live mode';
$_['help_escrows_publicId'] = 'The Stellar.org PublicId address of the 3rd party escrow signer.';
$_['help_escrows_email'] = 'Email address of the 3rd party escrow signer';
$_['help_enable_escrow'] = 'If value is set to no or blank then escrow service mode will not be an option in checkout, default is blank (disabled) '; 
$_['help_escrow_expire_hours'] = 'The number of hours before the time based transaction becomes valid for payment of the purchase in the event buyer doesnt clear';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment Stellar.org Net Delivery!';
