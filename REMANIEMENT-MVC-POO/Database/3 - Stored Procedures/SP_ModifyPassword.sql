DELIMITER //
DROP PROCEDURE IF EXISTS SP_ModifyPassword //
CREATE PROCEDURE SP_ModifyPassword (v_email VARCHAR(255), v_password VARCHAR(255))
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;

    SELECT COUNT(id)
    INTO exist
    FROM users
    WHERE email = LOWER(v_email);

    IF (exist = 0) THEN 

        SET message = "Cet email n'existe pas.";

        SELECT message;

    END IF;

    IF (exist > 0) THEN

        UPDATE users
        SET password = v_password
        WHERE email = v_email;

        SET message = "Votre mot de passe a correctement été modifié.";
        
        SELECT message;

    END IF;

END //