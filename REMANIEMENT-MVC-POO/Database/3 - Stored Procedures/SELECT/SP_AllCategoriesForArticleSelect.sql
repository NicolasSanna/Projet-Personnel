DELIMITER //
DROP PROCEDURE IF EXISTS SP_AllCategoriesForArticleSelect //
CREATE PROCEDURE SP_AllCategoriesForArticleSelect ()
BEGIN

    SELECT *
    FROM categories;

END //