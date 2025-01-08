<?php
include_once("../script/header.php");
include_once("../conf/conf.php");
session_start();

// Check if the form is submitted
if (isset($_GET['applyLeave'])) {
    // Retrieve data from the form
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    $leaveDescription = $_GET['description'];
    $empID = $_SESSION['user'];
    
    // Insert the leave application data into the database
    $query = "INSERT INTO leaveapply (empId, startDate, endDate, leaveDescription, leaveStatus) VALUES ('$empID', '$startDate', '$endDate', '$leaveDescription', 'pending')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Leave application saved successfully
        echo "<script>alert('Leave application submitted successfully');</script>";
    } else {
        // Failed to save leave application
        echo "<script>alert('Failed to submit leave application');</script>";
    }
}

// Fetch leave applications for the specific employee
$empID = $_SESSION['user'];
$query = "SELECT * FROM leaveapply WHERE empId = '$empID'";
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
    <style>
        .tblPending {
            background-color: #FFEFD5; /* Light orange */
        }
        .tblApproved {
            background-color: #90EE90; /* Light green */
        }
        .tblRejected {
            background-color: #FFC0CB; /* Light pink */
        }
        .tblExpired {
            background-color: #D3D3D3; /* Light gray */
        }
    </style>
</head>
<body class="contbody">

    <form method="GET">
        Select Start Date : 
        <input type="date" id="startDate" name="startDate" class="inputTextFilter" required>
        <br>
        Select End Date : 
        <input type="date" id="endDate" name="endDate" class="inputTextFilter" required>
        <br>
        <textarea name="description" id="leaveDescription" cols="300" rows="200" class="inputTextArea" placeholder="Description"></textarea>
        <br>
        <input type="submit" name="applyLeave" value="Apply Leave" class="btn">
    </form>

    <br>
    <div class="container2">
    <!-- Leave Applications table -->
    <table class="tbl">
        <tr class="tblHead">
            <th>Start Date</th>
            <th>End Date</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        <?php
        // Display leave applications for the specific employee
        while ($row = mysqli_fetch_assoc($result)) {
            $statusClass = '';
            // Check if the leave has expired
            $currentDate = date('Y-m-d');
            if ($row['endDate'] < $currentDate) {
                $statusClass = 'tblExpired';
                $row['leaveStatus'] = 'Expired';
            } else {
                switch ($row['leaveStatus']) {
                    case 'pending':
                        $statusClass = 'tblPending';
                        break;
                    case 'approved':
                        $statusClass = 'tblApproved';
                        break;
                    case 'rejected':
                        $statusClass = 'tblRejected';
                        break;
                    default:
                        $statusClass = '';
                }
            }
            echo "<tr class='$statusClass'>";
            echo "<td>{$row['startDate']}</td>";
            echo "<td>{$row['endDate']}</td>";
            echo "<td>{$row['leaveDescription']}</td>";
            echo "<td>{$row['leaveStatus']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>

    <br><br><br><br><br><br>

    <!-- Footer section -->
    <footer class="footer">
        <div class="container2">
            <a href="userDashboard.php"><button class="btn">Back to Dashboard</button></a>
        </div>
    </footer>

</body>
</html>
