<?php
require_once '../includes/db_connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Initialize error array
    $errors = [];

    // Sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    if (empty($name) || strlen($name) < 3 || strlen($name) > 50) {
        $errors['name'] = "Name must be between 3 and 50 characters.";
    }

    // Validate Email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please provide a valid email address.";
    } else {
        // Check if email is already registered
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['email'] = "This email is already registered.";
        }
        $stmt->close();
    }

    // Validate Password
    if (empty($password) || strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    // Validate Confirm Password
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    if (empty($errors)) {

    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $password])) {
        header('Location: login.php?success=1');
    } else {
        echo "Error: Unable to register.";
    }}
}
?>
