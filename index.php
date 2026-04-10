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
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            color: #1e293b;
            min-height: 100vh;
            padding: 30px 15px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            margin-bottom: 30px;
        }

        .title h1 {
            font-size: 2.4rem;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .title p {
            color: #475569;
            font-size: 1rem;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 24px;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
            padding: 22px;
        }

        .card h2 {
            font-size: 1.2rem;
            margin-bottom: 18px;
            color: #0f172a;
        }

        form label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.92rem;
            font-weight: bold;
            color: #334155;
        }

        input, textarea, select, button {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 12px;
            font-size: 0.95rem;
            margin-bottom: 14px;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        textarea {
            min-height: 95px;
            resize: vertical;
        }

        button {
            background: #4f46e5;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .topbar select {
            max-width: 220px;
            margin-bottom: 0;
        }

        .task-list {
            display: grid;
            gap: 14px;
        }

        .task {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            background: #f8fafc;
            transition: 0.2s;
        }

        .task:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .task-title {
            font-size: 1.05rem;
            font-weight: bold;
            color: #0f172a;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: bold;
            white-space: nowrap;
        }

        .a_faire { background: #fee2e2; color: #b91c1c; }
        .en_cours { background: #fef3c7; color: #b45309; }
        .termine { background: #dcfce7; color: #15803d; }

        .priority {
            display: inline-block;
            margin-top: 8px;
            margin-right: 8px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 0.78rem;
            background: #e2e8f0;
            color: #334155;
        }

        .task p {
            color: #475569;
            margin: 8px 0 10px;
            line-height: 1.5;
        }

        .meta {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 10px;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #64748b;
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            background: #f8fafc;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }
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