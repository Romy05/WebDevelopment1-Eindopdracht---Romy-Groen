<?php
include __DIR__ . '/../header.php';
?>

<h1 class="mb-4">Service Management</h1>

<!-- Filter Input -->
<div class="mb-3">
    <input type="text" id="filterInput" class="form-control" placeholder="Search services by name, description, duration, or price">
</div>

<!-- Service Table -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h5 mb-0">Services List</h2>
        <a href="/service/create" class="btn btn-primary btn-sm">Add Service</a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Duration (minutes)</th>
                    <th>Price (€)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="serviceTableBody">
                <!-- Loop through the services and display them -->
                <?php foreach ($model as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service->name); ?></td>
                        <td><?php echo !empty($service->description) ? htmlspecialchars($service->description): ""; ?></td>
                        <td><?php echo $service->duration_minutes; ?></td>
                        <td>€<?php echo number_format($service->price, 2); ?></td>
                        <td>
                            <?php echo "<a href='/service/edit?id=$service->id'" ?> class="btn btn-warning btn-sm">Edit</a>
                            <?php echo "<a href='/service/delete?id=$service->id'" ?> onclick="return confirm('Are you sure you want to delete this service?');" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Filter Table Rows
    document.getElementById('filterInput').addEventListener('input', function () {
        const filterValue = this.value.toLowerCase(); // Get input value in lowercase
        const rows = document.querySelectorAll('#serviceTableBody tr'); // Get all table rows

        rows.forEach(row => {
            const cells = row.querySelectorAll('td'); // Get all cells in the row
            const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' '); // Combine text of all cells
            if (rowText.includes(filterValue)) {
                row.style.display = ''; // Show row
            } else {
                row.style.display = 'none'; // Hide row
            }
        });
    });
</script>

<?php
include __DIR__ . '/../footer.php';
?>
