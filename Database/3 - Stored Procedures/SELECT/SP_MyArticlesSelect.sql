DELIMITER //
DROP PROCEDURE IF EXISTS SP_MyArticlesSelect //
CREATE PROCEDURE SP_MyArticlesSelect (v_id INT)
BEGIN

    SELECT art.id AS articleId, art.title, art.user_id, art.category_id, art.creation_date, cat.id, cat.category, COUNT(com.article_id) AS number_comments
    FROM articles art
    INNER JOIN categories cat ON art.category_id = cat.id
    INNER JOIN users u ON art.user_id = u.id
    LEFT JOIN comments com ON art.id = com.article_id
    WHERE u.id = v_id
    GROUP BY art.id
    ORDER BY art.creation_date DESC;

END //