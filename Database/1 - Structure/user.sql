ALTER USER 'root'@'localhost' IDENTIFIED BY 'TODO';

DROP USER '4dm1n1str4teur'@'localhost';

CREATE USER '4dm1n1str4teur'@'localhost' IDENTIFIED BY 'TODO';

-- Phase de développement :

REVOKE ALL PRIVILEGES, 
GRANT OPTION
FROM '4dm1n1str4teur'@'localhost';

GRANT ALL PRIVILEGES
ON huma_scientio.*
TO '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;

-- Après :

REVOKE ALL PRIVILEGES, 
GRANT OPTION
FROM '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;

GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE
ON huma_scientio.*
TO '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;