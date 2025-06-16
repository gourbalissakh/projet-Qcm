<?php
session_start();
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'etudiant') {
    header('Location: ../Views/connexion.php');
    exit();
}

$etudiant_id = $_SESSION['etudiant_id'] ?? $_SESSION['id'] ?? null;
if (!$etudiant_id) {
    die("Erreur d'identification.");
}

if (!isset($_GET['qcm_id'])) {
    die("Identifiant du QCM manquant.");
}
$qcm_id = intval($_GET['qcm_id']);

$stmtQcm = $pdo->prepare("SELECT titre, description FROM qcms WHERE id = ?");
$stmtQcm->execute([$qcm_id]);
$qcm = $stmtQcm->fetch(PDO::FETCH_ASSOC);
if (!$qcm) {
    die("QCM introuvable.");
}

$message = "";
$score = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questions = getQuestionsByQCM($qcm_id);
    $total = count($questions);
    $correctes = 0;

    foreach ($questions as $question) {
        $qid = $question['id'];
        $reponse_donnee = $_POST['question_' . $qid] ?? null;
        $reponses = getReponsesByQuestionId($qid);
        foreach ($reponses as $reponse) {
            if ($reponse['est_correcte'] == 1) {
                $bonne_reponse = $reponse['id'];
                break;
            }
        }
        if ($reponse_donnee !== null && intval($reponse_donnee) === intval($bonne_reponse)) {
            $correctes++;
        }
    }

    $score = round(($correctes / $total) * 20, 2);

    $check = $pdo->prepare("SELECT id FROM resultats WHERE utilisateur_id = ? AND qcm_id = ?");
    $check->execute([$etudiant_id, $qcm_id]);
    if ($check->rowCount() === 0) {
        $insert = $pdo->prepare("INSERT INTO resultats (utilisateur_id, qcm_id, score) VALUES (?, ?, ?)");
        $insert->execute([$etudiant_id, $qcm_id, $score]);
    }

    $message = "🎉 Votre note est : <strong>$score / 20</strong>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Passer le QCM : <?= htmlspecialchars($qcm['titre']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(135deg, #e3f0fd, #f4f9fc);
            font-family: 'Segoe UI', sans-serif;
            padding-top: 70px;
        }

        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 10;
            background: linear-gradient(to right, #7397bb, #4d648d);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            animation: fadeInLeft 1s;
        }

        .btn-header {
            background-color: white;
            color: #4d648d;
            border-radius: 10px;
            padding: 6px 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-header:hover {
            background-color: #d4e1ef;
            color: #2f3e58;
        }

        .container-qcm {
            max-width: 960px;
            margin: auto;
        }

        .card-gmi235 {
            background: white;
            border-left: 6px solid #7397bb;
            border-radius: 18px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            padding: 20px 25px;
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-gmi235:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: rgb(115, 151, 187);
            border-radius: 15px;
            padding: 12px 32px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: rgb(95, 131, 167);
            transform: scale(1.05);
        }

        .alert-info {
            background-color: rgba(115, 151, 187, 0.2);
            font-weight: 600;
            border-left: 6px solid #7397bb;
        }

        footer {
            margin-top: 100px;
            padding: 20px;
            text-align: center;
            background-color: #d7e9f7;
            font-size: 0.95rem;
            color: #3b4e68;
            animation: fadeInUp 1s;
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Header -->
<header>
<div>
    <a href="javascript:history.back()" class="btn btn-header me-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>
    <div>
        <a href="profil_etudiant.php" class="btn btn-header me-2"><i class="bi bi-person"></i> Profil</a>
        <a href="../Views/deconnexion.php" class="btn btn-header"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
    </div>
</header>

<!-- Contenu -->
<div class="container container-qcm animate__animated animate__fadeInUp">
    <h2 class="text-center mb-4 text-primary animate__animated animate__fadeInDown"><?= htmlspecialchars($qcm['titre']) ?></h2>
    <p class="text-center mb-5 animate__animated animate__fadeInDown animate__delay-1s">
        <?= nl2br(htmlspecialchars($qcm['description'])) ?>
    </p>

    <?php if ($message): ?>
        <div class="alert alert-info text-center animate__animated animate__fadeInDown"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($score === null): ?>
        <form method="POST" action="" class="animate__animated animate__fadeInUp animate__delay-1s">
            <?php
            $questions = getQuestionsByQCM($qcm_id);
            foreach ($questions as $index => $question):
                $reponses = getReponsesByQuestionId($question['id']);
            ?>
                <div class="card-gmi235">
                    <h5>Question <?= $index + 1 ?> :</h5>
                    <p><strong><?= htmlspecialchars($question['texte_question']) ?></strong></p>
                    <?php foreach ($reponses as $reponse): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                name="question_<?= $question['id'] ?>"
                                id="q<?= $question['id'] ?>r<?= $reponse['id'] ?>"
                                value="<?= $reponse['id'] ?>" required>
                            <label class="form-check-label" for="q<?= $question['id'] ?>r<?= $reponse['id'] ?>">
                                <?= htmlspecialchars($reponse['texte_reponse']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__infinite">Soumettre</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    &copy; <?= date('Y') ?> ESTM - Plateforme QCM | Design GMI235 
</footer>

</body>
</html>
