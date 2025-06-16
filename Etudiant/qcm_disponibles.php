<?php
session_start();
include_once '../databases/db.php';

// Vérifie que l'utilisateur est étudiant
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header('Location: ../Views/connexion.php');
    exit();
}

try {
    // Récupère tous les QCMs
    $stmt = $pdo->prepare("SELECT id, titre, description FROM qcms ORDER BY id DESC");
    $stmt->execute();
    $qcms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erreur lors de la récupération des QCMs : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>QCMs disponibles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f4f9fc;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-gmi235 {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(115, 151, 187, 0.3);
            margin-bottom: 20px;
            padding: 25px;
            transition: box-shadow 0.3s ease;
        }
        .card-gmi235:hover {
            box-shadow: 0 12px 30px rgba(115, 151, 187, 0.5);
        }
        .btn-primary {
            background-color: rgb(115, 151, 187);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: rgb(95, 131, 167);
        }
    </style>
</head>
<body>
    <!-- Navbar avec icônes -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #7397bb;">
        <div class="container">
            <a class="navbar-brand" href="#" style="color: #fff; font-weight: bold;">
                <i class="bi bi-mortarboard" style="color: #fff;"></i> Espace Étudiant
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashbord_etudiant.php" style="color: #fff;">
                            <i class="bi bi-arrow-left" style="color: #fff;"></i> Revenir en arrière
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="profil_etudiant.php" style="color: #fff;">
                            <i class="bi bi-person-circle me-2" style="font-size: 1.3rem; color: #fff;"></i>
                            <span style="font-weight: 500; color: #fff;">Profil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Views/deconnexion.php" style="color: #fff;">
                            <i class="bi bi-box-arrow-right" style="color: #fff;"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <div class="container py-5">
        <h2 class="mb-4 text-center" style="color: rgb(115, 151, 187); font-weight: bold;">
            QCMs Disponibles
        </h2>

        <?php if (!empty($qcms)) : ?>
            <?php foreach ($qcms as $qcm) : ?>
                <div class="card-gmi235">
                    <h4><?= htmlspecialchars($qcm['titre']) ?></h4>
                    <p><?= nl2br(htmlspecialchars($qcm['description'])) ?></p>
                    <a href="passer_qcm.php?qcm_id=<?= $qcm['id'] ?>" class="btn btn-primary">
                        Passer ce QCM
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-danger">Aucun QCM disponible actuellement.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<footer>
    <div class="text-center py-3" style="color: #789; font-size: 0.95rem;">
        &copy; <?= date('Y') ?> Espace Étudiant - Tous droits réservés.
    </div>
</footer>
</body>
</html>
