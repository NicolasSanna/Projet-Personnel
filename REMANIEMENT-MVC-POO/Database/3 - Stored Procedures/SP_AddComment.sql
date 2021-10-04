DELIMITER //
DROP PROCEDURE IF EXISTS SP_AddComment //
CREATE PROCEDURE SP_AddComment (v_content TEXT, v_user_id INT(11), v_article_id INT(11))
BEGIN 

INSERT INTO comments (content, user_id, article_id, date_publication)
VALUES
(v_content, v_user_id, v_article_id, NOW());

END //