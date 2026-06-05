<?php
session_start();
$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ---- CONFIGURATION INIFINITYFREE EN LIGNE ----
    $serveur = "sql101.infinityfree.com"; 
    $utilisateur = "if0_42103233";
    $nom_base = "if0_42103233_esssaibdd"; 
    
    // À TOI DE JOUER : Colle ton mot de passe secret entre les deux guillemets ci-dessous
    $mot_de_passe = "Manouelle24"; 
    // ----------------------------------------------
    
    $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base);

    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }
    
    $login = $conn->real_escape_string($_POST['login']);
    $password = $conn->real_escape_string($_POST['password']);

    // Requête de connexion (et non d'inscription)
    $sql = "SELECT * FROM User WHERE login='$login' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $login;
        header("Location: Accueil.php");
        exit();
    } else {
        $message = "<div style='color: red; margin-bottom: 15px;'>Identifiant ou mot de passe incorrect.</div>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ENEAM</title>
    <link rel="stylesheet" href="css.css"> <!-- Ton CSS -->
</head>
<body>

<div class="top-bar-promo">
    Bienvenue sur la plateforme de gestion centralisée <strong>ENEAM / UAC</strong>.
</div>

<div class="container" style="margin-top: 40px;">
    <div class="form-container">
        <h2>Connexion</h2>

        <?php echo $message; ?> <!-- Affiche l'erreur si login raté -->

        <form action="" method="POST">
            <div class="form-group">
                <label>Identifiant (Login)</label>
                <input type="text" name="login" required>
            </div>
            
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-index btn-login">Connexion</button>
            
            <div class="btn-container-index">
                <!-- Lien vers ton formulaire d'inscription -->
                <a href="Formulaire_user.php" class="btn-index btn-register" style="line-height: 2.8; text-decoration: none; text-align: center;">S'inscrire</a>
            </div>
        </form>
    </div>
</div>

<div class="footer">
    &copy; 2026 ENEAM - Tous droits réservés
</div>

</body>
</html>