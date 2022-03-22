DELIMITER //
DROP PROCEDURE IF EXISTS SP_ApprouveArticleUpdate //
CREATE PROCEDURE SP_ApprouveArticleUpdate (v_id INT)
BEGIN 

    UPDATE articles 
    SET status_id = 2
    WHERE id = v_id;

END //