DELIMITER //
DROP PROCEDURE IF EXISTS SP_UserWithoutArticlesCommentsDelete //
CREATE PROCEDURE SP_UserWithoutArticlesCommentsDelete (v_id INT)
BEGIN

    DECLARE message VARCHAR(512);
    DECLARE existUser SMALLINT;
    DECLARE existDelete SMALLINT;
    DECLARE grantId SMALLINT;

    DECLARE pseudoinfo VARCHAR(255);

    SET message = '';
    SET grantId = 2;

    SELECT COUNT(id)
    INTO existDelete
    FROM users
    WHERE LOWER(pseudo) = LOWER('Supprimé');

    IF (existDelete = 0) THEN
        
        INSERT INTO users (id, firstname, lastname, pseudo, email, password, inscription_date, grant_id)
        VALUES (1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', NOW(), grantId);

            SELECT COUNT(id)
            INTO existUser
            FROM users
            WHERE id = v_id;

            IF (existUser = 0) THEN

                SET message = CONCAT("L'utilisateur ", v_id ," n'existe pas.");

            END IF;

            IF (existUser > 0) THEN

                SELECT pseudo
                INTO pseudoinfo
                FROM users
                WHERE id = v_id;

                UPDATE comments
                SET user_id = 1
                WHERE user_id = v_id;

                UPDATE articles
                SET user_id = 1
                WHERE user_id = v_id;

                DELETE
                FROM users
                WHERE id = v_id;

                SET message = CONCAT("L'utilisateur ", pseudoinfo, " a bien été supprimé.");

            END IF;

    END IF;

    IF (existDelete > 0) THEN

        SELECT COUNT(id)
        INTO existUser
        FROM users
        WHERE id = v_id;

        IF (existUser = 0) THEN

            SET message = CONCAT("L'utilisateur ", v_id ," n'existe pas.");

        END IF;

        IF (existUser > 0) THEN

            SELECT pseudo
            INTO pseudoinfo
            FROM users
            WHERE id = v_id;

            UPDATE comments
            SET user_id = 1
            WHERE user_id = v_id;

            UPDATE articles
            SET user_id = 1
            WHERE user_id = v_id;

            DELETE
            FROM users
            WHERE id = v_id;

            SET message = CONCAT("L'utilisateur ", pseudoinfo, " a bien été supprimé.");

        END IF;

    END IF;

    SELECT message;

END //