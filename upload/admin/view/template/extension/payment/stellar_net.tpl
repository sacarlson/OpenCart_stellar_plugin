<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-stellar_net" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-stellar_net" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_publicid"><span data-toggle="tooltip" title="<?php echo $help_publicid; ?>"><?php echo $entry_publicid; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_publicid" value="<?php echo $stellar_net_publicid; ?>" placeholder="<?php echo $entry_publicid; ?>" id="stellar_net_publicid" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_asset_code"><span data-toggle="tooltip" title="<?php echo $help_asset_code; ?>"><?php echo $entry_asset_code; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_asset_code" value="<?php echo $stellar_net_asset_code; ?>" placeholder="<?php echo $entry_asset_code; ?>" id="stellar_net_asset_code" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_issuer"><span data-toggle="tooltip" title="<?php echo $help_issuer; ?>"><?php echo $entry_issuer; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_issuer" value="<?php echo $stellar_net_issuer; ?>" placeholder="<?php echo $entry_issuer; ?>" id="stellar_net_issuer" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_wallet_url"><span data-toggle="tooltip" title="<?php echo $help_wallet_url; ?>"><?php echo $entry_wallet_url; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_wallet_url" value="<?php echo $stellar_net_wallet_url; ?>" placeholder="<?php echo $entry_wallet_url; ?>" id="stellar_net_wallet_url" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_tx_callback_token"><span data-toggle="tooltip" title="<?php echo $help_tx_callback_token; ?>"><?php echo $entry_tx_callback_token; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_tx_callback_token" value="<?php echo $stellar_net_tx_callback_token; ?>" placeholder="<?php echo $entry_tx_callback_token; ?>" id="stellar_net_tx_callback_token" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_testnet_mode"><?php echo $entry_testnet_mode; ?></label>
            <div class="col-sm-10">
              <select name="stellar_net_testnet_mode" id="stellar_net_testnet_mode" class="form-control">
                <?php if ($stellar_net_testnet_mode) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_escrows_publicId"><span data-toggle="tooltip" title="<?php echo $help_escrows_publicId; ?>"><?php echo $entry_escrows_publicId; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_escrows_publicId" value="<?php echo $stellar_net_escrows_publicId; ?>" placeholder="<?php echo $entry_escrows_publicId; ?>" id="stellar_net_escrows_publicId" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_escrows_email"><span data-toggle="tooltip" title="<?php echo $help_escrows_email; ?>"><?php echo $entry_escrows_email; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_escrows_email" value="<?php echo $stellar_net_escrows_email; ?>" placeholder="<?php echo $entry_escrows_email; ?>" id="stellar_net_escrows_email" class="form-control" />
            </div>
          </div>

          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_escrow_vendor_signer_secret"><span data-toggle="tooltip" title="<?php echo $help_escrow_vendor_signer_secret; ?>"><?php echo $entry_escrow_vendor_signer_secret; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_escrow_vendor_signer_secret" value="<?php echo $stellar_net_escrow_vendor_signer_secret; ?>" placeholder="<?php echo $entry_escrow_vendor_signer_secret; ?>" id="stellar_net_escrow_vendor_signer_secret" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_escrow_expire_hours"><span data-toggle="tooltip" title="<?php echo $help_escrow_expire_hours; ?>"><?php echo $entry_escrow_expire_hours; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_escrow_expire_hours" value="<?php echo $stellar_net_escrow_expire_hours; ?>" placeholder="<?php echo $entry_escrow_expire_hours; ?>" id="stellar_net_escrow_expire_hours" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="stellar_net_enable_escrow"><?php echo $entry_enable_escrow; ?></label>
            <div class="col-sm-10">
              <select name="stellar_net_enable_escrow" id="stellar_net_enable_escrow" class="form-control">
                <?php if ($stellar_net_enable_escrow) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_total" value="<?php echo $stellar_net_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
            <div class="col-sm-10">
              <select name="stellar_net_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $stellar_net_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="stellar_net_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $stellar_net_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="stellar_net_status" id="input-status" class="form-control">
                <?php if ($stellar_net_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="stellar_net_sort_order" value="<?php echo $stellar_net_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 
