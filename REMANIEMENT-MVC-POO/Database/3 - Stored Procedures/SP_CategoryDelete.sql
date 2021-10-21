DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryDelete //
CREATE PROCEDURE SP_CategoryDelete (v_id INT(11)) 
BEGIN 

	DECLARE message VARCHAR(512); 
    DECLARE exist SMALLINT; 
    DECLARE categoryinfo VARCHAR(255);
    
    SET message = '';   
    
    SELECT COUNT(id)
    INTO exist 
    FROM categories
    WHERE id = v_id;
    
    IF(exist = 0)THEN

    	SET message = CONCAT('La catégorie ', v_id, ' n''existe pas');

    END IF; 
    
    IF(exist > 0) THEN
        
        SELECT category
        INTO categoryinfo
        FROM categories
        WHERE id = v_id;

        DELETE
        FROM categories
        WHERE id = v_id;
        
        	SET message = CONCAT("La catégorie ",  categoryinfo, " a bien été supprimée");

   END IF; 
   
   SELECT message; 

END // 