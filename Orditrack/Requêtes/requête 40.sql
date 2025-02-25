$sql_prêt = 'SELECT p.id, p.numero_serie, r.date_retour 
             FROM pcs p 
             JOIN reservations r ON p.id = r.id_pc 
             WHERE p.status = "en prêt"';


