DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryWithoutArticlesDelete //
CREATE PROCEDURE SP_CategoryWithoutArticlesDelete (v_id INT)
BEGIN

    DECLARE exist SMALLINT;
    DECLARE message VARCHAR(512);
    DECLARE categoryinfo VARCHAR(255);

    SET message = '';

    SELECT COUNT(id)
    INTO exist
    FROM categories
    WHERE id = v_id;

    IF (exist = 0) THEN

        SET message = CONCAT("La catégorie ", v_id, " n'existe pas");

    END IF;

    IF (exist > 0) THEN

        SELECT category 
        INTO categoryinfo
        FROM categories
        WHERE id = v_id;

        UPDATE articles
        SET category_id = 1
        WHERE category_id = v_id;

        SET message = CONCAT("La catégorie ", categoryinfo, " a bien été supprimée");

    END IF;

    SELECT message;

END //