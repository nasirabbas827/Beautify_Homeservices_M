<?php
session_start();
include "config.php";

// Get search and gender filters
$search = $_GET['search'] ?? '';
$gender_filter = $_GET['gender'] ?? '';

// Build Query based on your schema
$query = "SELECT s.*, c.name as cat_name 
          FROM services s 
          JOIN service_categories c ON s.category_id = c.id 
          WHERE s.is_active = 1";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " AND (s.service_name LIKE '%$search%' OR s.description LIKE '%$search%')";
}

if (!empty($gender_filter)) {
    $gender_filter = mysqli_real_escape_string($conn, $gender_filter);
    $query .= " AND s.gender = '$gender_filter'";
}

$query .= " ORDER BY s.created_at DESC";
$services = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beautify | Luxury Home Beauty Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        :root {
            --primary-gold: #d4a373;
            --dark-charcoal: #2d2d2d;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fdfcfb;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('./images/img.jpg');
            background-size: cover;
            background-position: center;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            border-bottom: 8px solid var(--primary-gold);
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .cta-button {
            padding: 15px 40px;
            background: var(--primary-gold);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            text-transform: uppercase;
            border: none;
        }

        .cta-button:hover {
            background: #bc8a5f;
            transform: scale(1.05);
            color: white;
        }

        /* Search & Filter Bar */
        .search-container {
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }

        .search-bar {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        /* Service Cards */
        .service-card {
            border: none;
            border-radius: 20px;
            transition: 0.4s;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(212, 163, 115, 0.15);
        }

        .service-card img {
            height: 230px;
            object-fit: cover;
        }

        .gender-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.9);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--dark-charcoal);
        }

        .price-tag {
            color: var(--primary-gold);
            font-weight: 700;
            font-size: 1.25rem;
        }

        footer {
            background: var(--dark-charcoal);
            color: #aaa;
            padding: 60px 0 30px;
        }
    </style>
</head>
<body>
    
    <?php include('navbar.php'); ?>

    <div class="hero">
        <div class="container">
            <h1 class="display-3">Luxury Beauty at Your Doorstep</h1>
            <p class="lead mb-4 fw-light">Experience professional grooming and salon services in the comfort of your home.</p>
            <a href="#services" class="cta-button shadow-lg">View All Services</a>
        </div>
    </div>

    <div class="container search-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form class="search-bar" method="GET" action="index.php#services">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control border-0 bg-light" placeholder="What service are you looking for?" value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="gender" class="form-select border-0 bg-light">
                                <option value="">All Genders</option>
                                <option value="women" <?php echo $gender_filter == 'women' ? 'selected' : ''; ?>>Women</option>
                                <option value="men" <?php echo $gender_filter == 'men' ? 'selected' : ''; ?>>Men</option>
                            </select>
                        </div>
                        <div class="col-md-4 d-grid">
                            <button type="submit" class="btn btn-dark rounded-pill fw-bold">Find Services</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="py-5" id="services">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold" style="font-family: 'Playfair Display';">Signature Treatments</h2>
                <p class="text-muted">Handpicked premium services for your needs</p>
                <div class="mx-auto" style="height: 3px; width: 50px; background: var(--primary-gold);"></div>
            </div>

            <div class="row g-4">
                <?php if ($services && mysqli_num_rows($services) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($services)): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card service-card h-100 position-relative">
                                <div class="gender-badge shadow-sm border">
                                    <i class="fas <?php echo $row['gender'] == 'women' ? 'fa-venus text-danger' : 'fa-mars text-primary'; ?> me-1"></i>
                                    <?php echo $row['gender']; ?>
                                </div>
                                
                                <?php 
                                    $img_path = !empty($row['image']) ? "admin/uploads/".$row['image'] : "images/placeholder.jpg";
                                ?>
                                <img src="<?php echo $img_path; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['service_name']); ?>">
                                
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-uppercase tracking-wider text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">
                                            <?php echo htmlspecialchars($row['cat_name']); ?>
                                        </small>
                                        <small class="text-muted"><i class="far fa-clock me-1"></i><?php echo $row['duration_minutes']; ?> min</small>
                                    </div>
                                    
                                    <h4 class="card-title fw-bold h5"><?php echo htmlspecialchars($row['service_name']); ?></h4>
                                    <p class="text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?php echo htmlspecialchars($row['description']); ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                        <div>
                                            <span class="text-muted small d-block">Price starting at</span>
                                            <span class="price-tag">Rs. <?php echo number_format($row['price']); ?></span>
                                        </div>
                            <a href="book_now.php?service_id=<?php echo $row['id']; ?>" class="btn btn-dark btn-sm px-3 rounded-pill">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-spa fa-3x text-light"></i>
                        </div>
                        <h4 class="text-muted">No services found</h4>
                        <p class="text-muted small">Try adjusting your filters or search terms.</p>
                        <a href="index.php" class="btn btn-outline-gold rounded-pill mt-3">Reset Filters</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
                    <h5 class="text-white fw-bold">BEAUTIFY</h5>
                    <p class="small mb-0">Premium home salon experience.</p>
                </div>
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="text-white opacity-50 hover-opacity-100"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white opacity-50"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4 text-center text-md-end">
                    <p class="small mb-0">&copy; <?php echo date("Y"); ?> BEAUTIFY. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>