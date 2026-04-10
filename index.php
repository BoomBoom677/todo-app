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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #dbeafe, #fce7f3, #dcfce7);
            padding: 30px 15px;
            color: #1f2937;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .title {
            text-align: center;
            margin-bottom: 25px;
        }

        .title h1 {
            margin-bottom: 8px;
            color: #111827;
        }

        .title p {
            color: #4b5563;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 20px;
        }

        .card {
            background: #ffffff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin-bottom: 15px;
            color: #111827;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
        }

        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #6366f1;
        }

        button {
            background: #4f46e5;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #4338ca;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .topbar select {
            max-width: 200px;
            margin-bottom: 0;
        }

        .task-list {
            display: grid;
            gap: 12px;
        }

        .task {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 15px;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .task-title {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .a_faire {
            background: #fee2e2;
            color: #b91c1c;
        }

        .en_cours {
            background: #fef3c7;
            color: #b45309;
        }

        .termine {
            background: #dcfce7;
            color: #15803d;
        }

        .priority {
            display: inline-block;
            margin: 8px 0;
            padding: 5px 10px;
            border-radius: 999px;
            background: #e0e7ff;
            color: #3730a3;
            font-size: 12px;
            font-weight: bold;
        }

        .task p {
            margin: 8px 0;
            color: #475569;
            line-height: 1.5;
        }

        .meta {
            font-size: 13px;
            color: #64748b;
            margin-top: 8px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .actions a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .edit-btn {
            background: #2563eb;
        }

        .edit-btn:hover {
            background: #1d4ed8;
        }

        .delete-btn {
            background: #dc2626;
        }

        .delete-btn:hover {
            background: #b91c1c;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #64748b;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
        }

        @media (max-width: 850px) {
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
        <p>Ajoute, filtre, modifie et supprime tes tâches facilement.</p>
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

            <div class="task-list">
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

                            <span class="priority">
                                Priorité : <?= htmlspecialchars($tache['priorite']) ?>
                            </span>

                            <div class="meta">
                                Date limite : <?= htmlspecialchars($tache['date_limite']) ?><br>
                                Créée le : <?= htmlspecialchars($tache['date_creation']) ?>
                            </div>

                            <div class="actions">
                                <a class="edit-btn" href="modifier.php?id=<?= htmlspecialchars($tache['id']) ?>">Modifier</a>
                                <a class="delete-btn" href="supprimer.php?id=<?= htmlspecialchars($tache['id']) ?>" onclick="return confirm('Supprimer cette tâche ?')">Supprimer</a>
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