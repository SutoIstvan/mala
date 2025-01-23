@extends('layouts.main')

@section('title', 'Mala.hu - Szolgáltatások')

@section('content')

    <section class="wrapper overflow-hidden">
        <div class="container pt-18 pt-md-20 text-center position-relative">
            <div class="position-absolute" style="top: -15%; left: 50%; transform: translateX(-50%);" data-cue="fadeIn"><img
                    src="./assets/img/photos/blurry.png" alt=""></div>
            <div class="row position-relative">
                <div class="col-lg-8 col-xxl-7 mx-auto position-relative">

                    <div data-cues="slideInDown" data-group="page-title">
                        <h1 class="display-1 fs-64 mb-5 mx-md-10 mx-lg-0 "> <span
                                class="text-primary">Szolgáltatásaink</span>
                            <p class="lead fs-24 mb-8">

                                Szolgáltatásaink rövid leírása ügyfeleink számára

                            </p>
                    </div>

                    <!-- /div -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>


        <section class="wrapper bg-soft-primary overflow-hidden" id="demos">

            <!-- /.container -->
            <div class="container pt-10 pb-20">
                <div class="row">
                    <div class="col-md-11 col-lg-8 col-xl-7 col-xxl-6 mx-auto text-center">
                        <p class="lead fs-lg mb-11"></p>
                    </div>
                    <!-- /column -->
                </div>
                <!-- /.row -->
                <div class="row gx-md-8 gy-8 text-center mb-8 mb-md-10">
                    <div class="col-md-6 col-lg-3">
                        <div class="svg-bg svg-bg-lg bg-white rounded-xl shadow-xl mb-6"> <img
                                src="./assets/img/icons/solid/pen-tool.svg"
                                class="svg-inject icon-svg solid-duo text-grape-fuchsia" alt="" /> </div>
                        <h3>Webshopok kialakítása</h3>
                        <p class="mb-3">
                            Bérelhető webshopok kialakítása<br>
                            Egyedi template készítése<br>
                            Kategóriák kialakítása<br>
                            Termékparaméterek kialakítása
                        </p>
                        <!-- <a href="#" class="more hover">További információ</a> -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-lg-3">
                        <div class="svg-bg svg-bg-lg bg-white rounded-xl shadow-xl mb-6"> <img
                                src="./assets/img/icons/solid/script.svg"
                                class="svg-inject icon-svg solid-duo text-grape-fuchsia" alt="" /> </div>
                        <h3>Szoftverfejlesztés</h3>
                        <p class="mb-3">
                            Egyedi megoldások webshopba illesztése<br>
                            Adatmigráláshoz konvertáló programok készítése
                        </p>
                        <!-- <a href="#" class="more hover">További információ</a> -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-lg-3">
                        <div class="svg-bg svg-bg-lg bg-white rounded-xl shadow-xl mb-6"> <img
                                src="./assets/img/icons/solid/shopping-basket.svg"
                                class="svg-inject icon-svg solid-duo text-grape-fuchsia" alt="" /> </div>
                        <h3>Teljeskörű webshop audit</h3>
                        <p class="mb-3">
                            Keresőbarát megjelenés<br>

                            Webshop sebesség optimalizálása<br>
                            Webshop biztonságának ellenőrzése

                        </p>
                        <!-- <a href="#" class="more hover">További információ</a> -->
                    </div>
                    <!--/column -->
                    <div class="col-md-6 col-lg-3">
                        <div class="svg-bg svg-bg-lg bg-white rounded-xl shadow-xl mb-6"> <img
                                src="./assets/img/icons/solid/server.svg"
                                class="svg-inject icon-svg solid-duo text-grape-fuchsia" alt="" /> </div>
                        <h3>Webshop költöztetés</h3>
                        <p class="mb-3">
                            Termékek migrálása<br>
                            Kategóriák migrálása<br>
                            Blog bejegyzések migrálása<br>
                            Kinézet átmásolása
                        </p>
                        <!-- <a href="#" class="more hover">További információ</a> -->
                    </div>
                    <!--/column -->
                </div>
                <!--/.row -->
            </div>
            <!-- /.container -->

        </section>

    </section>

@endsection
