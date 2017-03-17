<h2> <?php echo $text_title; ?> </h2>
<?php
  if ($testmode == 'Yes'){
    echo '    <h2>'.$text_testmode . "</h2>";
  }
?>
<div>
<p> <?php echo $text_click_link; ?> </p><br />


<a href="<?php echo $qrcode_url_v2; ?>" target="_blank">
<img border="0" alt="W3Schools" src="image/payment/stellar_net/pay_my_wallet.png" ></a>

<p><?php echo $text_or_scan ?></p><br />
 
  <label for="qrcode_ver">Select Stellar.org QR-Code Version (default 2.1)</label>
  <select name="qrcode_ver" id="qrcode_ver" value='2.1'>
    <option>1.0</option>
    <option>2.0</option>
    <option>2.1</option> 
    <option>2.2</option> 
  </select><br />


<a href="<?php echo $qrcode_url_v2; ?>" target="_blank"><img id="qrcode" style="width:300px; height:300px; margin-top:15px;"/></a>


<script type="text/javascript">
$( document ).ready(function () {
    
var qrcode = new QRCode(document.getElementById("qrcode"), {
	width : 300,
	height : 300
});
//qrcode.makeCode("<?php echo $qrcode_json; ?>");
qrcode.makeCode("<?php echo $qrcode_v2; ?>");

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
          }     
        }
      }

});
</script>

<p>  <?php echo $text_or_send; ?>   </p>
<h3> <?php echo $text_to_PublicId; ?> <?php echo $stellar_net_publicid; ?></h3>
<h3> <?php echo $text_amount; ?> <?php echo $total; ?></h3>
<h3> <?php echo $text_asset_code; ?> <?php echo $asset_code; ?></h3>
<h3> <?php echo $text_issuer; ?> <?php echo $issuer; ?></h3>
<h3> <?php echo $text_memo; ?> <?php echo $order_id; ?></h3>
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
