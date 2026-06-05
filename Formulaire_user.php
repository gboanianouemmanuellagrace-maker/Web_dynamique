<?php
    $message = ""; 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // ---- CONFIGURATION INIFINITYFREE EN LIGNE ----
        $serveur = "sql101.infinityfree.com";
        $utilisateur = "if0_42103233";
        $nom_base = "if0_42103233_esssaibdd"; 
        
        // À TOI DE JOUER : Colle ton mot de passe d'hébergement secret entre les deux guillemets ci-dessous
        $mot_de_passe = "Manouelle24"; 
        // ----------------------------------------------
        
        $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $nom_base);

        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }
        
        $id = $conn->real_escape_string($_POST['id_user']);
        $nom = $conn->real_escape_string($_POST['nom']);
        $prenom = $conn->real_escape_string($_POST['prenom']);
        $contact = $conn->real_escape_string($_POST['contact']);
        $login = $conn->real_escape_string($_POST['login']);
        $password = $conn->real_escape_string($_POST['password']);

        $sql = "INSERT INTO User (id_user, nom, prénom, contact, login, password) 
                VALUES ('$id', '$nom', '$prenom', '$contact', '$login', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: Tableau_User.php");
            exit();
        } else {
            $message = "Erreur : " . $conn->error;
        }
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Utilisateur</title>
    <!-- Liaison avec le fichier CSS global unique -->
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <br>
    <div class="nav-bar">
        <a href="connexion.php" class="btn-retour">← Se connecter / Retour</a>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Nouveau Utilisateur</h2>
            
            <?php if($message != ""): ?>
                <div class="error-msg"><?php echo $message; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label>ID Utilisateur</label>
                    <input type="number" name="id_user" placeholder="Ex: 2101" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" placeholder="Votre nom" required>
                    </div>

                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" name="prenom" placeholder="Votre prénom" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Contact</label>
                    <input type="number" name="contact" placeholder="Numéro de téléphone EX: 01 XX XX XX XX" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Login</label>
                        <input type="text" name="login" placeholder="Nom d'utilisateur" required>
                    </div>

                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="password" placeholder="********" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Enregistrer</button>
            </form>
        </div>
    </div>

    <div class="footer">
        &copy; 2026 - Plateforme de Gestion - ENEAM / UAC
    </div>

</body>
</html>