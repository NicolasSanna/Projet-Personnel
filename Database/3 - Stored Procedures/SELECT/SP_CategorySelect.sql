DELIMITER //
DROP PROCEDURE IF EXISTS  SP_CategorySelect //
CREATE PROCEDURE SP_CategorySelect (v_id INT) 
BEGIN

	SELECT *
    FROM categories cat
    WHERE cat.id = v_id
    AND cat.id <> 1
    AND cat.category <> "Non classé";

END //