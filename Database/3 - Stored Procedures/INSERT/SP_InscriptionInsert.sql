DELIMITER //
DROP PROCEDURE IF EXISTS SP_InscriptionInsert //
CREATE PROCEDURE SP_InscriptionInsert (v_firstname VARCHAR(255), v_lastname VARCHAR(255), v_pseudo VARCHAR(255), v_email VARCHAR(255), v_password VARCHAR(255))
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;
    DECLARE existeDelete SMALLINT;
    DECLARE v_grantId SMALLINT;
    DECLARE existPseudo SMALLINT;
    DECLARE v_grant_label VARCHAR(255);
    
    SET v_grantId = 3;
    SET v_grant_label = "['ROLE_NEW_USER']";

    SELECT COUNT(id)
    INTO existeDelete
    FROM users
    WHERE pseudo = LOWER('Supprimé');

    IF (existeDelete = 0) THEN

        INSERT INTO users (id, firstname, lastname, pseudo, email, password, inscription_date, grant_id, grant_label)
        VALUES (1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', NOW(), v_grantId, v_grant_label);

        SELECT COUNT(id)
        INTO exist
        FROM users
        WHERE email = LOWER(v_email);

        IF (exist > 0) THEN

            SET message = "Un autre utilisateur avec cet email existe déjà.";

            SELECT message;

        END IF;

        SELECT COUNT(id)
        INTO existPseudo
        FROM users
        WHERE pseudo = LOWER(v_pseudo);

        IF (existPseudo > 0) THEN

            SET message = "Un autre utilisateur avec ce pseudo existe déjà.";

            SELECT message;
        
        END IF;
        
        IF (exist = 0 AND existPseudo = 0) THEN

            INSERT INTO users (firstname, lastname, pseudo, email, password, grant_id, grant_label, inscription_date)
            VALUES
            (v_firstname, v_lastname, v_pseudo, v_email, v_password, v_grantId, v_grant_label, NOW());

            SET message = "Vous êtes bien enregistré, vous pouvez vous connecter.";

            SELECT message;

        END IF;

    END IF;

    IF (existeDelete > 0) THEN

        SELECT COUNT(id)
        INTO exist
        FROM users
        WHERE email = LOWER(v_email);

        IF (exist > 0) THEN

            SET message = "Un autre utilisateur avec cet email existe déjà.";

            SELECT message;

        END IF;

        SELECT COUNT(id)
        INTO existPseudo
        FROM users
        WHERE pseudo = LOWER(v_pseudo);

        IF (existPseudo > 0) THEN

            SET message = "Un autre utilisateur avec ce pseudo existe déjà.";

            SELECT message;
        
        END IF;

        IF (exist = 0 AND existPseudo = 0) THEN

            INSERT INTO users (firstname, lastname, pseudo, email, password, grant_id, grant_label, inscription_date)
            VALUES
            (v_firstname, v_lastname, v_pseudo, v_email, v_password, v_grantId, v_grant_label, NOW());

            SET message = "Vous êtes bien enregistré, vous pouvez vous connecter.";

            SELECT message;

        END IF;

    END IF;

END //