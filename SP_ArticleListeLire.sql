DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleListeLire//
CREATE PROCEDURE SP_ArticleListeLire() 
BEGIN
    SELECT * 
    FROM article art 
    ORDER BY art.date_creation_article DESC;
END//