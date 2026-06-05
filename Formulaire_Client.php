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

    // Récupération sécurisée des données selon la structure de ta table
    $id = $conn->real_escape_string($_POST['Id_client']);
    $nom = $conn->real_escape_string($_POST['Nom']);
    $prenom = $conn->real_escape_string($_POST['Prénom']);
    $age = $conn->real_escape_string($_POST['Age']);
    $adresse = $conn->real_escape_string($_POST['Adresse']);
    $ville = $conn->real_escape_string($_POST['Ville']);
    $email = $conn->real_escape_string($_POST['Email']);

    // Insertion dans la table client
    $sql = "INSERT INTO client (Id_client, Nom, Prénom, Age, Adresse, Ville, Email) 
            VALUES ('$id', '$nom', '$prenom', '$age', '$adresse', '$ville', '$email')";

    if ($conn->query($sql) === TRUE) {
        header("Location: Tableau_Client.php");
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
    <title>Nouveau Client - MA BOUTIQUE ENEAM</title>
    <!-- On relie au CSS commun style Blissim -->
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <br>
    <div class="nav-bar">
        <a href="Accueil.php" class="btn-retour">← Accueil</a>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Nouveau Client</h2>
            
            <?php if($message != ""): ?>
                <div class="error-msg"><?php echo $message; ?></div>
            <?php endif; ?>

            <form action="Formulaire_Client.php" method="POST">
                <div class="form-group">
                    <label>Identifiant Client (Id_client)</label>
                    <input type="number" name="Id_client" placeholder="Ex: 101" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="Nom" placeholder="Nom du client" required>
                    </div>
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" name="Prénom" placeholder="Prénom du client" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Âge</label>
                        <input type="number" name="Age" placeholder="Âge" required>
                    </div>
                    <div class="form-group">
                        <label>Ville</label>
                        <input type="text" name="Ville" placeholder="Ville" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Adresse</label>
                    <input type="text" name="Adresse" placeholder="Adresse de résidence" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Email" placeholder="exemple@domaine.com" required>
                </div>

                <button type="submit" class="btn-submit">Enregistrer le client</button>
            </form>

            <div class="retour-lien-bloc">
                <a href="Tableau_Client.php" class="retour">Retour à la liste des clients</a>
            </div>
        </div>
    </div>

</body>
</html>