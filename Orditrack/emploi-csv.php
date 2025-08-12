<!--///////////////////////////////////////////////////////*/
 /*//////////////////Page Tuto import PCS//////////////////*/
 /*///////////////////////////////////////////////////////*/-->

 <?php
require_once 'config/main.php';

// MODIFICATION : Vérification si l'utilisateur est connecté (admin)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutoriel : Remplir un fichier CSV pour Orditrack</title>
    <link rel="stylesheet" href="public/assets/css/emploi-csv.css">
</head>
<body>
    <div class="tutorial-container">
        <!-- Bouton Accueil en haut à droite -->
        <a href="index.php" class="home-button" onclick="window.close(); return true;">Fermer</a>

        <h1>Tutoriel : Ajouter des PCs disponibles via un fichier CSV</h1>
        <p class="intro">Bienvenue ! Ce guide va vous montrer comment préparer facilement un fichier CSV pour ajouter des PCs disponibles dans le stock d’Orditrack. Suivez ces étapes simples pour que tout se passe sans accroc.</p>

        <section class="step">
            <h2>Étape 1 : Comprendre le fichier CSV</h2>
            <p>Un fichier CSV, c’est une liste claire et structurée. Voici ce qu’il faut :</p>
            <ul>
                <li><span class="highlight">En-tête</span> : La première ligne doit contenir <code>numero_serie</code> et <code>status</code>.</li>
                <li><span class="highlight">Contenu</span> : Une ligne par PC avec son numéro de série et le statut <strong>"disponible"</strong>.</li>
            </ul>
            <p>Voici un exemple de ce que ça donne :</p>
            <pre>
numero_serie    status
PC-TEST-170     disponible
PC-TEST-171     disponible
            </pre>
        </section>

        <section class="step">
            <h2>Étape 2 : Créer votre fichier CSV avec Excel</h2>
            <ol>
                <li><strong>Ouvrez Excel</strong> : Lancez Excel sur votre ordinateur.</li>
                <li><strong>Ajoutez l’en-tête</strong> :
                    <ul>
                        <li>Dans la cellule <strong>A1</strong>, tapez <code>numero_serie</code> (sans majuscule sur "serie").</li>
                        <li>Dans la cellule <strong>B1</strong>, tapez <code>status</code> (sans majuscule).</li>
                    </ul>
                </li>
                <li><strong>Remplissez les données</strong> :
                    <ul>
                        <li>Sous l’en-tête (A2, B2, etc.), entrez les numéros de série et le statut. Par exemple :</li>
                        <li>A2 : <code>PC-TEST-170</code>    B2 : <code>disponible</code></li>
                        <li>A3 : <code>PC-TEST-171</code>    B3 : <code>disponible</code></li>
                        <li><strong>Important</strong> : Chaque numéro doit être unique et ne pas exister déjà dans la base !</li>
                    </ul>
                </li>
                <li><strong>Sauvegardez</strong> :
                    <ul>
                        <li>Cliquez sur <em>Fichier > Enregistrer sous</em>.</li>
                        <li>Choisissez un nom (ex. <code>pcs_orditrack.csv</code>).</li>
                        <li>Type : "CSV UTF-8 (séparé par des virgules) (*.csv)".</li>
                        <li>Cliquez sur <em>Enregistrer</em>.</li>
                    </ul>
                </li>
            </ol>
        </section>

        <p class="tip"><strong>Astuce</strong> : Vérifiez votre fichier dans un classeur après l’enregistrement pour vous assurer que tout est bien aligné. Ensuite, importez-le dans Orditrack et c’est parti !</p>
    </div>
</body>
</html>