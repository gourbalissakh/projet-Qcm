<?php
session_start();
// Inclure le fichier de connexion à la base de données
include_once '../databases/db.php';
include_once '../databases/fonctions.php';
// Vérifier si l'utilisateur a rempli le formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérifier les informations de connexion
    $utilisateur = verifierConnexion($email, $password, $pdo);

if ($utilisateur) {
    // Connexion réussie, stocker les informations de l'utilisateur dans la session
    $_SESSION['utilisateur_id'] = $utilisateur['id'];
    $_SESSION['role'] = $utilisateur['role'];

    // Rediriger vers le tableau de bord associé au rôle de l'utilisateur
   if ($utilisateur['role'] === 'etudiant') {
    $_SESSION['etudiant_id'] = $utilisateur['id']; // Ajoute cette ligne
    $_SESSION['etudiant_nom'] = $utilisateur['nom'] ?? 'Étudiant'; // Optionnel
    header('Location: ../Etudiant/dashbord_etudiant.php');
}
 elseif ($utilisateur['role'] === 'enseignant') {
        $_SESSION['enseignant_id'] = $utilisateur['id']; // Ajout pour dashboard_enseignant
        $_SESSION['enseignant_nom'] = $utilisateur['nom'] ?? 'Enseignant';
        header('Location: ../admin/dashbord_enseignant.php');
    }

    exit();
}
 else {
        // Connexion échouée, afficher un message d'erreur
        $error_message = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --gmi: rgb(115, 151, 187);
            --gmi-dark: rgb(95, 131, 167);
            --bg: #f0f6fa;
        }

        body {
            background: linear-gradient(to right, #e3edf7, #f5fafe);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: var(--gmi);
        }

        .navbar-brand img {
            transition: transform 0.3s ease-in-out;
        }

        .navbar-brand:hover img {
            transform: scale(1.1);
        }

        .form-container {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
            animation: fadeIn 1s ease;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--gmi-dark);
        }

        .btn-primary {
            background-color: var(--gmi);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--gmi-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(115, 151, 187, 0.5);
        }

        footer {
            text-align: center;
            padding: 20px 0;
            color: #888;
            background-color: #fff;
            box-shadow: 0 -1px 6px rgba(0, 0, 0, 0.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

<!-- 🔷 Header avec logo ESTM -->
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="/Travail/projet_fil_rouge/views/index.php">
            <img src="../images/estm-logo.png" alt="Logo ESTM" width="45" height="45">
        </a>
    </div>
</nav>

<!-- 🧾 Formulaire de Connexion -->
<div class="form-container">
    <div class="login-card">
        <h2>Connexion</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="ex: nom@exemple.com" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
</div>

<!-- ⏬ Footer -->
<footer>
    &copy; 2025 ESTM - Tous droits réservés
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
