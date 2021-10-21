DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetArticlesByCategory //
CREATE PROCEDURE SP_GetArticlesByCategory(v_category_id INT)
BEGIN

    SELECT articles.id AS id_article , title, content, user_id, category_id, creation_date, categories.id AS id_category, category, pseudo
    FROM articles
    INNER JOIN categories ON articles.category_id = categories.id
    INNER JOIN users ON articles.user_id = users.id
    WHERE categories.id = v_category_id
    ORDER BY creation_date DESC;

END //