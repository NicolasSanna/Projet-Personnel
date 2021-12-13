DELIMITER //
DROP PROCEDURE IF EXISTS SP_BlockUserUpdate //
CREATE PROCEDURE SP_BlockUserUpdate (v_user_to_block_id INT, v_user_want_block_id INT)
BEGIN

    DECLARE userinfo VARCHAR(255);
    DECLARE message VARCHAR(512);
    DECLARE existUser SMALLINT;

    SELECT COUNT(id)
    INTO existUser
    FROM users
    WHERE id = v_user_to_block_id;

    IF (existUser = 0) THEN 

        SET message = "L'utilisateur n'existe pas";

    END IF;

    IF (existUser > 0) THEN 

        SELECT pseudo
        INTO userinfo
        FROM users
        WHERE id = v_user_to_block_id;

        UPDATE messages
        SET status_sender_id = 2
        WHERE from_user_id = v_user_to_block_id
        AND to_user_id = v_user_want_block_id;

        SET message = CONCAT("L'utilisateur ayant pour pseudo ", userinfo, " a été bloqué.");

    END IF;

    SELECT message;

END //