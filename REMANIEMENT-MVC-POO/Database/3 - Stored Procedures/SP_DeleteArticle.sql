DELIMITER //
DROP PROCEDURE IF EXISTS SP_DeleteArticle //
CREATE PROCEDURE SP_DeleteArticle (v_article_id INT(11), v_user_id INT(11))
BEGIN

    DELETE 
    FROM articles
    WHERE id = v_article_id
    AND user_id = v_user_id;

END //