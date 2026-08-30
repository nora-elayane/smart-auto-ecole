# 📒 Journal du Projet — Smart Auto-École

Application web de gestion d'une auto-école basée sur une architecture **MVC**, avec **PHP, MySQL, HTML5, CSS3 et JavaScript Vanilla**.

---

# 📅 Jour 1 — Initialisation

## 🎯 Objectif

Définir les bases du projet **Smart Auto-École**, identifier les besoins principaux et mettre en place l'environnement initial de développement.

## ✅ Réalisations

* Définition de l'idée et des objectifs du projet **Smart Auto-École**.
* Analyse des besoins fonctionnels.
* Choix de l'architecture **MVC (Model - View - Controller)**.
* Choix des technologies :

  * **PHP**
  * **MySQL**
  * **HTML5**
  * **CSS3**
  * **JavaScript**
* Création du dépôt **GitHub**.
* Initialisation de la structure du projet.
* Création de la documentation du projet.

---

# 📅 Jour 2 — Analyse & Conception

## 🎯 Objectif

Analyser les besoins du système et concevoir son modèle fonctionnel ainsi que sa structure de données avant le début du développement.

## ✅ Réalisations

* Rédaction du **Cahier des Charges**.
* Création des **Use Cases**.
* Conception du **Modèle Conceptuel de Données (MCD)**.
* Validation des :

  * entités ;
  * attributs ;
  * relations ;
  * cardinalités.
* Conception du **Modèle Logique de Données (MLD)**.
* Rédaction des **Dépendances Fonctionnelles**.
* Création du **Dictionnaire des Données**.
* Conception du **diagramme EER** avec **MySQL Workbench**.
* Génération de la base de données MySQL via **Forward Engineering**.
* Validation de la structure finale de la base de données.

## 🧠 Décisions importantes

* Une seule table **`Utilisateur`** est utilisée pour gérer les différents utilisateurs du système et est associée à la table **`Role`**.
* Le **`Contrat`** constitue une entité centrale du système.
* Un candidat peut posséder plusieurs contrats.
* Un contrat peut recevoir plusieurs paiements.
* Les séances sont gérées à travers la table **`Participation`**.
* Les examens utilisent l'attribut **`numero_tentative`** afin de distinguer les différentes tentatives.
* Les différents types et états sont gérés à l'aide de **`ENUM`**.
* Une séance de type **`Code`** peut ne pas être associée à un véhicule.

---

# 📅 Jour 3 — Configuration & Développement de Base

## 🎯 Objectif

Configurer l'environnement serveur, intégrer l'interface utilisateur et mettre en place la structure MVC de l'application.

## 🖥️ Configuration du serveur Apache & Linux

### Réalisations

* Résolution des problèmes d'accès **404 Not Found** et **403 Forbidden**.
* Création d'un lien symbolique (**symlink**) vers `/var/www/html/`.
* Configuration des permissions Linux avec `chmod 755`.
* Vérification de l'accès à l'application via le serveur Apache.

---

## 🎨 Intégration de l'interface UI

### Layouts modularisés

Découpage du template en composants PHP réutilisables :

```text
app/
└── Views/
    └── layouts/
        ├── header.php
        ├── sidebar.php
        └── footer.php
```

### Réalisations

* Création des composants `header.php`, `sidebar.php` et `footer.php`.
* Création de la feuille de style globale **`style.css`**.
* Utilisation de **Pure CSS**, sans framework externe.
* Utilisation de **Flexbox** et **CSS Grid**.
* Intégration d'icônes **SVG natives**.
* Mise en place du **responsive design** pour desktop et mobile.

---

## 🏗️ Mise en place de l'architecture MVC & Front Controller

### Réalisations

* Création du point d'entrée unique :

```text
public/index.php
```

* Mise en place de la gestion de l'affichage des erreurs en environnement de développement.
* Création d'un premier système de routage basé sur l'analyse de l'URI.
* Création du contrôleur principal :

```text
HomeController.php
```

* Intégration de la vue principale :

```text
dashboard.php
```

* Création du premier Dashboard avec :

  * cartes de statistiques ;
  * tableau récapitulatif des séances ;
  * structure générale de l'interface d'administration.

## 🧠 Décisions importantes

### Développement Full Vanilla

Utilisation exclusive de technologies natives :

* HTML5
* CSS3
* JavaScript Vanilla
* PHP

Aucun framework frontend externe n'est utilisé afin de conserver une architecture légère et de garder une maîtrise complète du code.

### Front Controller Pattern

Toutes les requêtes de l'application sont centralisées via :

```text
public/index.php
```

Cette approche permet de centraliser le routage et le traitement des différentes requêtes.

### Découpage des vues

Les composants communs de l'interface sont isolés dans :

```text
app/Views/layouts/
```

afin de favoriser la réutilisation du code et la maintenabilité de l'application.

---

# 📅 Jour 4 — Connexion à la Base de Données & Module Candidats

## 🎯 Objectif

Connecter l'application MVC à la base de données MySQL et commencer le développement du premier module fonctionnel : la gestion des candidats.

---

## 🗄️ Intégration du modèle & Statistiques dynamiques

### Réalisations

* Création du modèle :

```text
app/Models/Students.php
```

* Mise en place de la gestion des données provenant de la table **`utilisateur`**.
* Écriture de requêtes **PDO préparées et sécurisées**.
* Création des méthodes :

  * `getTotalStudents()`
  * `getAll()`
* Filtrage des utilisateurs afin de récupérer uniquement les candidats avec :

```text
id_role = 3
```

* Connexion du **`HomeController.php`** à la base de données.
* Remplacement des données statiques du Dashboard par des données réelles.
* Affichage dynamique du **nombre total de candidats**.

---

# 👨‍🎓 Mise en place du Module Candidats

## Contrôleur

Création du contrôleur :

```text
app/Controllers/StudentController.php
```

Ce contrôleur commence à centraliser la logique métier liée aux candidats.

## Vue

Création de la vue :

```text
app/Views/students/index.php
```

Cette vue permet d'afficher dynamiquement la liste des candidats sous forme de tableau.

## 🛣️ Nouvelle route

Ajout de la route :

```text
/candidates
```

dans le **Front Controller `public/index.php`**.

L'application permet désormais d'accéder à une page dédiée à la liste des candidats.

---

# 🌐 Optimisation Apache & Routage

## Clean URLs

Création du fichier :

```text
public/.htaccess
```

afin de permettre la gestion des **Clean URLs**.

### Configuration Apache

* Activation du module :

```text
mod_rewrite
```

* Modification de la configuration Apache dans :

```text
/etc/apache2/apache2.conf
```

* Configuration de la directive :

```text
AllowOverride All
```

* Mise en place de la réécriture des URLs vers le Front Controller.

Grâce à cette configuration, l'application peut utiliser :

```text
/candidates
```

au lieu d'une URL contenant directement :

```text
/index.php
```

---

# 🎨 Gestion dynamique du menu latéral

Modification de `sidebar.php` afin de détecter automatiquement l'URI courante.

La classe :

```text
active
```

est maintenant attribuée dynamiquement à l'élément correspondant à la page actuellement visitée.

### Avantage

Cette approche évite de définir manuellement la page active pour chaque vue et permet au menu de rester cohérent avec le système de routing.

---

# 🧠 Décisions importantes

### 🔐 Utilisation de PDO

Les accès à la base de données utilisent des **requêtes préparées PDO** afin de limiter les risques d'injection SQL et d'améliorer la sécurité des interactions avec MySQL.

### 🌐 Clean URLs

Utilisation de **Apache `mod_rewrite`** pour masquer `index.php` dans les URLs et rendre les routes plus propres et lisibles.

### 🎨 Interface dynamique

Le menu latéral détermine automatiquement la page active à partir de l'URI courante au lieu d'utiliser un ciblage statique.

### 🏗️ Séparation MVC

La logique commence à être séparée entre :

```text
Model       → accès aux données
Controller  → logique de traitement
View        → affichage
```

Cette séparation servira de base au développement des prochains modules CRUD.

---

# ✅ État du projet

## 📋 Analyse & Conception

* [x] Cahier des Charges
* [x] Use Cases
* [x] MCD
* [x] MLD
* [x] Dépendances Fonctionnelles
* [x] Dictionnaire des Données
* [x] Diagramme EER
* [x] Base de données MySQL

## 🎨 Interface & Architecture

* [x] Maquettes UI / Layouts de base
* [x] Header
* [x] Sidebar
* [x] Footer
* [x] CSS global
* [x] Responsive Design
* [x] Architecture MVC
* [x] Front Controller
* [x] Routing de base
* [x] Dashboard

## ⚙️ Développement

* [x] Connexion aux données MySQL
* [x] Modèle `Students.php`
* [x] Requêtes PDO
* [x] Statistiques dynamiques du Dashboard
* [x] Contrôleur `StudentController.php`
* [x] Route `/candidates`
* [x] Vue `students/index.php`
* [x] Configuration Apache `mod_rewrite`
* [x] Clean URLs
* [x] Menu Sidebar dynamique
* [ ] Ajout d'un candidat
* [ ] Modification d'un candidat
* [ ] Suppression d'un candidat
* [ ] Validation des formulaires
* [ ] Flash Messages

---

# 🎯 Prochaine étape — Jour 5

Le prochain objectif est de compléter le **CRUD des candidats**.

## Priorités

### 1. ➕ Ajout d'un candidat

* Création de la vue `create.php`.
* Création du formulaire d'inscription.
* Ajout de la méthode `store()`.
* Insertion des données dans la base MySQL.
* Validation des données côté serveur.

### 2. ✏️ Modification d'un candidat

* Création de la vue `edit.php`.
* Récupération des données existantes.
* Création de la méthode `update()`.
* Mise à jour des informations dans la base de données.

### 3. 🗑️ Suppression d'un candidat

* Création de la méthode `delete()`.
* Ajout d'une confirmation avant suppression.
* Gestion des éventuelles contraintes liées aux données associées.

### 4. 🔔 Validation & Notifications

* Validation des champs du formulaire.
* Gestion des erreurs.
* Mise en place des **Flash Messages** :

  * succès ;
  * erreur ;
  * avertissement.

---

# 📈 Avancement du projet

| Domaine                        |  Avancement |
| ------------------------------ | ----------: |
| 📋 Analyse & Conception        | **100 %** ✅ |
| 🏗️ Architecture MVC           | **100 %** ✅ |
| 🎨 Interface & Layouts UI      | **100 %** ✅ |
| 🗄️ Base de données            | **100 %** ✅ |
| 📊 Dashboard                   | **100 %** ✅ |
| 👨‍🎓 Module Candidats — Liste | **100 %** ✅ |
| ⚙️ CRUD Candidats              | **50 %** 🚀 |
| 🧪 Tests                       | **À venir** |
| 🚀 Déploiement                 | **À venir** |

---

# 🏁 Statut actuel

> **Le projet Smart Auto-École est actuellement dans la phase de développement fonctionnel. 🚀**

L'analyse et la conception sont terminées. L'architecture MVC, le serveur Apache, les layouts UI, la connexion aux données et le système de routing sont désormais opérationnels.

Le premier module fonctionnel, **Candidats**, est commencé avec l'affichage dynamique des données depuis MySQL.

**Prochaine priorité : finaliser le CRUD des candidats avec l'ajout, la modification, la suppression et la validation des formulaires.**
