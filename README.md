# 🚗 Smart Auto-École

![PHP](https://img.shields.io/badge/PHP-8-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![Architecture](https://img.shields.io/badge/Architecture-MVC-success)
![Status](https://img.shields.io/badge/Status-In--Progress-yellow)
![License](https://img.shields.io/badge/License-MIT-green)

**Smart Auto-École** est une application web de gestion d’une auto-école développée avec **PHP 8, MySQL 8, HTML5, CSS3 et JavaScript Vanilla**. Elle repose sur une architecture **MVC**, la programmation orientée objet (POO), PDO et un Front Controller.

Le projet vise à centraliser la gestion des utilisateurs, candidats, employés, véhicules, contrats, paiements, séances, examens et documents administratifs.

> 🚧 Le projet est en cours de développement. Les fonctionnalités cochées ci-dessous correspondent aux éléments implémentés selon l’avancement actuel ; les tests fonctionnels complets restent à poursuivre.

---

## 🎯 Objectifs

- Digitaliser et centraliser la gestion d’une auto-école.
- Faciliter le suivi des candidats et de leurs contrats.
- Organiser la gestion administrative et financière.
- Préparer la planification des séances et des examens.
- Mettre en pratique PHP orienté objet, MVC et PDO.
- Développer une application maintenable, responsive et sécurisée.

---

## ✨ Fonctionnalités

### 🔐 Authentification et autorisations — UC01

- [x] Authentification
- [x] Contrôles d’autorisation basés sur les rôles (RBAC)
- [x] Guards d’autorisation côté serveur
- [x] Filtrage de la Sidebar selon le rôle de l’utilisateur
- [x] Gestion des rôles et des accès
- [x] Déconnexion
- [ ] Tests approfondis des permissions et des scénarios de sécurité

### 👥 Gestion des utilisateurs — UC02

- [x] Structure des utilisateurs et des rôles
- [x] Création et modification des utilisateurs via les modules concernés
- [x] Gestion des statuts
- [x] Suppression
- [ ] Audit complet des opérations et des permissions sur tous les profils

### 👨‍🎓 Gestion des candidats — UC03

- [x] Liste et consultation des candidats
- [x] Création avec attribution contrôlée du rôle candidat
- [x] Modification des informations
- [x] Archivage et réactivation
- [x] Suppression définitive
- [x] Gestion et prévisualisation des photos de profil
- [x] Validation des formulaires et gestion des erreurs
- [x] Flash Messages / Toast Notifications
- [x] Fiche détaillée du candidat
- [x] Historique des contrats
- [x] Accès aux documents administratifs

### 👥 Gestion des employés — UC04

Le module couvre les **secrétaires et les moniteurs**.

- [x] Liste, consultation et création
- [x] Modification et suppression
- [x] Gestion des rôles et des statuts
- [x] Archivage et activation
- [x] Gestion des photos de profil
- [x] Notifications Flash
- [ ] Tests fonctionnels et de permissions approfondis

### 🚗 Gestion des véhicules — UC05

- [x] Liste, création, modification et suppression
- [x] Gestion de l’état du véhicule
- [x] Validation côté client avec JavaScript
- [x] Gestion des erreurs PDO
- [x] Flash Messages / Toast Notifications
- [x] Formulaires structurés et interface harmonisée
- [x] Badges d’état

Une correction a été apportée aux valeurs `ENUM` de la colonne `etat` afin d’éviter les erreurs `Data truncated`.

### 📄 Gestion des contrats — UC06

- [x] Création, consultation, modification et suppression
- [x] Validation des données
- [x] Notifications Flash / Toast
- [x] Relation Contrat ↔ Candidat
- [x] Récupération des informations de l’auto-école et du véhicule
- [x] Affichage du numéro d’enregistrement `num_enregistrement`
- [x] Vue détaillée du contrat
- [x] Navigation contextuelle entre la fiche candidat et les contrats
- [x] Routes et actions CRUD standardisées
- [x] Informations financières affichées dans la fiche du contrat

### 💰 Paiements — UC07

Les premières fonctionnalités de gestion des paiements sont intégrées à la vue détaillée du contrat.

- [x] Modèle `Payment`
- [x] Contrôleur `PaymentController`
- [x] Enregistrement des paiements associés à un contrat
- [x] Affichage dynamique du montant total payé
- [x] Calcul et affichage du solde restant
- [x] Affichage du statut financier et d’une barre de progression
- [x] Reçu de paiement imprimable (`recu_paiement.php`)
- [x] Intégration du logo dans le reçu
- [x] Actions pour imprimer, modifier et supprimer un paiement
- [ ] Vérification complète de la modification et de la suppression
- [ ] Tests des montants limites et des validations côté serveur
- [ ] Vérification des autorisations et de la cohérence financière

> Le module Paiements est en cours de validation : la présence des actions d’édition et de suppression ne signifie pas, à elle seule, que tous les scénarios ont été testés.

### 🖨️ Impression et documents administratifs

- [x] Template imprimable du Contrat d’Apprentissage
- [x] Template imprimable de la Carte Candidat
- [x] Routes et actions d’impression
- [x] Templates HTML/CSS dédiés
- [x] Templates bilingues pour les documents déjà implémentés
- [x] Menu déroulant d’impression
- [x] Intégration des informations de l’auto-école, du candidat et du véhicule
- [x] Reçu de paiement imprimable
- [ ] Attestation d’Inscription

La table `schools` centralise les informations de l’auto-école utilisées dans les documents administratifs. La colonne `num_enregistrement` est également présente dans les contrats.

### 📅 Séances et planning — UC08 / UC09 / UC10

- [ ] Création et gestion des séances
- [ ] Affectation d’un candidat
- [ ] Affectation d’un moniteur
- [ ] Affectation d’un véhicule
- [ ] Gestion des dates et horaires
- [ ] Consultation du planning
- [ ] Validation des séances
- [ ] Gestion des disponibilités

### 📝 Examens — UC11 / UC12

- [ ] Planification des examens
- [ ] Consultation des examens
- [ ] Association d’un candidat
- [ ] Gestion des dates et des types d’examens
- [ ] Suivi des résultats
- [ ] Historique des examens

### 📊 Tableau de bord et statistiques — UC13

- [x] Dashboard
- [x] Layout général
- [x] Statistiques de base
- [ ] Statistiques avancées
- [ ] Statistiques sur les candidats et les contrats
- [ ] Statistiques financières
- [ ] Statistiques sur les séances et les examens

---

## 🎨 Interface et expérience utilisateur

- [x] Header, Sidebar et Footer
- [x] Design responsive
- [x] Adaptation de l’interface pour tablette
- [x] Tables et formulaires harmonisés
- [x] Barres et boutons d’action
- [x] Badges et menus déroulants
- [x] Toast Notifications
- [x] Menu d’impression
- [x] Correction du positionnement et de l’overflow des menus
- [x] Amélioration de la Sidebar
- [x] Correction de problèmes de navigation et de redirection
- [x] Navigation contextuelle entre les pages

### 👤 Rôles prévus

| Rôle       | Responsabilités principales                                                |
| ---------- | -------------------------------------------------------------------------- |
| Directeur  | Gestion globale de l’auto-école                                            |
| Secrétaire | Gestion administrative, des candidats et des opérations autorisées         |
| Moniteur   | Accès aux fonctionnalités liées aux séances et au suivi des candidats      |
| Candidat   | Consultation de ses informations, séances et examens selon les permissions |

Les accès sont contrôlés côté serveur selon le rôle de l’utilisateur connecté.

---

## 🏗️ Architecture et routing

Le projet utilise une architecture **MVC (Model – View – Controller)** et un **Front Controller**.

```text
Browser
   |
   v
public/index.php
   |
   v
Centralized Router / Dispatch Table
   |
   v
Controller ---> Model ---> MySQL
   |
   v
View (HTML/CSS)
```

### Routing

- [x] Front Controller : `public/index.php`
- [x] Clean URLs avec Apache `mod_rewrite`
- [x] Table de dispatch centralisée
- [x] Nettoyage des anciennes routes
- [x] Standardisation des actions CRUD : `index`, `create`, `store`, `edit`, `update`, `delete`
- [x] Harmonisation des routes du module Contrats
- [x] Helpers de redirection et sessions Flash standardisés
- [x] Redirections contextuelles
- [x] Gestion des exceptions avec `try/catch`
- [x] Gestion des exceptions PDO et journalisation via `error_log()`
- [ ] Tests de non-régression de toutes les routes

Exemples de routes utilisées :

```text
/candidates
/contrats
/contrats/create
/contrats/edit
/contrats/update
/contrats/delete
/contrats/show
/employes
/vehicules
/dashboard
```

La structure du routing a été refactorisée pour faciliter l’ajout de nouveaux modules. Les chemins exacts peuvent dépendre de la configuration du routeur.

---

## 🛠️ Technologies

| Domaine           | Technologie                                 |
| ----------------- | ------------------------------------------- |
| Front-end         | HTML5, CSS3, JavaScript Vanilla             |
| Back-end          | PHP 8                                       |
| Programmation     | POO                                         |
| Base de données   | MySQL 8                                     |
| Accès aux données | PDO                                         |
| Architecture      | MVC                                         |
| Serveur web       | Apache                                      |
| Routing           | Front Controller, `mod_rewrite`, Clean URLs |
| Conception BDD    | MySQL Workbench                             |
| Maquettes         | Figma                                       |
| Versioning        | Git / GitHub                                |

---

## 📂 Structure du projet

Structure indicative du dépôt :

```text
smart-auto-ecole/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   │   ├── layouts/
│   │   ├── candidates/
│   │   ├── contrats/
│   │   ├── employes/
│   │   └── vehicules/
│   ├── Core/
│   └── Helpers/
├── config/
├── database/
│   ├── smart_auto_ecole.sql
│   └── smart_auto_ecole.mwb
├── docs/
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── uploads/
│   └── index.php
├── routes/
├── storage/
├── tests/
├── README.md
└── LICENSE
```

Cette arborescence est indicative : les fichiers et dossiers affichés doivent correspondre à la version réelle du dépôt.

---

## 📚 Documentation

La documentation du projet se trouve dans [`docs/`](docs/) et peut inclure :

- Cahier des Charges
- Diagrammes de Use Cases
- MCD et MLD
- Dépendances fonctionnelles
- Dictionnaire des données
- Diagramme EER
- Maquettes UI
- Architecture MVC
- Journal du projet
- Guide d’installation

---

## 🗺️ Roadmap

### Analyse et conception

- [x] Cahier des Charges et Use Cases
- [x] MCD, MLD et dépendances fonctionnelles
- [x] Dictionnaire des données
- [x] Diagramme EER et conception de la base de données

### Architecture et interface

- [x] Maquettes et layout général
- [x] Architecture MVC et Front Controller
- [x] Clean URLs et routing centralisé
- [x] Standardisation des actions CRUD
- [x] Helpers de redirection et gestion des erreurs
- [x] Interface responsive et notifications

### Modules métier

- [x] Candidats — UC03 : opérations principales
- [x] Employés — UC04 : CRUD principal
- [x] Véhicules — UC05 : CRUD principal
- [x] Contrats — UC06 : CRUD et vue détaillée
- [x] Authentification et guards RBAC — UC01
- [x] Paiements — UC07 : premières fonctionnalités et reçu imprimable
- [ ] Attestation d’Inscription
- [ ] Séances et planning — UC08 / UC09 / UC10
- [ ] Examens — UC11 / UC12
- [ ] Statistiques avancées — UC13

### Tests et finalisation

- [ ] Tests fonctionnels de bout en bout
- [ ] Tests CRUD et validations
- [ ] Tests de navigation et de non-régression
- [ ] Tests des autorisations par rôle
- [ ] Vérifications de sécurité et de protection des données
- [ ] Optimisation du code et de la base de données
- [ ] Vérification responsive finale
- [ ] Mise à jour de la documentation
- [ ] Déploiement

---

## 📍 État actuel du projet

**Statut : en cours de développement.**

### Éléments implémentés

- Analyse et conception de la base de données
- Architecture MVC et Front Controller
- Routing centralisé et actions CRUD standardisées
- Authentification et autorisations basées sur les rôles
- Dashboard
- Gestion des candidats, employés et véhicules
- Gestion des contrats et vue détaillée
- Suivi financier initial des contrats
- Enregistrement des paiements et reçu imprimable
- Documents imprimables : Contrat d’Apprentissage et Carte Candidat
- Gestion des exceptions et journalisation technique
- Interface responsive et filtrage de la Sidebar selon le rôle

### Prochaine étape

**Finaliser et tester le module Paiements (UC07)** : valider l’enregistrement, les montants, le solde restant, les statuts financiers, les actions de modification/suppression, les permissions et l’impression des reçus. Ensuite, poursuivre avec la gestion des séances et du planning.

---

## 👩‍💻 Auteur

**Nora Elayane**

Projet personnel réalisé dans le cadre de l’apprentissage du développement web Full Stack.

## 📄 Licence

Ce projet est distribué sous licence **MIT**.
