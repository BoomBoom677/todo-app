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
</head>
<body>
    <h1>Modifier une tâche</h1>

    <form method="POST">
        <input type="text" name="titre" value="<?= htmlspecialchars($tache['titre']) ?>" required>
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

        <input type="date" name="date_limite" value="<?= htmlspecialchars($tache['date_limite']) ?>">

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>