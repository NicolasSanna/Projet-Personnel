DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticlesNotApprouvedSelect //
CREATE PROCEDURE SP_ArticlesNotApprouvedSelect ()
BEGIN 

    SELECT art.id, art.title, art.content, art.image, u.pseudo, DATE_FORMAT(art.creation_date,  'Le %d/%m/%Y à %H:%i') AS creation_date
    FROM articles art
    INNER JOIN users u ON art.user_id = u.id
    WHERE art.status_id = 1
    ORDER BY art.creation_date DESC;

END //