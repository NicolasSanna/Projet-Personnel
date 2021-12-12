DELIMITER //
DROP PROCEDURE IF EXISTS SP_MessageInsert //
CREATE PROCEDURE SP_MessageInsert (v_id_message VARCHAR(512), v_id_from INT, v_id_to INT, v_subject VARCHAR(255), v_content TEXT)
BEGIN

    DECLARE userBlocked INT;

    SELECT COUNT(id)
    INTO userBlocked
    FROM messages
    WHERE status_sender_id = 2
    AND from_user_id = v_id_from
    AND to_user_id = v_id_to;

    IF(userBlocked > 0) THEN

        INSERT INTO messages (id_message, subject, content, from_user_id, to_user_id, publication_date, status_message_sender_id, status_message_receptor_id, status_sender_id)
        VALUES (v_id_message, v_subject, v_content, v_id_from, v_id_to, NOW(), 1, 1, 2);

    ELSE

        INSERT INTO messages (id_message, subject, content, from_user_id, to_user_id, publication_date, status_message_sender_id, status_message_receptor_id, status_sender_id)
        VALUES (v_id_message, v_subject, v_content, v_id_from, v_id_to, NOW(), 1, 1, 1);

    END IF;

END //