DELIMITER //
DROP PROCEDURE IF EXISTS SP_Connexion //
CREATE PROCEDURE SP_Connexion (v_email VARCHAR(255))
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;
    DECLARE idinfo VARCHAR(255);
    DECLARE firstnameinfo VARCHAR(255);
    DECLARE lastnameinfo VARCHAR(255);
    DECLARE pseudoinfo VARCHAR(255);
    DECLARE emailinfo VARCHAR(255);
    DECLARE passwordinfo VARCHAR(255); 
    DECLARE grant_idinfo VARCHAR(255);
    DECLARE inscription_dateinfo DATETIME;

    SELECT COUNT(id)
    INTO exist
    FROM users
    WHERE email = LOWER(v_email);

    IF (exist = 0) THEN

        SET message = "Cet email n'existe pas.";

        SELECT message;

    END IF;

    IF (exist > 0) THEN

        SELECT id, firstname, lastname, pseudo, email, password, grant_id, inscription_date
        INTO idinfo, firstnameinfo, lastnameinfo, pseudoinfo, emailinfo, passwordinfo, grant_idinfo, inscription_dateinfo
        FROM users
        WHERE email = LOWER(v_email);

        SELECT idinfo, firstnameinfo, lastnameinfo, pseudoinfo, emailinfo, passwordinfo, grant_idinfo, inscription_dateinfo;
    
    END IF;

END //