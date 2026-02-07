<?php
session_start();
include "config.php";
if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

$message = "";
$categories = mysqli_query($conn, "SELECT id, name FROM service_categories ORDER BY name ASC");
$subcategories = mysqli_query($conn, "SELECT id, name FROM service_subcategories ORDER BY name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat_id = $_POST['category_id'];
    $sub_id = $_POST['subcategory_id'];
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $gender = $_POST['gender'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Image Upload Logic
    $image_name = $_FILES['image']['name'];
    $target = "uploads/" . basename($image_name);

    $sql = "INSERT INTO services (category_id, subcategory_id, service_name, gender, price, duration_minutes, description, image) 
            VALUES ('$cat_id', '$sub_id', '$name', '$gender', '$price', '$duration', '$desc', '$image_name')";

    if (mysqli_query($conn, $sql)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $message = "<div class='alert alert-success small'>Service launched successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger small'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Service | Beautify Admin</title>
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
                        <h3 class="fw-bold mb-4"><i class="fas fa-scissors me-2 text-warning"></i>Add New Service</h3>
                        <?php echo $message; ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Category</label>
                                    <select name="category_id" class="form-select" required>
                                        <?php while($c = mysqli_fetch_assoc($categories)) echo "<option value='{$c['id']}'>{$c['name']}</option>"; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Sub-Category</label>
                                    <select name="subcategory_id" class="form-select" required>
                                        <?php while($s = mysqli_fetch_assoc($subcategories)) echo "<option value='{$s['id']}'>{$s['name']}</option>"; ?>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold text-muted small uppercase">Service Name</label>
                                    <input type="text" name="service_name" class="form-control" placeholder="e.g. Signature Charcoal Facial" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted small uppercase">Target Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="women">Women</option>
                                        <option value="men">Men</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Price (PKR)</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted small uppercase">Duration (Mins)</label>
                                    <input type="number" name="duration" class="form-control" placeholder="e.g. 60">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted small uppercase">Service Image</label>
                                    <input type="file" name="image" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted small uppercase">Description</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 py-3 mt-4 fw-bold">Publish Service</button>
                            <a href="view_services.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">Cancel and Go Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>