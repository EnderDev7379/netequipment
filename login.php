<?php
if (isset($_POST['login'])) {
    require_once "db_init.php";
    require_once "utils.php";
    global $connection;
    $identifier = $_POST['username'];
    $password = $_POST['password'];
    $result = $connection->execute_query("SELECT id, username, email, type FROM users WHERE (username=? OR email=?) AND password=?", [ $identifier, $identifier, $password ]);
    echo $connection->error;
    if ($row = $result->fetch_assoc()) {
        session_start();
        $_SESSION['user'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_type'] = $row['type'];
        if (isset($_GET['redirect']))
            redirect($_GET['redirect']);
        else redirect('/index.php');
        exit();
    } else {
        safeReload(-1);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <?php require "common_meta.php"?>
</head>
<body class="h-screen w-screen flex items-center justify-center bg-linear-155 from-blue-600 to-green-500 bg-fixed">
    <div class="w-1/3 h-1/2 grid grid-rows-3 p-15 rounded-2xl shadow-md shadow-gray-800">
        <h2 class="text-5xl text-center row-span-1">Log In</h2>
        <form method="post" class="row-span-2 flex flex-col space-y-5">
            <label>
                Username:
                <input class="w-full p-1 shadow-md shadow-gray-800 rounded-md font-normal" type="text" placeholder="john_doe" name="username" maxlength="24" required>
            </label>
            <label>
                Password
                <input class="w-full p-1 shadow-md shadow-gray-800 rounded-md font-normal" type="password" name="password" required>
            </label>
<!--            <input class="w-full p-1 border border-b-3 rounded-md font-normal hover:bg-black/10 active:border-2 active:bg-black/20" type="submit">-->
            <input class="w-full p-1 shadow-md shadow-gray-800 rounded-md font-normal hover:bg-black/10 active:shadow-inner active:bg-black/15" type="submit" name="login" value="Log In">
        </form>
    </div>
</body>
</html>