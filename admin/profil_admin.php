<?php
session_start();

// Connexion à la base de données
include_once '../databases/db.php'; // Assure-toi que ce fichier crée bien $pdo
include_once '../databases/fonctions.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['enseignant_id'])) {
    header('Location: ../Views/connexion.php');
    exit();
}

// Récupération des infos de session
$enseignant_id = $_SESSION['enseignant_id'];
$enseignant_nom = $_SESSION['enseignant_nom'] ?? 'Profil';

// Récupération des données de l'enseignant depuis la base
$enseignant = getEnseignantById($enseignant_id, $pdo); // AJOUT OBLIGATOIRE
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Enseignant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --main-color: rgb(115, 151, 187);
            --hover-color: rgb(95, 130, 165);
            --text-color: #34495e;
        }

        body {
            background: linear-gradient(to right, #f8fbfd, #e3ecf3);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background: linear-gradient(90deg, var(--main-color) 60%, #4a6a8a);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .profile-card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
            padding: 30px;
            max-width: 550px;
            margin: 40px auto;
            animation: fadeInUp 0.8s ease-in-out;
        }

        .profile-icon {
            font-size: 4.5rem;
            color: var(--main-color);
        }

        .profile-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: var(--main-color);
        }

        th {
            width: 30%;
            color: var(--main-color);
            font-weight: 600;
        }

        td {
            color: var(--text-color);
            font-weight: 500;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
            font-size: 0.85rem;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark px-3">
    <a class="navbar-brand text-white" href="../admin/dashbord_enseignant.php">
        <i class="bi bi-house-fill me-2"></i>Tableau de bord
    </a>
    <div class="ms-auto">
        <a href="../Views/deconnexion.php" class="btn btn-outline-light rounded-pill px-3">
            <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
        </a>
    </div>
</nav>

<!-- Carte Profil -->
<div class="container">
    <div class="profile-card text-center animate__animated animate__fadeInUp">
        <i class="bi bi-person-circle profile-icon"></i>
        <h2 class="profile-title mt-2">Profil de l’Enseignant</h2>
        <p class="text-muted">Vos informations personnelles</p>

        <?php if ($enseignant): ?>
        <table class="table table-borderless text-start mt-4">
            <tr>
                <th><i class="bi bi-person-fill me-2"></i>Nom</th>
                <td><?= htmlspecialchars($enseignant['nom']) ?></td>
            </tr>
            <tr>
                <th><i class="bi bi-person-badge-fill me-2"></i>Prénom</th>
                <td><?= htmlspecialchars($enseignant['prenom']) ?></td>
            </tr>
            <tr>
                <th><i class="bi bi-envelope-fill me-2"></i>Email</th>
                <td><?= htmlspecialchars($enseignant['email']) ?></td>
            </tr>
            <tr>
                <th><i class="bi bi-award-fill me-2"></i>Rôle</th>
                <td><?= htmlspecialchars($enseignant['role']) ?></td>
            </tr>
        </table>
        <?php else: ?>
        <div class="alert alert-warning mt-3">
            Aucune information disponible pour cet enseignant.
        </div>
        <?php endif; ?>
    </div>
    <div class="text-center mt-3">
        <button class="btn btn-secondary" onclick="window.history.back();">
            <i class="bi bi-arrow-left"></i> Retour
        </button>
    </div>
</div>

<footer>&copy; 2025 ESTM - Tous droits réservés</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>