# 🚗 Smart Auto-École

![PHP](https://img.shields.io/badge/PHP-8-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![Architecture](https://img.shields.io/badge/Architecture-MVC-success)
![Status](https://img.shields.io/badge/Status-In_Progress-yellow)
![License](https://img.shields.io/badge/License-MIT-green)

**Smart Auto-École** est une application web de gestion d'une auto-école développée avec **PHP 8, MySQL 8, HTML5, CSS3 et JavaScript**, en suivant une architecture **MVC**.

Le projet a pour objectif de centraliser et simplifier la gestion des **utilisateurs, candidats, contrats, paiements, séances, véhicules, moniteurs et examens**.

---

## 🎯 Objectifs

* Digitaliser la gestion d'une auto-école.
* Centraliser les données et les opérations.
* Faciliter le suivi des candidats.
* Mettre en pratique l'architecture **MVC** et la **POO en PHP**.
* Concevoir une base de données relationnelle avec **MySQL**.
* Développer une application web complète, structurée et maintenable.

---

## ✨ Fonctionnalités

### 🔐 Authentification & Utilisateurs

* Authentification des utilisateurs.
* Gestion des rôles.
* Gestion des utilisateurs.
* Gestion du profil utilisateur.
* Déconnexion sécurisée.

### 👨‍🎓 Candidats

* Liste des candidats.
* Ajout d'un candidat.
* Modification d'un candidat.
* Suppression d'un candidat.
* Consultation des informations d'un candidat.

### 📊 Gestion de l'auto-école

* Tableau de bord.
* Gestion des contrats.
* Gestion des paiements.
* Gestion des véhicules.
* Gestion des séances.
* Gestion des examens.
* Statistiques générales.

> Certaines fonctionnalités sont encore en cours de développement.

---

## 👥 Utilisateurs

L'application prévoit quatre profils principaux :

* **Directeur**
* **Secrétaire**
* **Moniteur**
* **Candidat**

Les fonctionnalités accessibles dépendent du rôle de l'utilisateur.

---

## 🛠️ Technologies

| Domaine           | Technologies                        |
| ----------------- | ----------------------------------- |
| Front-end         | HTML5, CSS3, JavaScript Vanilla     |
| Back-end          | PHP 8, POO                          |
| Base de données   | MySQL 8                             |
| Accès aux données | PDO                                 |
| Architecture      | MVC                                 |
| Serveur           | Apache                              |
| Routing           | Front Controller + `mod_rewrite`    |
| Outils            | Git, GitHub, MySQL Workbench, Figma |

---

## 🏗️ Architecture

Le projet utilise une architecture **MVC (Model - View - Controller)**.

```text
Model       → Gestion des données et accès à MySQL
Controller  → Logique de traitement
View        → Interface utilisateur
```

Les requêtes sont centralisées via le **Front Controller** :

```text
public/index.php
```

Le projet utilise également **Apache `mod_rewrite`** afin de gérer les Clean URLs.

Exemple :

```text
/candidates
```

---

## 📂 Structure

```text
smart-auto-ecole/

├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   │   ├── layouts/
│   │   └── students/
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
│
├── README.md
└── LICENSE
```

---

## 📚 Documentation

La documentation détaillée du projet est disponible dans [`docs/`](docs/).

Elle comprend :

* Cahier des Charges
* Use Cases
* MCD
* MLD
* Dépendances Fonctionnelles
* Dictionnaire des Données
* Maquettes UI
* Architecture MVC
* Journal du Projet
* Guide d'installation

---

## 📌 Roadmap

### 📋 Analyse & Conception

* [x] Cahier des Charges
* [x] Use Cases
* [x] MCD
* [x] MLD
* [x] Dépendances Fonctionnelles
* [x] Dictionnaire des Données
* [x] Diagramme EER
* [x] Base de données MySQL

### 🎨 Interface & Architecture

* [x] Maquettes UI / Layouts
* [x] Header / Sidebar / Footer
* [x] Responsive Design
* [x] Architecture MVC
* [x] Front Controller
* [x] Routing de base
* [x] Clean URLs
* [x] Dashboard

### ⚙️ Développement

#### Utilisateurs — UC02

* [x] Structure utilisateur
* [x] Gestion des rôles
* [x] Formulaire centralisé de création
* [x] Modification
* [x] Désactivation
* [x] Suppression

#### Candidats — UC03

* [x] Liste des candidats
* [x] Ajout d'un candidat
* [x] Attribution automatique du rôle
* [x] Affichage des photos de profil
* [x] Modification
* [x] Suppression
* [x] Validation complète des formulaires
* [x] Flash Messages

#### Autres Use Cases

* [ ] UC01 — Authentification
* [ ] UC04 — Gestion des moniteurs
* [ ] UC05 — Gestion des véhicules
* [ ] UC06 — Gestion des contrats
* [ ] UC07 — Enregistrement des paiements
* [ ] UC08 — Planification des séances
* [ ] UC09 — Consultation du planning
* [ ] UC10 — Validation des séances
* [ ] UC11 — Planification des examens
* [ ] UC12 — Consultation des examens
* [ ] UC13 — Statistiques
* [ ] UC14 — Gestion du profil
* [ ] UC15 — Déconnexion

### 🧪 Finalisation

* [ ] Tests
* [ ] Validation et sécurité
* [ ] Optimisation
* [ ] Déploiement
* [ ] Documentation finale

---

## 🚀 État du projet

🟡 **En cours de développement**

### Progression actuelle

* ✅ Analyse & conception
* ✅ Base de données
* ✅ Architecture MVC
* ✅ Interface UI de base
* ✅ Dashboard
* ✅ Connexion MySQL / PDO
* ✅ Routing & Clean URLs
* 🚧 Module Candidats
* ⏳ Authentification
* ⏳ Autres modules métier
* ⏳ Tests & déploiement

Le développement fonctionnel a commencé avec le **module Candidats (UC03)**.

La **liste et la création des candidats** sont actuellement opérationnelles.

---

## 👩‍💻 Auteur

**Nora Elayane**

Projet personnel réalisé dans le cadre de mon apprentissage du développement web Full Stack.

---

## 📄 Licence

Ce projet est distribué sous licence **MIT**.
