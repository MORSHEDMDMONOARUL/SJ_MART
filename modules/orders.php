<?php
include '../config/db.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_order'])) {
        // adding order to database
        $customer_id = $_POST['customer_id'];
        $order_date = $_POST['order_date'];
        $status = $_POST['status'];
        $total_amount = $_POST['total_amount'];
        $query = "INSERT INTO orders (customer_id, order_date, status, total_amount) 
                  VALUES ($customer_id, '$order_date', '$status', $total_amount)";
        $conn->query($query);
    }

    if (isset($_POST['delete_order'])) {
        // deleting order from database
        $id = $_POST['id'];
        $query = "DELETE FROM orders WHERE id = $id";
        $conn->query($query);
    }

    if (isset($_POST['update_status'])) {
        // updating order status
        $id = $_POST['id'];
        $status = $_POST['status'];
        $query = "UPDATE orders SET status='$status' WHERE id=$id";
        $conn->query($query);
    }
}

// getting data from orders
$orders = $conn->query("SELECT orders.*, customers.name AS customer_name 
                        FROM orders 
                        LEFT JOIN customers ON orders.customer_id = customers.id");

// getting customers for dropdown
$customers = $conn->query("SELECT * FROM customers");
?>

<div class="container">
    <h2>Manage Orders</h2>
    <div class="form-section">
        <form method="POST" class="form-card">
            <label for="customer_id">Customer:</label>
            <select id="customer_id" name="customer_id" required>
                <?php while ($customer = $customers->fetch_assoc()): ?>
                    <option value="<?= $customer['id'] ?>"><?= $customer['name'] ?></option>
                <?php endwhile; ?>
            </select>

            <label for="order_date">Order Date:</label>
            <input type="date" id="order_date" name="order_date" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>

            <label for="total_amount">Total Amount:</label>
            <input type="number" id="total_amount" name="total_amount" step="0.01" required>

            <button type="submit" name="add_order">Add Order</button>
        </form>
    </div>
    <div class="table-section">
        <h3>Order List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['customer_name'] ?></td>
                        <td><?= $row['order_date'] ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <select name="status" class="status-dropdown" onchange="this.form.submit()">
                                    <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Completed" <?= $row['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="Cancelled" <?= $row['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                        <td><?= $row['total_amount'] ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_order" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../templates/footer.php'; ?>
