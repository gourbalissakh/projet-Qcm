# 📘 Plateforme de Gestion de QCM en Ligne

![PHP](https://img.shields.io/badge/PHP-8.x-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.x-orange)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-purple)
![Statut](https://img.shields.io/badge/Statut-En%20cours-success)
![Licence](https://img.shields.io/badge/Licence-MIT-green)

---

## 🎯 Présentation

Ce projet est une **application web complète** de gestion de **QCM (Questionnaires à Choix Multiples)**. Il est conçu pour être utilisé par les étudiants, les enseignants et les administrateurs au sein d’une plateforme académique.  

> 🎓 Projet réalisé dans le cadre d’un projet fil rouge étudiant.

---

## 📸 Captures d’écran

### 🏠 Tableau de bord étudiant
<img width="941" alt="image" src="https://github.com/user-attachments/assets/e2baec83-49f3-4a96-aa0b-fd433bec83bc" />


### 🏠 Tableau de bord admin
<img width="941" alt="image" src="https://github.com/user-attachments/assets/32d8036c-0241-44dc-bb38-819e3e9b7e8e" />


### 🧑‍🏫 Ajout de QCM par l’enseignant
<img width="960" alt="image" src="https://github.com/user-attachments/assets/654baba0-99ae-4af4-885d-5bc4c20a0657" />

### L'etudiant passe le QCM
<img width="935" alt="image" src="https://github.com/user-attachments/assets/ef1091da-522e-4e9d-a9c0-23f777dc0aab" />



### 📊 Résultats après QCM

<img width="955" alt="image" src="https://github.com/user-attachments/assets/56b8d684-a8a4-487a-bf02-a6baa844ffb3" />

### Resultats des etudiants

<img width="940" alt="image" src="https://github.com/user-attachments/assets/042be045-d89e-434e-8b2f-f6057f9f5d56" />




---

## 🛠️ Fonctionnalités

- 🔐 Authentification multi-rôles (Admin, Enseignant, Étudiant)
- 🧠 Création et gestion des QCM
- ✍️ Réponse aux QCM avec correction automatique
- 📊 Calcul et affichage des résultats
- 🎨 Interface responsive (Bootstrap 5 + style GMI235)
- 🧱 Base de données sécurisée avec PDO

---

## 🧰 Technologies utilisées

| Frontend         | Backend       | Base de données |
|------------------|---------------|------------------|
| HTML5 / CSS3     | PHP 8.x       | MySQL            |
| Bootstrap 5      | PDO (PHP)     | phpMyAdmin       |
| JavaScript       |               |                  |

---

## 🚀 Installation locale

### 1. Pré-requis

- [XAMPP](https://www.apachefriends.org/) ou [WAMP](https://www.wampserver.com/)
- PHP 8.x
- MySQL
- Navigateur web (Chrome, Edge, Firefox…)

### 2. Étapes

```bash
# 1. Cloner le projet
git clone https://github.com/gourbalissakh/projet-Qcm.git

# 2. Copier le dossier dans htdocs (XAMPP) ou www (WAMP)

# 3. Importer la base de données
# Ouvrir phpMyAdmin -> Créer une base "plateforme_qcm"
# Puis importer le fichier 'plateforme_qcm.sql' fourni dans le dossier /Databases

# 4. Lancer le serveur Apache & MySQL depuis XAMPP/WAMP

# 5. Ouvrir le projet dans le navigateur :
http://localhost/projet-Qcm

