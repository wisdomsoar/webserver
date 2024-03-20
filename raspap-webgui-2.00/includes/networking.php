<?php

include_once('includes/status_messages.php');

/**
*
*
*/
function DisplayNetworkingConfig()
{

    $status = new StatusMessages();

	$all_interfaces = array();
	$interfaces = array();
    exec("ls /sys/class/net | grep -v sit0", $all_interfaces);
	$len = count($all_interfaces);
	for ($i = 0; $i < $len; $i++)
	{
		$tmp_operstate = array();
		exec("cat /sys/class/net/$all_interfaces[$i]/operstate", $tmp_operstate);
		
		//exec("echo '0: $tmp_operstate[0]' >> /tmp/operstate.txt", $tmp);
		//exec("echo '1: $tmp_operstate[1]' >> /tmp/operstate.txt", $tmp);
		
		$pos = strpos($tmp_operstate[0], 'down');
		if ( $pos === false )
		{
			array_push($interfaces, $all_interfaces[$i]);
		}
	}

    foreach ($interfaces as $interface) {
        exec("ip a show $interface", $$interface);
    }
    echo renderTemplate("networking", compact("status", "interfaces"));
}
