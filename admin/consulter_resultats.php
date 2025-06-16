<?php
session_start();
include_once '../databases/db.php';

// Vérifie que l'utilisateur est enseignant
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') {
    header('Location: ../Views/connexion.php');
    exit();
}

// Vérifie si on a cliqué sur un QCM
$qcm_id = isset($_GET['qcm_id']) ? intval($_GET['qcm_id']) : null;

// Si un QCM est sélectionné, récupérer les résultats
$resultats = [];
$qcm_titre = "";
if ($qcm_id) {
    $stmt = $pdo->prepare("SELECT q.titre, u.nom, u.prenom, r.score, r.date_passage
        FROM resultats r
        JOIN utilisateurs u ON u.id = r.utilisateur_id
        JOIN qcms q ON q.id = r.qcm_id
        WHERE q.id = ?
        ORDER BY r.date_passage DESC");
    $stmt->execute([$qcm_id]);
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($resultats) {
        $qcm_titre = $resultats[0]['titre'];
    } else {
        $stmt = $pdo->prepare("SELECT titre FROM qcms WHERE id = ?");
        $stmt->execute([$qcm_id]);
        $qcm_titre = $stmt->fetchColumn();
    }
} else {
    $stmt = $pdo->query("SELECT id, titre FROM qcms ORDER BY id DESC");
    $qcms = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consulter Résultats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }
        header {
            background-color: rgb(115, 151, 187);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #0d6efd;
        }
        footer {
            padding: 15px;
            text-align: center;
            margin-top: 40px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
        .card-style {
            border-left: 6px solid rgb(115, 151, 187);
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-style:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
        .btn-gmi {
            background-color: rgb(115, 151, 187);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .btn-gmi:hover {
            background-color: rgb(90, 130, 160);
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f6f9fc;
        }
    </style>
</head>
<body>

<header class="d-flex justify-content-between align-items-center" style="padding: 10px 20px; font-size: 1rem; min-height: 40px;">
    <div>
        <a href="javascript:history.back()" class="btn btn-gmi fs-6 py-1 px-2">
            <i class="bi bi-bar-chart-steps"></i> Consulter Résultats
        </a>
    </div>
    <div>
       
        <a href="profil_admin.php" class="btn btn-gmi me-2 fs-6 py-1 px-2">
            <i class="bi bi-person-circle"></i> Profil
        </a>
        <a href="../Views/deconnexion.php" class="btn btn-gmi fs-6 py-1 px-2">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
    </div>
</header>

<div class="container py-5 animate__animated animate__fadeInUp">
    <h2 class="text-center mb-4 text-primary">
        <?= $qcm_id ? "Résultats du QCM : <span class='text-dark'>$qcm_titre</span>" : "Tous les QCMs disponibles" ?>
    </h2>

    <?php if (!$qcm_id): ?>
        <?php if (!empty($qcms)): ?>
            <?php foreach ($qcms as $qcm): ?>
                <div class="card-style d-flex justify-content-between align-items-center animate__animated animate__zoomIn">
                    <h5 class="mb-0"><i class="bi bi-journal-text"></i> <?= htmlspecialchars($qcm['titre']) ?></h5>
                    <a href="consulter_resultats.php?qcm_id=<?= $qcm['id'] ?>" class="btn btn-gmi">
                        <i class="bi bi-bar-chart-line"></i> Voir les résultats
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Aucun QCM disponible.</p>
        <?php endif; ?>
    <?php else: ?>
        <?php if (!empty($resultats)): ?>
            <table class="table table-bordered table-striped mt-4 animate__animated animate__fadeIn">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nom & Prénom</th>
                        <th>Score</th>
                        <th>Date de passage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultats as $index => $res): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($res['prenom']) . ' ' . htmlspecialchars($res['nom']) ?></td>
                            <td><strong><?= $res['score'] ?>/20</strong></td>
                            <td><?= $res['date_passage'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-warning mt-4">Aucun étudiant n’a encore passé ce QCM.</p>
        <?php endif; ?>
        <?php
        // Calculer les statistiques si des résultats existent
        if (!empty($resultats)) {
            $scores = array_column($resultats, 'score');
            $nb_etudiants = count($scores);
            $moyenne = round(array_sum($scores) / $nb_etudiants, 2);
            $min = min($scores);
            $max = max($scores);

            // Calcul de la médiane
            sort($scores);
            $milieu = floor($nb_etudiants / 2);
            if ($nb_etudiants % 2) {
                $mediane = $scores[$milieu];
            } else {
                $mediane = round(($scores[$milieu - 1] + $scores[$milieu]) / 2, 2);
            }
            ?>
            <div class="card-style mt-4">
                <h5 class="mb-3"><i class="bi bi-graph-up"></i> Statistiques des notes</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nombre d'étudiants : <strong><?= $nb_etudiants ?></strong></li>
                    <li class="list-group-item">Moyenne : <strong><?= $moyenne ?>/20</strong></li>
                    <li class="list-group-item">Médiane : <strong><?= $mediane ?>/20</strong></li>
                    <li class="list-group-item">Note minimale : <strong><?= $min ?>/20</strong></li>
                    <li class="list-group-item">Note maximale : <strong><?= $max ?>/20</strong></li>
                </ul>
            </div>
            <?php
        }
        ?>

        <div class="text-center mt-5">
            <a href="consulter_resultats.php" class="btn btn-gmi">
                ← Retour à la liste des QCMs
            </a>
        </div>
    <?php endif; ?>
</div>

<footer class="animate__animated animate__fadeInUp">
    <p>&copy; <?= date('Y') ?> Plateforme QCM ESTM | GMI235</p>
</footer>

</body>
</html>
