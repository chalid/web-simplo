<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Simplo - One Gateway Controller</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Nunito', sans-serif;
      background: #fff;
      color: #222;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 1.8rem;
      color: #004080;
    }
    .navbar {
      padding: 1rem 2rem;
    }
    .carousel-caption {
      left: 5%;
      right: auto;
      bottom: 20%;
      color: white;
      max-width: 40%;
      text-align: left;
      background: rgba(0,0,0,0.4);
      padding: 1.5rem;
      border-radius: 8px;
    }
    .btn-learn-more {
      border-radius: 30px;
      border: 1px solid white;
      color: white;
      background: transparent;
      padding: 0.5rem 1.75rem;
      transition: background 0.3s ease;
    }
    .btn-learn-more:hover {
      background: white;
      color: #004080;
      text-decoration: none;
    }
    .brand-logos img {
      max-height: 60px;
      margin: 0 15px;
      opacity: 0.8;
      transition: opacity 0.3s ease;
    }
    .brand-logos img:hover {
      opacity: 1;
    }
    .inquiry-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #004080;
      color: white;
      border-radius: 50%;
      width: 48px;
      height: 48px;
      font-weight: 700;
      font-size: 1.2rem;
      border: none;
      cursor: pointer;
      z-index: 1050;
    }
  </style>
</head>
<body>

<nav class="navbar d-flex justify-content-between align-items-center">
  <a href="#" class="navbar-brand">Simplo</a>
  <div>
    <button class="btn btn-link text-secondary me-3"><i class="bi bi-search"></i></button>
    <button class="btn btn-link text-secondary"><i class="bi bi-list"></i></button>
  </div>
</nav>

<div id="homeCarousel" class="carousel slide" data-bs-ride="carousel" style="max-width: 100%;">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/mnt/data/1b353d49-d66b-48bf-a2e4-dcae2db591f5.png" class="d-block w-100" alt="Gateway Controller" />
      <div class="carousel-caption">
        <h2>One Gateway Controller for Total Security</h2>
        <p>Seamlessly connect CCTV, access control, and visitor management into a single, powerful platform for enhanced security and efficiency.</p>
        <a href="#" class="btn btn-learn-more">Learn More</a>
      </div>
    </div>
    <!-- Add more slides if needed -->
  </div>
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="3"></button>
    <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="4"></button>
  </div>
</div>

<section class="text-center my-5">
  <p class="mb-1">Seamless Integration with Leading</p>
  <h3 class="fw-bold">Global Security Brands</h3>
  <div class="d-flex justify-content-center align-items-center brand-logos my-4 flex-wrap">
    <img src="/mnt/data/c2da4cd5-c68a-478e-83e1-f4f68b571c1e.png" alt="Suprema" />
    <img src="/mnt/data/5d107c10-9564-41b1-91dc-cf875114a583.png" alt="Salto" />
    <img src="/mnt/data/c7302c63-e267-40bf-8308-5663bc364cd3.png" alt="EntryPass" />
    <img src="/mnt/data/8f0d2da1-35be-46ee-b7c9-af6b1a5c64ab.png" alt="Bosch" />
    <img src="/mnt/data/8709685f-2b4c-451f-9ae5-3a4110c4e185.png" alt="Hikvision" />
  </div>
  <p>With our gateway controller, businesses can unify existing and new security infrastructures into a single, customizable.</p>
</section>

<button class="inquiry-button" title="Inquiry">?</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
