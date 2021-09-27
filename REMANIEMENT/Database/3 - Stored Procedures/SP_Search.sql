DELIMITER //
DROP PROCEDURE IF EXISTS SP_Search //
CREATE PROCEDURE SP_Search (v_search VARCHAR(512))
BEGIN

    SET v_search = CONCAT('%', v_search, '%');

    SELECT DISTINCT articles.id AS id_article, title, content, creation_date, user_id, pseudo, category_id, categories.id AS id_category, category
    FROM articles
    INNER JOIN categories ON articles.category_id = categories.id
    INNER JOIN users ON articles.user_id = users.id
    WHERE content LIKE v_search
    OR articles.title LIKE v_search
    OR users.pseudo LIKE v_search
    OR categories.category LIKE v_search
    ORDER BY articles.creation_date DESC;

END //

