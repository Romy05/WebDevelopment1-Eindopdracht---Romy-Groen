
<?php
include __DIR__ . '/../header.php';
?>

<h1 class="mb-4">User Management</h1>

<!-- Filter Input -->
<div class="mb-3">
    <input type="text" id="filterInput" class="form-control" placeholder="Search users by name, email, type, phone, or city">
</div>

<!-- User Table -->
<div class="card mb-4">
<div class="card-header d-flex justify-content-between align-items-center">
    <h2 class="h5 mb-0">Users List</h2>
    <a href="/user/create" class="btn btn-primary btn-sm">Add User</a>
</div>
<div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <!-- Loop through the users and display them -->
                <?php foreach ($model as $user): ?>
                    <tr>
                        <td><?php echo $user->id; ?></td>
                        <td><?php echo $user->first_name; ?></td>
                        <td><?php echo $user->last_name; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td><?php echo $user->type_of_user->value; ?></td>
                        <td><?php echo $user->phone_number; ?></td>
                        <td><?php echo $user->city; ?></td>
                        <td>
                        <?php echo "<a href='/user/edit?id=$user->id'"?> class="btn btn-warning btn-sm">Edit</a>
                        <?php echo "<a href='/user/delete?id=$user->id'"?>onclick="return confirm('Are you sure you want to delete this user?');" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Filter Table Rows
    document.getElementById('filterInput').addEventListener('input', function() {
        const filterValue = this.value.toLowerCase(); // Get input value in lowercase
        const rows = document.querySelectorAll('#userTableBody tr'); // Get all table rows

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
