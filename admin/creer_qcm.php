<?php
session_start();
// Inclure les fichiers nécessaires
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['enseignant_id'])) {
    header('Location: ../Views/connexion.php');
    exit();
}

// Récupérer l'ID de l'enseignant
$enseignant_id = $_SESSION['enseignant_id'];
$enseignant_nom = $_SESSION['enseignant_nom'] ?? 'Profil';

// Si le formulaire est soumis, traiter les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Validation des champs
    if (empty($titre) || empty($description)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        // Enregistrer le QCM dans la base de données
        try {
            $stmt = $pdo->prepare("INSERT INTO qcms (titre, description, enseignant_id) VALUES (:titre, :description, :enseignant_id)");
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':enseignant_id' => $enseignant_id
            ]);
            $message = "QCM créé avec succès !";
        } catch (PDOException $e) {
            $message = "Erreur lors de la création du QCM : " . $e->getMessage();
        }
    }
} else {
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un QCM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(135deg, #eef2ff 0%, #c7d2fe 100%);
            min-height: 100vh;
        }
        .qcm-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 2.5rem 2rem;
            max-width: 500px;
            margin: auto;
            border-top: 6px solid #4f46e5;
        }
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }
        .btn-primary {
            background: linear-gradient(90deg, #4f46e5 0%, #818cf8 100%);
            border: none;
            transition: transform 0.2s;
        }
        .btn-primary:active {
            transform: scale(0.97);
        }
        .form-label {
            color: #4f46e5;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="qcm-card animate__animated animate__fadeInUp">
            <h1 class="mb-4 text-center fw-bold" style="color:#4f46e5;">Créer un QCM</h1>

            <!-- Affichage du message de succès ou d'erreur -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info text-center">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form id="qcmForm" method="post" action="">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du QCM :</label>
                    <input type="text" id="titre" name="titre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Créer le QCM</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.form-control').forEach(function(input) {
            input.addEventListener('focus', function() {
                this.classList.add('animate__animated', 'animate__pulse');
            });
            input.addEventListener('blur', function() {
                this.classList.remove('animate__animated', 'animate__pulse');
            });
        });

        document.getElementById('qcmForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.classList.add('animate__animated', 'animate__tada');
            setTimeout(() => {
                btn.classList.remove('animate__animated', 'animate__tada');
            }, 800);
        });
    </script>
</body>
</html>
<?php
session_start();
// Inclure les fichiers nécessaires
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['enseignant_id'])) {
    header('Location: ../Views/connexion.php');
    exit();
}

// Récupérer l'ID de l'enseignant
$enseignant_id = $_SESSION['enseignant_id'];
$enseignant_nom = $_SESSION['enseignant_nom'] ?? 'Profil';

// Si le formulaire est soumis, traiter les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Validation des champs
    if (empty($titre) || empty($description)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        // Enregistrer le QCM dans la base de données
        try {
            $stmt = $pdo->prepare("INSERT INTO qcms (titre, description, enseignant_id) VALUES (:titre, :description, :enseignant_id)");
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':enseignant_id' => $enseignant_id
            ]);
            $message = "QCM créé avec succès !";
        } catch (PDOException $e) {
            $message = "Erreur lors de la création du QCM : " . $e->getMessage();
        }
    }
} else {
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un QCM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(135deg, #eef2ff 0%, #c7d2fe 100%);
            min-height: 100vh;
        }
        .qcm-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 2.5rem 2rem;
            max-width: 500px;
            margin: auto;
            border-top: 6px solid #4f46e5;
        }
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.15);
        }
        .btn-primary {
            background: linear-gradient(90deg, #4f46e5 0%, #818cf8 100%);
            border: none;
            transition: transform 0.2s;
        }
        .btn-primary:active {
            transform: scale(0.97);
        }
        .form-label {
            color: #4f46e5;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="qcm-card animate__animated animate__fadeInUp">
            <h1 class="mb-4 text-center fw-bold" style="color:#4f46e5;">Créer un QCM</h1>

            <!-- Affichage du message de succès ou d'erreur -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info text-center">
                    <?= htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form id="qcmForm" method="post" action="">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre du QCM :</label>
                    <input type="text" id="titre" name="titre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Créer le QCM</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.form-control').forEach(function(input) {
            input.addEventListener('focus', function() {
                this.classList.add('animate__animated', 'animate__pulse');
            });
            input.addEventListener('blur', function() {
                this.classList.remove('animate__animated', 'animate__pulse');
            });
        });

        document.getElementById('qcmForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.classList.add('animate__animated', 'animate__tada');
            setTimeout(() => {
                btn.classList.remove('animate__animated', 'animate__tada');
            }, 800);
        });
    </script>
</body>
</html>
