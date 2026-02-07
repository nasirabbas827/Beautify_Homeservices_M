<?php
include('config.php');
session_start();

if (!isset($_SESSION['id'])) { header("Location: login.php"); exit(); }

$service_id = intval($_GET['service_id']);
$service_res = mysqli_query($conn, "SELECT * FROM services WHERE id = $service_id");
$service = mysqli_fetch_assoc($service_res);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_SESSION['id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $payment = $_POST['payment_method'];
    $total = $service['price'];

    // 1. Insert into appointments
    $sql = "INSERT INTO appointments (client_id, appointment_date, appointment_time, service_address, contact_number, total_amount, status) 
            VALUES ('$client_id', '$date', '$time', '$address', '$contact', '$total', 'pending')";
    
    if (mysqli_query($conn, $sql)) {
        $app_id = mysqli_insert_id($conn);
        // 2. Insert into appointment_services
        mysqli_query($conn, "INSERT INTO appointment_services (appointment_id, service_id, price) VALUES ('$app_id', '$service_id', '$total')");
        
        header("Location: dashboard.php?msg=success");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Beautify</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body class="bg-light">
<?php include('navbar.php'); ?>

    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your Selection</span>
                </h4>
                <ul class="list-group mb-3 shadow-sm">
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0"><?php echo $service['service_name']; ?></h6>
                            <small class="text-muted"><?php echo $service['duration_minutes']; ?> mins</small>
                        </div>
                        <span class="text-muted">Rs. <?php echo $service['price']; ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-md-8">
                <h4 class="mb-3 fw-bold">Appointment Details</h4>
                <form method="POST" class="card p-4 shadow-sm border-0">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">Desired Date</label>
                            <input type="date" name="appointment_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Desired Time</label>
                            <input type="time" name="appointment_time" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Service Address</label>
                            <textarea name="address" class="form-control" placeholder="Where should our stylist come?" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" class="form-control" value="<?php echo $_SESSION['contact_number'] ?? ''; ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cod">Cash on Delivery</option>
                                <option value="card">Debit/Credit Card</option>
                                <option value="easypaisa">EasyPaisa</option>
                                <option value="jazzcash">JazzCash</option>
                            </select>
                        </div>
                    </div>
                    <hr class="my-4">
                    <button class="btn btn-warning btn-lg w-100 fw-bold" type="submit">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>