ALTER TABLE `contrat` 
ADD COLUMN `num_enregistrement` VARCHAR(100) NULL AFTER `id_categorie`;

ALTER TABLE `contrat` 
DROP FOREIGN KEY `fk_contrat_utilisateur`;

ALTER TABLE `contrat` 
ADD CONSTRAINT `fk_contrat_utilisateur` 
FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) 
ON DELETE CASCADE;


-- UC10 : statut + remarque du moniteur sur une séance
ALTER TABLE seance
  ADD COLUMN statut ENUM('Planifiée', 'Réalisée') NOT NULL DEFAULT 'Planifiée',
  ADD COLUMN remarque_moniteur TEXT NULL;

-- (optionnel) empêcher qu'un candidat soit inscrit deux fois à la même séance
ALTER TABLE participation
  ADD UNIQUE KEY uq_participation (id_seance, id_contrat);


  -- ============================================================
-- Correctifs base de données — module Planning
-- ============================================================
 
-- 1) participation.presence est un TINYINT(1) dans ta base, alors que le code
--    enregistre 'En attente' / 'Présent' / 'Absent'  =>  l'insertion échoue.
--    On convertit en 3 étapes pour conserver les anciennes valeurs (0 / 1).
ALTER TABLE participation MODIFY presence VARCHAR(20) NOT NULL DEFAULT 'En attente';
UPDATE participation SET presence = 'En attente' WHERE presence = '0';
UPDATE participation SET presence = 'Présent'    WHERE presence = '1';
ALTER TABLE participation
  MODIFY presence ENUM('En attente', 'Présent', 'Absent') NOT NULL DEFAULT 'En attente';
 
-- 2) UC10 (si ce n'est pas déjà fait) : statut + remarque du moniteur
--    (déjà dans ton alters.sql ; à exécuter une seule fois)
-- ALTER TABLE seance
--   ADD COLUMN statut ENUM('Planifiée', 'Réalisée') NOT NULL DEFAULT 'Planifiée',
--   ADD COLUMN remarque_moniteur TEXT NULL;
 
-- 3) Inutile : participation a déjà la clé unique uk_contrat_seance (id_contrat, id_seance).
--    N'exécute PAS le "ADD UNIQUE KEY uq_participation" de alters.sql (doublon).
--    Si tu l'as déjà exécuté :  ALTER TABLE participation DROP INDEX uq_participation;
 