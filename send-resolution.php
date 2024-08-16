<?php
require __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

function sendResolutionNotification($userEmail, $complaintNo, $resolution) {
    // Fetch the user's subscription from the database
    $subscription = getUserSubscription($userEmail);
    
    if (!$subscription) {
        return false; // User hasn't subscribed to notifications
    }

    $auth = [
        'VAPID' => [
            'subject' => 'mailto:your@email.com',
            'publicKey' => 'YOUR_PUBLIC_VAPID_KEY',
            'privateKey' => 'YOUR_PRIVATE_VAPID_KEY',
        ],
    ];

    $webPush = new WebPush($auth);

    $payload = [
        'title' => 'Complaint Resolution',
        'body' => "Your complaint #$complaintNo has been resolved.",
        'icon' => '/path/to/icon.png',
        'url' => "/complaint_history.php",
    ];

    $report = $webPush->sendOneNotification(
        Subscription::create(json_decode($subscription, true)),
        json_encode($payload)
    );

    return $report->isSuccess();
}

function getUserSubscription($userEmail) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'project');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT subscription FROM push_subscriptions WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $subscription = $row['subscription'];
    } else {
        $subscription = null;
    }

    $stmt->close();
    $conn->close();

    return $subscription;
}

// This function should be called when an admin submits a resolution
function notifyUserOfResolution($userEmail, $complaintNo, $resolution) {
    $success = sendResolutionNotification($userEmail, $complaintNo, $resolution);
    if ($success) {
        echo "Notification sent successfully";
    } else {
        echo "Failed to send notification";
    }
}