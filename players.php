<?php
require_once 'db.php';
require_once 'PlayerModel.php';

$database = new Database();
$db = $database->connect();
$player = new Player($db);
$players = $player->getAll();
?>

<?php require_once 'partials/header.php'; ?>

<section class="artists-section section-padding">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 text-center mb-5">
                <h2>Naši hráči</h2>
                <p class="text-muted">Zoznámte sa s tímom FC Výčapy-Opatovce</p>
            </div>

            <?php if(empty($players)): ?>
                <div class="col-12 text-center">
                    <p class="text-white">Žiadni hráči nie sú zatiaľ pridaní.</p>
                </div>
            <?php else: ?>
                <?php foreach($players as $p): ?>
                <div class="col-lg-3 col-md-6 col-12 mb-4">
                    <div class="artists-thumb">
                        <div class="artists-image-wrap">
                            <?php if(!empty($p['photo'])): ?>
                                <img src="/SJ_projekt_LC/uploads/players/<?php echo htmlspecialchars($p['photo']); ?>" 
                                     class="artists-image img-fluid">
                            <?php else: ?>
                                <img src="/SJ_projekt_LC/images/pexels-alexander-suhorucov-6457579.jpg" 
                                     class="artists-image img-fluid">
                            <?php endif; ?>
                        </div>
                        <div class="artists-hover">
                            <p>
                                <strong>Meno:</strong>
                                <?php echo htmlspecialchars($p['name']); ?>
                            </p>
                            <p>
                                <strong>Pozícia:</strong>
                                <?php echo htmlspecialchars($p['position']); ?>
                            </p>
                            <p>
                                <strong>Číslo dresu:</strong>
                                <?php echo htmlspecialchars($p['jersey_number']); ?>
                            </p>
                            <?php if(!empty($p['date_of_birth'])): ?>
                            <p>
                                <strong>Dátum nar.:</strong>
                                <?php echo date('d.m.Y', strtotime($p['date_of_birth'])); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>