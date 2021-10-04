DELIMITER //
DROP PROCEDURE IF EXISTS SP_ModifyArticle //
CREATE PROCEDURE SP_ModifyArticle (v_article_id INT(11), v_user_id INT(11), v_new_title VARCHAR(255), v_new_content TEXT, v_category_id INT(11))
BEGIN

    UPDATE articles
    SET title = v_new_title,
        content = v_new_content,
        category_id = v_category_id
    WHERE id = v_article_id
    AND user_id = v_user_id;

END //