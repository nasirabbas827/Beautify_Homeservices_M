<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

$message = "";
// Fetch parent categories for the dropdown
$categories = mysqli_query($conn, "SELECT id, name FROM service_categories ORDER BY name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = intval($_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO service_subcategories (category_id, name, description) VALUES ('$category_id', '$name', '$description')";
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert alert-success'>Sub-category added! <a href='view_subcategories.php'>View List</a></div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Sub-Category | Beautify Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">

</head>
<body class="bg-light">
    <?php include('navbar.php'); ?>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4"><i class="fas fa-layer-group me-2 text-warning"></i>Add Sub-Category</h3>
                        <?php echo $message; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small uppercase">Parent Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select a Category</option>
                                    <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small uppercase">Sub-Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Party Makeup" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted small uppercase">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">Save Sub-Category</button>
                            <a href="view_subcategories.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none small">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>