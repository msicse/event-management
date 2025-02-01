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

// Fetch existing event data
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// If event not found, show error
if (!$event) {
    die("Event not found!");
}

$name = $description = $event_date = $location = $capacity = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and trim spaces
    $name = sanitize_input($_POST['name']);
    $description = sanitize_input($_POST['description']);
    $event_date = sanitize_input($_POST['event_date']);
    $location = sanitize_input($_POST['location']);
    $capacity = sanitize_input($_POST['capacity']);

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Name must be at least 3 characters.";
    }

    // Validate description
    if (empty($description)) {
        $errors[] = "Description is required.";
    } elseif (strlen($name) < 10) {
        $errors[] = "Description must be at least 10 characters.";
    }
    // Validate event_date
    if (empty($event_date)) {
        $errors[] = "Event Date is required.";
    } elseif (!strtotime($event_date)) {
        $errors[] = "Invalid Date Formate.";
    }

    // Validate location
    if (empty($location)) {
        $errors[] = "Location is required.";
    } elseif (strlen($location) < 3) {
        $errors[] = "Location must be at least 3 characters.";
    }

    // Validate capacity
    if (empty($capacity)) {
        $errors[] = "Max Capacity is required.";
    } elseif (!is_numeric($capacity) || $capacity < 1) {
        $errors[] = "Maximum capacity must be a number greater than 0.";
    }


    // If no errors, insert into database
    if (empty($errors)) {
        $created_by = $_SESSION['user_id'];

        $stmt = $pdo->prepare("
            UPDATE events 
            SET name = :name, description = :description, event_date = :event_date, 
                location = :location, capacity = :capacity, created_by = :created_by 
            WHERE id = :event_id
        ");

        if ($stmt->execute([
            'name' => $name,
            'description' => $description,
            'event_date' => $event_date,
            'location' => $location,
            'capacity' => $capacity,
            'created_by' => $created_by,
            'event_id'  => $event_id
        ])) {
            $_SESSION['success'] = "Event updated successfully!";
            header("Location: events.php");
            exit();
        }
    }

    $_SESSION['errors'] = $errors;
}
?>

<div class="d-flex justify-content-center md:align-items-center min-vh-100">
    <div class="row w-100">
        <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
            <div class="card shadow p-4">
                <h3 class="text-center">Create Event</h3>
                <form method="POST" action="" id="createForm">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="name" value="<?= htmlspecialchars($event['name']) ?>" name="name" placeholder="Enter your full name" required minlength="3" maxlength="20">

                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" required><?= htmlspecialchars($event['description']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="event_date" class="form-control" value="<?= htmlspecialchars($event['event_date']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($event['location']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Maximum Capacity</label>
                        <input type="number" name="capacity" class="form-control" value="<?= htmlspecialchars($event['capacity']) ?>" required min="1">
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <a href="events.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Event</button>

                    </div>
                </form>

            </div>
        </div>
    </div>



    <?php include('../templates/js.php'); ?>
    <script src="/assets/js/jquery.validate.js"></script>
    <script>
        $("#createForm").validate();
    </script>
    <?php include('../templates/footer.php'); ?>