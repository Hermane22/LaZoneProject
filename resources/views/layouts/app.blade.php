<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    {{-- @notify_css  --}}
</head>

<body>
      <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope-fill"></i><a href="mailto:contact@example.com">info@example.com</a>
        <i class="bi bi-phone-fill phone-icon"></i> +1 5589 55488 55
      </div>
      <div class="social-links d-none d-md-block">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
    </div>
  </section>

<header id="header" class="d-flex align-items-center">
  <div class="container d-flex align-items-center justify-content-center" >
    <nav id="navbar" class="navbar">
        @auth
                    <!-- ICON -->
                    <div class="dropdown nav-button notifications-button hidden-sm-down ">
                        <a class="btn btn-dark dropdown-toggle" href="#" id="notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                          <i id="notificationsIcon" aria-hidden="true"></i>
                          <svg class="bi bi-bell-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 16a2 2 0 002-2H6a2 2 0 002 2zm.995-14.901a1 1 0 10-1.99 0A5.002 5.002 0 003 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                          </svg>
                          <span id="notificationsBadge" class="badge bg-danger">
                            <i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true">{{ count(Auth::user()->unreadNotifications) }}</i>
                          </span>
                        </a>
                        <!-- NOTIFICATIONS -->
{{--                         <div id="notificationsContainer" class="notifications-container">
                          @foreach (Auth::user()->unreadNotifications as $notification)
                              <div class="notifications-body">
                                  <a href="#" class="dropdown-item dropdown-notification">
                                      <p class="notification-texte mx-1">
                                          <small>
                                              @if ($notification->type === 'App\Notifications\CvAffected')
                                                  @if (isset($notification->data['cv_id']))
                                                      <span class="badge badge-pill bg-dark">#{{ $notification->data['cv_id'] }}</span>
                                                  @endif
                                                  {{ $notification->data['affected_by'] }} t'a affecté la demande de CV {{ $notification->data['cv_name'] }}
                                              @elseif ($notification->type === 'App\Notifications\CoverAffected')
                                                  @if (isset($notification->data['cover_id']))
                                                      <span class="badge badge-pill bg-dark">#{{ $notification->data['cover_id'] }}</span>
                                                  @endif
                                                  {{ $notification->data['affected_by'] }} t'a affecté la demande de Cover {{ $notification->data['cover_name'] }}
                                              @elseif ($notification->type === 'App\Notifications\MemoryAffected')
                                                  @if (isset($notification->data['memory_id']))
                                                      <span class="badge badge-pill bg-dark">#{{ $notification->data['memory_id'] }}</span>
                                                  @endif
                                                  {{ $notification->data['affected_by'] }} t'a affecté la demande de Memory {{ $notification->data['memory_name'] }}
                                              @endif
                                          </small>
                                      </p>
                                  </a>
                                  {{ $notification->markAsRead() }}
                              </div>
                          @endforeach
                      </div> --}}
                      
                      
                        <div class="dropdown-menu notification-dropdown-menu bg-dark" aria-labelledby="notifications-dropdown" style="min-width: 360px; max-width: 360px;">
                          <h6 class="dropdown-header">Notifications</h6>
                          @if(count(Auth::user()->unreadNotifications) > 0)
                            <div id="notificationsContainer" class="notifications-container">
                              @foreach (Auth::user()->unreadNotifications as $notification)
                                <div class="notifications-body">
                                  <a href="#" class="dropdown-item dropdown-notification">
                                      <p class="notification-texte mx-1">
                                          <small>
                                              @if ($notification->type === 'App\Notifications\CvAffected')
                                                  @if (isset($notification->data['cv_id']))
                                                      <span class="badge badge-pill bg-dark">#{{ $notification->data['cv_id'] }}</span>
                                                  @endif
                                                  {{ $notification->data['affected_by'] }} t'a affecté la demande de CV {{ $notification->data['cv_name'] }}
                                              @elseif ($notification->type === 'App\Notifications\CoverAffected')
                                                  @if (isset($notification->data['cover_id']))
                                                      <span class="badge badge-pill bg-dark">#{{ $notification->data['cover_id'] }}</span>
                                                  @endif
                                                  {{ $notification->data['affected_by'] }} t'a affecté la demande de Cover {{ $notification->data['cover_name'] }}
                                              @elseif ($notification->type === 'App\Notifications\MemoryAffected')
                                                  @if (isset($notification->data['memory_id']))
                                                      <span class="badge badge-pill bg-dark">#{{ $notification->data['memory_id'] }}</span>
                                                  @endif
                                                  {{ $notification->data['affected_by'] }} t'a affecté la demande de Memory {{ $notification->data['memory_name'] }}
                                              @endif
                                          </small>
                                      </p>
                                  </a>
                                  {{ $notification->markAsRead() }}
                                </div>
                              @endforeach
                            </div>
                          @else
                            <!-- AUCUNE NOTIFICATION -->
                            <a id="notificationAucune" class="dropdown-item dropdown-notification" href="#">
                              <p class="notification-solo text-center">Aucune nouvelle notification</p>
                            </a>
                          @endif
                          <!-- TOUTES -->
                          <a class="dropdown-item dropdown-notification-all" href="">
                            Voir toutes les notifications
                          </a>
                        </div>
                      </div>
                      
                    
        @endauth

      <ul>
        @if(!auth()->check())
        <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
        <li><a class="nav-link scrollto" href="#services">Services</a></li> 
        <li><a class="nav-link scrollto" href="#about">About</a></li>
        <li><a class="nav-link scrollto" href="{{route('cvs.telechargement')}}">Telechargement</a></li>
        @endif
        @Auth
        <li><a class="nav-link scrollto" href=" {{route('cvs.index')}} ">Demandes de CV</a></li> 
        <li><a class="nav-link scrollto" href=" {{route('covers.index')}} ">Demandes de lettre de motivation</a></li>
        <li><a class="nav-link scrollto" href=" {{route('memory.index')}} ">Demandes de correction de memoire</a></li>
        @endAuth
      </ul>

      <ul class="justify-content-right">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="dropdown">
                
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarDropdown">
                
                    <a class="dropdown-item " href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a class="dropdown-item" href="{{ route('users.index') }}">
                        Liste de utilisateurs
                    </a>
                    <a class="dropdown-item" href="{{ route('cvs.affected') }}">
                        Liste des demandes affectées
                    </a>
                </div>
            </li>
        @endguest
    </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
</div>
</header>
    <div id="main">
        <main class="container">
            @yield('content')
        </main>
    </div>
</body>
{{-- @notify_js
@notify_render --}}

</html>
