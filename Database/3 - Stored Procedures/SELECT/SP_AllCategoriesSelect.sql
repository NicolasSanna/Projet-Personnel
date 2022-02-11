DELIMITER //
DROP PROCEDURE IF EXISTS SP_AllCategoriesSelect //
CREATE PROCEDURE SP_AllCategoriesSelect ()
BEGIN

    SELECT *
    FROM categories
    WHERE id <> 1
    AND category <> "Non classé";

END //