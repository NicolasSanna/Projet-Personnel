CREATE USER '4dm1n1str4teur'@'localhost' IDENTIFIED BY 'TODO';

GRANT SELECT,
      INSERT,
      UPDATE,
      DELETE,
      EXECUTE
ON histoire_philosophie.*
TO '4dm1n1str4teur'@'localhost';