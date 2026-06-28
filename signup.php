<?php
if (isset($_POST['signup'])) {
    require_once "db_init.php";
    global $connection;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $connection->execute_query("INSERT INTO users (username, password, type, email) VALUES
                                (?, ?, 'USER', ?)", [ $username, $email, $password ]);
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
    <h1 class="text-5xl text-center row-span-1">Sign Up</h1>
    <form method="post" class="row-span-2 flex flex-col space-y-5">
        <label>
            Username:
            <input class="w-full p-1 shadow-md shadow-gray-800 rounded-md font-normal" type="text" placeholder="john_doe" name="username" maxlength="24" required>
        </label>
        <label>
            E-Mail:
            <input class="w-full p-1 shadow-md shadow-gray-800 rounded-md font-normal" type="email" placeholder="john.doe@example.com" name="email" maxlength="96" required>
        </label>
        <label>
            Password
            <input class="w-full p-1 shadow-md shadow-gray-800 rounded-md font-normal" type="password" name="password" maxlength="96" required>
        </label>
        <!--            <input class="w-full p-1 border border-b-3 rounded-md font-normal hover:bg-black/10 active:border-2 active:bg-black/20" type="submit">-->
        <input class="w-full p-1 shadow-md shadow-gray-800 rounded-md font-normal hover:bg-black/10 active:shadow-inner active:bg-black/15" type="submit" name="signup" value="Sign Up">
    </form>
</div>
</body>
</html>