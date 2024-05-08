<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label, input, textarea {
            display: block;
            margin-bottom: 10px;
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
        .error {
            color: red;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un produit</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            
            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" min="0.01" step="0.01" required>
            
            <label for="photo">Photo :</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>
            
            <input type="submit" value="Ajouter" class="btn">
        </form>
    </div>
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

    // Traitement du formulaire d'ajout de produit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom_p = $_POST['nom'];
        $prix = $_POST['prix'];

        // Vérifier si un fichier a été téléchargé
        if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
            $photo = $_FILES['photo']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);

            // Déplacer le fichier téléchargé vers le dossier d'uploads
            if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                // Préparer et exécuter la requête SQL pour ajouter le produit
                $stmt = $conn->prepare("INSERT INTO produits (nom_p, prix, photo) VALUES (?, ?, ?)");
                $stmt->bind_param("sds", $nom_p, $prix, $photo);
                $stmt->execute();

                // Redirection vers une page de confirmation
                header('Location: gest_p.php');
                exit;
            } else {
                echo "Erreur lors de l'upload du fichier.";
            }
        } else {
            echo "Aucun fichier sélectionné ou erreur lors du téléchargement.";
        }
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
</body>
</html>