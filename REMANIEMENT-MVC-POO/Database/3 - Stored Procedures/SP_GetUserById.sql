DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetUserById //
CREATE PROCEDURE SP_GetUserById (v_id INT(11))
BEGIN

    SELECT *
    FROM users
    WHERE id = v_id
    AND grant_id <> 1;
    AND users.pseudo <> 'Supprimé';

END //