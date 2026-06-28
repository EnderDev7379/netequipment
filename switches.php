<?php
require_once 'db_init.php';
require_once 'action_handler.php';
global $connection;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
	<?php require "common_meta.php"?>
    <script>
        function calcSwitchingCapacity() {
            var portSpeed = document.getElementById('port_speed').value;
            if (portSpeed === "") return;
            var ports = 0;
            var rj45 = 1 * document.getElementById('rj45_ports').value;
            var sfp = 1 * document.getElementById('sfp_ports').value;
            if (rj45 != 0) ports += rj45;
            if (sfp != 0) ports += sfp;
            if (ports !== 0) document.getElementById('switching_capacity').value = ports * 2 * portSpeed;
        }
    </script>
</head>
<body>
	<?php require "header.php"?>
    <div class="p-5 grid grid-cols-2 grid-flow-row">
    <div class="border-2 rounded-xl p-3 mb-5 ml-5 w-fit">
        <span class='text-xl font-semibold'>Search and Filter</span>
        <form method="get" class='grid grid-rows-6 grid-flow-col space-y-3 space-x-3 mt-3 w-fit'>
            <label class='inline-flex items-center gap-1'>Manufacturer:
                <div class='border rounded-md py-0.5 px-1 group w-fit'>
                    Select
                    <div class="hidden group-hover:grid grid-rows-2 grid-cols-2 absolute bg-white border-black border p-3 rounded-lg space-x-3 space-y-3">
                        <?php
                        $result = $connection->query("SELECT * FROM manufacturers;");
                        while ($row = $result->fetch_assoc()) {
                            echo "<input type='checkbox' name='manufacturer[]' value='{$row['id']}'>{$row['name']}";
                        }
                        ?>
                    </div>
                </div>
            </label>
            <label>Name: <input type='text' maxlength='128' name='name' class='border rounded-md p-0.5'></label>
            <label>№ of RJ45 Ports: <?php operatorSelector('rj45_op')?><input type='number' min='0' step='1' name='rj45' class='border rounded-md p-0.5'></label>
            <label>№ of PoE Ports: <?php operatorSelector('poe_op')?><input type='number' min='0' step='1' name='poe' class='border rounded-md p-0.5''></label>
            <label>№ of SFP Ports: <?php operatorSelector('sfp_op')?><input type='number' min='0' step='1' name='sfp' class='border rounded-md p-0.5''></label>
            <input type='submit' name='action' value='Search' class='justify-self-end col-span-2 w-min border rounded-md py-0.5 px-1.5'>
            <label>Port Speed: <?php operatorSelector('speed_op')?><input type='number' step='1' name='port_speed' class='border rounded-md p-0.5''> Mbps</label>
            <label>Switching Capacity: <?php operatorSelector('capacity_op')?><input type='number' step='1' name='switching_capacity' class='border rounded-md p-0.5'> Mbps</label>
            <label class='inline-flex items-center gap-1'>Forwarding Method:
                <div class='border rounded-md py-0.5 px-1 group w-fit'>
                    Select
                    <div class="hidden group-hover:grid grid-rows-2 grid-cols-2 absolute bg-white border-black border p-3 rounded-lg space-x-3 space-y-3">
                        <input type='checkbox' name='forwarding[]' value='STORE_AND_FORWARD'>Store and Forward
                        <input type='checkbox' name='forwarding' value='CUT_THROUGH'>Cut Through
                    </div>
                </div>
            </label>
            <label>Address Table: <?php operatorSelector('table_op')?><input type='number' step='1' name='table_size' class='border rounded-md p-0.5'> K</label>
            <label>Packet Buffer: <?php operatorSelector('buffer_op')?><input type='number' step='1' name='buffer_size' class='border rounded-md p-0.5'> KiB</label>
        </form>
    </div>
        <?php
        if (isset($_SESSION['user']) && $_SESSION['user_type'] == "ADMIN") {
            $result = $connection->query("SELECT * FROM manufacturers;");
            $manufacturer_select = "";
            while ($manufacturer = $result->fetch_assoc()) {
                $manufacturer_select .= "<option value='{$manufacturer['id']}'>{$manufacturer['name']}</option>";
            }
            echo "
        <div class='border-2 rounded-xl p-3 mb-5 mr-5 w-fit'>
    		<span class='text-xl font-semibold'>Add Switch to Database</span>
    		<form method='post' class='grid grid-rows-6 grid-flow-col space-y-3 space-x-3 mt-3 w-fit'>
    			<label>Manufacturer: <select name='manufacturer' class='border rounded-md p-1'>
    			    $manufacturer_select
    			</select></label>
    			<label>Name: <input type='text' maxlength='128' name='name' class='border rounded-md p-0.5'></label>
    			<label>№ of RJ45 Ports: <input id='rj45_ports' type='number' min='0' step='1' name='rj45' class='border rounded-md p-0.5' onchange='calcSwitchingCapacity()'></label>
    			<label>№ of PoE Ports: <input id='poe_ports' type='number' min='0' step='1' name='poe' class='border rounded-md p-0.5' onchange='calcSwitchingCapacity()'></label>
    			<label>№ of SFP Ports: <input id='sfp_ports' type='number' min='0' step='1' name='sfp' class='border rounded-md p-0.5' onchange='calcSwitchingCapacity()'></label>
			    <input type='submit' name='action' value='Insert Switch' class='justify-self-end col-span-2 w-min border rounded-md py-0.5 px-1.5'>
    			<label>Port Speed: <input id='port_speed' type='number' step='1' name='port_speed' class='border rounded-md p-0.5' onchange='calcSwitchingCapacity()'> Mbps</label>
    			<label>Switching Capacity: <input id='switching_capacity' type='number' step='1' name='switching_capacity' class='border rounded-md p-0.5'> Mbps</label>
    			<label>Forwarding Method: <select name='forwarding' class='border rounded-md p-1'>
                    <option value='STORE_AND_FORWARD'>Store and Forward</option>
                    <option value='CUT_THROUGH'>Cut Through</option>
			    </select></label>
			    <label>Address Table: <input type='number' step='1' name='table_size' class='border rounded-md p-0.5'> K</label>
			    <label>Packet Buffer: <input type='number' step='1' name='buffer_size' class='border rounded-md p-0.5'> KiB</label>
		    </form>
		</div>
		";
        }
        ?>
    <table class="text-xl col-span-2">
        <thead class="font-bold">
            <tr class="*:border-3 *:border-black *:p-3 *:bg-gray-700 text-gray-200">
                <th>ID</th>
                <th>Manufacturer</th>
                <th>Name</th>
                <th>RJ45 Ports</th>
                <th>PoE Ports</th>
                <th>SFP Ports</th>
                <th>Port Speed (Mbps)</th>
                <th>Switching Capacity (Mbps)</th>
                <th>Forwarding Method</th>
                <th>Address Table Size (K)</th>
                <th>Packet Buffer Size (KiB)</th>
            </tr>
        </thead>
        <tbody class="font-semibold">
            <?php
            $query = "SELECT s.*, m.name as manufacturer FROM switches s JOIN manufacturers m on m.id = s.manufacturer_id WHERE '' = ''";
            if ($_GET['action'] == "Search") {
                if (isset($_GET['manufacturer'])) {
                    $manufacturers = $_GET['manufacturer'];
                    $query .= " AND (s.manufacturer_id = $manufacturers[0]";
                    for ($i = 1; $i < count($manufacturers); $i++) {
                        $query .= " OR s.manufacturer_id = $manufacturers[$i]";
                    }
                    $query .= ")";
                } if (!empty($_GET['name'])) {
                    $query .= " AND s.name LIKE '%{$_GET['name']}%'";
                } if (!empty($_GET['rj45'])) {
                    $query .= " AND s.rj45_ports {$_GET['rj45_op']} {$_GET['rj45']}";
                } if (!empty($_GET['poe'])) {
                    $query .= " AND s.poe_ports {$_GET['poe_op']} {$_GET['poe']}";
                } if (!empty($_GET['sfp'])) {
                    $query .= " AND s.sfp_ports {$_GET['rj45_op']} {$_GET['sfp']}";
                } if (!empty($_GET['port_speed'])) {
                    $query .= " AND s.port_speed {$_GET['speed_op']} {$_GET['port_speed']}";
                } if (!empty($_GET['switching_capacity'])) {
                    $query .= " AND s.switching_capacity {$_GET['capacity_op']} {$_GET['switching_capacity']}";
                } if (isset($_GET['forwarding'])) {
                    $forwarding = $_GET['forwarding'];
                    $query .= " AND (s.forwarding_method = $forwarding[0]";
                    for ($i = 1; $i < count($forwarding); $i++) {
                        $query .= " OR s.forwarding_method = $forwarding[$i]";
                    }
                    $query .= ")";
                } if (!empty($_GET['table_size'])) {
                    $query .= " AND s.address_table {$_GET['table_op']} {$_GET['table_size']}";
                } if (!empty($_GET['buffer_size'])) {
                    $query .= " AND s.packet_buffer {$_GET['buffer_op']} {$_GET['buffer_size']}";
                }
            } $query .= ";";
            $result = $connection->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr class='even:bg-gray-600 even:text-white *:border-3 *:border-black *:p-1.5'>
                    <td>{$row['id']}</td>
                    <td>{$row['manufacturer']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['rj45_ports']}</td>
                    <td>{$row['poe_ports']}</td>
                    <td>{$row['sfp_ports']}</td>
                    <td>{$row['port_speed']}</td>
                    <td>{$row['switching_capacity']}</td>
                    <td>{$row['forwarding_method']}</td>
                    <td>{$row['address_table']}</td>
                    <td>{$row['packet_buffer']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
    <?php require "footer.php"?>
</body>
</html>