<?php
session_start();
include "config.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminlogin.php");
    exit();
}

// --- DATA FETCHING ---

// 1. Get Total Clients
$user_count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_users = mysqli_fetch_assoc($user_count_res)['total'];

// 2. Get Active Services
$service_count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM services WHERE is_active = 1");
$total_services = mysqli_fetch_assoc($service_count_res)['total'];

// 3. Get Total Appointments (Bookings)
$booking_count_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM appointments");
$total_bookings = mysqli_fetch_assoc($booking_count_res)['total'];

// 4. Fetch Recently Joined Clients (Limit 5)
$recent_users = mysqli_query($conn, "SELECT full_name, email, contact_number, created_at, is_active FROM users ORDER BY created_at DESC LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Beautify Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">

    <style>
        :root {
            --sidebar-bg: #212529;
            --accent-gold: #d4a373;
        }
        body {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
        }
        .main-wrapper {
            padding: 30px;
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .icon-shape {
            width: 48px;
            height: 48px;
            background: rgba(212, 163, 115, 0.1);
            color: var(--accent-gold);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .status-pill {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .border-dashed {
            border-style: dashed !important;
        }
    </style>
</head>
<body>

<?php include('navbar.php'); ?>

<div class="main-wrapper container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Management Overview</h2>
            <p class="text-muted">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></p>
        </div>
        <a href="admin_reports.php" class="btn btn-dark rounded-pill px-4">
    <i class="fas fa-file-invoice-dollar me-2 text-warning"></i> Generate & Export Reports
</a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small uppercase fw-bold">Total Clients</h6>
                        <h3 class="mb-0 fw-bold"><?php echo number_format($total_users); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape me-3" style="background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                        <i class="fas fa-magic"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small uppercase fw-bold">Active Services</h6>
                        <h3 class="mb-0 fw-bold"><?php echo number_format($total_services); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape me-3" style="background: rgba(25, 135, 84, 0.1); color: #198754;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small uppercase fw-bold">Total Bookings</h6>
                        <h3 class="mb-0 fw-bold"><?php echo number_format($total_bookings); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card table-card">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recently Joined Clients</h5>
                    <a href="view_users.php" class="btn btn-link btn-sm text-decoration-none fw-bold text-dark">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small uppercase">
                                <tr>
                                    <th class="ps-4">Client Name</th>
                                    <th>Contact</th>
                                    <th>Joined Date</th>
                                    <th class="text-end pe-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($recent_users) > 0): ?>
                                    <?php while($row = mysqli_fetch_assoc($recent_users)): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold"><?php echo htmlspecialchars($row['full_name']); ?></div>
                                            <div class="text-muted small"><?php echo htmlspecialchars($row['email']); ?></div>
                                        </td>
                                        <td><span class="small"><?php echo htmlspecialchars($row['contact_number'] ?: 'N/A'); ?></span></td>
                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                        <td class="text-end pe-4">
                                            <?php if($row['is_active']): ?>
                                                <span class="status-pill bg-success bg-opacity-10 text-success">Active</span>
                                            <?php else: ?>
                                                <span class="status-pill bg-danger bg-opacity-10 text-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">No clients registered yet.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card table-card p-4">
                <h5 class="fw-bold mb-4">Quick Management</h5>
                <div class="d-grid gap-3">
                    <a href="add_service.php" class="btn btn-outline-dark text-start p-3 border-dashed">
                        <i class="fas fa-plus-circle me-2 text-warning"></i> Add New Beauty Service
                    </a>
                    <a href="admin_view_appointments.php" class="btn btn-outline-dark text-start p-3 border-dashed">
                        <i class="fas fa-clipboard-list me-2 text-primary"></i> Manage Appointments
                    </a>
                    <a href="view_services.php" class="btn btn-outline-dark text-start p-3 border-dashed">
                        <i class="fas fa-magic me-2 text-info"></i> View/Edit Services
                    </a>
                </div>
                
                <div class="mt-5 p-4 bg-dark text-white rounded-4 shadow-sm">
                    <h6 class="fw-bold"><i class="fas fa-server me-2 text-success"></i>System Status</h6>
                    <hr class="opacity-25">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small opacity-75">Database</span>
                        <span class="badge bg-success">Online</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small opacity-75">Last Login</span>
                        <span class="small"><?php echo date('H:i A'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>