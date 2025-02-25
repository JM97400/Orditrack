CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_pc INT NOT NULL,
    date_debut DATETIME NOT NULL,
    date_retour DATETIME NOT NULL,
    statut ENUM('en attente', 'validé', 'rendu', 'annulé') NOT NULL DEFAULT 'en attente',
    validated_by INT NULL
);

