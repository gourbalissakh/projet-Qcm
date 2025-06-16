<?php
session_start();
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

if (!isset($_SESSION['enseignant_id'])) {
    header('Location: ../Views/connexion.php');
    exit();
}

if (isset($_GET['id'])) {
    $etudiant_id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ? AND role = 'etudiant'");
        $stmt->execute([$etudiant_id]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$etudiant) {
            header('Location: gerer_etudiants.php?error=1');
            exit();
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
} else {
    header('Location: gerer_etudiants.php?error=1');
    exit();
}

// Traitement POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $numero_etudiant = $_POST['numero_etudiant'];

    try {
        $updateStmt = $pdo->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, numero_etudiant = ? WHERE id = ? AND role = 'etudiant'");
        $updateStmt->execute([$nom, $prenom, $email, $numero_etudiant, $etudiant_id]);

        header("Location: gerer_etudiants.php?success=1");
        exit();
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --main-color: #4b83c3;
        }

        body {
            background: linear-gradient(to right, #e3f2fd, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .btn-custom {
            background-color: var(--main-color);
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #365f87;
        }

        h2 {
            color: var(--main-color);
            font-weight: bold;
        }

        label {
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 0 0.2rem rgba(75, 131, 195, 0.25);
        }
    </style>
</head>
<body>

 <nav class="navbar navbar-expand-lg navbar-light" style="background-color: var(--main-color); box-shadow: 0 2px 8px rgba(0,0,0,0.07);">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="dashboard.php">
                <i class="bi bi-mortarboard-fill"></i> Gestion Étudiants
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="gerer_etudiants.php"><i class="bi bi-people-fill"></i> Étudiants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="ajouter_etudiant.php"><i class="bi bi-person-plus"></i> Ajouter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../Views/deconnexion.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container">
    <div class="form-container mx-auto col-md-6">
        <h2 class="text-center mb-4"><i class="bi bi-pencil-square me-2"></i>Modifier l'Étudiant</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($etudiant['email']) ?>" required>
            </div>
            <div class="mb-4">
                <label for="numero_etudiant" class="form-label">Numéro Étudiant</label>
                <input type="text" class="form-control" id="numero_etudiant" name="numero_etudiant" value="<?= htmlspecialchars($etudiant['numero_etudiant']) ?>" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-custom">💾 Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
<footer class="text-center mt-5 mb-3 text-muted">
    &copy; <?= date('Y') ?> Gestion Étudiants. Tous droits réservés.
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
