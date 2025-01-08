<?php
include_once("../conf/conf.php");

// Check if empID is provided in the URL
if(isset($_GET['empID'])) {
    $empID = $_GET['empID'];

    // Retrieve employee data from the database
    $query = "SELECT * FROM employee WHERE empId='$empID'";
    $result = mysqli_query($conn, $query);

    // Check if employee exists
    if(mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
    } else {
        // Redirect to manageEmployee.php if employee not found
        header("Location: manageEmployee.php");
        exit;
    }
} else {
    // Redirect to manageEmployee.php if empID is not provided
    header("Location: manageEmployee.php");
    exit;
}

// Check if the form is submitted for updating employee data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated form data
    $employeeID = $_POST['employeeID'];
    $employeeName = $_POST['employeeName'];
    $age = $_POST['age'];
    $level = $_POST['level'];
    $password = $_POST['password'];

    // Validate form data (check if all fields are filled)
    if (!empty($employeeID) && !empty($employeeName) && !empty($age) && !empty($level) && !empty($password)) {
        // Update data in the employee table
        $update_query = "UPDATE employee SET empName='$employeeName', empAge='$age', empLevel='$level', empPassword='$password' WHERE empId='$employeeID'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Data updated successfully
            echo "<script>alert('Employee updated successfully');</script>";
            // Redirect back to manageEmployee.php
            echo "<script>window.location.href = 'manageEmployee.php';</script>";
            exit;
        } else {
            // Error occurred while updating data
            echo "<script>alert('Error updating employee');</script>";
        }
    } else {
        // All fields are not filled, display error message
        echo "<script>alert('Please fill all fields');</script>";
    }
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
        <!-- Update Employee form -->
        <form method="POST">
            <table>
                <tr>
                    <td>Employee ID</td>
                    <td><input type="text" id="employeeID" name="employeeID" class="inputText" value="<?php echo $employee['empId']; ?>" readonly></td>
                </tr>
                <tr>
                    <td>Employee Name</td>
                    <td><input type="text" id="employeeName" name="employeeName" class="inputText" value="<?php echo $employee['empName']; ?>" required></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><input type="text" id="age" name="age" class="inputText" value="<?php echo $employee['empAge']; ?>" required></td>
                </tr>
                <tr>
                    <td>Level</td>
                    <td>
                        <select id="level" name="level" class="inputText" required>
                            <option value="">Select Level</option>
                            <option value="Level1" <?php if($employee['empLevel'] == 'Level1') echo 'selected'; ?>>Level 1</option>
                            <option value="Level2" <?php if($employee['empLevel'] == 'Level2') echo 'selected'; ?>>Level 2</option>
                            <option value="Level3" <?php if($employee['empLevel'] == 'Level3') echo 'selected'; ?>>Level 3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="text" id="password" name="password" class="inputText" value="<?php echo $employee['empPassword']; ?>" required></td>
                </tr>
                <tr>
                    <td><button type="button" class="btn" onclick="window.location.href='manageEmployee.php';">Cancel</button></td>
                    <td><input type="submit" value="Update Employee" class="btn"></td>
                </tr>
            </table>
        </form>
    </div>

</body>
</html>
