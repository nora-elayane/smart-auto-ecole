# 📒 Journal du Projet

## Jour 1 - Initialisation

### Réalisations

- Définition de l'idée du projet **Smart Auto-Ecole**.
- Analyse des besoins fonctionnels.
- Choix de l'architecture **MVC**.
- Choix des technologies : PHP, MySQL, HTML, CSS et JavaScript.
- Création du dépôt GitHub.
- Initialisation de la structure du projet.
- Création de la documentation.

---

## Jour 2 - Analyse & Conception

### Réalisations

- Rédaction du Cahier des Charges.
- Création des Use Cases.
- Conception du Modèle Conceptuel de Données (MCD).
- Validation des entités, des attributs et des cardinalités.
- Conception du Modèle Logique de Données (MLD).
- Rédaction des Dépendances Fonctionnelles.
- Création du Dictionnaire des Données.
- Conception du diagramme EER avec MySQL Workbench.
- Génération de la base de données MySQL (Forward Engineering).
- Validation de la structure finale de la base de données.

### Décisions importantes

- Une seule table **Utilisateur** associée à une table **Role**.
- Le **Contrat** est l'entité centrale du système.
- Un candidat peut posséder plusieurs contrats.
- Un contrat peut recevoir plusieurs paiements.
- Les séances sont gérées via la table **Participation**.
- Les examens utilisent l'attribut **numero_tentative**.
- Les types et états sont gérés avec des **ENUM**.
- Une séance de type **Code** peut ne pas être associée à un véhicule.

---

# ✅ État du projet

- [x] Cahier des Charges
- [x] Use Cases
- [x] MCD
- [x] MLD
- [x] Dépendances Fonctionnelles
- [x] Dictionnaire des Données
- [x] Diagramme EER
- [x] Base de données MySQL

---

# 🎯 Prochaine étape

- Concevoir les maquettes (UI/UX).
- Définir les interfaces principales.
- Préparer l'architecture MVC.
- Initialiser le développement de l'application.

---

# 📈 Avancement

**Analyse & Conception : 100 %** ✅

Le projet est prêt à entrer dans la phase de développement.

ها هو التوثيق المضاف لـ Journal du Projet الخاص بـ اليوم الثالث (Jour 3) بنفس الأسلوب والدقة باش تضيفيه لـ Journal ديالك:

Jour 3 - Configuration & Développement de Base
Réalisations

Configuration du serveur Apache & Linux :

Résolution des problèmes d'accès (404 et 403 Forbidden) via la création d'un lien symbolique (symlink) vers /var/www/html/ et la configuration des permissions (chmod 755).

Intégration de l'interface UI (Layouts modularisés) :

Découpage du template en composants PHP réutilisables (header.php, sidebar.php, footer.php).

Création de la feuille de style globale style.css en Pure CSS (Flexbox & CSS Grid) sans frameworks externes.

Intégration des icônes SVG natives et responsive design pour desktop et mobile.

Mise en place de l'Architecture MVC & Front Controller :

Création du point d'entrée unique public/index.php avec gestion de l'affichage des erreurs et système de routage de base (URI parsing).

Création du contrôleur principal HomeController.php.

Intégration de la vue principale dashboard.php (Cartes de statistiques et tableau récapitulatif des séances).

Décisions importantes

Développement Full Vanilla : Utilisation exclusive de HTML5, Vanilla CSS et Vanilla JS pour une performance maximale et une totale maîtrise du code.

Structure du Routing : Redirection de toutes les requêtes vers public/index.php (Front Controller Pattern).

Découpage strict des vues : Isolation complète des composants de mise en page dans le dossier app/Views/layouts/.

✅ État du projet

Cahier des Charges

Use Cases

MCD

MLD

Dépendances Fonctionnelles

Dictionnaire des Données

Diagramme EER

Base de données MySQL

Maquettes UI / Layouts Base

Architecture MVC & Front Controller

Tableau de bord (Interface)

🎯 Prochaine étape

Créer le modèle Student.php et connecter l'application à la base de données.

Initialiser le développement du module CRUD des Candidats (Liste, Ajout, Modification, Suppression).

Implémenter la logique métier pour l'affichage dynamique des statistiques du Dashboard.

📈 Avancement

Analyse & Conception : 100 % ✅

Architecture & Layouts UI : 100 % ✅

Développement des fonctionnalités (CRUDs) : En cours 🚀
