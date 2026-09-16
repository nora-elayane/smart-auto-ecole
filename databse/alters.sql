ALTER TABLE `contrat` 
ADD COLUMN `num_enregistrement` VARCHAR(100) NULL AFTER `id_categorie`;

ALTER TABLE `contrat` 
DROP FOREIGN KEY `fk_contrat_utilisateur`;

ALTER TABLE `contrat` 
ADD CONSTRAINT `fk_contrat_utilisateur` 
FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`) 
ON DELETE CASCADE;