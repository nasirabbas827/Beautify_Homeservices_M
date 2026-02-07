<?php
date_default_timezone_set('Asia/Karachi');

include('config.php');
session_start();

if (!isset($_SESSION['id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$user_id = $_SESSION['id'];
$full_name = $_SESSION['full_name'] ?? 'User';
$email = $_SESSION['email'] ?? '';

// Fetch real booking count (excluding cancelled)
$count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM appointments WHERE client_id = $user_id AND status != 'cancelled'");
$booking_count = mysqli_fetch_assoc($count_res)['total'] ?? 0;

// Fetch Total Spend
$spend_res = mysqli_query($conn, "SELECT SUM(total_amount) as total_spend FROM appointments WHERE client_id = $user_id AND status = 'completed'");
$total_spend = mysqli_fetch_assoc($spend_res)['total_spend'] ?? 0;

// Fetch recent appointments with service names
$recent_query = "SELECT a.*, 
                (SELECT GROUP_CONCAT(s.service_name SEPARATOR ', ') 
                 FROM appointment_services aps 
                 JOIN services s ON aps.service_id = s.id 
                 WHERE aps.appointment_id = a.id) as services_booked
                 FROM appointments a 
                 WHERE a.client_id = $user_id 
                 ORDER BY a.created_at DESC LIMIT 5";
$recent_bookings = mysqli_query($conn, $recent_query);  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Dashboard | Beautify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .dashboard-header { background: #2d2d2d; color: white; padding: 40px 0; border-radius: 0 0 30px 30px; }
        .stat-card { border: none; border-radius: 15px; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .badge-pending   { background: #fff3cd; color: #856404; }
        .badge-confirmed { background: #d4edda; color: #155724; }
        .badge-completed { background: #cce5ff; color: #004085; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<header class="dashboard-header mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2>Welcome, <?= htmlspecialchars($full_name) ?></h2>
            <p class="opacity-75">Member since: <?= date('M Y') ?></p>
        </div>
        <a href="search_services.php" class="btn btn-warning rounded-pill px-4 fw-bold">Book a Service</a>
    </div>
</header>

<main class="container mb-5">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card p-4 shadow-sm">
                <h6 class="text-muted small fw-bold text-uppercase">Total Bookings</h6>
                <h3 class="mb-0"><?= $booking_count ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4 shadow-sm">
                <h6 class="text-muted small fw-bold text-uppercase">Customer ID</h6>
                <h3 class="mb-0">#BE-<?= str_pad($user_id, 4, '0', STR_PAD_LEFT) ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4 shadow-sm">
                <h6 class="text-muted small fw-bold text-uppercase">Total Spent</h6>
                <h3 class="mb-0">Rs. <?= number_format($total_spend) ?></h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card stat-card p-4 shadow-sm border-0">
                <h5 class="fw-bold mb-4">Recent Appointments</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-muted small">
                                <th>Services</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (mysqli_num_rows($recent_bookings) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($recent_bookings)): 
                                // Timer logic for cancellation window
                                $created_at = strtotime($row['created_at']);
                                $now = time();
                                $minutes_passed = ($now - $created_at) / 60;
                                $can_cancel = ($minutes_passed < 5 && $row['status'] === 'pending');
                            ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['services_booked'] ?: '—') ?></strong></td>
                                <td>
                                    <?= date('d M Y', strtotime($row['appointment_date'])) ?><br>
                                    <small class="text-muted"><?= date('h:i A', strtotime($row['appointment_time'])) ?></small>
                                </td>
                                <td>
                                    <span class="badge rounded-pill 
                                        <?php 
                                            if ($row['status'] == 'pending')    echo 'badge-pending';
                                            elseif ($row['status'] == 'confirmed') echo 'badge-confirmed';
                                            elseif ($row['status'] == 'completed') echo 'badge-completed';
                                            elseif ($row['status'] == 'cancelled') echo 'badge-cancelled';
                                        ?>">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($can_cancel): ?>
                                        <a href="delete_booking.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-outline-danger btn-sm rounded-pill"
                                           onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            Cancel
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No recent appointments found.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card stat-card p-4 shadow-sm border-0 bg-dark text-white">
                <h6 class="mb-3">Quick Tips</h6>
                <p class="small opacity-75 mb-0">
                    • You can cancel any pending booking within <strong>5 minutes</strong> of placing it.<br>
                    • After that, please contact support for any changes.
                </p>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>