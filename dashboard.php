<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
include 'config/db.php';
include 'templates/header.php';

// getting data from the database
$total_categories = $conn->query("SELECT COUNT(*) AS count FROM categories")->fetch_assoc()['count'];
$total_products = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc()['count'];
$total_customers = $conn->query("SELECT COUNT(*) AS count FROM customers")->fetch_assoc()['count'];
$total_orders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
?>
    <h2>Welcome to SJ MART Dashboard</h2>
    <p>Here you can manage categories, products, users, customers, and orders efficiently.</p>
    
    <!-- overview section to check all at once -->
    <div class="overview">
        <div class="card">
            <h2><?= $total_categories ?></h2>
            <p>Total Categories</p>
        </div>
        <div class="card">
            <h2><?= $total_products ?></h2>
            <p>Total Products</p>
        </div>
        <div class="card">
            <h2><?= $total_customers ?></h2>
            <p>Total Customers</p>
        </div>
        <div class="card">
            <h2><?= $total_orders ?></h2>
            <p>Total Orders</p>
        </div>
    </div>
<?php include 'templates/footer.php'; ?>
