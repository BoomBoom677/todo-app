#  Mini projet Todo App

## Objectif
Créer une application web permettant de gérer des tâches :
- ajouter
- modifier
- supprimer
- afficher

---

## Fonctionnalités

- Ajouter une tâche via un formulaire
- Modifier une tâche
- Supprimer une tâche
- Afficher les tâches triées par priorité
- Filtrer les tâches (toutes / à faire / terminées)
- Vérification JavaScript (titre et date obligatoires)

---

## Base de données

Importer le fichier `todo_app.sql` dans MySQL.

Structure de la table `taches` :
- `id`
- `titre`
- `description`
- `statut`
- `priorite`
- `date_limite`
- `date_creation`

---

## Installation

1. Placer le projet dans le dossier du serveur local 
2. Lancer Apache et MySQL
3. Importer le fichier `todo_app.sql` dans phpMyAdmin
4. Configurer les identifiants dans `config.php`
5. Ouvrir dans le navigateur :

## 🔒 Sécurité

- Utilisation de `htmlspecialchars` pour sécuriser l’affichage
- Utilisation de requêtes préparées (PDO) pour éviter les injections SQL

## 🛠️ Technologies utilisées

- PHP
- MySQL
- JavaScript
- HTML / CSS