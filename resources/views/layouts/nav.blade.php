<header class="position-absolute w-100">
    <div class="gradient-5 text-white fw-bold fs-15 mb-2 position-relative" style="z-index: 1;">
    </div>
    <nav class="navbar navbar-expand-lg center-nav transparent navbar-light">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand w-100">
                <a href="{{ route('home') }}" class="nav-link" style="    color: #343f52;">
                    <svg width="80" height="20" viewBox="0 0 402 97" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M95 0.0999756H0V95.1H89.5715L56.7989 59.6058L44.0391 78.6558L27 14.7778L85.4463 46.6089L63.7001 54.2648L95 88.1638V0.0999756Z"
                            fill="#343f52" />
                        <path
                            d="M239.256 39.5854C246.154 31.939 256.221 29.2488 266.768 31.9979C281.835 35.9249 289.824 53.0969 281.532 68.8273M281.532 68.8273C279.179 73.2915 275.514 77.6395 270.328 81.5358C239.022 105.055 217.69 74.1701 240.279 61.3384C253.738 53.6934 270.616 57.5661 281.532 68.8273ZM281.532 68.8273C287.822 75.3169 292.133 84.2601 292.669 94.8668"
                            stroke="#343f52" stroke-width="13" />
                        <path d="M306.072 95.2V0H320.08V95.2H306.072Z" fill="#343f52" />
                        <path
                            d="M342.093 39.5861C348.991 31.9395 359.057 29.249 369.605 31.9978C384.671 35.9243 392.661 53.0961 384.369 68.8267M384.369 68.8267C382.016 73.2909 378.352 77.6391 373.166 81.5355C341.861 105.056 320.528 74.1715 343.117 61.3391C356.575 53.6937 373.453 57.5659 384.369 68.8267ZM384.369 68.8267C390.66 75.3161 394.971 84.2592 395.507 94.8658"
                            stroke="#343f52" stroke-width="13" />
                        <path
                            d="M119 95.2V0H146.608L167.416 85.408H169.592L190.4 0H218.008V95.2H203.728V10.336H201.552L180.88 95.2H156.128L135.456 10.336H133.28V95.2H119Z"
                            fill="#343f52" />
                    </svg>
                </a>
            </div>
            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                <div class="offcanvas-header d-lg-none">
                    <h3 class="text-white fs-30 mb-0">Mala.hu</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Főoldal</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('services') ? 'active' : '' }}" href="{{ route('services') }}">Szolgáltatások</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('request') ? 'active' : '' }}" href="{{ route('request') }}">Ajánlat kérés</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('references') ? 'active' : '' }}" href="{{ route('references') }}">Referenciák</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kapcsolat</a>
                        </li>


                    </ul>
                    <!-- /.navbar-nav -->
                    <div class="offcanvas-footer d-lg-none">
                        <div>
                            <a href="mailto:first.last@email.com" class="link-inverse">info@mala.hu</a>
                            <br /> +36 70 7021 252 <br />
                            <nav class="nav social social-white mt-4">
                                <a href="#">
                                    <img src="{{ asset('assets/img/logo-mvp.png') }}" alt="mvp">
                                </a>

                                {{-- <a href="#"><i class="uil uil-twitter"></i></a>
                                <a href="#"><i class="uil uil-facebook-f"></i></a>
                                <a href="#"><i class="uil uil-dribbble"></i></a>
                                <a href="#"><i class="uil uil-instagram"></i></a>
                                <a href="#"><i class="uil uil-youtube"></i></a> --}}
                            </nav>
                            <!-- /.social -->
                        </div>
                    </div>
                    <!-- /.offcanvas-footer -->
                </div>
                <!-- /.offcanvas-body -->
            </div>
            <!-- /.navbar-collapse -->
            <div class="navbar-other w-100 d-flex ms-auto">
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <li class="nav-item">
                        <nav class="nav social social-muted justify-content-end text-end">
                            <li class="nav-item">

                            <a class="nav-link fs-16" href="https://vallalkozzdigitalisan.mkik.hu/">Modern Vállalkozások Programja - Vállalkozz digitálisan!
                                {{-- <img src="{{ asset('assets/img/logo-mvp.png') }}" height="38" alt="Modern Vállalkozások Programja"> --}}
                            </a>
                            </li>
                            {{-- <a href="#"><i class="uil uil-twitter"></i></a>
                            <a href="#"><i class="uil uil-facebook-f"></i></a>
                            <a href="#"><i class="uil uil-dribbble"></i></a>
                            <a href="#"><i class="uil uil-instagram"></i></a> --}}
                        </nav>
                        <!-- /.social -->
                    </li>
                    <li class="nav-item d-lg-none">
                        <button class="hamburger offcanvas-nav-btn"><span></span></button>
                    </li>
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
    </nav>
</header>