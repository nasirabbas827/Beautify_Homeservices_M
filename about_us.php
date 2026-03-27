<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Story | Beautify Luxury Home Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        :root {
            --primary-gold: #d4a373;
            --dark-charcoal: #2d2d2d;
            --bg-silk: #fdfcfb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-silk);
            color: var(--dark-charcoal);
            overflow-x: hidden;
        }

        /* Hero Section */
        .about-hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            padding: 150px 0;
            color: white;
            text-align: center;
        }

        .about-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            margin-bottom: 20px;
        }

        /* Mission Section */
        .mission-box {
            background: white;
            border-radius: 30px;
            padding: 60px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            margin-top: -100px;
            position: relative;
            z-index: 5;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            color: var(--dark-charcoal);
            position: relative;
            margin-bottom: 30px;
        }

        .section-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: var(--primary-gold);
            margin-top: 15px;
        }

        /* Value Cards */
        .value-card {
            border: none;
            background: transparent;
            text-align: center;
            padding: 30px;
            transition: 0.3s;
        }

        .value-icon {
            font-size: 2.5rem;
            color: var(--primary-gold);
            margin-bottom: 20px;
        }

        /* Stats Section */
        .stats-bar {
            background-color: var(--dark-charcoal);
            color: white;
            padding: 80px 0;
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: var(--primary-gold);
            display: block;
        }

        .btn-gold {
            background-color: var(--primary-gold);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-gold:hover {
            background-color: #bc8a5f;
            color: white;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <header class="about-hero">
        <div class="container">
            <h1>Redefining Elegance</h1>
            <p class="lead opacity-75 fs-4">Bringing the luxury salon experience to the sanctuary of your home.</p>
        </div>
    </header>

    <div class="container mb-5">
        <div class="mission-box">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Our Mission</h2>
                    <p class="text-muted fs-5 lh-lg">
                        Founded in 2024, <strong>Beautify</strong> was born out of a simple realization: luxury shouldn't require a commute. We believe that your time is your most precious asset. 
                    </p>
                    <p class="text-muted fs-5 lh-lg">
                        By connecting world-class beauty professionals with clients in their own homes, we’ve created a personalized, hygienic, and stress-free way to look and feel your absolute best.
                    </p>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://images.unsplash.com/photo-1560750588-73207b1ef5b8?auto=format&fit=crop&w=600&q=80" class="img-fluid rounded-4 shadow" alt="Luxury Service">
                </div>
            </div>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title d-inline-block">The Beautify Values</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card value-card">
                        <i class="fas fa-gem value-icon"></i>
                        <h4>Uncompromising Quality</h4>
                        <p class="text-muted">We use only premium, dermatologist-tested products and high-end equipment for every service.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card value-card">
                        <i class="fas fa-user-check value-icon"></i>
                        <h4>Expert Hands</h4>
                        <p class="text-muted">Our professionals undergo rigorous background checks and skill certifications to ensure excellence.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card value-card">
                        <i class="fas fa-hand-sparkles value-icon"></i>
                        <h4>Absolute Hygiene</h4>
                        <p class="text-muted">Single-use kits and medical-grade sanitization are at the core of our "Safe-Salon" promise.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-bar text-center">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <span class="stat-number">150+</span>
                    <span class="small text-uppercase opacity-75">Expert Stylists</span>
                </div>
                <div class="col-6 col-md-3">
                    <span class="stat-number">10k+</span>
                    <span class="small text-uppercase opacity-75">Happy Clients</span>
                </div>
                <div class="col-6 col-md-3">
                    <span class="stat-number">4.9/5</span>
                    <span class="small text-uppercase opacity-75">Average Rating</span>
                </div>
                <div class="col-6 col-md-3">
                    <span class="stat-number">24/7</span>
                    <span class="small text-uppercase opacity-75">Booking Support</span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 text-center">
        <div class="container py-5">
            <h2 class="section-title d-inline-block">Experience Luxury Today</h2>
            <p class="lead text-muted mb-5">Your personal sanctuary is just one click away.</p>
            <a href="search_services.php" class="btn btn-gold shadow-lg">View Our Menu</a>
        </div>
    </section>

    <footer class="py-4 text-center border-top bg-white">
        <div class="container">
            <p class="mb-0 text-muted">&copy; <?php echo date("Y"); ?> BEAUTIFY. Elevating home beauty standards.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>