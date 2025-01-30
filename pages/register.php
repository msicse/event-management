<?php include('../templates/header.php'); ?>
<div class="d-flex justify-content-center md:align-items-center min-vh-100">
    <div class="row w-100">
        <div class="col-lg-6 col-md-8 col-sm-10 mx-auto">
            <div class="card shadow p-4">
                <h3 class="text-center">Register</h3>
                <form method="POST" action="register_process.php" id="registerForm">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required minlength="3" maxlength="20">
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" minlength="6" required>
                    </div>
                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                    </div>
                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
                <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>

    <?php include('../templates/footer.php'); ?>