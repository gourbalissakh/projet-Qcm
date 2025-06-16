<?php
session_start();
include_once '../databases/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header('Location: ../Views/connexion.php');
    exit();
}

$utilisateur_id = $_SESSION['etudiant_id'] ?? $_SESSION['id'] ?? null;
if (!$utilisateur_id) {
    die("Erreur d'identification.");
}

function mention($score) {
    if ($score >= 16) return "<span class='badge rounded-pill bg-success'> Très Bien</span>";
    elseif ($score >= 14) return "<span class='badge rounded-pill bg-info text-dark'> Bien</span>";
    elseif ($score >= 10) return "<span class='badge rounded-pill bg-warning text-dark'> Passable</span>";
    else return "<span class='badge rounded-pill bg-danger'> Insuffisant</span>";
}

if (isset($_GET['qcm_id'])) {
    $qcm_id = intval($_GET['qcm_id']);
    $stmt = $pdo->prepare("SELECT q.titre, r.score, r.date_passage FROM qcms q
        JOIN resultats r ON q.id = r.qcm_id
        WHERE r.utilisateur_id = ? AND q.id = ?");
    $stmt->execute([$utilisateur_id, $qcm_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Résultat du QCM</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <style>
            body {
                background: linear-gradient(135deg, #e6f0ff, #ffffff);
                font-family: 'Segoe UI', sans-serif;
            }
            .container {
                max-width: 700px;
                margin: 60px auto;
                background-color: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 0 25px rgba(0, 0, 0, 0.08);
            }
            .btn-custom {
                background-color: #7397bb;
                color: white;
                border-radius: 12px;
                padding: 10px 20px;
                font-weight: 600;
                border: none;
            }
            .btn-custom:hover {
                background-color: #5c85a8;
            }
        </style>
    </head>
    <body>
        <div class="container animate__animated animate__fadeInDown">
            <?php if ($row): ?>
                <h3 class="mb-4 text-center text-primary"> Résultat du QCM : <?= htmlspecialchars($row['titre']) ?></h3>
                <p><strong>Score :</strong> <?= $row['score'] ?>/20</p>
                <p><strong>Mention :</strong> <?= mention($row['score']) ?></p>
                <p><strong>Date :</strong> <?= $row['date_passage'] ?></p>
            <?php else: ?>
                <p class="text-danger">Aucun résultat trouvé pour ce QCM.</p>
            <?php endif; ?>
            <a href="resultats.php" class="btn btn-custom mt-3">← Retour</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Liste globale
$stmt = $pdo->prepare("SELECT q.id, q.titre, r.score, r.date_passage FROM qcms q
    JOIN resultats r ON q.id = r.qcm_id
    WHERE r.utilisateur_id = ?");
$stmt->execute([$utilisateur_id]);
$qcms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Résultats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Animate -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(120deg, #dceefc, #f9fcff);
            font-family: 'Segoe UI', sans-serif;
        }

        .header {
            background: linear-gradient(to right, #7397bb, #b3cde9);
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qcm-card {
            background: white;
            border-left: 6px solid #7397bb;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .footer {
            background: #e2f0fc;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
            font-size: 0.95rem;
        }

        .btn-profile {
            background-color: white;
            border-radius: 10px;
            padding: 6px 14px;
            font-weight: 600;
            color: #3a5c7d;
            border: 1px solid #fff;
        }

        .btn-profile:hover {
            background-color: #f4faff;
            color: #2d4f6f;
        }
    </style>
</head>
<body>

<!-- Header moderne stylisé -->
<div class="header shadow-sm mb-4 animate__animated animate__fadeInDown">
    <a href="dashbord_etudiant.php" class="d-flex align-items-center text-decoration-none">
        <img src="../images/estm-logo.png" alt="ESTM Logo" style="height:40px; margin-right:12px;">
        <span class="fs-4 fw-bold text-white">ESTM</span>
    </a>
       <a href="../Etudiant/profil_etudiant.php" class="btn btn-profile me-2"><i class="bi bi-person-circle"></i> Profil</a>
        <a href="../Views/deconnexion.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        <!-- Bootstrap Icons CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    </div>
</div>

<!-- Résultats -->
<div class="container mt-5 animate__animated animate__fadeInUp">
    <h3 class="text-center text-primary mb-4"> Mes QCMs Passés</h3>
    <?php if ($qcms): ?>
        <?php foreach ($qcms as $qcm): ?>
            <div class="qcm-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5><?= htmlspecialchars($qcm['titre']) ?></h5>
                        <small class="text-muted"> <?= $qcm['date_passage'] ?></small><br>
                        <?= mention($qcm['score']) ?>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary fs-5"><?= $qcm['score'] ?>/20</span><br>
                        <a href="resultats.php?qcm_id=<?= $qcm['id'] ?>" class="btn btn-sm btn-outline-primary mt-2">🔍 Détail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted text-center">Aucun QCM encore passé.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<div class="footer">
    &copy; <?= date('Y') ?> ESTM - Plateforme QCM | Design  GMI235 
</div>

</body>
</html>
