<?php

// ---- CONFIGURATION INIFINITYFREE EN LIGNE ----
$host = 'sql101.infinityfree.com';
$port = '3306'; 
$dbname = 'if0_42103233_esssaibdd';
$user = 'if0_42103233';

// À TOI DE JOUER : Colle ton mot de passe d'hébergement secret (celui de l'œil violet) entre les deux guillemets ci-dessous
$pass = 'Manouelle24';
// ----------------------------------------------

try {
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
if (isset($_POST['valider_vente'])) {
    $id_client = $_POST['id_client'];
    $articles_ids = $_POST['id_article_cache']; 
    $quantites = $_POST['quantite'];

    try {
        $bdd->beginTransaction();
        $sql_com = "INSERT INTO commande (Id_client, Date) VALUES (?, NOW())";
        $res_com = $bdd->prepare($sql_com);
        $res_com->execute([$id_client]);
        $dernier_id_commande = $bdd->lastInsertId();

        $sql_cont = "INSERT INTO contenir (Id_commande, Id_article, Qté_commande) VALUES (?, ?, ?)";
        $res_cont = $bdd->prepare($sql_cont);

        for ($i = 0; $i < count($articles_ids); $i++) {
            if (!empty($articles_ids[$i])) {
                $res_cont->execute([$dernier_id_commande, $articles_ids[$i], $quantites[$i]]);
            }
        }
        $bdd->commit();
        header("Location: accueil.php?msg=Vente_Reussie");
        exit();
    } catch (Exception $e) {
        $bdd->rollBack();
        echo "<script>alert('Erreur SQL : " . addslashes($e->getMessage()) . "');</script>";
    }
}

$liste_clients = $bdd->query("SELECT * FROM client")->fetchAll(PDO::FETCH_ASSOC);
$liste_articles = $bdd->query("SELECT * FROM article")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture Professionnelle - ENEAM</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>

<br>
<div class="nav-bar">
    <a href="accueil.php" class="btn-retour">← Retour à l'accueil</a>
</div>

<div class="facture-box">
    <div class="header" style="border: none; padding: 0; margin-bottom: 30px; position: relative;">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 28px; margin: 0;">FACTURE № PRO-<?php echo date('Ymd'); ?></h2>
        <div class="text-right">Date d'émission : <?php echo date('d/m/Y'); ?></div>
    </div>

    <form method="POST">
        <div class="client-info">
            <div>
                <span class="client-label">Destinataire</span>
                <a href="formulaire_client.php?provenance=facture" class="btn-new" style="margin-left: 15px;">+ Nouveau Client</a>
                <br><br>
                <div class="form-group" style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 13px; color: var(--text-muted);">ID Client :</span>
                    <input list="clients" name="id_client" oninput="remplirClient(this.value)" required style="width: 80px; padding: 5px 0;">
                </div>
                <datalist id="clients">
                    <?php foreach($liste_clients as $c): ?>
                        <option value="<?php echo $c['Id_client']; ?>">
                    <?php endforeach; ?>
                </datalist>
                
                <input type="text" id="nom_client" placeholder="Nom" readonly class="input-readonly-nom">
                <input type="text" id="prenom_client" placeholder="Prénom" readonly class="input-readonly-prenom">
            </div>
            <div style="text-align: right; font-size: 14px; line-height: 1.6;">
                <strong style="color: var(--text-dark); font-family: 'Playfair Display', serif; font-size: 16px;">MA BOUTIQUE ENEAM</strong><br>
                <span style="color: var(--text-muted);">Bénin, Afrique de l'Ouest</span>
            </div>
        </div>

        <table id="table_art">
            <thead>
                <tr>
                    <th>Désignation de l'Article</th>
                    <th style="width: 100px; text-align: center;">Qté</th>
                    <th style="width: 120px; text-align: right;">PU HT (FCFA)</th>
                    <th style="width: 120px; text-align: right;">Total HT</th>
                    <th style="width: 40px;"></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <datalist id="list_art">
            <?php foreach($liste_articles as $a): ?>
                <option value="<?php echo htmlspecialchars($a['Design'], ENT_QUOTES); ?>">
            <?php endforeach; ?>
        </datalist>

        <div class="total-zone">
            <div class="total-row">
                <span>Total HT</span>
                <span id="ht" style="font-weight: 600;">0.00 FCFA</span>
            </div>
            <div class="total-ttc">
                <span>TOTAL TTC</span>
                <span id="ttc">0.00 FCFA</span>
            </div>
        </div>

        <div style="clear: both;"></div>

        <button type="submit" name="valider_vente" class="btn-save">Enregistrer la vente</button>
    </form>
</div>

<script>
const dataClients = <?php echo json_encode($liste_clients); ?>;
const dataArticles = <?php echo json_encode($liste_articles); ?>;

function remplirClient(v) {
    let c = dataClients.find(x => x.Id_client == v);
    document.getElementById('nom_client').value = c ? c.Nom : "";
    document.getElementById('prenom_client').value = c ? c.Prénom : "";
}

function ajouterLigne() {
    let tbody = document.getElementById('table_art').getElementsByTagName('tbody')[0];
    let row = tbody.insertRow();
    row.innerHTML = `<td>
                        <input list="list_art" oninput="remplirLigne(this)" placeholder="Sélectionner un article..." style="width: 95%;">
                        <input type="hidden" name="id_article_cache[]" class="id_art">
                     </td>
                     <td>
                        <input type="number" name="quantite[]" class="qte" value="1" min="1" oninput="calculer()" style="text-align: center;">
                     </td>
                     <td>
                        <input type="text" class="pu" readonly style="border: none; text-align: right; width: 100%; background: transparent; font-weight: 600;">
                     </td>
                     <td style="text-align: right; font-weight: 600;">
                        <span class="l_tot">0.00</span>
                     </td>
                     <td style="text-align: center;">
                        <button type="button" onclick="supprimerLigne(this)" class="btn-delete-row" style="color: var(--accent-pink); font-size: 18px; border: none; background: none; cursor: pointer;">×</button>
                     </td>`;
}

function remplirLigne(i) {
    let r = i.closest('tr');
    let a = dataArticles.find(x => x.Design == i.value);
    if(a) { 
        r.querySelector('.id_art').value = a.Id_article; 
        r.querySelector('.pu').value = a.Prix; 
        calculer();
        
        let tbody = document.getElementById('table_art').getElementsByTagName('tbody')[0];
        if (r === tbody.lastChild || r === tbody.rows[tbody.rows.length - 1]) {
            ajouterLigne();
        }
    }
}

function supprimerLigne(button) {
    let tbody = document.getElementById('table_art').getElementsByTagName('tbody')[0];
    if (tbody.rows.length > 1) {
        button.closest('tr').remove();
        calculer();
    }
}

function calculer() {
    let totalHT = 0;
    document.querySelectorAll('#table_art tbody tr').forEach(r => {
        let p = parseFloat(r.querySelector('.pu').value) || 0;
        let q = parseInt(r.querySelector('.qte').value) || 0;
        let t = p * q;
        r.querySelector('.l_tot').innerText = t.toLocaleString('fr-FR', { minimumFractionDigits: 2 });
        totalHT += t;
    });
    document.getElementById('ht').innerText = totalHT.toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + " FCFA";
    document.getElementById('ttc').innerText = (totalHT * 1.18).toLocaleString('fr-FR', { minimumFractionDigits: 2 }) + " FCFA";
}

window.onload = ajouterLigne;
</script>
</body>
</html>