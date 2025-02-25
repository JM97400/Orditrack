DELIMITER $$

CREATE TRIGGER after_reservation_validation
AFTER UPDATE ON reservations
FOR EACH ROW
BEGIN
    IF NEW.status = 'validé' THEN
        UPDATE pcs SET status = 'en prêt' WHERE id = NEW.id_pc;
    ELSEIF NEW.status = 'rendu' OR NEW.status = 'annulé' THEN
        UPDATE pcs SET status = 'disponible' WHERE id = NEW.id_pc;
    END IF;
END$$

DELIMITER ;



