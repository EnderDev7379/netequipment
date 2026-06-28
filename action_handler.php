<?php
session_start();
require_once 'db_init.php';
require_once 'utils.php';
global $connection;

if (isset($_POST['action'])) {
	switch ($_POST['action']) {
		case 'Log Out':
		case 'logout':
			session_destroy();
			safeReload(null);
			break;
		case 'Insert Switch':
			$manufacturer = $_POST['manufacturer'];
			$name = $_POST['name'];
			$rj45 = $_POST['rj45'];
			$poe = $_POST['poe'];
			$sfp = $_POST['sfp'];
			$switching_capacity = $_POST['switching_capacity'];
			$port_speed = $_POST['port_speed'];
			$forwarding = $_POST['forwarding'];
			$table_size = $_POST['table_size'];
			$buffer_size = $_POST['buffer_size'];
			$connection->query("INSERT INTO switches(manufacturer_id, name, rj45_ports, poe_ports, sfp_ports, switching_capacity, port_speed, forwarding_method, address_table, packet_buffer) VALUES
				($manufacturer, '$name', $rj45, $poe, $sfp, $switching_capacity, $port_speed, '$forwarding', $table_size, $buffer_size);");
			echo "$connection->error";
			safeReload(null);
	}
}