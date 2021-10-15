DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryCreate // 
CREATE PROCEDURE SP_CategoryCreate (v_category VARCHAR(255)) 
BEGIN 

	 DECLARE message VARCHAR(512); 
    DECLARE exist SMALLINT; 
    
    SET message = ''; 

   
    
    SELECT COUNT(id)
    INTO exist
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category);

    
    
    IF(exist > 0) THEN 
       SET message = CONCAT('La catégorie ', v_category, ' existe déjà.'); 
    END IF; 

    
       
    IF(exist = 0) THEN 

       INSERT INTO categories (category)
       VALUES(v_category);

       SET message = CONCAT('La catégorie ', v_category ,' a bien été ajoutée.');

    END IF;

    

  	SELECT message;

END //