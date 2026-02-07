<?php
session_start();
include "config.php";
if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM service_subcategories WHERE id = $id");
    header("Location: view_subcategories.php?msg=deleted");
}

// Fetch subcategories with their parent category name
$query = "SELECT sub.*, cat.name as category_name 
          FROM service_subcategories sub 
          INNER JOIN service_categories cat ON sub.category_id = cat.id 
          ORDER BY cat.name ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Sub-Categories | Beautify Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">

</head>
<body class="bg-light">
    <?php include('navbar.php'); ?>
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Service Sub-Categories</h2>
            <a href="admin_add_subcategory.php" class="btn btn-warning fw-bold px-4 rounded-pill">
                <i class="fas fa-plus me-2"></i>New Sub-Category
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">Parent Category</th>
                            <th>Sub-Category Name</th>
                            <th>Description</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="ps-4"><span class="badge bg-secondary"><?= htmlspecialchars($row['category_name']) ?></span></td>
                            <td class="fw-bold"><?= htmlspecialchars($row['name']) ?></td>
                            <td class="text-muted small"><?= htmlspecialchars($row['description']) ?></td>
                            <td class="text-center">
                                <a href="edit_subcategory.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                                <a href="view_subcategories.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this sub-category?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>