-- À la première utilisation d'une base de données, l'utilisateur root possède tous les privilèges, il faut donc le sécuriser et lui assigner un mot de passe.
ALTER USER 'root'@'localhost' IDENTIFIED BY 'TODO';

-- On supprime l'utilisateur que l'on veut créer par sécurité.
DROP USER '4dm1n1str4teur'@'localhost';

-- On créé l'utilisateur et on lui donne le vrai mot de passe. Ici, on ne l'indique pas, on met à la place un TODO.
CREATE USER '4dm1n1str4teur'@'localhost' IDENTIFIED BY 'TODO';

-- Phase de développement : On donne les privilèges nécessaires DDL et DML pendant la phase de création.
REVOKE ALL PRIVILEGES, 
GRANT OPTION
FROM '4dm1n1str4teur'@'localhost';

GRANT ALL PRIVILEGES
ON huma_scientio.*
TO '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;

-- Après : Une fois la phase de développée terminée pour mise en production, on retire tous les privilèges sauf ceux nécessaires à l'utilisateur connecté à la base de données. 
REVOKE ALL PRIVILEGES, 
GRANT OPTION
FROM '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE
ON huma_scientio.*
TO '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;