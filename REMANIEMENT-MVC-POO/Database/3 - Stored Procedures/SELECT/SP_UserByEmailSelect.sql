DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserByEmailSelect //
CREATE PROCEDURE SP_UserByEmailSelect (v_email VARCHAR(255))
BEGIN

    SELECT *
    FROM users
    WHERE email = LOWER(v_email)
    AND id <> 1;

END //