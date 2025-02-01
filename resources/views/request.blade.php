@extends('layouts.main')

@section('title', 'Mala.hu - Ajánlat kérés')

@section('content')

    <section class="wrapper overflow-hidden">
        <div class="container pt-18 pt-md-20 text-center position-relative">
            <div class="position-absolute" style="top: -15%; left: 50%; transform: translateX(-50%); z-index: -1;" data-cue="fadeIn"><img
                    src="./assets/img/photos/blurry.png" alt=""></div>
            <div class="row position-relative">
                <div class="col-lg-8 col-xxl-7 mx-auto position-relative">
                    <div data-cues="slideInDown" data-group="page-title">
                        <h1 class="display-1 fs-64 mb-5 mx-md-10 mx-lg-0 "> <span class="text-primary">Ajánlatkérés</span>
                            <p class="lead fs-24 mb-8">

                                Kérjük, ne habozzon felvenni velünk a kapcsolatot ajánlatkérés céljából!

                            </p>
                    </div>
                </div>
            </div>
        </div>




        <section class="wrapper upper-end">
            <div class="container pb-11">

                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2  mt-16 mb-16">
                        <p class="lead text-center mb-10">Töltse ki az alábbi mezőket, és munkatársaink hamarosan felkeresik
                            Önt a részletekkel.
                        </p>

                        <form class="contact-form needs-validation" method="post" action="{{ route('contact.submit') }}" novalidate>
                            @csrf

                            <div class="messages">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </div>
                            <div class="row gx-4">
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input id="form_name" type="text" name="name" class="form-control" placeholder="Keresztnév" required>
                                        <label for="form_name">Keresztnév *</label>
                                        <div class="valid-feedback"> Jó név! </div>
                                        <div class="invalid-feedback"> Kérjük, adja meg a keresztnevét. </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Vezetéknév" required>
                                        <label for="form_lastname">Vezetéknév *</label>
                                        <div class="valid-feedback"> Jó vezetéknév! </div>
                                        <div class="invalid-feedback"> Kérjük, adja meg a vezetéknevét. </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-4">
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="pelda@example.com" required>
                                        <label for="form_email">Email *</label>
                                        <div class="valid-feedback"> Jó email! </div>
                                        <div class="invalid-feedback"> Kérjük, adjon meg egy érvényes email címet. </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-4">
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Üzenet" style="height: 150px" required></textarea>
                                        <label for="form_message">Üzenet *</label>
                                        <div class="valid-feedback"> Jó üzenet! </div>
                                        <div class="invalid-feedback"> Kérjük, írja be üzenetét. </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-check mb-4">
                                      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required="">
                                      <label class="form-check-label" for="invalidCheck"> Elfogadom az <a href="{{ route('gdpr') }}" class="hover">adatkezelési feltételeket</a>. </label>
                                      <div class="invalid-feedback"> El kell fogadnia az adatkezelési feltételeket a beküldés előtt. </div>
                                    </div>
                                  </div>

                                <div class="col-12 text-center">
                                    <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3" value="Üzenet küldése">
                                    <p class="text-muted"><strong>*</strong> Ezek a mezők kötelezőek.</p>
                                </div>
                            </div>
                        </form>

                        {{-- <form class="contact-form needs-validation" method="post" action=""
                            novalidate>
                            <div class="messages"></div>
                            <div class="row gx-4">
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input id="form_name" type="text" name="name" class="form-control"
                                            placeholder="Jane" required>
                                        <label for="form_name">First Name *</label>
                                        <div class="valid-feedback"> Looks good! </div>
                                        <div class="invalid-feedback"> Please enter your first name. </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-4">
                                        <input id="form_lastname" type="text" name="surname" class="form-control"
                                            placeholder="Doe" required>
                                        <label for="form_lastname">Last Name *</label>
                                        <div class="valid-feedback"> Looks good! </div>
                                        <div class="invalid-feedback"> Please enter your last name. </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-4">
                                        <input id="form_email" type="email" name="email" class="form-control"
                                            placeholder="jane.doe@example.com" required>
                                        <label for="form_email">Email *</label>
                                        <div class="valid-feedback"> Looks good! </div>
                                        <div class="invalid-feedback"> Please provide a valid email address. </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-4">
                                        <textarea id="form_message" name="message" class="form-control" placeholder="Your message" style="height: 150px"
                                            required></textarea>
                                        <label for="form_message">Message *</label>
                                        <div class="valid-feedback"> Looks good! </div>
                                        <div class="invalid-feedback"> Please enter your messsage. </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3"
                                        value="Send message">
                                    <p class="text-muted"><strong>*</strong> These fields are required.</p>
                                </div>
                            </div>
                        </form> --}}

                        <!-- /form -->
                    </div>
                    <!-- /column -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </section>

    </section>

@endsection
