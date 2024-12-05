<?php
include '../config/db.php';
include '../templates/header.php';

$edit_customer = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_customer'])) {
        // Add new customer
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $query = "INSERT INTO customers (name, email, phone, address) 
                  VALUES ('$name', '$email', '$phone', '$address')";
        $conn->query($query);
    }

    if (isset($_POST['edit_customer'])) {
        // Update existing customer
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $query = "UPDATE customers SET name='$name', email='$email', phone='$phone', address='$address' 
                  WHERE id=$id";
        $conn->query($query);
    }

    if (isset($_POST['delete_customer'])) {
        // Delete customer
        $id = $_POST['id'];
        $query = "DELETE FROM customers WHERE id = $id";
        $conn->query($query);
    }
}

// Fetch customers
$customers = $conn->query("SELECT * FROM customers");

// Handle edit request
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_customer = $conn->query("SELECT * FROM customers WHERE id = $edit_id")->fetch_assoc();
}
?>

<div class="container">
    <h2>Manage Customers</h2>
    <div class="form-section">
        <form method="POST" class="form-card">
            <input type="hidden" name="id" value="<?= $edit_customer['id'] ?? '' ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $edit_customer['name'] ?? '' ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= $edit_customer['email'] ?? '' ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?= $edit_customer['phone'] ?? '' ?>" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?= $edit_customer['address'] ?? '' ?></textarea>

            <button type="submit" name="<?= isset($edit_customer) ? 'edit_customer' : 'add_customer' ?>">
                <?= isset($edit_customer) ? 'Update Customer' : 'Add Customer' ?>
            </button>
        </form>
    </div>
    <div class="table-section">
        <h3>Customer List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $customers->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['address'] ?></td>
                        <td>
                            <a href="customers.php?edit_id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_customer" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../templates/footer.php'; ?>
