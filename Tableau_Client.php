<?php
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

$sql = "SELECT * FROM client";
$resultat = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients - ENEAM</title>
    <!-- Raccordement au style Blissim unique -->
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <br>
    <div class="nav-bar">
        <a href="Accueil.php" class="btn-retour">← Retour Accueil</a>
    </div>

    <div class="container" style="background-color: var(--bg-card); padding: 30px; border-radius: 4px; border: 1px solid var(--border-color); box-shadow: 0 4px 20px var(--shadow-soft);">
        <div class="header" style="border: none; padding: 0; margin-bottom: 35px; background: transparent; box-shadow: none;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 28px; margin: 0; color: var(--text-dark);">Tableau des Clients</h2>
            <a href="Formulaire_Client.php" class="btn-nouvelle-vente" style="background-color: var(--text-dark); color: white; padding: 10px 20px; text-decoration: none; font-size: 0.9em; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">+ Ajouter Nouveau</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultat->num_rows > 0) {
                    while($row = $resultat->fetch_assoc()) {
                        // Inclusion de TOUS les champs réels de ta table client
                        echo "<tr>
                                <td><strong>#" . $row["Id_client"] . "</strong></td>
                                <td>" . htmlspecialchars(strtoupper($row["Nom"])) . "</td>
                                <td>" . htmlspecialchars($row["Prénom"]) . "</td>
                                <td>" . htmlspecialchars($row["Age"]) . " ans</td>
                                <td>" . htmlspecialchars($row["Adresse"]) . "</td>
                                <td><span style='text-transform: uppercase; font-size: 0.85em; letter-spacing: 0.5px; color: #666;'>" . htmlspecialchars($row["Ville"]) . "</span></td>
                                <td style='color: var(--text-muted); font-size: 0.95em;'>" . htmlspecialchars($row["Email"]) . "</td> 
                              </tr>";
                    }
                } else {
                    // Le colspan est maintenant bien ajusté à 7 pour couvrir tout le tableau sans bug
                    echo "<tr><td colspan='7' class='no-data'>Aucun Client trouvé pour le moment.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; 2026 - Plateforme de Gestion - ENEAM / UAC
    </div>

</body>
</html>

<?php $conn->close(); ?>