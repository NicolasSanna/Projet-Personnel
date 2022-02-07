DELIMITER //
DROP PROCEDURE IF EXISTS SP_InscriptionInsert //
CREATE PROCEDURE SP_InscriptionInsert (v_firstname VARCHAR(255), v_lastname VARCHAR(255), v_pseudo VARCHAR(255), v_email VARCHAR(255), v_password VARCHAR(255))
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existEmail SMALLINT;
    DECLARE v_grantId SMALLINT;
    DECLARE existPseudo SMALLINT;
    DECLARE v_grant_label VARCHAR(255);
    
    SET v_grantId = 3;
    SET v_grant_label = "['ROLE_NEW_USER']";

    SELECT COUNT(id)
    INTO existEmail
    FROM users
    WHERE email = LOWER(v_email);
    
    SELECT COUNT(id)
    INTO existPseudo
    FROM users
    WHERE pseudo = LOWER(v_pseudo);

    IF (existEmail > 0) THEN

        SET message = "Un autre utilisateur avec cet email existe déjà.";

    END IF;

    IF (existPseudo > 0) THEN

        SET message = "Un autre utilisateur avec ce pseudo existe déjà.";
    
    END IF;

    IF (existEmail > 0 AND existPseudo > 0) THEN

        SET message = "Un autre utilisateur avec email et ce pseudo existe déjà.";

    END IF;

    IF (existEmail = 0 AND existPseudo = 0) THEN

        INSERT INTO users (firstname, lastname, pseudo, email, password, grant_id, grant_label, inscription_date)
        VALUES
        (v_firstname, v_lastname, v_pseudo, v_email, v_password, v_grantId, v_grant_label, NOW());

        SET message = "Vous êtes bien enregistré, vous pouvez vous connecter.";

    END IF;

    SELECT message;

END //