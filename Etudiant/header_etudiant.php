<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Étudiant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --main-color: rgb(115, 151, 187);
            --hover-color: rgb(95, 130, 165);
            --bg-light: #f4f9fc;
            --text-light: #f0f0f0;
        }

        body {
            margin: 0;
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .gmi-header {
            background: linear-gradient(to right, var(--main-color), #7da4c2);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            color: white;
            position: relative;
            z-index: 10;
        }

        .gmi-header .logo img {
            width: 40px;
            height: 40px;
            transition: transform 0.3s ease;
        }

        .gmi-header .logo:hover img {
            transform: scale(1.1);
        }

        .gmi-header .btn-nav {
            color: white;
            font-weight: 500;
            border: 1px solid rgba(255,255,255,0.3);
            background-color: transparent;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .gmi-header .btn-nav:hover {
            background-color: var(--hover-color);
            transform: scale(1.05);
        }

        .gmi-header .btn-danger:hover {
            transform: scale(1.05);
        }

        .header-title {
            font-size: 1.2rem;
            font-weight: bold;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
            margin: 0;
            color: white;
        }

        .header-group {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .gmi-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-group {
                width: 100%;
                justify-content: space-between;
                margin-top: 10px;
            }

            .header-title {
                font-size: 1.1rem;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<header class="gmi-header">
    <!-- Logo + Accueil -->
    <div class="header-group logo">
        <a href="/Travail/projet_fil_rouge/views/index.php">
            <img src="../images/estm-logo.png" alt="Logo ESTM">
        </a>
        
    </div>

    <!-- Titre -->
    <h1 class="header-title text-center">🎓 Tableau de bord Étudiant</h1>

    <!-- Profil + Déconnexion -->
    <div class="header-group">
        <a href="profil_etudiant.php" class="btn btn-outline-light btn-sm btn-nav">
            <i class="bi bi-person-circle"></i> Profil
        </a>
        <a href="../Views/deconnexion.php" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
        </a>
    </div>
</header>


</body>
</html>
