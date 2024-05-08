<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "parapharmacie";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Vérifier si l'ID du produit à supprimer est présent dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer et exécuter la requête SQL pour supprimer le produit
    $stmt = $conn->prepare("DELETE FROM produits WHERE id_p = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirection vers la page de gestion des produits après la suppression
    header('Location: gest_p.php');
    exit;
} else {
    echo "ID du produit non spécifié.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
