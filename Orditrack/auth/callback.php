<?php
require '../config/database.php';
require '../vendor/autoload.php';

session_start();
use League\OAuth2\Client\Provider\GenericProvider;

$provider = new GenericProvider([
    'clientId'                => 'TON_CLIENT_ID',
    'clientSecret'            => 'TON_CLIENT_SECRET',
    'redirectUri'             => 'http://localhost/auth/callback.php',
    'urlAuthorize'            => 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
    'urlAccessToken'          => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
    'scopes'                  => 'User.Read'
]);

if (!isset($_GET['code'])) {
    exit('Erreur d’authentification');
}

try {
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $resourceOwner = $provider->getResourceOwner($accessToken);
    $userData = $resourceOwner->toArray();

    $email = $userData['mail'] ?? $userData['userPrincipalName'];
    $name = $userData['displayName'];
    $microsoftId = $userData['id'];

    // Vérifier si l'utilisateur existe dans la BDD
    $stmt = $conn->prepare("SELECT * FROM users WHERE microsoft_id = ?");
    $stmt->execute([$microsoftId]);
    $user = $stmt->fetch();

    if (!$user) {
        // Si l'utilisateur n'existe pas, on l'ajoute
        $stmt = $conn->prepare("INSERT INTO users (username, email, microsoft_id, role) VALUES (?, ?, ?, 'user')");
        $stmt->execute([$name, $email, $microsoftId]);
        $userId = $conn->lastInsertId();
    } else {
        $userId = $user['id'];
    }

    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $name;
    $_SESSION['email'] = $email;

    header("Location: ../index.php");
    exit;
} catch (Exception $e) {
    exit('Erreur de connexion : ' . $e->getMessage());
}
?>
