<?php
require_once "action_handler.php";
require_once "utils.php";
$subdomains = explode('.', $_SERVER["HTTP_HOST"]);
array_pop($subdomains);
array_pop($subdomains);
if ($subdomains[0] != "netequipment") {
    redirect("/404notfound");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <?php require "common_meta.php"?>
</head>
<body>
    <?php require "header.php"?>
    <?php require "footer.php"?>
</body>
</html>