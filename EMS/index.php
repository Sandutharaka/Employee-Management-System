<!DOCTYPE html>
<html lang="en" class="comhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <?php include_once("style/fontIconConfig.html"); ?>
    <title>Employee Management System</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="asset/logo.jpg" alt="Employee Management System Logo">
        </div>
        <div class="header-text">
            Employee Management System - Bit Lord
        </div>
    </header>

    <div class="container">
        <a href="user/userlogin.php">
        <div class="employee">
        <span class="material-symbols-outlined" style="font-size: 75px;">group</span><br>
            Employee
        </div>
        </a>

        <a href="admin/adminlogin.php">
        <div class="admin">
        <span class="material-symbols-outlined" style="font-size: 75px;">admin_panel_settings</span><br>
            Admin
        </div>
        </a>
    </div>

</body>
</html>