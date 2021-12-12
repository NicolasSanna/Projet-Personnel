DELIMITER //
DROP PROCEDURE IF EXISTS SP_MessageFromUserTrashboxUpdate //
CREATE PROCEDURE SP_MessageFromUserTrashboxUpdate (v_message_id VARCHAR(255))
BEGIN

    UPDATE messages
    SET status_message_sender_id = 2
    WHERE id_message = v_message_id;

END //