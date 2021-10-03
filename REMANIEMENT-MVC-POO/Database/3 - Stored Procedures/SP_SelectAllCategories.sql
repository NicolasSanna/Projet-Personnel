DELIMITER //
DROP PROCEDURE IF EXISTS SP_SelectAllCategories //
CREATE PROCEDURE SP_SelectAllCategories ()
BEGIN

    SELECT *
    FROM Categories;

END //