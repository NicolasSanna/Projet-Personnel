DELIMITER //
DROP PROCEDURE IF EXISTS SP_SearchSelect //
CREATE PROCEDURE SP_SearchSelect (v_search VARCHAR(512))
BEGIN

    SET v_search = CONCAT('%', v_search, '%');

    SELECT DISTINCT art.id AS id_article, art.title, art.content, DATE_FORMAT(art.creation_date, 'Le %d/%m/%Y à %H:%i') AS creation_date, art.user_id, u.pseudo, art.category_id, cat.id AS id_category, cat.category
    FROM articles art
    INNER JOIN categories cat ON art.category_id = cat.id
    INNER JOIN users u  ON art.user_id = u.id
    WHERE content LIKE v_search
    OR art.title LIKE v_search
    OR u.pseudo LIKE v_search
    OR cat.category LIKE v_search
    ORDER BY art.creation_date DESC;

END //