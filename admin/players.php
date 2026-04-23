<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../db.php';
require_once '../PlayerModel.php';

$database = new Database();
$db = $database->connect();
$player = new Player($db);

// VYMAZANIE
if(isset($_GET['delete'])) {
    $player->id = $_GET['delete'];
    
    // Zmaz fotku ak existuje
    $p = $player->getById($player->id);
    if($p && !empty($p['photo'])) {
        @unlink('../uploads/players/' . $p['photo']);
    }
    
    $player->delete();
    header('Location: players.php');
    exit;
}

// PRIDANIE / UPRAVENIE
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $player->name = $_POST['name'];
    $player->position = $_POST['position'];
    $player->jersey_number = $_POST['jersey_number'];
    $player->date_of_birth = $_POST['date_of_birth'];

    // Upload fotky
    if(!empty($_FILES['photo']['name'])) {
        $fileName = time() . '_' . basename($_FILES['photo']['name']);
        $uploadPath = '../uploads/players/' . $fileName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
        $player->photo = $fileName;
    } else {
        $player->photo = $_POST['current_photo'] ?? null;
    }

    if(isset($_POST['id']) && !empty($_POST['id'])) {
        // EDIT
        $player->id = $_POST['id'];
        $player->update();
    } else {
        // CREATE
        $player->create();
    }

    header('Location: players.php');
    exit;
}

// Načítaj hráča na editáciu
$editPlayer = null;
if(isset($_GET['edit'])) {
    $editPlayer = $player->getById($_GET['edit']);
}

$players = $player->getAll();
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hráči | Admin</title>
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
        .sidebar a:hover, .sidebar a.active {
            background-color: #e84545;
        }
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
        .table-dark th, .table-dark td { vertical-align: middle; }
        .form-control, .form-select {
            background-color: #0f3460;
            border: none;
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            background-color: #0f3460;
            color: #fff;
            box-shadow: 0 0 0 2px #e84545;
        }
        .form-select option { background-color: #0f3460; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 px-0 sidebar">
            <div class="brand">
                <i class="bi-shield-lock me-2"></i>Admin Panel
            </div>
            <a href="index.php"><i class="bi-speedometer2 me-2"></i>Dashboard</a>
            <a href="players.php" class="active"><i class="bi-people me-2"></i>Hráči</a>
            <a href="news.php"><i class="bi-newspaper me-2"></i>Aktuality</a>
            <a href="gallery.php"><i class="bi-images me-2"></i>Galéria</a>
            <hr style="border-color: #ffffff22;">
            <a href="/SJ_projekt_LC/index.php"><i class="bi-house me-2"></i>Zobraziť web</a>
            <a href="logout.php"><i class="bi-box-arrow-right me-2"></i>Odhlásiť sa</a>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-md-10 px-0">
            <div class="main-content">
                <div class="top-bar">
                    <h5 class="mb-0">Správa hráčov</h5>
                    <span><i class="bi-person-circle me-2"></i><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                </div>

                <!-- FORM -->
                <div class="p-4 mb-4 rounded" style="background-color: #16213e;">
                    <h5 class="mb-3"><?php echo $editPlayer ? 'Upraviť hráča' : 'Pridať hráča'; ?></h5>
                    <form method="POST" action="players.php" enctype="multipart/form-data">
                        <?php if($editPlayer): ?>
                            <input type="hidden" name="id" value="<?php echo $editPlayer['id']; ?>">
                            <input type="hidden" name="current_photo" value="<?php echo $editPlayer['photo']; ?>">
                        <?php endif; ?>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Meno a priezvisko</label>
                                <input type="text" name="name" class="form-control" required
                                    value="<?php echo $editPlayer ? htmlspecialchars($editPlayer['name']) : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pozícia</label>
                                <select name="position" class="form-select" required>
                                    <option value="">-- Vyber pozíciu --</option>
                                    <?php
                                    $positions = ['Brankár', 'Obranca', 'Záložník', 'Útočník'];
                                    foreach($positions as $pos) {
                                        $selected = ($editPlayer && $editPlayer['position'] === $pos) ? 'selected' : '';
                                        echo "<option value='$pos' $selected>$pos</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Číslo dresu</label>
                                <input type="number" name="jersey_number" class="form-control" min="1" max="99" required
                                    value="<?php echo $editPlayer ? htmlspecialchars($editPlayer['jersey_number']) : ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Dátum narodenia</label>
                                <input type="date" name="date_of_birth" class="form-control"
                                    value="<?php echo $editPlayer ? htmlspecialchars($editPlayer['date_of_birth']) : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fotka hráča</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                                <?php if($editPlayer && !empty($editPlayer['photo'])): ?>
                                    <small class="text-secondary">Aktuálna: <?php echo htmlspecialchars($editPlayer['photo']); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi-save me-1"></i>
                                    <?php echo $editPlayer ? 'Uložiť zmeny' : 'Pridať hráča'; ?>
                                </button>
                                <?php if($editPlayer): ?>
                                    <a href="players.php" class="btn btn-secondary">Zrušiť</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABUĽKA -->
                <div class="p-4 rounded" style="background-color: #16213e;">
                    <h5 class="mb-3">Zoznam hráčov (<?php echo count($players); ?>)</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Meno</th>
                                    <th>Pozícia</th>
                                    <th>Dres</th>
                                    <th>Dátum nar.</th>
                                    <th>Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($players)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-secondary">Žiadni hráči</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($players as $p): ?>
                                    <tr>
                                        <td><?php echo $p['id']; ?></td>
                                        <td>
                                            <?php if(!empty($p['photo'])): ?>
                                                <img src="/SJ_projekt_LC/uploads/players/<?php echo htmlspecialchars($p['photo']); ?>" 
                                                     width="45" height="45" style="border-radius:50%; object-fit:cover;">
                                            <?php else: ?>
                                                <i class="bi-person-circle" style="font-size:2rem;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                                        <td><?php echo htmlspecialchars($p['position']); ?></td>
                                        <td><?php echo htmlspecialchars($p['jersey_number']); ?></td>
                                        <td><?php echo !empty($p['date_of_birth']) ? date('d.m.Y', strtotime($p['date_of_birth'])) : '—'; ?></td>
                                        <td>
                                            <a href="players.php?edit=<?php echo $p['id']; ?>" class="btn btn-sm btn-warning me-1">
                                                <i class="bi-pencil"></i>
                                            </a>
                                            <a href="players.php?delete=<?php echo $p['id']; ?>" class="btn btn-sm btn-danger"
                                               onclick="return confirm('Naozaj chceš vymazať tohto hráča?')">
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