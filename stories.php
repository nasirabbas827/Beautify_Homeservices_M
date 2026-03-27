<?php
session_start();
require_once('config.php');

// Fetch all stories from your table, newest first
$query = "SELECT * FROM stories ORDER BY created_at DESC";
$result = $conn->query($query);

// Separate the first story to be the "Featured" one
$featured = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Stories | Beautify Luxury Home Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        :root { --primary-gold: #d4a373; --dark-charcoal: #2d2d2d; --bg-silk: #fdfcfb; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-silk); color: var(--dark-charcoal); }
        .stories-header { 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1560750588-73207b1ef5b8?auto=format&fit=crop&w=1350&q=80');
            background-size: cover; background-position: center; padding: 120px 0; color: white; text-align: center; margin-bottom: 80px; 
        }
        .stories-header h1 { font-family: 'Playfair Display', serif; font-size: 3.5rem; }
        .featured-card { background: white; border-radius: 25px; overflow: hidden; border: none; box-shadow: 0 30px 60px rgba(0,0,0,0.08); margin-top: -150px; position: relative; z-index: 5; }
        .featured-img { width: 100%; height: 100%; object-fit: cover; min-height: 450px; }
        .story-card { background: white; border: none; border-radius: 20px; padding: 30px; height: 100%; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.03); }
        .story-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(212, 163, 115, 0.2); }
        .quote-mark { font-size: 2.5rem; color: var(--primary-gold); opacity: 0.2; line-height: 1; }
        .cta-section { background-color: var(--dark-charcoal); color: white; padding: 80px 0; margin-top: 80px; }
        .btn-gold { background-color: var(--primary-gold); color: white; padding: 15px 40px; border-radius: 50px; font-weight: 600; text-transform: uppercase; transition: 0.3s; text-decoration: none; display: inline-block; }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <header class="stories-header">
        <div class="container">
            <h1 class="display-4 fw-bold">Stories of Radiance</h1>
            <p class="lead opacity-75">Real transformations, delivered at your doorstep.</p>
        </div>
    </header>

    <div class="container">
        <?php if ($featured): ?>
        <div class="card featured-card mb-5">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="admin/<?php echo htmlspecialchars($featured['image_url']); ?>" class="featured-img" alt="Featured Story">
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="card-body p-5">
                        <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill">Latest Transformation</span>
                        <h2 class="display-6 fw-bold mb-4" style="font-family: 'Playfair Display';"><?php echo htmlspecialchars($featured['title']); ?></h2>
                        <p class="text-muted fs-5 lh-lg mb-4">
                            "<?php echo nl2br(htmlspecialchars($featured['content'])); ?>"
                        </p>
                        <small class="text-muted">Published on: <?php echo date('M d, Y', strtotime($featured['created_at'])); ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row g-4 mt-4">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card story-card">
                    <i class="fas fa-quote-left quote-mark"></i>
                    <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="text-muted mb-4">"<?php echo htmlspecialchars(substr($row['content'], 0, 150)) . '...'; ?>"</p>
                    
                    <?php if($row['image_url']): ?>
                        <img src="admin/<?php echo htmlspecialchars($row['image_url']); ?>" class="img-fluid rounded mb-3" style="height: 150px; width: 100%; object-fit: cover;">
                    <?php endif; ?>

                    <div class="mt-auto">
                        <small class="text-muted d-block">Verified Client Story</small>
                        <small class="text-muted"><?php echo date('M Y', strtotime($row['created_at'])); ?></small>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            
            <?php if ($result->num_rows == 0 && !$featured): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No stories found. Be the first to share your experience!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <section class="cta-section text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4" style="font-family: 'Playfair Display';">Ready for your own glow-up?</h2>
            <a href="search_services.php" class="btn btn-gold shadow-lg">Book a Service Now</a>
        </div>
    </section>

    <footer class="py-4 text-center border-top bg-white">
        <div class="container">
            <p class="mb-0 text-muted">&copy; <?php echo date("Y"); ?> BEAUTIFY. All stories are verified.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>