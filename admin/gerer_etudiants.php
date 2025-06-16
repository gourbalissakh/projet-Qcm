<?php
session_start();
include_once '../databases/db.php';
include_once '../databases/fonctions.php';

if (!isset($_SESSION['enseignant_id'])) {
    header('Location: ../Views/connexion.php');
    exit();
}

$enseignant_id = $_SESSION['enseignant_id'];
$enseignant_nom = $_SESSION['enseignant_nom'] ?? 'Profil';

try {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE role = 'etudiant'");
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des étudiants : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Étudiants</title>
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
<body>
<?php include_once 'header_admin.php'; ?>

<div class="container py-5">
    <h2 class="mb-4 text-center"><i class="bi bi-people-fill"></i> Gestion des Étudiants</h2>
    <div class="table-responsive table-container shadow rounded p-3 bg-white">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><i class="bi bi-person-fill"></i> Nom</th>
                    <th><i class="bi bi-envelope-fill"></i> Email</th>
                    <th><i class="bi bi-hash"></i> Numéro étudiant</th>
                    <th><i class="bi bi-person-badge-fill"></i> Rôle</th>
                    <th><i class="bi bi-gear-fill"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr class="student-row">
                        <td><?= htmlspecialchars($etudiant['id']) ?></td>
                        <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['email']) ?></td>
                        <td><?= htmlspecialchars($etudiant['numero_etudiant']) ?></td>
                        <td><?= htmlspecialchars($etudiant['role']) ?></td>
                        <td>
                            <a href="modifier_etudiant.php?id=<?= $etudiant['id'] ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="supprimer_etudiant.php?id=<?= $etudiant['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">
                                <i class="bi bi-trash-fill"></i>
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
            <a href="ajouter_etudiant.php" class="btn btn-custom ms-2">
                <i class="bi bi-plus-circle"></i> Ajouter un Étudiant
            </a>
        </div>
        <!-- ajouter un nouveau Etudiant -->
        
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const rows = document.querySelectorAll('.student-row');
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
<footer class="mt-5 py-3 bg-light border-top text-center" style="color: var(--main-color); font-weight: 500;">
    &copy; <?= date('Y') ?> Gestion des Étudiants - Tous droits réservés.
</footer>
</body>
</html>
<?php 

?>