DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryDeleteName //
CREATE PROCEDURE SP_CategoryDeleteName (v_category VARCHAR(128)) 
BEGIN 

	DECLARE message VARCHAR(512); 
    DECLARE exist SMALLINT; 
    
    SET message = ''; 
    
    SELECT COUNT(id)
    INTO exist 
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category);
    
    IF(exist = 0)THEN

    

    	SET message = CONCAT('La catégorie ', v_category, ' n''existe pas');

    END IF;

    IF(message = '') THEN

        DELETE
        FROM categories
        WHERE LOWER(categories.category) = LOWER(v_category);

        SET message = CONCAT('La catégorie ', v_category, ' a bien été supprimée.');

   END IF; 
   
   SELECT message; 

END // 