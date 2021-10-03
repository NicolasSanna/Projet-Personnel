DELIMITER //
DROP PROCEDURE IF EXISTS  SP_CategoryRead // -- Suppression de la procédure si elle existe déjà.
CREATE PROCEDURE SP_CategoryRead (v_id INT) -- Début de la création de la procédure. Elle prend en paramètre l'identifiant de la colonne id.
BEGIN -- Début de l'écriture de la procédure.

-- Lancement de la requête. Elle va sélectionner tous les champs venant de la table categories en fonction de ce qui a été renseigné en paramètre de la procédure comme variable. Dans la clause WHERE, on entrera l'identifiant de la ligne selon la colonne id grâce à la variable entrée en paramètre.

	SELECT *
    FROM categories cat
    WHERE cat.id = v_id;

END // -- Fin de l'écriture de la procédure.