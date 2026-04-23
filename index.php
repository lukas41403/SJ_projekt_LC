<?php require_once 'partials/header.php'; ?>

<!-- HERO SEKCIA -->
<section class="hero-section" id="section_1">
    <div class="section-overlay"></div>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="row">

            <div class="col-12 mt-auto mb-5 text-center">
                <small>Vitajte na oficiálnej stránke</small>
                <h1 class="text-white mb-5">FC Výčapy-Opatovce</h1>
                <a class="btn custom-btn smoothscroll" href="#section_2">Zistiť viac</a>
            </div>

            <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
                <div class="location-wrap mx-auto py-3 py-lg-0">
                    <h5 class="text-white">
                        <i class="custom-icon bi-geo-alt me-2"></i>
                        Výčapy-Opatovce, Slovensko
                    </h5>
                </div>

                <div class="social-share">
                    <ul class="social-icon d-flex align-items-center justify-content-center">
                        <span class="text-white me-3">Sledujte nás:</span>
                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link"><span class="bi-facebook"></span></a>
                        </li>
                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link"><span class="bi-instagram"></span></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="video-wrap">
        <video autoplay loop muted class="custom-video" poster="">
            <source src="video/pexels-2022395.mp4" type="video/mp4">
            Váš prehliadač nepodporuje video.
        </video>
    </div>
</section>

<!-- O KLUBE -->
<section class="about-section section-padding" id="section_2">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-12 mb-4 mb-lg-0 d-flex align-items-center">
                <div class="services-info">
                    <h2 class="text-white mb-4">O FC Výčapy-Opatovce</h2>
                    <p class="text-white">FC Výčapy-Opatovce je futbalový klub zo Slovenska s dlhoročnou tradíciou. Klub združuje hráčov všetkých vekových kategórií.</p>
                    <h6 class="text-white mt-4">Naša história</h6>
                    <p class="text-white">Klub má bohatú históriu v slovenskom amatérskom futbale a aktívne sa zúčastňuje regionálnych súťaží.</p>
                    <h6 class="text-white mt-4">Náš cieľ</h6>
                    <p class="text-white">Rozvíjať futbal v obci a vychovávať mladých talentovaných hráčov.</p>
                </div>
            </div>

            <div class="col-lg-6 col-12">
                <div class="about-text-wrap">
                    <img src="/SJ_projekt_LC/images/pexels-alexander-suhorucov-6457579.jpg" class="about-image img-fluid">
                    <div class="about-text-info d-flex">
                        <div class="d-flex">
                            <i class="about-text-icon bi-trophy"></i>
                        </div>
                        <div class="ms-4">
                            <h3>Náš klub</h3>
                            <p class="mb-0">Hráme pre radosť z futbalu a pre našich fanúšikov</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- HRÁČI - náhľad -->
<section class="artists-section section-padding" id="section_3">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 text-center mb-4">
                <h2>Naši hráči</h2>
                <p class="text-muted">Spoznajte náš tím</p>
            </div>

            <?php
            require_once 'db.php';
            require_once 'Player.php';

            $database = new Database();
            $db = $database->connect();
            $player = new Player($db);
            $players = $player->getAll();

            $count = 0;
            foreach($players as $p) {
                if($count >= 4) break;
                echo '
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="artists-thumb">
                        <div class="artists-image-wrap">
                            <img src="' . (!empty($p['photo']) ? '/SJ_projekt_LC/uploads/players/' . htmlspecialchars($p['photo']) : '/SJ_projekt_LC/images/no-image.jpg') . '" class="artists-image img-fluid">
                        </div>
                        <div class="artists-hover">
                            <p><strong>Meno:</strong> ' . htmlspecialchars($p['name']) . '</p>
                            <p><strong>Pozícia:</strong> ' . htmlspecialchars($p['position']) . '</p>
                            <p><strong>Číslo dresu:</strong> ' . htmlspecialchars($p['jersey_number']) . '</p>
                        </div>
                    </div>
                </div>';
                $count++;
            }

            if(empty($players)) {
                echo '<div class="col-12 text-center"><p class="text-white">Hráči budú pridaní čoskoro.</p></div>';
            }
            ?>

            <div class="col-12 text-center mt-4">
                <a href="/SJ_projekt_LC/players.php" class="btn custom-btn">Zobraziť všetkých hráčov</a>
            </div>

        </div>
    </div>
</section>

<!-- AKTUALITY - náhľad -->
<section class="pricing-section section-padding section-bg" id="section_4">
    <div class="container">
        <div class="row">

            <div class="col-12 text-center mb-4">
                <h2>Najnovšie aktuality</h2>
                <p class="text-muted">Správy z klubu</p>
            </div>

            <?php
            require_once 'NewsModel.php';

            $news = new News($db);
            $latestNews = $news->getLatest(3);

            foreach($latestNews as $n) {
                echo '
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="pricing-thumb">
                        <h5>' . htmlspecialchars($n['title']) . '</h5>
                        <p class="text-muted small">' . date('d.m.Y', strtotime($n['created_at'])) . '</p>
                        <p>' . htmlspecialchars(substr($n['content'], 0, 100)) . '...</p>
                    </div>
                </div>';
            }

            if(empty($latestNews)) {
                echo '<div class="col-12 text-center"><p>Žiadne aktuality.</p></div>';
            }
            ?>

            <div class="col-12 text-center mt-4">
                <a href="/SJ_projekt_LC/news.php" class="btn custom-btn">Všetky aktuality</a>
            </div>

        </div>
    </div>
</section>

<!-- KONTAKT -->
<section class="contact-section section-padding" id="section_5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <h2 class="text-center mb-4">Kontaktujte nás</h2>

                <nav class="d-flex justify-content-center">
                    <div class="nav nav-tabs align-items-baseline justify-content-center" id="nav-tab" role="tablist">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#nav-ContactForm" type="button" role="tab">
                            <h5>Kontaktný formulár</h5>
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#nav-ContactMap" type="button" role="tab">
                            <h5>Google Maps</h5>
                        </button>
                    </div>
                </nav>

                <div class="tab-content shadow-lg mt-5">
                    <div class="tab-pane fade show active" id="nav-ContactForm" role="tabpanel">
                        <form class="custom-form contact-form mb-5 mb-lg-0" action="#" method="post">
                            <div class="contact-form-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="text" name="contact-name" class="form-control" placeholder="Celé meno" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <input type="email" name="contact-email" class="form-control" placeholder="Email adresa" required>
                                    </div>
                                </div>
                                <input type="text" name="contact-subject" class="form-control" placeholder="Predmet">
                                <textarea name="contact-message" rows="3" class="form-control" placeholder="Správa"></textarea>
                                <div class="col-lg-4 col-md-10 col-8 mx-auto">
                                    <button type="submit" class="form-control">Odoslať správu</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="nav-ContactMap" role="tabpanel">
                        <iframe class="google-map"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2638.5!2d18.1!3d48.4!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zVsO9xI1hcHktT3BhdG92Y2U!5e0!3m2!1ssk!2ssk!4v1234567890"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>