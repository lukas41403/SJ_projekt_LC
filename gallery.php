<?php
require_once 'db.php';
require_once 'GalleryModel.php';

$database = new Database();
$db = $database->connect();
$gallery = new Gallery($db);
$allPhotos = $gallery->getAll();
?>

<?php require_once 'partials/header.php'; ?>

<section class="section-padding">
    <div class="container">
        <div class="row">

            <div class="col-12 text-center mb-5">
                <h2>Galéria</h2>
                <p class="text-muted">Fotografie z klubu a zápasov</p>
            </div>

            <?php if(empty($allPhotos)): ?>
                <div class="col-12 text-center">
                    <p class="text-white">Galéria je prázdna.</p>
                </div>
            <?php else: ?>
                <?php foreach($allPhotos as $p): ?>
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="artists-thumb">
                        <div class="artists-image-wrap">
                            <img src="/SJ_projekt_LC/uploads/gallery/<?php echo htmlspecialchars($p['filename']); ?>" 
                                 class="artists-image img-fluid" style="height:250px; object-fit:cover;">
                        </div>
                        <div class="artists-hover">
                            <p><strong><?php echo htmlspecialchars($p['title']); ?></strong></p>
                            <p class="text-muted small"><?php echo date('d.m.Y', strtotime($p['created_at'])); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>