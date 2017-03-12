# Stellar Payment Plugin for OpenCart #

### Details about OpenCart ###
You will need to install OpenCart to use this payment plugin.  For details on how to download, install and detailed documentation see: https://www.opencart.com/.  to download: https://www.opencart.com/index.php?route=cms/download.  Note this plugin was write to support OpenCart version: 2.3.0.2.  The plugin has not been tested on any other version.

### How to install Stellar Payment Plugin###
Basic install copy upload dir in this distribution to the base dir of your pre-installed and running OpenCart.  Also copy install.sh script to the base dir.  cd into base dir and run the script.  This will just copy the files from the ./upload directory into the base install.  You can choose to manually copy each file to it's location if you so desire.

I also created a link_install.sh that does much the same as install.sh but just creates symbolic links to the locations needed from the ./upload dir at the base.  This was created to aid in development so you can just copy your upload dir into base and it will already be linked into the system.  I can also edit these files, test them and later make them a distribution while still in place and operational.

Another aid in development was the make_quckview_links.sh that makes it so I don't have to travers so many directories to locate the file I want to edit within the package.

I'm sure there are other simpler ways to install OpenCart packages but I'm new to opencart so I just haven't learned it yet.  If you have other better methods of install feel free to drop us a line or PR this doc or whatever else is needed to change.  Later I'll have it so you can install it from the admin console if it won't already if you zip the upload dir. 

### Post Install setup ###
After the files are installed you should see Stellar Payment as an option in admin extension payment on your installed OpenCart.  Click the install button at the end of the line.  Then click edit.  The options are now shown to be filled for the stellar payment settings of your store.
The values include:

PublicID:  the value customers will use to send payments to your store.

Asset Code:  You will also have to supply the asset_code and the Issuer of the asset code your store will be willing to accept as payments.

Issuer: The PublicId of the issuer of the Asset Code above. At this time we only support acceptance of a single asset/issuer pair in payment.  I assume you can also use XLM as payment, if so I guess Issuer can be left blank (untested).

Tx Callback URL: This is the value that will later be used to generate QR-code and URL links with the callback option (not implemented yet).  This will be required for phase 2 of development where we plan to support escrow transactions.

TestNet Mode: When set to "Yes" the customer will see the checkout display that the store is in TestNet mode (not real money) used in testing.  In this mode you still have to setup stellar bridge monitor config in testnet mode so that it is listening for transactions on testnet not real Live net. 

Note: For other values bellow TestNet value, use the OpenCart docs for clearification or leave them defaulted.

### Stellar Bridge setup and config ###
To monitor transaction that update the OpenCart transaction status and history we use stellar bridge.  For information on how to install and some details on how to down load compile and install and run with detailed docs see: https://github.com/stellar/bridge-server.  We have also provided an example of the bridge.config.example file that we used in the prototype install tests we performed.

### Other Misc details about the OpenCart Store ###
At this time you can only setup to accept one stellar asset/issuer pair as payment but there seems to be options within the store to view the price in other currency but at payment time it will be calculated to what is needed in your asset that your store accepts.  The exchange rate expressed within the store may not match closely to what it presently trades for on the internal stallar currency market so beware.  Also I haven't yet tested using this feature yet.  So if you find it usfull let us know and how you made use of it.

The customer should already have the asset issuer set funds needed available in there account before they make the purchase.  It would in theory be posible to perform Path payments within stellar.org net to apply the needed funding to the store account, but I'm not sure how well that works at this time.
 
## What's planed next for this plugins development ##

### Wiki's with screen shots ###
I have plans to setup wiki pages on this project that will provide screen shots of OpenCart in the post install setup and maybe adding more details in other sections of install were we find users need them.  There will be a link within this readme.md that will redirect to the wiki pages when they are ready.

### QR-code as payment option ###
Next in line we hope to have QR-code on the checkout working. this will setup your wallet with all the info needed to make payments using for example an android app wallet that reads stellar.org QR-code payment setup.  This should not be too much trouble to work with at least for My_wallet QR-code format that has already been released and tested.  But at this time there is still no standard on qr-code formats so for other stellar wallets, you will still have to enter the information into your wallet manualy or with cut and paste.  As we start seeing other qr-code formats in stellar wallets that work, we can later add them as options at checkout. When we finnaly standardization on QR-code formats we will only need one.  The Qr-code format will also later need to support the setup of escrow that we will discuse here later. 

### Escrow payment option Phase 2 ###
We would like to later add the option for escrow payments that at first will only have one entity available as a 3rd party signer that will be the Funtracker.site Bank as the 3rd signer on the stellar.org account used in the escrow transaction.

At the escrow stage, the customer will select the option to accept an escrow payment.  The escrow payment will have a setable expiration time window of any number of days selectable by the admin of the store.  It will be a long enuf window of time that the package should reach the intended customer before the expire time.  If the package fails to arive before the the expire time the customer will have the option to contact the store and ask for a refund or an extension can be provided on the time window of the escrow if for any reason.

If the store fails to correct the problem with the customer and refuses to refund the asset, the customer then has the option to contact the 3rd party escrow signer on the escrow account.  The 3rd party in this case being Funtracker.site Bank will view the details provided on both sides and decide to refund the money or allow the store to have the funds.  The bank will provide the winning party with a signed transaction that will also have to be signed by the winner to recieve the funds.

This all sounds simple but to make it easy for people to setup and use is another story.  I'm not good at user interfaces but I will do my best to make something that will work.  I leave it to others to make improvments to make it simple for people to make better use of it. 

### Escrow payment option Phase 3 ###
In phase 3 we need a group of 3rd party signers available to be choosen as signers by both the store and the customers.  The store will have an allowed list that it trusts as signers and the customer can select from that list who they want to be as there escrow signer (only one 3rd party signer per transaction). 

In the 3rd phase we will need a website that signers sign up to be escrow signers.  This site should also track any problems that people have had dealing with them in the past.  From the signers track records the stores and customers can decide who to trust from the list of signers.  At this stage the escrow signer can also ask for a fee or sign for free at the discretion of the signer. 
