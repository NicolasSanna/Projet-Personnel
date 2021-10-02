DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetUserByEmail //
CREATE PROCEDURE SP_GetUserByEmail(v_email VARCHAR(255))
BEGIN

    SELECT *
    FROM users
    WHERE email = LOWER(v_email);

END //