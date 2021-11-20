DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserByIdSelect //
CREATE PROCEDURE SP_UserByIdSelect (v_id INT(11))
BEGIN

    SELECT *
    FROM users
    WHERE id = v_id
    AND users.grant_id <> 1

END //