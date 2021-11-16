DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetOneComment //
CREATE PROCEDURE SP_GetOneComment (v_id INT(11))
BEGIN

    SELECT *
    FROM comments
    WHERE id = v_id;

END //