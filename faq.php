<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frequently Asked Questions | Beautify</title>
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
            color: var(--dark-charcoal);
        }

        .faq-header {
            background: linear-gradient(rgba(45, 45, 45, 0.9), rgba(45, 45, 45, 0.9)), url('https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .faq-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
        }

        .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 15px !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .accordion-button {
            font-weight: 600;
            padding: 20px;
            background-color: white;
            color: var(--dark-charcoal);
        }

        .accordion-button:not(.collapsed) {
            background-color: white;
            color: var(--primary-gold);
            box-shadow: none;
        }

        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23d4a373'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
        }

        .category-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary-gold);
            margin-bottom: 25px;
            margin-top: 40px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .category-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(212, 163, 115, 0.3);
        }

        .help-card {
            background: var(--dark-charcoal);
            color: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            margin-top: 60px;
        }

        .btn-gold {
            background: var(--primary-gold);
            color: white;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-gold:hover {
            background: #bc8a5f;
            color: white;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

    <?php include('navbar.php'); ?>

    <header class="faq-header">
        <div class="container">
            <h1>Common Inquiries</h1>
            <p class="lead opacity-75">Everything you need to know about our luxury home services.</p>
        </div>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <h3 class="category-title"><i class="fas fa-calendar-check"></i> Booking & Scheduling</h3>
                <div class="accordion" id="bookingFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                                How do I book a home service?
                            </button>
                        </h2>
                        <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#bookingFaq">
                            <div class="accordion-body text-muted">
                                Simply browse our <strong>Services</strong> page, select the treatment you want, and click "Book". You'll be asked to pick a date and time that suits you. Our system will then confirm the appointment.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                                Can I cancel or reschedule my appointment?
                            </button>
                        </h2>
                        <div id="q2" class="accordion-collapse collapse" data-bs-parent="#bookingFaq">
                            <div class="accordion-body text-muted">
                                Yes! You can manage your bookings through your <strong>Dashboard</strong>. We kindly ask for at least 24 hours' notice for cancellations to respect our professionals' time.
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="category-title"><i class="fas fa-shield-alt"></i> Safety & Hygiene</h3>
                <div class="accordion" id="safetyFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3">
                                What hygiene protocols do you follow?
                            </button>
                        </h2>
                        <div id="q3" class="accordion-collapse collapse" data-bs-parent="#safetyFaq">
                            <div class="accordion-body text-muted">
                                Your safety is our priority. Our professionals use sanitized tools, wear masks/gloves when necessary, and carry disposable kits for services like wax and facials to ensure 100% hygiene.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4">
                                Are your professionals background-checked?
                            </button>
                        </h2>
                        <div id="q4" class="accordion-collapse collapse" data-bs-parent="#safetyFaq">
                            <div class="accordion-body text-muted">
                                Absolutely. Every beautician and stylist undergoes a rigorous background check and a skill verification process before joining the Beautify team.
                            </div>
                        </div>
                    </div>
                </div>

                <h3 class="category-title"><i class="fas fa-wallet"></i> Payments & Pricing</h3>
                <div class="accordion" id="paymentFaq">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5">
                                What are the available payment methods?
                            </button>
                        </h2>
                        <div id="q5" class="accordion-collapse collapse" data-bs-parent="#paymentFaq">
                            <div class="accordion-body text-muted">
                                We currently support Cash on Service (CoS). Once your service is completed to your satisfaction, you can pay our professional directly. Online payment options are coming soon!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="help-card shadow-lg">
                    <h2 class="mb-3" style="font-family: 'Playfair Display';">Still have questions?</h2>
                    <p class="mb-4 opacity-75">Our support team is available from 9 AM to 9 PM to help you with anything you need.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="contact.php" class="btn-gold">Contact Us</a>
                        <a href="https://wa.me/yournumber" class="btn btn-outline-light rounded-pill px-4 py-2"><i class="fab fa-whatsapp me-2"></i> WhatsApp Support</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <footer class="py-4 text-center mt-5 bg-white border-top">
        <div class="container">
            <p class="mb-0 text-muted">&copy; <?php echo date("Y"); ?> BEAUTIFY - Home Beauty Solutions</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>