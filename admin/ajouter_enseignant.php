<?php
session_start();
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['enseignant_id'])) {
    header('Location: connexion.php');
    exit();
}
// Inclure les fichiers nécessaires
include_once '../databases/db.php'; // Assurez-vous que ce fichier crée bien $pdo
include_once '../databases/fonctions.php';

// verifier que le formulaire a ete soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $numero_etudiant = $_POST['numero_etudiant'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hash du mot de passe

    // Préparer la requête d'insertion
    try {
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, numero_etudiant, mot_de_passe, role) VALUES (?, ?, ?, ?, ?, 'enseignant')");
        $stmt->execute([$nom, $prenom, $email, $numero_etudiant, $mot_de_passe]);

        // Rediriger vers la page de gestion des étudiants avec un message de succès
        header('Location: gerer_etudiants.php?success=1');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de l'étudiant : " . $e->getMessage());
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --main-color: rgb(115, 151, 187);
        }

        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: white;
            border: 1px solid var(--main-color);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease;
        }

        .form-title {
            color: var(--main-color);
            font-weight: 600;
        }

        .btn-custom {
            background-color: var(--main-color);
            color: white;
        }

        .btn-custom:hover {
            background-color: rgb(95, 130, 165);
        }

        label {
            font-weight: 500;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        input:focus {
            border-color: var(--main-color);
            box-shadow: 0 0 0 0.2rem rgba(115, 151, 187, 0.25);
        }
   
body {
    background: linear-gradient(to right, #e9f3fb, #fefefe);
    font-family: 'Segoe UI', sans-serif;
}

.table {
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease-in-out;
}

.table th {
    background-color: #7397bb;
    color: white;
    text-align: center;
}

.table-hover tbody tr:hover {
    background-color: rgba(115, 151, 187, 0.15);
    transform: scale(1.01);
    transition: 0.2s ease-in-out;
}

.table td, .table th {
    vertical-align: middle;
    text-align: center;
}

h4.text-primary {
    font-weight: bold;
    animation: fadeInDown 0.8s;
    position: relative;
}

h4.text-primary::after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background-color: #7397bb;
    margin: 8px auto 0;
    border-radius: 2px;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: var(--main-color);">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="dashbord_enseignant.php">
            <i class="bi bi-mortarboard-fill"></i> Gestion Enseignants
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="gerer_etudiants.php">
                        <i class="bi bi-people-fill"></i> Étudiants
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="ajouter_enseignant.php">
                        <i class="bi bi-person-plus-fill"></i> Ajouter Enseignant
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../Views/deconnexion.php">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container">
            <h2 class="text-center form-title mb-4">
                <i class="bi bi-person-plus-fill"></i> Ajouter un Enseignant
            </h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nom" class="form-label"><i class="bi bi-person-fill"></i> Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label"><i class="bi bi-person-fill"></i> Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <!-- numero Etudiant -->
                <div class="mb-3">
                    <label for="numero_etudiant" class="form-label"><i class="bi bi-hash"></i> Numéro Étudiant</label>
                    <input type="text" class="form-control" id="numero_etudiant" name="numero_etudiant" required>
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label"><i class="bi bi-lock-fill"></i> Mot de passe</label>
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-custom">
                        <i class="bi bi-check-circle"></i> Ajouter Étudiant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4 class="mb-3 text-center text-primary"><i class="bi bi-person-lines-fill"></i> Liste des Enseignants</h4>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Numéro Étudiant</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                try {
                    $stmt = $pdo->prepare("SELECT nom, prenom, email, numero_etudiant FROM utilisateurs WHERE role = 'enseignant'");
                    $stmt->execute();
                    $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($enseignants) {
                        foreach ($enseignants as $enseignant) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($enseignant['nom']) . "</td>";
                            echo "<td>" . htmlspecialchars($enseignant['prenom']) . "</td>";
                            echo "<td>" . htmlspecialchars($enseignant['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($enseignant['numero_etudiant']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td colspan="4" class="text-center">Aucun enseignant trouvé.</td></tr>';
                    }
                } catch (PDOException $e) {
                    echo '<tr><td colspan="4" class="text-danger text-center">Erreur lors de la récupération des enseignants.</td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<footer class="mt-5 py-4" style="background: var(--main-color); color: white;">
    <div class="container text-center">
        
        <div>
            © <?php echo date('Y'); ?> Gestion Enseignants. Tous droits réservés.
        </div>
       
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
