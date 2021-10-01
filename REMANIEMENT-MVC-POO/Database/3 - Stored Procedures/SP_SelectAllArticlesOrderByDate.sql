DELIMITER //
DROP PROCEDURE IF EXISTS SP_SelectAllArticlesOrderByDate //
CREATE PROCEDURE SP_SelectAllArticlesOrderByDate ()
BEGIN

    SELECT *
    FROM articles art
    ORDER BY art.creation_date DESC;

END //