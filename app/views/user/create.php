
<?php
include __DIR__ . '/../header.php';
?>

<div class="container d-flex justify-content-center align-items-start vh-100" style="margin-top: 5%;">
    <div class="card p-4" style="width: 80%;">
        <h2 class="mb-4 text-center">Add a new account
        </h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" id="userForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            placeholder="First Name"
                            value="<?php echo isset($formData['first_name']) ? htmlspecialchars($formData['first_name']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            placeholder="Last Name"
                            value="<?php echo isset($formData['last_name']) ? htmlspecialchars($formData['last_name']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number"
                            placeholder="Phone Number"
                            value="<?php echo isset($formData['phone_number']) ? htmlspecialchars($formData['phone_number']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address*</label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Address (Example: Mainstreet 44)"
                            value="<?php echo isset($formData['address']) ? htmlspecialchars($formData['address']) : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City*</label>
                        <input type="text" class="form-control" id="city" name="city"
                            placeholder="City"
                            value="<?php echo isset($formData['city']) ? htmlspecialchars($formData['city']) : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="zip" class="form-label">ZIP Code*</label>
                        <input type="text" class="form-control" id="zip" name="zip"
                            placeholder="ZIP Code (Example: 1234AB)"
                            value="<?php echo isset($formData['zip']) ? htmlspecialchars($formData['zip']) : ''; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
            
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Email (Example: Email@address.com)"
                            value="<?php echo isset($formData['email']) ? htmlspecialchars($formData['email']) : ''; ?>" required>
                    </div>

                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required
                        value="<?php echo isset($formData['password']) ? htmlspecialchars($formData['password']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password*</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required
                        value="<?php echo isset($formData['confirm_password']) ? htmlspecialchars($formData['confirm_password']) : ''; ?>">
                    </div>

                    
                    <div class="mb-3">
                        <label for="type_of_user" class="form-label">Type of user*</label>
                        <select class="form-select" id="type_of_user" name="type_of_user" required>
                            <option value="" disabled <?php echo !isset($formData['type_of_user']) ? 'selected' : ''; ?>>Select a type of user</option>
                            <option value="employee" <?php echo (isset($formData['type_of_user']) && $formData['type_of_user'] === 'employee') ? 'selected' : ''; ?>>Employee</option>
                            <option value="customer" <?php echo (isset($formData['type_of_user']) && $formData['type_of_user'] === 'customer') ? 'selected' : ''; ?>>Customer</option>
                        </select>
                    </div>
                    <p>*These fields are mandatory.</p>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <script>
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirm_password');
        
        function validatePasswords() {
            if (passwordField.value !== confirmPasswordField.value) {
                confirmPasswordField.setCustomValidity("Passwords do not match");
            } else {
                confirmPasswordField.setCustomValidity("");
            }
        }
       
        passwordField.addEventListener('input', validatePasswords);
        confirmPasswordField.addEventListener('input', validatePasswords); 

        const emailField = document.getElementById('email');
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('error') === 'email_exists') {
            emailField.setCustomValidity("This email is already registered.");
            emailField.reportValidity();
        }   

        emailField.addEventListener('input', function () {
            emailField.setCustomValidity("");
        });
    </script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<?php
include __DIR__ . '/../footer.php';
?>

