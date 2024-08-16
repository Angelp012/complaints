<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['endpoint']) || !isset($input['keys']['p256dh']) || !isset($input['keys']['auth'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid subscription data']);
    exit;
}

$userEmail = $_SESSION['email'];
$subscription = json_encode($input);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'project');
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Check if a subscription already exists for this user
$stmt = $conn->prepare("SELECT id FROM push_subscriptions WHERE email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing subscription
    $stmt = $conn->prepare("UPDATE push_subscriptions SET subscription = ? WHERE email = ?");
    $stmt->bind_param("ss", $subscription, $userEmail);
} else {
    // Insert new subscription
    $stmt = $conn->prepare("INSERT INTO push_subscriptions (email, subscription) VALUES (?, ?)");
    $stmt->bind_param("ss", $userEmail, $subscription);
}

if ($stmt->execute()) {
    echo json_encode(['data' => ['success' => true]]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save subscription']);
}

$stmt->close();
$conn->close();