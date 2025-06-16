<?php
session_start();
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') {
    header('Location: ../Views/connexion.php');
    exit();
}

if (!isset($_GET['qcm_id']) || !is_numeric($_GET['qcm_id'])) {
    die("Identifiant du QCM invalide.");
}

$qcm_id = intval($_GET['qcm_id']);
$questions = getQuestionsByQCM($qcm_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Questions du QCM #<?= $qcm_id ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(to right, #e6ecf3, #ffffff);
            font-family: 'Segoe UI', sans-serif;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1 0 auto;
            padding: 20px 0 40px 0;
        }
        .gmi-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    padding: 25px;
    margin-bottom: 25px;
    border-left: 6px solid rgb(115, 151, 187);
    transition: all 0.3s ease;
}
        .question-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        .reponse {
            padding: 12px 15px;
            border-radius: 12px;
            margin: 8px 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
            transition: transform 0.2s;
        }
        .reponse:hover {
            transform: scale(1.02);
        }
        .reponse.correcte {
            background-color: #d1e7dd;
            color: #0f5132;
            font-weight: bold;
        }
        .reponse.fausse {
            background-color: #f8d7da;
            color: #842029;
        }
        .reponse i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        .btn-retour {
            background-color: rgb(115, 151, 187);
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-retour:hover {
            background-color: rgb(90, 120, 150);
            transform: scale(1.05);
        }
        .section-header {
            text-align: center;
            margin-bottom: 40px;
            color: rgb(80, 110, 145);
            animation: fadeInDown 0.8s ease;
            letter-spacing: 1px;
        }
        /* Header/Footer */
        .custom-header {
            background: linear-gradient(90deg, #7397bb 60%, #e6ecf3 100%);
            color: #fff;
            padding: 18px 0 12px 0;
            box-shadow: 0 2px 10px rgba(115,151,187,0.08);
            margin-bottom: 0;
        }
        .custom-header .logo {
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
        }
        .custom-header .logo i {
            margin-right: 10px;
            font-size: 2.2rem;
        }
        .custom-footer {
            background: linear-gradient(90deg, #e6ecf3 0%, #7397bb 100%);
            color: #46607a;
            text-align: center;
            padding: 18px 0 10px 0;
            font-size: 1rem;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            box-shadow: 0 -2px 10px rgba(115,151,187,0.08);
            flex-shrink: 0;
        }
        @keyframes fadeInUp {
            0% {opacity: 0; transform: translateY(30px);}
            100% {opacity: 1; transform: translateY(0);}
        }
        @keyframes fadeInDown {
            0% {opacity: 0; transform: translateY(-30px);}
            100% {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
<!-- HEADER -->
<header class="custom-header mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <i class="bi bi-journal-text"></i>
            Gestion QCM
        </div>
        <nav>
            <a href="dashbord_enseignant.php" class="btn btn-link text-white fw-bold me-2" style="text-decoration: none;">Tableau de bord</a>
            <a href="gerer_qcms.php" class="btn btn-link text-white fw-bold me-2" style="text-decoration: none;">QCM</a>
            <a href="../Views/deconnexion.php" class="btn btn-retour ms-2"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
        </nav>
    </div>
</header>

    <div class="container main-content">
        <h2 class="section-header">🎓 Questions du QCM <?= $qcm_id ?></h2>

    <?php if (!empty($questions)) : ?>
    <?php foreach ($questions as $index => $question) : ?>
        <div class="gmi-card animate__animated animate__fadeInUp" style="animation-delay: <?= $index * 0.1 ?>s">
            <div class="question-title mb-3">QUESTION: <?= htmlspecialchars($question['texte_question']) ?></div>
            <?php
                $reponses = getReponsesByQuestionId($question['id']);
                foreach ($reponses as $reponse) :
                    $class = $reponse['est_correcte'] ? 'correcte' : 'fausse';
                    $icon = $reponse['est_correcte'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill';
            ?>
                <div class="reponse <?= $class ?>">
                    <i class="bi <?= $icon ?> me-2"></i> <?= htmlspecialchars($reponse['texte_reponse']) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <p class="text-danger text-center animate__animated animate__fadeIn">Aucune question trouvée pour ce QCM.</p>
<?php endif; ?>


    <!-- FOOTER -->
    <footer class="custom-footer mt-auto">
        <div>
            &copy; <?= date('Y') ?> Gestion QCM | Réalisé par votre équipe pédagogique
        </div>
    </footer>
</body>
</html>
