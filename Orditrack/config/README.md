# Configuration Orditrack

Ce dossier contient tous les fichiers de configuration de l'application Orditrack.

## Structure des fichiers

### Fichiers principaux
- **`main.php`** - Fichier principal qui inclut tous les modules de configuration
- **`database.php`** - Configuration de la connexion à la base de données
- **`sessions.php`** - Configuration des sessions et sécurité

### Fichiers de sauvegarde
- **`backup-database.php`** - Configuration alternative de base de données
- **`backup-sessions.php`** - Configuration alternative des sessions

## Utilisation

### Pour utiliser la configuration complète
```php
require_once 'config/main.php';
```

### Pour utiliser seulement la base de données
```php
require_once 'config/database.php';
```

### Pour utiliser seulement les sessions
```php
require_once 'config/sessions.php';
```

## Migration

Pour migrer depuis l'ancien système, remplacez :
```php
require_once 'config.php';
```

Par :
```php
require_once 'config/main.php';
```

## Notes de sécurité

- Les sessions expirent après 30 minutes d'inactivité
- Protection CSRF activée par défaut
- Cookies sécurisés avec httponly et samesite
- En production, activer HTTPS et mettre `secure => true`
