DELIMITER //
DROP PROCEDURE IF EXISTS SP_AllCommentsArticleSelect //
CREATE PROCEDURE SP_AllCommentsArticleSelect (v_article_id INT(11))
BEGIN

    SELECT com.content, com.date_publication, u.pseudo, com.article_id
    FROM comments com
    INNER JOIN users u ON com.user_id = u.id
    WHERE com.article_id = v_article_id
    AND com.status_id = 2
    ORDER BY date_publication DESC;

END //