INSERT INTO grants (id, privilege)
VALUES
(1, 'Administrateur'),
(2, 'Auteur');

INSERT INTO categories (id, category)
VALUES
(1, 'Non classé');

INSERT INTO users (id, firstname, lastname, pseudo, email, password, inscription_date, grant_id)
VALUES 
(1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', NOW(), 2);