<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Simplo – Clients</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .simplo-logo {
      font-weight: bold;
      font-size: 2rem;
      color: #1b4fc2;
    }
    .client-section {
      background-color: #f4f6fc;
      padding: 80px 0;
    }
    .client-logo {
      padding: 30px;
      background: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      border-radius: 12px;
      text-align: center;
      transition: transform 0.2s;
    }
    .client-logo:hover {
      transform: scale(1.05);
    }
    .section-title {
      font-size: 2.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand simplo-logo" href="#">Simplo</a>
      <div>
        <button class="btn btn-outline-primary">
          <svg width="24" height="24" fill="currentColor">
            <use xlink:href="https://www.svgrepo.com/show/494324/menu.svg#icon"/>
          </svg>
        </button>
      </div>
    </div>
  </nav>

  <!-- Clients Section -->
  <section class="client-section">
    <div class="container">
      <h2 class="section-title">Trusted by Clients</h2>
      <div class="row g-4">
        <!-- Repeat this block for each client -->
        <div class="col-6 col-md-4 col-lg-3">
          <div class="client-logo">
            <img src="https://via.placeholder.com/120x60?text=Logo+1" alt="Client 1" class="img-fluid" />
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="client-logo">
            <img src="https://via.placeholder.com/120x60?text=Logo+2" alt="Client 2" class="img-fluid" />
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="client-logo">
            <img src="https://via.placeholder.com/120x60?text=Logo+3" alt="Client 3" class="img-fluid" />
          </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="client-logo">
            <img src="https://via.placeholder.com/120x60?text=Logo+4" alt="Client 4" class="img-fluid" />
          </div>
        </div>
        <!-- Add more client logos as needed -->
      </div>
    </div>
  </section>

  <!-- Optional Footer -->
  <footer class="bg-white text-center py-4">
    <small>© 2025 Simplo. All rights reserved.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
