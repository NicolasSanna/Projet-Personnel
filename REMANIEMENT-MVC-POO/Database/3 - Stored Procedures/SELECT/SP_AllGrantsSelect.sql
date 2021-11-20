DELIMITER //
DROP PROCEDURE IF EXISTS SP_AllGrantsSelect //
CREATE PROCEDURE SP_AllGrantsSelect ()
BEGIN

    SELECT *
    FROM grants
    WHERE privilege <> "Administrateur"
    OR id <> 1;

END // 