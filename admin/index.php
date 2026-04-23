<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | FC Výčapy-Opatovce</title>
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
        .sidebar a:hover { background-color: #e84545; }
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
        .card-stat {
            border: none;
            border-radius: 10px;
            padding: 25px;
            color: #fff;
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
            <a href="gallery.php"><i class="bi-images me-2"></i>Galéria</a>
            <hr style="border-color: #ffffff22;">
            <a href="/SJ_projekt_LC/index.php"><i class="bi-house me-2"></i>Zobraziť web</a>
            <a href="logout.php"><i class="bi-box-arrow-right me-2"></i>Odhlásiť sa</a>
        </div>

        <div class="col-md-10 px-0">
            <div class="main-content">
                <div class="top-bar">
                    <h5 class="mb-0">Dashboard</h5>
                    <span>
                        <i class="bi-person-circle me-2"></i>
                        <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                    </span>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card-stat" style="background-color: #e84545;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>Hráči</h6>
                                    <h2 class="mb-0">
                                        <?php
                                        require_once '../db.php';
                                        $database = new Database();
                                        $db = $database->connect();
                                        echo $db->query('SELECT COUNT(*) FROM players')->fetchColumn();