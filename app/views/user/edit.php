
<?php
include __DIR__ . '/../header.php';
$user = $model;
?>
<div class="container d-flex justify-content-center align-items-start vh-100" style="margin-top: 5%;">
    <div class="card p-4" style="width: 80%;">
        <h2 class="mb-4 text-center">Edit User</h2>

        <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

        <form method="POST" id="userForm">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user->id) ?>">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First name</label>
                        <input value="<?= isset($formData['first_name']) ? htmlspecialchars($formData['first_name']) : (!is_null($user->first_name) ? htmlspecialchars($user->first_name) : "") ?>" type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                    </div>
                    
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last name</label>
                        <input value="<?= isset($formData['last_name']) ? htmlspecialchars($formData['last_name']) :(!is_null($user->last_name) ? htmlspecialchars($user->last_name): "" )?>"type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input value="<?= isset($formData['phone_number']) ? htmlspecialchars($formData['phone_number']) : (!is_null($user->phone_number) ? htmlspecialchars($user->phone_number): "" )?>"type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number">
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address*</label>
                        <input value="<?= isset($formData['address']) ? htmlspecialchars($formData['address']) :htmlspecialchars($user->address) ?>"type="text" class="form-control" id="address" name="address" placeholder="Address (Example: Mainstreet 44)" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="city" class="form-label">City*</label>
                        <input value="<?= isset($formData['city']) ? htmlspecialchars($formData['city']) :htmlspecialchars($user->city) ?>"type="text" class="form-control" id="city" name="city" placeholder="City" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="zip" class="form-label">ZIP Code*</label>
                        <input value="<?= isset($formData['zip']) ? htmlspecialchars($formData['zip']) :htmlspecialchars($user->zip) ?>"type="text" class="form-control" id="zip" name="zip" placeholder="ZIP Code (Example: 1234AB)" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input value="<?= isset($formData['email']) ? htmlspecialchars($formData['email']) : htmlspecialchars($user->email) ?>" type="email" class="form-control" id="email" name="email" placeholder="Email (Example: Email@adress.com)" required>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="edit_password_checkbox" name="edit_password">
                        <label class="form-check-label" for="edit_password">
                            Edit Password?
                        </label>
                    </div>
                    
                    <div id="passwordFields" style="display: none;">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password*</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password*</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" >
                        </div>
                    </div>
                    <p>*These fields are mandatory.</p>
                    <button type="submit" class="btn btn-primary">Edit User</button>
                </div>
            </div>

        </form>

    <script>
        const editPasswordCheckbox = document.getElementById('edit_password_checkbox');
        const passwordFields = document.getElementById('passwordFields');
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('confirm_password');

       
        editPasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.style.display = 'block';
                passwordField.required = true;
                confirmPasswordField.required = true;
            } else {
                passwordFields.style.display = 'none';
                passwordField.required = false;
                confirmPasswordField.required = false;
            }
        });

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

