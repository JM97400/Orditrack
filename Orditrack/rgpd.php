<?php
// Pas de traitement PHP spécifique requis pour cette page statique
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique RGPD - Gestion de Prêt de PC</title>
    <link rel="stylesheet" href="rgpd.css">
</head>
<body>

<div class="rgpd-container"> <!-- Changé de tutorial-container à rgpd-container -->

    <!-- Bouton Fermer -->
    <a href="index.php"><button class="rgpd-close-button">Fermer</button></a> <!-- Changé de home-button à rgpd-close-button -->

    <h1>Politique de Protection des Données (RGPD)</h1>
    <p class="rgpd-intro">Conformément au Règlement Général sur la Protection des Données (RGPD) de l’Union Européenne, cette page détaille la manière dont nous collectons, traitons et protégeons vos données personnelles dans le cadre de notre service de gestion de prêt de PC.</p>

    <div class="rgpd-step">
        <h2>1. Responsable du Traitement</h2>
        <p>Le responsable du traitement des données est :</p>
        <ul>
            <li><span class="rgpd-highlight">Ecole du Numérique</span></li>
            <li>Adresse : [Votre Adresse Physique]</li>
            <li>Email : <a href="mailto:[alexis@gmail.com]">[alexis@gmail.com]</a></li>
        </ul>
        <p>Pour toute question relative à vos données, contactez-nous via l’adresse ci-dessus.</p>
    </div>

    <div class="rgpd-step">
        <h2>2. Données Collectées</h2>
        <p>Nous collectons les données suivantes lors de l’utilisation de notre service :</p>
        <ul>
            <li><span class="rgpd-highlight">Identifiants</span> : Nom d’utilisateur.</li>
            <li><span class="rgpd-highlight">Données de réservation</span> : Dates de début et de retour, numéros de série des PCs, numéros de réservation.</li>
            <li><span class="rgpd-highlight">Données techniques</span> : Adresse IP, horodatage des connexions (via sessions PHP).</li>
        </ul>
        <p>Aucune donnée sensible supplémentaire (ex. mot de passe en clair) n’est conservée sans chiffrement en production.</p>
    </div>

    <div class="rgpd-step">
        <h2>3. Finalités du Traitement</h2>
        <p>Les données sont traitées pour :</p>
        <ul>
            <li>Gérer les prêts de PC (réservations, validation, retour).</li>
            <li>Assurer la sécurité du site (via sessions sécurisées et jetons CSRF).</li>
            <li>Générer des statistiques internes (ex. nombre de PCs disponibles, en prêt, ou en maintenance).</li>
        </ul>
    </div>

    <div class="rgpd-step">
        <h2>4. Base Légale</h2>
        <p>Le traitement repose sur :</p>
        <ul>
            <li><span class="rgpd-highlight">Consentement</span> : Votre utilisation volontaire du service implique un consentement explicite.</li>
            <li><span class="rgpd-highlight">Exécution d’un contrat</span> : Gestion des prêts de PC dans le cadre de votre accès au service.</li>
            <li><span class="rgpd-highlight">Intérêt légitime</span> : Sécurisation et amélioration du site.</li>
        </ul>
    </div>

    <div class="rgpd-step">
        <h2>5. Destinataires des Données</h2>
        <p>Vos données sont accessibles uniquement à :</p>
        <ul>
            <li>Les administrateurs du site pour la gestion des réservations.</li>
            <li>Le personnel technique en charge de la maintenance du système.</li>
        </ul>
        <p>Aucun transfert hors UE n’est effectué. Les données sont hébergées sur [précisez l’hébergeur, ex. "des serveurs locaux en France"].</p>
    </div>

    <div class="rgpd-step">
        <h2>6. Durée de Conservation</h2>
        <p>Les données sont conservées :</p>
        <ul>
            <li><span class="rgpd-highlight">Données de session</span> : 30 minutes (durée de vie des sessions PHP).</li>
            <li><span class="rgpd-highlight">Historique des réservations</span> : 1 an après la fin de la réservation, sauf demande de suppression.</li>
            <li><span class="rgpd-highlight">Identifiants</span> : Tant que votre compte est actif ou jusqu’à une demande de suppression.</li>
        </ul>
    </div>

    <div class="rgpd-step">
        <h2>7. Vos Droits</h2>
        <p>Conformément au RGPD, vous disposez des droits suivants :</p>
        <ol>
            <li><span class="rgpd-highlight">Droit d’accès</span> : Consulter vos données personnelles.</li>
            <li><span class="rgpd-highlight">Droit de rectification</span> : Corriger des données inexactes.</li>
            <li><span class="rgpd-highlight">Droit à l’effacement</span> : Demander la suppression de vos données ("droit à l’oubli").</li>
            <li><span class="rgpd-highlight">Droit à la limitation</span> : Restreindre le traitement dans certains cas.</li>
            <li><span class="rgpd-highlight">Droit d’opposition</span> : Refuser le traitement pour des raisons légitimes.</li>
            <li><span class="rgpd-highlight">Droit à la portabilité</span> : Récupérer vos données dans un format structuré.</li>
        </ol>
        <p>Pour exercer ces droits, contactez-nous à [votre.email@exemple.com]. Une réponse vous sera fournie sous 1 mois.</p>
    </div>

    <div class="rgpd-step">
        <h2>8. Sécurité des Données</h2>
        <p>Nous mettons en œuvre les mesures suivantes :</p>
        <ul>
            <li>Sessions sécurisées avec cookies `httponly` et `samesite=Strict`.</li>
            <li>Protection contre les attaques CSRF via jetons.</li>
            <li>En production : mots de passe chiffrés avec des algorithmes sécurisés (ex. bcrypt).</li>
        </ul>
    </div>

    <div class="rgpd-step">
        <h2>9. Réclamation</h2>
        <p>Si vous estimez que vos droits ne sont pas respectés, vous pouvez contacter la CNIL :</p>
        <ul>
            <li>Site : <a href="https://www.cnil.fr" target="_blank">www.cnil.fr</a></li>
            <li>Adresse : 3 Place de Fontenoy, TSA 80715, 75334 Paris Cedex 07, France</li>
        </ul>
    </div>

    <p class="rgpd-tip"><strong>Mise à jour :</strong> Cette politique a été mise à jour le 20 mars 2025.</p>
</div>

<script>
    // Ferme la fenêtre au clic sur le bouton
    document.querySelector('.rgpd-close-button').addEventListener('click', function() {
        window.close();
    });
</script>

</body>
</html>