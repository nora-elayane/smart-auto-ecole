# Dictionnaire de Données

# Smart Auto-Ecole

---

## Objectif

Le dictionnaire de données recense l'ensemble des attributs des tables du système **Smart Auto-Ecole**, en précisant pour chacun son type, sa taille, ses contraintes et sa description. Il est établi à partir du MCD, du MLD et des Dépendances Fonctionnelles.

---

## Sommaire des tables

| Table | Description | Nombre d'attributs |
|---|---|---|
| [ROLE](#role) | Rôles disponibles dans l'application | 2 |
| [UTILISATEUR](#utilisateur) | Toute personne utilisant l'application (Directeur, Secrétaire, Moniteur, Candidat) | 12 |
| [CATEGORIE](#categorie) | Catégories de permis de conduire | 4 |
| [VEHICULE](#vehicule) | Véhicules utilisés pour les séances pratiques | 7 |
| [CONTRAT](#contrat) | Inscription d'un candidat à une catégorie de permis | 6 |
| [SEANCE](#seance) | Séances de formation théorique ou pratique | 7 |
| [PARTICIPATION](#participation) | Association entre un contrat et une séance | 5 |
| [PAIEMENT](#paiement) | Paiements effectués dans le cadre d'un contrat | 6 |
| [EXAMEN](#examen) | Examens passés par les candidats | 6 |

---

## ROLE

*Rôles disponibles dans l'application*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_role** | INT | - | PK | Identifiant unique du rôle |
| **nom_role** | VARCHAR | 50 | NOT NULL | Nom du rôle (Directeur, Secrétaire, Moniteur, Candidat) |

---

## UTILISATEUR

*Toute personne utilisant l'application (Directeur, Secrétaire, Moniteur, Candidat)*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_user** | INT | - | PK | Identifiant unique de l'utilisateur |
| **nom** | VARCHAR | 50 | NOT NULL | Nom de famille de l'utilisateur |
| **prenom** | VARCHAR | 50 | NOT NULL | Prénom de l'utilisateur |
| **email** | VARCHAR | 100 | NOT NULL, UNIQUE | Adresse email de connexion |
| **mot_de_passe** | VARCHAR | 255 | NOT NULL | Mot de passe chiffré (hashé) |
| **telephone** | VARCHAR | 20 | NOT NULL | Numéro de téléphone |
| **adresse** | VARCHAR | 255 | NULL | Adresse postale de l'utilisateur |
| **cin** | VARCHAR | 20 | NOT NULL, UNIQUE | Numéro de la carte d'identité nationale |
| **date_naissance** | DATE | - | NOT NULL | Date de naissance de l'utilisateur |
| **photo** | VARCHAR | 255 | NULL | Chemin d'accès à la photo de profil |
| **etat** | VARCHAR | 20 | NOT NULL | État du compte (Actif / Inactif) |
| **id_role** | INT | - | FK → ROLE(id_role) | Référence vers le rôle de l'utilisateur |

---

## CATEGORIE

*Catégories de permis de conduire*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_categorie** | INT | - | PK | Identifiant unique de la catégorie de permis |
| **code** | VARCHAR | 10 | NOT NULL, UNIQUE | Code de la catégorie de permis (ex : A, B, C) |
| **prix_base** | DECIMAL | 10,2 | NOT NULL | Prix de base de la formation pour cette catégorie |
| **description** | VARCHAR | 255 | NULL | Description détaillée de la catégorie |

---

## VEHICULE

*Véhicules utilisés pour les séances pratiques*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_vehicule** | INT | - | PK | Identifiant unique du véhicule |
| **immatriculation** | VARCHAR | 20 | NOT NULL, UNIQUE | Numéro d'immatriculation du véhicule |
| **marque** | VARCHAR | 50 | NOT NULL | Marque du véhicule |
| **modele** | VARCHAR | 50 | NOT NULL | Modèle du véhicule |
| **date_assurance** | DATE | - | NOT NULL | Date d'expiration de l'assurance |
| **date_visite_technique** | DATE | - | NOT NULL | Date d'expiration de la visite technique |
| **etat** | VARCHAR | 20 | NOT NULL | État du véhicule (Disponible / En panne / Hors service) |

---

## CONTRAT

*Inscription d'un candidat à une catégorie de permis*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_contrat** | INT | - | PK | Identifiant unique du contrat |
| **date_contrat** | DATE | - | NOT NULL | Date de signature du contrat |
| **prix_final** | DECIMAL | 10,2 | NOT NULL | Prix final négocié pour la formation |
| **statut** | VARCHAR | 20 | NOT NULL | Statut du contrat (En cours / Terminé / Annulé) |
| **id_user** | INT | - | FK → UTILISATEUR(id_user) | Référence vers le candidat concerné |
| **id_categorie** | INT | - | FK → CATEGORIE(id_categorie) | Référence vers la catégorie de permis choisie |

---

## SEANCE

*Séances de formation théorique ou pratique*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_seance** | INT | - | PK | Identifiant unique de la séance |
| **type** | VARCHAR | 20 | NOT NULL | Type de séance (Théorique / Pratique) |
| **date** | DATE | - | NOT NULL | Date de la séance |
| **heure_debut** | TIME | - | NOT NULL | Heure de début de la séance |
| **heure_fin** | TIME | - | NOT NULL | Heure de fin de la séance |
| **id_moniteur** | INT | - | FK → UTILISATEUR(id_user) | Référence vers le moniteur qui anime la séance |
| **id_vehicule** | INT | - | FK → VEHICULE(id_vehicule), NULL | Référence vers le véhicule utilisé (nul si séance de type Code) |

---

## PARTICIPATION

*Association entre un contrat et une séance*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_participation** | INT | - | PK | Identifiant unique de la participation |
| **presence** | BOOLEAN | - | NOT NULL | Indique si le candidat était présent |
| **remarque** | VARCHAR | 255 | NULL | Remarque du moniteur sur la participation |
| **id_seance** | INT | - | FK → SEANCE(id_seance) | Référence vers la séance concernée |
| **id_contrat** | INT | - | FK → CONTRAT(id_contrat) | Référence vers le contrat (candidat) concerné |

---

## PAIEMENT

*Paiements effectués dans le cadre d'un contrat*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_paiement** | INT | - | PK | Identifiant unique du paiement |
| **montant** | DECIMAL | 10,2 | NOT NULL | Montant payé |
| **date_paiement** | DATE | - | NOT NULL | Date du paiement |
| **mode_paiement** | VARCHAR | 20 | NOT NULL | Mode de paiement (Espèces / Chèque / Virement / Carte) |
| **reference** | VARCHAR | 50 | NULL | Référence du paiement (numéro de chèque, transaction, etc.) |
| **id_contrat** | INT | - | FK → CONTRAT(id_contrat) | Référence vers le contrat concerné |

---

## EXAMEN

*Examens passés par les candidats*

| Attribut | Type | Taille | Contrainte | Description |
|---|---|---|---|---|
| **id_examen** | INT | - | PK | Identifiant unique de l'examen |
| **type** | VARCHAR | 20 | NOT NULL | Type d'examen (Code / Conduite) |
| **date** | DATE | - | NOT NULL | Date de passage de l'examen |
| **resultat** | VARCHAR | 20 | NULL | Résultat de l'examen (Admis / Ajourné / En attente) |
| **numero_tentative** | INT | - | NOT NULL | Numéro de la tentative pour cet examen |
| **id_contrat** | INT | - | FK → CONTRAT(id_contrat) | Référence vers le contrat concerné |

---

## Légende

| Terme | Signification | Remarque |
|---|---|---|
| `PK` | Clé primaire (Primary Key) | Identifiant unique de chaque enregistrement de la table |
| `FK` | Clé étrangère (Foreign Key) | Référence vers la clé primaire d'une autre table |
| `NOT NULL` | Champ obligatoire | Ne peut pas être vide |
| `NULL` | Champ optionnel | Peut être vide |
| `UNIQUE` | Valeur unique dans la table | Ex : email, cin, immatriculation |
| `VARCHAR(n)` | Chaîne de caractères de longueur variable | n = nombre maximal de caractères |
| `INT` | Nombre entier | Utilisé notamment pour les identifiants |
| `DECIMAL(p,s)` | Nombre décimal | p = précision totale, s = nombre de décimales |
| `DATE` | Date | Format AAAA-MM-JJ |
| `TIME` | Heure | Format HH:MM:SS |
| `BOOLEAN` | Valeur booléenne | Vrai (1) ou Faux (0) |

---

## Version

**Version : 1.0**

**Statut : Validé**
