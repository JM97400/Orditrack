$sql = "INSERT INTO reservations (id_user, id_pc, date_debut, date_retour, status, validated_by)
        VALUES (:id_user, :id_pc, :date_debut, :date_retour, 'en attente', :validated_by)";
