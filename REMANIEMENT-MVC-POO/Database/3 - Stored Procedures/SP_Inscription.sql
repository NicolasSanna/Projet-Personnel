DELIMITER //
DROP PROCEDURE IF EXISTS SP_Inscription //
CREATE PROCEDURE SP_Inscription (v_firstname VARCHAR(255), v_lastname VARCHAR(255), v_pseudo VARCHAR(255), v_email VARCHAR(255), v_password VARCHAR(255))
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;
    DECLARE existeDelete SMALLINT;
    DECLARE v_grantId SMALLINT;
    DECLARE existPseudo SMALLINT;
    
    SET v_grantId = 3;

    SELECT COUNT(id)
    INTO existeDelete
    FROM users
    WHERE pseudo = LOWER('Supprimé');

    IF (existeDelete = 0) THEN

        INSERT INTO users (id, firstname, lastname, pseudo, email, password, inscription_date, grant_id)
        VALUES (1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', NOW(), v_grantId);

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
        
        END IF;
        
        IF (exist = 0 AND existPseudo = 0) THEN

            INSERT INTO users (firstname, lastname, pseudo, email, password, grant_id, inscription_date)
            VALUES
            (v_firstname, v_lastname, v_pseudo, v_email, v_password, v_grantId, NOW());

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

            INSERT INTO users (firstname, lastname, pseudo, email, password, grant_id, inscription_date)
            VALUES
            (v_firstname, v_lastname, v_pseudo, v_email, v_password, v_grantId, NOW());

            SET message = "Vous êtes bien enregistré, vous pouvez vous connecter.";

            SELECT message;

        END IF;

    END IF;

END //