DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleInsert //
CREATE PROCEDURE SP_ArticleInsert (v_title VARCHAR(255), v_content TEXT, v_category_id INT, v_user_id INT, v_image VARCHAR(255))
BEGIN

    IF (v_image IS NOT NULL) THEN
    
        INSERT INTO articles (title, content, category_id, user_id, creation_date, image) 
        VALUES (v_title, v_content, v_category_id, v_user_id, NOW(), v_image);

    ELSE

        INSERT INTO articles (title, content, category_id, user_id, creation_date) 
        VALUES (v_title, v_content, v_category_id, v_user_id, NOW());

    END IF;

END //