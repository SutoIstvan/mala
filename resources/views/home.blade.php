@extends('layouts.main')

@section('title', 'Mala.hu - Főoldal')

@section('content')

<section class="wrapper overflow-hidden">
    <div class="container pt-19 pt-md-21 text-center position-relative">
        <div class="position-absolute" style="top: -15%; left: 50%; transform: translateX(-50%);" data-cue="fadeIn"><img
                src="./assets/img/photos/blurry.png" alt=""></div>
        <div class="row position-relative">
            <div class="col-lg-8 col-xxl-7 mx-auto position-relative">
                <div class="position-absolute shape grape w-5 d-none d-lg-block" style="top: -5%; left: -15%;"
                    data-cue="fadeIn" data-delay="1500"><img src="./assets/img/svg/pie.svg"
                        class="svg-inject icon-svg w-100 h-100" alt="" /></div>
                <div class="position-absolute shape violet w-10 d-none d-lg-block" style="bottom: 30%; left: -20%;"
                    data-cue="fadeIn" data-delay="1500"><img src="./assets/img/svg/scribble.svg"
                        class="svg-inject icon-svg w-100 h-100" alt="" /></div>
                <div class="position-absolute shape fuchsia w-6 d-none d-lg-block"
                    style="top: 0%; right: -25%; transform: rotate(70deg);" data-cue="fadeIn" data-delay="1500">
                    <img src="./assets/img/svg/tri.svg" class="svg-inject icon-svg w-100 h-100" alt="" />
                </div>
                <div class="position-absolute shape yellow w-6 d-none d-lg-block" style="bottom: 25%; right: -17%;"
                    data-cue="fadeIn" data-delay="1500"><img src="./assets/img/svg/circle.svg"
                        class="svg-inject icon-svg w-100 h-100" alt="" /></div>
                <div data-cues="slideInDown" data-group="page-title">
                    <h1 class="display-1 fs-64 mb-5 mx-md-10 mx-lg-0">Egyedi digitális megoldásokat kínálunk
                        <br /><span class="rotator-fade text-primary">Weboldal fejlesztés.,Webshopok
                            kialakítása.,Szoftverfejlesztés.,Webshop Audit.</span>
                    </h1>
                    <p class="lead fs-24 mb-8">
                        <img src="https://unas.hu/!common_design/own/image/page/arculati-kezikonyv/unas-logo-gray.png?version=1323"
                            height="28px" alt="">

                        <br>

                        Unas szakértők vagyunk

                        <!-- Az innováció és a kreatív gondolkodás hajt minket, hogy valós eredményeket érjünk el. -->

                    </p>
                </div>
                <div class="d-flex justify-content-center" data-cues="slideInDown" data-delay="600">
                    <span><a href="{{ route('references') }}" class="btn btn-lg btn-primary rounded-xl mx-1">Referenciák</a></span>
                    <span><a href="{{ route('request') }}" class="btn btn-lg btn-fuchsia rounded-xl mx-1">Ajánlatkérés</a></span>
                </div>
                <!-- /div -->
            </div>
            <!-- /column -->
        </div>
        <!-- /.row -->
    </div>

    <!-- /.container -->
    <div class="container pt-20">
        <div class="row">
            <div class="col-md-11 col-lg-8 col-xl-7 col-xxl-6 mx-auto text-center">
                <h2 class="display-2 mb-4">Szolgáltatásaink</h2>
                <p class="lead fs-lg mb-11">Szolgáltatásaink rövid leírása ügyfeleink számára</p>
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
                    Egyedi arculat / kinézet<br> tervezése és keszitése<br>
                    Kategóriák kialakítása<br>
                </p>
                <!--<a href="#" class="more hover">További információ</a>-->
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
                <!--<a href="#" class="more hover">További információ</a>-->
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
                <!--<a href="#" class="more hover">További információ</a>-->
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
                <!--<a href="#" class="more hover">További információ</a>-->
            </div>
            <!--/column -->
        </div>
        <!--/.row -->
    </div>
    <!-- /.container -->

    <section class="wrapper bg-soft-primary overflow-hidden" id="demos">
        <div class="container pt-16 pt-mb-18">
            <div class="row mb-10">
                <div class="col-md-9 col-lg-8 col-xl-7 col-xxl-6 mx-auto">

                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="demos-wrapper text-center mb-4 mb-md-6">
                <div class="col-md-11 col-lg-8 col-xl-7 col-xxl-6 mx-auto text-center">
                    <h2 class="display-2 mb-4">Legutóbbi munkáink</h2>
                    <p class="lead fs-lg mb-11">Tekintse meg projektjeinket, amelyek során ügyfeleink egyedi
                        igényeire szabott megoldásokat valósítottunk meg.</p>
                </div>

                <!-- <h2 class="lead fs-24 text-muted mb-6">Legutóbbi munkáink</h2> -->
                <div class="row mb-10 gx-md-8 gy-12">
                    <div class="col-md-6 col-lg-4">
                        <figure class="lift rounded-xl mb-6"><a href="" target=""><img class="shadow-xl"
                                    src="./assets/img/photos/w1.png" alt="" /></a>
                        </figure>
                        <h2 class="fs-18 mb-0"><a href="" class="link-dark">Paksi informatika</a></h2>
                    </div>
                    <!-- /column -->
                    <div class="col-md-6 col-lg-4">
                        <figure class="lift rounded-xl mb-6"><a href="" target=""><img class="shadow-xl"
                                    src="./assets/img/photos/w22.png" alt="" /></a>
                        </figure>
                        <h2 class="fs-18 mb-0"><a href="" class="link-dark">Marka motor</a></h2>
                    </div>
                    <!-- /column -->
                    <div class="col-md-6 col-lg-4">
                        <figure class="lift rounded-xl mb-6"><a href="" target=""><img class="shadow-xl"
                                    src="./assets/img/photos/w33.png" alt="" /></a>
                        </figure>
                        <h2 class="fs-18 mb-0"><a href="" class="link-dark">Human regen</a></h2>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- /section -->
    <section class="wrapper overflow-hidden">
        <div class="container py-15 py-md-17">
            <div class="row">
                <div class="col-md-11 col-lg-8 col-xl-7 col-xxl-6 mx-auto text-center">
                    <h2 class="display-2 mb-4">Ami megkülönböztet minket</h2>
                    <p class="lead fs-lg mb-11">Az innovatív ötleteink és a modern technológia ötvözése, amely
                        testreszabott
                        megoldásokat kínál ügyfeleink számára.</p>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->

            <div class="row gx-lg-0 gy-10 align-items-center">
                <div class="col-lg-7 position-relative order-lg-2">
                    <div class="position-absolute"
                        style="top: 50%; left: 50%; width: 140%; height: auto; transform: translate(-50%,-50%); z-index: -1">
                        <img class="w-100" src="./assets/img/photos/blurry.png" alt="">
                    </div>
                    <figure><img src="./assets/img/photos/mi2.png" srcset="./assets/img/photos/mi2@2x.png 2x"
                            alt="" />
                    </figure>
                </div>
                <!--/column -->
                <div class="col-lg-4 me-auto">
                    <h2 class="display-5 mb-2 mt-xxl-n10">Fejlesztés</h2>
                    <p class="mb-8"></p>
                    <div class="d-flex flex-row mb-6">
                        <div>
                            <div class="svg-bg bg-white rounded-xl shadow-xl me-5"> <img
                                    src="./assets/img/icons/solid/devices.svg"
                                    class="svg-inject icon-svg solid-duo text-grape-fuchsia" alt="" />
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-1">Testreszabott megoldások:</h4>
                            <p class="mb-0">Minden projektünket az ügyfeleink egyedi igényeire szabjuk.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row mb-6">
                        <div>
                            <div class="svg-bg bg-white rounded-xl shadow-xl me-5"> <img
                                    src="./assets/img/icons/solid/safe.svg"
                                    class="svg-inject icon-svg solid-duo text-grape-fuchsia" alt="" />
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-1">Szakértői csapat:</h4>
                            <p class="mb-0">Tapasztalt csapatunk kreatív megoldásokkal és technológiai
                                tudással segítik a
                                projektek megvalósítását.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <div>
                            <div class="svg-bg bg-white rounded-xl shadow-xl me-5"> <img
                                    src="./assets/img/icons/solid/globe-2.svg"
                                    class="svg-inject icon-svg solid-duo text-grape-fuchsia" alt="" />
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-1">Gyors és rugalmas megvalósítás:</h4>
                            <p class="mb-0">Gyorsan reagálunk a változásokra, így ügyfeleink mindig naprakész
                                információkat kapnak
                                a projekt állapotáról.</p>
                        </div>
                    </div>
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
        </div>
        <!-- /.container -->


        <!-- /.swiper-container -->

    </section>
    <!-- /section -->
    <section class="wrapper pattern-wrapper bg-image section-frame" data-image-src="./assets/img/pattern.png">
        <div class="container py-14 pt-md-16 pt-lg-0 pb-md-12">

            <!--/.row -->
            <div class="row gx-md-8 gx-lg-12 gy-6 gy-lg-0 mb-13">
                <div class="col-lg-6 mt-16">
                    <h1 class="display-2 mb-0 text-white">Érdeklődni szeretne, vagy már konkrét elképzelése
                        van, hogy mit
                        kíván megvalósítani?</h1>
                </div>
                <!-- /column -->
                <div class="col-lg-6 mt-16">
                    <p class="lead fs-lg mb-3 text-inverse">Nyugodtan hívjon minket a megadott
                        <br>telefonszámon +36 70 7021
                        252, <br>vagy írja meg kívánságait a megadott email címre info@mala.hu. <br>Munkatársunk
                        mielőbb felveszi
                        Önnel a kapcsolatot, hogy segíthessen a projektje megvalósításában!
                    </p>
                    <!-- <a href="#" class="more link-white hover">Kapcsolat</a> -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
    <section class="overflow-hidden">
        <div class="container pt-16 pt-md-18 pb-20 pb-md-18">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center mb-15 mb-md-17">
                <div class="col-lg-7 position-relative">
                    <div class="position-absolute d-none d-md-block"
                        style="top: 50%; left: 50%; width: 130%; height: auto; transform: translate(-50%,-50%); z-index:-1">
                        <img class="w-100" src="./assets/img/photos/blurry.png" alt="">
                    </div>
                    <div class="row gx-md-5 gy-5">
                        <div class="col-md-6 col-xl-5 align-self-end">
                            <div class="card shadow-xl rounded-xl">
                                <div class="card-body">
                                    <blockquote class="icon mb-0">
                                        <p>“Én nagyon meg voltam elégedve a honlap fejlesztése gyors és rugalmas
                                            volt. Szakmailag magas színvonalon, baráti hangulatban zajlott a
                                            közös munka. Sok ötlettel segített a korszerű végeredményt elérni.
                                            Én mindenkinek bátran ajánlanám”</p>
                                        <div class="blockquote-details">
                                            <div class="info p-0">
                                                <h5 class="mb-1">Márkus László</h5>
                                                <p class="mb-0">Márkamotor</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!--/.card -->
                        </div>
                        <!--/column -->
                        <div class="col-md-6 align-self-end">
                            <div class="card shadow-xl rounded-xl">
                                <div class="card-body">
                                    <blockquote class="icon mb-0">
                                        <p>“Weboldalunk átalakítása kiemelkedő színvonalon valósult meg. A régi
                                            verzióhoz képest hatalmas előrelépés történt mind dizájn, mind
                                            funkcionalitás terén. Az új felület modern, letisztult és könnyen
                                            kezelhető, ami nagyban hozzájárul a felhasználói élményhez.
                                            A fejlesztés során minden részletre odafigyeltek, így egy igazán
                                            professzionális, korszerű és megbízható weboldal született.
                                            Csak ajánlani tudjuk mindazoknak, akik magas színvonalú webes
                                            megoldásokat keresnek!”</p>
                                        <div class="blockquote-details">
                                            <div class="info p-0">
                                                <h5 class="mb-1">Lazók Norbert</h5>
                                                <p class="mb-0">N+T Kft</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!--/.card -->
                        </div>
                        <!--/column -->
                        <div class="col-md-6 col-xl-5 offset-xl-1">
                            <div class="card shadow-xl rounded-xl">
                                <div class="card-body">
                                    <blockquote class="icon mb-0">
                                        <p>“Cégünk számára kiemelten fontos a stabil és hatékony online
                                            jelenlét, ezért örömmel választottuk a mala.hu csapatát
                                            webfejlesztési és integrációs feladatainkhoz. A velük való
                                            együttműködés során egyértelművé vált, hogy valódi szakértőkkel
                                            dolgozunk, akik nemcsak gyorsan és precízen végzik a munkájukat,
                                            hanem valódi üzleti értéket teremtenek..”</p>
                                        <div class="blockquote-details">
                                            <div class="info p-0">
                                                <h5 class="mb-1">Dari Zoltán </h5>
                                                <p class="mb-0">Paksi Informatika</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!--/.card -->
                        </div>
                        <!--/column -->
                        <div class="col-md-6 align-self-start">
                            <div class="card shadow-xl rounded-xl">
                                <div class="card-body">
                                    <blockquote class="icon mb-0">
                                        <p>“A humanregen.hu egy egyedi és innovatív szolgáltatást nyújt, ezért
                                            különösen fontos volt számunkra, hogy a weboldal funkcionalitása és
                                            megjelenése tökéletesen tükrözze ezt a különlegességet. Az egyedi
                                            foglalási rendszer és a könnyen kezelhető adminisztrációs felület
                                            biztosítja a hatékony működést mind az ügyfelek, mind az üzemeltetők
                                            számára.

                                            Örömmel ajánljuk szolgáltatásainkat mindazoknak, akik
                                            professzionális, modern és megbízható webes megoldásokat keresnek!”
                                        </p>
                                        <div class="blockquote-details">
                                            <div class="info p-0">
                                                <h5 class="mb-1">Humanregen</h5>
                                                <p class="mb-0">Humanregen.hu</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!--/.card -->
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/column -->


                <div class="col-lg-5">
                    <h2 class="display-2 mb-2 mt-lg-n6">Rólunk mondták</h2>
                    <p class="lead fs-lg mb-4">Ügyfeleink véleménye számunkra rendkívül fontos. Íme néhány
                        gondolat, amit
                        rólunk mondanak:</p>
                    <p class="lead fs-lg mb-4">Csatlakozzon Ön is elégedett ügyfeleinkhez!</p>
                    {{-- <a href="#" class="btn btn-primary rounded-xl mt-3">Írja meg véleményét</a> --}}
                </div>
                <!--/column -->
            </div>

            <!--/.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
</section>

@endsection