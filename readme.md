# Stellar Payment Plugin for OpenCart #

### Details about OpenCart ###
You will need to install OpenCart to use this payment plugin.  For details on how to download, install and detailed documentation see: https://www.opencart.com/.  to download: https://www.opencart.com/index.php?route=cms/download.  Note this plugin was write to support OpenCart version: 2.3.0.2.  The plugin has not been tested on any other version.

### How to install Stellar Payment Plugin ###
Basic install copy upload dir in this distribution to the base dir of your pre-installed and running OpenCart.  Also copy install.sh script to the base dir.  cd into base dir and run the script.  This will just copy the files from the ./upload directory into the base install.  You can choose to manually copy each file to it's location if you so desire.

I also created a link_install.sh that does much the same as install.sh but just creates symbolic links to the locations needed from the ./upload dir at the base.  This was created to aid in development so you can just copy your upload dir into base and it will already be linked into the system.  I can also edit these files, test them and later make them a distribution while still in place and operational.

Another aid in development was the make_quckview_links.sh that makes it so I don't have to travers so many directories to locate the file I want to edit within the package.

I'm sure there are other simpler ways to install OpenCart packages but I'm new to opencart so I just haven't learned it yet.  If you have other better methods of install feel free to drop us a line or PR this doc or whatever else is needed to change.  Later I'll have it so you can install it from the admin console if it won't already if you zip the upload dir. 

### Post Install setup and transactions ###
See [wiki_link](https://github.com/sacarlson/OpenCart_stellar_plugin/wiki) for screen shots of post install setup of OpenCart Stellar.org Payment Plugin and transactions as seen by a customer.
 
After the files are installed you should see Stellar Payment as an option in admin extension payment on your installed OpenCart.  Click the install button at the end of the line.  Then click edit.  The options are now shown to be filled for the stellar payment settings of your store.
The values include:



### QR-code as payment option ###
We now have QR-code on checkout working. This sets up payments with supported stellar.org wallets including My_wallet web app and the Stargazer wallet android app.

There is at this point no standardized stellar.org QR-code format for stellar transactions,  so for other stellar wallets that we don't yet support yet, you may still have to enter the purchase information into your wallet manualy or with cut and paste from info provided at checkout.  As we continue to see other qr-code formats in stellar wallets that work, we can add them as options at checkout. When we finnaly have standardization on QR-code formats we will only need one.  The Qr-code format will also later need to support the setup of escrow that we will discuse here later.

The present qr-code format include:

Ver 1.0: this is the first original version supported by my_wallet web app. This format continues to be supported by my_wallet but the prefered my_wallet version at present is Ver 2.1.

Ver 2.0: this was the next step in evulution of the My_wallet protocol that now fetches details of transactions with webhook callback instead of providing the information directly in the qr-code and or URL link.  This makes for a much smaller qr-code that makes for easy reading by a cheap web camera.

Ver 2.1:  This version is much like version 2.0 but now the callback return info is rendered in the format developed for stargazer.  At present we feel this is the best choice for default.

Ver 2.2: This version is what we named the present released stargazer qr-code format with added URL encoding. URL encoding replaces the characters {} and spaces and quotes from the json string for URL link usage and other usages.  This version puts all the info of the transaction into the qr-code itself.  This makes for much larger more complex qr-code images that at times may be difficult to read with poor cams and bad envirnmental conditions.  We still fell Ver 2.1 a better choice of formats at this time for this reason. The Version number was created by me just so we can track and select it's usage in our apps.

Ver 2.3: This is the same as Ver 2.2 with no added URL encoding added.  This maybe the only format that will work on the present release of the Stargazer android app. 

Ver 3.0: This is the next step in the evolution of formats that integrates escrow handshake protocol from the wallet app to the OpenCart store plugin.  At this time this is only supported using the My_wallet web app by selecting the Big Red "PAY" button at checkout.  This format allows for a selected 3rd party escrow agent to help resolve problems bettween customers and vendors.

Note: all the formats above in both qr-code and URL link mode method are supported by the presently released my_wallet web app that decodes all the above V1.0 - V3.0.


### Stellar Bridge setup and config ###
To monitor transaction that update the OpenCart transaction status and history we use stellar bridge.  For information on how to install and some details on how to down load compile and install and run with detailed docs see: https://github.com/stellar/bridge-server.  We have also provided an example of the bridge.config.example file that we used in the prototype install tests we performed.

### Other Misc details about the OpenCart Store ###
At this time you can only setup to accept one stellar asset/issuer pair as payment but there seems to be options within the store to view the price in other currency but at payment time it will be calculated to what is needed in your asset that your store accepts.  The exchange rate expressed within the store may not match closely to what it presently trades for on the internal stallar currency market so beware.  Also I haven't yet tested using this feature yet.  So if you find it usefull let us know and how you made use of it.

The customer should already have the asset issuer set funds needed available in there account before they make the purchase.

how ever it would in theory be posible to perform Path payments within stellar.org net to apply the needed funding to the store account, but I'm not sure how well this feature works at this time (noted some issues people have had using it in the past).  At some point Path Payment might be the standard used in transactions to make for easy invisible currency conversion for users.
 
### Escrow payment option Phase 2 ###

We now have the option for escrow payments working in our present release that at this time only has one entity available as a 3rd party signer that being the Funtracker.site Bank as the 3rd party signer on the stellar.org accounts used in escrow transactions.

In the escrow active mode setable by the store admin, the customer will select the option to accept an escrow payment.  The escrow payment has a settable expiration time window of any number of days selectable by the admin of the store.  It will be a long enuf window of time that the package should reach the intended customer before the expire time.  If the package fails to arive before the expire time the customer will have the option to contact the store and ask for a refund or an extension can be provided on the time window of the escrow if for any reason setup by the vendor with the customer.

If the store fails to correct the problem with the customer and the store refuses to refund the asset or extend the contract time, the customer then has the option to contact the 3rd party escrow signer on the escrowed account.  The 3rd party in this case being Funtracker.site Bank will review the details provided by both sides and decide to refund the money or allow the store to have the funds or extend the contract time.  The bank will provide the winning party with a signed transaction that will also have to be signed by the winner to recieve the funds or extend the time of the contract.

This all sounds simple but to make it easy for people to setup and use is another story.  I'm not good at user interfaces but I will do my best to make something that will work.  I leave it to others to make improvments to make it simple for people to make better use of it.

### Escrow handshake protocol  V3.0 ###
The 3rd idea for escrow that has now been implemented:
In this case the main difference with V3.1 is we don't make any attempt to contact the 3rd party at contract creation time.  3rd party signer contact will only happen in the event of failure between the 2 parties vendor and customer that started it.

* At Checkout time the Customer selects Escrow Mode, optionaly later he will also select who will be the 3rd party signer for this contract.

* After the selection is made for the type of transaction (escrow, no escrow), the customer can ether click the generated URL or scan the QR-code (they do the same thing internaly in the wallet).
  
* The URL link brings in the URL data with GET into the web wallet that contains: tx_tag, callback URL, version number.
qr-code json formated
 
example of data post URL escape decoded: {"tx_tag":"123", "callback":"https://callback.website.com","ver":"3.0"}

example as seen in browser:
http://sacarlson.github.io/my_wallet/?json=%7B%22tx_tag%22:%2232%22,%22callback%22:%22http://b.funtracker.site/store/index.php?route=extension/payment/stellar_net/get_tx&%22,%22ver%22:%223.0%22%7D

Note: we had to escape encode the "{}" and " " spaces to allow it within the URL string

* If the version is seen as ver:3.0, the wallet knows that this is the start of an escrow transaction (ver 2.0 - 2.99 are non escrow protocol at this time).  So the wallet then sends a restclient GET with just the tx_tag and the vesion that it just recieved back to the stores callback URL address that will return the details of the transaction.

example of what would be sent from the customers wallet when seen using curl to the store callback URL:

  curl  https://callback.website.com?tx_tag=123&ver=3.0

or a more real example when clicked as a link the data is added to the end of the URL link:

http://b.funtracker.site/wallet/?json=%7B%22tx_tag%22:%2282%22,%22callback%22:%22http://b.funtracker.site/store/?route=extension/payment/stellar_net/get_tx&%22,%22ver%22:%223.0%22%7D

for QR-code we would just provide the end json with or without the URI encoding (in this case URI encoded):

%7B%22tx_tag%22:%2282%22,%22callback%22:%22http://b.funtracker.site/store/?route=extension/payment/stellar_net/get_tx&%22,%22ver%22:%223.0%22%7D


* The store returns response to the above callback to the wallet with detailed transaction data
 
example transaction details string returned from store callback in the present json format.

with return data looking like this:

{"stellar":{"payment":{"destination":"GDUPQLNDVSUKJ4XKQQDITC7RFYCJTROCR6AMUBAMPGBIZXQU4UTAGX7C","network":"cee0302d","amount":"204.9900","asset":{"code":"USD","issuer":"GCEZWKCA5VLDNRLN3RPRJMRZOX3Z6G5CHCGSNFHEYVXM3XOJMDS674JZ"},"memo":{"type":"text","value":"82"},"order_status":null,"escrow":{"publicId":"GAVUFP3ZYPZUI2WBSFAGRMDWUWK2UDCPD4ODIIADOILQKB4GI3APVGIF","email":"funtracker.site.bank@gmail.com","expire_ts":1490574272,"expire_dt":"2017-03-27","status":"0","fee":522.475,"callback":"http:\/\/b.funtracker.site\/store\/?route=extension\/payment\/stellar_net\/submit_escrow&"}},"version":"3.0"}}

The above part of format is mostly the same as dzham's stargazer format with some added data for escrow being this part:

"escrow":{"publicId":"GAVUFP3ZYPZUI2WBSFAGRMDWUWK2UDCPD4ODIIADOILQKB4GI3APVGIF","email":"funtracker.site.bank@gmail.com","expire_ts":1490574272,"expire_dt":"2017-03-27","status":"0","fee":522.475,"callback":"http:\/\/b.funtracker.site\/store\/?route=extension\/payment\/stellar_net\/submit_escrow&"}},"version":"3.0"}}

values seen in the above data string when decoded and explained:

destination: GDUP...  The final store payment publicID that will recieve the funds after escrow is cleared

network: this indicates to the wallet this this is testnet or Livenet encoded with dzham's stargazer method

amount: 204.9900  // the amount of the purchase in the selected asset

asset->code: USD  // the asset that the item will be paid with

asset->issuer: GCEZW...  // the issuer of the asset above

memo-type: text  // in escrow we plan to always use text memo mode

memo-value: 82  // the value in this case the stores tx_tag or order_id when using the OpenCart plugin

order_status: null  // this will be what state the store sees this tx_tag order in,  null means it does not yet exist.  when already paid this becomes a value of 0 - X indicating that the order has already been paid or had an error and prevents the wallet from allowing to pay more than 1 time.

beyond this becomes the added Escrow Data:

publicId: GAVUFP... // this is the 3rd party escrow agents publicID that becomes a signer in the escrow contract

email: funtracker.site.bank@gmail.com // the email contact info for the 3rd party escrow agent above

expire_ts: 1490574272 // timestamp of expire time when the store can recover it's funds with no reponse from the buyer.

expire_dt: the above time stamp in date format just for reference by humans not really used in the protocol, as the contract is down to the second

status: 0 // I don't even remember what this status is for I'll have to look it up as I think the above order_status is used in most cases, this might provide detailed error messages if problems happen in the esrow handshake at some point or stages in escrow post processing.

fee: this is the escrow service fee in XLM that is sent to the 3rd party escrow agent, this fee is optional depending on what the 3rd party wants to charge.

callback: this is the URL callback address that the wallet will submit the escrow transaction package to after the customer confirms payment from the wallet.

version: 3.0 // this is the present protocol version 3.0 indicating escrow verison 3 that we are now using.  As new methods of escrow and other transaction types are created this value will change that will change what data is required and how handshaking will be handled.

* after the buyers wallet recieves the detailed transaction  results from the above, the wallet will will display the values of the transaction and await the user to confirm the order.

* after the wallet gets the user confirm button signal the wallet will setup a multi opp transaction that will:

 * create a new random escrow account and fund it with minimal 31 XLM to hold a single asset.
 * setup trust on the new escrow account to prepare to hold the asset/issuer pair to be sent.
 * fund the escrow account with the amount of asset/issuer asset needed to make the purchase.
 * setup the 3 signers on the account
 * set account options to signing weight of 2 of 3
 * submit transaction

* create signed (1 of 2) transaction from the escrow account to the store destination account with time valid starting at escrow_expire time

* The buyer wallet then sends the last restclient message back to the stores callback with this info:

 b64_tx: the signed time based transaction that becomes valid at escrow_expire time to pay the store 

 escPID: GKDS...  // the locked timed escrow account holding the future store payment assets

 tx_tag: the stores transaction id that this payment is attached to.

example:
http://b.funtracker.site/store/?route=extension/payment/stellar_net/submit_escrow&tx_tag=1&exp=49851234&escPID=GTYUE...&b64_tx=iewotu...

* When the store recieves the above from they buyers wallet, it can now verify the escrow_holding_publicId account has the needed funding for the purchase and verifies the b64_timed_env transaction will be valid with payment as expected. if funding is seen correct, it can update the customers transaction status to processing and starts shipment procedures.

* When the escrow expires the b64_tx that the customer sent the store becomes valid.  The store processing software auto detects this event and send the stored transaction onto the stellar network that moves the asset from the locked escrow account into the store public payment address.  The same transaction also returns the remaining XLM funds back to the customer that created the escrow account and removes the escrow account from the stellar net.

* In the event that the customer is not happy with the product service and the store fails to send a refund transaction, the 3rd party can step in and send a transaction to release the funds back to the customer or to the store depending on how the 3rd party escrow agent see's it.

* We now have working code for the above V3.0 in this release with my_wallet web app presently being the only wallet that supports escrow V3.0 at this time.

## What's planed next for the plugins development ##

### Escrow payment option Phase 3 ###
In phase 3 we need a group of 3rd party signers available to be choosen as signers by both the store and the customers.  The store will have an allowed list that it trusts as signers and the customer can select from that list who they want to be as there escrow signer (only one 3rd party signer per transaction to start). 

In the 3rd phase we will need a website that signers sign up to be escrow signers.  This site should also track any problems that people have had dealing with them in the past.  From the signers track records the stores and customers can decide who to trust from the list of signers.  At this stage the escrow signer can also ask for a fee or sign for free at the discretion of the signer.

I have now created https://github.com/sacarlson/Stellar_Escrow_Signers as the first method to list and track performance of volunteer signers. If you would like to be added to the list please let me know at stellar slack.  Anyone can also volunteer to participate in maintaining the Stellar_Escrow_Signers page that should be under the publics control.  I also setup a chat channel #escrow in stellar slack to provide a public point for escrow disputes and problems you might have with 3rd party signers and to ask any questions you might have about escrow.

## temp bug in install with missing table work around ##
issue with install not creating new table oc_stellar_net_order,  temp work around for now is to use phpmyadmin to create it 
manually with a provided sql file that you will find in this distribution package.

The table looks kind of like this but has now changed a bit so use the released sql file instead of what is seen here:

CREATE TABLE IF NOT EXISTS `oc_stellar_net_order` (
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
	
Error seen in var/log/apache2/error.log with this condition is:	

Error: Table 'opencart.oc_stellar_net_order' doesn't exist<br />Error No: 1146<br />SELECT * FROM `oc_stellar_net_order` WHERE `order_id` = '11' in /var/www/funtracker.site/test_store/system/library/db/mysqli.php:40\nStack trace:\n#0 /var/www/funtracker.site/test_store/system/library/db.php(16): DB\\MySQLi->query('SELECT * FROM `...', Array)\n#1 /var/www/funtracker.site/test_store/upload/catalog/controller/extension/payment/stellar_net.php(121): DB->query('SELECT * FROM `...')\n#2 /var/www/funtracker.site/test_store/upload/catalog/controller/extension/payment/stellar_net.php(146): ControllerExtensionPaymentStellarNet->getstellar_netOrder('11')\n#3 /var/www/funtracker.site/test_store/system/engine/action.php(51): ControllerExtensionPaymentStellarNet->get_tx()\n#4 /var/www/funtracker.site/test_store/catalog/controller/startup/router.php(25): Action->execute(Object(Registry))\n#5 /var/www/funtracker.site/test_store/system/engine/action.php(51): ControllerStartupRouter->index()\n#6 /var/www/funtracker. in /var/www/funtracker.site/test_store/system/library/db/mysqli.php on line 40
