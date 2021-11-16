DELIMITER //
DROP PROCEDURE IF EXISTS SP_CommentApprouved //
CREATE PROCEDURE SP_CommentApprouved (v_id INT(11))
BEGIN

    UPDATE comments
    SET status_id = 2
    WHERE id = v_id;
    
END //