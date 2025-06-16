<?php
session_start();
include_once '../databases/db.php';

// Vérifier si l'enseignant est connecté
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') {
    header('Location: ../Views/connexion.php');
    exit();
}

// Vérifier que qcm_id est présent en GET
if (!isset($_GET['qcm_id'])) {
    die("Identifiant du QCM manquant.");
}
$qcm_id = intval($_GET['qcm_id']);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question'] ?? '');
    $reponses = [
        trim($_POST['reponse1'] ?? ''),
        trim($_POST['reponse2'] ?? ''),
        trim($_POST['reponse3'] ?? ''),
        trim($_POST['reponse4'] ?? ''),
        trim($_POST['reponse5'] ?? ''),
    ];
    $reponse_correcte = intval($_POST['reponse_correcte'] ?? 0);

    if ($question === '' || in_array('', $reponses) || $reponse_correcte < 1 || $reponse_correcte > 5) {
        $message = "Merci de remplir tous les champs correctement.";
    } else {
        try {
            $pdo->beginTransaction();

            // Insertion de la question liée au QCM
           $stmtQ = $pdo->prepare("INSERT INTO questions (qcm_id, texte_question) VALUES (?, ?)");
            $stmtQ->execute([$qcm_id, $question]);
            $question_id = $pdo->lastInsertId();

            // Insertion des réponses avec indication de la bonne réponse
           $stmtR = $pdo->prepare("INSERT INTO reponses (question_id, texte_reponse, est_correcte) VALUES (?, ?, ?)");

            foreach ($reponses as $index => $texteReponse) {
                $est_correcte = ($index + 1 === $reponse_correcte) ? 1 : 0;
                $stmtR->execute([$question_id, $texteReponse, $est_correcte]);
            }

            $pdo->commit();
            $message = "Question ajoutée avec succès !";

            // Optionnel : vider les champs après succès
            $_POST = [];
        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "Erreur lors de l'ajout de la question : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ajouter une Question - QCM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        /* Ton style CSS existant */
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
        }
        .card-gmi235:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        h2 {
            color: rgb(115, 151, 187);
            font-weight: bold;
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
        .form-control, .form-select {
            border-radius: 10px;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header class="mb-4">
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #7397bb; border-radius: 0 0 20px 20px;">
            <div class="container">
                <a class="navbar-brand text-white fw-bold" href="gerer_qcms.php">
                    <i class="bi bi-journal-text me-2"></i>Gestion QCM
                </a>
                <div class="d-flex align-items-center ms-auto">
                    <span class="text-white me-3">
                        <i class="bi bi-person-circle me-1"></i>
                        <?= htmlspecialchars($_SESSION['prenom'] ?? 'Enseignant') ?>
                    </span>
                    <a href="../Views/deconnexion.php" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <div class="card-gmi235 mx-auto" style="max-width: 700px;">
            <h2 class="text-center mb-4"><i class="bi bi-plus-circle me-2"></i>Ajouter une question au QCM</h2>

            <?php if ($message): ?>
                <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form action="ajouter_question.php?qcm_id=<?= $qcm_id ?>" method="POST">
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <input type="text" class="form-control" id="question" name="question" required value="<?= htmlspecialchars($_POST['question'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="reponse1" class="form-label">Réponse 1</label>
                    <input type="text" class="form-control" id="reponse1" name="reponse1" required value="<?= htmlspecialchars($_POST['reponse1'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="reponse2" class="form-label">Réponse 2</label>
                    <input type="text" class="form-control" id="reponse2" name="reponse2" required value="<?= htmlspecialchars($_POST['reponse2'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="reponse3" class="form-label">Réponse 3</label>
                    <input type="text" class="form-control" id="reponse3" name="reponse3" required value="<?= htmlspecialchars($_POST['reponse3'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="reponse4" class="form-label">Réponse 4</label>
                    <input type="text" class="form-control" id="reponse4" name="reponse4" required value="<?= htmlspecialchars($_POST['reponse4'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="reponse5" class="form-label">Réponse 5</label>
                    <input type="text" class="form-control" id="reponse5" name="reponse5" required value="<?= htmlspecialchars($_POST['reponse5'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="reponse_correcte" class="form-label">Réponse Correcte</label>
                    <select class="form-select" id="reponse_correcte" name="reponse_correcte" required>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            $selected = (isset($_POST['reponse_correcte']) && intval($_POST['reponse_correcte']) === $i) ? 'selected' : '';
                            echo "<option value=\"$i\" $selected>Réponse $i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send-fill me-1"></i> Ajouter la question
                    </button>
                </div>
                <div class="mt-3 text-center">
                    <a href="gerer_qcms.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Retour à l'accueil</a>
                </div>
            </form>
        </div>
    </div>
    <footer class="mt-5 text-center text-muted">
        <hr>
        <small>&copy; <?= date('Y') ?> Gestion QCM - Tous droits réservés.</small>
    </footer>
</body>
</html>
