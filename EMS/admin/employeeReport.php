<?php
include_once("../script/header.php");
include_once("../conf/conf.php");

$data = [];
$total_workHours = 0;
$total_overTimeHours = 0;

// Check if empID is set in the URL, if not, set it to null
$empID = isset($_GET['empID']) ? $_GET['empID'] : null;

// Check if selectedMonth is set in the URL, if not, set it to the current month
$selectedMonth = isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : date('Y-m');

// Query to fetch attendance data for the specified empID and selectedMonth
$query = "SELECT date, workHours, overTimeHours FROM attendance WHERE empId = '$empID' AND DATE_FORMAT(date, '%Y-%m') = '$selectedMonth'";
$result = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en" class="conthtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <?php include_once("../style/fontIconConfig.html"); ?>
    <title>Employee Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="contbody">

<form method="GET">
    <div class="container2">
        <input type="text" value="<?php echo $empID; ?>" id="employeeID" name="empID" class="inputTextFilter" placeholder="Employee ID">
        <input type="month" id="monthPicker" name="selectedMonth" class="inputTextFilter" value="<?php echo $selectedMonth; ?>" min="2000-01" max="<?php echo date('Y-m'); ?>">
        <input type="submit" value="View Report" class="filterbtn">
    </div>
</form>

<hr>
<div class="container2"> Monthly view </div>
<hr>

<div class="container3">
    <div class="calendar-card">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = [
                    'date' => $row['date'],
                    'workHours' => $row['workHours'],
                    'overtimeHours' => $row['overTimeHours']
                ];
                echo "<div class='calendar-item'>";
                echo "<div class='date'>" . $row["date"] . "</div>";
                echo "<div class='work-hours'>Work Hours: " . $row["workHours"] . "</div>";
                $total_workHours += $row["workHours"];
                echo "<div class='overtime-hours'>Overtime Hours: " . $row["overTimeHours"] . "</div>";
                $total_overTimeHours += $row["overTimeHours"];
                echo "<div class='total-hours'>Total Hours: " . $row["overTimeHours"]+$row["workHours"] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-data'>No data found for the selected employee and month.</div>";
        }
        ?>
    </div>
</div>

<script>
// JavaScript code to create a bar chart using Chart.js
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($data, 'date')); ?>,
            datasets: [{
                label: 'Work Hours',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: <?php echo json_encode(array_column($data, 'workHours')); ?>
            }, {
                label: 'Overtime Hours',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: <?php echo json_encode(array_column($data, 'overtimeHours')); ?>
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
});
</script>


<hr>
<div class="container2"> Monthly Graph </div>
<hr>

<div class="container2">
    <canvas id="myChart"></canvas>
</div>

<hr>
<div class="container2"> Monthly Summary </div>
<hr>

<div class="container2">
<?php
    $query2 = "SELECT empName, empAge, empLevel FROM employee WHERE empId = '$empID'";
    $result2 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($result2);

    if(mysqli_num_rows($result) > 0){
        echo "<table class='tbl'>";
        echo "<tr class='tblRow'> <td>Employee Name</td> <td>$row2[empName]</td> </tr>";
        echo "<tr class='tblRow'> <td>Employee Age</td> <td>$row2[empAge]</td> </tr>";
        echo "<tr class='tblRow'> <td>Employee Level</td> <td>$row2[empLevel]</td> </tr>";
        echo "<tr class='tblRow'> <td>Total Work Hours</td> <td>$total_workHours</td> </tr>";
        echo "<tr class='tblRow'> <td>Total Overtime Hours</td> <td>$total_overTimeHours</td> </tr>";
        echo "</table>";
    }

?>
</div>

<hr>
<div class="container2"> Monthly Salary Report </div>
<hr>

<div class="container2">
<?php
    $query3 = "SELECT empId, totalWorkHours, totalOverTimeHours, workHoursRate, overTimeHoursRate, bonus, `description`, total, `month` FROM salary WHERE empId = '$empID' AND `month` = '$selectedMonth'";
    $result3 = mysqli_query($conn, $query3);
    $row3 = mysqli_fetch_assoc($result3);

    if(mysqli_num_rows($result3) > 0){
        echo "<table class='tbl'>";
        echo "<tr class='tblRow'> <td>Employee ID</td> <td>$row3[empId]</td> </tr>";
        echo "<tr class='tblRow'> <td>Total Work Hours</td> <td>$row3[totalWorkHours]</td> </tr>";
        echo "<tr class='tblRow'> <td>Tottal Overtime Hours</td> <td>$row3[totalOverTimeHours]</td> </tr>";
        echo "<tr class='tblRow'> <td>Work Hours Rate</td> <td>$row3[workHoursRate]</td> </tr>";
        echo "<tr class='tblRow'> <td>Overtime Hours Rate</td> <td>$row3[overTimeHoursRate]</td> </tr>";
        echo "<tr class='tblRow'> <td>Bonus</td> <td>$row3[bonus]</td> </tr>";
        echo "<tr class='tblRow'> <td>Description</td> <td>$row3[description]</td> </tr>";
        echo "<tr class='tblRow'> <td>Total</td> <td>$row3[total]</td> </tr>";
        echo "</table>";
    }

?>
</div>

<br><br><br><br><br><br>


<!-- Footer section -->
<footer class="footer">
    <div class="container2">
        <a href="adminDashboard.php"><button class="btn">Back to Dashboard</button></a>
    </div>
</footer>

</body>
</html>
