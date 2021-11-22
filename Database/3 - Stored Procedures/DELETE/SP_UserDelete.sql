DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserDelete //
CREATE PROCEDURE SP_UserDelete (v_id INT)
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE exist SMALLINT;
    DECLARE pseudoinfo VARCHAR(512);

    SET message = '';

    SELECT COUNT(id)
    INTO exist
    FROM users
    WHERE id = v_id;

    IF (exist = 0) THEN

        SET message = CONCAT("L'utilsateur N° ", v_id, " n'existe pas.");
    
    END IF;

    IF (exist > 0) THEN

        SELECT pseudo
        INTO pseudoinfo
        FROM users
        WHERE id = v_id;

        DELETE
        FROM comments
        WHERE user_id = v_id;

        DELETE
        FROM articles
        WHERE user_id = v_id;

        DELETE
        FROM users
        WHERE id = v_id;

        SET message = CONCAT("L'utilisateur ", pseudoinfo, " a bien été supprimé");

    END IF;

    SELECT message;

END //