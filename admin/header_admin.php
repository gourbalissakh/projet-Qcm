<?php


// Vérifier si l'enseignant est connecté
if (!isset($_SESSION['enseignant_id'])) {
    header('Location: connexion.php');
    exit();
}

// Récupérer les informations de l'enseignant (exemple)
$enseignant_nom = isset($_SESSION['enseignant_nom']) ? $_SESSION['enseignant_nom'] : 'Profil';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Enseignant</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


</head>
<body>
    <header style="background:rgb(115, 151, 187); color:#fff; padding:15px 30px; display:flex; justify-content:space-between; align-items:center;">
        <!--logo de estm s'il clique il va dans la page precedente  -->
        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="/Travail/projet_fil_rouge/views/connexion.php" class="navbar-brand" style="margin-right: 5px;">
            <img src="../images/estm-logo.png" alt="Logo ESTM" width="40" height="40">
            </a>
            <!-- icone pour retourner vers la page d'accueil -->
            
        </div>
        <!-- Titre du tableau de bord -->
        <div>
            <h1 style="margin:0; font-size:24px;">Tableau de bord Enseignant</h1>
        </div>
        <!-- Informations de l'enseignant à droite  avec des icons bootstrap-->
        <div>

            <a href="profil_admin.php" class="btn btn-secondary btn-sm">
                <i class="bi bi-person-circle"></i> Profil
            </a>
            <a href="../Views/deconnexion.php" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </a>
        </div>
        

    </header>
</body>
</html>