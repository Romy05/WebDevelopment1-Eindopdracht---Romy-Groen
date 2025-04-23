
<?php
include __DIR__ . '/../header.php';
?>
<div class="container d-flex justify-content-center align-items-start vh-100" style="margin-top: 5%;">
    <div class="card p-4" style="width: 80%;">
        <h2 class="mb-4 text-center">Create a Service</h2>
        <form id="serviceForm" method="POST">
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Service Name*</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter service name" required>
                <div class="invalid-feedback">Please enter a service name.</div>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="4" class="form-control" placeholder="Enter a description"></textarea>
            </div>

            <!-- Duration in Minutes -->
            <div class="mb-3">
                <label for="duration_minutes" class="form-label">Duration (in minutes)*</label>
                <input type="number" id="duration_minutes" name="duration_minutes" class="form-control" min="1" placeholder="Enter duration" required>
                <div class="invalid-feedback">Please enter a valid duration in minutes.</div>
            </div>

            <!-- Price in Euros -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (in €)*</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" placeholder="Enter price in euros" required>
                <div class="invalid-feedback">Please enter a valid price in euros.</div>
            </div>

            <button type="submit" class="btn btn-primary w-25">Create Service</button>
        </form>
    </div>
</div>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<?php
include __DIR__ . '/../footer.php';
?>

