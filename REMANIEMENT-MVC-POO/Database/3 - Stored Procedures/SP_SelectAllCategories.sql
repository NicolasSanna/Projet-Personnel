DELIMITER //
DROP PROCEDURE IF EXISTS SP_SelectAllCategories //
CREATE PROCEDURE SP_SelectAllCategories ()
BEGIN

    SELECT *
    FROM Categories
    WHERE id <> 1
    AND category <> "Non classé";

END //