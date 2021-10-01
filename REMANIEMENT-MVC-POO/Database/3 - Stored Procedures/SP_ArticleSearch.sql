DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleSearch // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_ArticleSearch (v_srch VARCHAR(128)) -- On créé la procédure de recherche des articles. Elle prend en paramètre une variable qui est une chaîne de caractères de 128.

BEGIN -- On démarre l'écriture de la procédure.

SET v_srch = CONCAT('%', v_srch, '%'); -- On stocke dans la variable v_srch l'ensemble du code de recherche en SQL % [chaîne de recherche] % Et l'on concatène cela via la fonction CONCAT.

-- Ensuite, on écrit la requête à effectuer. Il s'agit d'une requête qui va sélectionner le titre, le contenu et le pseudo. Dans la clause WHERE, on indique avec LIKE la variable de recherche qui va aller regarder dans le titre. Avec OR, on va également vérifier si le contenu contient la variable de recherche.

SELECT DISTINCT art.title, art.content, users.pseudo
FROM articles art
INNER JOIN users ON art.user_id = users.id
WHERE art.title LIKE v_srch
OR art.content LIKE v_srch;

END // -- On termine l'écriture de la procédure.