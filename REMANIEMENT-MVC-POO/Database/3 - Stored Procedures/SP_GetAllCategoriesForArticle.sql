DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetAllCategoriesForArticle //
CREATE PROCEDURE SP_GetAllCategoriesForArticle()
BEGIN

    SELECT *
    FROM categories;

END //