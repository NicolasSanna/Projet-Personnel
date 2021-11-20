DELIMITER //
DROP PROCEDURE IF EXISTS SP_OneCommentSelect //
CREATE PROCEDURE SP_OneCommentSelect (v_id INT)
BEGIN

    SELECT *
    FROM comments
    WHERE id = v_id;

END //