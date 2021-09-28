DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleLire//
CREATE PROCEDURE SP_ArticleLire(art_id INT) 
BEGIN
    SELECT * 
    FROM article art 
    WHERE art.id_art = art_id
    ORDER BY art.date_creation_article DESC;
END//