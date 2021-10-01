DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryModify // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_CategoryModify (v_id INT(11), v_category VARCHAR(255)) -- On lange la création de la procédure. Elle prend en paramètre la ligne de l'identifiant de la catégorie existant déjà, ainsi que la nouvelle chaîne de caractère avec laquelle on va vouloir la remplacer. 
BEGIN -- Début de l'écriture de la procédure.

	DECLARE message VARCHAR(512); -- On déclare une variable message qui sera un VARCHAR de 512 caractères maximum.
    DECLARE exist SMALLINT; -- On déclare une variable existe qui sera un petit nombre.
    DECLARE doublon SMALLINT; -- On déclare une variable doublon qui sera un petit nombre.
    
    SET message = ''; -- On initialise la variable message à une chaîne vide.

    -- On lance la requête suivante. Elle va compter le nombre de lignes dans la table categories qu'elle va stocker dans exist. Dans la clause WHERE, on donnera la variable en paramètre de la procédure à entrer dans l'id de la table.
    
    SELECT COUNT(id)
    INTO exist 
    FROM categories
    WHERE id = v_id;

    -- Si exist ne contient pas de ligne à la suite de la requête, alors on execute le code suivant :
    
    IF (exist = 0) THEN

    -- On enregistre dans la variable message le contenu suivant, que l'on concatène avec la variable de l'identifiant entré en paramètre.

    	SET message = CONCAT ('La catégorie ', v_id, ' n''existe pas');

    END IF; -- Fin du IF, la procédure s'arrête là.

    -- On vérifie ensuite si la chaîne de caractères entrée par l'utilisateur en paramètre n'a pas une correspondance doublée dans la table. On lance alors une requête qui va compter les identifiants dans la table categories et qui sera stockée dans doublon. Dans la clause WHERE, on récupère la colonne et la ligne de la catégorie concernée et la variable entrée en paramètre comme nouveau nom de catégorie entrée par l'utilisateur. On procède à une mise en minuscule afin d'éviter toute sensibilité à la casse du côté de ce que l'on trouve déjà dans la table, de même que ce que l'on veut entrer. Et l'on parcorut les identifiants de catégorie ensuite supérieur et inférieur à celui entré par l'utilisateur.
    
    SELECT COUNT(id)
    INTO doublon
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category)
    AND categories.id <> v_id;

    -- Si doublon est supérieur à 0, c'est-à-dire que la requête a retourné un résultat (le nom d'une catégorie) alors on éxécute le code suivant :
    
    IF(doublon > 0) THEN 

        -- On stocke dans une variable de message que la catégorie existe déjà avec le nom de celle-ci en variable via la fonction de concaténation.

    	SET message = CONCAT ('Une catégorie ', v_category, ' existe déjà');


    END IF; -- Fin du IF. La procédure s'arrête là.

    -- Si la variable message est vide, c'est-à-dire qu'il n'y a pas d'erreurs, alors on peut procéder à l'exécution du code suivant :

    -- Syntaxe alternative de la ligne 52 : IF (doublon = 0) THEN
    
    IF(message = '') THEN

    -- On éxécute la requête suivante. Elle va mettre à jour la table categories. Elle va sélectionner la colonne category et entrer la variable insérée en paramètre. Dans la clause WHERE, on indique l'identifiant de la ligne et la variable insérée également en paramètre de la procédure.

    	UPDATE categories
        SET category = v_category
        WHERE id = v_id;

        -- On renvoie un message de succès à l'utilisateur une fois que la procédure s'est bien déroulée. 
        
        SET message = 'La catégorie a bien été modifiée.';

    END IF;
    
    -- On sélectionne le message à afficher à l'utilisateur.
    
    SELECT message;

END // -- Fin de l'écriture de la procédure.