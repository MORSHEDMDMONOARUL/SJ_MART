<?php
include '../config/db.php';
include '../templates/header.php';

$edit_product = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Add new product
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];
        $query = "INSERT INTO products (name, category_id, price, stock, description) 
                  VALUES ('$name', $category_id, $price, $stock, '$description')";
        $conn->query($query);
    }

    if (isset($_POST['edit_product'])) {
        // Update existing product
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];
        $query = "UPDATE products SET name='$name', category_id=$category_id, price=$price, stock=$stock, 
                  description='$description' WHERE id=$id";
        $conn->query($query);
    }

    if (isset($_POST['delete_product'])) {
        // Delete product
        $id = $_POST['id'];
        $query = "DELETE FROM products WHERE id = $id";
        $conn->query($query);
    }
}

// Fetch products
$products = $conn->query("SELECT products.*, categories.name AS category_name FROM products 
                          LEFT JOIN categories ON products.category_id = categories.id");

// Fetch categories for dropdown
$categories = $conn->query("SELECT * FROM categories");

// Handle edit request
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_product = $conn->query("SELECT * FROM products WHERE id = $edit_id")->fetch_assoc();
}
?>

<div class="container">
    <h2>Manage Products</h2>
    <div class="form-section">
        <form method="POST" class="form-card">
            <input type="hidden" name="id" value="<?= $edit_product['id'] ?? '' ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $edit_product['name'] ?? '' ?>" required>

            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($edit_product) && $edit_product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?= $edit_product['price'] ?? '' ?>" required>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="<?= $edit_product['stock'] ?? '' ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?= $edit_product['description'] ?? '' ?></textarea>

            <button type="submit" name="<?= isset($edit_product) ? 'edit_product' : 'add_product' ?>">
                <?= isset($edit_product) ? 'Update Product' : 'Add Product' ?>
            </button>
        </form>
    </div>
    <div class="table-section">
        <h3>Product List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['category_name'] ?></td>
                        <td><?= $row['price'] ?></td>
                        <td><?= $row['stock'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td>
                            <a href="products.php?edit_id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_product" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../templates/footer.php'; ?>
