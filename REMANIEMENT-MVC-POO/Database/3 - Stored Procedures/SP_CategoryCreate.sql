DELIMITER //
DROP PROCEDURE IF EXISTS SP_CategoryCreate // -- On supprime la procédure si elle existe déjà.
CREATE PROCEDURE SP_CategoryCreate (v_category VARCHAR(255)) -- on créé la procédure. Elle va prend en paramètre une chaîne de caractères de 255.
BEGIN -- Début de la création de la procédure.

	 DECLARE message VARCHAR(512); -- On déclare une variable message qui sera de 512 caractères maximum.
    DECLARE exist SMALLINT; -- On déclare une variable exist qui sera un petit nombre.
    
    SET message = ''; -- On initialise le message à une chaîne de caractères vide.

    -- On effectue ensuite une requête. On va compter le nombre de lignes dans la table categories et l'on va les stocker dans exist (INTO). On va chercher ensuite une ligne dans la colonne category qui porte le même nom ou nom que la variable entrée en paramètre de la procédure. Ces deux éléments de la clause WHERE seront paramétrées sur LOWER, c'est-à-dire que pour éviter un problème de sensibilité à la majuscule, on va tout mettre en minuscule. Par exemple, s'il y a une catégorie 'Philosophie', avec son P majuscule, la requête retournera 'philosophie', avec un P minuscule.
    
    SELECT COUNT(id)
    INTO exist
    FROM categories
    WHERE LOWER(categories.category) = LOWER(v_category);

    -- Si la requête a retourné une ligne, donc, supérieure à 0 au cours de la recherche, cela signifie que la catégorie existe déjà.
    
    IF(exist > 0) THEN -- Alors : 
       SET message = CONCAT('La categorie ', v_category, ' existe déjà.'); -- On stocke dans la variable message un texte qui avertit la personne. On concatène le contenu du message avec la variable du nom de la catégorie qui a été entrée par l'utilisateur. 
    END IF; -- On ferme le IF, et la procédure s'arrête ici. 

    -- Si au contraire, le message est vide, ou si exist = 0.

    -- Synthase alternative de la ligne 30 : IF (exist = 0) THEN
       
    IF(exist = 0) THEN -- Alors :

    -- On lance la requête d'insertion. On récupère le nom de la table, on met entre parenthèses le nom de la colonne, et dans VALUES, on met entre parenthèses la variable entrée en paramètre de la procédure. Ici, le nom d'une nouvelle catégorie. 

       INSERT INTO categories (category)
       VALUES(v_category);

       -- On écrit un message de succès, en concaténant le texte et la variable de la nouvelle catégorie insérée afin de prévenir l'utilisateur.

       SET message = CONCAT('La catégorie ', v_category ,' a bien été ajoutée.');

    END IF;

    -- On sélectionne le message et le nouvel identifiant de la catégorie ajoutée et on l'affiche à l'utilisateur.

  	SELECT message;

END //