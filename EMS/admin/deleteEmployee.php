<?php
include_once("../conf/conf.php");

// Check if empID is provided in the URL
if(isset($_GET['empID'])) {
    $empID = $_GET['empID'];

    // Construct DELETE query
    $delete_query = "DELETE FROM employee WHERE empId='$empID'";

    // Execute the DELETE query
    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        // Deletion successful
        header("Location: manageEmployee.php");
        exit;
    } else {
        // Error occurred while deleting
        header("Location: manageEmployee.php");
        exit;
    }
} else {
    // Redirect to manageEmployee.php if empID is not provided
    header("Location: manageEmployee.php");
    exit;
}
?>
