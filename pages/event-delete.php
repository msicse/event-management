<?php
session_start();
require_once '../includes/db_connection.php';
require 'session-check.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate event ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid event ID!");
}

$event_id = $_GET['id'];

try {
    // Check if the event exists before deleting
    $stmt = $pdo->prepare("SELECT id FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        die("Event not found!");
    }

    // Delete event
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    if ($stmt->execute([$event_id])) {
        $_SESSION['success'] = "Event deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete event.";
    }
    
    header("Location: events.php");
    exit();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
