<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];
    $priorite = $_POST['priorite'];
    $date_limite = !empty($_POST['date_limite']) ? $_POST['date_limite'] : null;

    $sql = "UPDATE taches
            SET titre = ?, description = ?, statut = ?, priorite = ?, date_limite = ?
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $description, $statut, $priorite, $date_limite, $id]);

    header("Location: index.php");
    exit;
}

$sql = "SELECT * FROM taches WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$tache = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tache) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier une tâche</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(135deg, #dbeafe, #fce7f3);
    padding: 30px;
}

.container {
    max-width: 500px;
    margin: auto;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

input, textarea, select, button {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
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

.back {
    display: block;
    text-align: center;
    margin-top: 10px;
    text-decoration: none;
    color: #4f46e5;
}
</style>
</head>

<body>

<div class="container">
<div class="card">

<h1>Modifier la tâche</h1>

<form method="POST" onsubmit="return verifierFormulaire()">

<input type="text" name="titre" id="titre"
value="<?= htmlspecialchars($tache['titre']) ?>">

<textarea name="description"><?= htmlspecialchars($tache['description']) ?></textarea>

<select name="statut">
    <option value="a_faire" <?= $tache['statut'] === 'a_faire' ? 'selected' : '' ?>>À faire</option>
    <option value="en_cours" <?= $tache['statut'] === 'en_cours' ? 'selected' : '' ?>>En cours</option>
    <option value="termine" <?= $tache['statut'] === 'termine' ? 'selected' : '' ?>>Terminée</option>
</select>

<select name="priorite">
    <option value="basse" <?= $tache['priorite'] === 'basse' ? 'selected' : '' ?>>Basse</option>
    <option value="moyenne" <?= $tache['priorite'] === 'moyenne' ? 'selected' : '' ?>>Moyenne</option>
    <option value="haute" <?= $tache['priorite'] === 'haute' ? 'selected' : '' ?>>Haute</option>
</select>

<input type="date" name="date_limite" id="date_limite"
value="<?= htmlspecialchars($tache['date_limite']) ?>">

<button type="submit">Enregistrer</button>

</form>

<a href="index.php" class="back">← Retour</a>

</div>
</div>

<script>
function verifierFormulaire() {
    let titre = document.getElementById("titre").value.trim();
    let date = document.getElementById("date_limite").value;

    if (titre === "") {
        alert("Le titre est obligatoire");
        return false;
    }

    if (date === "") {
        alert("La date est obligatoire");
        return false;
    }

    return true;
}
</script>

</body>
</html>