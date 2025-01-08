<!DOCTYPE html>
<html lang="en" class="comhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <?php include_once("../style/fontIconConfig.html"); ?>
    <title>Employee Management System</title>
</head>
<body class="combody">
    <?php include_once("../script/header.php"); ?>

    <div class="container">
        <a href="viewReport.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">lab_profile</span><br>
            View Report
        </div>
        </a>

        <a href="userLeave.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">holiday_village</span><br>
            Leave Apply
        </div>
        </a>
    </div>

    <!-- Footer section -->
    <footer class="footer">
        <div class="container2">
            <a href="../index.php"><button class="btn">Logout</button></a>
        </div>
    </footer>

</body>
</html>
