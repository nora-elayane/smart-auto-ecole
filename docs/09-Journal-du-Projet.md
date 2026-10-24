# 📒 Journal du Projet — Smart Auto-École

---

# 📅 Jour 1 — Initialisation

## Réalisations

- Définition de l'idée et des objectifs de **Smart Auto-École**.
- Analyse des besoins fonctionnels.
- Identification des principaux acteurs :
  - Directeur
  - Secrétaire
  - Moniteur
  - Candidat

- Choix de l'architecture **MVC**.
- Choix des technologies : **PHP, MySQL, HTML5, CSS3 et JavaScript**.
- Création du dépôt GitHub et de la structure initiale du projet.
- Mise en place de la documentation.

---

# 📅 Jour 2 — Analyse & Conception

## Réalisations

- Rédaction du **Cahier des Charges**.
- Création des **Use Cases**.
- Conception du **MCD** et du **MLD**.
- Définition des entités, relations et cardinalités.
- Rédaction des **Dépendances Fonctionnelles**.
- Création du **Dictionnaire des Données**.
- Conception du diagramme **EER** avec MySQL Workbench.
- Génération et validation de la base de données MySQL.

## Décisions importantes

- Une table **Utilisateur** liée à **Role** pour les différents profils.
- Le **Contrat** comme élément central de la gestion des candidats.
- Plusieurs contrats possibles pour un candidat.
- Plusieurs paiements possibles pour un contrat.
- Gestion des séances via **Participation**.
- Gestion des tentatives d'examen avec `numero_tentative`.
- Utilisation des `ENUM` pour certains types et états.
- Une séance **Code** peut être réalisée sans véhicule.

---

# 📅 Jour 3 — Architecture & Interface

## Réalisations

- Configuration du serveur **Apache/Linux**.
- Résolution des erreurs **404** et **403**.
- Mise en place du lien symbolique vers `/var/www/html/`.
- Configuration des permissions Linux.
- Création des layouts réutilisables :
  - `header.php`
  - `sidebar.php`
  - `footer.php`

- Création du `style.css` en **Pure CSS**.
- Utilisation de **Flexbox**, **CSS Grid** et SVG.
- Mise en place du responsive design.
- Création du **Front Controller** `public/index.php`.
- Mise en place du routing de base.
- Création de `HomeController.php`.
- Création du **Dashboard**.

## Use Cases concernés

- **UC02 — Gérer les utilisateurs**
- **UC03 — Gérer les candidats**
- **UC09 — Consulter le planning**
- **UC13 — Consulter les statistiques**

> Les interfaces sont préparées, tandis que les fonctionnalités métier sont développées progressivement.

---

# 📅 Jour 4 — Base de Données & Liste des Candidats

## Réalisations

- Création du modèle `Students.php`.
- Connexion aux données avec **PDO**.
- Création des méthodes `getAll()` et `getTotalStudents()`.
- Filtrage des utilisateurs ayant le rôle **Candidat** (`id_role = 3`).
- Connexion du Dashboard aux données réelles.
- Affichage dynamique du nombre de candidats.
- Création de `StudentController.php`.
- Création de la vue `students/index.php`.
- Ajout de la route `/candidates`.

## Routing & Interface

- Mise en place de `public/.htaccess`.
- Activation de `mod_rewrite`.
- Configuration de `AllowOverride All`.
- Mise en place des **Clean URLs**.
- Gestion dynamique de la classe `active` dans le Sidebar.

## Use Case concerné

- **UC03 — Gérer les candidats** : consultation et affichage de la liste.

---

# 📅 Jour 5 — Création des Utilisateurs & Candidats

## Réalisations

### ➕ Création

- Liaison du bouton **Ajouter un candidat** avec la route dédiée.
- Ajout de la méthode de traitement dans `StudentsController`.
- Création de la requête d'insertion dans `Students.php`.
- Attribution automatique du rôle **Candidat**.
- Mise en place du formulaire de création.

### 🔄 Centralisation

- Remplacement des formulaires spécifiques par un **formulaire unique pour les utilisateurs**.
- Transmission dynamique du rôle via un champ `hidden`.
- Suppression de la vue spécifique `create.php` après centralisation.

### 🛣️ Routing & Corrections

- Ajout de la route `storeStudent`.
- Résolution de l'erreur **404** lors de la soumission du formulaire.
- Correction de la structure HTML du tableau des candidats.
- Correction des chemins d'accès aux photos de profil.

### 📁 Stockage

- Séparation entre :
  - ressources publiques → photos de profil ;
  - stockage sécurisé → documents confidentiels comme les contrats PDF.

## Use Cases concernés

- **UC02 — Gérer les utilisateurs**
- **UC03 — Gérer les candidats**

La fonctionnalité de **création d'un candidat** est maintenant opérationnelle.

---

# 📅 Jour 6 — Modification & Sécurisation des Candidats

## 🎯 Objectif

Finaliser la fonctionnalité de modification des candidats (**UC03**) avec une gestion sécurisée des données et des photos de profil.

## ✅ Réalisations

### ✏️ Modification d'un candidat

- Création et intégration de l'interface d'édition d'un candidat.
- Mise en place du traitement de modification dans le contrôleur et le modèle.
- Récupération et affichage des informations existantes du candidat.
- Mise à jour sécurisée des données en base avec **PDO**.

### 🔐 Sécurité du compte

- Gestion sécurisée du mot de passe lors de la modification.
- Conservation de l'ancien mot de passe lorsqu'aucun nouveau mot de passe n'est fourni.
- Mise à jour du mot de passe uniquement lorsqu'une nouvelle valeur est renseignée.

### 📷 Gestion des photos

- Ajout de l'upload d'une nouvelle photo.
- Ajout d'un **preview JavaScript** avant l'enregistrement.
- Suppression automatique de l'ancienne photo avec `unlink` lors de son remplacement.
- Gestion du chemin de stockage des photos de profil.

## 🧠 Décisions importantes

- Ne jamais écraser le mot de passe existant sans nouvelle valeur.
- Supprimer l'ancienne photo uniquement lorsqu'une nouvelle photo est correctement enregistrée.
- Conserver les requêtes préparées **PDO** pour les opérations de modification.

## 🎯 Use Case concerné

- **UC03 — Gérer les candidats** : consultation, création et modification.

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

- [x] Implémentation de l'**archivage (Soft Delete)** des candidats.
- [x] Implémentation de l'**activation** des candidats archivés.
- [x] Finalisation de la **suppression définitive** des candidats.
- [x] Ajout de **Flash Messages / Toast Notifications** dynamiques.
- [x] Notifications pour les actions :
  - Création
  - Modification
  - Archivage
  - Activation
  - Suppression définitive

- [x] Création d'une feuille de style dédiée `public/css/toast.css`.
- [x] Intégration des Toast Notifications dans l'interface.
- [x] Ajout d'une fermeture automatique des notifications.
- [x] Implémentation d'un effet **auto-fade** en JavaScript.
- [x] Amélioration du feedback utilisateur après chaque opération.

## 🧠 Décisions importantes

- Utiliser le **Soft Delete** afin de conserver les données du candidat tout en permettant son archivage.
- Permettre la réactivation d'un candidat archivé.
- Réserver la suppression définitive aux actions nécessitant réellement la suppression des données.
- Centraliser l'affichage des notifications pour garder une interface cohérente.
- Séparer le style des Toasts dans un fichier CSS dédié.
- Utiliser JavaScript pour gérer le comportement dynamique et la disparition automatique des notifications.

## 🎯 Use Cases concernés

### UC03 — Gestion des candidats

- Création
- Consultation
- Modification
- Archivage
- Activation
- Suppression définitive

## 📌 État

Le module **Gestion des candidats (UC03)** est maintenant fonctionnel pour les principales opérations CRUD, avec archivage, activation, suppression définitive et système de notifications intégré.

La validation complète des formulaires reste à renforcer avant de considérer le module comme totalement finalisé.

# 📅 Jour 8 — Analyse, Benchmark & Redesign UX / Architecture du Module Contrats

## 🎯 Objectif

Analyser le fonctionnement du module Contrats et redéfinir son organisation afin d'améliorer l'expérience utilisateur et de préparer son intégration avec les autres modules métier.

## ✅ Réalisations

- **Étude concurrentielle & Analyse SWOT :**
  - Analyse des solutions existantes.
  - Identification des points forts et faibles.
  - Recherche d'une expérience utilisateur plus fluide et intuitive.

- **Architecture Single Source of Truth (SSOT) :**
  - Centralisation de l'accès aux contrats depuis la gestion des candidats.
  - Réduction de la duplication des informations.

- **Fiche Candidat :**
  - Affichage des informations personnelles.
  - Affichage de l'historique des contrats.
  - Ajout d'un contrat directement depuis la fiche candidat.

- **Tableau des Contrats :**
  - Ajout d'un menu d'actions :
    - Éditer
    - Supprimer
    - Imprimer Contrat
    - Imprimer Attestation
    - Imprimer Carte Candidat

  - Ajout d'un bouton **Consulter**.

- **Page de détails du Contrat :**
  - Création d'une vue dédiée.
  - Organisation par onglets :
    - Paiements
    - Séances
    - Examens

## 🎯 Use Cases concernés

- **UC03 — Gestion des candidats**
- **UC06 — Gestion des contrats**
- Préparation de **UC07 — Gestion des paiements**
- Préparation de **UC08 — Planification des séances**
- Préparation de **UC11 — Planification des examens**

## 📌 État

La conception UX et l'organisation du module Contrats sont définies. La structure permet également de préparer l'intégration future des paiements, séances et examens.

# 📅 Jour 9 — Implémentation Technique & Module Contrats

## 🎯 Objectif

Implémenter le module Contrats dans l'architecture MVC et permettre la création et l'affichage des contrats associés aux candidats.

## ✅ Réalisations

- **Architecture MVC :**
  - Création du `ContratController`.
  - Création du modèle `Contrat`.
  - Création des vues :
    - `students/show.php`
    - `contrats/create.php`

- **Fiche Candidat & Contrats :**
  - Affichage des informations du candidat.
  - Affichage des contrats associés.
  - Utilisation d'une jointure SQL `LEFT JOIN categorie`.
  - Récupération de la catégorie du permis avec les détails du contrat.
  - Utilisation de `PDO::fetchAll()`.

- **Gestion dynamique :**
  - Récupération de l'ID candidat via `$_GET['id']`.
  - Affichage dynamique des informations correspondant au candidat sélectionné.

- **Création d'un Contrat :**
  - Création du formulaire de souscription.
  - Transmission de l'ID candidat via un `hidden input`.
  - Traitement du formulaire en `POST`.
  - Utilisation de requêtes préparées PDO.
  - Validation des données côté serveur.
  - Redirection dynamique après traitement.

## 🎯 Use Cases concernés

- **UC03 — Gestion des candidats**
- **UC06 — Gestion des contrats**

## 📌 État

La création et l'affichage des contrats associés aux candidats sont maintenant fonctionnels. Le module est intégré à l'architecture MVC et utilise des requêtes préparées avec validation côté serveur.

# 📅 Jour 10 — Finalisation du module Contrats

## 🎯 Objectif

Finaliser le module **Gestion des Contrats (UC06)** en ajoutant les opérations de modification et de suppression, tout en améliorant les validations et les retours utilisateur.

## ✅ Réalisations

- ✏️ Implémentation de la **modification des contrats**
- 🗑️ Implémentation de la **suppression des contrats**
- 🔔 Ajout des **Toast Notifications** pour les actions sur les contrats
- 🛡️ Renforcement de la **validation des données du formulaire**
- 🧪 Test des opérations principales du **CRUD des contrats**
- 🔗 Vérification de la relation **Contrat ↔ Candidat**
- ✅ Vérification du bon fonctionnement des redirections et des actions après chaque opération

## 🧠 Décisions importantes

- Utilisation des requêtes **PDO préparées** pour sécuriser les opérations SQL.
- Conservation d'une relation cohérente entre les **candidats et leurs contrats**.
- Utilisation des **Toast Notifications** pour informer clairement l'utilisateur du résultat de chaque action.
- Centralisation des opérations du module Contrats à travers l'architecture **MVC**.

## 🎯 Use Cases concernés

- **UC06 — Gérer les contrats**
  - Création
  - Consultation
  - Modification
  - Suppression

- Préparation des fonctionnalités liées à :
  - **UC07 — Gérer les paiements**
  - **UC08 — Planifier les séances**
  - **UC11 — Planifier les examens**

## 📌 État

🟢 **UC06 — Gestion des contrats : 80%**

Le module permet maintenant de **créer, consulter, modifier et supprimer les contrats**, avec validation des données et notifications utilisateur.

# 📅 Jour 11 — Impression des documents & amélioration de l'interface

## 🎯 Objectif

Implémenter les premiers documents administratifs imprimables liés aux **contrats et aux candidats**, puis améliorer l'interface existante et corriger certains problèmes d'utilisation.

## ✅ Réalisations

### 📄 Impression des documents

- 📝 Implémentation du template PDF du **Contrat d'Apprentissage**
- 🪪 Implémentation du template PDF de la **Carte Candidat**
- 🏫 Ajout de la table **`schools`**
- 🔢 Ajout de la colonne **`num_enregistrement`** dans la table des contrats
- 🔗 Mise à jour du modèle **Contract** pour récupérer les informations de l'auto-école avec les données du candidat et du véhicule
- 🛣️ Ajout des routes dédiées à l'impression
- 🎮 Ajout des actions correspondantes dans le **ContratController**
- 🌐 Création des templates HTML/CSS bilingues :
  - `contrat_print.php`
  - `fiche_candidat_print.php`

- 📷 Correction du chemin de stockage des photos candidats :
  `/smart-auto-ecole/public/uploads/`
- 🖨️ Ajout des options d'impression dans le profil candidat via un menu déroulant
- 🎨 Ajustement du positionnement et de l'overflow du menu d'impression

### 🎨 Amélioration de l'interface

- 🔧 Amélioration du **Sidebar**
- 📊 Amélioration de l'affichage des **tableaux**
- 🐛 Correction de plusieurs bugs d'interface et de navigation
- ↩️ Correction du comportement du bouton **Retour** pour permettre de revenir correctement à la page précédente

## 🧠 Décisions importantes

- Séparer les vues d'impression des vues classiques de l'application afin d'obtenir des documents adaptés à l'impression.
- Centraliser les informations de l'auto-école dans la base de données afin de les réutiliser dans les documents administratifs.
- Conserver les templates d'impression en **HTML/CSS bilingue** pour faciliter leur adaptation et leur maintenance.
- Améliorer progressivement l'interface avant de poursuivre avec les prochains modules fonctionnels.

## 🎯 Use Cases concernés

- **UC03 — Gérer les candidats**
- **UC06 — Gérer les contrats**
- Préparation des fonctionnalités administratives liées aux documents.

## 📌 État

🟢 **UC06 — Gestion des contrats : 85%**

La création, consultation, modification, suppression et une partie de l'impression des documents liés aux contrats sont maintenant fonctionnelles.

# 📅 Jour 12 — Finalisation de l'interface & navigation

## 🎯 Objectif

Finaliser les améliorations visuelles de l'interface et corriger les principaux problèmes liés à la navigation, aux tableaux et aux actions utilisateur.

## ✅ Réalisations

### 🎨 Interface & Sidebar

- Réorganisation du **menu latéral (Sidebar)**.
- Amélioration de la structure et de la présentation visuelle du Sidebar.
- Optimisation de l'affichage des différentes sections du menu.

### 📊 Gestion des Tables & Actions

- Correction du comportement des menus déroulants, notamment le **Dropdown Imprimer**.
- Optimisation de la sélection et de l'interaction avec les lignes des tableaux.
- Amélioration de l'affichage et de l'utilisation des actions associées aux tableaux.

### 🧭 Navigation

- Résolution du bug lié au bouton **Retour**.
- Correction des problèmes de **redirection vers les pages précédentes**.
- Amélioration de la navigation entre les différentes pages de l'application.

## 🧠 Décisions importantes

- Uniformiser progressivement les composants d'interface afin de faciliter leur réutilisation dans les prochains modules.
- Corriger les problèmes de navigation avant de commencer le développement de nouveaux modules.
- Conserver une interface simple et cohérente pour les différentes opérations CRUD.

## 🎯 Use Cases concernés

- **UC03 — Gérer les candidats**
- **UC06 — Gérer les contrats**
- Préparation de l'interface pour les prochains modules de gestion.

## 📌 État

🟢 **Interface & Navigation : finalisées pour les modules actuels**

Les principaux problèmes liés au **Sidebar, aux tableaux, aux Dropdowns et à la navigation** ont été corrigés.

# 📅 Jour 13 — Gestion des employés

## 🎯 Objectif

Implémenter le module **Gestion des employés (UC04)** pour permettre la gestion des **Secrétaires et des Moniteurs**, tout en réutilisant la logique commune de gestion des utilisateurs.

## ✅ Réalisations

### 👥 Gestion des employés

- Implémentation du **CRUD complet des employés** :
  - Consultation
  - Création
  - Modification
  - Affichage du profil
  - Suppression

- Ajout de `EmployeController` avec les actions :
  - `index`
  - `create`
  - `store`
  - `edit`
  - `update`
  - `show`
  - `delete`

- Gestion des **rôles** pour les différents types d'employés :
  - Secrétaire
  - Moniteur

### 🔄 Gestion des statuts

- Implémentation de la gestion des statuts :
  - **Actif**
  - **Archivé**

- Possibilité d'archiver et de réactiver les employés.

### 📷 Gestion des photos

- Mise en place de l'upload sécurisé des **photos de profil**.
- Gestion du remplacement des anciennes photos lors de la modification.

### 🛠️ Correction & amélioration du modèle

- Correction de la requête `updateEmploye` dans le modèle **Employe**.
- Correction de la mise à jour de `id_role` en l'intégrant correctement dans la clause `SET`.

### 🔔 Feedback utilisateur

- Intégration des **Flash Messages** pour informer l'utilisateur du résultat des différentes opérations.
- Liaison des actions CRUD avec les différentes vues du module Employés.

## 🧠 Décisions importantes

- Réutilisation de la logique commune déjà développée pour les utilisateurs et les candidats.
- Centralisation de la gestion des rôles afin de maintenir une structure cohérente.
- Utilisation du système d'archivage pour éviter la suppression directe des employés actifs.
- Conservation d'une gestion sécurisée des photos de profil.

## 🎯 Use Cases concernés

- **UC04 — Gérer les employés**
  - Secrétaires
  - Moniteurs
  - Création
  - Consultation
  - Modification
  - Archivage / activation
  - Suppression

## 📌 État

🟢 **UC04 — Gestion des employés : 85%**

Le module **Gestion des employés** dispose maintenant d'un CRUD complet avec gestion des rôles, des statuts, des photos et des notifications utilisateur.

# 📅 Jour 14 — Gestion des véhicules

## 🎯 Objectif

Implémenter le module **Gestion des véhicules (UC05)** avec un CRUD complet, une interface cohérente avec les autres modules et une gestion correcte des erreurs et validations.

## ✅ Réalisations

### 🚗 Gestion des véhicules

- Implémentation de l'affichage de la **liste des véhicules**.
- Création du formulaire d'**ajout d'un véhicule**.
- Création du formulaire de **modification d'un véhicule**.
- Implémentation de la **suppression des véhicules**.
- Gestion du **statut / état du véhicule**.
- Ajout des validations nécessaires aux formulaires.
- Mise en place des **Toast Notifications** pour améliorer le feedback utilisateur.

### 🎨 Interface & UX

- Uniformisation de la vue `index` avec le style déjà utilisé dans la gestion des candidats.
- Ajout d'une **barre d'actions flottante**.
- Utilisation de **badges** pour l'affichage des états.
- Amélioration de la présentation générale des informations.

### 📝 Formulaires

- Création de formulaires structurés avec une **mise en page en grille**.
- Ajout d'une **validation côté client avec JavaScript**.
- Amélioration de l'expérience utilisateur lors de la saisie des données.

### 🛣️ Routing & Backend

- Ajout des routes du module **Véhicules** dans le routeur principal.

- Gestion et amélioration du traitement des erreurs PDO.

- Correction de l'exception :

  `Data truncated for column 'etat'`

- Alignement des valeurs utilisées avec les options **ENUM** définies dans la base de données.

## 🧠 Décisions importantes

- Réutilisation du style d'interface déjà établi dans le module **Candidats** afin de conserver une cohérence visuelle.
- Utilisation des validations **côté client et côté serveur** pour renforcer la fiabilité des données.
- Alignement strict entre les valeurs de l'application et les valeurs **ENUM** de la base de données.
- Centralisation des routes du module dans le routeur principal.

## 🎯 Use Cases concernés

- **UC05 — Gérer les véhicules**
  - Consulter
  - Ajouter
  - Modifier
  - Supprimer
  - Gérer l'état du véhicule

## 📌 État

🟢 **UC05 — Gestion des véhicules : 85%**

Le module dispose maintenant d'un **CRUD fonctionnel**, avec des vues dédiées, des formulaires validés, une gestion des états, des notifications utilisateur et une gestion améliorée des erreurs.

# 📅 Jour 15 — Unification du routing des contrats & préparation du refactoring

## 🎯 Objectif

Finaliser et uniformiser le système de routing du module **Contrats**, améliorer la gestion du contexte de navigation et préparer une architecture de routing plus propre et maintenable pour l'ensemble de l'application.

## ✅ Réalisations

### 🛣️ Standardisation du routing

- Uniformisation de toutes les routes du module Contrats sous :
  - `/contrats/create`
  - `/contrats/edit`
  - `/contrats/update`
  - `/contrats/delete`
  - `/contrats/show`

### 🔄 Gestion du contexte de navigation

- Ajout de la gestion du paramètre `from` dans les **Views** et les **Controllers**.
- Adaptation dynamique des redirections selon la page d'origine.
- Correction du comportement du bouton **Annuler**.
- Correction des redirections après soumission des formulaires.
- Gestion des retours contextuels vers :
  - `candidates/show`
  - `contrats/index`

### 📝 Formulaire de création

- Affichage dynamique de la sélection du candidat selon le contexte.
- Utilisation d'un champ caché lorsque le candidat est déjà défini depuis sa fiche.
- Correction de l'ordre des paramètres lors de l'appel à `Contrat::createContrat()` dans `ContratController`.

## 🧠 Décisions importantes

- Centraliser progressivement les routes du module Contrats sous `/contrats/*`.
- Conserver le contexte de navigation afin d'éviter les redirections incorrectes.
- Préparer une architecture de routing commune pour les prochains modules.
- Réduire progressivement les URLs et redirections écrites manuellement dans les Controllers et les Views.

## 🎯 Use Cases concernés

- **UC06 — Gérer les contrats**
- **UC03 — Gérer les candidats**
- Préparation de l'architecture technique pour les prochains modules.

## 📌 État

🟢 **UC06 — Gestion des contrats : 90%**

Le routing du module Contrats est maintenant uniformisé et les redirections sont adaptées au contexte de navigation.

# 📅 Jour 16 — Audit de l’architecture et préparation du refactoring

## 🎯 Objectif

Analyser l’architecture existante du routing afin de préparer sa centralisation et d’améliorer la maintenabilité du projet.

## ✅ Réalisations

- Réalisation d’un audit de l’architecture actuelle.
- Analyse des routes et des relations entre les différents modules.
- Étude de la navigation entre les candidats, les contrats et les autres fonctionnalités.
- Identification des améliorations nécessaires pour centraliser les URLs et simplifier le Router.
- Préparation de la nouvelle organisation du routing.

## 🧠 Décisions importantes

- Centraliser progressivement la gestion des URLs.
- Uniformiser les conventions de nommage des routes et des actions CRUD.
- Réduire la dépendance aux URLs écrites manuellement dans les Views et les Controllers.
- Préparer une architecture extensible pour les prochains modules.

## 🎯 Use Cases concernés

- UC03 — Gestion des candidats
- UC04 — Gestion des employés
- UC05 — Gestion des véhicules
- UC06 — Gestion des contrats

## 📌 État

L’audit de l’architecture est terminé. Les améliorations à apporter au système de routing ont été identifiées afin de préparer leur implémentation au Jour 17.

---

# 📅 Jour 17 — Centralisation du routing et gestion des exceptions

## 🎯 Objectif

Refactoriser le système de routing, uniformiser les actions CRUD et renforcer la gestion des erreurs dans l’application.

## ✅ Réalisations

- Standardisation des méthodes des Controllers : `index()`, `create()`, `store()`, `edit()`, `update()` et `delete()`.
- Nettoyage des anciennes routes devenues inutiles.
- Mise à jour de la table de dispatch dans `public/index.php`.
- Uniformisation des sessions Flash et des helpers de redirection.
- Mise à jour des Views et des formulaires pour respecter la nouvelle structure du routing centralisé.
- Mise en place d’une gestion sécurisée des exceptions avec `try/catch`.
- Gestion des exceptions PDO avec journalisation des erreurs via `error_log()`.

## 🧠 Décisions importantes

- Adopter des conventions communes pour les actions CRUD.
- Centraliser la définition et la distribution des routes.
- Séparer les messages destinés à l’utilisateur des détails techniques des erreurs.
- Améliorer la traçabilité des erreurs sans exposer les informations sensibles à l’interface.

## 🎯 Use Cases concernés

- UC03 — Gestion des candidats
- UC04 — Gestion des employés
- UC05 — Gestion des véhicules
- UC06 — Gestion des contrats

## 📌 État

Le routing a été refactorisé et les actions CRUD harmonisées. La gestion des exceptions, des redirections et des notifications Flash a également été améliorée.

**Commit :** `refactor: centralize routing, standardize CRUD actions and enhance exception handling`

---

# 📅 Jour 18 — Authentification, autorisations RBAC et interface responsive

## 🎯 Objectif

Mettre en place un système complet d’authentification et de contrôle d’accès basé sur les rôles, tout en adaptant l’interface aux tablettes.

## ✅ Réalisations

- Implémentation du système d’authentification.
- Mise en place des contrôles d’autorisation basés sur les rôles (RBAC).
- Ajout de protections pour contrôler l’accès aux fonctionnalités selon les permissions.
- Filtrage dynamique de la Sidebar en fonction du rôle de l’utilisateur connecté.
- Adaptation de l’interface pour améliorer l’affichage sur tablette.
- Amélioration de la cohérence entre les autorisations et les éléments de navigation affichés.

## 🧠 Décisions importantes

- Contrôler les autorisations côté serveur, et pas uniquement au niveau de l’interface.
- Adapter les éléments de navigation aux rôles des utilisateurs.
- Préserver une expérience responsive sur les écrans de taille intermédiaire.

## 🎯 Use Cases concernés

- UC01 — Authentification
- UC02 — Gestion des utilisateurs
- UC14 — Gestion du profil personnel
- UC15 — Déconnexion

## 📌 État

L’authentification, les contrôles d’accès RBAC, le filtrage de la Sidebar et l’adaptation responsive pour tablette ont été implémentés.

**Commit :** `feat(auth): implement complete authentication, RBAC authorization guards, UI sidebar filtering, and responsive tablet layout`

---

# 📅 Jour 19 — Détails des contrats et gestion des paiements (UC07)

## 🎯 Objectif

Développer la consultation détaillée des contrats et intégrer le suivi financier ainsi que l’enregistrement et l’impression des paiements.

## ✅ Réalisations

### 1. Détails du contrat

- Création d’une vue détaillée du contrat.
- Affichage des informations générales du contrat.
- Affichage du numéro d’enregistrement `num_enregistrement`.
- Ajout d’une navigation dynamique pour retourner à la page précédente selon le contexte.

### 2. Suivi financier

- Affichage dynamique du montant total payé.
- Calcul et affichage du solde restant à payer.
- Affichage du statut financier du contrat.
- Ajout d’une barre de progression représentant l’état des paiements.

### 3. Gestion des paiements

- Création du modèle `Payment`.
- Création du contrôleur `PaymentController`.
- Implémentation de l’enregistrement des paiements associés aux contrats.
- Ajout de boutons d’action pour imprimer, modifier et supprimer les paiements individuels.

### 4. Impression des reçus

- Création du modèle d’impression `recu_paiement.php`.
- Mise en place d’un reçu de paiement imprimable.
- Intégration du logo dans le document.
- Préparation d’une présentation adaptée à l’impression.

## 🧠 Décisions importantes

- Associer les paiements au contrat concerné afin de conserver un suivi financier cohérent.
- Présenter les indicateurs financiers directement dans la fiche détaillée du contrat.
- Permettre l’impression d’un reçu pour justifier un paiement.
- Préserver une navigation cohérente entre la fiche candidat, les contrats et leurs détails.

## 🎯 Use Cases concernés

- UC06 — Gestion des contrats
- UC07 — Enregistrement et gestion des paiements
- UC03 — Gestion des candidats, pour la navigation contextuelle

## 📌 État

La consultation détaillée des contrats, le suivi des montants payés et du solde restant, ainsi que l’enregistrement et l’impression des reçus de paiement ont été implémentés.

Les fonctionnalités de modification et de suppression des paiements disposent également de boutons d’action. Leur validation complète devra être confirmée par des tests fonctionnels.

**Commit :** `feat(contrats): implement contract details view with payment tracking and receipt printing (UC07)`

---

# 🎯 Prochaine étape — Jour 20

## 📋 Finalisation et sécurisation du module Paiements

- [ ] Tester l’enregistrement des paiements et les validations côté serveur.
- [ ] Vérifier le calcul du montant total payé et du solde restant.
- [ ] Vérifier la cohérence du statut financier après chaque opération.
- [ ] Tester la modification et la suppression des paiements.
- [ ] Vérifier les notifications Flash et les redirections.
- [ ] Contrôler la présentation et les informations du reçu imprimable.
- [ ] Vérifier les cas limites : paiement nul, montant négatif, montant supérieur au solde restant et contrat sans paiement.
- [ ] Vérifier les autorisations d’accès aux paiements selon les rôles.

**Objectif :** fiabiliser le module UC07 avant de poursuivre avec la planification des séances de conduite.

---

# 📊 Progression actuelle

| Partie                           |                                     État |
| -------------------------------- | ---------------------------------------: |
| Analyse & Conception             |                                 🟢 100 % |
| Architecture & Interface         |                                 🟢 100 % |
| Base de données                  |                                 🟢 100 % |
| Dashboard                        |                                 🟢 100 % |
| UC01 — Authentification          |                           🟢 Implémentée |
| UC02 — Gestion des utilisateurs  |                            🟡 À vérifier |
| UC03 — Candidats                 |                                  🟢 90 % |
| UC04 — Employés                  |                                  🟢 85 % |
| UC05 — Véhicules                 |                                  🟢 85 % |
| UC06 — Contrats                  |                                  🟢 95 % |
| UC07 — Paiements                 | 🟡 Implémentation en cours de validation |
| UC08 — Planification des séances |                               🔴 À venir |
| UC09 — Consultation du planning  |                               🔴 À venir |
| UC10 — Validation des séances    |                               🔴 À venir |
| UC11 — Planification des examens |                               🔴 À venir |
| UC12 — Consultation des examens  |                               🔴 À venir |
| UC13 — Statistiques              |                               🔴 À venir |
| UC14 — Profil personnel          |                            🟡 À vérifier |
| UC15 — Déconnexion               |                            🟡 À vérifier |
| Tests & Déploiement              |                               🔴 À venir |

> **État actuel :** après la centralisation du routing et l’intégration de l’authentification avec contrôle d’accès RBAC, le projet dispose désormais d’une base plus structurée et sécurisée. Le module Contrats a été enrichi par une fiche détaillée intégrant le suivi financier et les reçus de paiement. La prochaine étape consiste à valider la fiabilité du module Paiements avant d’entamer la gestion des séances et du planning.
