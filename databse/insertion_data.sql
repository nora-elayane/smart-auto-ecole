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

-- Insertion  auto ecole informations 
INSERT INTO school_info (
    id,
    nom_ecole,
    num_autorisation,
    num_registre_national,
    num_patente,
    num_rc,
    adresse,
    ville,
    telephone,
    fax,
    email,
    representant_legal,
    logo
) VALUES (
    1,
    'Smart Auto-École',
    'AE-BM-2026-00125',
    'RN-2026-004578',
    'PAT-2026-00987',
    'RC-2026-003214',
    'Avenue Hassan II, Quartier Centre',
    'Beni Mellal',
    '0523001122',
    '0523001123',
    'contact@smart-autoecole.ma',
    'Nora Elayane',
    'uploads/logo.png'
);