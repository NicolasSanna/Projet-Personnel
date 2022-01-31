DELIMITER //
DROP PROCEDURE IF EXISTS SP_PasswordUpdate //
CREATE PROCEDURE SP_PasswordUpdate (v_email VARCHAR(255), v_password VARCHAR(255), v_key_reinitialization VARCHAR(512))
BEGIN

    DECLARE keyReinitializationInfo VARCHAR(512);
    DECLARE v_id INT;
    DECLARE message VARCHAR(512);

    SELECT u.id, upc.key_change_password
    INTO v_id, keyReinitializationInfo
    FROM users u
    INNER JOIN user_password_change upc ON u.id = upc.user_id
    WHERE LOWER(u.email) = v_email;

    IF (keyReinitializationInfo = v_key_reinitialization) THEN

        UPDATE users
        SET password = v_password
        WHERE LOWER(email) = v_email;

        DELETE 
        FROM user_password_change
        WHERE user_id = v_id;

        SET message = "Votre mot de passe a bien été modifié, vous pouvez vous connecter";

    ELSE

        SET message = "Votre clé de réinitialisation ne correspond pas avec celle que vous avez reçu par email.";

    END IF;

    SELECT message;

END //