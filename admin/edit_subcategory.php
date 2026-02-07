<?php
session_start();
include "config.php";
if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

$id = intval($_GET['id']);
$categories = mysqli_query($conn, "SELECT id, name FROM service_categories ORDER BY name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = intval($_POST['category_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    mysqli_query($conn, "UPDATE service_subcategories SET category_id='$category_id', name='$name', description='$description' WHERE id=$id");
    header("Location: view_subcategories.php?msg=updated");
}

$sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM service_subcategories WHERE id=$id"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Sub-Category | Beautify Admin</title>
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
                        <h3 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-warning"></i>Edit Sub-Category</h3>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small uppercase">Parent Category</label>
                                <select name="category_id" class="form-select" required>
                                    <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $sub['category_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small uppercase">Sub-Category Name</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($sub['name']) ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-muted small uppercase">Description</label>
                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($sub['description']) ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">Update Sub-Category</button>
                            <a href="view_subcategories.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none small">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>