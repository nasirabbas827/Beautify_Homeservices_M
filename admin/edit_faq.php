<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

$id = intval($_GET['id']);
$message = "";

$res = mysqli_query($conn, "SELECT * FROM faqs WHERE faq_id=$id");
$faq = mysqli_fetch_assoc($res);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);

    $sql = "UPDATE faqs SET question='$question', answer='$answer' WHERE faq_id=$id";
    if(mysqli_query($conn, $sql)){
        header("Location: view_faqs.php?msg=updated");
    } else {
        $message = "<div class='alert alert-danger'>Update failed: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit FAQ | Beautify Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="bg-light">
<?php include('navbar.php'); ?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-warning"></i>Edit FAQ</h3>
                    <?php echo $message; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Question</label>
                            <input type="text" name="question" class="form-control" value="<?php echo htmlspecialchars($faq['question']); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Answer</label>
                            <textarea name="answer" class="form-control" rows="5"><?php echo htmlspecialchars($faq['answer']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2">Update FAQ</button>
                        <a href="view_faqs.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">Cancel and Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>