DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetMyArticles //
CREATE PROCEDURE SP_GetMyArticles (v_id INT(11))
BEGIN

    SELECT art.id as articleId, art.title, art.content, art.user_id, art.category_id, art.creation_date, cat.id, cat.category, COUNT(com.id) AS number_comments
    FROM articles art
    INNER JOIN categories cat ON art.category_id = cat.id
    INNER JOIN users u ON art.user_id = u.id
    LEFT JOIN comments com ON art.id = com.article_id
    WHERE u.id = v_id
    GROUP BY art.id
    ORDER BY art.creation_date DESC;

END //