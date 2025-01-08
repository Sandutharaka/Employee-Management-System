<!DOCTYPE html>
<html lang="en" class="conthtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <?php include_once("../style/fontIconConfig.html"); ?>
    <title>Employee Management System</title>
</head>
<body class="contbody">
    <?php 
    include_once("../script/header.php");
    include_once("../conf/conf.php");
    ?>

    <div class="container2">
        <!-- Filter options -->
        <form method="GET">
            <input type="text" id="employeeID" name="employeeID" class="inputTextFilter" placeholder="Employee ID">
            
            <input type="text" id="employeeName" name="employeeName" class="inputTextFilter" placeholder="Employee Name">
            
            <select id="level" name="level" class="inputTextFilter">
                <option value="">Select Level</option>
                <option value="Level1">Level 1</option>
                <option value="Level2">Level 2</option>
                <option value="Level3">Level 3</option>
            </select>
            
            <input type="submit" value="Filter" class="filterbtn">
        </form>
    </div>

    <div class="container2">
    <a href="addEmployee.php"><button class="btn" style="height: 60px;"><span class="material-symbols-outlined">person_add</span> <br> Add New Employee </button></a>
    </div>

    <hr>

    <div class="container2" style="padding-bottom: 150px;">
        <?php
            // Construct SQL query based on filter options
            $query = "SELECT empId, empName, empAge, empLevel FROM employee WHERE 1=1";
            
            if(isset($_GET['employeeID']) && $_GET['employeeID'] != "") {
                $employeeID = $_GET['employeeID'];
                $query .= " AND empId='$employeeID'";
            }
            if(isset($_GET['employeeName']) && $_GET['employeeName'] != "") {
                $employeeName = $_GET['employeeName'];
                // Using LIKE operator for name filter
                $query .= " AND empName LIKE '%$employeeName%'";
            }
            if(isset($_GET['level']) && $_GET['level'] != "") {
                $level = $_GET['level'];
                $query .= " AND empLevel='$level'";
            }

            $result = mysqli_query($conn, $query);

            echo "<table class='tbl'>";
            echo "<tr class=tblHead>";
            echo "<th>Employee ID</th><th>Employee Name</th><th>Age</th><th>Level</th><th>Report</th><th>Edit</th><th>Delete</th>";
            echo "</tr>";
            while($row = mysqli_fetch_row($result)){
                echo "<tr class='tblRow'>";
                foreach ($row as $key => $value) {
                    echo "<td>";
                    echo $value;
                    echo "</td>";
                }
                echo "<td><a href='employeeReport.php?empID=$row[0]'>
                <span class='material-symbols-outlined'>lab_profile</span>
                </a></td>";
                echo "<td><a href='updateEmployee.php?empID=$row[0]'>
                <span class=material-symbols-outlined>edit</span>
                </a></td>";
                echo "<td><font color=#FF4444><a href='deleteEmployee.php?empID=$row[0]'>
                <span class=material-symbols-outlined>delete</span>
                </a></font></td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </div>

    <!-- Footer section -->
    <footer class="footer">
        <div class="container2">
            <a href="adminDashboard.php"><button class="btn">Back to Dashboard</button></a>
        </div>
    </footer>

</body>
</html>
