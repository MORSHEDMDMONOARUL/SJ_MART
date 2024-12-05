<?php
include '../config/db.php';
include '../templates/header.php';

$edit_category = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_category'])) {
        // Add new category
        $name = $_POST['name'];
        $description = $_POST['description'];
        $query = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";
        $conn->query($query);
    }

    if (isset($_POST['edit_category'])) {
        // Update existing category
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $query = "UPDATE categories SET name='$name', description='$description' WHERE id=$id";
        $conn->query($query);
    }

    if (isset($_POST['delete_category'])) {
        // Delete category
        $id = $_POST['id'];
        $query = "DELETE FROM categories WHERE id = $id";
        $conn->query($query);
    }
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");

// Handle edit request
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_category = $conn->query("SELECT * FROM categories WHERE id = $edit_id")->fetch_assoc();
}
?>

<div class="container">
    <h2>Manage Categories</h2>
    <div class="form-section">
        <form method="POST" class="form-card">
            <input type="hidden" name="id" value="<?= $edit_category['id'] ?? '' ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $edit_category['name'] ?? '' ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= $edit_category['description'] ?? '' ?></textarea>

            <button type="submit" name="<?= isset($edit_category) ? 'edit_category' : 'add_category' ?>">
                <?= isset($edit_category) ? 'Update Category' : 'Add Category' ?>
            </button>
        </form>
    </div>
    <div class="table-section">
        <h3>Category List</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $categories->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['description'] ?></td>
                        <td>
                            <a href="categories.php?edit_id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete_category" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../templates/footer.php'; ?>
