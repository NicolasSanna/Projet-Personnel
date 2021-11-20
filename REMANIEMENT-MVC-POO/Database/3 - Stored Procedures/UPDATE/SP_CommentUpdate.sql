DELIMITER //
DROP PROCEDURE IF EXISTS SP_CommentUpdate //
CREATE PROCEDURE SP_CommentUpdate (v_id INT)
BEGIN

    UPDATE comments
    SET status_id = 2
    WHERE id = v_id;
    
END //