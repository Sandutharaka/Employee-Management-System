<?php
include_once("../script/header.php");
include_once("../conf/conf.php");

session_start();

// Initialize variables for filter options
$employeeID = isset($_GET['employeeID']) ? $_GET['employeeID'] : '';
$employeeName = isset($_GET['employeeName']) ? $_GET['employeeName'] : '';
$level = isset($_GET['level']) ? $_GET['level'] : '';
$selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : date('Y-m');
$bonus = isset($_GET['bonus']) ? $_GET['bonus'] : 0;
$description = isset($_GET['description']) ? $_GET['description'] : '';

$_SESSION['selectedMonth'] = $selectedMonth;
$_SESSION['description'] = $description;

// Query to fetch data based on filter options
$query = "SELECT employee.empId, empName, 
                 SUM(attendance.workHours) AS totalWorkHours, 
                 salaryrate.workHoursRate AS workHoursRate, 
                 (SUM(attendance.workHours) * salaryrate.workHoursRate) AS workHourAmount,
                 SUM(attendance.overTimeHours) AS totalOverTimeHours, 
                 salaryrate.overTimeHoursRate AS overTimeHoursRate, 
                 (SUM(attendance.overTimeHours) * salaryrate.overTimeHoursRate) AS overTimeAmount
          FROM employee 
          LEFT JOIN attendance ON employee.empId = attendance.empId 
          LEFT JOIN salaryrate ON employee.empLevel = salaryrate.level
          WHERE 1=1 AND DATE_FORMAT(attendance.date, '%Y-%m') = '$selectedMonth'";

// Add filter conditions to the query
if ($employeeID != '') {
    $query .= " AND employee.empId = '$employeeID'";
}
if ($employeeName != '') {
    $query .= " AND employee.empName LIKE '%$employeeName%'";
}
if ($level != '') {
    $query .= " AND employee.empLevel = '$level'";
}

// Group by employee ID and name
$query .= " GROUP BY employee.empId, empName";

$result = mysqli_query($conn, $query);

// Initialize array to store data
$employeeData = array();

// Fetch data and store in array
while ($row = mysqli_fetch_assoc($result)) {
    $totalWorkHoursPayment = $row['workHourAmount'] + $row['overTimeAmount'];
    $bonusAmount = $bonus;
    $totalSalary = $totalWorkHoursPayment + $bonusAmount;

    // Store data in array
    $employeeData[] = array(
        'empId' => $row['empId'],
        'empName' => $row['empName'],
        'totalWorkHours' => $row['totalWorkHours'],
        'totalOverTimeHours' => $row['totalOverTimeHours'],
        'workHoursRate' => $row['workHoursRate'],
        'overTimeHoursRate' => $row['overTimeHoursRate'],
        'bonus' => $bonusAmount,
        'totalSalary' => $totalSalary
    );
}
?>

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

<?php include_once("../script/header.php"); ?>

<div class="container2">
    <!-- Filter options -->
    <form method="GET">
        <label class="form-label"><strong>Select Employee</strong></label> <br>
        <input type="text" id="employeeID" name="employeeID" class="inputTextFilter" placeholder="Employee ID" value="<?php echo $employeeID; ?>">
        <input type="text" id="employeeName" name="employeeName" class="inputTextFilter" placeholder="Employee Name" value="<?php echo $employeeName; ?>">
        <select id="level" name="level" class="inputTextFilter">
            <option value="">Select Level</option>
            <option value="Level1" <?php echo ($level == 'Level1') ? 'selected' : ''; ?>>Level 1</option>
            <option value="Level2" <?php echo ($level == 'Level2') ? 'selected' : ''; ?>>Level 2</option>
            <option value="Level3" <?php echo ($level == 'Level3') ? 'selected' : ''; ?>>Level 3</option>
        </select>
        <input type="month" id="monthPicker" name="selectedMonth" class="inputTextFilter" value="<?php echo $selectedMonth; ?>" min="2000-01" max="<?php echo date('Y-m'); ?>">
        <input type="submit" value="Filter" class="filterbtn">

        <hr>

            <label class="form-label"><strong>Add Bonus</strong></label> <br>
            <input type="number" name="bonus" value="0" class="inputTextFilter" placeholder="Bonus">
            <br>
            <textarea name="description" id="description" cols="300" rows="200" class="inputTextArea" placeholder="Bonus Description"></textarea>
            <br>
            <input type="submit" value="Add Bonus" class="filterbtn">

    </form>
</div>

<div class="container2">
    <!-- Output table -->
    <table class="tbl" width="100%">
        <tr class="tblHead">
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Total Work Hours</th>
            <th>Work Hour Rate</th>
            <th>Total Work Hour Amount</th>
            <th>Total Overtime Hours</th>
            <th>Overtime Hour Rate</th>
            <th>Total Overtime Amount</th>
            <th>Total workHours Payment</th>
            <th>Bonus Amount</th>
            <th>Total Salary</th>
        </tr>
        <?php
        // Display results and populate array
        foreach ($employeeData as $data) {
            $workHourAmount = $data['totalWorkHours'] * $data['workHoursRate'];
            $overTimeAmount = $data['totalOverTimeHours'] * $data['overTimeHoursRate'];
            $totalWorkHoursPayment = $workHourAmount + $overTimeAmount;
            $totalSalary = $totalWorkHoursPayment + $data['bonus'];
            echo "<tr>";
            echo "<td>{$data['empId']}</td>";
            echo "<td>{$data['empName']}</td>";
            echo "<td>{$data['totalWorkHours']}</td>";
            echo "<td>{$data['workHoursRate']}</td>";
            echo "<td>$workHourAmount</td>";
            echo "<td>{$data['totalOverTimeHours']}</td>";
            echo "<td>{$data['overTimeHoursRate']}</td>";
            echo "<td>$overTimeAmount</td>";
            echo "<td>$totalWorkHoursPayment</td>";
            echo "<td>{$data['bonus']}</td>";
            echo "<td>$totalSalary</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

<?php

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $selectedMonth = $_SESSION['selectedMonth'];
        $description = $_SESSION['description'];

        foreach ($employeeData as $data) {
            #$query2 = "INSERT INTO salary (empId, totalWorkHours, toalOverTimeHours, workHoursRate, overTimeHoursRate, bonus, `description`, total, 'month') VALUES ('$data['empId']', '$data['totalWorkHours']', '$data['totalOverTimeHours']', '$data['workHoursRate']', '$data['overTimeHoursRate']', '$data['bonus']', '$description', '$data['totalSalary']', '$selectedMonth') ON DUPLICATE KEY UPDATE $columnName = $value";

            $query2 = "INSERT INTO salary (empId, totalWorkHours, totalOverTimeHours, workHoursRate, overTimeHoursRate, bonus, `description`, total, `month`) VALUES ('" . $data['empId'] . "', '" . $data['totalWorkHours'] . "', '" . $data['totalOverTimeHours'] . "', '" . $data['workHoursRate'] . "', '" . $data['overTimeHoursRate'] . "', '" . $data['bonus'] . "', '" . $description . "', '" . $data['totalSalary'] . "', '$selectedMonth') ON DUPLICATE KEY UPDATE empId = '" . $data['empId'] . "'";

            #echo $query2;

            mysqli_query($conn, $query2);

            
        }
        
    }

?>

<form method="POST">
    <input type="submit" value="Save Salary" class="btn">
</form>

<br><br><br><br>

<!-- Footer section -->
<footer class="footer">
    <div class="container2">
        <a href="adminDashboard.php"><button class="btn">Back to Dashboard</button></a>
    </div>
</footer>

</body>
</html>
