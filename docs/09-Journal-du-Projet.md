# 📒 Journal du Projet — Smart Auto-École

---

# 📅 Jour 1 — Initialisation

## Réalisations

* Définition de l'idée et des objectifs de **Smart Auto-École**.
* Analyse des besoins fonctionnels.
* Identification des principaux acteurs :

  * Directeur
  * Secrétaire
  * Moniteur
  * Candidat
* Choix de l'architecture **MVC**.
* Choix des technologies : **PHP, MySQL, HTML5, CSS3 et JavaScript**.
* Création du dépôt GitHub et de la structure initiale du projet.
* Mise en place de la documentation.

---

# 📅 Jour 2 — Analyse & Conception

## Réalisations

* Rédaction du **Cahier des Charges**.
* Création des **Use Cases**.
* Conception du **MCD** et du **MLD**.
* Définition des entités, relations et cardinalités.
* Rédaction des **Dépendances Fonctionnelles**.
* Création du **Dictionnaire des Données**.
* Conception du diagramme **EER** avec MySQL Workbench.
* Génération et validation de la base de données MySQL.

## Décisions importantes

* Une table **Utilisateur** liée à **Role** pour les différents profils.
* Le **Contrat** comme élément central de la gestion des candidats.
* Plusieurs contrats possibles pour un candidat.
* Plusieurs paiements possibles pour un contrat.
* Gestion des séances via **Participation**.
* Gestion des tentatives d'examen avec `numero_tentative`.
* Utilisation des `ENUM` pour certains types et états.
* Une séance **Code** peut être réalisée sans véhicule.

---

# 📅 Jour 3 — Architecture & Interface

## Réalisations

* Configuration du serveur **Apache/Linux**.
* Résolution des erreurs **404** et **403**.
* Mise en place du lien symbolique vers `/var/www/html/`.
* Configuration des permissions Linux.
* Création des layouts réutilisables :

  * `header.php`
  * `sidebar.php`
  * `footer.php`
* Création du `style.css` en **Pure CSS**.
* Utilisation de **Flexbox**, **CSS Grid** et SVG.
* Mise en place du responsive design.
* Création du **Front Controller** `public/index.php`.
* Mise en place du routing de base.
* Création de `HomeController.php`.
* Création du **Dashboard**.

## Use Cases concernés

* **UC02 — Gérer les utilisateurs**
* **UC03 — Gérer les candidats**
* **UC09 — Consulter le planning**
* **UC13 — Consulter les statistiques**

> Les interfaces sont préparées, tandis que les fonctionnalités métier sont développées progressivement.

---

# 📅 Jour 4 — Base de Données & Liste des Candidats

## Réalisations

* Création du modèle `Students.php`.
* Connexion aux données avec **PDO**.
* Création des méthodes `getAll()` et `getTotalStudents()`.
* Filtrage des utilisateurs ayant le rôle **Candidat** (`id_role = 3`).
* Connexion du Dashboard aux données réelles.
* Affichage dynamique du nombre de candidats.
* Création de `StudentController.php`.
* Création de la vue `students/index.php`.
* Ajout de la route `/candidates`.

## Routing & Interface

* Mise en place de `public/.htaccess`.
* Activation de `mod_rewrite`.
* Configuration de `AllowOverride All`.
* Mise en place des **Clean URLs**.
* Gestion dynamique de la classe `active` dans le Sidebar.

## Use Case concerné

* **UC03 — Gérer les candidats** : consultation et affichage de la liste.

---

# 📅 Jour 5 — Création des Utilisateurs & Candidats

## Réalisations

### ➕ Création

* Liaison du bouton **Ajouter un candidat** avec la route dédiée.
* Ajout de la méthode de traitement dans `StudentsController`.
* Création de la requête d'insertion dans `Students.php`.
* Attribution automatique du rôle **Candidat**.
* Mise en place du formulaire de création.

### 🔄 Centralisation

* Remplacement des formulaires spécifiques par un **formulaire unique pour les utilisateurs**.
* Transmission dynamique du rôle via un champ `hidden`.
* Suppression de la vue spécifique `create.php` après centralisation.

### 🛣️ Routing & Corrections

* Ajout de la route `storeStudent`.
* Résolution de l'erreur **404** lors de la soumission du formulaire.
* Correction de la structure HTML du tableau des candidats.
* Correction des chemins d'accès aux photos de profil.

### 📁 Stockage

* Séparation entre :

  * ressources publiques → photos de profil ;
  * stockage sécurisé → documents confidentiels comme les contrats PDF.

## Use Cases concernés

* **UC02 — Gérer les utilisateurs**
* **UC03 — Gérer les candidats**

La fonctionnalité de **création d'un candidat** est maintenant opérationnelle.

---

# 📅 Jour 6 — Modification & Sécurisation des Candidats

## 🎯 Objectif

Finaliser la fonctionnalité de modification des candidats (**UC03**) avec une gestion sécurisée des données et des photos de profil.

## ✅ Réalisations

### ✏️ Modification d'un candidat

* Création et intégration de l'interface d'édition d'un candidat.
* Mise en place du traitement de modification dans le contrôleur et le modèle.
* Récupération et affichage des informations existantes du candidat.
* Mise à jour sécurisée des données en base avec **PDO**.

### 🔐 Sécurité du compte

* Gestion sécurisée du mot de passe lors de la modification.
* Conservation de l'ancien mot de passe lorsqu'aucun nouveau mot de passe n'est fourni.
* Mise à jour du mot de passe uniquement lorsqu'une nouvelle valeur est renseignée.

### 📷 Gestion des photos

* Ajout de l'upload d'une nouvelle photo.
* Ajout d'un **preview JavaScript** avant l'enregistrement.
* Suppression automatique de l'ancienne photo avec `unlink` lors de son remplacement.
* Gestion du chemin de stockage des photos de profil.

## 🧠 Décisions importantes

* Ne jamais écraser le mot de passe existant sans nouvelle valeur.
* Supprimer l'ancienne photo uniquement lorsqu'une nouvelle photo est correctement enregistrée.
* Conserver les requêtes préparées **PDO** pour les opérations de modification.

## 🎯 Use Case concerné

* **UC03 — Gérer les candidats** : consultation, création et modification.

---

# 📈 Avancement

**Analyse & Conception : 100 %** ✅

**Architecture & UI : 100 %** ✅

**Module Candidats : 80 %** 🚀

La liste, la création et la modification des candidats sont maintenant fonctionnelles et sécurisées.

---

# 📅 Jour 7 — Finalisation du module Candidats & Notifications

## 🎯 Objectif

Finaliser les principales actions de gestion des candidats et améliorer le feedback utilisateur grâce à un système de notifications visuelles.

## ✅ Réalisations

* [x] Implémentation de l'**archivage (Soft Delete)** des candidats.
* [x] Implémentation de l'**activation** des candidats archivés.
* [x] Finalisation de la **suppression définitive** des candidats.
* [x] Ajout de **Flash Messages / Toast Notifications** dynamiques.
* [x] Notifications pour les actions :

  * Création
  * Modification
  * Archivage
  * Activation
  * Suppression définitive
* [x] Création d'une feuille de style dédiée `public/css/toast.css`.
* [x] Intégration des Toast Notifications dans l'interface.
* [x] Ajout d'une fermeture automatique des notifications.
* [x] Implémentation d'un effet **auto-fade** en JavaScript.
* [x] Amélioration du feedback utilisateur après chaque opération.

## 🧠 Décisions importantes

* Utiliser le **Soft Delete** afin de conserver les données du candidat tout en permettant son archivage.
* Permettre la réactivation d'un candidat archivé.
* Réserver la suppression définitive aux actions nécessitant réellement la suppression des données.
* Centraliser l'affichage des notifications pour garder une interface cohérente.
* Séparer le style des Toasts dans un fichier CSS dédié.
* Utiliser JavaScript pour gérer le comportement dynamique et la disparition automatique des notifications.

## 🎯 Use Cases concernés

### UC03 — Gestion des candidats

* Création
* Consultation
* Modification
* Archivage
* Activation
* Suppression définitive

## 📌 État

Le module **Gestion des candidats (UC03)** est maintenant fonctionnel pour les principales opérations CRUD, avec archivage, activation, suppression définitive et système de notifications intégré.

La validation complète des formulaires reste à renforcer avant de considérer le module comme totalement finalisé.

# 📅 Jour 8 — Analyse, Benchmark & Redesign UX / Architecture du Module Contrats

## 🎯 Objectif

Analyser le fonctionnement du module Contrats et redéfinir son organisation afin d'améliorer l'expérience utilisateur et de préparer son intégration avec les autres modules métier.

## ✅ Réalisations

* **Étude concurrentielle & Analyse SWOT :**

  * Analyse des solutions existantes.
  * Identification des points forts et faibles.
  * Recherche d'une expérience utilisateur plus fluide et intuitive.

* **Architecture Single Source of Truth (SSOT) :**

  * Centralisation de l'accès aux contrats depuis la gestion des candidats.
  * Réduction de la duplication des informations.

* **Fiche Candidat :**

  * Affichage des informations personnelles.
  * Affichage de l'historique des contrats.
  * Ajout d'un contrat directement depuis la fiche candidat.

* **Tableau des Contrats :**

  * Ajout d'un menu d'actions :

    * Éditer
    * Supprimer
    * Imprimer Contrat
    * Imprimer Attestation
    * Imprimer Carte Candidat
  * Ajout d'un bouton **Consulter**.

* **Page de détails du Contrat :**

  * Création d'une vue dédiée.
  * Organisation par onglets :

    * Paiements
    * Séances
    * Examens

## 🎯 Use Cases concernés

* **UC03 — Gestion des candidats**
* **UC06 — Gestion des contrats**
* Préparation de **UC07 — Gestion des paiements**
* Préparation de **UC08 — Planification des séances**
* Préparation de **UC11 — Planification des examens**

## 📌 État

La conception UX et l'organisation du module Contrats sont définies. La structure permet également de préparer l'intégration future des paiements, séances et examens.

# 📅 Jour 9 — Implémentation Technique & Module Contrats

## 🎯 Objectif

Implémenter le module Contrats dans l'architecture MVC et permettre la création et l'affichage des contrats associés aux candidats.

## ✅ Réalisations

* **Architecture MVC :**

  * Création du `ContratController`.
  * Création du modèle `Contrat`.
  * Création des vues :

    * `students/show.php`
    * `contrats/create.php`

* **Fiche Candidat & Contrats :**

  * Affichage des informations du candidat.
  * Affichage des contrats associés.
  * Utilisation d'une jointure SQL `LEFT JOIN categorie`.
  * Récupération de la catégorie du permis avec les détails du contrat.
  * Utilisation de `PDO::fetchAll()`.

* **Gestion dynamique :**

  * Récupération de l'ID candidat via `$_GET['id']`.
  * Affichage dynamique des informations correspondant au candidat sélectionné.

* **Création d'un Contrat :**

  * Création du formulaire de souscription.
  * Transmission de l'ID candidat via un `hidden input`.
  * Traitement du formulaire en `POST`.
  * Utilisation de requêtes préparées PDO.
  * Validation des données côté serveur.
  * Redirection dynamique après traitement.

## 🎯 Use Cases concernés

* **UC03 — Gestion des candidats**
* **UC06 — Gestion des contrats**

## 📌 État

La création et l'affichage des contrats associés aux candidats sont maintenant fonctionnels. Le module est intégré à l'architecture MVC et utilise des requêtes préparées avec validation côté serveur.

# 🎯 Prochaine étape — Jour 10

📄 **Finaliser le module UC06 — Gestion des contrats.**

* [ ] Implémenter la modification d'un contrat
* [ ] Implémenter la suppression d'un contrat
* [ ] Ajouter les notifications Toast aux actions Contrats
* [ ] Renforcer la validation des formulaires Contrats
* [ ] Tester les opérations CRUD du module
* [ ] Vérifier les relations Contrat ↔ Candidat

# 📊 Progression actuelle

| Partie                   | État        |
| ------------------------ | ----------- |
| Analyse & Conception     | 🟢 100%     |
| Architecture & Interface | 🟢 100%     |
| Base de données          | 🟢 100%     |
| Dashboard                | 🟢 100%     |
| UC03 — Candidats         | 🟢 90%      |
| UC02 — Utilisateurs      | 🟡 En cours |
| UC06 — Contrats          | 🟡 50%      |
| UC01 — Authentification  | 🔴 À venir  |
| UC04 → UC05              | 🔴 À venir  |
| UC07 → UC15              | 🔴 À venir  |
| Tests & Déploiement      | 🔴 À venir  |

> **État actuel :** Le module **Gestion des contrats (UC06)** est en cours d'implémentation. La fiche candidat permet maintenant d'afficher les contrats associés et de créer un nouveau contrat avec validation côté serveur et requêtes préparées PDO. La modification et la suppression des contrats restent à implémenter.
