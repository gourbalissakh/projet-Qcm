<?php
session_start();
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

// Vérifier que le rôle de l'utilisateur est enseignant
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant' || !isset($_SESSION['enseignant_id'])) {
    header('Location: ../Views/connexion.php');
    exit();
}

$message = "";
$titre = "";
$description = "";

// Vérification que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validation des champs
    if (empty($titre) || empty($description)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        // Insertion du QCM dans la base de données
        try {
            $stmt = $pdo->prepare("INSERT INTO qcms (titre, description, enseignant_id) VALUES (?, ?, ?)");
            if ($stmt->execute([$titre, $description, $_SESSION['enseignant_id']])) {
                $message = "QCM créé avec succès.";
                // Optionnel : Redirection après succès
                // header('Location: liste_qcm.php');
                // exit();
                $titre = "";
                $description = "";
            } else {
                $message = "Erreur lors de la création du QCM.";
            }
        } catch (PDOException $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un QCM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --main-color: rgb(115, 151, 187); }
        body { background-color: #f8f9fa; }
        .form-container {
            animation: fadeInUp 1s ease;
            border: 1px solid var(--main-color);
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h2 { color: var(--main-color); font-weight: bold; }
        .btn-custom { background-color: var(--main-color); color: white; font-weight: 500; }
        .btn-custom:hover { background-color: rgb(95, 130, 165); }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px);}
            100% { opacity: 1; transform: translateY(0);}
        }
        .alert { font-size: 16px; }
    </style>
</head>
<body>
    <!-- Header stylisé -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: var(--main-color); border-radius: 0 0 20px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="dashbord_enseignant.php">
                <i class="bi bi-mortarboard-fill"></i> Gestion QCM
            </a>
            <div class="d-flex align-items-center ms-auto">
                <span class="text-white me-3">
                    <i class="bi bi-person-circle"></i>
                    <?= htmlspecialchars($_SESSION['prenom'] ?? 'Enseignant') ?>
                </span>
                <a href="../Views/deconnexion.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </a>
            </div>
        </div>
    </nav>
<div class="container py-5">
    <div class="form-container">
        <h2 class="text-center mb-4"><i class="bi bi-journal-plus"></i> Créer un QCM</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre du QCM</label>
                <input type="text" class="form-control" id="titre" name="titre" required value="<?= htmlspecialchars($titre) ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-custom"><i class="bi bi-check-circle"></i> Créer le QCM</button>
            </div>
        </form>
        <div class="text-center mt-4">
            <a href="dashbord_enseignant.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Retour au tableau de bord
            </a>
        </div>
    </div>
</div>
<footer class="mt-5 py-3" style="background-color: var(--main-color); border-radius: 20px 20px 0 0; box-shadow: 0 -4px 12px rgba(0,0,0,0.08);">
    <div class="container text-center text-white">
        <span>&copy; <?= date('Y') ?> Gestion QCM. Tous droits réservés.</span>
    </div>
</footer>
</body>
</html>
