<!-- Contact Page (HTML from Figma Design) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - Simplo</title>
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
          <li class="nav-item"><a class="nav-link text-dark" href="/news">News</a></li>
          <li class="nav-item"><a class="nav-link text-dark" href="/contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-light text-center py-5">
    <div class="container">
      <h2 class="display-5 fw-bold">Contact Us</h2>
      <p class="lead text-muted">We’d love to hear from you. Reach out for support, inquiries, or partnerships.</p>
    </div>
  </section>

  <!-- Contact Form Section -->
  <section class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <form>
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Your Email" required>
            </div>
            <div class="mb-3">
              <label for="subject" class="form-label">Subject</label>
              <input type="text" class="form-control" id="subject" placeholder="Subject" required>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Info Section -->
  <section class="bg-primary text-white py-5">
    <div class="container text-center">
      <h4>Our Office</h4>
      <p>1234 Simplo Tower, Business District, Jakarta</p>
      <p>Email: contact@simplo.com | Phone: +62 812-3456-7890</p>
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
