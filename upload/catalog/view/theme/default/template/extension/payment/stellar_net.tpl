<h2> <?php echo $text_title; ?> </h2>
<?php
  if ($testmode == '1'){
    echo '    <h2>'.$text_testmode . "</h2>";
  }
?>
<div>
<p> <?php echo $text_click_link; ?> </p><br />

<?php
  if ($enable_escrow == '1'){    
    echo '<a href="' . $qrcode_url_v3 . '" target="_blank">';
  }else {
    echo '<a href="' . $qrcode_url_v2 . '" target="_blank">';
  }
?>
<img border="0" alt="W3Schools" src="image/payment/stellar_net/pay_my_wallet.png" ></a>

<br /><br /><p><?php echo $text_or_scan ?></p>
<?php
  if ($enable_escrow == '1'){
    echo "<p>" . $text_for_escrow_select ."</p><br />";
    echo "<h4>" .$text_escrow_signer_publicId.": " . $escrows_publicId . "</h4>";
    echo "<h4>" .$text_escrow_agent_email .": " . $escrows_email . "</h4>";
    echo "<h4>" .$text_escrow_fee . ": " . $escrow_fee_xlm . " XLM  </h4>";
    echo "<h4>" .$text_escrow_expires_on. ": ". $escrow_expires_dt . "  </h4>";
   
  }
?>
<br />
 
  <label for="qrcode_ver">Select Stellar.org QR-Code Version (default 2.1)</label>
  <select name="qrcode_ver" id="qrcode_ver" >
    <option selected disabled>Choose QR-Code Version</option>
    <option>1.0</option>
    <option>2.0</option>
    <option>2.1</option> 
    <option>2.2</option>
    <option>2.3</option> 
<?php
  if ($enable_escrow == '1'){
    echo '<option>3.0</option> ';
  }
?>
  </select><br />

<?php
if ($enable_escrow == '1'){   
    echo '<a href="' . $qrcode_url_v3 . '" target="_blank"><img id="qrcode" style="width:300px; height:300px; margin-top:15px;"/></a>';
  }else {
    echo '<a href="' . $qrcode_url_v2 . '" target="_blank"><img id="qrcode" style="width:300px; height:300px; margin-top:15px;"/></a>';
  }
?>


<script type="text/javascript">
$( document ).ready(function () {
    
var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 300,
	height : 300
});
//qrcode.makeCode("<?php echo $qrcode_json; ?>");
qrcode.makeCode("<?php echo $qrcode_v2_1; ?>");

qrcode_ver.onchange=function(){ //run some code when "onchange" event fires
        var chosenoption=this.options[this.selectedIndex]; //this refers to "selectmenu"
        if (chosenoption.value!="nothing"){
          console.log("qrcode_ver selected: " + chosenoption.value);
          if (chosenoption.value == 1.0){
            console.log("here");
            qrcode.makeCode("<?php echo $qrcode_v1; ?>");
          }else if (chosenoption.value == 2.0){
            console.log("here 2.0");
            qrcode.makeCode("<?php echo $qrcode_v2; ?>");
          }else if (chosenoption.value == 2.1){
            console.log("here 2.1");
            qrcode.makeCode("<?php echo $qrcode_v2_1; ?>");
          }else if (chosenoption.value == "2.2"){
            qrcode.makeCode("<?php echo $qrcode_v2_2; ?>");
          }else if (chosenoption.value == "2.3"){
            qrcode.makeCode('<?php echo $qrcode_v2_3; ?>');
          }else if (chosenoption.value == "3.0"){
            qrcode.makeCode('<?php echo $qrcode_v3_0; ?>');
          }           
        }
      }

});
</script>

<br /><p>  <?php echo $text_or_send; ?>   </p>
<h4> <?php echo $text_to_PublicId; ?> <?php echo $stellar_net_publicid; ?></h4>
<h4> <?php echo $text_amount; ?> <?php echo $total; ?></h4>
<h4> <?php echo $text_asset_code; ?> <?php echo $asset_code; ?></h4>
<h4> <?php echo $text_issuer; ?> <?php echo $issuer; ?></h4>
<h4> <?php echo $text_memo; ?> <?php echo $order_id; ?></h4>
</div>

<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/stellar_net/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function() {
            alert("success!!  Make sure to send total funds of purchase to stellar address payment address to continue processing" )
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>
