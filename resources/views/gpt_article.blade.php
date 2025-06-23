<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Simplo – Articles</title>
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
    .article-header {
      background: url('https://via.placeholder.com/1600x400?text=Article+Banner') center/cover no-repeat;
      color: white;
      padding: 120px 0;
      text-align: center;
    }
    .article-header h1 {
      font-size: 3rem;
      font-weight: bold;
    }
    .article-content {
      padding: 60px 0;
    }
    .article-preview {
      border-bottom: 1px solid #ddd;
      padding: 30px 0;
    }
    .article-preview h3 {
      font-size: 1.5rem;
      font-weight: bold;
    }
    .article-preview p {
      color: #555;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand simplo-logo" href="#">Simplo</a>
    </div>
  </nav>

  <!-- Header Banner -->
  <header class="article-header">
    <div class="container">
      <h1>Latest Articles</h1>
      <p class="lead">Insights, updates, and stories from Simplo</p>
    </div>
  </header>

  <!-- Article Content Section -->
  <section class="article-content">
    <div class="container">
      <!-- Article Preview Block -->
      <div class="article-preview">
        <h3>Why Custom Security Solutions Matter</h3>
        <p>Learn how tailored platform integration improves your business operations securely and efficiently.</p>
        <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
      </div>
      <div class="article-preview">
        <h3>Top 5 Benefits of Infrastructure Automation</h3>
        <p>Automation is transforming infrastructure—see what this means for the future of security and control.</p>
        <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
      </div>
      <div class="article-preview">
        <h3>Simplo Platform Updates – Q2 Highlights</h3>
        <p>New features, system enhancements, and what’s coming next.</p>
        <a href="#" class="btn btn-outline-primary btn-sm">Read More</a>
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
