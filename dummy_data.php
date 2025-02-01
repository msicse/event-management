<?php
include 'includes/db_connection.php';

try {

    // Insert Dummy Events
    $pdo->exec("INSERT INTO attendees (event_id, name, email) VALUES
        (  1,  'John Doe',  'john.doe@example.com' ),
        (  1,  'Jane Smith',  'jane.smith@example.com' ),
        (  1,  'Alice Johnson',  'alice.johnson@example.com' ),
        (  2,  'Bob Brown',  'bob.brown@example.com' ),
        (  2,  'Charlie Davis',  'charlie.davis@example.com' ),
        (  2,  'Emily White',  'emily.white@example.com' ),
        (  3,  'Michael Green',  'michael.green@example.com' ),
        (  3,  'Sophia Black',  'sophia.black@example.com' ),
        (  3,  'Daniel Gray',  'daniel.gray@example.com' ),
        (  1,  'Olivia Blue',  'olivia.blue@example.com' )");

    //Insert Dummy Attendees
    // $pdo->exec("INSERT INTO attendees (event_id, user_id, registered_at) VALUES
    //     (1, 2, NOW()),
    //     (1, 3, NOW()),
    //     (2, 3, NOW())");

    echo "Dummy data inserted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
