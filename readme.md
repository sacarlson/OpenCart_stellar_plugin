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

PublicID:  the value customers will use to send payments to your store.

Asset Code:  You will also have to supply the asset_code and the Issuer of the asset code your store will be willing to accept as payments.

Issuer: The PublicId of the issuer of the Asset Code above. At this time we only support acceptance of a single asset/issuer pair in payment.  I assume you can also use XLM as payment, if so I guess Issuer can be left blank (untested).

Wallet URL: This is the URL of the My_wallet that the transaction links point at for example "https://wallet.funtracker.site".

TestNet Mode: When set to "Yes" the customer will see the checkout display that the store is in TestNet mode (not real money) used in testing.  In this mode you still have to setup stellar bridge monitor config in testnet mode so that it is listening for transactions on testnet not real Live net. 

Note: For other values bellow TestNet value, use the OpenCart docs for clearification or leave them defaulted.

### QR-code as payment option ###
We now have QR-code on checkout working. This sets up payments with supported stellar.org wallets including My_wallet web app and the Stargazer wallet android app.

There is at this point no standardized stellar.org QR-code format for stellar transactions,  so for other stellar wallets that we don't yet support yet, you may still have to enter the purchase information into your wallet manualy or with cut and paste from info provided at checkout.  As we continue to seeing other qr-code formats in stellar wallets that work, we can add them as options at checkout. When we finnaly have standardization on QR-code formats we will only need one.  The Qr-code format will also later need to support the setup of escrow that we will discuse here later.

The present qr-code format include:
Ver 1.0: this is the first original version supported by my_walled web app. This format continues to be supported by my_wallet but the prefered my_wallet version at present is Ver 2.1.

Ver 2.0: this was the next step in evulution of the My_wallet protocol that now fetches details of transactions with webhook callback instead of providing the information directly in the qr-code and or URL link.  This makes for a much smaller qr-code that makes for easy reading by a cheap web camera.

Ver 2.1:  This version is much like version 2.1 but now the callback return info is rendered in the a format developed for stargazer.  At present we feel this is the best choice for default.

Ver 2.2: This version is what we named the present released stargazer qr-code format.  This version puts all the info of the transaction into the qr-code itself.  This makes for much larger more complex qr-code images that at times may be difficult to read with poor cams and bad envirnmental conditions.  We still fell Ver 2.1 a better choice of formats at this time for this reason. The Version number was created by me just so we can track and select it's usage in our apps.

Note: all the formats above in both qr-code and URL link mode method are supported by the presently released my_wallet web app that decodes all the above V1.0 - V2.2.


### Stellar Bridge setup and config ###
To monitor transaction that update the OpenCart transaction status and history we use stellar bridge.  For information on how to install and some details on how to down load compile and install and run with detailed docs see: https://github.com/stellar/bridge-server.  We have also provided an example of the bridge.config.example file that we used in the prototype install tests we performed.

### Other Misc details about the OpenCart Store ###
At this time you can only setup to accept one stellar asset/issuer pair as payment but there seems to be options within the store to view the price in other currency but at payment time it will be calculated to what is needed in your asset that your store accepts.  The exchange rate expressed within the store may not match closely to what it presently trades for on the internal stallar currency market so beware.  Also I haven't yet tested using this feature yet.  So if you find it usefull let us know and how you made use of it.

The customer should already have the asset issuer set funds needed available in there account before they make the purchase.

how ever it would in theory be posible to perform Path payments within stellar.org net to apply the needed funding to the store account, but I'm not sure how well this feature works at this time (noted some issues people have had using it in the past).  At some point Path Payment might be the standard used in transactions to make for easy invisible currency conversion for users.
 
## What's planed next for the plugins development ##

### Escrow payment option Phase 2 ###
We would like to later add the option for escrow payments that at first will only have one entity available as a 3rd party signer that will be the Funtracker.site Bank as the 3rd signer on the stellar.org account used in the escrow transaction.

In the escrow active mode, the customer will select the option to accept an escrow payment.  The escrow payment will have a settable expiration time window of any number of days selectable by the admin of the store.  It will be a long enuf window of time that the package should reach the intended customer before the expire time.  If the package fails to arive before the expire time the customer will have the option to contact the store and ask for a refund or an extension can be provided on the time window of the escrow if for any reason.

If the store fails to correct the problem with the customer and refuses to refund the asset, the customer then has the option to contact the 3rd party escrow signer on the escrow account.  The 3rd party in this case being Funtracker.site Bank will review the details provided by both sides and decide to refund the money or allow the store to have the funds.  The bank will provide the winning party with a signed transaction that will also have to be signed by the winner to recieve the funds.

This all sounds simple but to make it easy for people to setup and use is another story.  I'm not good at user interfaces but I will do my best to make something that will work.  I leave it to others to make improvments to make it simple for people to make better use of it.

### Plan for escrow handshake  V3.2 ###
The 3rd idea for escrow:
In this case the main difference with V3.1 is we won't make any attempt to contact the 3rd party at contract creation time.  3rd party signer contact will only happen in the event of failure between the 2 parties that started it.

* At Checkout time the Customer selects Escrow Mode, optionaly later he will also select who will be the 3rd party signer for this contract.

* After the selection is made for the type of transaction (escrow, no escrow), the customer can ether click the generated URL or scan the QR-code (they do the same thing internaly in the wallet).
  
* The URL link brings in the URL data with GET into the web wallet that contains: tx_tag, callback URL, version number.
qr-code json formated
 
example of data post URL escape decoded: {"tx_tag":"abcde", "callback":"https://callback.website.com","ver":"3.2"}

example as seen in browser:
http://sacarlson.github.io/my_wallet/?json=%7B%22tx_tag%22:%2232%22,%22callback%22:%22http://b.funtracker.site/store/index.php?route=extension/payment/stellar_net/get_tx&%22,%22ver%22:%223.2%22%7D

Note: we had to escape encode the "{}" and " " spaces to allow it within the URL string

* If the version is seen as ver:3.2, the wallet knows that this is the start of an escrow transaction (ver 2.0 - 2.99 is non escrow at this time).  So the wallet then sends a restclient PUT with just the tx_tag and the vesion that it just recieved back to the stores callback URL address that will return the details of the transaction.

example of what would be sent from the customers wallet when seen with curl to the store callback URL:

  curl  https://callback.website.com?tx_tag=abcde&ver=3.2


* The store returns response to the above back to the wallet with detailed transaction data. 
 
example transaction details string returned from store callback in the present format that is escape encoded json format that allows usage in URL links for v1.0:

%7B%22destination%22:%22GDUPQLNDVSUKJ4XKQQDITC7RFYCJTROCR6AMUBAMPGBIZXQU4UTAGX7C%22,%22amount%22:%22204.9900%22,%22asset%22:%22USD%22,%22issuer%22:%22GCEZWKCA5VLDNRLN3RPRJMRZOX3Z6G5CHCGSNFHEYVXM3XOJMDS674JZ%22,%22memo%22:%2232%22,%22escrow_publicId%22:%22GRTYWX...%22,%22escrow_email%22:%22escrow@gmail.com%22,%22dest_email%22:%22dest@gmail.com%22%7D

values seen in the above data string when decoded:

destination: GDUP...

dest_email: dest@gmail.com

amount: 204.9900

asset: USD

issuer: GCEZW

memo: 32

escrow_publicId: GRTYWX...

escrow_email: escrow@gmail.com

escrow_expire: timestamp of expire time when the store can recover it's funds with no reponse from the buyer.


* after the buyers wallet recieves the detailed transaction  results from the above the wallet will will display the values of the transaction and await the user to confirm the order.

* after the wallet gets the user confirm button signal the wallet will setup a multi opp transaction that will:

 * create a new random escrow account and fund it with minimal 31 XLM to hold a single asset.
 * setup trust on the new escrow account to prepare to hold the asset/issuer pair to be sent.
 * fund the escrow account with the amount of asset/issuer asset needed to make the purchase.
 * setup the 3 signers on the account
 * set account options to signing weight of 2 of 3
 * submit transaction

* create signed (1 of 2) transaction from the escrow account to the store destination account with time valid starting at escrow_expire time

* The buyer wallet then sends the last restclient message to the store with this info:

 b64_timed_env: the signed time based transaction that becomes valid at escrow_expire time 

 escrow_holding_publicId: GKDS...

 tx_tag: the stores transaction id that this payment is attached to.

* When the store recieves the above from they buyers wallet, it can now verify the escrow_holding_publicId account has the needed funding for the purchase and verifies the b64_timed_env transaction will be valid with payment as expected. if funding is seen correct, it can update the customers transaction status to processing and starts shipment procedures.

* After the customer receives his package and is satisfied with the product or service, he/she has the option to send the store a transaction to merge the escrow account with the stores general account and optionaly a secound opp that returns the XLM funds back to the buyer that steup the transaction and maybe some part sent as a fee to the escrow service.

* When the store recieves the above transaction it can add it's signature to the transaction and retreave the escrow funds.

* In the event the Customer fails to send the store the release funds transaction, the store can then use the 3rd party transaction after it becomes valid to retrieave the escrow funds.

* On the event that the customer is not happy with the product service and the store fails to send a refund transaction, the 3rd party can step in and send a transaction to release the funds back to the customer or to the store depending on how it see's it.

* At this point I had planed to use standard restclient protocol to perform the above.  But if times to setup accounts is too slow we may end up with restclient timeouts.  So if that ends up being the case we may need to move to websocket protocol.  Websocket may be better from the start, I'm not really sure.  It's not really any more difficult to setup so we can even try to support both as I did in mss-server of different port addresses.

* Estimated time frame to develop and debug the above is estimated at 30 - 90 days or more.



### Escrow payment option Phase 3 ###
In phase 3 we need a group of 3rd party signers available to be choosen as signers by both the store and the customers.  The store will have an allowed list that it trusts as signers and the customer can select from that list who they want to be as there escrow signer (only one 3rd party signer per transaction to start). 

In the 3rd phase we will need a website that signers sign up to be escrow signers.  This site should also track any problems that people have had dealing with them in the past.  From the signers track records the stores and customers can decide who to trust from the list of signers.  At this stage the escrow signer can also ask for a fee or sign for free at the discretion of the signer. 
