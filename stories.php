<?php
session_start();
// No DB connection needed for a static page
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
        }

        /* Hero Header */
        .stories-header {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1560750588-73207b1ef5b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            padding: 120px 0;
            color: white;
            text-align: center;
            margin-bottom: 80px;
        }

        .stories-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            margin-bottom: 15px;
        }

        /* Featured Story Card */
        .featured-card {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            border: none;
            box-shadow: 0 30px 60px rgba(0,0,0,0.08);
            margin-top: -150px;
            position: relative;
            z-index: 5;
        }

        .featured-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 450px;
        }

        /* Review Cards */
        .story-card {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .story-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(212, 163, 115, 0.2);
        }

        .quote-mark {
            font-size: 2.5rem;
            color: var(--primary-gold);
            opacity: 0.2;
            line-height: 1;
        }

        .star-rating {
            color: #ffc107;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        .client-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid var(--primary-gold);
        }

        .cta-section {
            background-color: var(--dark-charcoal);
            color: white;
            padding: 80px 0;
            margin-top: 80px;
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
        }

        .btn-gold:hover {
            background-color: #bc8a5f;
            color: white;
            transform: scale(1.05);
        }
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
        <div class="card featured-card mb-5">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1351&q=80" class="featured-img" alt="Featured transformation">
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="card-body p-5">
                        <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill">Featured Transformation</span>
                        <h2 class="display-6 fw-bold mb-4" style="font-family: 'Playfair Display';">The Bridal Glow Experience</h2>
                        <p class="text-muted fs-5 lh-lg mb-4">
                            "I was skeptical about home services for my wedding events, but Beautify exceeded every expectation. The team was punctual, used high-end products, and understood exactly the look I wanted. It felt like having a premium salon inside my own bedroom."
                        </p>
                        <div class="client-info d-flex align-items-center">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Zoya K.">
                            <div>
                                <h6 class="mb-0 fw-bold">Zoya Khan</h6>
                                <small class="text-muted">Bridal Package · Lahore</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card story-card">
                    <div class="star-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <i class="fas fa-quote-left quote-mark"></i>
                    <p class="text-muted italic mb-4">"The Men's Grooming package is a lifesaver for busy professionals. A barber who actually listens and takes his time, all while I'm in my home office."</p>
                    <div class="client-info d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Ahmed">
                        <div>
                            <h6 class="mb-0 fw-bold">Ahmed Ali</h6>
                            <small class="text-muted">Executive Haircut</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card story-card">
                    <div class="star-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <i class="fas fa-quote-left quote-mark"></i>
                    <p class="text-muted italic mb-4">"Best facial I've ever had! The therapist brought her own specialized equipment and even played soothing music. Totally transformed my mood."</p>
                    <div class="client-info d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sana">
                        <div>
                            <h6 class="mb-0 fw-bold">Sana Mansoor</h6>
                            <small class="text-muted">Hydra-Facial Luxe</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card story-card">
                    <div class="star-rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <i class="fas fa-quote-left quote-mark"></i>
                    <p class="text-muted italic mb-4">"The convenience is 10/10. No traffic, no waiting in salons. The nail artist was a perfectionist. My manicures lasted for weeks!"</p>
                    <div class="client-info d-flex align-items-center">
                        <img src="https://randomuser.me/api/portraits/women/12.jpg" alt="Maria">
                        <div>
                            <h6 class="mb-0 fw-bold">Maria J.</h6>
                            <small class="text-muted">Spa Mani-Pedi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="cta-section text-center">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4" style="font-family: 'Playfair Display';">Ready for your own glow-up?</h2>
            <p class="lead mb-5 opacity-75">Join thousands of happy clients who trust Beautify for their grooming needs.</p>
            <a href="search_services.php" class="btn btn-gold shadow-lg">Book a Service Now</a>
        </div>
    </section>

    <footer class="py-4 text-center border-top bg-white">
        <div class="container">
            <p class="mb-0 text-muted">&copy; <?php echo date("Y"); ?> BEAUTIFY. All stories are verified by our team.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>