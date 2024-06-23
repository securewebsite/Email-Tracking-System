<?php
require 'config.php';

$conn = getDbConnection();

$sql = "CREATE TABLE IF NOT EXISTS tracking_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    event_type ENUM('open', 'click', 'bounce') NOT NULL,
    url TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table tracking_events created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
