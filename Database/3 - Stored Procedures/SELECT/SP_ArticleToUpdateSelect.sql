DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleToUpdateSelect //
CREATE PROCEDURE SP_ArticleToUpdateSelect (v_id INT)
BEGIN

    SELECT art.id, art.title, art.content, art.image, art.user_id, art.category_id, DATE_FORMAT(art.creation_date, 'Le %d/%m/%Y à %H:%i') AS creation_date, u.pseudo, cat.category
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    INNER JOIN categories cat ON art.category_id = cat.id
    WHERE art.id = v_id
    AND art.status_id = 1;

END //