<?php require_once 'partials/header.php'; ?>

<section class="contact-section section-padding">
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

                <div class="row mt-5">
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <div class="pricing-thumb text-center">
                            <i class="bi-geo-alt" style="font-size:2rem; color:#e84545;"></i>
                            <h5 class="mt-3">Adresa</h5>
                            <p class="text-muted">Výčapy-Opatovce, Slovensko</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <div class="pricing-thumb text-center">
                            <i class="bi-telephone" style="font-size:2rem; color:#e84545;"></i>
                            <h5 class="mt-3">Telefón</h5>
                            <p class="text-muted">+421 000 000 000</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <div class="pricing-thumb text-center">
                            <i class="bi-envelope" style="font-size:2rem; color:#e84545;"></i>
                            <h5 class="mt-3">Email</h5>
                            <p class="text-muted">info@fcvycapy.sk</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php require_once 'partials/footer.php'; ?>