SELECT r.id, u.username AS user, p.numero_serie AS pc, r.date_debut, r.date_retour, r.statut
FROM reservations r
JOIN users u ON r.id_user = u.id
JOIN pcs p ON r.id_pc = p.id
WHERE r.statut = 'en attente';
