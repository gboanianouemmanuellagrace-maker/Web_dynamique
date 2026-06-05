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

$sql = "SELECT * FROM article";
$resultat = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Articles - ENEAM</title>
    <!-- Liaison à la feuille de style unique Blissim -->
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <br>
    <div class="nav-bar">
        <a href="Accueil.php" class="btn-retour">← Retour Accueil</a>
    </div>

    <div class="container" style="background-color: var(--bg-card); padding: 30px; border-radius: 4px; border: 1px solid var(--border-color); box-shadow: 0 4px 20px var(--shadow-soft);">
        <div class="header" style="border: none; padding: 0; margin-bottom: 35px; background: transparent; box-shadow: none;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 28px; margin: 0; color: var(--text-dark);">Tableau des Articles</h2>
            <a href="Formulaire.php" class="btn-nouvelle-vente" style="background-color: var(--text-dark); color: white; padding: 10px 20px; text-decoration: none; font-size: 0.9em; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">+ Ajouter Nouveau</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Référence (ID)</th>
                    <th>Désignation</th>
                    <th>Prix Unitaire</th>
                    <th>Catégorie</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultat->num_rows > 0) {
                    while($row = $resultat->fetch_assoc()) {
                        // Utilisation de guillemets simples pour les attributs HTML afin d'éviter le conflit PHP
                        echo "<tr>
                                <td><strong>#" . $row["Id_article"] . "</strong></td>
                                <td>" . htmlspecialchars($row["Design"]) . "</td>
                                <td><span class='badge-montant'>" . number_format($row["Prix"], 0, ',', ' ') . " FCFA</span></td>
                                <td><span style='text-transform: uppercase; font-size: 0.85em; letter-spacing: 0.5px; color: #666;'>" . htmlspecialchars($row["Catégorie"]) . "</span></td> 
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='no-data'>Aucun article trouvé pour le moment.</td></tr>";
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