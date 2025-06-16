<?php
session_start();
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

// Vérifier que l'étudiant est connecté
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header('Location: ../Views/connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Étudiant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Dashboard étudiant pour consulter QCM et résultats" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --main-color: rgb(115, 151, 187);
            --hover-color: rgb(95, 130, 165);
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 40px;
            min-height: 100vh;
        }

        .dashboard-title {
            color: var(--main-color);
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            font-size: 2.8rem;
            text-shadow: 1px 1px 3px rgba(115, 151, 187, 0.4);
            animation: fadeInDown 1s ease forwards;
            opacity: 0;
        }

        @keyframes fadeInDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .card-gmi235 {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            user-select: none;
            will-change: transform;
        }

        .card-gmi235:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(115, 151, 187, 0.3);
        }

        .card-gmi235 .card-body {
            padding: 30px;
            text-align: center;
        }

        .card-gmi235 i {
            font-size: 3rem;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        .card-gmi235 h5 {
            font-weight: 700;
            color: #1e2e4a;
            font-size: 1.6rem;
            margin-bottom: 15px;
        }

        .card-gmi235 p {
            color: #465a7f;
            font-size: 1rem;
            margin-bottom: 25px;
        }

        .card-gmi235 a {
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        /* Color variants */
        .card-qcm {
            background: linear-gradient(135deg, #a0c4ff, #d0e8ff);
            color: #0d3b66;
        }

        .card-qcm i,
        .card-qcm a {
            color: #0d3b66;
        }

        .card-resultats {
            background: linear-gradient(135deg, #b9fbc0, #d4fadd);
            color: #1e4639;
        }

        .card-resultats i,
        .card-resultats a {
            color: #1e4639;
        }

        .card-profil {
            background: linear-gradient(135deg, #ffd6a5, #fff0d2);
            color: #5f3d00;
        }

        .card-profil i,
        .card-profil a {
            color: #5f3d00;
        }

        .card-support {
            background: linear-gradient(135deg, #fcb0b3, #ffe3e4);
            color: #702323;
        }

        .card-support i,
        .card-support a {
            color: #702323;
        }

        .card-gmi235 a:hover {
            text-decoration: underline;
        }

        footer {
            background: linear-gradient(90deg, #7397bb 0%, #dce9f9 100%);
            box-shadow: 0 -2px 16px rgba(115,151,187,0.08);
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
        }

        footer i {
            transition: transform 0.3s ease;
        }

        footer i:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<body>
    <?php include 'header_etudiant.php'; ?>

    <div class="mt-5 container">
        <h2 class="dashboard-title animate__animated animate__fadeInDown">Bienvenue sur votre espace étudiant</h2>

        <div class="row g-4">
            <!-- QCM disponibles -->
            <div class="col-md-6 animate__animated animate__fadeInLeft animate__delay-1s">
                <div class="card card-gmi235 card-qcm">
                    <div class="card-body">
                        <i class="fas fa-file-alt"></i>
                        <h5 class="card-title">QCM disponibles</h5>
                        <p class="card-text">Consultez et participez aux QCM actifs proposés par vos enseignants.</p>
                        <a href="qcm_disponibles.php" aria-label="Accéder aux QCM disponibles">Accéder <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Résultats -->
            <div class="col-md-6 animate__animated animate__fadeInRight animate__delay-1s">
                <div class="card card-gmi235 card-resultats">
                    <div class="card-body">
                        <i class="fas fa-chart-bar"></i>
                        <h5 class="card-title">Mes Résultats</h5>
                        <p class="card-text">Consultez vos performances et résultats obtenus aux différents QCM.</p>
                        <a href="resultats.php" aria-label="Voir mes résultats aux QCM">Voir mes résultats <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>

            
           
           
        </div>
    </div>
    <!-- Espace avant le footer -->
    <div style="height: 60px;"></div>
    <!-- Footer -->
    <footer class="mt-5 py-4">
        <div class="container text-center">
            <div class="mb-2">
                <a href="#" class="mx-2 text-decoration-none" style="color:#1e2e4a;">
                    <i class="fab fa-facebook-f fa-lg"></i>
                </a>
                <a href="#" class="mx-2 text-decoration-none" style="color:#1e2e4a;">
                    <i class="fab fa-twitter fa-lg"></i>
                </a>
                <a href="#" class="mx-2 text-decoration-none" style="color:#1e2e4a;">
                    <i class="fab fa-linkedin-in fa-lg"></i>
                </a>
                <a href="#" class="mx-2 text-decoration-none" style="color:#1e2e4a;">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
            </div>
            <div style="color:#465a7f; font-size:1.05rem;">
                © <?php echo date('Y'); ?> GMI235 | Projet Fil Rouge — Tous droits réservés.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
