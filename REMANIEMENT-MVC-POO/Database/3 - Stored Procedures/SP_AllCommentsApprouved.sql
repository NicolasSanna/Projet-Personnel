DELIMITER //
DROP PROCEDURE IF EXISTS SP_AllCommentsApprouved //
CREATE PROCEDURE SP_AllCommentsApprouved ()
BEGIN

    UPDATE comments
    SET status_id = 2
    WHERE status_id = 1;

END //