@extends('layouts.app')


@section('content')

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="500">
      <h1>Bienvenu</h1>
      <h2>Nous sommes .....</h2>
      
    </div>
  </section><!-- End Hero -->


  <main id="main">


    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <span>Services</span>
          <h2>Services</h2>
          <p>Nous vous offrons</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
            <div class="icon-box">
              <div class="icon"><i class="bx bxl-dribbble"></i></div>
              <h4>
                <a href=" {{ route('cvs.create') }}" data-bs-toggle="modal" data-bs-target="#fenetreCv">Création de CV professionnels</a>
              </h4>
              <p>Notre équipe de professionnels peut créer un CV qui mettra en valeur vos compétences et votre expérience pour vous aider à obtenir le travail de vos rêves</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="150">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-file"></i></div>
              <h4><a href="{{ route('covers.create') }}" data-bs-toggle="modal" data-bs-target="#fenetreCover">Rédaction de lettres de motivation percutantes</a></h4>
              <p>Nous pouvons vous aider à rédiger une lettre de motivation convaincante qui mettra en valeur vos compétences et votre expérience pour vous aider à obtenir le travail que vous souhaitez</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-tachometer"></i></div>
              <h4><a href="{{ route('memory.create') }}" data-bs-toggle="modal" data-bs-target="#fenetreMemoire">Correction de mémoires universitaires</a></h4>
              <p>Nous pouvons aider les étudiants à améliorer la qualité de leurs mémoires universitaires en fournissant une correction minutieuse et détaillée de leur travail</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->
<!-- fenetre cv -->
    <div class="modal fade" id="fenetreCv" tabindex="-1" aria-labelledby="fenetreCv-label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fenetreCv-label">Demande de conception de CV</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="card">
                  <div class="card-body">
                      <form action="{{ route('cvs.store') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                              <h5>Nom et Prenom</h5>
                              <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
                              <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre nom au complet.</small>
                          </div>
                          <hr>
                          <div class="form-group">
                              <h5>Numero de telephone</h5>
                              <input type="text" name="phone_number" class="form-control" id="phone_number" aria-describedby="nameHelp">
                              <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre numero de telephone fonctionel.</small>
                          </div>
                          <button type="submit" class="btn btn-primary">Envoyer</button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end fenetre cv -->

    <!-- fenetre cover -->
    <div class="modal fade" id="fenetreCover" tabindex="-1" aria-labelledby="fenetreCover-label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fenetreCover-label">Demande de redaction de lettre de motivation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="card">
                  <div class="card-body">
                      <form action="{{ route('covers.store') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                              <h5>Nom et Prenom</h5>
                              <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
                              <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre nom au complet.</small>
                          </div>
                          <hr>
                          <div class="form-group">
                              <h5>Numero de telephone</h5>
                              <input type="text" name="phone_number" class="form-control" id="phone_number" aria-describedby="nameHelp">
                              <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre numero de telephone fonctionel.</small>
                          </div>
                          <button type="submit" class="btn btn-primary">Envoyer</button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end fenetre cover -->

    <!-- fenetre memoire -->
    <div class="modal fade" id="fenetreMemoire" tabindex="-1" aria-labelledby="fenetreMemoire-label" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="fenetreMemoire-label">Demande de correction de memoire</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="card">
                  <div class="card-body">
                      <form action="{{ route('memory.store') }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                              <h5>Nom et Prenom</h5>
                              <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
                              <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre nom au complet.</small>
                          </div>
                          <hr>
                          <div class="form-group">
                              <h5>Numero de telephone</h5>
                              <input type="text" name="phone_number" class="form-control" id="phone_number" aria-describedby="nameHelp">
                              <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre numero de telephone fonctionel.</small>
                          </div>
                          <button type="submit" class="btn btn-primary">Envoyer</button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end fenetre memoire -->

            <!-- ======= About Section ======= -->
            <section id="about" class="about">
              <div class="container">
        
                <div class="row">
                  <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left">
                    <img src="assets/img/about.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
                    <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                    <p class="fst-italic">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                      magna aliqua.
                    </p>
                    <ul>
                      <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                      <li><i class="bi bi-check-circle"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                      <li><i class="bi bi-check-circle"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                    </ul>
                    <p>
                      Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                      velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                      culpa qui officia deserunt mollit anim id est laborum
                    </p>
                  </div>
                </div>
        
              </div>
            </section><!-- End About Section -->


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">


    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>application</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/day-multipurpose-html-template-for-free/ -->
        Designed by <a href="">Hermane</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
@endsection
