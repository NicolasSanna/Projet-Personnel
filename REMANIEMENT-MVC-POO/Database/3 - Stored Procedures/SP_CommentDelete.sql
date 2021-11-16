DELIMITER //
DROP PROCEDURE IF EXISTS SP_CommentDelete //
CREATE PROCEDURE SP_CommentDelete(v_id INT(11))
BEGIN

    DELETE
    FROM comments
    WHERE id = v_id;

END //