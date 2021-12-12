DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetAllUsersMessageSelect //
CREATE PROCEDURE SP_GetAllUsersMessageSelect ()
BEGIN

    SELECT u.id, u.pseudo
    FROM users u
    WHERE u.id <> 1
    AND u.pseudo <> "Supprimé"
    ORDER BY u.pseudo DESC;

END //