<div class="row">
  <div class="col-lg-12">
   <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col">
          <i class="fas fa-network-wired mr-2"></i><?php echo _("Configure networking"); ?>
        </div>
      </div><!-- ./row -->
     </div><!-- ./card-header -->
      <div class="card-body">
        <div id="msgNetworking"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="nav-item"><a class="nav-link active" href="#summary" aria-controls="summary" role="tab" data-toggle="tab"><?php echo _("Summary"); ?></a></li>
		  <!--
          < ? comment php foreach ($interfaces as $if): ?>
          < ? comment php $if_quoted = htmlspecialchars($if, ENT_QUOTES) ?>
          <li role="presentation" class="nav-item"><a class="nav-link" href="#<?php echo $if_quoted ?>" aria-controls="< ? comment php echo $if_quoted ?>" role="tab" data-toggle="tab">< ? comment php echo $if_quoted ?></a></li>
          < ? comment php endforeach ?>
		  -->
        </ul>
        <div class="tab-content">

          <div role="tabpanel" class="tab-pane active" id="summary">
            <h4 class="mt-3"><?php echo _("Current settings") ?></h4>
            <div class="row">
              <?php foreach ($interfaces as $if): ?>
              <?php $if_quoted = htmlspecialchars($if, ENT_QUOTES) ?>
              <div class="col-md-6 mb-3">
                <div class="card">
                  <div class="card-header"><?php echo $if_quoted ?></div>
                  <div class="card-body">
                    <pre class="unstyled" id="<?php echo $if_quoted ?>-summary"></pre>
                  </div>
                </div>
              </div>
              <?php endforeach ?>
            </div><!-- /.row -->
            <div class="col-lg-12">
              <div class="row">
                <a href="#" class="btn btn-outline btn-primary" id="btnSummaryRefresh"><i class="fas fa-sync-alt"></i> <?php echo _("Refresh"); ?></a>
              </div><!-- /.row -->
            </div><!-- /.col-lg-12 -->
          </div><!-- /.tab-pane -->

<!--
          < ? commnet php foreach ($interfaces as $if): ?>
          < ? commnet php $if_quoted = htmlspecialchars($if, ENT_QUOTES) ?>
          <div role="tabpanel" class="tab-pane fade in" id="< ? commnet php echo $if_quoted ?>">
            <div class="row">
              <div class="col-lg-6">

                <form id="frm-< ? commnet php echo $if_quoted ?>">
                  < ? commnet php echo CSRFTokenFieldTag() ?>
                  <div class="form-group">
                    <h4 class="mt-3">< ? commnet php echo _("Adapter IP Address Settings") ?></h4>
                    <div class="btn-group" role="group" data-toggle="buttons">
                      <label class="btn btn-primary">
                        <input class="mr-2" type="radio" name="< ? commnet php echo $if_quoted ?>-addresstype" id="< ? commnet php echo $if_quoted ?>-dhcp" autocomplete="off">< ? commnet php echo _("DHCP") ?>
                      </label>
                      <label class="btn btn-primary">
                        <input class="mr-2" type="radio" name="< ? commnet php echo $if_quoted ?>-addresstype" id="< ? commnet php echo $if_quoted ?>-static" autocomplete="off">< ? commnet php echo _("Static IP") ?>
                      </label>
                    </div><!-- /.btn-group -- >
                    <h4 class="mt-3">< ? commnet php echo _("Enable Fallback to Static Option") ?></h4>
                    <div class="btn-group" role="group" data-toggle="buttons">
                      <label class="btn btn-primary">
                        <input class="mr-2" type="radio" name="< ? commnet php echo $if_quoted ?>-dhcpfailover" id="< ? commnet php echo $if_quoted ?>-failover" autocomplete="off">< ? commnet php echo _("Enabled") ?>
                      </label>
                      <label class="btn btn-warning">
                        <input class="mr-2" type="radio" name="< ? commnet php echo $if_quoted ?>-dhcpfailover" id="< ? commnet php echo $if_quoted ?>-nofailover" autocomplete="off">< ? commnet php echo _("Disabled") ?>
                      </label>
                    </div><!-- /.btn-group -- >
                  </div><!-- /.form-group -- >

                  <hr />

                  <h4>< ? commnet php echo _("Static IP Options") ?></h4>
                  <div class="form-group">
                    <label for="< ? commnet php echo $if_quoted ?>-ipaddress">< ? commnet php echo _("IP Address") ?></label>
                    <input type="text" class="form-control" id="< ? commnet php echo $if_quoted ?>-ipaddress" placeholder="0.0.0.0">
                  </div>
                  <div class="form-group">
                    <label for="< ? commnet php echo $if_quoted ?>-netmask">< ? commnet php echo _("Subnet Mask") ?></label>
                    <input type="text" class="form-control" id="< ? commnet php echo $if_quoted ?>-netmask" placeholder="255.255.255.0">
                  </div>
                  <div class="form-group">
                    <label for="< ? commnet php echo $if_quoted ?>-gateway">< ? commnet php echo _("Default Gateway") ?></label>
                    <input type="text" class="form-control" id="< ? commnet php echo $if_quoted ?>-gateway" placeholder="0.0.0.0">
                  </div>
                  <div class="form-group">
                    <label for="< ? commnet php echo $if_quoted ?>-dnssvr">< ? commnet php echo _("DNS Server") ?></label>
                    <input type="text" class="form-control" id="< ? commnet php echo $if_quoted ?>-dnssvr" placeholder="0.0.0.0">
                  </div>
                  <div class="form-group">
                    <label for="< ? commnet php echo $if_quoted ?>-dnssvralt">< ? commnet php echo _("Alternate DNS Server") ?></label>
                    <input type="text" class="form-control" id="< ? commnet php echo $if_quoted ?>-dnssvralt" placeholder="0.0.0.0">
		  </div>
                  < ? commnet php if (!RASPI_MONITOR_ENABLED): ?>
                      <a href="#" class="btn btn-outline btn-primary intsave" data-int="< ? commnet php echo $if_quoted ?>">< ? commnet php echo _("Save settings") ?></a>
		      <a href="#" class="btn btn-warning intapply" data-int="< ? commnet php echo $if_quoted ?>">< ? commnet php echo _("Apply settings") ?></a>
                  < ? commnet php endif ?>
                </form>

              </div>
            </div><!-- /.tab-panel -- >
          </div>
          < ? commnet php endforeach ?>
-->		  

        </div><!-- /.tab-content -->
      </div><!-- /.card-body -->
      <div class="card-footer"><?php echo _("Information provided by /sys/class/net"); ?></div>
    </div><!-- /.card -->
  </div><!-- /.col-lg-12 -->
</div>
