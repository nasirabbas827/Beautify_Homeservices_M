<?php
include('config.php');
session_start();

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $user_id = $_SESSION['id'];
    
    // Check if the booking belongs to user AND was created less than 5 mins ago
    $res = mysqli_query($conn, "SELECT created_at FROM appointments WHERE id = $id AND client_id = $user_id");
    $row = mysqli_fetch_assoc($res);
    
    if($row) {
        $created_at = strtotime($row['created_at']);
        if((time() - $created_at) <= 300) { // 300 seconds = 5 minutes
            mysqli_query($conn, "UPDATE appointments SET status = 'cancelled' WHERE id = $id");
            header("Location: dashboard.php?msg=cancelled");
        } else {
            header("Location: dashboard.php?error=expired");
        }
    }
}
?>