<?php
// Set timezone BEFORE anything else to fix the "245 min" error
date_default_timezone_set('Asia/Karachi');

include('config.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch all appointments for this user with joined service names
$query = "SELECT a.*, 
          (SELECT GROUP_CONCAT(s.service_name SEPARATOR ', ') 
           FROM appointment_services aps 
           JOIN services s ON aps.service_id = s.id 
           WHERE aps.appointment_id = a.id) as service_names
          FROM appointments a 
          WHERE a.client_id = $user_id 
          ORDER BY a.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | Beautify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gold: #d4a373;
            --dark-charcoal: #2d2d2d;
            --soft-bg: #fdfcfb;
        }

        body { 
            background-color: var(--soft-bg); 
            font-family: 'Inter', sans-serif; 
            color: var(--dark-charcoal);
        }

        .booking-card {
            border: none;
            border-radius: 20px;
            background: white;
            transition: all 0.3s ease;
            border-left: 6px solid var(--dark-charcoal);
            overflow: hidden;
        }

        .booking-card:hover { 
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
        }

        /* Status Badge Styling */
        .status-badge { 
            font-size: 0.7rem; 
            padding: 5px 12px; 
            border-radius: 50px; 
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
        }
        .pending { background: #fff3cd; color: #856404; border-left-color: #ffc107 !important; }
        .confirmed { background: #d1e7dd; color: #0f5132; border-left-color: #198754 !important; }
        .completed { background: #cfe2ff; color: #084298; border-left-color: #0d6efd !important; }
        .cancelled { background: #f8d7da; color: #842029; border-left-color: #dc3545 !important; }

        .price-tag { 
            color: var(--primary-gold); 
            font-weight: 800; 
            font-size: 1.25rem; 
        }

        .timer-text {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            background: #fff5f5;
            border-radius: 6px;
            display: inline-block;
        }

        .empty-state img {
            width: 120px;
            opacity: 0.5;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="container py-5">
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h1 class="fw-bold mb-1" style="font-family: 'Playfair Display', serif;">My Appointments</h1>
            <p class="text-muted">You have total <strong><?= mysqli_num_rows($result); ?></strong> bookings in your history.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="index.php#services" class="btn btn-dark rounded-pill px-4 py-2 shadow-sm">
                <i class="fas fa-plus me-2"></i>Book New Service
            </a>
        </div>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="row g-4">
            <?php while($row = mysqli_fetch_assoc($result)): 
                // Time Calculation Logic
                $booking_timestamp = strtotime($row['created_at']);
                $current_timestamp = time();
                $seconds_passed = $current_timestamp - $booking_timestamp;
                $minutes_passed = $seconds_passed / 60;
                
                // Only show cancel button if status is pending AND it's been less than 5 mins
                $time_left = 5 - $minutes_passed;
                $is_deletable = ($time_left > 0 && $row['status'] == 'pending');
            ?>
                <div class="col-12">
                    <div class="card booking-card shadow-sm p-4 <?= $row['status']; ?>">
                        <div class="row align-items-center">
                            
                            <div class="col-md-4">
                                <span class="text-muted small fw-bold text-uppercase d-block mb-1" style="letter-spacing: 1px;">Selected Services</span>
                                <h5 class="fw-bold mb-2"><?= htmlspecialchars($row['service_names']); ?></h5>
                                <span class="status-badge <?= $row['status']; ?>">
                                    <i class="fas fa-circle me-2" style="font-size: 0.5rem;"></i> <?= ucfirst($row['status']); ?>
                                </span>
                            </div>

                            <div class="col-md-4 border-start border-end px-md-4 my-3 my-md-0">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-box me-3 text-primary"><i class="far fa-calendar-alt"></i></div>
                                    <div>
                                        <div class="fw-bold"><?= date('D, M d, Y', strtotime($row['appointment_date'])); ?></div>
                                        <div class="small text-muted"><?= date('h:i A', strtotime($row['appointment_time'])); ?></div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-3 text-primary"><i class="fas fa-map-marker-alt"></i></div>
                                    <div class="small text-muted"><?= htmlspecialchars($row['service_address']); ?></div>
                                </div>
                            </div>

                            <div class="col-md-4 text-md-end">
                                <div class="price-tag mb-2">Rs. <?= number_format($row['total_amount']); ?></div>
                                
                                <?php if ($is_deletable): ?>
                                    <div class="mb-2">
                                        <span class="timer-text text-danger">
                                            <i class="fas fa-hourglass-half me-1"></i> Ends in <?= ceil($time_left); ?> min
                                        </span>
                                    </div>
                                    <a href="delete_booking.php?id=<?= $row['id']; ?>" 
                                       class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold"
                                       onclick="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                                        Cancel Booking
                                    </a>
                                <?php elseif ($row['status'] == 'pending'): ?>
                                    <span class="text-muted small fst-italic">
                                        <i class="fas fa-lock me-1"></i> Fixed (5min window passed)
                                    </span>
                                <?php elseif ($row['status'] == 'cancelled'): ?>
                                    <span class="text-danger small fw-bold">Appointment Voided</span>
                                <?php else: ?>
                                    <button class="btn btn-light btn-sm rounded-pill px-3" disabled>
                                        <i class="fas fa-check-double me-1"></i> Verified
                                    </button>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" alt="No Bookings">
            <h3 class="fw-bold">No Appointments Yet</h3>
            <p class="text-muted">Looks like you haven't booked a luxury session yet.</p>
            <a href="index.php#services" class="btn btn-primary rounded-pill px-5 py-3 mt-3 shadow">Explore Services</a>
        </div>
    <?php endif; ?>
</div>

<footer class="py-4 text-center border-top bg-white mt-auto">
    <p class="small text-muted mb-0">&copy; <?= date('Y'); ?> BEAUTIFY. Need help? <a href="contact.php" class="text-primary text-decoration-none">Contact Support</a></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>