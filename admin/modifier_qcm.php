<?php
session_start();
include_once '../databases/db.php';

// Vérifie que l'utilisateur est enseignant
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') {
    header('Location: ../Views/connexion.php');
    exit();
}

$message = "";
$error = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qcm_id = intval($_POST['qcm_id'] ?? 0);
    $new_title = trim($_POST['new_title'] ?? '');
    $new_description = trim($_POST['new_description'] ?? '');

    if ($qcm_id <= 0 || empty($new_title)) {
        $error = "L'ID du QCM et le nouveau titre sont obligatoires.";
    } else {
        // Vérifier si le QCM existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM qcms WHERE id = ?");
        $stmt->execute([$qcm_id]);
        if ($stmt->fetchColumn() == 0) {
            $error = "Le QCM avec l'ID $qcm_id n'existe pas.";
        } else {
            // Mettre à jour le QCM
            $stmt = $pdo->prepare("UPDATE qcms SET titre = ?, description = ? WHERE id = ?");
            $success = $stmt->execute([$new_title, $new_description, $qcm_id]);
            if ($success) {
                $message = "Le QCM #$qcm_id a été modifié avec succès.";
            } else {
                $error = "Une erreur est survenue lors de la modification.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Modifier QCM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #eaf0f6, #d6e4f0);
      font-family: 'Segoe UI', sans-serif;
    }

    .card-gmi235 {
      background-color: #ffffff;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      max-width: 700px;
      margin: 50px auto;
    }

    .card-gmi235:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    h2 {
      color: rgb(115, 151, 187);
      font-weight: bold;
      margin-bottom: 30px;
    }

    label {
      font-weight: 500;
    }

    .btn-primary {
      background-color: rgb(115, 151, 187);
      border: none;
      border-radius: 12px;
      padding: 10px 20px;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: rgb(95, 131, 167);
    }

    .form-control, .form-select, textarea {
      border-radius: 10px;
      box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
    }

    .alert-success {
      background-color: #d1e7dd;
      color: #0f5132;
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 20px;
      font-weight: 600;
      box-shadow: 0 3px 10px rgba(15, 81, 50, 0.2);
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #842029;
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 20px;
      font-weight: 600;
      box-shadow: 0 3px 10px rgba(132, 32, 41, 0.2);
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background: #7397bb; box-shadow: 0 4px 18px rgba(115,151,187,0.12);">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="../index.php">
      <i class="bi bi-journal-text me-2"></i>Gestion QCM
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-white" href="../admin/dashbord_enseignant.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="../admin/ajouter_qcm.php"><i class="bi bi-plus-circle me-1"></i>Ajouter QCM</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="../Views/deconnexion.php"><i class="bi bi-box-arrow-right me-1"></i>Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
  <div class="card-gmi235">
    <h2><i class="bi bi-pencil-square me-2"></i>Modifier le QCM</h2>

    <?php if ($message): ?>
      <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="modifier_qcm.php" method="post" novalidate>
      <div class="mb-3">
        <label for="qcm_id" class="form-label">ID du QCM</label>
        <input type="number" class="form-control" id="qcm_id" name="qcm_id" required min="1" value="<?= isset($_POST['qcm_id']) ? intval($_POST['qcm_id']) : '' ?>">
      </div>
      <div class="mb-3">
        <label for="new_title" class="form-label">Nouveau Titre</label>
        <input type="text" class="form-control" id="new_title" name="new_title" required value="<?= htmlspecialchars($_POST['new_title'] ?? '') ?>">
      </div>
      <div class="mb-3">
        <label for="new_description" class="form-label">Nouvelle Description</label>
        <textarea class="form-control" id="new_description" name="new_description" rows="3"><?= htmlspecialchars($_POST['new_description'] ?? '') ?></textarea>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save me-2"></i>Enregistrer les modifications
        </button>
      </div>
    </form>
  </div>
  <footer class="text-center mt-5 mb-3">
    <div class="container">
      <hr>
      <span class="text-muted">&copy; <?= date('Y') ?> Gestion QCM - Tous droits réservés.</span>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
