<?php

include_once('includes/status_messages.php');

/**
*
* Manage DHCP configuration
*
*/
function DisplayConnectionConfig()
{

    $status = new StatusMessages();
    if (isset($_POST['saveconnectionmgrconfig'])) {
        //$errors = '';

		$web_pinCode = isset($_POST['pin_code']) ? $_POST['pin_code'] : '';
		$web_autoProvision = isset($_POST['auto_provision']) ? intval($_POST['auto_provision']) : 1;
		$web_autoConnection = isset($_POST['auto_connection']) ? intval($_POST['auto_connection']) : 0;
		$web_apn = isset($_POST['apn']) ? $_POST['apn'] : '';
		$web_callType = isset($_POST['call_type']) ? $_POST['call_type'] : 'IPV4V6';
		$web_authType = isset($_POST['auth_type']) ? $_POST['auth_type'] : 'NONE';
		$web_authUser = isset($_POST['auth_user']) ? $_POST['auth_user'] : '';
		$web_authPassword = isset($_POST['auth_password']) ? $_POST['auth_password'] : '';
		$web_roaming = isset($_POST['roaming']) ? intval($_POST['roaming']) : 0;

		// Construct the associative array
		$data = array(
			"cm_cfg" => array(
				"auto_provision" => $web_autoProvision,
				"auto_connection" => $web_autoConnection
			),
			"apn_cfg" => array(
				"apn" => $web_apn,
				"call_type" => $web_callType,
				"auth_type" => $web_authType,
				"auth_user" => $web_authUser,
				"auth_password" => $web_authPassword,
				"roaming" => $web_roaming
			)
		);

		$json_created_from_web = json_encode($data, JSON_PRETTY_PRINT);

		$file = '/data/config/xs_cm.json';
		$return = file_put_contents($file, $json_created_from_web);		
		
		exec("xs_cm_cli reload_config", $reload_result);
		
		if ($return) 
		{
            $status->addMessage('XS Connection Mananger configuration (xs_cm) updated successfully', 'success');
        } else 
		{
            $status->addMessage('XS Connection Mananger configuration (xs_cm) failed to be updated. (try to remount / as rw?) ', 'danger');
        }
goto SKIP_WRITE_DHCP_CONFIG;		
		
        define('IFNAMSIZ', 16);
        if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['interface']) ||
        strlen($_POST['interface']) >= IFNAMSIZ) {
              $errors .= _('Invalid interface name.').'<br />'.PHP_EOL;
        }

        if (!preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_POST['RangeStart']) &&
        !empty($_POST['RangeStart'])) {  // allow ''/null ?
              $errors .= _('Invalid DHCP range start.').'<br />'.PHP_EOL;
        }

        if (!preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_POST['RangeEnd']) &&
        !empty($_POST['RangeEnd'])) {  // allow ''/null ?
              $errors .= _('Invalid DHCP range end.').'<br />'.PHP_EOL;
        }

        if (!ctype_digit($_POST['RangeLeaseTime']) && $_POST['RangeLeaseTimeUnits'] !== 'infinite') {
            $errors .= _('Invalid DHCP lease time, not a number.').'<br />'.PHP_EOL;
        }

        if (!in_array($_POST['RangeLeaseTimeUnits'], array('m', 'h', 'd', 'infinite'))) {
            $errors .= _('Unknown DHCP lease time unit.').'<br />'.PHP_EOL;
        }

        $return = 1;
        if (empty($errors)) {
            $config = 'interface='.$_POST['interface'].PHP_EOL.
                  'dhcp-range='.$_POST['RangeStart'].','.$_POST['RangeEnd'].
                  ',255.255.255.0,';
            if ($_POST['RangeLeaseTimeUnits'] !== 'infinite') {
                $config .= $_POST['RangeLeaseTime'];
            }

            $config .= $_POST['RangeLeaseTimeUnits'].PHP_EOL;

            for ($i=0; $i < count($_POST["static_leases"]["mac"]); $i++) {
                $mac = trim($_POST["static_leases"]["mac"][$i]);
                $ip  = trim($_POST["static_leases"]["ip"][$i]);
                if ($mac != "" && $ip != "") {
                    $config .= "dhcp-host=$mac,$ip".PHP_EOL;
                }
            }

            if ($_POST['DNS1']){
                $config .= "dhcp-option=6," . $_POST['DNS1'];
                if ($_POST['DNS2']){
                    $config .= ','.$_POST['DNS2'];
                }
                $config .= PHP_EOL;
            }

            file_put_contents("/tmp/dnsmasqdata", $config);
            system('sudo cp /tmp/dnsmasqdata '.RASPI_DNSMASQ_CONFIG, $return);
        } else {
            $status->addMessage($errors, 'danger');
        }

        if ($return == 0) {
            $status->addMessage('Dnsmasq configuration updated successfully', 'success');
        } else {
            $status->addMessage('Dnsmasq configuration failed to be updated.', 'danger');
        }
    }

SKIP_WRITE_DHCP_CONFIG:

    exec('pidof xs_cm | wc -l', $xs_cm);
    $xs_cm_state = ($xs_cm[0] > 0);

    if (isset($_POST['startdhcpd'])) {
        if ($dnsmasq_state) {
            $status->addMessage('dnsmasq already running', 'info');
        } else {
            exec('sudo /etc/init.d/dnsmasq start', $dnsmasq, $return);
            if ($return == 0) {
                $status->addMessage('Successfully started dnsmasq', 'success');
                $dnsmasq_state = true;
            } else {
                $status->addMessage('Failed to start dnsmasq', 'danger');
            }
        }
    } elseif (isset($_POST['stopdhcpd'])) {
        if ($dnsmasq_state) {
            exec('sudo /etc/init.d/dnsmasq stop', $dnsmasq, $return);
            if ($return == 0) {
                $status->addMessage('Successfully stopped dnsmasq', 'success');
                $dnsmasq_state = false;
            } else {
                $status->addMessage('Failed to stop dnsmasq', 'danger');
            }
        } else {
            $status->addMessage('dnsmasq already stopped', 'info');
        }
    }

    $serviceStatus = $xs_cm_state ? "up" : "down";
	
	$xs_info = array();
	exec('xsinfo', $xs_info);
/*	xsinfo

TARGET NAME:XS4G01
XS  VERSION:XS.DA.04.01.06
APP VERSION:00.00.09
XS MD version:MD.XS.04.01.05
	*/
	$ModemVersion = "";
	$len = count($xs_info);
	for ($i = 0; $i < $len; $i++)
	{
		$pos = strpos($xs_info[$i], 'XS MD version:');
		if ( $pos !== false )
		{
			$ModemVersion = str_replace('XS MD version:', '', $xs_info[$i]);
			break;
		}
	}	
	
	

/*
sim_type=real        display only
*/
	$cm_config = array();
	exec('xs_cm_cli show_config', $cm_config);
	$SIMType = "";
	$len = count($cm_config);
	for ($i = 0; $i < $len; $i++)
	{
		$pos = strpos($cm_config[$i], 'sim_type=');
		if ( $pos !== false )
		{
			$SIMType = str_replace('sim_type=', '', $cm_config[$i]);
			break;
		}
	}
	
	/*
	 xs_cm_cli sim_state
SIM_READY*/
	$sim_state_result = array();
	$sim_state = "";
	exec('xs_cm_cli sim_state', $sim_state_result);
	$sim_state = $sim_state_result[0];
	
	
	$cm_config = array();
	exec('cat /data/config/xs_cm.json', $cm_config);
	$strReturn = implode("\n", $cm_config);
	
	exec('echo "return: "'. $strReturn . ' >> /tmp/web_xs_cm.txt');

/*
{"cm_cfg":{"auto_provision":1,"auto_connection":1},"apn_cfg":{"apn":"internet","call_type":"IPV4","auth_type":"none","auth_user":"","auth_password":"","roaming":1}}/mnt/sdcard/raspap-webgui-2.00/ajax/networking
*/
	$obj = json_decode($strReturn);
	

	$auto_provision = $obj->cm_cfg->{'auto_provision'};
	$auto_connection = $obj->cm_cfg->{'auto_connection'};

	$apn           = $obj->apn_cfg->{'apn'};
	$call_type     = $obj->apn_cfg->{'call_type'};
	$auth_type     = $obj->apn_cfg->{'auth_type'};
	$auth_user     = $obj->apn_cfg->{'auth_user'};
	$auth_password = $obj->apn_cfg->{'auth_password'};
	$roaming       = $obj->apn_cfg->{'roaming'};

exec('echo "apn: "'. $apn .' >> /tmp/web_xs_cm.txt');

goto SKIP_SOME_DHCP_CODE;

    exec('cat '. RASPI_DNSMASQ_CONFIG, $return);
    $conf = ParseConfig($return);
    $arrRange = explode(",", $conf['dhcp-range']);
    $RangeStart = $arrRange[0];
    $RangeEnd = $arrRange[1];
    $RangeMask = $arrRange[2];
    $leaseTime = $arrRange[3];
    $dhcpHost = $conf["dhcp-host"];
    $dhcpHost = empty($dhcpHost) ? [] : $dhcpHost;
    $dhcpHost = is_array($dhcpHost) ? $dhcpHost : [ $dhcpHost ];

    $DNS1 = '';
    $DNS2 = '';
    if (isset($conf['dhcp-option'])){
        $arrDns = explode(",", $conf['dhcp-option']);
        if ($arrDns[0] == '6'){
            if (count($arrDns) > 1){
                $DNS1 = $arrDns[1];
            }
            if (count($arrDns) > 2){
                $DNS2 = $arrDns[2];
            }
        }
    }
  
    $hselected = '';
    $mselected = '';
    $dselected = '';
    $infiniteselected = '';
    preg_match('/([0-9]*)([a-z])/i', $leaseTime, $arrRangeLeaseTime);
    if ($leaseTime === 'infinite') {
        $infiniteselected = ' selected="selected"';
    } else {
        switch ($arrRangeLeaseTime[2]) {
            case 'h':
                $hselected = ' selected="selected"';
                break;
            case 'm':
                $mselected = ' selected="selected"';
                break;
            case 'd':
                $dselected = ' selected="selected"';
                break;
        }
    }

    exec("ip -o link show | awk -F': ' '{print $2}'", $interfaces);
    exec('cat ' . RASPI_DNSMASQ_LEASES, $leases);


SKIP_SOME_DHCP_CODE:

    echo renderTemplate("connection_mgr", compact(
        "status",
        "serviceStatus",
		"ModemVersion",
		"SIMType",
		"sim_state",
		"pin_code",
		"auto_provision",
		"auto_connection",
		"apn",     
		"call_type",
		"auth_type",
		"auth_user",
		"auth_password",
		"roaming",		
        "mselected",
        "hselected",
        "dselected",
        "infiniteselected",
        "dnsmasq_state",
        "conf",
        "dhcpHost",
        "interfaces",
        "leases"
    ));
}
