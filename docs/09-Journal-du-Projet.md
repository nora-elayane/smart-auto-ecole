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

# ✅ État du projet

## Analyse & Conception

* [x] Cahier des Charges
* [x] Use Cases
* [x] MCD
* [x] MLD
* [x] Dépendances Fonctionnelles
* [x] Dictionnaire des Données
* [x] Diagramme EER
* [x] Base de données MySQL

## Architecture & Interface

* [x] Architecture MVC
* [x] Front Controller
* [x] Routing de base
* [x] Clean URLs
* [x] Layouts UI
* [x] Responsive Design
* [x] Dashboard

## Développement

* [x] Connexion MySQL / PDO
* [x] Liste des candidats
* [x] Affichage dynamique du Dashboard
* [x] Création d'un candidat
* [x] Formulaire utilisateur centralisé
* [x] Gestion dynamique des rôles
* [x] Gestion des photos de profil
* [ ] Modification d'un candidat
* [ ] Suppression d'un candidat
* [ ] Validation complète des formulaires
* [ ] Flash Messages
* [ ] Authentification
* [ ] Autres modules métier

---

# 🎯 Prochaine étape — Jour 6

* ✏️ Modifier un candidat.
* 🗑️ Supprimer un candidat.
* 🔔 Ajouter les messages de succès/erreur.
* ✅ Renforcer la validation des formulaires.
* 🔐 Préparer le module **Authentification (UC01)**.

---

# 📈 Avancement

| Phase                | État            |
| -------------------- | --------------- |
| Analyse & Conception | **100 %** ✅     |
| Architecture & UI    | **100 %** ✅     |
| Module Candidats     | **En cours** 🚀 |
| Authentification     | **À venir**     |
| Autres Use Cases     | **À venir**     |
| Tests                | **À venir**     |
| Déploiement          | **À venir**     |

---

# 🏁 Statut actuel

**Smart Auto-École est en phase de développement fonctionnel. 🚀**

Le premier module métier, **Gérer les candidats (UC03)**, est en cours de réalisation avec la **liste et la création des candidats déjà fonctionnelles**.
