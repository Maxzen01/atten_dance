<?php
session_start();

// Admin validation


// Database connection
$conn = new mysqli("localhost", "root", "", "attendanceapp");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch all leave requests
$sql = "SELECT * FROM leave_requests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Leave Requests</title>
	<link rel="icon" type="image/jpeg" href="logo.jpg">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; text-align: center; border: 1px solid #ddd; }
        th { background-color: #4c9ff5; color: white; }
        .pending { color: orange; }
        .approved { color: green; }
        .rejected { color: red; }
    </style>
</head>
<body>
    <h1>View Leave Requests</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Reason</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['leave_reason']; ?></td>
                    <td><?php echo $row['leave_start_date']; ?></td>
                    <td><?php echo $row['leave_end_date']; ?></td>
                    <td class="<?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </td>
                    <td>
                        <form method="POST" action="update_leave_request.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button name="status" value="Approved">Approve</button>
                            <button name="status" value="Rejected">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
<?php $conn->close(); ?>
