<!-- Product Page (HTML from Figma Design) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Our Products - Simplo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/css/styles.css" />
</head>
<body>
  <!-- Header -->
  <header class="bg-white border-bottom shadow-sm py-3">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="/" class="text-decoration-none">
        <h1 class="h3 text-primary m-0">Simplo</h1>
      </a>
      <nav>
        <ul class="nav">
          <li class="nav-item"><a class="nav-link text-dark" href="/">Home</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="/products">Products</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="/clients">Clients</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="/contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-light text-center py-5">
    <div class="container">
      <h2 class="display-5 fw-bold">Our Products</h2>
      <p class="lead text-muted">Secure. Scalable. Smart.</p>
    </div>
  </section>

  <!-- Product Grid -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100">
            <img src="/images/product1.jpg" class="card-img-top" alt="Product 1">
            <div class="card-body">
              <h5 class="card-title">Access Gateway</h5>
              <p class="card-text">Control and monitor entry points with cutting-edge security features.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100">
            <img src="/images/product2.jpg" class="card-img-top" alt="Product 2">
            <div class="card-body">
              <h5 class="card-title">IoT Controller</h5>
              <p class="card-text">Connect and automate your devices with real-time data insights.</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card h-100">
            <img src="/images/product3.jpg" class="card-img-top" alt="Product 3">
            <div class="card-body">
              <h5 class="card-title">Network Hub</h5>
              <p class="card-text">Reliable, fast, and secure networking for your organization.</p>
            </div>
          </div>
        </div>

        <!-- Add more product cards as needed -->
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4">
    <div class="container text-center">
      <p class="mb-1">&copy; 2025 Simplo. All rights reserved.</p>
      <small>Built with security and simplicity in mind.</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
