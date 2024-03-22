<div class="row">
<div class="col-lg-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col">
          <i class="fas fa-exchange-alt mr-2"></i><?php echo _("Configure Connection Management"); ?>
        </div>
        <div class="col">
          <button class="btn btn-light btn-icon-split btn-sm service-status float-right">
            <span class="icon text-gray-600"><i class="fas fa-circle service-status-<?php echo $serviceStatus ?>"></i></span>
            <span class="text service-status">xs_cm <?php echo _($serviceStatus) ?></span>
          </button>
        </div>
      </div><!-- /.row -->
    </div><!-- /.card-header -->
		<div class="card-body">
		<?php $status->showMessages(); ?>
		<form method="POST" action="?page=xs_cm_conf" class="js-connection-mgr-settings-form">
		<?php echo CSRFTokenFieldTag() ?>
		<!-- Nav tabs -->
				<ul class="nav nav-tabs">
						<li class="nav-item"><a class="nav-link active" href="#server-settings" data-toggle="tab">
						<?php echo _("XS connection settings"); ?></a></li>
						<!--
						<li class="nav-item"><a class="nav-link" href="#static-leases" data-toggle="tab">< ? php echo _("Static Leases") ?></a></li>
						<li class="nav-item"><a class="nav-link" href="#client-list" data-toggle="tab">< ? php echo _("Client list"); ?></a></li> -->
				</ul>
		<!-- Tab panes -->
		<div class="tab-content">
		<div class="tab-pane active" id="server-settings">
		<h4 class="mt-3">Connection settings</h4>
		<div class="row">
			<div class="form-group col-md-6">
			
				<div class="info-item"><div> 
				<label for="code">Modem Version:</label>
				</div></div>
				
				<!--
				<input type="text" class="form-control"name="ModemVersion" value="< ? php echo htmlspecialchars($ModemVersion, ENT_QUOTES); ?>" />
				-->
				
				<div class="info-item"><div> 
				<?php echo htmlspecialchars($ModemVersion, ENT_QUOTES); ?>
				</div></div>
				
				<!--
				<select class="form-control" name="interface">
				< ? php foreach ($interfaces as $if) : ?>
						< ? php $if_quoted = htmlspecialchars($if, ENT_QUOTES) ?>
						< ? php $selected  = $if === $conf['interface'] ? ' selected="selected"' : '' ?>
					<option value="<?php echo $if_quoted ?>"< ? php echo $selected ?>>< ? php echo $if_quoted ?></option>
				< ? php endforeach ?>
				</select>-->
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6">
			<!--
				<label for="code">
				< ? php echo _("SIM Type"); ?>
				</label> -->
				
				<div class="info-item"><div> 
				<label for="code">SIM Type:</label>
				</div></div>
				
				<!--
				<input type="text" class="form-control"name="ModemVersion" value="< ? php echo htmlspecialchars($ModemVersion, ENT_QUOTES); ?>" />
				-->
				
				<div class="info-item"><div> 
				<?php echo htmlspecialchars($SIMType, ENT_QUOTES); ?>
				</div></div>
				
				<!--
				<input type="text" class="form-control"name="SIMType" value="< ? php echo htmlspecialchars($SIMType, ENT_QUOTES); ? >" /> -->
			</div>
		</div>


		<div class="row">
			<div class="form-group col-md-6">
				<div class="info-item">
				<div> 
				<label for="code"><?php echo _("SIM Status"); ?></label>
				</div>
				</div>
				
				<div class="info-item"><div> 
				<?php echo htmlspecialchars($sim_state, ENT_QUOTES); ?>
				</div></div>
				<!--
				<input type="text" class="form-control"name="sim_state" value="< ? php echo htmlspecialchars($sim_state, ENT_QUOTES); ?>" /> -->
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("PIN Code"); ?></label>
				<input type="text" class="form-control"name="pin_code" value="<?php echo htmlspecialchars($pin_code, ENT_QUOTES); ?>" />
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6"> <!-- col-xs-3 col-sm-3"> -->
				<label for="code"><?php echo _("Auto Provision"); ?></label>
				<select class="form-control" name="auto_provision">
					<option value="1"  <?php echo $auto_provision?' selected="selected"':'' ?> >Enable</option>
					<option value="0"  <?php echo $auto_provision?'':'selected="selected"'  ?> >Disable</option>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("Auto Connect"); ?></label>
				<select class="form-control" name="auto_connection">
					<option value="1"  <?php echo $auto_connection?' selected="selected"':'' ?>  >Enable</option>
					<option value="0"  <?php echo $auto_connection?'':'selected="selected"'  ?>  >Disable</option>
				</select>
				<!--
				<input type="text" class="form-control" name="RangeEnd" value="< ? php echo htmlspecialchars($RangeEnd, ENT_QUOTES); ?>" /> -->
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("APN"); ?></label>
				<input type="text" class="form-control"name="apn" value="<?php echo htmlspecialchars($apn, ENT_QUOTES); ?>" />
				To modify the APN value, you must first Disable the Auto Provision functionality.
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("Call Type"); ?></label>
				<select class="form-control" name="call_type">
					<option value="IPV4"   <?php echo ($call_type==="IPV4")?" selected='selected' ":"";    ?>  >IPV4</option>
					<option value="IPV6"   <?php echo ($auth_type==="IPV6")?" selected='selected' ":"";    ?>  >IPV6</option>
					<option value="IPV4V6" <?php echo ($auth_type==="IPV4V6")?" selected='selected' ":"";  ?>  >IPV4V6</option>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("Auth Type"); ?></label>
				<select class="form-control" name="auth_type">
					<option value="NONE" <?php echo ($auth_type==="NONE")?" selected='selected' ":"";  ?> >NONE</option>
					<option value="PAP"  <?php echo ($auth_type==="PAP")?" selected='selected' ":"";  ?>  >PAP</option>
					<option value="CHAP" <?php echo ($auth_type==="CHAP")?" selected='selected' ":"";  ?>  >CHAP</option>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("User Name"); ?></label>
				<input type="text" class="form-control"name="auth_user" value="<?php echo htmlspecialchars($auth_user, ENT_QUOTES); ?>" />
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("Password"); ?></label>
				<input type="text" class="form-control"name="auth_password" value="<?php echo htmlspecialchars($auth_password, ENT_QUOTES); ?>" />
			</div>
		</div>

		<div class="row">
			<div class="form-group col-md-6">
				<label for="code"><?php echo _("Roaming"); ?></label>
				<select class="form-control" name="roaming">
					<option value="1"  <?php echo $roaming?' selected="selected"':'' ?>   >Enable</option>
					<option value="0"  <?php echo $roaming?'':'selected="selected"'  ?>   >Disable</option>
				</select>
			</div>
		</div>
		
		<input type="submit" class="btn btn-outline btn-primary" value="<?php echo _("Save and Apply"); ?>" name="saveconnectionmgrconfig" />
		
<!--
		< ? php if (!RASPI_MONITOR_ENABLED) : ?>
				<input type="submit" class="btn btn-outline btn-primary" value="< ? php echo _("Save settings"); ?>" name="savedhcpdsettings" />
				< ? php if ($dnsmasq_state) : ?>
					<input type="submit" class="btn btn-warning" value="< ? php echo _("Stop dnsmasq") ?>" name="stopdhcpd" />
				< ? php else : ?>
					<input type="submit" class="btn btn-success" value="< ? php echo _("Start dnsmasq") ?>" name="startdhcpd" />
				< ? php endif ?>
		< ? php endif ?> -->
		
		</div><!-- /.tab-pane -->

  </div><!-- /.tab-content -->
</form>
</div><!-- ./ card-body -->
<div class="card-footer"> <?php echo _("Information provided by xs_cm"); ?></div>
    </div><!-- /.card -->
</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
