<?php
session_start();
// Inclure le fichier de connexion à la base de données
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

if (isset($_GET['supprimer'])) {
    $qcm_id = intval($_GET['supprimer']);
    if ($qcm_id > 0) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM qcms WHERE id = ?");
            $stmt->execute([$qcm_id]);
            if ($stmt->fetchColumn() == 0) {
                $error = "Le QCM demandé n'existe pas.";
            } else {
                $pdo->beginTransaction();

                // Supprimer résultats liés
                $stmt = $pdo->prepare("DELETE FROM resultats WHERE qcm_id = ?");
                $stmt->execute([$qcm_id]);

                // Supprimer questions liées
                $stmt = $pdo->prepare("DELETE FROM questions WHERE qcm_id = ?");
                $stmt->execute([$qcm_id]);

                // Supprimer QCM
                $stmt = $pdo->prepare("DELETE FROM qcms WHERE id = ?");
                $stmt->execute([$qcm_id]);

                $pdo->commit();

                $message = "Le QCM #$qcm_id a été supprimé avec succès.";
                header("Location: gerer_qcms.php?msg=" . urlencode($message));
                exit();
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = "Erreur lors de la suppression : " . $e->getMessage();
        }
    } else {
        $error = "ID de QCM invalide.";
    }
}


$qcms = getAllQCMs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des QCMs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --main-color: rgb(115, 151, 187);
        }

        body {
            background-color: #f8f9fa;
        }

        .table-container {
            animation: fadeInUp 1s ease;
            border: 1px solid var(--main-color);
        }

        .btn-custom {
            background-color: var(--main-color);
            color: white;
        }

        .btn-custom:hover {
            background-color: rgb(95, 130, 165);
        }

        .table thead {
            background-color: var(--main-color);
            color: white;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table tbody tr {
            transition: all 0.3s ease-in-out;
        }

        .table tbody tr:hover {
            background-color: rgba(115, 151, 187, 0.1);
            transform: scale(1.01);
        }

        h2 {
            color: var(--main-color);
        }
    </style>
</head>
<body class="mt-5">
<?php include_once 'header_admin.php'; ?>

<h2 class="mb-4 text-center"><i class="bi bi-journal-check"></i> Gestion des QCMs</h2>

<div class="table-responsive table-container shadow rounded p-3 bg-white">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th><i class="bi bi-card-text"></i> Titre</th>
                <th><i class="bi bi-file-text"></i> Description</th>
                <th><i class="bi bi-gear-fill"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($qcms as $index => $qcm): ?>
                <tr class="qcm-row">
                    <td><?= htmlspecialchars($qcm['id']) ?></td>
                    <td><?= htmlspecialchars($qcm['titre']) ?></td>
                    <td><?= htmlspecialchars($qcm['description']) ?></td>
                    <td>
                        <a href="modifier_qcm.php?id=<?= $qcm['id'] ?>" class="btn btn-warning btn-sm" title="Modifier">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="gerer_qcms.php?supprimer=<?= $qcm['id'] ?>" class="btn btn-danger btn-sm" title="Supprimer" onclick="return confirm('Confirmer la suppression ?')">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <!-- ajouter des questions et reponse au QCM -->
                        <a href="ajouter_question.php?qcm_id=<?= $qcm['id'] ?>" class="btn btn-primary btn-sm" title="Ajouter une question">
                            <i class="bi bi-plus-square"></i>
                        </a>
                        <a href="voir_questions.php?qcm_id=<?= $qcm['id'] ?>" class="btn btn-info btn-sm" title="Voir les questions et réponses">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="text-center mt-4">
        <a href="dashbord_enseignant.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Retour au tableau de bord
        </a>
        <a href="ajouter_qcm.php" class="btn btn-custom ms-2">
            <i class="bi bi-plus-circle"></i> Ajouter un QCM
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const rows = document.querySelectorAll('.qcm-row');
        rows.forEach((row, index) => {
            row.style.opacity = 0;
            row.style.transform = 'translateY(20px)';
            setTimeout(() => {
                row.style.transition = 'all 0.6s ease';
                row.style.opacity = 1;
                row.style.transform = 'translateY(0)';
            }, index * 150);
        });
    });
</script>
<footer class="mt-5 py-3" style="background-color: #f8f9fa; color: #7397bb; position: fixed; left: 0; bottom: 0; width: 100%; z-index: 1030;">
    <div class="container text-center">
        <span>&copy; <?= date('Y') ?> Gestion des QCMs - Tous droits réservés.</span>
    </div>
</footer>

</body>
</html>
