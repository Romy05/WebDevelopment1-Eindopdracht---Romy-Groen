<?php
include __DIR__ . '/../header.php';?>

<div class="container d-flex justify-content-center align-items-start vh-100" style="margin-top: 15%;">
    <div class="card p-4" style="width: 35%;">
        <h3 class="text-center">Login</h3>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?> 
        <div id="error-message" style="display: none;" class="alert alert-danger" role="alert">
        </div>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Enter you email address" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <a href="/register" style="margin-top: 5%;" class="btn btn-link w-100">Make an account</a>
        </form>
    </div>
</div>
<script>
    function showError() {
        const errorMessageDiv = document.getElementById('error-message');
        errorMessageDiv.style.display = 'block';
        errorMessageDiv.textContent = 'error';
    }
</script>

<?php include __DIR__ . '/../footer.php';
?>