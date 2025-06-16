<?php
session_start();
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['enseignant_id'])) {
    header('Location: dashbord_enseignant.php');
    exit();
}

// Exemple de récupération des informations de l'enseignant
$nom = $_SESSION['enseignant_nom'] ?? 'Enseignant';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Enseignant</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .bg-gradient-blue {
    background: linear-gradient(135deg, #007bff, #00c6ff);
}
.bg-gradient-green {
    background: linear-gradient(135deg, #28a745, #6fdc8c);
}
.bg-gradient-purple {
    background: linear-gradient(135deg, #6f42c1, #b58ded);
}

.hover-zoom {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-zoom:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,0.3);
}
</style>

</head>
<body class="bg-light">
    <?php include_once 'header_admin.php'; ?>
   <!-- Section d’accueil améliorée -->
<div class="container my-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-8 text-center">
            <img src="../images/estm-logo.png" alt="Logo ESTM" class="img-fluid mb-4" style="max-width: 120px;">
            <h1 class="fw-bold text-primary">Bienvenue, <?php echo htmlspecialchars($nom); ?> </h1>
            <p class="lead text-muted"><strong>Gérez facilement vos étudiants et leurs QCMs via cette plateforme intuitive.</strong></p>
        </div>
    </div>
</div>



    <!-- des sections avec des animation javascript pour Gerer les etudiants et les QCMs -->

    <div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4" data-aos="zoom-in">
            <div class="card h-100 text-white bg-gradient-blue border-0 shadow-lg hover-zoom">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill display-4 mb-3"></i>
                    <h5 class="card-title fw-bold">Gérer les Étudiants</h5>
                    <p class="card-text">Ajouter, modifier ou supprimer des étudiants.</p>
                    <a href="gerer_etudiants.php" class="btn btn-light btn-sm">Accéder</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="card h-100 text-white bg-gradient-green border-0 shadow-lg hover-zoom">
                <div class="card-body text-center">
                    <i class="bi bi-journal-check display-4 mb-3"></i>
                    <h5 class="card-title fw-bold">Gérer les QCMs</h5>
                    <p class="card-text">Créer, modifier ou supprimer des QCMs.</p>
                    <a href="gerer_qcms.php" class="btn btn-light btn-sm">Accéder</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="card h-100 text-white bg-gradient-purple border-0 shadow-lg hover-zoom">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line-fill display-4 mb-3"></i>
                    <h5 class="card-title fw-bold">Consulter les Résultats</h5>
                    <p class="card-text">Voir les résultats des étudiants aux QCMs.</p>
                    <a href="consulter_resultats.php" class="btn btn-light btn-sm">Accéder</a>
                </div>
            </div> 
        </div>
        <!-- ajouter un enseignant -->
        <div class="col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="card h-100 text-white bg-gradient-blue border-0 shadow-lg hover-zoom">
                <div class="card-body text-center">
                    <i class="bi bi-person-plus-fill display-4 mb-3"></i>
                    <h5 class="card-title fw-bold">Ajouter un Enseignant</h5>
                    <p class="card-text">Ajouter un nouvel enseignant à la plateforme.</p>
                    <a href="ajouter_enseignant.php" class="btn btn-light btn-sm">Accéder</a>
                </div>
            </div>
        </div>
        

    </div>
</div>

            
    <!-- Bootstrap JS (optionnel) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<footer class="mt-5">
    <div style="background-color: #7397bb;">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-white">
                    <strong>&copy; <?php echo date('Y'); ?> ESTM - Plateforme Enseignant</strong>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</footer>
