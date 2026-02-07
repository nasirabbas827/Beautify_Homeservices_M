<?php
include('config.php');
session_start();

$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$query = "SELECT s.*, c.name as category_name FROM services s 
          JOIN service_categories c ON s.category_id = c.id 
          WHERE s.is_active = 1";

if(!empty($search)) {
    $query .= " AND (s.service_name LIKE '%$search%' OR s.description LIKE '%$search%')";
}
$results = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find Services | Beautify</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">

</head>
<body class="bg-light">
    <?php include('navbar.php'); ?>
    <div class="container py-5">
        <div class="row justify-content-center mb-5">
            <div class="col-md-6 text-center">
                <h2 class="fw-bold">Discover Beauty Services</h2>
                <form action="" method="GET" class="mt-4">
                    <div class="input-group input-group-lg shadow-sm">
                        <input type="text" name="q" class="form-control border-0" placeholder="Search for makeup, hair, facial..." value="<?php echo $search; ?>">
                        <button class="btn btn-warning px-4" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <?php while($row = mysqli_fetch_assoc($results)): ?>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="admin/uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                    <div class="card-body">
                        <span class="badge bg-soft-gold text-dark mb-2"><?php echo $row['category_name']; ?></span>
                        <h5 class="fw-bold"><?php echo $row['service_name']; ?></h5>
                        <p class="text-muted small"><?php echo substr($row['description'], 0, 80); ?>...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark">PKR <?php echo number_format($row['price']); ?></span>
                            <a href="book_now.php?service_id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm px-3 rounded-pill">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>