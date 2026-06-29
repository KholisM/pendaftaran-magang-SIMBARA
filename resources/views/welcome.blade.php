<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pendaftaran Magang</title>

  <!-- Favicons -->
  <link href="assets/img/capil.png" rel="icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>

  <!-- Vendor CSS -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- Chatbot -->
  <script src="assets/js/chatbot.js"></script>
</head>

<body class="index-page">

@php
    $pengaturan = \App\Models\Pengaturan::first();
@endphp

<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
      <img src="assets/img/capil.png" alt="Logo" style="height: 40px; margin-right: 10px;">

      <div class="d-flex flex-column">
        <h3 class="sitename mb-0">DISDUKCAPIL</h3>
        <h6 class="mb-0">Kota Bogor</h6>
      </div>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="#hero" class="active">Home</a></li>
        <li><a href="#persyaratan">Persyaratan</a></li>
        <li><a href="#services">Proses Pendaftaran</a></li>
        <li><a href="{{ url('login') }}">Login</a></li>
      </ul>

      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

  </div>
</header>

<main class="main">

  <!-- HERO -->
  <section id="hero" class="hero section dark-background position-relative">
    <div class="hero-overlay"></div>

    <img src="assets/img/lokasi.jpeg"
         alt="Hero"
         class="img-fluid w-100 hero-image">

    <div class="container text-center hero-content">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2 class="hero-title">
            Ayo! Magang dan PKL disini!
          </h2>
        </div>
      </div>
    </div>
  </section>

  <!-- PENGANTAR -->
  <section id="pengantar-magang" class="about section">

    <div class="container section-title">
      <h2>Pengantar Program Magang</h2>
    </div>

    <div class="container">
      <div class="row gy-3">

        <div class="col-lg-6">
          <img src="assets/img/pengantar.jpg"
               class="img-fluid rounded"
               style="max-height:500px;width:100%;object-fit:cover;">
        </div>

        <div class="col-lg-6 d-flex flex-column justify-content-center">

          <div class="about-content ps-0 ps-lg-3">

            <h3>Program Magang Disdukcapil Kota Bogor</h3>

            <p class="fst-italic">
              Membuka kesempatan bagi mahasiswa untuk mengembangkan kompetensi.
            </p>

            <ul>
              <li>
                <div>
                  <h4>Tujuan Program</h4>

                  <p>
                    Memberikan pengalaman praktis bagi mahasiswa.
                  </p>
                </div>
              </li>

              <li>
                <div>
                  <h4>Lingkup Kegiatan</h4>

                  <p>
                    Mahasiswa dilibatkan dalam kegiatan pemerintahan.
                  </p>
                </div>
              </li>
            </ul>

            <p>
              Program magang ini dirancang untuk memberikan pengalaman
              profesional kepada mahasiswa sebelum memasuki dunia kerja.
            </p>

          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- PERSYARATAN -->
  <section id="persyaratan" class="about section">

    <div class="container section-title">
      <h2>Persyaratan Umum Magang</h2>
    </div>

    <div class="container">
      <div class="row gy-4 align-items-center">

        <!-- KIRI -->
        <div class="col-lg-6">

          <div class="about-content">

            <h3>Dokumen dan Persyaratan</h3>

            <p class="fst-italic">
              Pastikan dokumen lengkap sebelum mendaftar.
            </p>

            <div class="row">

              <div class="col-12 mb-4">
                <div class="d-flex align-items-start">
                  <i class="bi bi-file-earmark-text text-primary me-3 fs-4"></i>

                  <div>
                    <strong>Surat Permohonan Magang</strong>

                    <p class="text-muted mb-0">
                      Surat resmi dari kampus.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-12 mb-4">
                <div class="d-flex align-items-start">
                  <i class="bi bi-person-vcard text-primary me-3 fs-4"></i>

                  <div>
                    <strong>Biodata Diri</strong>

                    <p class="text-muted mb-0">
                      Biodata lengkap peserta.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-12 mb-4">
                <div class="d-flex align-items-start">
                  <i class="bi bi-file-earmark-medical text-primary me-3 fs-4"></i>

                  <div>
                    <strong>Dokumen Pendukung</strong>

                    <p class="text-muted mb-0">CV terbaru</p>
                    <p class="text-muted mb-0">Surat KesBangPol</p>
                  </div>
                </div>
              </div>

            </div>

            <div class="alert alert-info">
              <i class="bi bi-info-circle me-2"></i>
              Seluruh dokumen harus jelas dan lengkap.
            </div>

           <!-- STATUS PROGRAM -->
<section class="py-4">

    <div class="container text-center">

        @php
            $pengaturan = \App\Models\Pengaturan::first();
        @endphp

        @if($pengaturan && $pengaturan->magang_dibuka)

            <div class="alert alert-success shadow-sm border-0 rounded-4 p-4">

                <h4 class="mb-2 fw-bold">
                    <i class="bi bi-check-circle-fill"></i>
                    Program Magang Sedang Dibuka
                </h4>

                <p class="mb-3">
                    Pendaftaran magang saat ini tersedia dan dapat dilakukan melalui website.
                </p>

                <a href="{{ url('login') }}"
                   class="btn btn-success px-4">

                    Daftar Sekarang

                </a>

            </div>

        @else

            <div class="alert alert-danger shadow-sm border-0 rounded-4 p-4">

                <h4 class="mb-2 fw-bold">
                    <i class="bi bi-x-circle-fill"></i>
                    Program Magang Sedang Ditutup
                </h4>

                <p class="mb-3">
                    Saat ini pendaftaran magang belum tersedia.
                </p>

                <button class="btn btn-secondary px-4" disabled>
                    Pendaftaran Ditutup
                </button>

            </div>

        @endif

    </div>

</section>

          </div>

        </div>

        <!-- KANAN -->
        <div class="col-lg-6 text-md-end">

          <img src="assets/img/syarat1.webp"
               alt="Persyaratan"
               class="img-fluid rounded"
               style="max-height:500px;width:100%;object-fit:cover;">

        </div>

      </div>
    </div>
  </section>

  <!-- PROSES -->
  <section id="services" class="services section light-background">

    <section id="what-we-do" class="what-we-do section">

      <div class="container section-title">
        <h2>Proses Pendaftaran</h2>
      </div>

      <div class="container">

        <div class="row gy-4 justify-content-center">

          <div class="col-lg-10">

            <div class="row gy-4">

              <div class="col-xl-3 col-md-6">
                <div class="icon-box text-center">
                  <i class="bi bi-inboxes mb-3"></i>

                  <h4>Registrasi Online</h4>

                  <p class="text-muted">
                    Membuat akun di website.
                  </p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6">
                <div class="icon-box text-center">
                  <i class="bi bi-clipboard-data mb-3"></i>

                  <h4>Pendaftaran Online</h4>

                  <p class="text-muted">
                    Isi formulir pendaftaran.
                  </p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6">
                <div class="icon-box text-center">
                  <i class="bi bi-gem mb-3"></i>

                  <h4>Seleksi Administrasi</h4>

                  <p class="text-muted">
                    Tim melakukan seleksi berkas.
                  </p>
                </div>
              </div>

              <div class="col-xl-3 col-md-6">
                <div class="icon-box text-center">
                  <i class="bi bi-check-circle mb-3"></i>

                  <h4>Pengumuman</h4>

                  <p class="text-muted">
                    Hasil seleksi melalui email.
                  </p>
                </div>
              </div>

            </div>

          </div>

        </div>

      </div>

    </section>

  </section>

</main>

<footer id="footer" class="footer light-background">

  <div class="container footer-top">

    <div class="row gy-4">

      <div class="col-lg-5 footer-about">

        <a href="/" class="logo d-flex align-items-center">
          <span class="sitename">Disdukcapil</span>
        </a>

        <p>Disdukcapil Kota Bogor</p>

      </div>

      <div class="col-lg-3 footer-contact">

        <h4>Contact Us</h4>

        <p>
          Jl. Merdeka No.142 Bogor Tengah Jawa Barat
        </p>

        <p class="mt-4">
          <strong>Phone:</strong>
          <span>081290003271</span>
        </p>

        <p>
          <strong>Email:</strong>
          <span>disdukcapil@kotabogor.go.id</span>
        </p>

      </div>

    </div>

  </div>

</footer>

<!-- JS -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>