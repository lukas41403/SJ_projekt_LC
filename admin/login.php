<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

require_once '../db.php';
$database = new Database();
$db = $database->connect();

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $db->prepare('SELECT * FROM admins WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Nesprávne meno alebo heslo!';
    }
}
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prihlásenie | Admin</title>
    <link href="/SJ_projekt_LC/css/bootstrap.min.css" rel="stylesheet">
    <link href="/SJ_projekt_LC/css/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #1a1a2e;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background-color: #16213e;
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
        }
        .login-box h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
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
        .btn-login {
            background-color: #e84545;
            color: #fff;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
        }
        .btn-login:hover {
            background-color: #c73535;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2><i class="bi-shield-lock me-2"></i>Admin Panel</h2>
        <p class="text-center text-secondary mb-4">FC Výčapy-Opatovce</p>

        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label class="form-label text-white">Používateľské meno</label>
                <input type="text" name="username" class="form-control"
                       placeholder="admin" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label text-white">Heslo</label>
                <input type="password" name="password" class="form-control"
                       placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="bi-box-arrow-in-right me-2"></i>Prihlásiť sa
            </button>
        </form>
    </div>

    <script src="/SJ_projekt_LC/js/bootstrap.min.js"></script>
</body>
</html>