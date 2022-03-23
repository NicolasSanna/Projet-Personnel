DELIMITER //
DROP PROCEDURE IF EXISTS SP_InfosPersosUpdate //
CREATE PROCEDURE SP_InfosPersosUpdate (v_firstname VARCHAR(255), v_lastname VARCHAR(255), v_pseudo VARCHAR(255), v_email VARCHAR(255), v_id INT)
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existEmail SMALLINT;
    DECLARE existPseudo SMALLINT;

    SELECT COUNT(id)
    INTO existEmail
    FROM users
    WHERE LOWER(email) = v_email
    AND id <> v_id;
    
    SELECT COUNT(id)
    INTO existPseudo
    FROM users
    WHERE LOWER(pseudo) = v_pseudo
    AND id <> v_id;

    IF (existEmail > 0) THEN

        SET message = "Un autre utilisateur avec cet email existe déjà.";

    END IF;

    IF (existPseudo > 0) THEN

        SET message = "Un autre utilisateur avec ce pseudo existe déjà.";
    
    END IF;

    IF (existEmail > 0 AND existPseudo > 0) THEN

        SET message = "Un autre utilisateur avec cet email et ce pseudo existe déjà.";

    END IF;

    IF (existEmail = 0 AND existPseudo = 0) THEN

        UPDATE users
        SET firstname = v_firstname,
            lastname = v_lastname,
            pseudo = v_pseudo,
            email = v_email
        WHERE id = v_id;

        SET message = "Vos informations ont bien été modifiées, vous pourrez les voir à jour lors de votre reconnexion.";

    END IF;

    SELECT message;

END //