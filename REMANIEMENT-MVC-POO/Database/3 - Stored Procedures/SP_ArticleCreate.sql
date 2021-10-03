DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleCreate //
CREATE PROCEDURE SP_ArticleCreate (v_title VARCHAR(255), v_content TEXT, v_category_id INT(11), v_user_id INT(11))
BEGIN

    INSERT INTO articles (title, content, category_id, user_id, creation_date) 
    VALUES (v_title, v_content, v_category_id, v_user_id, NOW());

END //