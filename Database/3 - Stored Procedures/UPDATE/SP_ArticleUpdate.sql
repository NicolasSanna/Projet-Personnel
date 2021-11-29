DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleUpdate //
CREATE PROCEDURE SP_ArticleUpdate(v_article_id INT(11), v_user_id INT(11), v_new_title VARCHAR(255), v_new_content TEXT, v_category_id INT(11), v_image VARCHAR(255))
BEGIN


    IF (v_image IS NULL) THEN

        UPDATE articles
        SET title = v_new_title,
            content = v_new_content,
            category_id = v_category_id,e
        WHERE id = v_article_id
        AND user_id = v_user_id;

    ELSE

        UPDATE articles
        SET image = v_image
        WHERE id = v_article_id
        AND user_id = v_user_id;

    END IF;

END //

-- A essayer avec la syntaxe CASE-WHEN-THEN.

DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleUpdate //
CREATE PROCEDURE SP_ArticleUpdate(v_article_id INT(11), v_user_id INT(11), v_new_title VARCHAR(255), v_new_content TEXT, v_category_id INT(11), v_image VARCHAR(255))
BEGIN

        DECLARE existeImage VARCHAR(500);

        SELECT image
        INTO existeImage
        FROM articles
        WHERE id = v_article_id;

        UPDATE articles
        SET title = v_new_title,
            content = v_new_content,
            category_id = v_category_id,
            image = 
                    (CASE v_image 
                        WHEN NULL THEN existeImage
                        ELSE v_image 
                    END)        
        WHERE id = v_article_id
        AND user_id = v_user_id;

END //