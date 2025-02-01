<?php
include('../templates/header.php');
require_once '../includes/db_connection.php';
require_once '../includes/helpers.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT DISTINCT location FROM events ORDER BY location ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$locations = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>

<div class="d-flex justify-content-center md:align-items-center min-vh-100">
    <div class="row w-100">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Events Dashboard</h4>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" id="searchName" class="form-control" placeholder="Search Event Name">
                        </div>
                        <div class="col-md-3">
                            <select id="searchLocation" class="form-control">
                                <option value="">Select Location</option>
                                <?php foreach($locations as $location): ?>
                                    <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input type="date" id="endDate" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button id="resetFilters" class="btn btn-danger w-100">Reset Filters</button>
                        </div>
                    </div>
                    <!-- Events Table -->
                    <table class="table table-bordered table-striped" id="eventDashboardTable">
                        <thead class="">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Event Date</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../templates/footer.php'); ?>