<?php
require_once 'db.php';
require_once 'newsModel.php';

$database = new Database();
$db = $database->connect();
$news = new News($db);
$allNews = $news->getAll();
?>

<?php require_once 'partials/header.php'; ?>

<section class="pricing-section section-padding section-bg">
    <div class="container">
        <div class="row">

            <div class="col-12 text-center mb-5">
                <h2>Aktuality</h2>
                <p class="text-muted">Najnovšie správy z klubu FC Výčapy-Opatovce</p>
            </div>

            <?php if(empty($allNews)): ?>
                <div class="col-12 text-center">
                    <p class="text-white">Žiadne aktuality nie sú zatiaľ pridané.</p>
                </div>
            <?php else: ?>
                <?php foreach($allNews as $n): ?>
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="pricing-thumb">
                        <?php if(!empty($n['image'])): ?>
                            <img src="/SJ_projekt_LC/uploads/news/<?php echo htmlspecialchars($n['image']); ?>" 
                                 class="img-fluid mb-3 w-100" style="border-radius:8px; height:200px; object-fit:cover;">
                        <?php endif; ?>
                        <h5><?php echo htmlspecialchars($n['title']); ?></h5>
                        <p class="text-muted small">
                            <i class="bi-calendar me-1"></i>
                            <?php echo date('d.m.Y', strtotime($n['created_at'])); ?>
                        </p>
                        <p><?php echo htmlspecialchars($n['content']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>