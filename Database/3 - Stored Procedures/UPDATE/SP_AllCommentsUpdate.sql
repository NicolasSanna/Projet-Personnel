DELIMITER //
DROP PROCEDURE IF EXISTS SP_AllCommentsUpdate //
CREATE PROCEDURE SP_AllCommentsUpdate ()
BEGIN

    UPDATE comments
    SET status_id = 2
    WHERE status_id = 1;

END //