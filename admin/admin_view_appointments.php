<?php
session_start();
include "config.php";

// Admin Protection
if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

// Update Status Logic
if (isset($_POST['update_status'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update_sql = "UPDATE appointments SET status = '$new_status' WHERE id = $appointment_id";
    mysqli_query($conn, $update_sql);
    $message = "<div class='alert alert-success py-2 small'>Status updated to $new_status!</div>";
}

// Fetch Appointments with Client Names and Service Summaries
$query = "SELECT a.*, u.full_name, u.contact_number as user_phone,
          (SELECT GROUP_CONCAT(s.service_name SEPARATOR ', ') 
           FROM appointment_services aps 
           JOIN services s ON aps.service_id = s.id 
           WHERE aps.appointment_id = a.id) as services_list
          FROM appointments a
          JOIN users u ON a.client_id = u.id
          ORDER BY a.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments | Beautify Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">

    <style>
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #cfe2ff; color: #084298; }
        .status-completed { background: #d1e7dd; color: #0f5132; }
        .status-cancelled { background: #f8d7da; color: #842029; }
        .table-card { border-radius: 15px; overflow: hidden; border: none; }
    </style>
</head>
<body class="bg-light">
    <?php include('navbar.php'); ?>

    <div class="container mb-5 mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class="fas fa-calendar-check me-2 text-warning"></i>Client Appointments</h2>
            <div class="text-muted small">Total Found: <?php echo mysqli_num_rows($result); ?></div>
        </div>

        <?php if(isset($message)) echo $message; ?>

        <div class="card table-card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Client Info</th>
                            <th>Services</th>
                            <th>Schedule</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="ps-4 text-muted small">#BE-<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($row['full_name']); ?></div>
                                <div class="text-muted small"><i class="fas fa-phone me-1"></i><?= $row['contact_number']; ?></div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="<?= $row['services_list']; ?>">
                                    <?= $row['services_list']; ?>
                                </div>
                            </td>
                            <td>
                                <div><i class="far fa-calendar-alt me-1"></i> <?= date('d M, Y', strtotime($row['appointment_date'])); ?></div>
                                <div class="text-muted small"><i class="far fa-clock me-1"></i> <?= date('h:i A', strtotime($row['appointment_time'])); ?></div>
                            </td>
                            <td class="fw-bold text-success">PKR <?= number_format($row['total_amount']); ?></td>
                            <td>
                                <span class="badge status-<?= $row['status']; ?> px-3 py-2 rounded-pill">
                                    <?= ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <form method="POST" class="d-flex gap-2 justify-content-center">
                                    <input type="hidden" name="appointment_id" value="<?= $row['id']; ?>">
                                    <select name="status" class="form-select form-select-sm" style="width: 120px;">
                                        <option value="pending" <?= $row['status']=='pending'?'selected':''; ?>>Pending</option>
                                        <option value="confirmed" <?= $row['status']=='confirmed'?'selected':''; ?>>Confirm</option>
                                        <option value="completed" <?= $row['status']=='completed'?'selected':''; ?>>Complete</option>
                                        <option value="cancelled" <?= $row['status']=='cancelled'?'selected':''; ?>>Cancel</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-sm btn-dark">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="table-light">
                            <td colspan="7" class="ps-4 py-1 small text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i> Address: <?= htmlspecialchars($row['service_address']); ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>