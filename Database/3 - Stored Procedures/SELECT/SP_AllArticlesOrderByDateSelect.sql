DELIMITER //
DROP PROCEDURE IF EXISTS SP_AllArticlesOrderByDateSelect //
CREATE PROCEDURE SP_AllArticlesOrderByDateSelect ()
BEGIN

    SELECT art.id, art.title, art.content, art.user_id, art.category_id, art.creation_date, u.pseudo, cat.category
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    INNER JOIN categories cat ON art.category_id = cat.id
    ORDER BY art.creation_date DESC;

END //