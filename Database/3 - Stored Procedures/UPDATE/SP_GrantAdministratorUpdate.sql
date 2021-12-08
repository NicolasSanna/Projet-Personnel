DELIMITER //
DROP PROCEDURE IF EXISTS SP_GrantAdministratorUpdate //
CREATE PROCEDURE SP_GrantAdministratorUpdate (v_email VARCHAR(255))
BEGIN

    DECLARE existEmail SMALLINT;
    DECLARE message VARCHAR(512);
    DECLARE v_grant_administrator_label VARCHAR(255);

    SET v_grant_administrator_label = "['ROLE_ADMINISTRATOR']";

    SELECT COUNT(id)
    INTO existEmail
    FROM users
    WHERE email = LOWER(v_email);

    IF(existEmail = 0) THEN

        SET message = CONCAT("L'utilisateur ayant pour email ", v_email, " n'existe pas.");

    END IF;

    IF (existEmail > 0) THEN

        UPDATE users
        SET grant_id = 1,
        grant_label = v_grant_administrator_label
        WHERE email = v_email;

        SET message = CONCAT("L'utilisateur ayant pour email ", v_email ," a désormais le rôle administrateur.");
    
    END IF;

    SELECT message;

END //