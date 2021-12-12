DELIMITER //
DROP PROCEDURE IF EXISTS SP_MessageToUserTrashboxUpdate //
CREATE PROCEDURE SP_MessageToUserTrashboxUpdate (v_message_id VARCHAR(255))
BEGIN

    UPDATE messages
    SET status_message_receptor_id = 2
    WHERE id_message = v_message_id;

END //