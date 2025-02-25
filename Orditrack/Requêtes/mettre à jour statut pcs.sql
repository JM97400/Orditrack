/*Le trigger mettra à jour le statut des PC associés en fonction du statut de la réservation.*/

DELIMITER $$        
CREATE TRIGGER after_reservation_validation
AFTER UPDATE ON reservations
FOR EACH ROW
BEGIN
    IF NEW.statut = 'validé' THEN
        UPDATE pcs SET statut = 'en prêt' WHERE id = NEW.id_pc;
    ELSEIF NEW.statut = 'rendu' OR NEW.statut = 'annulé' THEN
        UPDATE pcs SET statut = 'disponible' WHERE id = NEW.id_pc;
    END IF;
END $$

DELIMITER ;
