DELIMITER //
DROP PROCEDURE IF EXISTS SP_SendBoxSelect //
CREATE PROCEDURE SP_SendBoxSelect (v_id_from INT)
BEGIN

    SELECT msgs.id_message, msgs.subject, msgs.content, msgs.from_user_id, msgs.to_user_id, msgs.publication_date, ms.label AS MessageStatusLabel, ms.id AS MessageStatusId, us.label AS StatusSenderLabel, us.id AS StatusSenderId, u.pseudo AS pseudoTo, ufrom.pseudo AS pseudoFrom, ufrom.id AS pseudoFromId
    FROM messages AS msgs
    INNER JOIN users AS u ON msgs.to_user_id = u.id
    INNER JOIN users AS ufrom ON msgs.from_user_id = ufrom.id
    INNER JOIN message_status AS ms ON msgs.status_message_sender_id = ms.id
    INNER JOIN user_status AS us ON msgs.status_sender_id = us.id
    WHERE msgs.from_user_id = v_id_from
    AND status_message_sender_id = 1
    ORDER BY msgs.publication_date DESC;

END //