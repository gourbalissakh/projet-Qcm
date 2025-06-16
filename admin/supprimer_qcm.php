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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qcm_id = intval($_POST['qcm_id'] ?? 0);

    if ($qcm_id <= 0) {
        $error = "L'ID du QCM est obligatoire et doit être un nombre positif.";
    } else {
        // Vérifier si le QCM existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM qcms WHERE id = ?");
        $stmt->execute([$qcm_id]);
        if ($stmt->fetchColumn() == 0) {
            $error = "Le QCM avec l'ID $qcm_id n'existe pas.";
        } else {
            try {
                // Commencer une transaction
                $pdo->beginTransaction();

                // Supprimer les résultats liés (si tu as une table resultats, sinon adapte)
                $stmt = $pdo->prepare("DELETE FROM resultats WHERE qcm_id = ?");
                $stmt->execute([$qcm_id]);

                // Supprimer le QCM
                $stmt = $pdo->prepare("DELETE FROM qcms WHERE id = ?");
                $stmt->execute([$qcm_id]);

                // Valider la transaction
                $pdo->commit();

                $message = "Le QCM #$qcm_id a été supprimé avec succès.";
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Erreur lors de la suppression : " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Supprimer un QCM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #eaf0f6, #d6e4f0);
      font-family: 'Segoe UI', sans-serif;
    }
    .card-gmi235 {
      background: white;
      border-radius: 20px;
      padding: 30px;
      max-width: 500px;
      margin: 60px auto;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-gmi235:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    h2 {
      color: rgb(115, 151, 187);
      font-weight: bold;
      margin-bottom: 25px;
      text-align: center;
    }
    .btn-danger {
      background-color: #dc3545;
      border-radius: 12px;
      padding: 10px 20px;
      border: none;
      width: 100%;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .btn-danger:hover {
      background-color: #b02a37;
    }
    .form-control {
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
      box-shadow: 0 3px 10px rgba(15,81,50,0.2);
      text-align: center;
    }
    .alert-danger {
      background-color: #f8d7da;
      color: #842029;
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 20px;
      font-weight: 600;
      box-shadow: 0 3px 10px rgba(132,32,41,0.2);
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="card-gmi235">
    <h2><i class="bi bi-trash me-2 text-danger"></i>Supprimer un QCM</h2>

    <?php if ($message): ?>
      <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce QCM ? Cette action est irréversible !');" novalidate>
      <div class="mb-3">
        <label for="qcm_id" class="form-label">ID du QCM à supprimer</label>
        <input type="number" class="form-control" id="qcm_id" name="qcm_id" required min="1" value="<?= isset($_POST['qcm_id']) ? intval($_POST['qcm_id']) : '' ?>" />
      </div>
      <button type="submit" class="btn btn-danger">
        <i class="bi bi-trash me-2"></i>Supprimer le QCM
      </button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
