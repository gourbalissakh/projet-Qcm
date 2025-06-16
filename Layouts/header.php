<!DOCTYPE html>
<html lang="fr" data-bs-theme="<?php echo $theme; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Évaluation En Ligne</title>
  <link rel="icon" type="image/png" href="../images/estm-logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-custom {
      background: linear-gradient(90deg, #7397bb 0%, #4e6e8e 100%);
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .navbar-brand img {
      border-radius: 8px;
      border: 2px solid #fff;
    }
    .nav-link {
      color: #fff !important;
      font-weight: 500;
      transition: color 0.2s;
    }
    .nav-link:hover {
      color: #ffe082 !important;
    }
    .navbar-toggler {
      border-color: #fff;
    }
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255,255,255,0.7%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
  <a class="navbar-brand d-flex align-items-center" href="/Travail/projet_fil_rouge/views/index.php">
    <img src="../images/estm-logo.png" alt="Logo ESTM" width="40" height="40" class="me-2">
    <span class="fw-bold text-white">ESTM</span>
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
    <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="/Travail/projet_fil_rouge/views/connexion.php">
      <i class="bi bi-box-arrow-in-right"></i> Connexion
      </a>
    </li>
    </ul> 
  </div>
  </div>
</nav>
</body>
</html>