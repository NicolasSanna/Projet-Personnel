DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryUpdate // 
CREATE PROCEDURE SP_CategoryUpdate (v_id INT, v_category VARCHAR(255)) 
BEGIN 

	DECLARE message VARCHAR(512); 
    DECLARE exist SMALLINT;
    DECLARE doublon SMALLINT; 
    
    SET message = ''; 
    
    SELECT COUNT(id)
    INTO exist 
    FROM categories
    WHERE id = v_id;
    
    IF (exist = 0) THEN

   

    	SET message = CONCAT ('La catégorie ', v_id, ' n''existe pas');

    END IF; 
    
    SELECT COUNT(id)
    INTO doublon
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category)
    AND categories.id <> v_id;
    
    IF(doublon > 0) THEN 

        
    	SET message = CONCAT ('Une catégorie ', v_category, ' existe déjà');


    END IF; 

    IF(message = '') THEN

    

    	UPDATE categories
        SET category = v_category
        WHERE id = v_id;

        
        
        SET message = 'La catégorie a bien été modifiée.';

    END IF;
    
    
    
    SELECT message;

END // 