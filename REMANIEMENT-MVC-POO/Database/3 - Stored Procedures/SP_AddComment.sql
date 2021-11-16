DELIMITER //
DROP PROCEDURE IF EXISTS SP_AddComment //
CREATE PROCEDURE SP_AddComment (v_content TEXT, v_user_id INT(11), v_article_id INT(11))
BEGIN

DECLARE status_id SMALLINT;

SET status_id = 1;

INSERT INTO comments (content, user_id, article_id, status_id, date_publication)
VALUES
(v_content, v_user_id, v_article_id, status_id, NOW());

END //