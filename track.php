<?php
require 'config.php';

$conn = getDbConnection();

$email = isset($_GET['email']) ? $_GET['email'] : '';
$event_type = isset($_GET['event']) ? $_GET['event'] : '';
$url = isset($_GET['url']) ? $_GET['url'] : '';
$subject = isset($_GET['subject']) ? urldecode($_GET['subject']) : '';
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if ($email && $event_type) {
    $stmt = $conn->prepare("INSERT INTO tracking_events (email, event_type, url, subject, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $event_type, $url, $subject, $ip_address, $user_agent);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

if ($event_type == 'open') {
    header('Content-Type: image/gif');
    echo base64_decode('R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
    exit();
} elseif ($event_type == 'click' && $url) {
    header("Location: $url");
    exit();
}
?>
