# Orditrack

Gestion simple du prêt d’ordinateurs portables (réservation, validation, suivi, historique).

## Prérequis
- PHP 8.x
- Serveur web (Laragon, XAMPP, WAMP ou Apache/Nginx)
- MySQL/MariaDB
- Composer (facultatif selon vos besoins)

## Structure du projet
```
Orditrack/
  Base de données/               # Exports SQL
  Orditrack/                     # Application PHP
    config/                      # Config app/DB/sessions
    public/assets/css/           # Styles
    img/                         # Images app
    index.php                    # Accueil de l’application
    presentation.php             # Page Notre équipe
    rgpd.php                     # Mentions légales
  README.md
```

## Installation locale (Laragon recommandé)
1. Placer ce dossier dans `C:\laragon\www\Orditrack`.
2. Démarrer Apache et MySQL via Laragon.
3. Créer une base de données (ex. `orditrack`).
4. Importer le dump SQL:
   - Fichier: `Base de données/Base données orditrack.sql`
5. Vérifier la configuration de connexion:
   - Fichiers: `Orditrack/config/database.php` et `Orditrack/config/main.php`
6. Accéder à l’application:
   - Accueil application: `http://localhost/Orditrack/Orditrack/index.php`
   - Notre équipe: `http://localhost/Orditrack/Orditrack/presentation.php`
   - Mentions légales: `http://localhost/Orditrack/Orditrack/rgpd.php`

## Fonctionnalités clés
- Réservation de PC avec dates de début/retour
- Validation/Refus par un administrateur
- Suivi des statuts et historique
- Page d’équipe avec profils et liens sociaux

## Authentification / Sessions
- Pages de connexion: `Orditrack/login.php` (utilisateurs), `Orditrack/login.php?role=admin` (admin)
- Sessions configurées dans `Orditrack/config/sessions.php`
- Jeton CSRF utilisé côté formulaire de réservation (voir `Orditrack/index.php`)

## Configuration
- `Orditrack/config/main.php`: bootstrap général
- `Orditrack/config/database.php`: paramètres MySQL (hôte, base, utilisateur, mot de passe)
- `Orditrack/config/sessions.php`: gestion de session
- `Orditrack/config/backup-database.php`: sauvegarde base (optionnel)

## Développement
- CSS principal: `Orditrack/public/assets/css/style.css` (et autres fichiers CSS dédiés)
- Images: `Orditrack/img/`
- Scripts JS globaux: `Orditrack/app.js` (si nécessaire)

## Données de démonstration
- Requêtes SQL utiles dans `Orditrack/Requêtes/` pour inspection et tests

## Sauvegardes
- Scripts de sauvegarde: `Orditrack/config/backup-database.php` et `Orditrack/admin-backup*.php`

## Bonnes pratiques & Sécurité
- Toujours vérifier/renouveler le jeton CSRF côté formulaires sensibles
- Éviter l’injection SQL (requêtes préparées déjà en place)
- Valider/échapper toutes les entrées utilisateur
- Ne pas committer d’identifiants de prod

## Déploiement (aperçu)
- Exporter la base de données (dump SQL)
- Mettre à jour les configs `config/database.php` sur l’environnement cible
- Déployer le dossier `Orditrack/` derrière un hôte virtuel Apache/Nginx

## Personnalisation rapide
- Logo/visuels: `Orditrack/img/`
- Couleurs/typographies: `Orditrack/public/assets/css/style.css`
- Équipe: `Orditrack/presentation.php` (avatars ou `<img>`)

## Problèmes connus
- Les chemins relatifs varient selon l’emplacement du dossier. Utilisez de préférence des URLs absolues si l’app est servie depuis un sous-dossier.

## Licence
Projet interne/éducatif. Adaptez la licence selon votre usage.


