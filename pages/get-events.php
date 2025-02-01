<?php
require_once '../includes/db_connection.php';
require_once '../includes/helpers.php';
session_start();
require 'session-check.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get filter parameters from AJAX request
$name = isset($_GET['name']) ? $_GET['name'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';


// Base query
$query = "SELECT * FROM events WHERE 1=1";

// Apply filters
if (!empty($name)) {
    $query .= " AND name LIKE :name";
}
if (!empty($location)) {
    $query .= " AND location = :location";
}
if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND event_date BETWEEN :start_date AND :end_date";
}

// Prepare statement
$stmt = $pdo->prepare($query);

// Bind parameters
if (!empty($name)) {
    $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
}
if (!empty($location)) {
    $stmt->bindValue(':location', $location, PDO::PARAM_STR);
}
if (!empty($start_date) && !empty($end_date)) {
    $stmt->bindValue(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
}

// Execute and fetch results
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);


// JSON response
header('Content-Type: application/json');
echo json_encode(['data' => $events]);
exit();
