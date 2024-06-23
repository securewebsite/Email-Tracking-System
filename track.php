<?php
require 'config.php';

$conn = getDbConnection();

$email = isset($_GET['email']) ? $_GET['email'] : '';
$event_type = isset($_GET['event']) ? $_GET['event'] : '';
$url = isset($_GET['url']) ? $_GET['url'] : '';

if ($email && $event_type) {
    $stmt = $conn->prepare("INSERT INTO tracking_events (email, event_type, url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $event_type, $url);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

if ($event_type == 'open') {
    header('Content-Type: image/gif');
    echo base64_decode('R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
} elseif ($event_type == 'click' && $url) {
    header("Location: $url");
    exit();
}
?>
