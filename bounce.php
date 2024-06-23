<?php
require 'config.php';

$conn = getDbConnection();

$input = file_get_contents('php://input');
$events = json_decode($input, true);

foreach ($events as $event) {
    if (isset($event['event']) && $event['event'] == 'bounce') {
        $email = $event['email'];
        $stmt = $conn->prepare("INSERT INTO tracking_events (email, event_type) VALUES (?, 'bounce')");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
?>
