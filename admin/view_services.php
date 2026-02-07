<?php
session_start();
include "config.php";
if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM services WHERE id = $id");
    header("Location: view_services.php?msg=deleted");
}

$query = "SELECT s.*, c.name as cat_name, sc.name as sub_name 
          FROM services s
          JOIN service_categories c ON s.category_id = c.id
          JOIN service_subcategories sc ON s.subcategory_id = sc.id
          ORDER BY s.id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services | Beautify Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <?php include('navbar.php'); ?>
     <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">All Beauty Services</h2>
            <a href="admin_add_service.php" class="btn btn-warning fw-bold px-4 rounded-pill">Add New</a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Service</th>
                        <th>Category</th>
                        <th>Gender</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="uploads/<?= $row['image'] ?>" class="rounded-3 me-3" style="width:50px; height:50px; object-fit:cover;">
                                <div>
                                    <div class="fw-bold"><?= $row['service_name'] ?></div>
                                    <div class="text-muted small"><?= $row['sub_name'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border"><?= $row['cat_name'] ?></span></td>
                        <td class="text-capitalize"><?= $row['gender'] ?></td>
                        <td class="fw-bold text-success"><?= number_format($row['price']) ?> PKR</td>
                        <td><?= $row['duration_minutes'] ?> mins</td>
                        <td class="text-center">
                            <a href="edit_service.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                            <a href="view_services.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete service?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>