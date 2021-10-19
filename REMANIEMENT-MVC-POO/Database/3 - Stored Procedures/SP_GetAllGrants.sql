DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetAllGrants //
CREATE PROCEDURE SP_GetAllGrants ()
BEGIN

    SELECT *
    FROM grants
    WHERE privilege <> "Administrateur"
    AND id <> 1;

END // 