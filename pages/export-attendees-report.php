<?php
require_once '../includes/db_connection.php';
require 'session-check.php';

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// Check if the user is an admin
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    die("Access denied. Only admins can export attendee reports.");
}

// Get event_id from request
if (!isset($_GET['event_id']) || empty($_GET['event_id'])) {
    die("Invalid event ID.");
}

$event_id = intval($_GET['event_id']);

// Fetch event data
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// Define CSV file headers
$filename = htmlspecialchars($event['name']). "_attendees_" . date('Y-m-d') . ".csv";
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$filename\"");



// Open output stream
$output = fopen('php://output', 'w');

// Write column headers
fputcsv($output, ['ID', 'Name', 'Email', 'Registered At']);

// Fetch event data from database
$query = "SELECT * FROM attendees WHERE event_id= ? ORDER BY registered_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$event_id]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Write data rows to CSV
foreach ($events as $event) {
    fputcsv($output, [
        $event['id'], 
        $event['name'], 
        $event['email'], 
        $event['registered_at'], 
    ]);
}

// Close output stream
fclose($output);
exit();
