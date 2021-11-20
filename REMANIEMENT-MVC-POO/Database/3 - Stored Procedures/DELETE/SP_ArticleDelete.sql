DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleDelete //
CREATE PROCEDURE SP_ArticleDelete (v_article_id INT, v_user_id INT)
BEGIN

    DELETE 
    FROM articles
    WHERE id = v_article_id
    AND user_id = v_user_id;

END //