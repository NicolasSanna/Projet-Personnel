DROP USER IF EXISTS '4dm1n1str4teur'@'localhost';


CREATE USER '4dm1n1str4teur'@'localhost' IDENTIFIED BY 'TODO';

-- Phase de développement :

GRANT ALL PRIVILEGES
ON huma_scientio.*
TO '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;

-- Après :

GRANT EXECUTE
ON huma_scientio.*
TO '4dm1n1str4teur'@'localhost';

FLUSH PRIVILEGES ;

-- B(v@!VR-q4XCmMzK