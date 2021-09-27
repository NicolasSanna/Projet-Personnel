DELIMITER //
DROP PROCEDURE IF EXISTS SP_ArticleByCommentsTop // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_ArticleByCommentsTop () -- On créé la procédure. Elle ne prend aucun paramètre, elle doit simplement être appelée.

BEGIN -- Début de l'écriture de la procédure.

-- On lance la requête. Elle va récupérer le nombre de commentaires de la table articles, les ranger par articles et les mettre dans l'ordre du plus grand nombre au plus petit nombre. On verra s'afficher également le nom de l'auteur, et le titre de l'article puis le nombre de commentaires qui vont avec.
    SELECT users.pseudo AS Author_of_Article, articles.id AS Id_of_Article, articles.title AS Title_of_Article, COUNT(comments.id) AS Comments_By_Article 
    FROM comments 
    INNER JOIN users ON comments.user_id = users.id 
    INNER JOIN articles ON comments.article_id = articles.id 
    GROUP BY users.pseudo 
    ORDER BY Comments_By_Article DESC;


END // -- Fin de l'écriture de la procédure.