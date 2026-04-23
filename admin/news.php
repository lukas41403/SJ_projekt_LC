<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../db.php';
require_once '../NewsModel.php';

$database = new Database();
$db = $database->connect();
$news = new News($db);

// VYMAZANIE
if(isset($_GET['delete'])) {
    $news->id = $_GET['delete'];
    $news->delete();
    header('Location: news.php');
    exit;
}

// PRIDANIE / UPRAVENIE
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $news->title = $_POST['title'];
    $news->content = $_POST['content'];

    if(!empty($_FILES['image']['name'])) {
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $uploadPath = '../uploads/news/' . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
        $news->image = $fileName;
    } else {
        $news->image = $_POST['current_image'] ?? null;
    }

    if(isset($_POST['id']) && !empty($_POST['id'])) {
        $news->id = $_POST['id'];
        $news->update();
    } else {
        $news->create();
    }

    header('Location: news.php');
    exit;
}

$editNews = null;
if(isset($_GET['edit'])) {
    $editNews = $news->getById($_GET['edit']);
}

$allNews = $news->getAll();
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aktuality | Admin</title>
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
        .form-control, .form-select {
            background-color: #0f3460;
            border: none;
            color: #fff;
        }
        .form-control:focus {
            background-color: #0f3460;
            color: #fff;
            box-shadow: 0 0 0 2px #e84545;
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
            <a href="news.php" class="active"><i class="bi-newspaper me-2"></i>Aktuality</a>
            <a href="gallery.php"><i class="bi-images me-2"></i>Galéria</a>
            <hr style="border-color: #ffffff22;">
            <a href="/SJ_projekt_LC/index.php"><i class="bi-house me-2"></i>Zobraziť web</a>
            <a href="logout.php"><i class="bi-box-arrow-right me-2"></i>Odhlásiť sa</a>
        </div>

        <div class="col-md-10 px-0">
            <div class="main-content">
                <div class="top-bar">
                    <h5 class="mb-0">Správa aktualít</h5>
                    <span><i class="bi-person-circle me-2"></i><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>

                <div class="p-4 mb-4 rounded" style="background-color: #16213e;">
                    <h5 class="mb-3"><?php echo $editNews ? 'Upraviť aktualitu' : 'Pridať aktualitu'; ?></h5>
                    <form method="POST" action="news.php" enctype="multipart/form-data">
                        <?php if($editNews): ?>
                            <input type="hidden" name="id" value="<?php echo $editNews['id']; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $editNews['image']; ?>">
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Titulok</label>
                                <input type="text" name="title" class="form-control" required
                                    value="<?php echo $editNews ? htmlspecialchars($editNews['title']) : ''; ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Obsah</label>
                                <textarea name="content" class="form-control" rows="5" required><?php echo $editNews ? htmlspecialchars($editNews['content']) : ''; ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Obrázok</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <?php if($editNews && !empty($editNews['image'])): ?>
                                    <small class="text-secondary">Aktuálny: <?php echo htmlspecialchars($editNews['image']); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi-save me-1"></i>
                                    <?php echo $editNews ? 'Uložiť zmeny' : 'Pridať aktualitu'; ?>
                                </button>
                                <?php if($editNews): ?>
                                    <a href="news.php" class="btn btn-secondary">Zrušiť</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="p-4 rounded" style="background-color: #16213e;">
                    <h5 class="mb-3">Zoznam aktualít (<?php echo count($allNews); ?>)</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titulok</th>
                                    <th>Obsah (náhľad)</th>
                                    <th>Dátum</th>
                                    <th>Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($allNews)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-secondary">Žiadne aktuality</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($allNews as $n): ?>
                                    <tr>
                                        <td><?php echo $n['id']; ?></td>
                                        <td><?php echo htmlspecialchars($n['title']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($n['content'], 0, 60)); ?>...</td>
                                        <td><?php echo date('d.m.Y', strtotime($n['created_at'])); ?></td>
                                        <td>
                                            <a href="news.php?edit=<?php echo $n['id']; ?>" class="btn btn-sm btn-warning me-1">
                                                <i class="bi-pencil"></i>
                                            </a>
                                            <a href="news.php?delete=<?php echo $n['id']; ?>" class="btn btn-sm btn-danger"
                                               onclick="return confirm('Naozaj chceš vymazať túto aktualitu?')">
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