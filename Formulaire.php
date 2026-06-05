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
        
        $id = $conn->real_escape_string($_POST['Id_article']);
        $Design = $conn->real_escape_string($_POST['Design']);
        $prix = $conn->real_escape_string($_POST['Prix']);
        $Catégorie = $conn->real_escape_string($_POST['Catégorie']);
        
        $sql = "INSERT INTO article (Id_article, Design, Prix, Catégorie) 
                VALUES ('$id', '$Design', '$prix', '$Catégorie')";
                
        if ($conn->query($sql) === TRUE) {
            header("Location: Tableau_Article.php");
            exit();
        } else {
            $message = "<div class='error-msg'>Erreur : " . $conn->error . "</div>";
        }
        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement d'un Article - ENEAM</title>
    <!-- Liaison directe au style Blissim unique -->
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <br>
    <div class="nav-bar">
        <a href="accueil.php" class="btn-retour">← Accueil</a>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Nouvel Article</h2>
            
            <?php echo $message; ?>

            <form method="post" action="Formulaire.php">
                <div class="form-group">
                    <label>Identifiant de l'article</label>
                    <input type="number" name="Id_article" placeholder="Ex: 2026" required>
                </div>

                <div class="form-group">
                    <label>Désignation</label>
                    <input type="text" name="Design" placeholder="Nom de l'article" required>
                </div>

                <div class="form-group">
                    <label>Catégorie</label>
                    <input type="text" name="Catégorie" placeholder="Ex: Informatique" required>
                </div>

                <div class="form-group">
                    <label>Prix Unitaire (FCFA)</label>
                    <input type="number" name="Prix" id="Prix" placeholder="0.00" step="0.01" required>
                </div>

                <div class="btn-container-index">
                    <button type="submit" class="btn-submit" style="flex: 2;">Enregistrer l'article</button>
                    <a href="Tableau_Article.php" class="btn-cancel" style="flex: 1; text-align: center; line-height: 2.2;">Annuler</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="footer">
        &copy; 2026 ENEAM - Tous droits réservés
    </div>

</body>
</html>
