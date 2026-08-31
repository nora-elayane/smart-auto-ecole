-- Insertion des rôles
INSERT INTO `role` (`nom_role`) VALUES
('Directeur'),
('Secrétaire'),
('Moniteur'),
('Candidat');


-- Insertion des catégories de permis de conduire
INSERT INTO `categorie` (`code`, `prix_base`, `description`) VALUES
('A', 2100.00, 'Permis Moto - Motocycles et tricycles à moteur'),
('B', 3550.00, 'Permis Voiture - Véhicules légers de tourisme et utilitaires (<= 3500 kg)'),
('C', 6500.00, 'Permis Poids Lourds - Véhicules de transport de marchandises'),
('D', 7000.00, 'Permis Transport en Commun - Autobus et autocars'),
('EC', 5500.00, 'Permis Remorque - Véhicules de la catégorie C avec remorque');
