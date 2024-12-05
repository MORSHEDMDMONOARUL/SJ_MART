<?php
include '../config/db.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        // Add user logic
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $query = "INSERT INTO users (username, password, role) 
                  VALUES ('$username', '$password', '$role')";
        $conn->query($query);
    }

    if (isset($_POST['delete_user'])) {
        // Delete user logic
        $id = $_POST['id'];
        $query = "DELETE FROM users WHERE id = $id";
        $conn->query($query);
    }
}

// Fetch users
$users = $conn->query("SELECT * FROM users");
?>

<div class="container">
    <h2>Manage Users</h2>
    <div class="form-section">
        <form method="POST" class="form-card">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>

            <button type="submit" name="add_user">Add User</button>
        </form>
    </div>
    <div class="table-section">
        <h3>User List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['role'] ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_user" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../templates/footer.php'; ?>
