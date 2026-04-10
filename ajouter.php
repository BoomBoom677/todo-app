<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $statut = $_POST['statut'];
    $priorite = $_POST['priorite'];
    $date_limite = !empty($_POST['date_limite']) ? $_POST['date_limite'] : null;

    $sql = "INSERT INTO taches (titre, description, statut, priorite, date_limite)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $description, $statut, $priorite, $date_limite]);

    header("Location: index.php");
    exit;
}
?>