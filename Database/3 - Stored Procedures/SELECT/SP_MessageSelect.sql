DELIMITER //
DROP PROCEDURE IF EXISTS SP_MessageSelect //
CREATE PROCEDURE SP_MessageSelect (v_message_id VARCHAR(512))
BEGIN

    SELECT msgs.id_message, msgs.subject, msgs.content, msgs.from_user_id, msgs.to_user_id, msgs.publication_date, u.pseudo AS pseudoTo, ufrom.pseudo AS pseudoFrom, ufrom.id AS pseudoFromId
    FROM messages AS msgs
    INNER JOIN users AS u ON msgs.to_user_id = u.id
    INNER JOIN users AS ufrom ON msgs.from_user_id = ufrom.id
    WHERE msgs.id_message = v_message_id;

END //