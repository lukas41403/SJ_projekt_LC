<?php session_start(); ?>
<!doctype html>
<html lang="sk">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="FC Výčapy-Opatovce - oficiálna webová stránka">
        <meta name="author" content="FC Výčapy-Opatovce">

        <title>FC Výčapy-Opatovce</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">
        <link href="/SJ_projekt_LC/css/bootstrap.min.css" rel="stylesheet">
        <link href="/SJ_projekt_LC/css/bootstrap-icons.css" rel="stylesheet">
        <link href="/SJ_projekt_LC/css/templatemo-festava-live.css" rel="stylesheet">
    </head>

    <body>
        <main>

            <header class="site-header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 d-flex flex-wrap">
                            <p class="d-flex me-4 mb-0">
                                <i class="bi-person custom-icon me-2"></i>
                                <strong class="text-dark">Vitajte na stránke FC Výčapy-Opatovce</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="/SJ_projekt_LC/index.php">
                        FC Výčapy-Opatovce
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
                            <li class="nav-item">
                                <a class="nav-link" href="/SJ_projekt_LC/index.php">Domov</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/SJ_projekt_LC/players.php">Hráči</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/SJ_projekt_LC/matches.php">Zápasy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/SJ_projekt_LC/news.php">Aktuality</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/SJ_projekt_LC/gallery.php">Galéria</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/SJ_projekt_LC/about.php">O klube</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/SJ_projekt_LC/contact.php">Kontakt</a>
                            </li>
                        </ul>

                        <a href="/SJ_projekt_LC/admin/login.php" class="btn custom-btn d-lg-block d-none">Admin</a>
                    </div>
                </div>
            </nav>