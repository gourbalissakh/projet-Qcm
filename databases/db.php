<?php
$servername = "sql202.infinityfree.com";
$dbname = "if0_39249443_qcm_plateforme";
$username = "if0_39249443";
$password = "Abbahanay6418";

try {
    // Connexion sans base
    $pdo = new PDO("mysql:host=$servername;charset=utf8mb4", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Créer la base si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

    // Se reconnecter sur la base
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création des tables (comme dans ton code)

    $pdo->exec("CREATE TABLE IF NOT EXISTS `utilisateurs` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        numero_etudiant VARCHAR(20) UNIQUE NOT NULL,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        mot_de_passe VARCHAR(255) NOT NULL,
        role ENUM('etudiant', 'enseignant') NOT NULL,
        date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // ... autres tables ...

    // Hash des mots de passe
    $adminPwd = password_hash('admin123', PASSWORD_DEFAULT);
    $etudiantPwd = password_hash('mariam123', PASSWORD_DEFAULT);

    // Insertion admin
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (numero_etudiant, nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?, ?)");
    try {
        $stmt->execute(['admin', 'Gourbal', 'Mohamed', 'gourbal@estm.edu.sn', $adminPwd, 'enseignant']);
    } catch (PDOException $e) {
        if ($e->getCode() != 23000) {
            throw $e;
        }
    }

    // Insertion étudiant
    try {
        $stmt->execute(['2025ESTM001', 'Issakh', 'Mariam', 'mariamissakh@estm.edu.sn', $etudiantPwd, 'etudiant']);
    } catch (PDOException $e) {
        if ($e->getCode() != 23000) {
            throw $e;
        }
    }

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}



// creer la table qcms si elle n'existe pas id (PK), titre, description
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `qcms` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(100) NOT NULL,
        description TEXT NOT NULL
    )");
} catch (PDOException $e) {
    die("Erreur de création de la table qcms : " . $e->getMessage());
}
// creer la table questions si elle n'existe pas id (PK), qcm_id (FK), texte_question;
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `questions` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        qcm_id INT(11) NOT NULL,
        texte_question TEXT NOT NULL,
        FOREIGN KEY (qcm_id) REFERENCES `qcms`(id) ON DELETE CASCADE
    )");
} catch (PDOException $e) {
    die("Erreur de création de la table questions : " . $e->getMessage());
}
// creer la table reponses si elle n'existe pas id (PK), question_id (FK), texte_reponse, est_correcte(boolean)
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `reponses` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        question_id INT(11) NOT NULL,
        texte_reponse TEXT NOT NULL,
        est_correcte BOOLEAN NOT NULL,
        FOREIGN KEY (question_id) REFERENCES `questions`(id) ON DELETE CASCADE
    )");
} catch (PDOException $e) {
    die("Erreur de création de la table reponses : " . $e->getMessage());
}
// creer la table resultats si elle n'existe pas id (PK), utilisateur_id (FK), qcm_id (FK), score, date_passage
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `resultats` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        utilisateur_id INT(11) NOT NULL,
        qcm_id INT(11) NOT NULL,
        score INT(11) NOT NULL,
        date_passage TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (utilisateur_id) REFERENCES `utilisateurs`(id) ON DELETE CASCADE,
        FOREIGN KEY (qcm_id) REFERENCES `qcms`(id) ON DELETE CASCADE 
    )");
} catch (PDOException $e) {
    die("Erreur de création de la table resultats : " . $e->getMessage());
}
// creer la table notes si elle n'existe pas id (PK), utilisateur_id (FK), note, date
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `notes` (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        utilisateur_id INT(11) NOT NULL,
        note FLOAT NOT NULL,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (utilisateur_id) REFERENCES `utilisateurs`(id) ON DELETE CASCADE
    )");
} catch (PDOException $e) {
    die("Erreur de création de la table notes : " . $e->getMessage());
}
