DELIMITER //
DROP PROCEDURE IF EXISTS SP_GetAllCommentsNotApprouved //
CREATE PROCEDURE SP_GetAllCommentsNotApprouved ()
BEGIN

    SELECT com.id, com.content, com.date_publication, u.pseudo, com.article_id, art.title
    FROM comments com
    INNER JOIN users u ON com.user_id = u.id
    INNER JOIN articles art ON com.article_id = art.id
    WHERE com.status_id = 1
    ORDER BY com.date_publication DESC;

END //