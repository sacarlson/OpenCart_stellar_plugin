Basic install copy upload dir in this distribution to the base dir of your installed and running OpenCart.  Also copy install.sh script to the base dir.  cd into base dir and run the script.  This will just copy the files from the ./upload directory into the base install.

I also created a link_install.sh that does much the same as install.sh but just creates symbolic links to the locations needed from the ./upload dir at the base.  This was created to aid in development so you can just copy your upload dir into base and it will already be linked into the system.  I can also edit these files, test them and later make them a distribution while in place.

Anther aid in development was the make_quckview_links.sh that makes it so I don't have to travers so many directories to locate the file I want to edit within the package.

I'm sure there are other simpler ways to install but I'm new to opencart so I just haven't learned it yet.  If you have other better methods of install feel free to drop us a line or PR it.  Later I'll have it so you can install it from the admin console if it won't already if you zip the upload dir. 

After installed you should see Stellar Payment as an option in admin extension payment.  click the install button at the end of the line.  Then click edit.  The options are now shown to fill in your stores PublicID that customers will use to send payments to.  You will also have to supply the asset_code and the Issuer of the asset code your store will be willing to accept as payment.

At first release of this package we don't have everything working yet.  To start we don't even have the payment status callback setup to be working yet.  For that we are working on using the stellar.org bridge software that will monitor the store address looking for payments.  when detected it will update the status within the view of the admin of the store on the outstanding orders.  We hope to have this working very soon.

After that we also hope to have QR-code on the checkout.  This should not be too much trouble to work with at least in the My_wallet QR-code format.  But at this time there is still no standard on qr-code formats so for other wallet you will still have to enter the information into your wallet manualy or with cut and paste.  As we start seeing other qr-code formats that work we can later add them as options until standardization hopefuly makes that unneeded.  The Qr-code format will also later need to support the setup of escrow that we will discuse later. 

At this time you can only accept one stellar asset as payment but there seems to be options within the store to view the price in other currency but at payment time it will be calculated to what is needed in your asset that your store accepts.  The exchange rate expressed within the store may not match closely to what it presently trades for on the internal stallar currency market.

The customer should already have the asset issuer set funds needed available in there account before they make the purchase.  It would in theory be posible to perform Path payments within stellar.org net to apply the needed funding to the store account, but I'm not sure how well that works at this time.  

We would like to later add the option for escrow payments that at first will only have one entity as a 3rd party signer that will be the Funtracker.site Bank as the 3rd signer on the stellar.org account used in the escrow transaction.

At the escrow stage, the customer will select the option to accept an escrow payment.  The escrow payment will have a setable expiration time window of any number of days selectable by the admin of the store.  It will be a long enuf window of time that the package should reach the intended customer before the expire time.  If the package fails to arive before the the expire time the customer will have the option to contact the store and ask for a refund or an extension can be provided on the time window of the escrow if for any reason.  

If the store fails to correct the problem with the customer and refuses to refund the asset, the customer then has the option to contact the 3rd party escrow signer on the escrow account.  The 3rd party in this case being Funtracker.site Bank will view the details provided on both sides and decide to refund the money or allow the store to have the funds.  The bank will provide the winning party with a signed transaction that will also have to be signed by the winner to recieve the funds.

This all sounds simple but to make it easy for people to setup and use is another story.  I'm not good at user interfaces but I will do my best to make something that will work.  I leave it to others to make improvments to make it simple for people to make better use of it. 

Also this is only phase 2 of this project.  In phase 3 we need a group of 3rd party signers available to be choosen as signers by both the store and the customers.  The store will have an allowed list that it trusts as signers and the customer can select from that list who they want to be as there escrow signer.  

In the 3rd phase we will need a website that signers sign up to be escrow signers.  This site should also track any problems that people have had dealing with them in the past.  From the track record the stores and customers can decide who to trust on the list of signer.  At this stage the escrow signer can also ask for a fee or sign for free at the discretion of the signer. 
