<?php
require_once 'db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><= htmlspecialchars($post['title']); ?> | Ayhan Taş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="fa-solid fa-code me-2"></i>Ayhan Taş</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Ana Sayfa</a>
        </div>
    </div>
</nav>


<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <article class="card shadow-sm border-0 p-4 p-md-5">
                <h1 class="fw-bold mb-3"><?= htmlspecialchars($post['title']); ?></h1>
                <p class="text-muted small mb-4 pb-3 border-bottom">
                    <i class="fa-regular fa-calendar me-1"></i> <?= date('d.m.Y H:i', strtotime($post['created_at'])); ?>
                </p>
                <div class="blog-content text-secondary lh-lg" style="white-space: pre-line;">
                    <?= htmlspecialchars($post['content']); ?>
                </div>
            </article>
        </div>
    </div>
</div>


<footer class="bg-dark text-white text-center py-4 mt-auto">
    <div class="container">
        <p class="mb-0 small text-white-50"></p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>