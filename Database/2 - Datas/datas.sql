-- On précise la base de données sur la quelle l'on veut entrer les données. 
USE huma_scientio;

-- On entre les données des différentes tables.
INSERT INTO grants (id, privilege)
VALUES
(1, 'Administrateur'),
(2, 'Auteur'),
(3, 'Inscrit');

INSERT INTO categories (id, category)
VALUES
(1, 'Non classé');

INSERT INTO users (id, firstname, lastname, pseudo, email, password, inscription_date, grant_id)
VALUES 
(1, 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', 'Supprimé', NOW(), 3);

INSERT INTO status (id, label)
VALUES
(1, "En attente d'approbation"),
(2, "Approuvé"),
(3, "Message autorisé"),
(4, "Message bloqué");