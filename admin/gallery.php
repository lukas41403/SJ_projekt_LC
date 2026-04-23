<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../db.php';
require_once '../Gallery.php';

$database = new Database();
$db = $database->connect();
$gallery = new Gallery($db);

// VYMAZANIE
if(isset($_GET['delete'])) {
    $g = $gallery->getById($_GET['delete']);
    if($g && !empty($g['filename'])) {
        @unlink('../uploads/gallery/' . $g['filename']);
    }
    $gallery->id = $_GET['delete'];
    $gallery->delete();
    header('Location: gallery.php');
    exit;
}

// PRIDANIE
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gallery->title = $_POST['title'];

    if(!empty($_FILES['filename']['name'])) {
        $fileName = time() . '_' . basename($_FILES['filename']['name']);
        $uploadPath = '../uploads/gallery/' . $fileName;
        move_uploaded_file($_FILES['filename']['tmp_name'], $uploadPath);
        $gallery->filename = $fileName;
        $gallery->create();
    }

    header('Location: gallery.php');
    exit;
}

$allPhotos = $gallery->getAll();
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galéria | Admin</title>
    <link href="/SJ_projekt_LC/css/bootstrap.min.css" rel="stylesheet">
    <link href="/SJ_projekt_LC/css/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a2e; color: #fff; }
        .sidebar {
            min-height: 100vh;
            background-color: #16213e;
            padding: 20px 0;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .sidebar a:hover, .sidebar a.active { background-color: #e84545; }
        .sidebar .brand {
            font-size: 1.2rem;
            font-weight: 700;
            padding: 15px 20px 30px;
            border-bottom: 1px solid #ffffff22;
            margin-bottom: 10px;
        }
        .main-content { padding: 30px; }
        .top-bar {
            background-color: #16213e;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        .form-control {
            background-color: #0f3460;
            border: none;
            color: #fff;
        }
        .form-control:focus {
            background-color: #0f3460;
            color: #fff;
            box-shadow: 0 0 0 2px #e84545;
        }
        .gallery-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-2 px-0 sidebar">
            <div class="brand">
                <i class="bi-shield-lock me-2"></i>Admin Panel
            </div>
            <a href="index.php"><i class="bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="players.php"><i class="bi-people me-2"></i>Hráči</a>
            <a href="news.php"><i class="bi-newspaper me-2"></i>Aktuality</a>
            <a href="gallery.php" class="active"><i class="bi-images me-2"></i>Galéria</a>
            <hr style="border-color: #ffffff22;">
            <a href="/SJ_projekt_LC/index.php"><i class="bi-house me-2"></i>Zobraziť web</a>
            <a href="logout.php"><i class="bi-box-arrow-right me-2"></i>Odhlásiť sa</a>
        </div>

        <div class="col-md-10 px-0">
            <div class="main-content">
                <div class="top-bar">
                    <h5 class="mb-0">Správa galérie</h5>
                    <span><i class="bi-person-circle me-2"></i><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>

                <!-- FORM -->
                <div class="p-4 mb-4 rounded" style="background-color: #16213e;">
                    <h5 class="mb-3">Pridať fotku</h5>
                    <form method="POST" action="gallery.php" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Popis fotky</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fotka</label>
                                <input type="file" name="filename" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi-upload me-1"></i>Nahrať fotku
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- FOTKY -->
                <div class="p-4 rounded" style="background-color: #16213e;">
                    <h5 class="mb-3">Fotky v galérii (<?php echo count($allPhotos); ?>)</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Náhľad</th>
                                    <th>Popis</th>
                                    <th>Dátum</th>
                                    <th>Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($allPhotos)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary">Žiadne fotky</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($allPhotos as $p): ?>
                                    <tr>
                                        <td><?php echo $p['id']; ?></td>
                                        <td>
                                            <img src="/SJ_projekt_LC/uploads/gallery/<?php echo htmlspecialchars($p['filename']); ?>"
                                                 class="gallery-img">
                                        </td>
                                        <td><?php echo htmlspecialchars($p['title']); ?></td>
                                        <td><?php echo date('d.m.Y', strtotime($p['created_at'])); ?></td>
                                        <td>
                                            <a href="gallery.php?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger"
                                               onclick="return confirm('Naozaj chceš vymazať túto fotku?')">
                                                <i class="bi-trash"></i>
                                            </a>
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
</div>

<script src="/SJ_projekt_LC/js/bootstrap.min.js"></script>
</body>
</html>