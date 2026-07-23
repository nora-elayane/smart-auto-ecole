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
