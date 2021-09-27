DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryDeleteName // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_CategoryDeleteName (v_category VARCHAR(128)) -- On créé la procédure. Elle prend en paramètre une chaine de caractères, celle qui va remplacer le nom de la catégorie en question.
BEGIN -- Début de l'écriture de la procédure.

	DECLARE message VARCHAR(512); -- On déclare une variable message étant une chaîne de caractères de 512.
    DECLARE exist SMALLINT; -- On déclare une variable exist qui sera un petit nombre.
    
    SET message = ''; -- On initialise le message à une chaîne vide.

    -- On lance une requête qui va compter les identifiants de la table categories que l'on stocke dans INTO. Dans la clause WHERE, on donne la variable insérée en paramètre pour la recherche.
    
    SELECT COUNT(id)
    INTO exist 
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category);

    -- Si la recherche ne retourne aucune ligne (0) Alors on exécute le code suivant :
    
    IF(exist = 0)THEN

    -- On stocke dans la variable message l'identifiant entré et l'on indique qu'il nexiste pas.

    	SET message = CONCAT('La catégorie ', v_category, ' n''existe pas');

    END IF; -- Fermeture du IF.

    -- En revanche, si la variable message est vide, on exécute le code suivant :

    -- Syntaxe alternative de la ligne 32 : IF(exist > 0)
    
    IF(message = '') THEN
        
    -- Alors on éxécute la requête suivante. Elle va supprimer dans la table catégorie l'identifiant donné en variable v_category

        DELETE
        FROM categories
        WHERE LOWER(categories.category) = LOWER(v_category);

            -- Puis l'on met dans la variable message comme quoi la catégorie a bien été supprimée si l'opération a réussi.
        
        	SET message = CONCAT('La catégorie ', v_category, ' a bien été supprimée.');

   END IF; -- Fin du IF.
   
   SELECT message; -- On sélectionne le message à afficher à l'utilisateur.

END // -- Fin de l'écriture de la procédure.