DELIMITER //
DROP PROCEDURE IF EXISTS SP_SelectUsersAdmin //
CREATE PROCEDURE SP_SelectUsersAdmin()
BEGIN

    SELECT u.id AS userId, u.firstname, u.lastname, u.email, u.pseudo, u.inscription_date, COUNT(art.id) AS number_articles, gr.id AS grantId, gr.privilege
    FROM users u
    LEFT JOIN articles art ON u.id = art.user_id
    INNER JOIN grants gr ON u.grant_id = gr.id
    WHERE u.grant_id <> 1
    AND u.pseudo <> 'Supprimé'
    GROUP BY u.pseudo
    ORDER BY u.inscription_date ASC;

END //