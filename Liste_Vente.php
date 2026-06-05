<?php
// 1. ---- CONFIGURATION INIFINITYFREE EN LIGNE ----
$host = 'sql101.infinityfree.com'; 
$port = '3306'; 
$dbname = 'if0_42103233_esssaibdd'; 
$user = 'if0_42103233'; 

// À TOI DE JOUER : Colle ton mot de passe d'hébergement secret entre les deux guillemets ci-dessous
$pass = 'Manouelle24';
// --------------------------------------------------

try {
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// 2. Requête SQL complexe pour récupérer les infos des ventes
$sql = "SELECT 
            c.Id_commande, 
            c.Date, 
            cl.Nom, 
            cl.Prénom, 
            SUM(co.Qté_commande * a.Prix) as Montant_Total
        FROM commande c
        JOIN client cl ON c.Id_client = cl.Id_client
        JOIN contenir co ON c.id_commande = co.id_commande
        JOIN article a ON co.Id_article = a.Id_article
        GROUP BY c.id_commande
        ORDER BY c.Date DESC";

$ventes = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Ventes - ENEAM</title>
    <!-- Liaison directe au style Blissim unique -->
    <link rel="stylesheet" href="css.css">
</head>
<body class="liste-vente-body">

<br>
<div class="nav-bar">
    <a href="accueil.php" class="btn-retour">← Retour Accueil</a>
</div>

<div class="container" style="background-color: var(--bg-card); padding: 30px; border-radius: 4px; border: 1px solid var(--border-color); box-shadow: 0 4px 20px var(--shadow-soft);">
    
    <div class="header" style="border: none; padding: 0; margin-bottom: 35px; background: transparent; box-shadow: none;">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 28px; margin: 0; color: var(--text-dark);">Historique des Ventes</h2>
        <a href="Facture.php" class="btn-nouvelle-vente">+ Effectuer une vente</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Commande</th>
                <th>Date d'enregistrement</th>
                <th>Client</th>
                <th>Montant Total</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($ventes) > 0): ?>
                <?php foreach ($ventes as $v): ?>
                <tr>
                    <td><strong>#<?php echo $v['Id_commande']; ?></strong></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($v['Date'])); ?></td>
                    <td><?php echo strtoupper($v['Nom']) . " " . $v['Prénom']; ?></td>
                    <td><span class="badge-montant"><?php echo number_format($v['Montant_Total'], 0, ',', ' '); ?> FCFA</span></td>
                    <td style="text-align: center;">
                        <button onclick="alert('Fonction d\'impression en cours de développement')" class="btn-action-view">Voir détails</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="no-data">Aucune vente enregistrée pour le moment.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="footer">
    &copy; 2026 ENEAM - Tous droits réservés
</div>

</body>
</html>