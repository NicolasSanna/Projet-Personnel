DELIMITER //
DROP PROCEDURE IF EXISTS SP_GrantUpdate //
CREATE PROCEDURE SP_GrantUpdate (v_userId INT, v_grantId INT)
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existUser SMALLINT;
    DECLARE existGrant SMALLINT;
    
    DECLARE pseudoinfo VARCHAR(255);
    DECLARE privilegeinfo VARCHAR(255);

    DECLARE label_author VARCHAR(255);
    DECLARE label_new_user VARCHAR(255);

    SET label_author = "['ROLE_AUTHOR']";
    SET label_new_user = "['ROLE_NEW_USER']";

    SET message = '';

    SELECT COUNT(id)
    INTO existUser 
    FROM users
    WHERE id = v_userId;

    IF (existUser = 0) THEN

        SET message = CONCAT("L'utilisateur ", v_userId, " n'existe pas.");
    
    END IF;

    IF (existUser > 0) THEN 

        SELECT COUNT(id)
        INTO existGrant
        FROM grants
        WHERE id = v_grantId;

        IF (existGrant = 0) THEN

            SET message = CONCAT("Le droit ", v_grantId, " n'existe pas.");

        END IF;

        IF (existGrant > 0) THEN

            IF (v_grantId = 2)  THEN
        
                UPDATE users
                SET grant_label = label_author
                WHERE id = v_userId;

            END IF;

            IF (v_grantId = 3) THEN

                UPDATE users
                SET grant_label = label_new_user
                WHERE id = v_userId;

            END IF;

            UPDATE users
            SET grant_id = v_grantId
            WHERE id = v_userId;

            SELECT pseudo, privilege
            INTO pseudoinfo, privilegeinfo
            FROM users
            INNER JOIN grants ON users.grant_id = grants.id
            WHERE users.id = v_userId;

            SET message = CONCAT("Le droit ", privilegeinfo, " a été attribué à l'utilisateur ", pseudoinfo, ".");

        END IF;

    END IF;

    SELECT message;

END //

-- Avec OR et AND

DELIMITER //
DROP PROCEDURE IF EXISTS SP_GrantUpdate //
CREATE PROCEDURE SP_GrantUpdate (v_userId INT, v_grantId INT)
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existUser SMALLINT;
    DECLARE existGrant SMALLINT;

    DECLARE pseudoinfo VARCHAR(255);
    DECLARE privilegeinfo VARCHAR(255);

    DECLARE label_author VARCHAR(255);
    DECLARE label_new_user VARCHAR(255);

    SET label_author = "['ROLE_AUTHOR']";
    SET label_new_user = "['ROLE_NEW_USER']";

    SELECT COUNT(id)
    INTO existUser 
    FROM users
    WHERE id = v_userId;

    SELECT COUNT(id)
    INTO existGrant
    FROM grants
    WHERE id = v_grantId;

    IF (existUser = 0 OR existGrant = 0) THEN

        SET message = "L'utilisateur ou le droit n'existe pas.";

    END IF;

    IF (existUser > 0 AND existGrant > 0) THEN

        IF (v_grantId = 2)  THEN
    
            UPDATE users
            SET grant_label = label_author
            WHERE id = v_userId;

        END IF;

        IF (v_grantId = 3) THEN

            UPDATE users
            SET grant_label = label_new_user
            WHERE id = v_userId;

        END IF;
   
        UPDATE users
        SET grant_id = v_grantId
        WHERE id = v_userId;

        SELECT pseudo, privilege
        INTO pseudoinfo, privilegeinfo
        FROM users
        INNER JOIN grants ON users.grant_id = grants.id
        WHERE users.id = v_userId;

        SET message = CONCAT("Le droit ", privilegeinfo, " a été attribué à ", pseudoinfo, ".");

    END IF;

    SELECT message;

END //