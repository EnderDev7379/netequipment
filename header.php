<header>
    <nav>
        <div class="flex justify-between bg-gray-700 p-2 text-gray-300 font-semibold items-center">
            <a href="index.php" class="text-2xl font-bold">NetworkingEquipmentSite</a>
            <div class="group">
                <span>Products</span>
                <div class="hidden group-hover:grid grid-rows-2 grid-cols-2 absolute bg-gray-800 border-black border p-3 rounded-lg space-x-3 space-y-3">
                    <a href="routers.php">Routers</a>
                    <a href="switches.php">Switches</a>
                    <a href="">Placeholder1</a>
                    <a href="">Placeholder2</a>
                </div>
            </div>
            <div class="flex space-x-4">
                 <?php
                 if (!isset($_SESSION['user']))
                    echo "
                        <a href='login.php?redirect={$_SERVER['REQUEST_URI']}'>Log In</a>
                        <a href='signup.php'>Sign Up</a>";
                 else
                     echo "
                        <span>{$_SESSION['username']}</span>
                        <form method='post'><input type='submit' name='action' class='text-red-500' value='Log Out'></form>";
                 ?>
            </div>
        </div>
    </nav>
</header>