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

// Fetch all events
$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date ASC");
$events = $stmt->fetchAll();

?>

<div class="d-flex justify-content-center md:align-items-center min-vh-100">
    <div class="row w-100">
        <div class="col mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4>Events</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="eventsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($event['name']); ?></td>
                                    <td><?php echo $event['event_date']; ?></td>
                                    <td><?php echo $event['location']; ?></td>
                                    <td><?php echo $event['capacity']; ?></td>
                                    <td>
                                        <a href="event-view.php?id=<?php echo $event['id']; ?>" class="btn btn-primary btn-sm mb-2">View Event</a>
                                        <a href="event-attendees.php?id=<?php echo $event['id']; ?>" class="btn btn-info btn-sm mb-2">View Attendees</a>
                                        <a href="event-edit.php?id=<?php echo $event['id']; ?>" class="btn btn-warning btn-sm mb-2">Edit</a>
                                        <a href="event-delete.php?id=<?php echo $event['id']; ?>" class="btn btn-danger btn-sm mb-2 delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>



    <?php include('../templates/footer.php'); ?>