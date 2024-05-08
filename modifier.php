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

// Vérifier si l'ID du produit à modifier est présent dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations actuelles du produit
    $sql = "SELECT id_p, nom_p, prix, photo FROM produits WHERE id_p = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nom_p = $row['nom_p'];
        $prix = $row['prix'];
        $photo = $row['photo'];
    } else {
        echo "Aucun produit trouvé avec cet ID.";
        exit;
    }

    // Vérifier si le formulaire de modification a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom_p = $_POST['nom'];
        $prix = $_POST['prix'];

        // Préparer et exécuter la requête SQL pour mettre à jour le produit
        $sql = "UPDATE produits SET nom_p = ?, prix = ? WHERE id_p = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdi", $nom_p, $prix, $id);
        $stmt->execute();

        // Redirection vers la page de gestion des produits après la modification
        header('Location: gest_p.php');
        exit;
    }
} else {
    echo "ID du produit non spécifié.";
    exit;
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un produit</title>
    <style>
        /* Style personnalisé pour la page */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f8f8;
}

.container {
    max-width: 900px;
    margin: 30px auto;
    padding: 30px;
    background-color: #f8f9fa;
    border: 2px solid #6c757d;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
    color: #333;
    font-size: 2.5em;
    margin-bottom: 30px;
}

label, input {
    display: block;
    margin-bottom: 10px;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.btn {
            padding: 15px 30px;
            text-decoration: none;
            color: #fff;
            background-color: #b6dade;
            border-radius: 10px;
            transition: background-color 0.3s;
            margin-left: 50px;
            display: inline-block;
        }
        .btn:hover {
            background-color: #1e91a3;
        }


    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier un produit</h1>
        <form method="post">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo $nom_p; ?>" required>
            
            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" value="<?php echo $prix; ?>" min="0.01" step="0.01" required>
            
            <input type="submit" value="Modifier" class="btn">
        </form>
    </div>
</body>
</html>
