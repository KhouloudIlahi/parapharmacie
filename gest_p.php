<!DOCTYPE html>
<html>
<head>
    <title>Gestion des produits</title>
    <style>
        /* Style personnalisé pour la page */
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

        .btn {
            padding: 15px 30px;
            text-decoration: none;
            color: #fff;
            background-color: #b6dade;
            border-radius: 10px;
            transition: background-color 0.3s;
            margin-left: 50px;
        }

        .btn:hover {
            background-color: #1e91a3;
        }

        /* Style pour la table des produits */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
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
        <h1>Liste des produits</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
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

                // Récupérer la liste des produits depuis la base de données
                $sql = "SELECT id_p, nom_p, prix, photo FROM produits";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id_p"] . "</td>";
                        echo "<td>" . $row["nom_p"] . "</td>";
                        echo "<td>" . $row["prix"] . "</td>";
                        echo "<td><img src='uploads/" . $row["photo"] . "' height='50'></td>";
                        echo "<td>";
                        echo "<a href='modifier.php?id=" . $row["id_p"] . "' class='btn'>Modifier</a>";
                        echo "<a href='supprimer.php?id=" . $row["id_p"] . "' class='btn'>Supprimer</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Aucun produit trouvé.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <a href="ajout.php" class="btn">Ajouter un produit</a>
    </div>
</body>
</html>
