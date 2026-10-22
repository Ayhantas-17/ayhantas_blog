<?php
require_once 'db.php';


$stmt = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayhan Taş Kişisel Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"> Ayhan Taş</a>
        <div class="ms-auto">
            <a href="login.php" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-lock me-1"></i> Yönetim Paneli</a>
        </div>
    </div>
</nav>


<header class="bg-primary text-white text-center py-5 mb-5 shadow-sm">
    <div class="container">
        <h1 class="fw-bold">Kişisel Blog </h1>
        <p class="lead text-white-50"</p>
    </div>
</header>


<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if (empty($posts)): ?>
                <div class="alert alert-info text-center">Henüz blog yazısı eklenmemiş.</div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-body p-4">
                            <h2 class="card-title h4 fw-bold">
                                <a href="post.php?id=<?= $post['id']; ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($post['title']); ?></a>
                            </h2>
                            <p class="text-muted small mb-3">
                                <i class="fa-regular fa-calendar me-1"></i> <?= date('d.m.Y H:i', strtotime($post['created_at'])); ?>
                            </p>
                            <p class="card-text text-secondary">
                                <?= nl2br(htmlspecialchars(mb_substr($post['content'], 0, 200))); ?>...
                            </p>
                            <a href="post.php?id=<?= $post['id']; ?>" class="btn btn-primary btn-sm">Devamını Oku <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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