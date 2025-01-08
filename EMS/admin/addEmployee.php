<?php
include_once("../conf/conf.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeID = $_POST['employeeID'];
    $employeeName = $_POST['employeeName'];
    $age = $_POST['age'];
    $level = $_POST['level'];
    $password = $_POST['password'];

    if (!empty($employeeID) && !empty($employeeName) && !empty($age) && !empty($level) && !empty($password)) {

        $query = "INSERT INTO employee (empId, empName, empAge, empLevel, empPassword) VALUES ('$employeeID', '$employeeName', '$age', '$level', '$password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>window.location.href = 'manageEmployee.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error adding employee');</script>";
        }
    } else {
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
        <form method="POST">
            <table>
                <tr>
                    <td>Employee ID</td>
                    <td><input type="text" id="employeeID" name="employeeID" class="inputText" placeholder="Employee ID" required></td>
                </tr>
                <tr>
                    <td>Employee Name</td>
                    <td><input type="text" id="employeeName" name="employeeName" class="inputText" placeholder="Employee Name" required></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><input type="text" id="age" name="age" class="inputText" placeholder="Age" required></td>
                </tr>
                <tr>
                    <td>Level</td>
                    <td>
                        <select id="level" name="level" class="inputText" required>
                            <option value="">Select Level</option>
                            <option value="Level1">Level 1</option>
                            <option value="Level2">Level 2</option>
                            <option value="Level3">Level 3</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="text" id="password" name="password" class="inputText" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td><button type="button" class="btn" onclick="window.location.href='manageEmployee.php';">Cancel</button></td>
                    <td><input type="submit" value="Add Employee" class="btn"></td>
                </tr>
            </table>
        </form>
    </div>

</body>
</html>
