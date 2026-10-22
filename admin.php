<?php
session_start();
require_once 'db.php';

// Oturum kontrolü
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$message = '';

// Çıkış yapma isteği
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Yeni yazı ekleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        $message = "Blog yazısı başarıyla eklendi!";
    } else {
        $message = "Lütfen tüm alanları doldurun!";
    }
}

// Yazı silme
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

// Yazıları listele
$posts = $pdo->query("SELECT * FROM posts ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli | Ayhan Taş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="admin.php"><i class="fa-solid fa-gauge me-2"></i>Admin Paneli</a>
        <div class="ms-auto d-flex align-items-center">
            <a href="index.php" target="_blank" class="btn btn-outline-light btn-sm me-2"><i class="fa-solid fa-globe me-1"></i> Siteyi Gör</a>
            <a href="admin.php?action=logout" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i> Çıkış Yap</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Yazı Ekleme Formu -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="fw-bold mb-3"><i class="fa-solid fa-plus me-1 text-primary"></i> Yeni Yazı Ekle</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Yazı Başlığı</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Yazı İçeriği</label>
                        <textarea name="content" rows="6" class="form-control" required></textarea>
                    </div>
                    <button type="submit" name="add_post" class="btn btn-primary w-100">Yayınla</button>
                </form>
            </div>
        </div>

        <!-- Mevcut Yazılar Tablosu -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="fw-bold mb-3"><i class="fa-solid fa-newspaper me-1 text-primary"></i> Kayıtlı Yazılar</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Başlık</th>
                            <th>Tarih</th>
                            <th class="text-end">İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($posts)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Hiç yazı bulunmuyor.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td class="fw-semibold"><?= htmlspecialchars($post['title']); ?></td>
                                    <td class="small text-muted"><?= date('d.m.Y H:i', strtotime($post['created_at'])); ?></td>
                                    <td class="text-end">
                                        <a href="post.php?id=<?= $post['id']; ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Görüntüle"><i class="fa-solid fa-eye"></i></a>
                                        <a href="admin.php?id=<?= $post['id']; ?>&delete=<?= $post['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu yazıyı silmek istediğinizden emin misiniz?');" title="Sil"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>