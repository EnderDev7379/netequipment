<?php
$connection = new mysqli("localhost", "root", "", "networking_equipment", 3307);

if ($connection->connect_error) {
    echo "An Error Occured:\n" . $connection->connect_error;
    exit();
}