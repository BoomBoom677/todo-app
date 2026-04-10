<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM taches ORDER BY 
    CASE priorite
        WHEN 'haute' THEN 1
        WHEN 'moyenne' THEN 2
        WHEN 'basse' THEN 3
    END,
    date_limite ASC");

$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>
    <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: Arial;
    background: linear-gradient(135deg, #eef2ff, #f8fafc);
    padding: 30px;
}

.container {
    max-width: 1000px;
    margin: auto;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.grid {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 20px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

input, textarea, select, button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    background: #4f46e5;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background: #4338ca;
}

.task {
    background: #f8fafc;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 10px;
}

.task strong {
    display: block;
}

.badge {
    padding: 4px 8px;
    border-radius: 10px;
    font-size: 12px;
    color: white;
}

.a_faire { background: red; }
.en_cours { background: orange; }
.termine { background: green; }

@media (max-width: 800px) {
    .grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>
<div class="container">
    <div class="title">
        <h1>Gestion des tâches</h1>
        <p>Ajoute, filtre et consulte tes tâches facilement.</p>
    </div>

    <div class="grid">
        <div class="card">
            <h2>Ajouter une tâche</h2>
            <form action="ajouter.php" method="POST" onsubmit="return verifierFormulaire()">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre" placeholder="Ex : Finir le mini projet">

                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Décris rapidement la tâche..."></textarea>

                <label for="statut">Statut</label>
                <select name="statut" id="statut">
                    <option value="a_faire">À faire</option>
                    <option value="en_cours">En cours</option>
                    <option value="termine">Terminée</option>
                </select>

                <label for="priorite">Priorité</label>
                <select name="priorite" id="priorite">
                    <option value="basse">Basse</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="haute">Haute</option>
                </select>

                <label for="date_limite">Date limite</label>
                <input type="date" name="date_limite" id="date_limite">

                <button type="submit">Ajouter la tâche</button>
            </form>
        </div>

        <div class="card">
            <div class="topbar">
                <h2>Liste des tâches</h2>
                <select id="filtreStatut" onchange="filtrerTaches()">
                    <option value="toutes">Toutes</option>
                    <option value="a_faire">À faire</option>
                    <option value="termine">Terminées</option>
                </select>
            </div>

            <div class="task-list" id="listeTaches">
                <?php if (count($taches) > 0): ?>
                    <?php foreach ($taches as $tache): ?>
                        <div class="task" data-statut="<?= htmlspecialchars($tache['statut']) ?>">
                            <div class="task-header">
                                <div class="task-title"><?= htmlspecialchars($tache['titre']) ?></div>
                                <span class="badge <?= htmlspecialchars($tache['statut']) ?>">
                                    <?= htmlspecialchars($tache['statut']) ?>
                                </span>
                            </div>

                            <p><?= htmlspecialchars($tache['description']) ?></p>

                            <span class="priority">Priorité : <?= htmlspecialchars($tache['priorite']) ?></span>

                            <div class="meta">
                                Date limite : <?= htmlspecialchars($tache['date_limite']) ?><br>
                                Créée le : <?= htmlspecialchars($tache['date_creation']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty">Aucune tâche enregistrée pour le moment.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function verifierFormulaire() {
    const titre = document.getElementById("titre").value.trim();
    const date = document.getElementById("date_limite").value;

    if (titre === "") {
        alert("Le titre ne doit pas être vide.");
        return false;
    }

    if (date === "") {
        alert("La date limite est obligatoire.");
        return false;
    }

    return true;
}

function filtrerTaches() {
    const filtre = document.getElementById("filtreStatut").value;
    const taches = document.querySelectorAll(".task");

    taches.forEach(tache => {
        const statut = tache.getAttribute("data-statut");

        if (filtre === "toutes" || statut === filtre) {
            tache.style.display = "block";
        } else {
            tache.style.display = "none";
        }
    });
}
</script>
</body>
</html>