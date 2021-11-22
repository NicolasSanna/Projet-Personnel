DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleSelect //
CREATE PROCEDURE SP_ArticleSelect (v_id INT)
BEGIN

    SELECT art.id, art.title, art.content, art.user_id, art.category_id, art.creation_date, u.pseudo, cat.category
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    INNER JOIN categories cat ON art.category_id = cat.id
    WHERE art.id = v_id;

END //