-- Avec CASE WHEN THEN ELSE

DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleInsert //
CREATE PROCEDURE SP_ArticleInsert (v_title VARCHAR(255), v_content TEXT, v_category_id INT, v_user_id INT, v_image VARCHAR(255))
BEGIN

        DECLARE v_status SMALLINT;
        SET v_status = 1;
    
        INSERT INTO articles (title, content, category_id, user_id, creation_date, image) 
        VALUES (v_title, v_content, v_category_id, v_user_id, NOW(),
            (
                CASE v_image 
                    WHEN NULL THEN NULL 
                    ELSE v_image 
                END
            )
        );

END //

-- Avec CASE WHEN THEN ELSE

DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleInsert //
CREATE PROCEDURE SP_ArticleInsert (v_title VARCHAR(255), v_content TEXT, v_category_id INT, v_user_id INT, v_image VARCHAR(255))
BEGIN

        DECLARE v_status SMALLINT;
        SET v_status = 1;

        INSERT INTO articles (title, content, category_id, user_id, status_id,  creation_date, image) 
        VALUES (v_title, v_content, v_category_id, v_user_id, v_status, NOW(),
            (
                CASE
                    WHEN v_image IS NULL THEN NULL
                    ELSE v_image 
                END
            )
        );

END //