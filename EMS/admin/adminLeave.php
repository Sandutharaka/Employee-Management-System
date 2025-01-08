<?php
include_once("../script/header.php");
include_once("../conf/conf.php");

// Process approve/reject leave requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['approveLeave'])) {
        $leaveId = $_POST['leaveId'];
        // Update leave status to "approved" in the database
        $updateQuery = "UPDATE leaveapply SET leaveStatus = 'approved' WHERE leaveId = $leaveId";
        mysqli_query($conn, $updateQuery);
        // Redirect to refresh the page
        header("Location: adminLeave.php");
        exit;
    } elseif (isset($_POST['rejectLeave'])) {
        $leaveId = $_POST['leaveId'];
        // Update leave status to "rejected" in the database
        $updateQuery = "UPDATE leaveapply SET leaveStatus = 'rejected' WHERE leaveId = $leaveId";
        mysqli_query($conn, $updateQuery);
        // Redirect to refresh the page
        header("Location: adminLeave.php");
        exit;
    }
}

// Fetch leave applications from the database
$query = "SELECT * FROM leaveapply";
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

<div class="container2">
    <!-- Leave Applications table -->
    <table class="tbl">
        <tr class="tblHead">
            <th>Employee ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th> <!-- New column for action buttons -->
        </tr>
        <?php
        // Display leave applications as table rows
        while ($row = mysqli_fetch_assoc($result)) {
            $statusClass = '';
            $actionButtons = '';
            // Check if leave has expired
            $currentDate = date('Y-m-d');
            if ($row['endDate'] < $currentDate) {
                $statusClass = 'tblExpired';
                $row['leaveStatus'] = 'Expired';
                $actionButtons = '<font color=red>Expired</font>';
            } else {
                switch ($row['leaveStatus']) {
                    case 'pending':
                        $statusClass = 'tblPending';
                        $actionButtons = "<button type='submit' name='approveLeave'>Approve</button>
                                          <button type='submit' name='rejectLeave'>Reject</button>";
                        break;
                    case 'approved':
                        $statusClass = 'tblApproved';
                        $actionButtons = "<button type='submit' name='rejectLeave'>Reject</button>";
                        break;
                    case 'rejected':
                        $statusClass = 'tblRejected';
                        $actionButtons = "<button type='submit' name='approveLeave'>Approve</button>";
                        break;
                    default:
                        $statusClass = '';
                        $actionButtons = '';
                }
            }
            echo "<tr class='$statusClass'>";
            echo "<td>{$row['empId']}</td>";
            echo "<td>{$row['startDate']}</td>";
            echo "<td>{$row['endDate']}</td>";
            echo "<td>{$row['leaveDescription']}</td>";
            echo "<td>{$row['leaveStatus']}</td>";
            echo "<td>";
            // Display action buttons or "Expired"
            echo "<form method='post'>";
            echo "<input type='hidden' name='leaveId' value='{$row['leaveId']}'>";
            echo $actionButtons;
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
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
