DELIMITER //
DROP PROCEDURE IF EXISTS SP_TwoArticlesOrderByDateSelect //
CREATE PROCEDURE SP_TwoArticlesOrderByDateSelect ()
BEGIN

    SELECT art.id, art.title, art.content, art.user_id, art.category_id, DATE_FORMAT(art.creation_date, 'Le %d/%m/%Y à %H:%i') AS creation_date, u.pseudo, cat.category
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    INNER JOIN categories cat ON art.category_id = cat.id
    AND status_id = 2
    ORDER BY art.creation_date DESC
    LIMIT 2;
    
END //