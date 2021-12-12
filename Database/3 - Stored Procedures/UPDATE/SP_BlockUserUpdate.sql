DELIMITER //
DROP PROCEDURE IF EXISTS SP_BlockUserUpdate //
CREATE PROCEDURE SP_BlockUserUpdate (v_user_to_block_id INT, v_user_want_block_id INT)
BEGIN

    UPDATE messages
    SET status_sender_id = 2
    WHERE from_user_id = v_user_to_block_id
    AND to_user_id = v_user_want_block_id;

END //