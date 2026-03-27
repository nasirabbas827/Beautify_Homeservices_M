<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_logged_in'])) { header("Location: adminlogin.php"); exit(); }

$id = intval($_GET['id']);
$message = "";

$res = mysqli_query($conn, "SELECT * FROM stories WHERE story_id=$id");
$story = mysqli_fetch_assoc($res);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // Handle image upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $target_dir = "uploads/";
        $filename = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $target_dir . $filename;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
            $image_url = "uploads/" . $filename;
            $sql = "UPDATE stories SET title='$title', content='$content', image_url='$image_url' WHERE story_id=$id";
        } else {
            $message = "<div class='alert alert-warning'>Image upload failed.</div>";
        }
    } else {
        $sql = "UPDATE stories SET title='$title', content='$content' WHERE story_id=$id";
    }

    if(mysqli_query($conn, $sql)){
        header("Location: view_stories.php?msg=updated");
    } else {
        $message = "<div class='alert alert-danger'>Update failed: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Story | Beautify Admin</title>
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
                    <h3 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-warning"></i>Edit Story</h3>
                    <?php echo $message; ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Story Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($story['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Content</label>
                            <textarea name="content" class="form-control" rows="5"><?php echo htmlspecialchars($story['content']); ?></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Image</label>
                            <?php if($story['image_url']): ?>
                                <div class="mb-2"><img src="<?php echo $story['image_url']; ?>" width="80"></div>
                            <?php endif; ?>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2">Update Story</button>
                        <a href="view_stories.php" class="btn btn-link w-100 mt-2 text-muted text-decoration-none">Cancel and Go Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>