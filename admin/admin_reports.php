<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}

// ───────────────────────────────────────────────
//  Form inputs
// ───────────────────────────────────────────────
$report_type = $_POST['report_type'] ?? 'sales';   
$period      = $_POST['period']      ?? 'this_month'; // Default to this month for better UX
$start_date  = $_POST['start_date']  ?? date('Y-m-01');
$end_date    = $_POST['end_date']    ?? date('Y-m-t');
$profit_margin = 0.70; 

// Preset periods logic
switch ($period) {
    case 'today':      $start_date = $end_date = date('Y-m-d'); break;
    case 'yesterday':  $start_date = $end_date = date('Y-m-d', strtotime('-1 day')); break;
    case 'this_week':  $start_date = date('Y-m-d', strtotime('monday this week')); $end_date = date('Y-m-d', strtotime('sunday this week')); break;
    case 'last_week':  $start_date = date('Y-m-d', strtotime('monday last week')); $end_date = date('Y-m-d', strtotime('sunday last week')); break;
    case 'this_month': $start_date = date('Y-m-01'); $end_date = date('Y-m-t'); break;
    case 'last_month': $start_date = date('Y-m-01', strtotime('first day of last month')); $end_date = date('Y-m-t', strtotime('last day of last month')); break;
    case 'this_year':  $start_date = date('Y-01-01'); $end_date = date('Y-12-31'); break;
}

if (strtotime($start_date) > strtotime($end_date)) {
    [$start_date, $end_date] = [$end_date, $start_date];
}

// ───────────────────────────────────────────────
//  Core stats calculation
// ───────────────────────────────────────────────
$stmt = $conn->prepare("
    SELECT 
        COUNT(*) AS total_bookings,
        COUNT(CASE WHEN status = 'completed' THEN 1 END) AS completed_count,
        COUNT(CASE WHEN status = 'cancelled' THEN 1 END) AS cancelled_count,
        SUM(total_amount) AS gross_revenue,
        SUM(CASE WHEN status IN ('completed','confirmed') THEN total_amount ELSE 0 END) AS considered_revenue,
        SUM(CASE WHEN status = 'completed' THEN total_amount ELSE 0 END) AS realized_revenue
    FROM appointments 
    WHERE appointment_date BETWEEN ? AND ?
");
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

$total_bookings      = $stats['total_bookings']      ?? 0;
$completed_count     = $stats['completed_count']     ?? 0;
$cancelled_count     = $stats['cancelled_count']     ?? 0;
$gross_revenue       = $stats['gross_revenue']       ?? 0;
$considered_revenue  = $stats['considered_revenue']  ?? 0;
$realized_revenue    = $stats['realized_revenue']    ?? 0;
$estimated_profit    = round($considered_revenue * $profit_margin);

// Quick Side-Bar Summaries
$today_dt = date('Y-m-d');
$month_dt = date('Y-m');
$year_dt  = date('Y');

$daily_total   = $conn->query("SELECT COALESCE(SUM(total_amount),0) FROM appointments WHERE appointment_date = '$today_dt' AND status IN ('completed','confirmed')")->fetch_row()[0];
$monthly_total = $conn->query("SELECT COALESCE(SUM(total_amount),0) FROM appointments WHERE appointment_date LIKE '$month_dt%' AND status IN ('completed','confirmed')")->fetch_row()[0];
$yearly_total  = $conn->query("SELECT COALESCE(SUM(total_amount),0) FROM appointments WHERE appointment_date LIKE '$year_dt%' AND status IN ('completed','confirmed')")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports Dashboard | Beautify Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root { --admin-gold: #d4a373; --admin-dark: #212529; }
        body { background:#f4f7f6; font-family: 'Inter', system-ui, -apple-system, sans-serif; color: #444; }
        .report-card { border: none; border-radius: 12px; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); transition: all 0.3s ease; border-top: 4px solid transparent; }
        .report-card:hover { transform: translateY(-3px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); }
        .stat-value { font-size: 1.8rem; font-weight: 800; letter-spacing: -1px; }
        .quick-box { background: #fff; border-radius: 10px; padding: 15px; border: 1px solid #edf2f7; }
        .table thead th { background: #f8f9fa; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; font-weight: 700; color: #6c757d; border-bottom: none; }
        .badge-subtle { padding: 0.5em 1em; font-weight: 600; }
        @media print { .no-print { display:none !important; } body { background:white; } .report-card { border: 1px solid #eee; } }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-4">

    <div class="row align-items-center mb-4 no-print">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark mb-0">Financial Analytics</h3>
            <p class="text-muted small">Data driven insights for your business growth</p>
        </div>
        <div class="col-md-6 text-md-end">
            <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-4 btn-sm fw-bold">
                <i class="fas fa-file-pdf me-2"></i>Export PDF
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 no-print">
        <div class="card-body p-3">
            <form method="POST" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label x-small fw-bold text-uppercase text-muted mb-1" style="font-size: 0.7rem;">Report Category</label>
                    <select name="report_type" class="form-select form-select-sm border-0 bg-light" onchange="this.form.submit()">
                        <option value="sales" <?= $report_type==='sales'?'selected':'' ?>>Sales & Revenue</option>
                        <option value="bookings" <?= $report_type==='bookings'?'selected':'' ?>>Booking Volume</option>
                        <option value="profit" <?= $report_type==='profit'?'selected':'' ?>>Profit Analysis</option>
                        <option value="transactions" <?= $report_type==='transactions'?'selected':'' ?>>Detailed Logs</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label x-small fw-bold text-uppercase text-muted mb-1" style="font-size: 0.7rem;">Timeline</label>
                    <select name="period" class="form-select form-select-sm border-0 bg-light" onchange="this.form.submit()">
                        <option value="today" <?= $period==='today'?'selected':'' ?>>Today</option>
                        <option value="this_week" <?= $period==='this_week'?'selected':'' ?>>This Week</option>
                        <option value="this_month" <?= $period==='this_month'?'selected':'' ?>>This Month</option>
                        <option value="this_year" <?= $period==='this_year'?'selected':'' ?>>This Year</option>
                        <option value="custom" <?= $period==='custom'?'selected':'' ?>>Custom Range</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label x-small fw-bold text-uppercase text-muted mb-1" style="font-size: 0.7rem;">Start Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm border-0 bg-light" value="<?= htmlspecialchars($start_date) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label x-small fw-bold text-uppercase text-muted mb-1" style="font-size: 0.7rem;">End Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm border-0 bg-light" value="<?= htmlspecialchars($end_date) ?>">
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-warning btn-sm fw-bold rounded-3 shadow-sm">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4 no-print text-center">
        <div class="col-md-4">
            <div class="quick-box shadow-sm border-0">
                <span class="text-muted small text-uppercase fw-bold">Today</span>
                <div class="h5 fw-bold text-success mt-1">Rs. <?= number_format($daily_total) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="quick-box shadow-sm border-0">
                <span class="text-muted small text-uppercase fw-bold">Monthly</span>
                <div class="h5 fw-bold text-primary mt-1">Rs. <?= number_format($monthly_total) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="quick-box shadow-sm border-0">
                <span class="text-muted small text-uppercase fw-bold">Yearly</span>
                <div class="h5 fw-bold text-dark mt-1">Rs. <?= number_format($yearly_total) ?></div>
            </div>
        </div>
    </div>

    <?php if ($report_type === 'sales'): ?>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card report-card bg-white p-4 border-success">
                <div class="text-muted small fw-bold">GROSS REVENUE</div>
                <div class="stat-value text-success mt-1">Rs. <?= number_format($gross_revenue) ?></div>
                <p class="small text-muted mb-0 mt-2"><i class="fas fa-info-circle me-1"></i> Total booked value</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card report-card bg-white p-4 border-primary">
                <div class="text-muted small fw-bold">EXPECTED CASH</div>
                <div class="stat-value text-primary mt-1">Rs. <?= number_format($considered_revenue) ?></div>
                <p class="small text-muted mb-0 mt-2">Active & Completed</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card report-card bg-white p-4 border-info">
                <div class="text-muted small fw-bold">COLLECTED REVENUE</div>
                <div class="stat-value text-info mt-1">Rs. <?= number_format($realized_revenue) ?></div>
                <p class="small text-muted mb-0 mt-2">Fully processed</p>
            </div>
        </div>
    </div>

    <?php elseif ($report_type === 'bookings'): ?>
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card report-card bg-white p-4 border-primary">
                <div class="text-muted small fw-bold">TOTAL VOLUME</div>
                <div class="stat-value text-primary mt-1"><?= number_format($total_bookings) ?></div>
                <p class="small text-muted mb-0 mt-2">Total appointments</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card report-card bg-white p-4 border-success">
                <div class="text-muted small fw-bold">SUCCESSFUL</div>
                <div class="stat-value text-success mt-1"><?= number_format($completed_count) ?></div>
                <p class="small text-muted mb-0 mt-2">Finished services</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card report-card bg-white p-4 border-danger">
                <div class="text-muted small fw-bold">CANCELLED</div>
                <div class="stat-value text-danger mt-1"><?= number_format($cancelled_count) ?></div>
                <p class="small text-muted mb-0 mt-2">Revoked bookings</p>
            </div>
        </div>
    </div>

    <?php elseif ($report_type === 'profit'): ?>
    <div class="row mb-5 justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card report-card border-warning bg-white p-5">
                <div class="text-muted small fw-bold text-uppercase">Projected Net Profit</div>
                <div class="stat-value text-dark mt-2" style="font-size: 3rem;">Rs. <?= number_format($estimated_profit) ?></div>
                <div class="badge bg-warning-subtle text-warning rounded-pill mt-3 px-3 py-2">
                    Margin: <?= ($profit_margin * 100) ?>%
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (in_array($report_type, ['sales','bookings','transactions'])): ?>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Detailed Record Log</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Date & Time</th>
                        <th>Client Detail</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT a.id, a.appointment_date, a.appointment_time, a.status, a.total_amount,
                               u.full_name, u.contact_number,
                               (SELECT COUNT(*) FROM appointment_services WHERE appointment_id = a.id) AS s_count
                        FROM appointments a
                        JOIN users u ON a.client_id = u.id
                        WHERE a.appointment_date BETWEEN ? AND ?
                        ORDER BY a.appointment_date DESC, a.appointment_time DESC";
                $st = $conn->prepare($sql);
                $st->bind_param("ss", $start_date, $end_date);
                $st->execute();
                $rows = $st->get_result();

                if ($rows->num_rows > 0):
                    while ($r = $rows->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold"><?= date('d M, Y', strtotime($r['appointment_date'])) ?></span><br>
                                <span class="text-muted small"><?= date('h:i A', strtotime($r['appointment_time'])) ?></span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= htmlspecialchars($r['full_name']) ?></div>
                                <div class="text-muted x-small"><?= htmlspecialchars($r['contact_number'] ?: 'N/A') ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border fw-normal"><?= $r['s_count'] ?> Services</span></td>
                            <td>
                                <?php 
                                    $s = $r['status'];
                                    $clr = ($s==='completed') ? 'success' : (($s==='cancelled') ? 'danger' : 'warning');
                                ?>
                                <span class="badge badge-subtle bg-<?= $clr ?>-subtle text-<?= $clr ?> rounded-pill">
                                    <?= ucfirst($s) ?>
                                </span>
                            </td>
                            <td class="text-end pe-4 fw-bold text-dark">Rs. <?= number_format($r['total_amount']) ?></td>
                        </tr>
                    <?php endwhile; 
                else: ?>
                    <tr><td colspan="5" class="text-center py-5 text-muted">No transactions found for this period.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>