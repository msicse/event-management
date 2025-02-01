<?php
include('../templates/header.php');
require_once '../includes/db_connection.php';
require_once '../includes/helpers.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'session-check.php';

// Fetch event details if 'id' is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid event ID!");
}

$event_id = $_GET['id'];

// Fetch existing event data
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// Count the number of attendees
$stmt = $pdo->prepare("SELECT COUNT(*) AS total_attendees FROM attendees WHERE event_id = ?");
$stmt->execute([$event_id]);
$attendee_count = $stmt->fetch(PDO::FETCH_ASSOC)['total_attendees'];

// Get All attendees
$stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ?");
$stmt->execute([$event_id]);
$attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if registration is still open
$is_full = ($attendee_count >= $event['capacity']);

// If event not found, show error
if (!$event) {
    die("Event not found!");
}

?>


<div class="d-flex justify-content-center md:align-items-center min-vh-100">
    <div class="w-100">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>Event Details: <?php htmlspecialchars($event['name']); ?> </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td><?= htmlspecialchars($event['name']) ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?= nl2br(htmlspecialchars($event['description'])) ?></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><?= htmlspecialchars($event['event_date']) ?></td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td><?= htmlspecialchars($event['location']) ?></td>
                        </tr>
                        <tr>
                            <th>Capacity</th>
                            <td><?= htmlspecialchars($event['capacity']) ?></td>
                        </tr>
                    </table>

                    <!-- Display Registration Form if Event is not full -->
                    <?php if (!$is_full): ?>
                        <div class="col-lg-6 col-md-8 col-sm-10 mx-auto my-4 ">
                            <h3>Register for this Event</h3>
                            <form action="event-register.php" method="POST">
                                <input type="hidden" name="event_id" value="<?= $event_id ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Your Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success">Register</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger mt-3">Registration is closed. This event has reached its maximum capacity.</div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="card">
                <div class="card-header">
                    <h4>Attendee List</h4>
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

                <div class="text-end">
                    <a href="events.php" class="btn btn-secondary">Back to Events</a>
                </div>
                </div>
            </div>

        </div>

    </div>
</div>



<?php include('../templates/js.php'); ?>
<?php include('../templates/footer.php'); ?>