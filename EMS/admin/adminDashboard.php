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
        <a href="manageEmployee.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">group</span><br>
            Manage Employee
        </div>
        </a>

        <a href="markAttendence.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">checklist_rtl</span><br>
            Mark Attendence
        </div>
        </a>

        <a href="calculateSalary.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">calculate</span><br>
            Calculate Salary
        </div>
        </a>

        <a href="employeeReport.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">lab_profile</span><br>
            Generate Report
        </div>
        </a>

        <a href="salaryRate.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">currency_exchange</span><br>
            Salary Rate
        </div>
        </a>

        <a href="adminLeave.php">
        <div class="optionContainer">
        <span class="material-symbols-outlined" style="font-size: 75px;">holiday_village</span><br>
            Check Leave
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
