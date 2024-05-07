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

$error_message = ""; // Message d'erreur initialisé à vide

// Traitement du formulaire d'authentification de l'admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = isset($_POST['username']) ? $_POST['username'] : "";
    $mdp_a = isset($_POST['password']) ? $_POST['password'] : "";

    // Requête SQL pour vérifier si l'administrateur existe dans la base de données
    $sql = "SELECT * FROM admin WHERE user_name = '$user_name' AND mdp_a = '$mdp_a'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Démarrer la session et stocker l'identifiant de l'administrateur
        session_start();
        $_SESSION['user_name'] = $user_name;
        // Rediriger vers l'interface d'administration
        header("Location: gestion.php");
        exit();
    } else {
        // L'administrateur n'existe pas ou les identifiants sont incorrects
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <title>Administration</title>
    <style>
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                
                <form action="login.php" method="post">
                    <h2>Authentification</h2>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="username" required> 
                        <label for="">username</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" required>
                        <label for="">Mot de passe</label>
                    </div>
                
                    <button type="submit">Log In</button> 
                 
                </form>
                <br/>
                <div>
                    <?php
                    if ($error_message) {
                        echo "<div class='error-message'>$error_message</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script> 
</body>
</html>
