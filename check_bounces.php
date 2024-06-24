<?php
require 'vendor/autoload.php';
require 'config.php';

use PhpImap\Exceptions\ConnectionException;
use PhpImap\Mailbox;

$mailbox = new Mailbox(
    "{" . $_ENV['IMAP_HOST'] . ":" . $_ENV['IMAP_PORT'] . "/imap/ssl}INBOX",
    $_ENV['IMAP_USER'],
    $_ENV['IMAP_PASS'],
    __DIR__
);

try {
    $mailsIds = $mailbox->searchMailbox('UNSEEN');
    if (!$mailsIds) {
        die('Mailbox is empty');
    }

    foreach ($mailsIds as $mailId) {
        $mail = $mailbox->getMail($mailId);

        if (stripos($mail->subject, 'Undelivered Mail Returned to Sender') !== false ||
            stripos($mail->subject, 'Delivery Status Notification (Failure)') !== false) {
            
            // Extract email address from the bounce message
            preg_match('/<(.+?)>/', $mail->textPlain, $matches);
            $bouncedEmail = isset($matches[1]) ? $matches[1] : null;

            if ($bouncedEmail) {
                $conn = getDbConnection();
                $stmt = $conn->prepare("INSERT INTO tracking_events (email, event_type) VALUES (?, 'bounce')");
                $stmt->bind_param("s", $bouncedEmail);
                $stmt->execute();
                $stmt->close();
                $conn->close();
            }
        }
    }
} catch (ConnectionException $ex) {
    echo "IMAP connection failed: " . $ex->getMessage();
}
