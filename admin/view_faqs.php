<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

// Delete Logic
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM faqs WHERE faq_id = $id");
    header("Location: view_faqs.php?msg=deleted");
}

$result = mysqli_query($conn, "SELECT * FROM faqs ORDER BY faq_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage FAQs | Beautify Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="bg-light">
<?php include('navbar.php'); ?>
<div class="container mt-5 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">FAQs</h2>
        <a href="admin_add_faq.php" class="btn btn-warning fw-bold px-4 rounded-pill">
            <i class="fas fa-plus me-2"></i>New FAQ
        </a>
    </div>

    <?php if(isset($_GET['msg'])) echo "<div class='alert alert-info py-2'>Action performed successfully.</div>"; ?>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td class="ps-4 text-muted">#<?php echo $row['faq_id']; ?></td>
                        <td class="fw-bold"><?php echo htmlspecialchars($row['question']); ?></td>
                        <td class="text-muted small"><?php echo htmlspecialchars(substr($row['answer'], 0, 50)) . '...'; ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                        <td class="text-center">
                            <a href="edit_faq.php?id=<?php echo $row['faq_id']; ?>" class="mb-2 btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="view_faqs.php?delete=<?php echo $row['faq_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this FAQ?')">
                                <i class="fas fa-trash"></i>
                            </a>
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