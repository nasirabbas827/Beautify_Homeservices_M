<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

// Fetch parent data for dropdowns
$categories = mysqli_query($conn, "SELECT id, name FROM service_categories ORDER BY name ASC");
$subcategories = mysqli_query($conn, "SELECT id, name FROM service_subcategories ORDER BY name ASC");

// Fetch existing service data
$res = mysqli_query($conn, "SELECT * FROM services WHERE id = $id");
$service = mysqli_fetch_assoc($res);

if (!$service) { header("Location: view_services.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat_id = $_POST['category_id'];
    $sub_id = $_POST['subcategory_id'];
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $gender = $_POST['gender'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Image Update Logic
    $image_sql = "";
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . "_" . $_FILES['image']['name'];
        $target = "uploads/" . $image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_sql = ", image = '$image_name'";
        }
    }

    $sql = "UPDATE services SET 
            category_id = '$cat_id', 
            subcategory_id = '$sub_id', 
            service_name = '$name', 
            gender = '$gender', 
            price = '$price', 
            duration_minutes = '$duration', 
            description = '$desc' 
            $image_sql 
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_services.php?msg=updated");
        exit();
    } else {
        $message = "<div class='alert alert-danger small'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service | Beautify Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <?php include('navbar.php'); ?>
    
     <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">
                            <i class="fas fa-magic me-2 text-warning"></i>Edit Service
                        </h3>
                        
                        <?php echo $message; ?>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Category</label>
                                    <select name="category_id" class="form-select" required>
                                        <?php while($c = mysqli_fetch_assoc($categories)): ?>
                                            <option value="<?= $c['id'] ?>" <?= ($c['id'] == $service['category_id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['name']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Sub-Category</label>
                                    <select name="subcategory_id" class="form-select" required>
                                        <?php while($s = mysqli_fetch_assoc($subcategories)): ?>
                                            <option value="<?= $s['id'] ?>" <?= ($s['id'] == $service['subcategory_id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($s['name']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label fw-semibold text-muted small uppercase">Service Name</label>
                                    <input type="text" name="service_name" class="form-control" value="<?= htmlspecialchars($service['service_name']) ?>" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted small uppercase">Target Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="women" <?= ($service['gender'] == 'women') ? 'selected' : '' ?>>Women</option>
                                        <option value="men" <?= ($service['gender'] == 'men') ? 'selected' : '' ?>>Men</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Price (PKR)</label>
                                    <input type="number" name="price" class="form-control" value="<?= $service['price'] ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Duration (Mins)</label>
                                    <input type="number" name="duration" class="form-control" value="<?= $service['duration_minutes'] ?>">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted small uppercase">Service Image</label>
                                    <div class="d-flex align-items-center gap-3 mb-2 p-2 border rounded bg-white">
                                        <img src="uploads/<?= $service['image'] ?>" alt="Preview" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                        <small class="text-muted fst-italic">Current image. Upload a new one to replace it.</small>
                                    </div>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted small uppercase">Description</label>
                                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($service['description']) ?></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 py-3 mt-4 fw-bold">Update Service Details</button>
                            <a href="view_services.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">Cancel and Go Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>