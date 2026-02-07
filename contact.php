<?php
session_start();
// You can add PHP mail logic here later if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Beautify Luxury Home Services</title>
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
            --soft-bg: #fdfcfb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
        }

        .contact-header {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            color: white;
            text-align: center;
        }

        .contact-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
        }

        .info-card {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            transition: 0.3s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(212, 163, 115, 0.15);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: rgba(212, 163, 115, 0.1);
            color: var(--primary-gold);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .contact-form-container {
            background: white;
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.05);
        }

        .form-control {
            padding: 12px 20px;
            border-radius: 10px;
            border: 1px solid #eee;
            background-color: #f9f9f9;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-gold);
            background-color: white;
        }

        .btn-send {
            background: var(--dark-charcoal);
            color: white;
            border-radius: 50px;
            padding: 15px 40px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
            width: 100%;
        }

        .btn-send:hover {
            background: var(--primary-gold);
            color: white;
            transform: translateY(-3px);
        }

        .map-container {
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            height: 450px;
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <header class="contact-header">
        <div class="container">
            <h1>Get in Touch</h1>
            <p class="lead opacity-75">We are here to assist your beauty journey.</p>
        </div>
    </header>

    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="info-card text-center">
                    <div class="icon-box mx-auto"><i class="fas fa-phone-alt"></i></div>
                    <h5 class="fw-bold">Call Us</h5>
                    <p class="text-muted">Monday - Sunday, 9am - 9pm</p>
                    <a href="tel:+923001234567" class="text-decoration-none fw-bold text-dark">+92 300 1234567</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card text-center">
                    <div class="icon-box mx-auto"><i class="fas fa-envelope"></i></div>
                    <h5 class="fw-bold">Email Us</h5>
                    <p class="text-muted">For bookings and inquiries</p>
                    <a href="mailto:support@beautify.com" class="text-decoration-none fw-bold text-dark">support@beautify.com</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card text-center">
                    <div class="icon-box mx-auto"><i class="fas fa-map-marker-alt"></i></div>
                    <h5 class="fw-bold">Our Location</h5>
                    <p class="text-muted">Gulberg III, Lahore</p>
                    <span class="fw-bold text-dark">Punjab, Pakistan</span>
                </div>
            </div>
        </div>

        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="contact-form-container">
                    <h2 class="mb-4 fw-bold" style="font-family: 'Playfair Display';">Send a Message</h2>
                    <form action="#" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address</label>
                                <input type="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Subject</label>
                                <input type="text" class="form-control" placeholder="Inquiry about Bridal Package" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Message</label>
                                <textarea class="form-control" rows="5" placeholder="How can we help you?" required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn-send shadow">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54435.53123565406!2d74.3168856!3d31.5203696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3919045a15c8a43d%3A0x4647307221381368!2sGulberg%2C%20Lahore%2C%20Punjab!5e0!3m2!1sen!2spk!4v1700000000000!5m2!1sen!2spk" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-5 text-center mt-5 bg-white border-top">
        <div class="container">
            <div class="mb-3">
                <a href="#" class="text-dark me-3"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-dark me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-dark"><i class="fab fa-whatsapp"></i></a>
            </div>
            <p class="mb-0 text-muted">&copy; <?php echo date("Y"); ?> BEAUTIFY. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>