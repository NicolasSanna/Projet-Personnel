DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleUpdate //
CREATE PROCEDURE SP_ArticleUpdate(v_article_id INT(11), v_user_id INT(11), v_new_title VARCHAR(255), v_new_content TEXT, v_category_id INT(11), v_image VARCHAR(255))
BEGIN


    IF (v_image IS NOT NULL) THEN

        UPDATE articles
        SET title = v_new_title,
            content = v_new_content,
            category_id = v_category_id,
            image = v_image
        WHERE id = v_article_id
        AND user_id = v_user_id;

    ELSE

        UPDATE articles
        SET title = v_new_title,
            content = v_new_content,
            category_id = v_category_id
        WHERE id = v_article_id
        AND user_id = v_user_id;

    END IF;

END //