<?php
require 'config.php';
require 'auth.php';

if (!isAuthenticated()) {
    header('Location: login.php');
    exit();
}

$conn = getDbConnection();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT email, event_type, url, subject, ip_address, user_agent, timestamp FROM tracking_events";
if ($search) {
    $sql .= " WHERE email LIKE ?";
}
$sql .= " ORDER BY timestamp DESC";

$stmt = $conn->prepare($sql);
if ($search) {
    $search = "%$search%";
    $stmt->bind_param("s", $search);
}
$stmt->execute();
$result = $stmt->get_result();

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Tracking Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Email Tracking Dashboard</h1>
        <form method="GET" action="dashboard.php" class="form-inline mb-3">
            <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Event Type</th>
                    <th>Subject</th>
                    <th>URL</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)) : ?>
                    <?php foreach ($events as $event) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['email']); ?></td>
                            <td><?php echo htmlspecialchars($event['event_type']); ?></td>
                            <td><?php echo htmlspecialchars($event['subject']); ?></td>
                            <td><?php echo htmlspecialchars($event['url']); ?></td>
                            <td><?php echo htmlspecialchars($event['ip_address']); ?></td>
                            <td><?php echo htmlspecialchars($event['user_agent']); ?></td>
                            <td><?php echo htmlspecialchars($event['timestamp']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">No tracking data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
