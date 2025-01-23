<footer class="wrapper pattern-wrapper bg-image section-frame" data-image-src="./assets/img/pattern.png">
    <div class="container pb-13 pb-md-15">
        <div class="card image-wrapper bg-full bg-image bg-overlay mt-n50p mx-md-5 rounded-xl overflow-hidden"
            data-image-src="./assets/img/photos/bg27.jpg">
            <div
                class="card-body p-6 p-md-11 d-lg-flex flex-row align-items-lg-center justify-content-md-between text-center text-lg-start">
                <h3 class="display-2 mb-6 mb-lg-0 pe-lg-10 pe-xl-5 pe-xxl-18 text-white">Ha felkeltettük
                    érdeklődését, kérjen
                    ajánlatot most!</h3>
                <a href="{{ route('request') }}" class="btn btn-lg btn-white rounded-xl mb-0 text-nowrap">Ajánlat kérés</a>
            </div>
            <!--/.card-body -->
        </div>
        <!--/.card -->
        <div class="text-inverse mx-md-5 mt-n15 mt-lg-0">
            <div class="row gy-6 gy-lg-0">
                <div class="col-lg-4">
                    <div class="widget">
                        <h3 class="h2 mb-3 text-white">Digitális megoldások</h3>
                        <p class="mb-5">Az innováció és a kreatív gondolkodás hajt minket, hogy valós
                            eredményeket érjünk el.</p>
                        <p class="mb-1">© Mala.HU 2025 All rights reserved.</p>
                        <nav class="nav social social-white">
                            <a href="#"><i class="uil uil-twitter"></i></a>
                            <a href="#"><i class="uil uil-facebook-f"></i></a>
                            <a href="#"><i class="uil uil-dribbble"></i></a>
                            <a href="#"><i class="uil uil-instagram"></i></a>
                            <a href="#"><i class="uil uil-youtube"></i></a>
                        </nav>
                        <!-- /.social -->
                    </div>
                    <!-- /.widget -->
                </div>

                <!-- /column -->
                <div class="col-md-4 col-lg-2 offset-lg-2">
                    <div class="widget">
                        <h4 class="widget-title text-white mb-3">Szolgáltatások</h4>
                        <ul class="list-unstyled text-reset mb-0">
                            <li><a href="#">Weboldal fejlesztés</a></li>
                            <li><a href="#">Webshopok kialakítása</a></li>
                            <li><a href="#">Szoftverfejlesztés</a></li>
                            <li><a href="#">Webshop Audit</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /column -->
                <div class="col-md-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title text-white mb-3">Linkek</h4>
                        <ul class="list-unstyled  mb-0">
                            <li><a href="{{ route('home') }}">Főoldal</a></li>
                            <li><a href="{{ route('request') }}">Ajánlat kérés</a></li>
                            <li><a href="{{ route('references') }}">Referenciák</a></li>
                            <li><a href="{{ route('contact') }}">Kapcsolat</a></li>

                        </ul>
                    </div>
                    <!-- /.widget -->
                </div>
                <!-- /column -->
                <div class="col-md-4 col-lg-2">
                    <div class="widget">
                        <h4 class="widget-title text-white mb-3">Cím</h4>
                        <address>7030 Paks, Vácika köz 1, Magyarország</address>
                        <a href="mailto:first.last@email.com">info@mala.hu</a><br> +36 70 7021 252
                    </div>
                    <!-- /.widget -->
                </div>
                <!-- /column -->
            </div>
            <!--/.row -->
        </div>
    </div>
    <!-- /.container -->
</footer>