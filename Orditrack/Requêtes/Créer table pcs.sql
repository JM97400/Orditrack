CREATE TABLE pcs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_serie VARCHAR(50) UNIQUE NOT NULL,
    statut ENUM('disponible', 'réservé', 'en prêt', 'en SAV') NOT NULL DEFAULT 'disponible'
);