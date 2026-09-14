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
- 👨‍🏫 Moniteurs
- 🚗 Véhicules
- 📄 Contrats
- 💰 Paiements
- 📅 Séances et planning
- 📝 Examens
- 📊 Statistiques

Le projet est actuellement **en cours de développement**.

---

## 🎯 Objectifs

- Digitaliser la gestion d'une auto-école.
- Centraliser les données et les opérations de gestion.
- Faciliter le suivi des candidats.
- Automatiser la gestion des contrats et des documents.
- Préparer la gestion des séances, du planning et des examens.
- Mettre en pratique l'architecture **MVC**.
- Approfondir la **POO en PHP**.
- Concevoir et exploiter une base de données relationnelle avec **MySQL**.
- Développer une application web complète, structurée, sécurisée et maintenable.

---

# ✨ Fonctionnalités

## 🔐 Authentification & Utilisateurs

Le système prévoit une gestion complète des utilisateurs et des rôles.

- [x] Structure des utilisateurs
- [x] Gestion des rôles
- [x] Création des utilisateurs
- [x] Modification des utilisateurs
- [x] Désactivation des utilisateurs
- [x] Suppression des utilisateurs
- [ ] Authentification complète
- [ ] Gestion du profil
- [ ] Déconnexion sécurisée

---

## 👨‍🎓 Gestion des candidats

Le module **Candidats (UC03)** est actuellement l'un des modules fonctionnels principaux de l'application.

### Fonctionnalités disponibles

- [x] Liste des candidats
- [x] Ajout d'un candidat
- [x] Attribution automatique du rôle candidat
- [x] Affichage des photos de profil
- [x] Consultation des informations
- [x] Modification d'un candidat
- [x] Suppression d'un candidat
- [x] Validation des formulaires
- [x] Gestion des erreurs
- [x] Flash Messages
- [x] Gestion des données liées au candidat

Le CRUD des candidats est actuellement **opérationnel**.

---

## 📄 Gestion des contrats

Le module **Contrats (UC06)** a également été développé.

### Fonctionnalités disponibles

- [x] Création d'un contrat
- [x] Consultation des contrats
- [x] Affichage des informations liées au candidat
- [x] Modification d'un contrat
- [x] Suppression d'un contrat
- [x] Validation des données
- [x] Gestion des messages de confirmation/erreur
- [ ] Impression des contrats
- [ ] Génération des documents imprimables

La prochaine étape de ce module consiste à implémenter **l'impression des documents liés aux contrats et aux candidats**.

---

## 👨‍🏫 Gestion des moniteurs

Module prévu dans l'application.

- [ ] Liste des moniteurs
- [ ] Ajout d'un moniteur
- [ ] Modification
- [ ] Suppression
- [ ] Consultation des informations
- [ ] Gestion des disponibilités

---

## 🚗 Gestion des véhicules

Module prévu pour gérer les véhicules utilisés par l'auto-école.

- [ ] Liste des véhicules
- [ ] Ajout d'un véhicule
- [ ] Modification
- [ ] Suppression
- [ ] Consultation des informations
- [ ] Gestion de l'état et de la disponibilité

---

## 💰 Gestion des paiements

Le module financier permettra de gérer les paiements effectués par les candidats.

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

# 👥 Utilisateurs

L'application prévoit quatre profils principaux :

| Rôle           | Description                                          |
| -------------- | ---------------------------------------------------- |
| **Directeur**  | Gestion globale de l'auto-école                      |
| **Secrétaire** | Gestion administrative et candidats                  |
| **Moniteur**   | Gestion des séances et suivi des candidats           |
| **Candidat**   | Consultation de ses informations, séances et examens |

Les fonctionnalités accessibles dépendent du **rôle de l'utilisateur**.

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
| Base de données   | MySQL Workbench                  |

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
                    │  Logique métier    │
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

                              │
                              ▼
                    ┌────────────────────┐
                    │       View         │
                    │   Interface HTML   │
                    └────────────────────┘
```

### Front Controller

Toutes les requêtes sont centralisées via :

```text
public/index.php
```

Le projet utilise également **Apache `mod_rewrite`** afin de gérer les **Clean URLs**.

Exemple :

```text
/candidates
/contracts
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
│   │   ├── contracts/
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
│
├── storage/
│
├── tests/
│
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
- [x] Routing
- [x] Clean URLs
- [x] Connexion MySQL avec PDO
- [x] Dashboard

---

## ⚙️ Développement

### 👥 Utilisateurs — UC02

- [x] Structure utilisateur
- [x] Gestion des rôles
- [x] Formulaire centralisé de création
- [x] Modification
- [x] Désactivation
- [x] Suppression
- [ ] Authentification complète
- [ ] Gestion du profil
- [ ] Déconnexion

### 👨‍🎓 Candidats — UC03

- [x] Liste des candidats
- [x] Ajout d'un candidat
- [x] Attribution automatique du rôle
- [x] Affichage des photos
- [x] Consultation
- [x] Modification
- [x] Suppression
- [x] Validation des formulaires
- [x] Gestion des erreurs
- [x] Flash Messages
- [x] CRUD complet

### 📄 Contrats — UC06

- [x] Création des contrats
- [x] Liste des contrats
- [x] Consultation
- [x] Modification
- [x] Suppression
- [x] Validation
- [x] Flash Messages
- [ ] Impression des contrats
- [ ] Génération des documents

### 👨‍🏫 Moniteurs — UC04

- [ ] CRUD des moniteurs
- [ ] Gestion des disponibilités
- [ ] Gestion des affectations

### 🚗 Véhicules — UC05

- [ ] CRUD des véhicules
- [ ] Gestion de la disponibilité
- [ ] Gestion des affectations

### 💰 Paiements — UC07

- [ ] Enregistrement des paiements
- [ ] Historique
- [ ] Suivi des paiements
- [ ] Gestion des montants restants
- [ ] Statistiques financières

### 📅 Séances & Planning — UC08 / UC09 / UC10

- [ ] Planification des séances
- [ ] Affectation candidat / moniteur / véhicule
- [ ] Consultation du planning
- [ ] Validation des séances
- [ ] Gestion des disponibilités

### 📝 Examens — UC11 / UC12

- [ ] Planification des examens
- [ ] Consultation des examens
- [ ] Gestion des résultats
- [ ] Historique des examens

### 📊 Statistiques — UC13

- [ ] Statistiques candidats
- [ ] Statistiques contrats
- [ ] Statistiques paiements
- [ ] Statistiques séances
- [ ] Statistiques examens

---

# 🖨️ Prochaine étape

La prochaine étape du développement concerne principalement **l'impression des documents**.

### Jour suivant

- [ ] Impression du contrat
- [ ] Mise en forme du document imprimable
- [ ] Impression des informations du candidat
- [ ] Préparation des documents administratifs
- [ ] Vérification de la présentation avant impression

L'objectif est de permettre à l'administration de générer facilement des documents propres et prêts à être imprimés.

---

# 🧪 Finalisation

Une fois les principaux modules terminés :

- [ ] Tests fonctionnels
- [ ] Tests de validation
- [ ] Sécurité
- [ ] Gestion des permissions
- [ ] Protection des données
- [ ] Optimisation du code
- [ ] Optimisation de la base de données
- [ ] Responsive final
- [ ] Documentation finale
- [ ] Déploiement

---

# 🚀 État actuel du projet

🟡 **En cours de développement**

### Progression actuelle

- ✅ Analyse & conception
- ✅ Base de données
- ✅ Architecture MVC
- ✅ Front Controller
- ✅ Routing & Clean URLs
- ✅ Connexion MySQL / PDO
- ✅ Interface UI
- ✅ Dashboard
- ✅ Gestion des utilisateurs
- ✅ CRUD Candidats
- ✅ CRUD Contrats
- 🚧 Impression des documents
- ⏳ Authentification complète
- ⏳ Gestion des moniteurs
- ⏳ Gestion des véhicules
- ⏳ Gestion des paiements
- ⏳ Gestion des séances
- ⏳ Planning
- ⏳ Gestion des examens
- ⏳ Statistiques avancées
- ⏳ Tests
- ⏳ Déploiement

---

# 👩‍💻 Auteur

**Nora Elayane**

Projet personnel réalisé dans le cadre de mon apprentissage du **développement web Full Stack**.

Le projet constitue également un exercice pratique permettant de mettre en œuvre :

- PHP orienté objet
- Architecture MVC
- MySQL
- PDO
- HTML / CSS / JavaScript
- Git / GitHub
- Conception de bases de données
- Développement d'une application web complète

---

# 📄 Licence

Ce projet est distribué sous licence **MIT**.
