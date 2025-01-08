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
    session_start()
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

    <hr>
    <form method="GET">
    <input type="text" id="commonHour" name="commonHour" class="inputTextFilter">
    <input type="submit" name="addCommonHourBtn" id="addCommonHourBtn" value="Add for every employee" class="btn">
    </form>

        
    <br>


    <form method="POST">
        Select Date : 
    <input type="date" id="attenDate" name="attenDate" class="inputTextFilter" required>
    <input type="submit" value="Set Date" class="btn">
    </form>

    <hr>

    <form method="GET">
    <div class="container2" style="padding-bottom: 200px;">
        <?php

            if(isset($_POST['attenDate'])) {
                if($_POST['attenDate'] != Null) {

                    #$date = $_POST['attenDate'];
                    $_SESSION['post_date'] = $date = $_POST['attenDate'];

                    echo "<font color=green> You setup the date as : ".$_SESSION['post_date']."</font>";

                    echo "<br><br><hr>";

                    // Construct SQL query based on filter options
                    $query = "SELECT employee.empId, empName, empLevel FROM employee WHERE 1=1";
                    
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
                    echo "<th>Employee ID</th><th>Employee Name</th><th>Level</th><th>Work Hours</th><th>Over Time Hours</th>";
                    echo "</tr>";
                    while($row = mysqli_fetch_row($result)){
                        echo "<tr class='tblRow'>";
                        echo "<td> $row[0] </td>";
                        echo "<td> $row[1] </td>";
                        echo "<td> $row[2] </td>";

                        $query2 = "SELECT workHours, overTimeHours FROM attendance WHERE date='". $_SESSION['post_date'] ."' AND empId='$row[0]'";
                        $result2 = mysqli_query($conn, $query2);
                        $row2 = mysqli_fetch_row($result2);

                        if(mysqli_num_rows($result2)==1){
                            echo "<td>
                            <input type='number' value=$row2[0] name=$row[0]"."wh"." class='inputTextFilter attenInput' id='workHour'>
                            </td>";
                        }
                        else{
                            echo "<td>
                            <input type='number' value=0  name=$row[0]"."wh"." class='inputTextFilter attenInput' id='workHour'>
                            </td>";
                        }

                        if(mysqli_num_rows($result2)==1){
                            echo "<td>
                            <input type='number' value=$row2[1] name=$row[0]"."ot"." class='inputTextFilter attenInput' id='overTimeHour'>
                            </td>";
                        }
                        else{
                            echo "<td>
                            <input type='number' value=0 name=$row[0]"."ot"." class='inputTextFilter attenInput' id='overTimeHour'>
                            </td>";
                        }

                    }
                    echo "</table>";
                }
                
            }
            else{
                // Construct SQL query based on filter options
                    $query = "SELECT employee.empId, empName, empLevel FROM employee WHERE 1=1";

                    echo "<font color=red>Please set the date first</font>";
                    echo "<br><br><hr>";
                    
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
                    echo "<th>Employee ID</th><th>Employee Name</th><th>Level</th><th>Work Hours</th><th>Over Time Hours</th>";
                    echo "</tr>";
                    while($row = mysqli_fetch_row($result)){
                        echo "<tr class='tblRow'>";
                        echo "<td> $row[0] </td>";
                        echo "<td> $row[1] </td>";
                        echo "<td> $row[2] </td>";

                        echo "<td>
                            <input type='number' value=0  name=$row[0]"."wh"." class='inputTextFilter attenInput' id='workHour'>
                            </td>";

                        echo "<td>
                            <input type='number' value=0  name=$row[0]"."ot"." class='inputTextFilter attenInput' id='overTimeHour'>
                            </td>";

                    }
                    echo "</table>";
            }
            
        ?>
    </div>

    <?php
    if($_SERVER['REQUEST_METHOD']=='GET'){
        $data = $_GET;
        #print_r($data);

        $date =  $_SESSION['post_date'];

        foreach ($data as $key => $value) {

            $empId = substr($key, 0, -2);

            $type = substr($key, -2);

            $columnName = ($type === 'wh') ? 'workHours' : 'overTimeHours';

            $query3 = "INSERT INTO attendance (empId, date, $columnName) VALUES ('$empId', '$date', $value) ON DUPLICATE KEY UPDATE $columnName = $value";
            #echo $query3;
            #echo "<br>";

            mysqli_query($conn, $query3);
        }

    }
    ?>


    <!-- Footer section -->
    <footer class="footer">
        <div class="container2">
        <button type="submit" class="btn" style="height: 60px;"><span class="material-symbols-outlined"> check_circle </span> <br> Update Attendance </button>
        </div>
        </form>

        <form action="adminDashboard.php">
        <div class="container2">
        <a href="adminDashboard.php"><button class="btn">Back to Dashboard</button></a>
        </div>
        <form>
    </footer>

    

    <!-- JavaScript code -->
    <script>
        document.getElementById('addCommonHourBtn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission
            
            var commonHourValue = document.getElementById('commonHour').value;
            var workHourInputs = document.querySelectorAll('.attenInput#workHour');
            
            // Set value of workHour inputs
            workHourInputs.forEach(function(input) {
                input.value = commonHourValue;
            });
        });
    </script>

</body>
</html>
