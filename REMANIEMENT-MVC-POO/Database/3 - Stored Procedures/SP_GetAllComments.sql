DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetAllComments //
CREATE PROCEDURE SP_GetAllComments (v_article_id INT(11))
BEGIN

    SELECT com.content, com.date_publication, u.pseudo, com.article_id
    FROM comments com
    INNER JOIN users u ON com.user_id = u.id
    WHERE com.article_id = v_article_id;

END //