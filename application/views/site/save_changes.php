<?php
// save_changes.php

$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "your_database_name"; // Remplacez par le nom de votre base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données JSON envoyées
$data = json_decode(file_get_contents('php://input'), true);
$block1 = $data['block1'];
$block2 = $data['block2'];

// Préparer et lier
$stmt = $conn->prepare("UPDATE your_table_name SET block1_column = ?, block2_column = ? WHERE id = ?"); // Remplacez par votre table et colonnes
$stmt->bind_param("ssi", $block1, $block2, $id);

// Exécuter la requête
if ($stmt->execute()) {
    echo json_encode(['message' => 'Changes saved successfully.']);
} else {
    echo json_encode(['message' => 'Error saving changes: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
