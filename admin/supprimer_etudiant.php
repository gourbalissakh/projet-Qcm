<?php
session_start();
// Inclure le fichier de connexion à la base de données
include_once '../databases/db.php';
include_once '../databases/fonctions.php';
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['enseignant_id'])) {
    header('Location: ../Views/connexion.php');
    exit();
}
// Vérifier si l'ID de l'étudiant est passé en paramètre
if (isset($_GET['id'])) {
    $etudiant_id = $_GET['id'];

    // Préparer la requête de suppression
    try {
        $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ? AND role = 'etudiant'");
        $stmt->execute([$etudiant_id]);

        // Rediriger vers la page de gestion des étudiants avec un message de succès
        header('Location: gerer_etudiants.php?success=1');
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la suppression de l'étudiant : " . $e->getMessage());
    }
} else {
    // Rediriger vers la page de gestion des étudiants si l'ID n'est pas fourni
    header('Location: gerer_etudiants.php?error=1');
    exit();
}



?>