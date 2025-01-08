<?php
include_once("../conf/conf.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['addCommonHourBtn'])) {
    // Fetch data from the form
    $attenDate = $_GET['attenDate'];
    $commonWorkHour = $_GET['commonHour'];

    // Construct SQL query to insert data into attendance table
    $query = "INSERT INTO attendance (empId, date, workHours) VALUES ";

    // Loop through the employee data
    $employeeIds = $_GET['employeeId']; // Assuming you have an input for employeeId in the form
    $workHours = $_GET['workHour'];
    $overTimeHours = $_GET['overTimeHour'];
    $numEmployees = count($employeeIds);

    for ($i = 0; $i < $numEmployees; $i++) {
        $empId = $employeeIds[$i];
        $workHour = $workHours[$i];
        $overTimeHour = $overTimeHours[$i];
        
        // Add values to the query
        $query .= "('$empId', '$attenDate', '$workHour', '$overTimeHour')";
        if ($i < $numEmployees - 1) {
            $query .= ", ";
        }
    }

    // Execute the query
    if (mysqli_query($conn, $query)) {
        echo "Attendance updated successfully.";
    } else {
        echo "Error updating attendance: " . mysqli_error($conn);
    }
}
?>
