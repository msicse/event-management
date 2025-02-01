<?php
session_start();
require_once '../includes/db_connection.php';
require_once '../includes/helpers.php';
require 'session-check.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$event_id = sanitize_input($_POST['event_id']);
$name = sanitize_input($_POST['name']);
$email = sanitize_input($_POST['email']);

// Validate email
if (empty($email)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
} else {
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM attendees WHERE email = :email AND event_id = :event_id");
    $stmt->execute(['email' => $email, 'event_id' => $event_id]);
    if ($stmt->fetch()) {
        $errors[] = "Email already registered.";
    }
}

if (empty($errors)) {
    // Check if the event exists and get capacity
    $stmt = $pdo->prepare("SELECT capacity FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);


    // Count the number of registered attendees
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_attendees FROM attendees WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $attendee_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_attendees'];

    // Prevent registration if the event is full
    if ($attendee_count >= $event['capacity']) {
        $_SESSION['error'] = "Registration is closed. Event is full!";
        header("Location: event_view.php?id=" . $event_id);
        exit();
    }

    // Insert attendee into database
    $stmt = $pdo->prepare("INSERT INTO attendees (event_id, name, email) VALUES (?, ?, ?)");
    if ($stmt->execute([$event_id, $name, $email])) {
        $_SESSION['success'] = "Successfully registered!";
    } else {
        $_SESSION['error'] = "Registration failed. Try again.";
    }

    header("Location: event-view.php?id=" . $event_id);
    exit();

}
$_SESSION['errors'] = $errors;
header("Location: event-view.php?id=" . $event_id);


?>
