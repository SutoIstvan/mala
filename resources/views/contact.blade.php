@extends('layouts.main')

@section('title', 'Mala.hu - Kapcsolat')

@section('content')

    <div class="container pt-18 pt-md-20 text-center position-relative">
        <div class="position-absolute" style="top: -15%; left: 50%; transform: translateX(-50%);" data-cue="fadeIn"><img
                src="./assets/img/photos/blurry.png" alt=""></div>
        <div class="row position-relative">
            <div class="col-lg-8 col-xxl-7 mx-auto position-relative">
                <div data-cues="slideInDown" data-group="page-title">
                    <h1 class="display-1 fs-64 mb-5 mx-md-10 mx-lg-0 "> <span class="text-primary">Kapcsolat</span>
                        <p class="lead fs-24 mb-8">

                            Vegye fel velünk a kapcsolatot, és beszéljük meg, hogyan segíthetünk Önnek megvalósítani
                            elképzeléseit.

                        </p>
                </div>
            </div>
        </div>
    </div>

    <section class="wrapper upper-end">
        <div class="container pb-11">
            <div class="row mt-14 mt-md-16">
                <div class="col-xl-10 mx-auto ">
                    <div class="card">
                        <div class="row gx-0">
                            <div class="col-lg-6 align-self-stretch">
                                <div class="map map-full rounded-top rounded-lg-start">

                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26862.474839357774!2d18.8296408!3d46.6240236!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4742c56e763b1ff5%3A0xa381d2a3f0d1ff0!2sPaks!5e0!3m2!1shu!2shu!4v1736673311885!5m2!1shu!2shu"
                                        style="width:100%; height: 100%; border:0" allowfullscreen></iframe>
                                </div>
                                <!-- /.map -->
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="p-10 p-md-11 p-lg-14">
                                    <div class="d-flex flex-row">
                                        <div>
                                            <div class="icon text-primary fs-28 me-4 mt-n1"> <i
                                                    class="uil uil-location-pin-alt"></i> </div>
                                        </div>
                                        <div class="align-self-start justify-content-start">
                                            <h5 class="mb-1">Address</h5>
                                            <address>7030 Paks, Vácika köz 1, <br class="d-none d-md-block" />Magyarország
                                            </address>
                                        </div>
                                    </div>
                                    <!--/div -->
                                    <div class="d-flex flex-row">
                                        <div>
                                            <div class="icon text-primary fs-28 me-4 mt-n1"> <i
                                                    class="uil uil-phone-volume"></i> </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">Phone</h5>
                                            <p>+36 (70) 7021 252 <br /></p>
                                        </div>
                                    </div>
                                    <!--/div -->
                                    <div class="d-flex flex-row">
                                        <div>
                                            <div class="icon text-primary fs-28 me-4 mt-n1"> <i
                                                    class="uil uil-envelope"></i> </div>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">E-mail</h5>
                                            <p class="mb-0"><a href="mailto:info@mala.hu"
                                                    class="link-body">info@mala.hu</a></p>
                                            {{-- <p class="mb-0"><a href="mailto:help@mala.com"
                                                    class="link-body">help@mala.hu</a></p> --}}
                                        </div>
                                    </div>
                                    <!--/div -->
                                </div>
                                <!--/div -->
                            </div>
                            <!--/column -->
                        </div>
                        <!--/.row -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2  mt-16 mb-16">

                    <!-- /form -->
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>

@endsection
