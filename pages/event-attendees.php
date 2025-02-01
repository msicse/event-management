<?php
include('../templates/header.php');
require_once '../includes/db_connection.php';
require_once '../includes/helpers.php';

require 'session-check.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Fetch event details if 'id' is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid event ID!");
}

$event_id = $_GET['id'];
// Get All attendees
$stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ?");
$stmt->execute([$event_id]);
$attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="d-flex justify-content-center md:align-items-center min-vh-100">
    <div class="row w-100">
        <div class="col mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Events</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="attendeeTable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendees as $key => $attendee): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($key + 1); ?></td>
                                    <td><?php echo htmlspecialchars($attendee['name']); ?></td>
                                    <td><?php echo htmlspecialchars($attendee['email']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>


                </div>
            </div>


        </div>
    </div>

    <?php include('../templates/footer.php'); ?>