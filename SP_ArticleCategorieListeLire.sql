DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleCategorieListeLire//
CREATE PROCEDURE SP_ArticleCategorieListeLire(cat_id INT) 
BEGIN
    SELECT * 
    FROM article art 
    WHERE art.id_cat = cat_id
    ORDER BY art.date_creation_article DESC;
END//