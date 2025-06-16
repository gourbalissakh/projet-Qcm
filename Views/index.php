<?php
include_once '../layouts/header.php';
include_once '../databases/db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Plateforme d'Évaluation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AOS + Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --gmi: rgb(115, 151, 187);
      --gmi-dark: rgb(93, 131, 167);
      --text: #2c3e50;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #f7fafd, #eaf1f7);
      color: var(--text);
    }

    .carousel-item {
      height: 90vh;
      position: relative;
    }

    .carousel-item img {
      object-fit: cover;
      width: 100%;
      height: 100%;
      filter: brightness(0.5);
    }

    .carousel-caption {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.6);
      border-radius: 20px;
      padding: 40px;
      color: white;
      text-shadow: 1px 1px 3px black;
      max-width: 800px;
      animation: fadeIn 1s ease-in-out;
    }

    .carousel-caption h5 {
      font-size: 2.5rem;
      font-weight: bold;
      color: var(--gmi);
    }

    .carousel-caption p {
      font-size: 1.2rem;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      background-color: rgba(255, 255, 255, 0.6);
      border-radius: 50%;
      padding: 15px;
    }

    section {
      padding: 60px 0;
    }

    .card-feature {
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-feature:hover {
      transform: translateY(-10px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    .card-feature i {
      font-size: 3rem;
      margin-bottom: 20px;
      color: var(--gmi-dark);
    }

    .card-feature h5 {
      font-weight: bold;
      margin-bottom: 15px;
      color: var(--gmi);
    }

    footer {
      background: var(--gmi);
      color: white;
      padding: 20px 0;
      text-align: center;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translate(-50%, -60%);
      }
      to {
        opacity: 1;
        transform: translate(-50%, -50%);
      }
    }
  </style>
</head>
<body>

<!-- 🎞️ Carousel -->
<div id="carouselEvaluation" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../images/img1.jpg" alt="Image 1">
      <div class="carousel-caption">
        <h5>Des évaluations pratiques</h5>
        <p>Testez vos compétences à tout moment, où que vous soyez.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/img2.jpg" alt="Image 2">
      <div class="carousel-caption">
        <h5>Statistiques en temps réel</h5>
        <p>Visualisez vos performances instantanément après chaque QCM.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/img3.jpg" alt="Image 3">
      <div class="carousel-caption">
        <h5>Plateforme responsive</h5>
        <p>Accessible depuis mobile, tablette ou ordinateur, sans limites.</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselEvaluation" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselEvaluation" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>
</div>

<!-- 🔥 Section Info -->
<section class="container">
  <div class="row text-center">
    <div class="col-md-4 mb-4" data-aos="zoom-in">
      <div class="card-feature">
        <i class="bi bi-person-fill-check text-primary"></i>
        <h5>Évaluation Étudiants</h5>
        <p>Les étudiants passent des QCMs, visualisent leurs scores, et suivent leur évolution.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
      <div class="card-feature">
        <i class="bi bi-ui-checks-grid text-success"></i>
        <h5>Création de QCMs</h5>
        <p>Les enseignants génèrent facilement des QCMs avec correction automatique intégrée.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
      <div class="card-feature">
        <i class="bi bi-person-gear text-danger"></i>
        <h5>Espace Enseignant</h5>
        <p>Gérez vos étudiants, les examens, et visualisez les statistiques détaillées.</p>
      </div>
    </div>
  </div>
</section>

<?php include_once '../layouts/footer.php'; ?>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ once: true });
</script>
</body>
</html>

