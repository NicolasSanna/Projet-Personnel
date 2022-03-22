DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleImageUpdate //
CREATE PROCEDURE SP_ArticleImageUpdate (v_article_id INT)
BEGIN

    UPDATE articles
    SET image = NULL
    WHERE id = v_article_id;

END //