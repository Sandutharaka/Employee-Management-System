<?php
include_once("../script/header.php");
include_once("../conf/conf.php");

// Fetch data from the salaryrate table
$query = "SELECT * FROM salaryrate";
$result = mysqli_query($conn, $query);

// Check if form is submitted to update values
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through POST data to update values in the database
    foreach ($_POST['data'] as $level => $rates) {
        $workHoursRate = $rates['workHoursRate'];
        $overTimeHoursRate = $rates['overTimeHoursRate'];
        // Update query
        $updateQuery = "UPDATE salaryrate SET workHoursRate='$workHoursRate', overTimeHoursRate='$overTimeHoursRate' WHERE level='$level'";
        mysqli_query($conn, $updateQuery);
    }
    // Redirect to the same page to prevent form resubmission
    header("Location: salaryRate.php");
    exit();
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
    <form method="post">
        <table class="tbl">
            <tr class="tblHead">
                <th>Level</th>
                <th>Work Hours Rate</th>
                <th>Overtime Hours Rate</th>
            </tr>
            <?php
            // Loop through the result set and display data in table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['level']}</td>";
                echo "<td><input type='number' name='data[{$row['level']}][workHoursRate]' value='{$row['workHoursRate']}'></td>";
                echo "<td><input type='number' name='data[{$row['level']}][overTimeHoursRate]' value='{$row['overTimeHoursRate']}'></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <input type="submit" value="Save Changes" class="btn">
    </form>
</div>

<!-- Footer section -->
<footer class="footer">
    <div class="container2">
        <a href="adminDashboard.php"><button class="btn">Back to Dashboard</button></a>
    </div>
</footer>

</body>
</html>
