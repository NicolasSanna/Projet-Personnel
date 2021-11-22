DELIMITER //
DROP PROCEDURE IF EXISTS SP_CommentInsert //
CREATE PROCEDURE SP_CommentInsert (v_content TEXT, v_user_id INT, v_article_id INT)
BEGIN

    DECLARE status_id SMALLINT;

    SET status_id = 1;

    INSERT INTO comments (content, user_id, article_id, status_id, date_publication)
    VALUES
    (v_content, v_user_id, v_article_id, status_id, NOW());

END //