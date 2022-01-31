DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserKeyReinitializationInsert //
CREATE PROCEDURE SP_UserKeyReinitializationInsert (v_email VARCHAR(255), v_key_reinitialization VARCHAR(512))
BEGIN

    DECLARE v_id INT;
    DECLARE doublon INT;

    SELECT u.id
    INTO v_id
    FROM users u
    WHERE LOWER(u.email) = v_email;

    SELECT COUNT(id)
    INTO doublon
    FROM user_password_change
    WHERE user_id = v_id;

    IF(doublon > 0) THEN

        DELETE
        FROM user_password_change
        WHERE user_id = v_id;

    END IF;
    

    INSERT INTO user_password_change (key_change_password, user_id)
    VALUES
    (v_key_reinitialization, v_id);

END //