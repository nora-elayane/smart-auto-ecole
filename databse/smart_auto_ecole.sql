-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema smart_auto_ecole
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `smart_auto_ecole` ;

CREATE SCHEMA IF NOT EXISTS `smart_auto_ecole` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `smart_auto_ecole` ;

-- -----------------------------------------------------
-- Table `role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` INT NOT NULL AUTO_INCREMENT,
  `nom_role` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_role`),
  UNIQUE INDEX `nom_role` (`nom_role` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `utilisateur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  `cin` VARCHAR(20) NOT NULL,
  `telephone` VARCHAR(15) NOT NULL,
  `adresse` VARCHAR(255) NULL DEFAULT NULL,
  `date_naissance` DATE NOT NULL,
  `photo` VARCHAR(255) NULL DEFAULT NULL,
  `etat` ENUM('Actif', 'Inactif') NOT NULL DEFAULT 'Actif',
  `id_role` INT NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `email` (`email` ASC) VISIBLE,
  UNIQUE INDEX `cin` (`cin` ASC) VISIBLE,
  INDEX `fk_utilisateur_role` (`id_role` ASC) VISIBLE,
  CONSTRAINT `fk_utilisateur_role`
    FOREIGN KEY (`id_role`)
    REFERENCES `role` (`id_role`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NOT NULL,
  `prix_base` DECIMAL(10,2) NOT NULL,
  `description` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_categorie`),
  UNIQUE INDEX `code` (`code` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `vehicule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id_vehicule` INT NOT NULL AUTO_INCREMENT,
  `immatriculation` VARCHAR(20) NOT NULL,
  `marque` VARCHAR(50) NOT NULL,
  `modele` VARCHAR(50) NOT NULL,
  `date_assurance` DATE NOT NULL,
  `date_visite_technique` DATE NOT NULL,
  `etat` ENUM('Disponible', 'Maintenance', 'En panne') NOT NULL DEFAULT 'Disponible',
  PRIMARY KEY (`id_vehicule`),
  UNIQUE INDEX `immatriculation` (`immatriculation` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `contrat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `contrat` (
  `id_contrat` INT NOT NULL AUTO_INCREMENT,
  `date_contrat` DATE NOT NULL,
  `prix_final` DECIMAL(10,2) NOT NULL,
  `statut` ENUM('En cours', 'Terminé', 'Annulé') NOT NULL DEFAULT 'En cours',
  `id_user` INT NOT NULL,
  `id_categorie` INT NOT NULL,
  PRIMARY KEY (`id_contrat`),
  INDEX `fk_contrat_utilisateur` (`id_user` ASC) VISIBLE,
  INDEX `fk_contrat_categorie` (`id_categorie` ASC) VISIBLE,
  CONSTRAINT `fk_contrat_categorie`
    FOREIGN KEY (`id_categorie`)
    REFERENCES `categorie` (`id_categorie`),
  CONSTRAINT `fk_contrat_utilisateur`
    FOREIGN KEY (`id_user`)
    REFERENCES `utilisateur` (`id_user`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `seance`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `seance` (
  `id_seance` INT NOT NULL AUTO_INCREMENT,
  `type` ENUM('Code', 'Conduite') NOT NULL,
  `date` DATE NOT NULL,
  `heure_debut` TIME NOT NULL,
  `heure_fin` TIME NOT NULL,
  `id_moniteur` INT NOT NULL,
  `id_vehicule` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id_seance`),
  INDEX `fk_seance_moniteur` (`id_moniteur` ASC) VISIBLE,
  INDEX `fk_seance_vehicule` (`id_vehicule` ASC) VISIBLE,
  CONSTRAINT `fk_seance_moniteur`
    FOREIGN KEY (`id_moniteur`)
    REFERENCES `utilisateur` (`id_user`),
  CONSTRAINT `fk_seance_vehicule`
    FOREIGN KEY (`id_vehicule`)
    REFERENCES `vehicule` (`id_vehicule`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `participation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `participation` (
  `id_participation` INT NOT NULL AUTO_INCREMENT,
  `presence` TINYINT(1) NOT NULL DEFAULT '0',
  `remarque` VARCHAR(255) NULL DEFAULT NULL,
  `id_contrat` INT NOT NULL,
  `id_seance` INT NOT NULL,
  PRIMARY KEY (`id_participation`),
  INDEX `fk_participation_contrat` (`id_contrat` ASC) VISIBLE,
  INDEX `fk_participation_seance` (`id_seance` ASC) VISIBLE,
  UNIQUE INDEX `uk_contrat_seance` (`id_contrat` ASC, `id_seance` ASC) VISIBLE,
  CONSTRAINT `fk_participation_contrat`
    FOREIGN KEY (`id_contrat`)
    REFERENCES `contrat` (`id_contrat`),
  CONSTRAINT `fk_participation_seance`
    FOREIGN KEY (`id_seance`)
    REFERENCES `seance` (`id_seance`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `paiement`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` INT NOT NULL AUTO_INCREMENT,
  `montant` DECIMAL(10,2) NOT NULL,
  `date_paiement` DATE NOT NULL,
  `mode_paiement` ENUM('Espèces', 'Carte bancaire', 'Virement', 'Chèque') NOT NULL DEFAULT 'Espèces',
  `reference` VARCHAR(100) NULL DEFAULT NULL,
  `id_contrat` INT NOT NULL,
  PRIMARY KEY (`id_paiement`),
  UNIQUE INDEX `reference` (`reference` ASC) VISIBLE,
  INDEX `fk_paiement_contrat` (`id_contrat` ASC) VISIBLE,
  CONSTRAINT `fk_paiement_contrat`
    FOREIGN KEY (`id_contrat`)
    REFERENCES `contrat` (`id_contrat`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `examen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `examen` (
  `id_examen` INT NOT NULL AUTO_INCREMENT,
  `type` ENUM('Code', 'Conduite') NOT NULL,
  `date` DATE NOT NULL,
  `resultat` ENUM('Réussi', 'Échec') NULL DEFAULT NULL,
  `numero_tentative` INT NOT NULL DEFAULT '1',
  `id_contrat` INT NOT NULL,
  PRIMARY KEY (`id_examen`),
  INDEX `fk_examen_contrat` (`id_contrat` ASC) VISIBLE,
  CONSTRAINT `fk_examen_contrat`
    FOREIGN KEY (`id_contrat`)
    REFERENCES `contrat` (`id_contrat`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
