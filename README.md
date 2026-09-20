# 🚗 Smart Auto-École

![PHP](https://img.shields.io/badge/PHP-8-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![Architecture](https://img.shields.io/badge/Architecture-MVC-success)
![Status](https://img.shields.io/badge/Status-In--Progress-yellow)
![License](https://img.shields.io/badge/License-MIT-green)

**Smart Auto-École** est une application web de gestion d'une auto-école développée avec **PHP 8, MySQL 8, HTML5, CSS3 et JavaScript Vanilla**, en suivant une architecture **MVC** et les principes de la **programmation orientée objet (POO)**.

Le projet a pour objectif de centraliser et simplifier la gestion des différents éléments d'une auto-école :

- 👥 Utilisateurs
- 👨‍🎓 Candidats
- 👨‍🏫 Employés (Secrétaires & Moniteurs)
- 🚗 Véhicules
- 📄 Contrats
- 💰 Paiements
- 📅 Séances & Planning
- 📝 Examens
- 📊 Statistiques
- 🖨️ Documents administratifs

Le projet est actuellement **en cours de développement**.

---

# 🎯 Objectifs

- Digitaliser la gestion d'une auto-école.
- Centraliser les données et les opérations de gestion.
- Faciliter le suivi des candidats.
- Automatiser la gestion des contrats et des documents administratifs.
- Préparer la gestion des séances, du planning et des examens.
- Mettre en pratique l'architecture **MVC**.
- Approfondir la **POO en PHP**.
- Concevoir et exploiter une base de données relationnelle avec **MySQL**.
- Développer une application web complète, structurée, sécurisée et maintenable.

---

# ✨ Fonctionnalités

## 🔐 Authentification & Utilisateurs

La structure des utilisateurs et des rôles est déjà en place. L'authentification complète sera développée dans une prochaine étape.

- [x] Structure des utilisateurs
- [x] Gestion des rôles
- [x] Création des utilisateurs
- [x] Gestion des profils utilisateurs via les modules concernés
- [ ] Authentification complète
- [ ] Gestion des permissions
- [ ] Déconnexion sécurisée

---

## 👨‍🎓 Gestion des candidats — UC03

Le module **Candidats (UC03)** est l'un des modules fonctionnels principaux de l'application.

### Fonctionnalités disponibles

- [x] Liste des candidats
- [x] Consultation des informations
- [x] Ajout d'un candidat
- [x] Attribution automatique du rôle candidat
- [x] Modification d'un candidat
- [x] Archivage d'un candidat
- [x] Activation d'un candidat archivé
- [x] Suppression définitive
- [x] Gestion des photos de profil
- [x] Prévisualisation des photos
- [x] Validation des formulaires
- [x] Gestion des erreurs
- [x] Flash Messages / Toast Notifications
- [x] Gestion des données liées au candidat
- [x] Fiche candidat
- [x] Historique des contrats
- [x] Accès aux documents administratifs

Le CRUD principal des candidats est **opérationnel**.

---

## 👥 Gestion des employés — UC04

Le module **Gestion des employés** permet de gérer les **Secrétaires et les Moniteurs**.

### Fonctionnalités disponibles

- [x] Liste des employés
- [x] Ajout d'un employé
- [x] Modification d'un employé
- [x] Consultation du profil
- [x] Suppression
- [x] Archivage
- [x] Activation
- [x] Gestion des rôles
- [x] Gestion des statuts
- [x] Gestion des photos de profil
- [x] Upload sécurisé des photos
- [x] Flash Messages
- [x] CRUD complet

Le module **Employés** est actuellement fonctionnel pour les opérations principales de gestion.

---

## 🚗 Gestion des véhicules — UC05

Le module **Véhicules (UC05)** dispose maintenant d'un CRUD fonctionnel.

### Fonctionnalités disponibles

- [x] Liste des véhicules
- [x] Ajout d'un véhicule
- [x] Modification d'un véhicule
- [x] Suppression
- [x] Gestion de l'état du véhicule
- [x] Validation côté client avec JavaScript
- [x] Gestion des erreurs PDO
- [x] Flash Messages / Toast Notifications
- [x] Formulaires structurés
- [x] Badges d'état
- [x] Interface harmonisée avec les autres modules

Une correction a également été apportée concernant les valeurs **ENUM** de la colonne `etat` afin d'éviter les erreurs `Data truncated`.

---

## 📄 Gestion des contrats — UC06

Le module **Contrats (UC06)** est actuellement fonctionnel pour les principales opérations CRUD.

### Fonctionnalités disponibles

- [x] Création d'un contrat
- [x] Consultation
- [x] Modification
- [x] Suppression
- [x] Validation des données
- [x] Flash Messages / Toast Notifications
- [x] Relation Contrat ↔ Candidat
- [x] Récupération des informations de l'auto-école
- [x] Récupération des informations du véhicule
- [x] Routing standardisé sous `/contrats/*`
- [x] Redirections contextuelles
- [x] Gestion du paramètre `from`
- [x] Retour vers la fiche candidat ou la liste des contrats

### Routing Contrats

Les principales routes du module sont maintenant standardisées :

```text
/contrats/create
/contrats/edit
/contrats/update
/contrats/delete
/contrats/show
```

La navigation est adaptée au contexte d'origine afin de permettre des retours cohérents entre les pages **Candidats** et **Contrats**.

---

## 🖨️ Impression & Documents administratifs

Une première partie du système d'impression est maintenant fonctionnelle.

### Documents disponibles

- [x] Template imprimable du **Contrat d'Apprentissage**
- [x] Template imprimable de la **Carte Candidat**
- [x] Routes d'impression
- [x] Actions d'impression dans le Controller
- [x] Templates HTML/CSS dédiés
- [x] Templates bilingues
- [x] Menu Dropdown d'impression
- [x] Intégration des informations de l'auto-école
- [x] Intégration des informations du candidat
- [x] Intégration des informations du véhicule
- [ ] Attestation d'Inscription

### Structure de l'auto-école

Une table `schools` a été ajoutée afin de centraliser les informations de l'auto-école utilisées dans les documents administratifs.

La colonne `num_enregistrement` a également été ajoutée aux contrats.

---

## 💰 Gestion des paiements

Le module financier est prévu pour gérer les paiements liés aux contrats.

- [ ] Enregistrement des paiements
- [ ] Consultation des paiements
- [ ] Historique des paiements
- [ ] Suivi des montants payés
- [ ] Suivi des montants restants
- [ ] Gestion des statuts de paiement
- [ ] Statistiques financières

---

## 📅 Gestion des séances & planning

Le système prévoit une gestion des séances de conduite et du planning.

- [ ] Création d'une séance
- [ ] Attribution d'un candidat
- [ ] Attribution d'un moniteur
- [ ] Attribution d'un véhicule
- [ ] Gestion de la date et de l'heure
- [ ] Gestion des séances
- [ ] Consultation du planning
- [ ] Validation des séances
- [ ] Gestion des disponibilités

---

## 📝 Gestion des examens

Un module sera consacré à la planification et au suivi des examens.

- [ ] Planification des examens
- [ ] Consultation des examens
- [ ] Association d'un candidat
- [ ] Gestion de la date de l'examen
- [ ] Gestion du type d'examen
- [ ] Suivi du résultat
- [ ] Historique des examens

---

## 📊 Tableau de bord & statistiques

Le projet dispose déjà d'un **Dashboard** permettant de centraliser les principales informations de l'application.

- [x] Dashboard
- [x] Layout général
- [x] Statistiques de base
- [ ] Statistiques avancées
- [ ] Statistiques sur les candidats
- [ ] Statistiques financières
- [ ] Statistiques sur les séances
- [ ] Statistiques sur les examens

---

# 🎨 Interface & Expérience utilisateur

L'interface a été progressivement harmonisée entre les différents modules.

### Réalisations

- [x] Header
- [x] Sidebar
- [x] Footer
- [x] Design responsive
- [x] Tables harmonisées
- [x] Barres d'actions
- [x] Boutons d'action
- [x] Badges
- [x] Dropdowns
- [x] Toast Notifications
- [x] Menus d'impression
- [x] Correction du positionnement et de l'overflow des Dropdowns
- [x] Amélioration du Sidebar
- [x] Correction de la navigation
- [x] Correction du bouton Retour
- [x] Redirections contextuelles

L'objectif est de conserver une interface **cohérente et réutilisable** entre les différents modules.

---

# 👥 Utilisateurs

L'application prévoit quatre profils principaux :

| Rôle           | Description                                          |
| -------------- | ---------------------------------------------------- |
| **Directeur**  | Gestion globale de l'auto-école                      |
| **Secrétaire** | Gestion administrative et des candidats              |
| **Moniteur**   | Gestion des séances et suivi des candidats           |
| **Candidat**   | Consultation de ses informations, séances et examens |

Les fonctionnalités accessibles seront progressivement adaptées au **rôle de l'utilisateur** avec l'implémentation du système d'authentification et des permissions.

---

# 🛠️ Technologies

| Domaine           | Technologies                     |
| ----------------- | -------------------------------- |
| Front-end         | HTML5, CSS3, JavaScript Vanilla  |
| Back-end          | PHP 8                            |
| Programmation     | POO                              |
| Base de données   | MySQL 8                          |
| Accès aux données | PDO                              |
| Architecture      | MVC                              |
| Serveur           | Apache                           |
| Routing           | Front Controller + `mod_rewrite` |
| URLs              | Clean URLs                       |
| Design            | Figma                            |
| Versioning        | Git / GitHub                     |
| Conception BDD    | MySQL Workbench                  |

---

# 🏗️ Architecture

Le projet utilise une architecture **MVC (Model - View - Controller)**.

```text
                    ┌────────────────────┐
                    │      Browser       │
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │  Front Controller  │
                    │   public/index.php │
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │       Router       │
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │     Controller     │
                    │   Logique métier   │
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │       Model        │
                    │  Accès aux données │
                    └─────────┬──────────┘
                              │
                              ▼
                    ┌────────────────────┐
                    │       MySQL        │
                    └────────────────────┘

                              ▲
                              │
                    ┌─────────┴──────────┐
                    │       View         │
                    │   Interface HTML   │
                    └────────────────────┘
```

## Front Controller

Toutes les requêtes sont centralisées via :

```text
public/index.php
```

Le projet utilise **Apache `mod_rewrite`** afin de gérer les **Clean URLs**.

Exemples :

```text
/candidates
/contrats
/contrats/create
/employes
/vehicules
/dashboard
```

---

# 📂 Structure du projet

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
│   │   ├── vehicules/
│   │   └── ...
│   ├── Core/
│   └── Helpers/
│
├── config/
│
├── database/
│   ├── smart_auto_ecole.sql
│   └── smart_auto_ecole.mwb
│
├── docs/
│   ├── images/
│   ├── 00-Journal-du-Projet.md
│   ├── 01-Cahier-des-Charges.md
│   ├── 02-Use-Cases.md
│   ├── 03-MCD.md
│   ├── 04-MLD.md
│   ├── 05-Dependances-Fonctionnelles.md
│   ├── 06-Dictionnaire-des-Donnees.md
│   ├── 07-Maquettes.md
│   ├── 08-Architecture-MVC.md
│   └── 09-Guide-Installation.md
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── uploads/
│   └── index.php
│
├── routes/
├── storage/
├── tests/
├── README.md
└── LICENSE
```

---

# 📚 Documentation

La documentation détaillée du projet se trouve dans le dossier [`docs/`](docs/).

Elle comprend notamment :

- 📋 Cahier des Charges
- 🔄 Use Cases
- 🗃️ MCD
- 🗃️ MLD
- 🔗 Dépendances Fonctionnelles
- 📖 Dictionnaire des Données
- 🗺️ Diagramme EER
- 🎨 Maquettes UI
- 🏗️ Architecture MVC
- 📔 Journal du Projet
- ⚙️ Guide d'installation

---

# 📌 Roadmap

## 📋 Analyse & Conception

- [x] Cahier des Charges
- [x] Use Cases
- [x] MCD
- [x] MLD
- [x] Dépendances Fonctionnelles
- [x] Dictionnaire des Données
- [x] Diagramme EER
- [x] Conception de la base de données
- [x] Base de données MySQL

---

## 🎨 Interface & Architecture

- [x] Maquettes UI
- [x] Header
- [x] Sidebar
- [x] Footer
- [x] Responsive Design
- [x] Architecture MVC
- [x] Front Controller
- [x] Clean URLs
- [x] Routing initial
- [x] Routing Contrats standardisé
- [x] Redirections contextuelles
- [x] Connexion MySQL avec PDO
- [x] Dashboard
- [x] Tables harmonisées
- [x] Dropdowns
- [x] Toast Notifications

### 🔧 Refactoring à venir

- [ ] Architecture Tree des routes
- [ ] Création de `config/app.php`
- [ ] Centralisation de `BASE_URL`
- [ ] Création du helper `url()`
- [ ] Création du helper `redirect()`
- [ ] Amélioration du Router principal
- [ ] Détection automatique Controller / Action

---

## ⚙️ Développement

### 👥 Utilisateurs — UC02

- [x] Structure utilisateur
- [x] Gestion des rôles
- [x] Création des utilisateurs
- [x] Modification
- [x] Désactivation / gestion des statuts
- [x] Suppression
- [ ] Authentification complète
- [ ] Gestion des permissions
- [ ] Déconnexion sécurisée

### 👨‍🎓 Candidats — UC03

- [x] Liste
- [x] Consultation
- [x] Création
- [x] Modification
- [x] Attribution automatique du rôle
- [x] Photos de profil
- [x] Archivage
- [x] Activation
- [x] Suppression définitive
- [x] Validation
- [x] Gestion des erreurs
- [x] Flash Messages / Toasts
- [x] Fiche candidat
- [x] Historique des contrats

### 👥 Employés — UC04

- [x] CRUD complet
- [x] Secrétaires
- [x] Moniteurs
- [x] Gestion des rôles
- [x] Gestion des statuts
- [x] Archivage / activation
- [x] Gestion des photos
- [x] Flash Messages

### 🚗 Véhicules — UC05

- [x] Liste
- [x] Création
- [x] Modification
- [x] Suppression
- [x] Gestion de l'état
- [x] Validation JavaScript
- [x] Gestion des erreurs
- [x] Toast Notifications
- [x] Interface harmonisée

### 📄 Contrats — UC06

- [x] Création
- [x] Consultation
- [x] Modification
- [x] Suppression
- [x] Validation
- [x] Flash Messages
- [x] Routing `/contrats/*`
- [x] Redirections contextuelles
- [x] Paramètre `from`
- [x] Contrat ↔ Candidat
- [x] Informations de l'auto-école
- [x] Informations du véhicule
- [x] Template Contrat d'Apprentissage
- [x] Template Carte Candidat
- [ ] Attestation d'Inscription

### 💰 Paiements — UC07

- [ ] Enregistrement
- [ ] Consultation
- [ ] Historique
- [ ] Suivi des montants
- [ ] Montants restants
- [ ] Statuts de paiement
- [ ] Statistiques financières

### 📅 Séances & Planning — UC08 / UC09 / UC10

- [ ] Planification
- [ ] Affectation candidat / moniteur / véhicule
- [ ] Consultation du planning
- [ ] Validation des séances
- [ ] Gestion des disponibilités

### 📝 Examens — UC11 / UC12

- [ ] Planification
- [ ] Consultation
- [ ] Gestion des résultats
- [ ] Historique

### 📊 Statistiques — UC13

- [ ] Statistiques candidats
- [ ] Statistiques contrats
- [ ] Statistiques paiements
- [ ] Statistiques séances
- [ ] Statistiques examens

---

# 🖨️ Documents administratifs

Documents déjà préparés :

- [x] **Contrat d'Apprentissage**
- [x] **Carte Candidat**
- [ ] **Attestation d'Inscription**

Les documents utilisent des **templates HTML/CSS dédiés**, avec support des informations de l'auto-école, du candidat et du véhicule.

---

# 🧪 Tests & Finalisation

Une fois les principaux modules terminés :

- [ ] Tests fonctionnels
- [ ] Tests CRUD complets
- [ ] Tests de validation
- [ ] Tests de navigation
- [ ] Tests des permissions
- [ ] Sécurité
- [ ] Protection des données
- [ ] Optimisation du code
- [ ] Optimisation de la base de données
- [ ] Responsive final
- [ ] Documentation finale
- [ ] Déploiement

---

# 🚀 État actuel du projet

🟡 **En cours de développement**

### Modules actuellement avancés

- ✅ Analyse & conception
- ✅ Base de données
- ✅ Architecture MVC
- ✅ Front Controller
- ✅ Clean URLs
- ✅ Connexion MySQL / PDO
- ✅ Dashboard
- ✅ Gestion des candidats
- ✅ Gestion des employés
- ✅ Gestion des véhicules
- ✅ Gestion des contrats
- ✅ Documents imprimables — Contrat & Carte Candidat
- 🚧 Refactoring du système de routing
- 🚧 Attestation d'Inscription
- ⏳ Authentification complète
- ⏳ Gestion des paiements
- ⏳ Gestion des séances
- ⏳ Planning
- ⏳ Gestion des examens
- ⏳ Statistiques avancées
- ⏳ Tests finaux
- ⏳ Déploiement

### 📍 Prochaine étape

**Refactoring de l'architecture du routing et centralisation des URLs**, avec :

1. Architecture Tree des routes
2. `config/app.php`
3. `BASE_URL`
4. Helpers `url()` et `redirect()`
5. Amélioration du Router principal
6. Détection automatique du Controller et de l'Action

---

# 👩‍💻 Auteur

**Nora Elayane**

Projet personnel réalisé dans le cadre de mon apprentissage du **développement web Full Stack**.

Le projet permet de mettre en pratique :

- PHP orienté objet
- Architecture MVC
- MySQL
- PDO
- HTML / CSS / JavaScript
- Git / GitHub
- Conception de bases de données
- Routing et Clean URLs
- Développement d'une application web complète

---

# 📄 Licence

Ce projet est distribué sous licence **MIT**.
