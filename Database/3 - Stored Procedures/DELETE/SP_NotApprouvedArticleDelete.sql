DELIMITER //
DROP PROCEDURE IF EXISTS SP_NotApprouvedArticleDelete //
CREATE PROCEDURE SP_NotApprouvedArticleDelete (v_id INT)
BEGIN 

    DELETE 
    FROM articles
    WHERE id = v_id
    AND status_id = 1;

END //