<?php
session_start();
require_once('config.php');

// Fetch all FAQs from the database
$query = "SELECT * FROM faqs ORDER BY created_at DESC";
$result = $conn->query($query);
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

        .search-box {
            border-radius: 50px;
            padding: 15px 25px;
            border: 1px solid rgba(212, 163, 115, 0.3);
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
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
            <p class="lead opacity-75">Find quick answers to your questions about our services.</p>
        </div>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="position-relative">
                    <input type="text" id="faqSearch" class="form-control search-box" placeholder="Search for a question (e.g. 'booking', 'price')...">
                </div>

                <div class="accordion" id="dynamicFaq">
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $count = 0; while($row = $result->fetch_assoc()): $count++; ?>
                            <div class="accordion-item faq-row">
                                <h2 class="accordion-header">
                                    <button class="accordion-button <?php echo ($count > 1) ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo $row['faq_id']; ?>">
                                        <?php echo htmlspecialchars($row['question']); ?>
                                    </button>
                                </h2>
                                <div id="faq-<?php echo $row['faq_id']; ?>" class="accordion-collapse collapse <?php echo ($count == 1) ? 'show' : ''; ?>" data-bs-parent="#dynamicFaq">
                                    <div class="accordion-body text-muted">
                                        <?php echo nl2br(htmlspecialchars($row['answer'])); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-question-circle fa-3x mb-3 text-muted"></i>
                            <p class="text-muted">No questions found. Check back soon!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="help-card shadow-lg">
                    <h2 class="mb-3" style="font-family: 'Playfair Display';">Still have questions?</h2>
                    <p class="mb-4 opacity-75">Our support team is available from 9 AM to 9 PM.</p>
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
    
    <script>
        document.getElementById('faqSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('.faq-row');
            
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>